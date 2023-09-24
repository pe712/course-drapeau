from django.contrib import admin
from course_drapeau.models import Runner, Driver

from django.contrib import admin

from django.contrib.auth.models import User


@admin.register(Runner)
class RunnerAdmin(admin.ModelAdmin):
    list_display = ('user', 'group',
                    'progress')

    base_fieldsets = (
        ('Informations personnelles', {
            'fields': ('user',
                       'vegetarian',
                       'license',
                       'manual_gearbox',
                       'young_driver'),
        }),
        ('Groupe', {
            'fields': ('group',),
        }),
    )

    def add_view(self, request, form_url="", extra_context=None):
        self.readonly_fields = []
        self.fieldsets = self.base_fieldsets + (
            ('Avancement', {
                'fields': ('medical_certificate',),
            }),
        )
        return super().add_view(request, form_url, extra_context)

    def change_view(self, request, object_id, form_url="", extra_context=None):
        self.readonly_fields = ('progress', 'user')
        self.fieldsets = self.base_fieldsets + (
            ('Avancement', {
                'fields': ('progress', 'medical_certificate',),
            }),
        )
        return super().change_view(request, object_id, form_url, extra_context)

# @admin.register(Driver)


class DriverAdmin(admin.ModelAdmin):
    list_display = ('first_name', 'last_name',
                    'seats')
    readonly_fields = ('username', 'first_name',
                       'last_name', 'email',)

    fieldsets = (
        ('Informations personnelles', {
            'fields': ('username', 'first_name',
                       'last_name', 'email', 'progress',)
        }),
        ('Véhicule', {
            'fields': ('seats',),
        }),
    )
