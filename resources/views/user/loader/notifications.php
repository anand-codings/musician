<?php
foreach ($notifications as $notification) {
    if ($notification->user_id != null) {
        $other_user = getUser($notification->user_id);
        $other_user_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
    }
    $url = '';
    $notificaiton_icon = '';
    if ($notification->type == 'message') {
        $url = asset('get_chat_detail/' . $notification->user_id);
        $notificaiton_icon = asset('userassets/images/icon-comment.png');
    }
    if ($notification->type == 'like') {
        $url = asset('get_post/' . $notification->postLike->post_id);
        $notificaiton_icon = asset('userassets/images/icon-likes.png');
    }
    if ($notification->type == 'comment') {
        $url = asset('get_post/' . $notification->postComment->post_id);
        $notificaiton_icon = asset('userassets/images/icon-comment.png');
    }
    if ($notification->type == 'booking') {
        $url = asset('booking_details/' . $notification->type_id);
        $notificaiton_icon = asset('userassets/images/icon-event.png');
    }
    if ($notification->type == 'follow') {
        $url = asset('profile_timeline/' . $notification->on_user);
        $notificaiton_icon = asset('userassets/images/icon-follow.svg');
    }if ($notification->type == 'review') {
        $url = asset('profile_reviews/' . $notification->on_user);
        $notificaiton_icon = asset('userassets/images/icon-review.png');
    }
    if ($notification->type == 'payment request') {
        $url = asset('booking_details/' . $notification->booking->id);
        $notificaiton_icon = asset('userassets/images/payment.png');
    }
    if ($notification->type == 'payment approved') {
        $url = asset('booking_details/' . $notification->booking->id);
        $notificaiton_icon = asset('userassets/images/payment.png');
    }
    if ($notification->type == 'payment rejected') {
        $url = asset('booking_details/' . $notification->booking->id);
        $notificaiton_icon = asset('userassets/images/payment.png');
    }
    if ($notification->type == 'accompanist') {
        $url = asset('accompanist_time_line/' . $notification->type_id);
        $notificaiton_icon = asset('userassets/images/pianist.png');
    }
    ?>
    <?php
    if ($notification->type == 'teaching_studio') {
        $notificaiton_icon = asset('userassets/images/studio.png');
        ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset('teaching_studio_time_line/' . $notification->studio->id) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <?php
                            $notificationSendingUserImage = getUserImage($notification->notificationSentBy->photo, $notification->notificationSentBy->social_photo, $notification->notificationSentBy->gender);
                            ?>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?= $notificationSendingUserImage ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text_darkblue font-weight-bold font-16"><?= $notification->notificationSentBy->first_name . ' ' . $notification->notificationSentBy->last_name ?></span> <?= $notification->notification_text ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>

                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <?php
            if (!$notification->is_studio_admin_invitation_response) {
                if ($notification->is_studio_invite == 1 && $notification->is_studio_invitee_responded == 0) {
                    ?>
                    <span class="icon">
                        <img onclick="inviteStudioResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" studio-id="<?= $notification->type_id ?>" studio-name="<?= $notification->studio->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                        <img onclick="inviteStudioResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" studio-id="<?= $notification->type_id ?>" studio-name="<?= $notification->studio->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                    </span>
                <?php } else if ($notification->is_studio_admin_responded == 0 && $notification->is_studio_request_response == 0 && $notification->activity_log !='Invite to teaching studio' && $notification->activity_log !='Followed to teaching studio') { ?>
                    <span class="icon">
                        <img onclick="joinStudioResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" studio-id="<?= $notification->type_id ?>" studio-name="<?= $notification->studio->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                        <img onclick="joinStudioResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" studio-id="<?= $notification->type_id ?>" studio-name="<?= $notification->studio->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                    </span>
                    <?php
                }
            }
            ?>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
        <?php
    } else if ($notification->type == 'group') {
        $notificaiton_icon = asset('userassets/images/group.png');
        ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset('group_time_line/' . $notification->group->id) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <?php
                            $notificationSendingUserImage = getUserImage($notification->notificationSentBy->photo, $notification->notificationSentBy->social_photo, $notification->notificationSentBy->gender);
                            ?>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?= $notificationSendingUserImage ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text_darkblue font-weight-bold font-16"><?= $notification->notificationSentBy->first_name . ' ' . $notification->notificationSentBy->last_name ?></span> <?= $notification->notification_text ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>

                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <?php
            if(!$notification->left_notification){
                if (!$notification->is_group_admin_invitation_response) {
                    if ($notification->is_group_invite == 1 && $notification->is_group_invitee_responded == 0) {
                        ?>
                        <span class="icon">
                            <img onclick="inviteGroupResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="inviteGroupResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                    <?php } else if ($notification->is_group_admin_responded == 0 && $notification->is_group_request_response == 0 && $notification->activity_log != 'Invite to event' && $notification->activity_log != 'follow the event') { ?>
                        <span class="icon">
                            <img onclick="joinGroupResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="joinGroupResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                        <?php
                    }
                }
            }
            ?>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
    <?php } else if ($notification->type == 'accompanist') {
        $notificaiton_icon = asset('userassets/images/pianist.png');
        ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset('accompanist_time_line/' . $notification->accompanist->id) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <?php
                            $notificationSendingUserImage = getUserImage($notification->notificationSentBy->photo, $notification->notificationSentBy->social_photo, $notification->notificationSentBy->gender);
                            ?>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?= $notificationSendingUserImage ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text_darkblue font-weight-bold font-16"><?= $notification->notificationSentBy->first_name . ' ' . $notification->notificationSentBy->last_name ?></span> <?= $notification->notification_text ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>

                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <?php
            if(!$notification->left_notification){
                if (!$notification->is_accompanist_admin_invitation_response) {
                    if ($notification->is_accompanist_invite == 1 && $notification->is_accompanist_invitee_responded == 0) {
                        ?>
                        <span class="icon">
                            <img onclick="inviteAccompanistResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" accompanist-id="<?= $notification->type_id ?>" accompanist-name="<?= $notification->accompanist->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="inviteAccompanistResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" accompanist-id="<?= $notification->type_id ?>" accompanist-name="<?= $notification->accompanist->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                    <?php } else if ($notification->is_accompanist_admin_responded == 0 && $notification->is_accompanist_request_response == 0 && $notification->activity_log != 'Invite to accompanist' && $notification->activity_log != 'follow the accompanist') { ?>
                        <span class="icon">
                            <img onclick="joinAccompanistResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" accompanist-id="<?= $notification->type_id ?>" accompanist-name="<?= $notification->accompanist->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="joinAccompanistResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" accompanist-id="<?= $notification->type_id ?>" accompanist-name="<?= $notification->accompanist->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                        <?php
                    }
                }
            }
            ?>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
    <?php } 
    else if ($notification->type == 'friend') {
        $notificaiton_icon = asset('userassets/images/icon-follow.svg');
        ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset('profile_timeline/' . $notification->friend->id) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <?php
                            $notificationSendingUserImage = getUserImage($notification->notificationSentBy->photo, $notification->notificationSentBy->social_photo, $notification->notificationSentBy->gender);
                            ?>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?= $notificationSendingUserImage ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text_darkblue font-weight-bold font-16"><?= $notification->notificationSentBy->first_name . ' ' . $notification->notificationSentBy->last_name ?></span> <?= $notification->notification_text ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>

                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <?php
            if(!$notification->left_notification){
                if (!$notification->is_friend_invitation_response) {
                    if ($notification->is_friend_invite == 1 && $notification->is_friend_invitee_responded == 0) {
                        ?>
                        <span class="icon">
                            <img onclick="inviteFriendResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" friend-id="<?= $notification->type_id ?>" friend-name="<?= $notification->friend->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="inviteFriendResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" friend-id="<?= $notification->type_id ?>" friend-name="<?= $notification->friend->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                    <?php } else if ($notification->is_friend_responded == 0 && $notification->is_friend_request_response == 0 && $notification->activity_log != 'Invite as Friend' && $notification->activity_log != 'follow Musician') { ?>
                        <span class="icon">
                            <img onclick="addFriendResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" friend-id="<?= $notification->type_id ?>" friend-name="<?= $notification->friend->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                            <img onclick="addFriendResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" friend-id="<?= $notification->type_id ?>" friend-name="<?= $notification->friend->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                        </span>
                        <?php
                    }
                }
            }
            ?>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
    <?php } 
    else if ($notification->user_id == null) { 
        $notificaiton_icon = asset('userassets/images/payment.png');
        ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset($url) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?= asset('userassets/images/favicon.png') ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <?= ($notification->notification_text) ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
    <?php } else { ?>
        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
            <a href="<?= asset($url) ?>">
                <div class="d-flex flex-column">
                    <div class="media align-items-center">
                        <div>
                            <span class="bg_image_round mr-2 w-50" style="background-image: url(<?php echo $other_user_image ?>)"></span>
                        </div>
                        <div class="media-body">
                            <div class="d-flex align-items-center">
                                <div>
                                    <span class="text_darkblue font-weight-bold font-16"><?= $other_user->first_name . ' ' . $other_user->last_name ?></span> <?= ($notification->notification_text) ?>
                                    <span class="d-block font-13"><?= timeago($notification->created_at) ?></span>
                                </div>

                            </div>
                        </div>
                    </div> 
                </div>
            </a>
            <div class="ml-auto mr-2">
                <span class="notification_icon">
                    <img src="<?php echo $notificaiton_icon ?>" />
                </span>
            </div>
        </li> <!-- li -->
        <?php
    }
}
?>