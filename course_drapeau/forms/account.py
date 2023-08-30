from django import forms
from course_drapeau.models import Driver, Runner
from django.contrib.auth.models import User

class UserTypeForm(forms.Form):
    user_type = forms.ChoiceField(
        choices=[('driver', 'Chauffeur'), ('runner', 'Coureur')],
        widget=forms.RadioSelect
    )

class DriverForm(forms.ModelForm):
    class Meta:
        model = Driver
        fields = ['seats']

class RunnerForm(forms.ModelForm):
    group_member_choice = forms.ModelChoiceField(
        queryset=User.objects.filter(runner__isnull=True),
        widget=forms.Select,
        required=False,
    )

    class Meta:
        model = Runner
        fields = []
