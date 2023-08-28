from django.http import HttpResponse
from django.views import View
from silk.profiling.profiler import silk_profile


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
        return HttpResponse(content)
