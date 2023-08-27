from django import template
from course_drapeau.base_views import NavbarItem
from django.urls import reverse, resolve
register = template.Library()

@register.simple_tag
def does_navbar_item_display(navbar_item: NavbarItem, user):
    return navbar_item.test_func(user)