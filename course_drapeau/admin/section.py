from django.contrib import admin
from django import forms
from course_drapeau.models import Route, Section


@admin.register(Section)
class SectionAdmin(admin.ModelAdmin):
    fields = (
        'gpx',
        'datetime_start',
        'datetime_stop',
        'start_latitude',
        'start_longitude',
        'stop_latitude',
        'stop_longitude',
        'full'
    )

    readonly_fields = (
        'start_latitude',
        'start_longitude',
        'stop_latitude',
        'stop_longitude'
    )


class SectionInline(admin.TabularInline):
    model = Section
    fields = (
        'gpx',
        'full',
    )


@admin.register(Route)
class RouteAdmin(admin.ModelAdmin):
    inlines = [SectionInline,]

    def save_model(self, request, obj, form, change):
        super().save_model(request, obj, form, change)

        for file in request.FILES.getlist('multiple_section'):
            section = Section.objects.create(gpx=file, full=False)
