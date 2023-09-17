from django.views.generic import TemplateView
from course_drapeau.permissions import is_member, is_staff, is_authenticated


class NavbarItem:
    def __init__(self, page_name, title, test_func=None):
        self.page_name = page_name
        self.title = title
        self.test_func = test_func or (lambda user: True)


class CustomTemplateView(TemplateView):
    navbar = [
        NavbarItem('index', 'Accueil'),
        NavbarItem('about', 'Informations'),
        NavbarItem('contact', 'Le binet'),
        NavbarItem('register', 'Inscription',
                   lambda user: not is_member(user)),
        NavbarItem('route', 'Tronçons'),
        NavbarItem('tracking', 'Suivi'),
        NavbarItem('admin:index', 'Administration', is_staff),
        NavbarItem('account', 'Espace Membre', is_member),
        NavbarItem('cas_ng_login', 'Me connecter',
                   lambda user: not user.is_authenticated),
        NavbarItem('cas_ng_logout', 'Me déconnecter', is_authenticated),
    ]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['navbar'] = self.navbar
        context['user'] = self.request.user
        return context
