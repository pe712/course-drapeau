from django.contrib import admin
from course_drapeau.models import Section


@admin.register(Section)
class SectionAdmin(admin.ModelAdmin):
    pass
