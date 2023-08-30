from django import forms
from django.contrib.auth.models import User
from course_drapeau.models import Runner

class RunnerAdminForm(forms.ModelForm):
    class Meta:
        model = Runner
        fields = ('medical_certificate', 'group')

    user_ptr = forms.ModelChoiceField(
        queryset=User.objects.all(),
        widget=forms.Select(attrs={'readonly': 'readonly'}),
    )
