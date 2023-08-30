from django.urls import path, include
from django.contrib import admin

urlpatterns = [
    path('', include('course_drapeau.urls')),
    path('admin/', include('course_drapeau.admin.urls')),
    path('silk/', include('silk.urls', namespace='silk')),
]
