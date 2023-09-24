from django import forms
from course_drapeau.models import Driver, Runner
from django.contrib.auth.models import User

# import user form
from django.contrib.auth.forms import UserCreationForm


class UserTypeForm(forms.Form):
    user_type = forms.ChoiceField(
        choices=[('runner', 'Coureur')],  # ('driver', 'Chauffeur')
        widget=forms.RadioSelect,
        initial='runner',
        label='Je suis',
    )


class DriverForm(forms.ModelForm):
    class Meta:
        model = Driver
        fields = ['seats']


class SimpleRunnerForm(forms.ModelForm):
    class Meta:
        model = Runner
        fields = []

    group_member_choice = forms.ModelChoiceField(
        queryset=Runner.objects.all(),
        widget=forms.Select,
        required=False,
        label="J'aimerais être avec"
    )


class AdvancedRunnerForm(forms.ModelForm):
    class Meta:
        model = Runner
        fields = ['vegetarian', 'license', 'manual_gearbox', 'young_driver']


class MedicalCertificateForm(forms.ModelForm):
    class Meta:
        model = Runner
        fields = ['medical_certificate']
