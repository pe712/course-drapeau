from django.views.generic import TemplateView

class NavItem:
    def __init__(self, page_name, title, logged_in_display=True, logged_out_display=True, staff_required=False):
        self.page_name = page_name
        self.title = title
        self.logged_in_display = logged_in_display
        self.logged_out_display = logged_out_display
        self.staff_required = staff_required

class CustomTemplateView(TemplateView):
    navbar = [
        NavItem('index', 'Accueil'),
        NavItem('about', 'À propos'),
        NavItem('contact', 'Le binet'),
        NavItem('troncons', 'Tronçons'),
        NavItem('suivi', 'Suivi'),
        NavItem('admin:index', 'Administration', staff_required=True),
        NavItem('espaceperso', 'Espace Membre', logged_out_display=False),
        NavItem('login', 'Me connecter', logged_in_display=False),
        NavItem('logout', 'Me déconnecter', logged_out_display=False),
    ]

    def get_context_data(self, **kwargs):
        context = super().get_context_data(**kwargs)
        context['navbar'] = self.navbar
        context['user'] = self.request.user
        return context