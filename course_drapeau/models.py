from collections.abc import Iterable
from django.db import models
from django.contrib.auth.models import User
from xml.etree import ElementTree as ET


class Section(models.Model):
    class Meta:
        verbose_name = 'Tronçon'

    id = models.AutoField(primary_key=True)
    gpx = models.FileField(upload_to='gpx/', verbose_name='fichier GPX')
    datetime_start = models.DateTimeField(
        null=True, blank=True,
        verbose_name='date et heure de départ'
    )
    datetime_stop = models.DateTimeField(
        null=True,
        blank=True,
        verbose_name='date et heure d\'arrivée'
    )
    start_latitude = models.DecimalField(
        max_digits=9,
        decimal_places=6,
        verbose_name='latitude de départ'
    )
    start_longitude = models.DecimalField(
        max_digits=9,
        decimal_places=6,
        verbose_name='longitude de départ'
    )
    stop_latitude = models.DecimalField(
        max_digits=9,
        decimal_places=6,
        verbose_name='latitude d\'arrivée'
    )
    stop_longitude = models.DecimalField(
        max_digits=9,
        decimal_places=6,
        verbose_name='longitude d\'arrivée'
    )
    full = models.BooleanField(default=False, verbose_name='tronçon complet')
    route = models.ForeignKey(
        'Route', on_delete=models.CASCADE, related_name='sections')

    def save(self, **kwargs):
        self.route = Route.objects.first()
        if not self.start_latitude:
            tree = ET.parse(self.gpx)
            root = tree.getroot()
            ns = {'gpx': 'http://www.topografix.com/GPX/1/1'}
            points = root.find('gpx:trk', namespaces=ns).find(
                'gpx:trkseg', namespaces=ns).findall('gpx:trkpt', namespaces=ns)
            start = points[0]
            stop = points[-1]
            self.start_latitude = start.attrib['lat']
            self.start_longitude = start.attrib['lon']
            self.stop_latitude = stop.attrib['lat']
            self.stop_longitude = stop.attrib['lon']
        return super().save(**kwargs)

    def __str__(self):
        return f"Tronçon {self.id}"


class Group(models.Model):
    class Meta:
        verbose_name = 'Groupe de coureurs'
        verbose_name_plural = 'Groupes de coureurs'

    id = models.IntegerField(primary_key=True, blank=True, null=False)
    name = models.CharField(
        max_length=100,
        null=True,
        blank=True,
        verbose_name='nom d\'équipe'
    )
    sections = models.ManyToManyField(
        Section,
        blank=True,
        related_name='group',
        verbose_name='tronçons',
    )

    def get_member_count(self):
        return self.runners.count()

    def save(self, force_insert=False, force_update=False, using=None, update_fields=None):
        if not self.id:
            available_ids = {group.id for group in Group.objects.all()}
            id = 1
            while id in available_ids:
                id += 1
            self.id = id
        super().save(force_insert, force_update, using, update_fields)

    def __str__(self):
        return f"Groupe {self.id}"


# class Member(models.Model):
#     class Meta:
#         abstract = True
#         verbose_name = 'Participant'

#     user = models.OneToOneField(
#         User, on_delete=models.CASCADE, primary_key=True)

#     def __str__(self):
#         return self.user.username


class Runner(models.Model):
    class Meta:
        verbose_name = 'Coureur'
    user = models.OneToOneField(
        User, on_delete=models.CASCADE, primary_key=True, verbose_name='utilisateur')
    group = models.ForeignKey(
        Group, on_delete=models.CASCADE, related_name='runners', null=True, blank=True, verbose_name='groupe')
    progress = models.FloatField(default=0.0, verbose_name='avancement')
    medical_certificate = models.FileField(
        upload_to='certificates/',
        null=True,
        blank=True,
        verbose_name='certificat médical de moins de 1 an',
    )
    paid = models.BooleanField(default=False, verbose_name='payé')
    vegetarian = models.BooleanField(
        null=True,
        blank=True,
        verbose_name='végétarien',
    )
    license = models.BooleanField(
        null=True,
        blank=True,
        verbose_name='permis de conduire',
    )
    manual_gearbox = models.BooleanField(
        null=True,
        blank=True,
        verbose_name='boîte manuelle',
    )
    young_driver = models.BooleanField(
        null=True,
        blank=True,
        verbose_name='jeune conducteur',
    )

    def save_group(self, runner):
        if not runner:
            # self has not chosen yet
            return True
        group = runner.group
        if not group:
            group = Group.objects.create(name=f'{runner.user}')
            runner.group = group
            runner.save()
        if group.runners.count() >= 3:
            return False
        if self.group and self.group.get_member_count() == 1:
            self.group.delete()
        self.group = group
        self.save()
        return True

    def save(self, force_insert=False, force_update=False, using=None, update_fields=None):
        self.progress = self.compute_progress()
        super().save()

    def compute_progress(self) -> float:
        increase = [
            self.user,
            self.group,
            self.medical_certificate,
            self.paid is not None,
            self.vegetarian is not None,
        ]
        # self.license, self.manual_gearbox and self.young_driver are filled at the same time as self.vegetarian (AdvancedRunnerForm)
        n = len(increase)
        progress = 0.0
        for elmt in increase:
            if elmt:
                progress += 1/n
        return round(progress, 2)

    def __str__(self):
        return self.user.username


class Driver(models.Model):
    class Meta:
        verbose_name = 'Chauffeur'

    user = models.OneToOneField(
        User, on_delete=models.CASCADE, primary_key=True)
    seats = models.IntegerField(default=0, verbose_name='nombre de places')

    def __str__(self):
        return self.user.username


class Information(models.Model):
    class Meta:
        verbose_name = 'Information'

    id = models.AutoField(primary_key=True)
    question = models.CharField(max_length=100, verbose_name='question')
    answer = models.CharField(max_length=100, verbose_name='réponse')


class Route(models.Model):
    """
    Only used to update several sections at once.
    """
    class Meta:
        verbose_name = 'Parcours'
        verbose_name_plural = 'Parcours'

    id = models.AutoField(primary_key=True)
    title = models.CharField(max_length=100, verbose_name='titre')
