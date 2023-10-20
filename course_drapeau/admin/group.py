from django.contrib import admin
from course_drapeau.models import Group


@admin.register(Group)
class GroupAdmin(admin.ModelAdmin):
    list_display = ('id', 'name', 'member_count')
    readonly_fields = ('id',)
    fields = ('id', 'name', 'sections')
    filter_horizontal = ('sections',)

    def member_count(self, obj):
        return obj.get_member_count()

    member_count.short_description = 'Nombre de coureurs'
