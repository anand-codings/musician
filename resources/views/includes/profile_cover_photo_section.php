<?php
$coverPhoto = asset('public/images/profile_pics/cover_photo_demo.jpg');
if ($user->cover_photo) {
    $coverPhoto = asset('public/images/' . $user->cover_photo);
}
?>
<div class="new_profile">
        <div class="container lg-fluid-container ">
            <div class="group_profile_cover_photo other_profiles" style="background-image: url('<?= $coverPhoto ?>')">
    <div class="overlay_color pb-2">

            <div class="row">
                <div class="col-lg-2 col-md-3 text-center align-items-center align-self-center">
                    <div class="profile-pic">
                        <?php
                        $image = getUserImage($user->photo, $user->social_photo, $user->gender);
                        ?>
                        <span class="bg_image_round" style="background-image: url('<?= $image ?>')"></span>
                    </div>
                    
                </div>
                <div class="col-lg-5 col-md-5">
                    <div class="profile_public_info">
                        <div class="profile_name">
                            <?php if ($user->id == $current_id || !$privacy || ($privacy && $privacy->username)) { ?>
                                <h2><?= $user->first_name . ' ' . $user->last_name ?></h2>
                            <?php } ?>
                            <div class="followings_number text-white">
                                <span style="cursor: pointer;" onclick="window.location.href = '<?= asset('get_followers/' . $user->id) ?>'"> <strong><?= $user->getFollowers->count() ?></strong> Followers</span> | <span style="cursor: pointer;" onclick="window.location.href = '<?= asset('get_followings/' . $user->id) ?>'"><strong><?= $user->getFollowings->count() ?></strong> Following</span>
                            </div>
                            <div class="text_red_dark">
                                <?php
                                if (!$user->getSelectedCategories->isEmpty()) {
                                    $getSelectedArtistTypesCount = $user->getSelectedCategories->count();

                                    if ($getSelectedArtistTypesCount <= 2) {
                                        $i = 1;
                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
                                            echo $selectedArtistType->getCategory->title;
                                            if ($getSelectedArtistTypesCount > $i)
                                                echo ', ';
                                            $i++;
                                        }
                                    } else {
                                        $i = 1;
                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
                                            echo $selectedArtistType->getCategory->title;
                                            if ($i < 2) {
                                                echo ', ';
                                            } else {
                                                echo ' ...';
                                                break;
                                            }
                                            $i++;
                                        }
                                    }
                                } else {
                                    ?>
                                    N/A
                                <?php } ?>
                            </div>
                        </div>
                        <?php if ($user->type == 'artist') { ?>
                            <!--                        <div class="rating_reviews clearfix">
                                                                                                <div class="star-ratings-sprite">
                                                                                                    <span style="width: <?= $user->rating_percentage ? $user->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                                                                                </div>
                                                                                                <span class="reviews text_grey">(<?= $user->number_of_reviews ? $user->number_of_reviews : '0' ?> Reviews)</span>
                                                                                            </div>-->
                        <?php } ?>
                        <div class="p_desc">
                            <h5 class="text-semibold mb-1 font-16">Biography:</h5>
                            <p><?= $user->description ? (strlen($user->description) > 300 ? substr($user->description, 0, 300) . '...' : $user->description) . ' ' : 'N/A ' ?><a href="<?= asset('profile_about/' . $user->id) ?>" class="readmore"> [ See Full Bio ]</a></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4">
                <?php if ($current_id && $user->id != $current_id) { ?>
                        <div class="public_profile_btns top_profile_btns append-request-<?=$user->id?>-<?=$current_id?>">
                            
                            <?php
                            if(!empty($user->checkFriend)){
                                if( $user->checkFriend->is_approved=='1'){
                                ?>
                                    <a href="javascript:void(0);" id="add-friend-btn"  class="btn btn-white" onclick="addFriend(<?=$user->id?>,'leave')"> <i class="fas fa-minus"></i> Unfriend</a>
                            <?php
                                } else if( $user->checkFriend->is_approved=='0') {
                                ?>
                                    <a href="javascript:void(0);" id="add-friend-btn"  class="btn btn-white" onclick="addFriend(<?=$user->id?>,'leave')"> <i class="fas fa-minus"></i> Cancel Friend Request</a>
                            <?php
                                }
                            } else if(!empty($user->requests)){
                            ?>
                                    <a href="javascript:void(0);" id="add-friend-btn"  class="btn btn-white" onclick="addFriend(<?=$user->id?>,'leave_response')"> <i class="fas fa-minus"></i> Reject Friend Request</a>
                            <?php
                                
                            } else {
                                ?>
                                <a href="javascript:void(0);" id="add-friend-btn"  class="btn btn-gradient" onclick="addFriend(<?=$user->id?>,'join')"> <i class="fas fa-plus"></i> Add Friend</a>
                                <?php
                            }
                            ?>
                            <a <?php if (checkFollowing($user->id)) { ?> style="display: none" <?php } ?> onclick="followUser('<?= $user->id ?>')" href="javascript:void(0)" class="btn btn-white-outline followuser_<?= $user->id ?>"> <i class="s_icon ic_follow"></i> Follow</a>
                            <a <?php if (!checkFollowing($user->id)) { ?> style="display: none" <?php } ?> onclick="unfollowUser('<?= $user->id ?>')" href="javascript:void(0)" class="btn btn-white-outline unfollowuser_<?= $user->id ?>"> <i class="s_icon ic_follow"></i> Unfollow</a>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $user->id ?>" class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
                            
                        </div>
                        <!-- Message modal Start -->
                        <div class="modal fade" id="modal_search_messages<?= $user->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $user->first_name . ' ' . $user->last_name; ?> </span></h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-0">
                                                        <textarea id="message<?= $user->id ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                    </div>
                                                </div>
                                            </div> <!-- row -->
                                            <div class="mt-2">
                                                <button type="button" onclick="sendMessage('<?= $user->id ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                                            </div>
                                        </form>
                                    </div> <!-- modal-body-->
                                </div> <!-- modal-content-->
                            </div>
                        </div> <!-- Edit Description modal -->
                        <!--  Message modal END -->
                    <?php } ?>
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- overlay color -->
</div>
</div>
<?php if ($current_id) { ?>
    <script>
        function addFriend(user_id,status){
            var data = new FormData();
            data.append('user_id', user_id);
            data.append('_token', '<?= csrf_token() ?>');
            data.append('status', status);
            if(status == 'join'){
                var click_function = 'addFriend(' + user_id + ",'cancel'"+')';
            } else {
                var click_function = 'addFriend(' + user_id + ",'join'" +')';
            } 
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_collaborative_friend'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#add-friend-btn").attr("onclick",click_function);
                        if(status == 'join'){
                            $('#add-friend-btn').removeClass('btn-gradient');
                            $('#add-friend-btn').addClass('btn-white');
                            $('#add-friend-btn').html('<i class="fas fa-minus"></i> Cancel Friend Request</a>');
                            socket.emit('notification_get', {
                                "user_id": data.notification.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' sent you a friend request',
                                "url": '<?= asset('profile_timeline/' . $user->id) ?>',
                                "friend_id": '<?= $user->id ?>',
                                "friend_name": '<?= $user->name ?>',
                                "friend_url": '<?= asset('profile_timeline/' . $current_id) ?>',
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                            });
                    
                        } else if( status == 'leave') { 
                        $("#add-friend-btn").attr("onclick",click_function);
                        $('.notification' + data.notification.unique_text).find('.icon').remove();
                            socket.emit('notification_get', {
                                "user_id": data.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' unfriended you!',
                                "url": '<?= asset('profile_timeline/' . $user->id) ?>',
                                "friend_id": '<?= $user->id ?>',
                                "friend_name": '<?= $user->name ?>',
                                "friend_url": '<?= asset('profile_timeline/' . $current_id) ?>',
                                "unique_text": '<?=$current_id?>_unfriended_'+data.on_user,
                                "friend_response":"2",
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                                "left_notification": "1",
                            });
                    
                            $(".unfollowuser_"+data.on_user).trigger("click");
                            $('#friend_<?php echo $current_id; ?>').remove();
                            $('#add-friend-btn').removeClass('btn-white');
                            $('#add-friend-btn').addClass('btn-gradient');
                            $('#add-friend-btn').html('<i class="fas fa-plus"></i> Add Friend</a>');
                            //load posts again
                            $('#showposts').empty();
                            load_posts_again();
                                
                        } else {
                            socket.emit('notification_get', {
                                "user_id": '<?= $user->id ?>',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your friend request',
                                "url": '<?= asset('profile_timeline/' . $user->id) ?>',
                                "friend_id": '<?= $user->id ?>',
                                "friend_name": '<?= $user->name ?>',
                                "friend_url": '<?= asset('profile_timeline/' . $current_id) ?>',
                                "unique_text": 'cancel_friend_request',
                                "friend_response":'3',
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                                "left_notification": "1",
                            });
                            $('#add-friend-btn').removeClass('btn-white');
                            $('#add-friend-btn').addClass('btn-gradient');
                            $('#add-friend-btn').html('<i class="fas fa-plus"></i> Add Friend</a>');
                            
                             <?php //if (!checkFollowing($user->id)) { ?>
                            <?php //} ?>
                        }
                    }
                }); 
                return false;
        }
        
        function sendMessage(otherid) {
            var message = $('#message' + otherid).val();
            if (message) {
                var data = new FormData();
                data.append('message', message);
                data.append('receiver_id', otherid);
                data.append('_token', '<?= csrf_token() ?>');
                $('#message' + otherid).val('');
                if (/\S/.test(message)) {
                    //                        var chat_message = '<li class="right"><div class="d-flex flex-row-reverse"><figure>' +
                    //                                '<span class="bg_image_round" onclick="location.href = \'<?= asset('profile_timeline/' . $current_id) ?>\'" style="background-image: url(<?php echo $current_photo ?>)"></span>' +
                    //                                '</figure><div class="chat_body"><div class="font-weight-bold text_darkblue text-right" style="cursor: pointer;" onclick="location.href = \'<?= asset('profile_timeline/' . $current_id) ?>\'"><?= $current_name ?></div>' +
                    //                                '<div class="chat_txt highlight">' + message + '</div>' +
                    //                                '<div class="font-13 text_grey text-right">Just Now</div>' +
                    //                                '</div></div> </li>';
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_message'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            $('#modal_search_messages' + otherid).modal('hide');
                            $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);

                            //                                    $('#attachment_loader').hide();
                            //                                    $('.tiny-div, .files_upload_box').hide();
                            result = JSON.parse(data);
                            //                                    $('.chat_box_wrapper .chat').append(result.append);
                            //                                    $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": result.other_message,
                                "chat_id": result.chat_id,
                                "message": message,
                                "chat_type": 'u',
                                "chat_type_id": result.chat_id,
                                "to_be_show": 'u'
                            });
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                "url": '<?= asset('messages/') ?>',
                                "chat_id": result.chat_id,
                                "chat_type": 'u',
                                "chat_type_id": result.chat_id,
                                "to_be_show": 'u'

                            });
                        }
                    });
                }
            }

        }
    </script>
<?php } ?>