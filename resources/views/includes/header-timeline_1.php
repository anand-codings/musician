<header class="header">
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid padding_fluid">
            <div class="header_left_side d-flex align-items-center">
                <?php if (Auth::guard('user')->check()) { ?>
                    <div class="navbar-toggler mr-3" id="toggle_timeline_menu">
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                        <span class="navbar-toggler-icon"></span>
                    </div>
                <?php } ?>
                <a href="<?php echo asset('/'); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="166" height="42" viewBox="0 0 166 42">
                        <path id="music" fill="#fff" class="cls-1" d="M37.4,32.914V14.5H37.93l4.655,17.36h4.83L52.07,14.5h0.525v18.41h4.83V9.114H49.2L45,26.474,40.8,9.114H32.575v23.8H37.4ZM72.48,28.5l-0.455.14a8.523,8.523,0,0,1-2.905.49,1.979,1.979,0,0,1-2.03-.945,9.937,9.937,0,0,1-.42-3.535v-9.24H61.98v9.17q0,4.725,1.26,6.738t4.9,2.012a9.35,9.35,0,0,0,4.375-1.4v0.98H77.17v-17.5H72.48V28.5ZM93.79,15.9l-1.155-.21A32.727,32.727,0,0,0,87,15.029a7.892,7.892,0,0,0-4.865,1.418,4.919,4.919,0,0,0-1.89,4.2q0,2.782,1.33,3.867a8.656,8.656,0,0,0,4.043,1.54,16.757,16.757,0,0,1,3.36.77,1.033,1.033,0,0,1,.647.98,1.071,1.071,0,0,1-.612,1,5.419,5.419,0,0,1-2.31.332,55.742,55.742,0,0,1-6.037-.56l-0.14,3.92,1.12,0.21a30.542,30.542,0,0,0,5.6.63q7.035,0,7.035-5.67a5.045,5.045,0,0,0-1.19-3.745,7.705,7.705,0,0,0-4.008-1.663,26.607,26.607,0,0,1-3.5-.77,0.95,0.95,0,0,1-.682-0.945,1.087,1.087,0,0,1,.507-1,5.016,5.016,0,0,1,2.24-.315,55.845,55.845,0,0,1,6.072.56Zm9.055,17.01v-17.5h-4.69v17.5h4.691Zm0-19.74V8.414h-4.69v4.76h4.691Zm5.22,3.973q-1.752,2.153-1.75,6.983t1.7,7.017q1.7,2.188,5.583,2.188a32.249,32.249,0,0,0,5.7-.735l-0.14-3.745-4.06.28q-2.451,0-3.238-1.067a7.025,7.025,0,0,1-.787-3.937q0-2.869.787-3.9t3.2-1.033q1.329,0,4.095.28l0.14-3.71-0.945-.21a25.055,25.055,0,0,0-4.655-.56Q109.815,14.994,108.065,17.147Zm19.78,15.767v-17.5h-4.69v17.5h4.69Zm0-19.74V8.414h-4.69v4.76h4.69Zm16.227,3.22q-1.488-1.4-4.865-1.4a27.24,27.24,0,0,0-7.122,1.015l0.14,3.255,6.58-.28a2.484,2.484,0,0,1,1.575.4,1.853,1.853,0,0,1,.49,1.487v1.085l-3.745.28a8.432,8.432,0,0,0-4.62,1.383Q131,24.795,131,27.594q0,5.741,5.425,5.74a11.652,11.652,0,0,0,5.145-1.225,6.4,6.4,0,0,0,2.152.98,13.28,13.28,0,0,0,2.853.245l0.14-3.535a1.3,1.3,0,0,1-.875-0.473,2.779,2.779,0,0,1-.28-1.172v-7.28A5.911,5.911,0,0,0,144.072,16.394Zm-3.2,8.82v3.745l-0.525.14a11.339,11.339,0,0,1-2.905.42q-1.716,0-1.715-1.925a1.9,1.9,0,0,1,1.96-2.1Zm13.975-5.39,0.42-.14a7.931,7.931,0,0,1,2.765-.49,2.108,2.108,0,0,1,2.1,1.068,7.874,7.874,0,0,1,.525,3.307v9.345h4.69V23.429q0-4.3-1.33-6.37t-4.83-2.065a8.768,8.768,0,0,0-4.375,1.4v-0.98h-4.655v17.5h4.69V19.824ZM17.935,34.973L12.414,42c-1.8-2.314-3.462-4.359-4.992-6.5a3.315,3.315,0,0,1-.363-2c0.067-1.133.315-2.256,0.5-3.5-1.336-.732-2.723-1.351-3.952-2.193C1.174,26.143-.273,23.907.046,20.849a6.942,6.942,0,0,1,2.37-4.628,49.946,49.946,0,0,1,4.532-3.312c0.877-.6,1.833-1.094,2.9-1.72C10,9.638,10.136,8.065,10.325,6.5A23.156,23.156,0,0,1,10.9,2.844c0.82-2.835,4.922-3.818,7.042-1.712a2.868,2.868,0,0,1,.812,3.394A31.785,31.785,0,0,1,16.485,8.4a20.811,20.811,0,0,1-1.907,2.14q1.125,8.344,2.283,16.937c5.237-2.281,6.157-6.6,2.428-10.215-0.868-.841-1.874-1.545-3.263-2.677C19.41,15.2,21.9,16.279,23.713,18.5c1.41,1.729,1.8,3.76.473,5.653a18.607,18.607,0,0,1-3.494,3.589,25.712,25.712,0,0,1-3.553,2.085ZM9.66,13.888c-3.728,1.465-5.925,4.517-5.746,7.8a5.8,5.8,0,0,0,4.05,5.5Zm4.506-5.22c1.726-1.964,2.715-3.541,2.631-5.6a1.526,1.526,0,0,0-1.624-1.694,1.4,1.4,0,0,0-1.43,1.583C13.783,4.669,13.985,6.373,14.166,8.668Z"/>
                    </svg>
                </a>
            </div> <!-- left side -->

            <div class="header_right_side d-flex flex-grow-1 align-items-center justify-content-end">
                <div class="s_timeline clearfix">
                    <form method="get" action="<?= asset('search') ?>" id="header_filter">
                        <span class="search_back">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="search_input">
                            <input id="search_box" type="text" name="search" placeholder="Find musician or their events..." value="<?= (isset($_GET['search']) && $_GET['search'] != '') ? $_GET['search'] : '' ?>"/>
                        </div>
                        <div class="search_options">
                            <?php $type_list = categories(); ?>
                            <select name="cat" onclick="$(this).submit()" class="selct2_select">
                                <option value="" <?= (isset($_GET['cat']) && $_GET['cat'] == '') ? 'selected' : '' ?>>All Categories</option>
                                <?php
                                if (isset($type_list) && count($type_list) > 0) {
                                    foreach ($type_list as $key => $typeval) {
                                        ?>
                                        <option value="<?= $typeval['id'] ?>" <?= (isset($_GET['cat']) && $_GET['cat'] == $typeval['id']) ? 'selected' : '' ?>><?= $typeval['title'] ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit"><i class="search_icons"></i><span>Search</span></button>
                    </form>
                </div> <!-- search -->

                <span class="search_icon_mobile">
                    <i class="fas fa-search"></i>
                </span>
                <?php
                if (Auth::guard('user')->check()) {
                    ?>
                    <div class="dropdown dropdown_notification">
                        <a onclick="readNotificatios()" href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                            <i class="fas fa-bell"></i>
                            <div id="new-notification-dot">
                                <?php if (notificationCount()) { ?>
                                    <span class="indicator rounded-circle"><span class="rounded-circle"></span></span>
                                <?php } ?>
                            </div>
                        </a>
                        <div class="dropdown-menu">
                            <div class="notification_mobile_header">
                                <h5 class="mb-0"> 
                                    <i class="fas fa-arrow-left" id="close-notifications-box"></i> 
                                    <span class="font-weight-bold">Notifications</span>
                                </h5>
                            </div>
                            <ul class="un_style notification_list" id="notification-list-in-header">
                                <?php
                                $notifications = notifications(5, 0);
                                foreach ($notifications as $notification) {
                                    if ($notification->user_id != null) {
                                        $other_user = getUser($notification->user_id);
                                        $other_user_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                    }
                                    $url = '';
                                    $notificaiton_icon = '';
                                    if ($notification->type == 'message') {
                                        $url = asset('messages');
                                        $notificaiton_icon = asset('userassets/images/icon-comment.png');
                                    }
                                    if ($notification->type == 'post') {
                                        $url = asset('get_post/'.$notification->type_id);
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
                                    }
                                    if ($notification->type == 'review') {
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
                                    ?>
                                    <?php
                                    if ($notification->type == 'teaching_studio') {
                                        $notificaiton_icon = asset('userassets/images/studio.png');
                                        ?>
                                        <li class="notification<?= $notification->unique_text ?> d-flex align-items-center">
                                            <a href="<?= asset('teaching_studio_detail/' . $notification->studio->id) ?>">
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
                                                <?php } else if ($notification->is_studio_admin_responded == 0 && $notification->is_studio_request_response == 0) { ?>
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
                                            if (!$notification->left_notification) {
                                                if (!$notification->is_group_admin_invitation_response) {
                                                    if ($notification->is_group_invite == 1 && $notification->is_group_invitee_responded == 0) {
                                                        ?>
                                                        <span class="icon">
                                                            <img onclick="inviteGroupResponse(this)" status="reject" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-close.png') ?>" />
                                                            <img onclick="inviteGroupResponse(this)" status="approve" unique-text="<?= $notification->unique_text ?>" group-id="<?= $notification->type_id ?>" group-name="<?= $notification->group->name ?>" user-id="<?= $notification->user_id ?>" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />
                                                        </span>
                                                    <?php } else if ($notification->is_group_admin_responded == 0 && $notification->is_group_request_response == 0) { ?>
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
                                        <?php
                                    } else if ($notification->user_id == null) {
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
                            </ul> <!-- notification_list -->
                            <div class="all_notifications">
                                <a href="<?= asset('notifications') ?>" class="text_grey font-14">See All Feed</a>
                            </div>
                        </div> <!-- drop down -->
                    </div> <!-- dropdown_notification -->

                    <div class="dropdown dropdown_user">
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle d-flex align-items-center">
                            <span class="bg_image_round w-40" style="background-image: url(<?php echo $current_photo ?>)"></span>
                            <span class="user-name"><?= $current_name ?></span>
                        </a>
                        <div class="dropdown-menu">
                            <h6 class="username d-xl-none"> <i class="fas fa-user-circle"></i> <?= $current_name ?></h6>
                            <ul class="un_style">
                                <li> <a href="<?= asset('statistics/') ?>" class="text_grey"> <i class="fas fa-chart-line"></i>Statistics </a> </li>
                                <li> <a href="<?= asset('profile_timeline/' . $current_user->id) ?>" class="text_grey"> <i class="fas fa-user"></i> Profile </a> </li>

                                <li> <a href="<?= $current_user->type == 'user' ? asset('edit_user_profile') : ($current_user->type == 'artist' ? asset('edit_musician_profile') : '') ?>" class="text_grey"> <i class="fas fa-edit"></i> Edit </a> </li>
                                <li> <a href="<?= asset('invitation_page') ?>" class="text_grey"> <i class="fas fa-envelope-open"></i> Inviter </a> </li>
                                <li> <a href="<?= asset('userlogout') ?>" class="text_grey"> <i class="fas fa-share"></i> Logout </a> </li>
                            </ul>
                        </div>
                    </div> <!-- drop down users -->       
                <?php } ?>
            </div> <!-- right side -->
        </div> <!-- container -->
    </nav> <!-- nav -->
</header> <!-- header -->