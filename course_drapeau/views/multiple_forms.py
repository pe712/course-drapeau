"""
Inspired by https://gist.github.com/michelts/1029336
And https://github.com/fusionbox/django-betterforms/blob/master/betterforms/multiform.py
Similar to FormMixin, ProcessFormView from django.views.generic.edit but for multiple forms.

I changed initial to forms_kwargs because it is more generic.
"""
from django.core.exceptions import ImproperlyConfigured
from django.http import HttpResponseRedirect

from django.views import View
from django.views.generic.edit import FormMixin, ProcessFormView
from django.views.generic.base import ContextMixin


class MultipleFormsMixin(ContextMixin):
    """
    A mixin that provides a way to show and handle several forms in a
    request.
    """

    forms_kwargs = {}
    instances = {}
    forms_class = {}
    success_url = None
    prefix = None

    def get_prefix(self, form_name) -> str:
        """Return the prefix to use for this form_name."""
        if isinstance(self.prefix, dict):
            prefix = self.prefix.get(form_name)
            if prefix:
                return prefix
            raise ImproperlyConfigured(
                "If prefix is a dict, it must contain a mapping for every form_name.")
        if isinstance(self.prefix, str):
            return self.prefix
        if self.prefix is None:
            return None
        raise ImproperlyConfigured(
            "The prefix attribute must be a string or a dict mapping form_name to prefix string.")

    def get_form_class(self, form_name):
        """Return the form class to use for this form_name."""
        return self.forms_class[form_name]

    def get_forms_class(self) -> dict:
        """Return the forms class to use for this view."""
        if not isinstance(self.forms_class, dict):
            raise ImproperlyConfigured(
                "The forms_class attribute must be a dictionary mapping form_name to form_class."
            )
        return self.forms_class

    def get_forms(self):
        """Return the instances of the forms to be used in this view."""
        forms_class = self.get_forms_class()
        return {form_name: form_class(**self.get_form_kwargs(form_name)) for form_name, form_class in forms_class.items()}

    def get_forms_kwargs(self) -> dict:
        """Return the kwargs data passed when instanciating forms on this view."""
        if not isinstance(self.forms_kwargs, dict):
            raise ImproperlyConfigured(
                "The forms_kwargs attribute must be a dictionary mapping form_name to kwargs passed to the form."
            )
        return self.forms_kwargs

    def get_form_kwargs(self, form_name) -> dict:
        """Return the keyword arguments for instantiating this form_name."""
        kwargs = self.get_forms_kwargs().get(form_name, {})
        kwargs["prefix"] = self.get_prefix(form_name)

        if self.request.method in ("POST", "PUT"):
            kwargs.update(
                {
                    "data": self.request.POST,
                    "files": self.request.FILES,
                }
            )
        return kwargs

    def get_success_url(self):
        """Return the URL to redirect to after processing a valid form."""
        if not self.success_url:
            raise ImproperlyConfigured(
                "No URL to redirect to. Provide a success_url.")
        return str(self.success_url)  # success_url may be lazy

    def forms_valid(self, forms):
        """If all forms are valid, redirect to the supplied URL."""
        return HttpResponseRedirect(self.get_success_url())

    def forms_invalid(self, forms):
        """If any form is invalid, render the invalid forms in the template."""
        return self.render_to_response(self.get_context_data(forms=forms))

    def get_context_data(self, **kwargs):
        """Insert the forms into the context dict."""
        if "forms" not in kwargs:
            kwargs["forms"] = self.get_forms()
        return super().get_context_data(**kwargs)


class ProcessMultipleFormsView(View):
    """
    A mixin that processes multiple forms on POST. Every form must be
    valid.
    """

    def get(self, request, *args, **kwargs):
        return self.render_to_response(self.get_context_data())

    def post(self, request, *args, **kwargs):
        forms = self.get_forms()
        if all([form.is_valid() for form in forms.values()]):
            return self.forms_valid(forms)
        else:
            return self.forms_invalid(forms)
