from django.contrib.auth.mixins import UserPassesTestMixin
from typing import Any, Callable
from django_cas_ng.views import LoginView as CASLoginView, LogoutView as CASLogoutView
from django.views import View
from django.views.generic import DetailView
from django.http import FileResponse, HttpRequest, HttpResponse

from course_drapeau.permissions import is_runner
from .base_views import CustomTemplateView
import logging

logger = logging.getLogger(__name__)


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
    template_name = 'course_drapeau/pages/route.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['GPX_traces'] = Section.objects.all()
        return context


class SuiviView(CustomTemplateView):
    template_name = 'course_drapeau/pages/tracking.html'


class Card:
    def __init__(self, title, id, template):
        self.title = title
        self.id = id
        self.template = f"course_drapeau/pages/account/cards/{template}.html"


class AccountView(UserPassesTestMixin, CustomTemplateView):
    template_name = 'course_drapeau/pages/account/index.html'
    cards = [[
        Card("Mes informations personnelles", "info", "info"),
        # Card("Mon certificat médical", "certif", "certif"),
        # Card("Paiement de la course", "payement", "payement")],
        # [
        # Card("Logistique", "logistique", "logistique"),
        # Card("Liste d'affaires à emmener",
        #      "affaires", "affaires"),
        # Card("Hébergement", "hebergement", "hebergement")],
        # [
        # Card("Mes tronçons", "troncons", "troncons"),
        # Card("Mon trinôme", "trinomes", "trinomes")]]
    ]]

    def test_func(self):
        return is_runner(self.request.user)

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['cards'] = self.cards
        return context


class FileView(DetailView):
    # queryset = File.objects.all()

    def get(self, request, *args, **kwargs):
        instance = self.get_object()
        as_attachment = bool(request.GET.get('download', False))
        response = FileResponse(instance.upload, as_attachment=as_attachment)
        return response


class WipView(View):
    def get(self, request, *args, **kwargs):
        # for key, value in request.session['attributes'].items():
        #     logging.info(f"{key}: {value}")
        content = ''
        from .models import Runner
        Runner.objects.create(user=request.user)
        logging.info(self.request.user.__class__)
        return HttpResponse(content, content_type='text/plain')


class LoginView(CASLoginView):
    def successful_login(self, request: HttpRequest, next_page: str) -> HttpResponse:
        user = request.user
        if not user.first_name:
            user.first_name = request.session['attributes']['givenName']
            user.last_name = request.session['attributes']['sn']
            user.email = request.session['attributes']['email']
            user.save()
        return super().successful_login(request, next_page)


class LogoutView(CASLogoutView):
    pass
