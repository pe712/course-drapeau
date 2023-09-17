from django.http import HttpResponse, HttpResponseRedirect
from django.views import View
from silk.profiling.profiler import silk_profile

from course_drapeau.models import Runner, Section


class WipView(View):
    """
    Usefull view for work in progress and testing purposes.
    """
    @silk_profile()
    def get(self, request, *args, **kwargs):
        # for key, value in request.session['attributes'].items():
        #     logging.info(f"{key}: {value}")
        content = '<html><body><h1>WIP</h1></body></html>'
        # from .models import Runner
        # Runner.objects.create(user=request.user)
        # logging.info(self.request.user.__class__)
        from django.contrib.auth.models import User
        user = User.objects.all().first() 
        user.is_staff = True
        user.is_superuser = True
        user.save()
        # user.delete()
        # return HttpResponseRedirect('/admin/')
        # runner = Runner.objects.all().first()
        # runner.user
        return HttpResponse(content)
