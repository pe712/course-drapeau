from django.contrib import admin
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
        'full',
        'get_group',
    )

    readonly_fields = (
        'start_latitude',
        'start_longitude',
        'stop_latitude',
        'stop_longitude',
        'get_group',
    )

    @admin.display(description='Groupe')
    def get_group(self, obj):
        """
        group is a ManyToManyField, it cannot be displayed easily.
        Returns the group associated to this section if any.
        """
        return obj.group.all().first()


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
