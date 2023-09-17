from django.db import models
from django.contrib.auth.models import User


class Section(models.Model):
    class Meta:
        verbose_name = 'Tronçon'

    id = models.AutoField(primary_key=True)
    gpx = models.FileField(upload_to='gpx/', verbose_name='fichier GPX')
    datetime_start = models.DateTimeField(verbose_name='date et heure de départ')
    datetime_stop  = models.DateTimeField(verbose_name='date et heure d\'arrivée')
    start_latitude = models.DecimalField(max_digits=9, decimal_places=6, verbose_name='latitude de départ')
    start_longitude = models.DecimalField(max_digits=9, decimal_places=6, verbose_name='longitude de départ')
    stop_latitude = models.DecimalField(max_digits=9, decimal_places=6, verbose_name='latitude d\'arrivée')
    stop_longitude = models.DecimalField(max_digits=9, decimal_places=6, verbose_name='longitude d\'arrivée')
    full = models.BooleanField(default=False, verbose_name='tronçon complet')

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
    user = models.OneToOneField(User, on_delete=models.CASCADE, primary_key=True)
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

    user = models.OneToOneField(User, on_delete=models.CASCADE, primary_key=True)
    seats = models.IntegerField(default=0, verbose_name='nombre de places')

    def __str__(self):
        return self.user.username

class Information(models.Model):
    class Meta:
        verbose_name = 'Information'
    
    id = models.AutoField(primary_key=True)
    question = models.CharField(max_length=100, verbose_name='question')
    answer = models.CharField(max_length=100, verbose_name='réponse')