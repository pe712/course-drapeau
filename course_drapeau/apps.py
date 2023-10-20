from django.apps import AppConfig


class CourseDrapeauConfig(AppConfig):
    default_auto_field = 'django.db.models.BigAutoField'
    name = 'course_drapeau'

    def ready(self):
        from . import receivers