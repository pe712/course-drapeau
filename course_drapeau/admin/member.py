from django.contrib import admin
from course_drapeau.admin.forms.runner import RunnerAdminForm
from course_drapeau.models import Runner, Driver

from django.contrib import admin


@admin.register(Runner)
class RunnerAdmin(admin.ModelAdmin):
    form = RunnerAdminForm

    list_display = ('user', 'group',
                    'progress')
    readonly_fields = ('progress',)

    fieldsets = (
        ('Informations personnelles', {
            'fields': ('username', 'first_name',
                       'last_name', 'email',)
        }),
        ('Group', {
            'fields': ('group',),
            'classes': ('collapse',),
        }),
        ('Avancement', {
            'fields': ('progress', 'medical_certificate'),
            'classes': ('collapse',),
        }),
    )

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
