from django_cas_ng.views import LoginView as CASLoginView, LogoutView as CASLogoutView
from django.http import HttpRequest, HttpResponse


class LoginView(CASLoginView):
    def successful_login(self, request: HttpRequest, next_page: str) -> HttpResponse:
        user = request.user
        attributes = request.session.get('attributes')
        if not user.first_name and attributes:
            # because of sessions, sometimes attributes are not available
            user.first_name = attributes['givenName']
            user.last_name = attributes['sn']
            user.email = attributes['email']
            user.save()
        return super().successful_login(request, next_page)


class LogoutView(CASLogoutView):
    pass
