from course_drapeau.models import Information, Section
from django.contrib.auth.mixins import UserPassesTestMixin
from django.shortcuts import redirect
from course_drapeau.forms.account import DriverForm, MedicalCertificateForm, RunnerForm, UserTypeForm

from course_drapeau.permissions import is_member
from .base import CustomTemplateView
import logging

logger = logging.getLogger(__name__)


class IndexView(CustomTemplateView):
    template_name = 'course_drapeau/pages/index.html'


class AboutView(CustomTemplateView):
    template_name = 'course_drapeau/pages/about.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['informations'] = Information.objects.all()
        return context


class ContactView(CustomTemplateView):
    template_name = 'course_drapeau/pages/contact.html'


class RouteView(CustomTemplateView):
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
    cards = [
        [
            Card("Mes informations personnelles", "info", "info"),
            Card("Mon certificat médical", "certif", "certif"),
            Card("Paiement de la course", "payment", "payment")
        ],
        [
            # Card("Logistique", "logistique", "logistique"),
            # Card("Liste d'affaires à emmener",
            #      "affaires", "affaires"),
            Card("Hébergement", "lodging", "lodging")
        ],
        # [
        # Card("Mes tronçons", "troncons", "troncons"),
        # Card("Mon trinôme", "trinomes", "trinomes")]]
    ]

    def test_func(self):
        return is_member(self.request.user)

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['cards'] = self.cards
        context['user_type_form'] = UserTypeForm()
        context['driver_form'] = DriverForm()
        context['runner_form'] = RunnerForm()
        context['medical_certificate_form'] = MedicalCertificateForm()
        return context

    def post(self, request, *args, **kwargs):
        """Medical certificate upload"""
        medical_certificate_form = MedicalCertificateForm(
            request.POST, request.FILES)
        if medical_certificate_form.is_valid():
            runner = request.user.runner
            runner.medical_certificate = medical_certificate_form.cleaned_data[
                'medical_certificate']
            runner.save()
            return redirect('account')
        return self.render_to_response(self.get_context_data(
            medical_certificate_form=medical_certificate_form
        ))


class RegisterView(CustomTemplateView):
    template_name = 'course_drapeau/pages/register.html'

    def post(self, request, *args, **kwargs):
        user_type_form = UserTypeForm(request.POST)
        driver_form = DriverForm(request.POST)
        runner_form = RunnerForm(request.POST)
        user = request.user
        error_response = self.render_to_response(self.get_context_data(
            user_type_form=user_type_form,
            driver_form=driver_form,
            runner_form=runner_form
        ))
        if not user.is_authenticated:
            return error_response
        if user_type_form.is_valid():
            user_type = user_type_form.cleaned_data['user_type']
            if user_type == 'driver' and driver_form.is_valid():
                driver = driver_form.save(commit=False)
                driver.user = user
                driver.save()
                return redirect('account')
            elif user_type == 'runner' and runner_form.is_valid():
                runner = runner_form.save(commit=False)
                runner.user = user
                runner.save()
                if runner.save_group(runner_form.cleaned_data['group_member_choice']):
                    return redirect('account')
                else:
                    pass
                    # TODO
        return error_response

    def get(self, request, *args, **kwargs):
        if is_member(request.user):
            return redirect('account')
        return super().get(request, *args, **kwargs)

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['user_type_form'] = kwargs.get(
            'user_type_form', UserTypeForm())
        context['driver_form'] = kwargs.get('driver_form', DriverForm())
        context['runner_form'] = kwargs.get('runner_form', RunnerForm())
        return context
