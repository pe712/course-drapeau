from django.db import models
from django.contrib.auth.models import User


class Section(models.Model):
    id = models.IntegerField(primary_key=True)
    gpx = models.FileField(upload_to='gpx/', verbose_name='fichier GPX')

    def __str__(self):
        return f"Tronçon {self.id}"


class Group(models.Model):
    id = models.IntegerField(primary_key=True)
    sections = models.ManyToManyField(Section, verbose_name='tronçons')

    def __str__(self):
        return f"Groupe {self.id}"


class Runner(models.Model):
    user = models.OneToOneField(User, on_delete=models.CASCADE)
    group = models.ForeignKey(
        Group, on_delete=models.CASCADE, related_name='runners', null=True)
    progress = models.FloatField(default=0.0, verbose_name='avancement')
    
    def __str__(self):
        return self.user.username
