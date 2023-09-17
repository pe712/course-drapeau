
from django.urls import include, path

from .views.wip import WipView
from .views.auth import LoginView, LogoutView
from .views.pages import IndexView, AboutView, ContactView, RouteView, SuiviView, AccountView, RegisterView


urlpatterns = [
    path('', IndexView.as_view(), name='index'),
    path('about', AboutView.as_view(), name='about'),
    path('contact', ContactView.as_view(), name='contact'),
    path('route', RouteView.as_view(), name='route'),
    path('tracking', SuiviView.as_view(), name='tracking'),
    path('account', AccountView.as_view(), name='account'),
    path('wip', WipView.as_view(), name='wip'),
    path('login', LoginView.as_view(), name='cas_ng_login'),
    path('logout', LogoutView.as_view(), name='cas_ng_logout'),
    path('register', RegisterView.as_view(), name='register'),
    path('download/', include('course_drapeau.download.urls')),

]