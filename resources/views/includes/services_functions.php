<script>
    function followService(type, type_id, owner_id) {
        $('#follow_' + type + '_' + type_id).hide();
        $('#unfollow_' + type + '_' + type_id).show();
        $.ajax({
            type: "GET",
            url: "<?= asset('follow_service'); ?>",
            data: {type: type, type_id: type_id, owner_id: owner_id, "other_id": owner_id},
            success: function (response) {
                url_type = '<?= asset('group_time_line') ?>' + '/' + type_id;
                notification_icon = '<?= asset('userassets/images/group.png') ?>';
                notification_text = ' started following your event';
                if (type == 's') {
                    url_type = '<?= asset('teaching_studio_time_line') ?>' + '/' + type_id;
                    notification_icon = '<?= asset('userassets/images/studio.png') ?>';
                    notification_text = ' started following your teaching studio';
                }
                if (type == 'a') {
                    url_type = '<?= asset('accompanist_time_line') ?>' + '/' + type_id;
                    notification_icon = '<?= asset('userassets/images/pianist.png') ?>';
                    notification_text = ' started following your accompanist';
                }
                socket.emit('notification_get', {
                    "user_id": owner_id,
                    "other_id": '<?php echo $current_id; ?>',
                    "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                    "photo": '<?php echo $current_photo; ?>',
                    "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + notification_text,
                    "url": url_type,
                    "notification_icon": notification_icon,
                    "other_url": url_type,
                    "unique_text": response.type_id,
                });
            }
        });
    }
    function unfollowService(type, type_id, owner_id) {
        $('#follow_' + type + '_' + type_id).show();
        $('#unfollow_' + type + '_' + type_id).hide();
        $.ajax({
            type: "GET",
            url: "<?= asset('unfollow_service'); ?>",
            data: {type: type, type_id: type_id, owner_id: owner_id},

            success: function (response) {
            }
        });
    }
    function inviteService(type, type_id, other_id) {
        $('#invite_' + type + '_' + other_id).hide();
        $('#showSuccess').html('Invitation send Successfully').fadeIn().fadeOut(5000);
        $.ajax({
            type: "GET",
            url: "<?= asset('invite_service'); ?>",
            data: {type: type, type_id: type_id, other_id: other_id},

            success: function (response) {
                url_type = '<?= asset('group_time_line') ?>' + '/' + type_id;
                notification_icon = '<?= asset('userassets/images/group.png') ?>';
                notification_text = ' invited his to event';
                if (type == 's') {
                    url_type = '<?= asset('teaching_studio_time_line') ?>' + '/' + type_id;
                    notification_icon = '<?= asset('userassets/images/studio.png') ?>';
                    notification_text = ' invited to his teaching studio';
                }
                if (type == 'a') {
                    url_type = '<?= asset('accompanist_time_line') ?>' + '/' + type_id;
                    notification_icon = '<?= asset('userassets/images/pianist.png') ?>';
                    notification_text = ' invited to his accompanist';
                }
                socket.emit('notification_get', {
                    "user_id": other_id,
                    "other_id": '<?php echo $current_id; ?>',
                    "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                    "photo": '<?php echo $current_photo; ?>',
                    "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> ' + notification_text,
                    "url": url_type,
                    "notification_icon": notification_icon,
                    "other_url": url_type,
                    "unique_text": response.type_id,
                });
            }
        });
    }
</script>

