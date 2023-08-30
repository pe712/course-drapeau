from typing import Union
from django.contrib.auth.models import User, AnonymousUser


def is_authenticated(user: Union[User, AnonymousUser]):
    """
    Check if the user is authenticated.
    """
    return user.is_authenticated


def is_member(user: Union[User, AnonymousUser]):
    """
    Check if the user it authenticated as a runner.
    """
    return hasattr(user, 'runner') or hasattr(user, 'driver')


def is_staff(user: Union[User, AnonymousUser]):
    """
    Check if the user is a staff member.
    """
    return user.is_staff
