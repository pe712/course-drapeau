from django import template
from course_drapeau.models import Section
register = template.Library()


@register.simple_tag
def gps_url(section: Section):
    start_gps = f'{section.start_latitude}%20{section.start_longitude}'
    stop_gps = f'{section.stop_latitude}%20{section.stop_longitude}'
    base_url = 'https://www.google.fr/maps/search/'
    import logging
    logging.info(f'gps_url: {base_url + start_gps}')
    return {
        'start': base_url + start_gps,
        'stop': base_url + stop_gps,
    }
