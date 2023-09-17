from django.contrib import admin
from course_drapeau.models import Information


@admin.register(Information)
class InformationAdmin(admin.ModelAdmin):
    list_display = ('id', 'question')
    fields = ('question', 'answer')
