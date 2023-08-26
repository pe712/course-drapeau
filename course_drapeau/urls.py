
from django.urls import path

from .views import IndexView, AboutView, ContactView, TronconsView


urlpatterns = [
    path('', IndexView.as_view(), name='index'),
    path('about', AboutView.as_view(), name='about'),
    path('contact', ContactView.as_view(), name='contact'),
    path('troncons', TronconsView.as_view(), name='troncons'),
    path('', IndexView.as_view(), name='suivi'),
    path('', IndexView.as_view(), name='espaceperso'),
]