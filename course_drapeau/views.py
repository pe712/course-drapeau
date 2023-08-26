from django.template import EngineHandler
from django.views import View
from django.views.generic import TemplateView

class IndexView(TemplateView):
    template_name = 'index.html'
