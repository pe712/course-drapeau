

from django.urls import path

from course_drapeau.download.views import SectionView, FullSectionView, MedicalCertificateView


urlpatterns = [
    path('section/<int:pk>/', SectionView.as_view(), name='section'),
    path('fullsection/', FullSectionView.as_view(), name='fullsection'),
    path('medical_certificate/<int:pk>/', MedicalCertificateView.as_view(), name='medical_certificate'),
]