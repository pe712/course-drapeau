from django import template

register = template.Library()

@register.simple_tag
def get_header(user):
    progress = user.runner.progress
    stylized_progress = f"{round(progress)*100}%"
    if progress == 1:
        text = f"Bravo {user.first_name}, tu as complété tout ton espace personnel."
    else:
        text = f"Bienvenue {user.first_name}, tu en es à {stylized_progress} du remplissage de ton espace personnel."
    return {'text': text, 'progress': stylized_progress}
