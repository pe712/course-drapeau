from django.views.generic import DetailView
from django.http import FileResponse
from .base_views import CustomTemplateView


class IndexView(CustomTemplateView):
    template_name = 'course_drapeau/pages/index.html'


class AboutView(CustomTemplateView):
    template_name = 'course_drapeau/pages/about.html'
    items = [
        ('question1', 'answer1'),
        ('question2', 'answer2'),
        ('question3', 'answer3'),
        ('question4', 'answer4'),
    ]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['items'] = self.items
        return context


class ContactView(CustomTemplateView):
    template_name = 'course_drapeau/pages/contact.html'


class TronconsView(CustomTemplateView):
    template_name = 'course_drapeau/pages/troncons.html'
    items = {}

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['GPX_traces'] = self.items
        return context


class FileView(DetailView):
    queryset = "File.objects.all()"

    def get(self, request, *args, **kwargs):
        instance = self.get_object()
        as_attachment = bool(request.GET.get('download', False))
        response = FileResponse(instance.upload, as_attachment=as_attachment)
        return response
