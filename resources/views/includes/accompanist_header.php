<div class="new_profile">
<div class="container">
<div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
    <div class="overlay_color">
       
            <div class="row">
                <div class="col-lg-2 col-md-3 text-center align-items-center align-self-center">
                    <div class="edit_user_profile_pic">
                        <?php
                        $pic = asset('public/images/profile_pics/demo.png');
                        if ($accompanist->pic) {
                            $pic = asset('public/images/' . $accompanist->pic);
                        }
                        ?>
                        <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                    </div>
                    <!-- <div class="public_profile_btns mt-3 d-flex justify-content-center">
                        <?php if (Auth::user() && Auth::user()->id != $accompanist->admin_id) { ?>
                            <a <?php if (checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="follow_a_<?= $accompanist->id ?>" onclick="followService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Follow</a>
                            <a <?php if (!checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="unfollow_a_<?= $accompanist->id ?>"   onclick="unfollowService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Unfollow</a>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages_acc<?= $accompanist->admin_id; ?>"class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
                        <?php } ?>
                    </div>    -->
                </div> <!-- col -->

                <div class="col-lg-5 col-md-5">
                    <div class="profile_public_info">
                        <div class="profile_name">
                            <h2><?= $accompanist->name ?></h2>
                        </div>       
                        <div class="rating_reviews clearfix">
                            <div class="star-ratings-sprite">
                                <span style="width: <?= $accompanist->rating_percentage ? $accompanist->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                            </div>
                            <span class="reviews text_grey">(<?= $accompanist->number_of_reviews ? $accompanist->number_of_reviews : '0' ?> Reviews)</span>
                        </div>
                        <div class="followings_number text-white">
                                <a href="<?= asset('get_service_followers/a/'.$accompanist->id)?>" class="text-white"> <?= getFollowingCount('a', $accompanist->id, 'accompanist_id')?> Followers </a>
                            </div>
                        <?php
                        // if ($accompanist->allow_booking) {
                        //     if (Auth::user() && Auth::user()->type == 'user') {
                        //         ?>
                             <!-- <div class="mt-3">
                                   <a href="#" data-toggle="modal" data-target="#booknow" class="btn btn btn-white btn-lg"> Book Now </a> 
                              </div> -->
                                 <?php
                        //     }
                        // }
                        ?>
                    </div>
                </div>
                <div class="col-lg-5 col-md-4">
                <div class="public_profile_btns top_profile_btns mt-3 d-flex justify-content-center">
                        <?php if (Auth::user() && Auth::user()->id != $accompanist->admin_id) { ?>
                            <a <?php if (checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="follow_a_<?= $accompanist->id ?>" onclick="followService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Follow</a>
                            <a <?php if (!checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="unfollow_a_<?= $accompanist->id ?>"   onclick="unfollowService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Unfollow</a>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages_acc<?= $accompanist->admin_id; ?>"class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
                        <?php } ?>
                        <?php
                        if ($accompanist->allow_booking) {
                            if (Auth::user() && Auth::user()->type == 'user') {
                                ?>
                                <div class="mt-3">
                                    <a href="#" data-toggle="modal" data-target="#booknow" class="btn btn btn-white btn-lg"> Book Now </a>
                                </div>
                                <?php
                            }
                        }
                        
                        if (Auth::user() && $accompanist->admin_id != Auth::user()->id){
                        ?>
                            <div class="mt-3 append-request-accompanist-<?=$accompanist->id?>">
                                <?php
                            if(!empty($accompanist->checkMember)){
                                if( $accompanist->checkMember->is_approved=='1'){
                                ?>
                                    <a href="javascript:void(0)" id="accompanist-request-id" onclick="addAccompanistMember(<?=$accompanist->admin_id?>,<?=$accompanist->id?>, 'leave')" class="btn btn-white"> <i class="fas fa-minus"></i> Joined</a>
                                <?php
                                } else if( $accompanist->checkMember->is_approved=='0') {
                                ?>
                                    <a href="javascript:void(0)" id="accompanist-request-id" onclick="addAccompanistMember(<?=$accompanist->admin_id?>,<?=$accompanist->id?>, 'leave')" class="btn btn-white"> <i class="fas fa-minus"></i> Cancel Request</a>
                                <?php
                                }                                          
                            }
                            else {
                            ?>
                                <a href="javascript:void(0)" id="accompanist-request-id" onclick="addAccompanistMember(<?=$accompanist->admin_id?>,<?=$accompanist->id?>, 'join')" class="btn btn-gradient"> <i class="fas fa-plus"></i> Join as Accompanist</a>
                            <?php
                            } 
                            ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>   
                </div>
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- overlay color -->
</div> <!-- cover photo -->
                    </div>
<!--Modal-->
<div class="modal fade" id="booknow" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Book the Event Service</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?php
                if ($accompanist->allow_booking) {
                    if (Auth::user() && Auth::user()->type == 'user') {
                        ?>
                        <div class="custom_booking_side">
                            <h3 class="font-22 text-center text-uppercase mb-3 font-weight-bold text_darkblue">Book the Accompanist</h3>
                            <h5 id="booking_error_custom" class="alert alert-danger" style="display: none"></h5>
                            <h5 id="booking_success_custom" class="alert alert-success" style="display: none"></h5>   
                            <?php
                            $book_now = '';
                            if (Auth::user()) {
                                if (!Auth::user()->stripe_id) {
                                    $book_now = 1;
                                    ?>
                                    <h5 class="alert alert-info">Please Add Card To Book This Accompanist</h5>
                                    <?php
                                }
                            } else {
                                $book_now = 1;
                                ?> 
                                <h5 class="alert alert-info">Please Login To Book This Accompanist</h5>
        <?php } ?>
                            <form class="book_group_form" id="group_booking_validation" method="post" action="<?= asset('add_booking') ?>">
                                <div class="form-group">
                                    <label>First & Last Name</label>
                                    <input id="name" required name="name" type="text" placeholder="John Doe" value="<?= $current_name ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Your Email</label>
                                    <input id="email" name="email" required type="email" placeholder="johndoe@email.com" value="<?= $current_email ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Location</label>
                                    <input id="location" name="location" required type="text" placeholder="Enter Location" class="form-control autofill_location">
                                </div>
                                <div class="form-group">
                                    <label>Date</label>
                                    <div class="d-flex">
                                        <input id="date" name="date" required readonly="" type="text" placeholder="Date" class="form-control mr-2 date-picker">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>Hours offering</label>
                                    <input id="hours_offering" name="hours_offering" required type="number" placeholder="0:00" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Price offering</label>
                                    <input id="price" name="price" required type="number" placeholder="$$$" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="description" name="description" required placeholder="Enter Description" class="form-control"></textarea>
                                </div>

        <?php if (!$current_user) { ?>
                                    <div class="form-group text-center mt-4">
                                        <input onclick="window.location.href = '<?= asset('login') ?>'" type="button" value="Submit" class="btn btn-round btn_aqua btn-xl">
                                    </div>
                                    <?php
                                } else if (!$book_now && $accompanist->allow_booking) {
                                    if ($current_id != $user_id_current) {
                                        ?>
                                        <div class="form-group text-center mt-4">
                                            <input type="submit" value="Submit" class="btn btn-round btn_aqua btn-xl">
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </form>
                        </div>
                    <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
<!-- Message modal Start -->
    <div class="modal fade" id="modal_search_messages_acc<?= $accompanist->admin_id; ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $accompanist->name; ?> </span></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <textarea id="message<?= $accompanist->admin_id; ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2">
                            <button type="button" onclick="sendMessage('<?= $accompanist->admin_id; ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                        </div>
                    </form>                        
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Description modal -->
    <!--  Message modal END -->
<?php if ($current_user) { ?>
    <?php include resource_path('views/includes/services_functions.php'); ?>
    <script>
        
            function addAccompanistMember(accompanist_admin_id, accompanist_id, status){
                    var data = new FormData();
                    data.append('accompanist_admin_id', accompanist_admin_id);
                    data.append('accompanist_id', accompanist_id);
                    data.append('_token', '<?= csrf_token() ?>');
                    data.append('status', status);
                    if(status == 'join'){
                        var status_new = 'leave';
                        var click_function = 'addAccompanistMember(' + accompanist_admin_id + ','+ accompanist_id + ",'cancel'"+')';
                    } else {
                        var status_new = 'join';
                        var click_function = 'addAccompanistMember(' + accompanist_admin_id + ','+ accompanist_id + ",'join'" +')';
                    }
                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_accompanist_member'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $("#accompanist-request-id").attr("onclick",click_function);
                        if(status == 'join'){
                            $('#accompanist-request-id').removeClass('btn-gradient');
                            $('#accompanist-request-id').addClass('btn-white');
                            $('#accompanist-request-id').html('<i class="fas fa-minus"></i> Cancel Request</a>');
                            
                            socket.emit('notification_get', {
                                "user_id": data.notification.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' wants to join your Accompanist <?= $accompanist->name ?>.',
                                "url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "accompanist_id": '<?= $accompanist->id ?>',
                                "accompanist_name": '<?= $accompanist->name ?>',
                                "accompanist_url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                            });
                        } else if(status == 'leave'){
                            socket.emit('notification_get', {
                                "user_id": data.admin_id,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' leaves your Accompanist <?=$accompanist->name?>.',
                                "url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "accompanist_id": '<?= $accompanist->id ?>',
                                "accompanist_name": '<?= $accompanist->name ?>',
                                "request_approve": '2',
                                "accompanist_url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "unique_text": 'user<?php echo $current_id; ?>_leaves_accompanist_<?= $accompanist->id ?>',
                                "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                                "left_notification" : '1',
                            });
                            $('#accompanist_members_count').html(parseInt($('#accompanist_members_count').html(), 10) - 1);
                            $("#post_box_accompanist_<?= $accompanist->id ?>").hide();
                            $('#accompanist_messages_li').hide();
                            $("#unfollow_a_<?= $accompanist->id ?>").trigger("click");
                            $('#accompanist-mem-<?=$current_id?>').remove();
                            $('#accompanist-request-id').removeClass('btn-white');
                            $('#accompanist-request-id').addClass('btn-gradient');
                            $('#accompanist-request-id').html('<i class="fas fa-plus"></i> Join Accompanist</a>');
                            $('#showposts').empty();
                            load_posts_again();
                            
                        } else {
                            socket.emit('notification_get', {
                                "user_id": data.admin_id,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' cancels his request for Accompanist <?= $accompanist->name ?>.',
                                "url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "accompanist_id": '<?= $accompanist->id ?>',
                                "accompanist_name": '<?= $accompanist->name ?>',
                                "request_approve": '2',
                                "accompanist_url": '<?= asset('accompanist_time_line/' . $accompanist->id) ?>',
                                "unique_text": 'user<?php echo $current_id; ?>_leaves_accompanist_<?= $accompanist->id ?>',
                                "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                                "left_notification" : '1',
                            });
                            $('#accompanist_members_count').html(parseInt($('#accompanist_members_count').html(), 10) - 1);
                            $('#accompanist_messages_li').hide();
                            $('#accompanist-mem-<?=$current_id?>').remove();
                            $('#accompanist-request-id').removeClass('btn-white');
                            $('#accompanist-request-id').addClass('btn-gradient');
                            $('#accompanist-request-id').html('<i class="fas fa-plus"></i> Join Accompanist</a>');
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
                data.append('message_type', 'a');
                data.append('type_id', '<?= $accompanist->id ?>');
                $('#message' + otherid).val('');
                if (/\S/.test(message)) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_message'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#modal_search_messages_acc' + otherid).modal('hide');
                            $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                            result = JSON.parse(data);
                            $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": result.other_message,
                                "chat_id": result.chat_id,
                                "message": message,
                                "chat_type": 'a',
                                "chat_type_id": '<?= $accompanist->id ?>',
                                "to_be_show": 'a'
                            });
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                "url": '<?= asset('messages/') ?>',
                                "chat_id": result.chat_id,
                                "chat_type": 'a',
                                "chat_type_id": '<?= $accompanist->id ?>',
                                "to_be_show": 'a'

                            });
                        }
                    });
                }
            }

        }
    </script>
<?php } ?>