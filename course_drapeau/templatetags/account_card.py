from django import template
from urllib.parse import quote

from course_drapeau.models import Runner

register = template.Library()


@register.simple_tag
def get_header(user):
    progress = user.runner.progress
    stylized_progress = f"{round(progress*100)}%"
    if progress == 1:
        text = f"Bravo {user.first_name}, tu as complété tout ton espace personnel."
    else:
        text = f"Bienvenue {user.first_name}, tu en es à {stylized_progress} du remplissage de ton espace personnel."
    return {'text': text, 'progress': stylized_progress}


@register.simple_tag
def maps_url(location: str):
    base_url = 'https://www.google.fr/maps/place/'
    return base_url + quote(location)

def group_runners(runner: Runner):
    if not runner.group:
        return []
    else:
        return runner.group.runners.all()