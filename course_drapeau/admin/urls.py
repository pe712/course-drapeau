
from django.contrib import admin
from django.urls import path

admin.site.site_header = 'Course Drapeau Administration'
admin.site.site_title = 'Course Drapeau Administration'
admin.site.index_title = 'Course Drapeau Administration'
admin.site.enable_nav_sidebar = False

urlpatterns = [
    path('', admin.site.urls),
]
