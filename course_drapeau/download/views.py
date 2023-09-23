from typing import Any
from django.db import models
from django.http import FileResponse
from django.views.generic.detail import BaseDetailView

from course_drapeau.models import Runner, Section


class FileView(BaseDetailView):
    """
    Inherited classes must implement the `get_file` method and as_attachment attribute.
    """

    def get(self, request, *args, **kwargs):
        file = self.get_file(self.get_object())
        response = FileResponse(file, as_attachment=self.as_attachment)
        return response


class SectionView(FileView):
    queryset = Section.objects.all()
    as_attachment = True

    def get_file(self, object):
        return object.gpx


class FullSectionView(SectionView):
    as_attachment = True

    def get_object(self):
        return Section.objects.get(full=True)


class MedicalCertificateView(FileView):
    queryset = Runner.objects.all()
    as_attachment = False

    def get_file(self, object):
        return object.medical_certificate
