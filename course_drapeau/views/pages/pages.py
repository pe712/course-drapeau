from django.views.generic.base import TemplateResponseMixin
from django.views.generic import TemplateView
from course_drapeau.models import Information, Section
from django.shortcuts import redirect
from course_drapeau.forms.account import DriverForm, SimpleRunnerForm, UserTypeForm

from course_drapeau.permissions import is_member
from course_drapeau.views.base import NavbarMixin
import logging

from course_drapeau.views.multiple_forms import MultipleFormsMixin, ProcessMultipleFormsView

logger = logging.getLogger(__name__)


class IndexView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/index.html'

class ReferenceView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/reference.html'

class AboutView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/about.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['informations'] = Information.objects.all()
        return context


class ContactView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/contact.html'


class RouteView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/route.html'

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['GPX_traces'] = Section.objects.all()
        return context


class SuiviView(NavbarMixin, TemplateView):
    template_name = 'course_drapeau/pages/tracking.html'


class RegisterView(NavbarMixin, TemplateResponseMixin, MultipleFormsMixin, ProcessMultipleFormsView):
    template_name = 'course_drapeau/pages/register.html'
    forms_class = {
        'user_type_form': UserTypeForm,
        # 'driver_form': DriverForm,
        'simple_runner_form': SimpleRunnerForm,
    }
    success_url = 'account'

    def forms_valid(self, forms):
        user = self.request.user
        user_type_form = forms['user_type_form']
        # driver_form = forms['driver_form']
        simple_runner_form = forms['simple_runner_form']
        if not user.is_authenticated:
            return self.forms_invalid(forms)
        user_type = user_type_form.cleaned_data['user_type']
        if user_type == 'driver':
            # driver = driver_form.save(commit=False)
            # driver.user = user
            # driver.save()
            return redirect('account')
        elif user_type == 'runner':
            runner = simple_runner_form.save(commit=False)
            runner.user = user
            runner.save()
            if runner.save_group(simple_runner_form.cleaned_data['group_member_choice']):
                return redirect('account')
            else:
                self.forms_invalid(forms)

    def get(self, request, *args, **kwargs):
        if is_member(request.user):
            return redirect('account')
        return super().get(request, *args, **kwargs)
