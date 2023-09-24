from urllib.parse import quote
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
    coordinates = coordinate(section)
    base_url = 'https://www.google.fr/maps/search/'
    return {
        'start': base_url + quote(coordinates["start"]),
        'stop': base_url + quote(coordinates["stop"]),
    }


@register.simple_tag
def coordinate(section: Section):
    start_gps = f'{section.start_latitude} {section.start_longitude}'
    stop_gps = f'{section.stop_latitude} {section.stop_longitude}'
    return {
        'start': start_gps,
        'stop': stop_gps,
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
