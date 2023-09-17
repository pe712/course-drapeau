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

    id = models.AutoField(primary_key=True)
    sections = models.ManyToManyField(
        Section, verbose_name='tronçons', blank=True)

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
        User, on_delete=models.CASCADE, primary_key=True)
    group = models.ForeignKey(
        Group, on_delete=models.CASCADE, related_name='runners', null=True, blank=True)
    progress = models.FloatField(default=0.0, verbose_name='avancement')
    medical_certificate = models.FileField(
        upload_to='certificates/', verbose_name='certificat médical', null=True, blank=True)

    def save_group(self, runner):
        if not hasattr(runner, 'group'):
            return True
        if not runner.group:
            group = Group()
            runner.group = group
            runner.save()
            self.group = group
            self.save()
            return True
        else:
            group = runner.group
            if group.runners.count() >= 3:
                return False
            else:
                self.group = group
                self.save()
                return True


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
