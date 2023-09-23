from django.contrib import admin
from course_drapeau.models import Group


@admin.register(Group)
class GroupAdmin(admin.ModelAdmin):
    list_display = ('id', 'name', 'member_count')
    filter_horizontal = ('sections',)

    def member_count(self, obj):
        return obj.runners.count()

    member_count.short_description = 'Nombre de coureurs'
