from course_drapeau.permissions import is_member as is_member_func
from django import template
register = template.Library()


@register.simple_tag
def is_member(user):
    return is_member_func(user)
