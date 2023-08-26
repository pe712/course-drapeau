from django import template

register = template.Library()

@register.simple_tag
def navbar_item_display(navbar_item, user):
    return ((user.is_authenticated and navbar_item.logged_in_display) or
            (not user.is_authenticated and navbar_item.logged_out_display)) and \
        (user.is_staff or not navbar_item.staff_required)
