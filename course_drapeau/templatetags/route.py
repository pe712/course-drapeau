from django import template
from course_drapeau.models import Section
register = template.Library()

colors = [
    '#FFFFFF',
    '#885371',
    '#033e3e',
    '#77bfc7',
    '#737ca1',
    '#434876',
    '#783f04',
    '#efba68',
    '#ce7e00',
    '#006400',
    '#347c17',
    '#8ac209',
    '#b8ea85',
    '#a0382b'
]


@register.simple_tag
def gps_url(section: Section):
    start_gps = f'{section.start_latitude}%20{section.start_longitude}'
    stop_gps = f'{section.stop_latitude}%20{section.stop_longitude}'
    base_url = 'https://www.google.fr/maps/search/'
    return {
        'start': base_url + start_gps,
        'stop': base_url + stop_gps,
    }


@register.simple_tag
def group(section: Section):
    group = section.group.all().first()
    if group:
        color = colors[group.id % len(colors)]
        name = group.name
        border_width = 0
    else:
        color = colors[0]
        name = None
        border_width = 'thin'
    import logging
    logging.info(f'color: {color}')
    return {
        'name': name,
        'color': color,
        'bw': border_width,
    }