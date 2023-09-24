from django.views.generic.base import TemplateResponseMixin
from course_drapeau.permissions import is_member
from course_drapeau.views.base import NavbarMixin
from django.contrib.auth.mixins import UserPassesTestMixin
from django.shortcuts import redirect
from course_drapeau.forms.account import AdvancedRunnerForm, DriverForm, MedicalCertificateForm, SimpleRunnerForm, UserTypeForm


from course_drapeau.views.multiple_forms import MultipleFormsMixin, ProcessMultipleFormsView


class Card:
    def __init__(self, title, id, template):
        self.title = title
        self.id = id
        self.template = f"course_drapeau/pages/account/cards/{template}.html"


class AccountView(UserPassesTestMixin, NavbarMixin, TemplateResponseMixin, MultipleFormsMixin, ProcessMultipleFormsView):
    template_name = 'course_drapeau/pages/account/index.html'
    forms_class = {
        'user_type_form': UserTypeForm,
        'driver_form': DriverForm,
        'simple_runner_form': SimpleRunnerForm,
        'medical_certificate_form': MedicalCertificateForm,
        'advanced_runner_form': AdvancedRunnerForm
    }

    cards = [
        [
            Card("Mes informations personnelles", "info", "info"),
            Card("Mon certificat médical",
                 "medical_certificate", "medical_certificate"),
            Card("Paiement de la course", "payment", "payment")
        ],
        [
            Card("Logistique", "logistics", "logistics"),
            Card("Liste d'affaires à emmener", "stuff", "stuff"),
            Card("Hébergement", "lodging", "lodging")
        ],
        # [
        # Card("Mes tronçons", "troncons", "troncons"),
        # Card("Mon trinôme", "trinomes", "trinomes")]]
    ]

    def test_func(self):
        return is_member(self.request.user)

    def get_context_data(self, **kwargs):
        kwargs['cards'] = self.cards
        return super().get_context_data(**kwargs)

    def get_forms_kwargs(self):
        runner = self.request.user.runner
        return {
            'driver_form': {'instance': runner},
            'simple_runner_form': {'instance': runner},
            'medical_certificate_form': {'instance': runner},
            'advanced_runner_form': {'instance': runner},
        }

    def post(self, request, *args, **kwargs):
        forms = self.get_forms()
        if request.POST['action'] == 'medical_certificate':
            return self.medical_certificate_upload(request)
        elif request.POST['action'] == 'advanced_runner':
            return self.advanced_runner_change(request)
        return self.forms_invalid(forms)

    def advanced_runner_change(self, request):
        advanced_runner_form = AdvancedRunnerForm(request.POST)
        if advanced_runner_form.is_valid():
            runner = request.user.runner
            runner.vegetarian = advanced_runner_form.cleaned_data['vegetarian']
            runner.license = advanced_runner_form.cleaned_data['license']
            runner.manual_gearbox = advanced_runner_form.cleaned_data[
                'manual_gearbox']
            runner.young_driver = advanced_runner_form.cleaned_data[
                'young_driver']
            runner.save()
            return redirect('account')
        else:
            return self.render_to_response(self.get_context_data(
                advanced_runner_form=advanced_runner_form
            ))

    def medical_certificate_upload(self, request):
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
