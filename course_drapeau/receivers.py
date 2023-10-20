
from django.dispatch import receiver
from course_drapeau.models import Group
from django.db.models.signals import post_save


@receiver(post_save, sender=Group)
def delete_empty_group(sender, instance: Group, created, **kwargs):
    if not created and instance.get_member_count() == 0:
        # instance.delete()
        pass
        # this currently does not work
        # after post_save, m2m_save signal is sent and cannot update the related fields because group is none
