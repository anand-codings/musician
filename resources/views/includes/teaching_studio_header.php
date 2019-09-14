<div class="new_profile">
<div class="container">
<div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
    <div class="overlay_color">
       
            <div class="row">
                <div class="col-lg-2 col-md-3 text-center align-items-center align-self-center">
                    <div class="edit_user_profile_pic">
                        <?php
                        $pic = asset('public/images/profile_pics/demo.png');
                        if ($studio->pic) {
                            $pic = asset('public/images/' . $studio->pic);
                        }
                        ?>
                        <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                    </div>
                    
                </div> <!-- col -->

                <div class="col-lg-5 col-md-5">
                    <div class="profile_public_info">
                        <div class="profile_name">
                            <h2><?= $studio->name ?></h2>
                        </div>       
                        <div class="rating_reviews clearfix">
                            <div class="star-ratings-sprite">
                                <span style="width: <?= $studio->rating_percentage ? $studio->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                            </div>
                            <span class="reviews text_grey">(<?= $studio->number_of_reviews ? $studio->number_of_reviews : '0' ?> Reviews)</span>
                        </div>
                        <div class="followings_number text-white">
                            <a href="<?= asset('get_service_followers/s/' . $studio->id) ?>" class="text-white"> <?= getFollowingCount('s', $studio->id, 'studio_id') ?> Followers </a>
                        </div>
                        
                    </div>
                </div>
                <div class="col-lg-5 col-md-4">
                    <div class="public_profile_btns top_profile_btns mt-3 d-flex justify-content-center">
                            <?php if (Auth::user() && Auth::user()->id != $studio->admin_id) { ?>
                                <a <?php if (checkServiceFollowing('s', $studio->id, 'studio_id')) { ?> style="display: none" <?php } ?> id="follow_s_<?= $studio->id ?>" onclick="followService('s',<?= $studio->id ?>, '<?= $studio->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Follow</a>
                                <a <?php if (!checkServiceFollowing('s', $studio->id, 'studio_id')) { ?> style="display: none" <?php } ?> id="unfollow_s_<?= $studio->id ?>"   onclick="unfollowService('s',<?= $studio->id ?>, '<?= $studio->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline"> <i class="s_icon ic_follow"></i> Unfollow</a>
                                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $studio->admin_id; ?>"class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
                            <?php } ?>
                            <?php
                            if (Auth::user() && $studio->admin_id != Auth::user()->id){
                                if ($studio->allow_booking) {
                                        ?>
                                        <div class="mt-3">
                                            <a href="#" data-toggle="modal" data-target="#booknow" class="btn btn btn-white btn-lg"> Book Now </a>
                                        </div>
                                        <?php
                                } 
                                        ?>
                                <div class="mt-3 append-request-<?=$studio->id?>">
                                <?php
                                    if($studio->checkMember){
                                        if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'teachere' && $studio->checkMember->is_approved=='1'){
                                            $teacher_txt = 'Joined as a Teacher';
                                            ?>
                                            <a href="javascript:void(0)" id="join_as_teacher" onclick="joinAsTeacher(<?=$studio->id?>,'leave','teachere')" class="btn btn btn-white"><i class="fas fa-minus"></i> Joined as Teacher</a>
                                        <?php
                                        } else if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'teachere' && $studio->checkMember->is_approved=='0' && $studio->checkMember->is_rejected=='0'){
                                            $teacher_txt = 'Cancel Request for Teacher';
                                        ?>
                                            <a href="javascript:void(0)" id="join_as_teacher" onclick="joinAsTeacher(<?=$studio->id?>,'leave','teachere')" class="btn btn btn-white"><i class="fas fa-minus"></i> Cancel Request for Teacher</a>
                                        <?php
                                        } else if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'user' && $studio->checkMember->is_approved=='1'){
                                        ?>
                                            <a href="javascript:void(0)" id="join_as_student" onclick="joinAsStudent(<?=$studio->id?>,'leave','user')" class="btn btn btn-white"><i class="fas fa-minus"></i> Joined</a>
                                        <?php
                                        } else if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'user' && $studio->checkMember->is_approved=='0'){
                                            $student_txt = 'Cancel Request for Student';
                                            ?>
                                            <a href="javascript:void(0)" id="join_as_student" onclick="joinAsStudent(<?=$studio->id?>,'leave','user')" class="btn btn btn-white"><i class="fas fa-minus"></i> Cancel Request</a>
                                        <?php
                                        }
                                    } else {
                                         $teacher_txt = 'Join as a Teacher';
                                         ?>
                                         <a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i> Join</a>                                       
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
                <?php if ($studio->allow_booking) { ?>
                    <?php if (Auth::user() && Auth::user()->type == 'user') { ?>
                        <div class="custom_booking_side">
                            <h3 class="font-22 text-center text-uppercase mb-3 font-weight-bold text_darkblue">Book the Teaching Studio</h3>
                            <h5 id="booking_error_custom" class="alert alert-danger" style="display: none"></h5>
                            <h5 id="booking_success_custom" class="alert alert-success" style="display: none"></h5>   
                            <?php
                            $book_now = '';
                            if (Auth::user()) {
                                if (!Auth::user()->stripe_id) {
                                    $book_now = 1;
                                    ?>
                                    <h5 class="alert alert-info">Please Add Card To Book This Teaching Studio</h5>
                                    <?php
                                }
                            } else {
                                $book_now = 1;
                                ?> 
                                <h5 class="alert alert-info">Please Login To Book This Teaching Studio</h5>
                            <?php } ?>
                            <form class="book_group_form" id="group_booking_validation" method="post" action="<?= asset('add_group_booking') ?>">
                                <div class="form-group">
                                    <label>First & Last Name</label>
                                    <input id="name" required name="name" type="text" placeholder="John Doe" value="<?= $current_name ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Your Email</label>
                                    <input id="email" name="email" required type="email" placeholder="johndoe@email.com" value="<?= $current_email ?>" class="form-control">
                                </div>
                                <!--                                <div class="form-group">
                                                                    <label>Event Name</label>
                                                                    <input type="text" name="event_name" required id="event_name" placeholder="Wedding, birthday or anniversaries" class="form-control">
                                                                </div>-->
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
                                } else if (!$book_now && $studio->allow_booking) {
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
<div class="modal fade" id="modal_search_messages<?= $studio->admin_id; ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $studio->name; ?> </span></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                <textarea id="message<?= $studio->admin_id; ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                            </div>
                        </div>
                    </div> <!-- row -->
                    <div class="mt-2">
                        <button type="button" onclick="sendMessage('<?= $studio->admin_id; ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                    </div>
                </form>                        
            </div> <!-- modal-body-->
        </div> <!-- modal-content-->
    </div>
</div> <!-- Edit Description modal -->

<?php
if($studio->checkMember){
 if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'teachere' && $studio->checkMember->is_approved=='1'){
     $teacher_txt = 'Joined as a Teacher';
 } else if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'teachere' && $studio->checkMember->is_approved=='0'){
     $teacher_txt = '<i class="fas fa-minus"></i> Cancel Request for Teacher';
 } else {
     $teacher_txt = 'Join as a Teacher';
}
} else {
     $teacher_txt = 'Join as a Teacher';
}

if($studio->checkMember){
 if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'user' && $studio->checkMember->is_approved=='1'){
     $student_txt = 'Joined as a Student';
 } else if ($studio->checkMember->user_id == $current_id && $studio->checkMember->user_type == 'user' && $studio->checkMember->is_approved=='0'){
     $student_txt = '<i class="fas fa-minus"></i> Cancel Request for Student';
 } else {
     $student_txt = 'Join as a Student';
}
} else {
     $student_txt = 'Join as a Student';
}
?>

<!-- Message modal Start -->
<div class="modal fade" id="joinmember" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title text-black" id="exampleModalLabel">Join <span class="text_maroon"> <?= $studio->name; ?> </span></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-0">
                                 <div class="mt-3">
                                            <a href="javascript:void(0)" id="join_as_teacher" onclick="joinAsTeacher(<?=$studio->id?>,'join','teachere')" class="btn btn btn-gradient"><?=$teacher_txt?> </a>
                                        </div>
                                        <div class="mt-3">
                                            <a href="javascript:void(0)" id="join_as_student" onclick="joinAsStudent(<?=$studio->id?>,'join','user')" class="btn btn btn-gradient">  <?= $student_txt?> </a>
                                        </div>
                            </div>
                        </div>
                    </div> <!-- row -->
                    
                </form>                        
            </div> <!-- modal-body-->
        </div> <!-- modal-content-->
    </div>
</div> <!-- Edit Description modal -->

<!--  Message modal END -->
<?php if ($current_user) { ?>
    <?php include resource_path('views/includes/services_functions.php'); ?>
    <script>
        
         function joinAsStudent(id, status, type){
                var data = new FormData();
                data.append('studio_id', id);
                data.append('status', status);
                data.append('type', type);
                data.append('_token', '<?= csrf_token() ?>');
                if(status == 'join'){
                    var status_new = 'leave';
                    var click_function = 'joinAsStudent(' + id  + ",'cancel','user'"+')';
                } else {
                    var status_new = 'join';
                    var click_function = 'joinAsStudent(' + id  + ",'join','user'"+')';
                }
                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('join_studio_member'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(status == 'join'){
//                            $('.students_list').find('ul').append('<li><a href="<?php //echo asset('/profile_timeline/'.$current_id) ?>"><img src="<?php// echo asset('public/images/'.$current_photo) ?> "></a></li>');
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_as_student" onclick='+click_function+' class="btn btn btn-white"><i class="fas fa-minus"></i> Cancel Request</a>');
                            $('#join_studio_id').remove();
                            $('#join_as_student').html('<i class="fas fa-minus"></i> Cancel Request</a>');
                            $("#join_as_student").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
                            
                            socket.emit('notification_get', {
                                "user_id": data.notification.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' wants to join your studio "<?= $studio->name ?>"',
                                "url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "studio_id": '<?= $studio->id ?>',
                                "studio_name": '<?= $studio->name ?>',
                                "type" : type,
                                "studio_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                            });
                    
                        } else if(status == 'leave'){
                        
                            socket.emit('notification_get', {
                                "user_id": <?= $studio->admin_id; ?>,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' left your studio "<?= $studio->name ?>"',
                                "url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "studio_id": '<?= $studio->id ?>',
                                "studio_name": '<?= $studio->name ?>',
                                "type" : type,
                                "request_approve": '2',
                                "studio_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": '<?php echo $current_id; ?>_left_studio_<?= $studio->id ?>',
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                                "left_notification":'1'
                            });
                            $("#post_box_studio_<?= $studio->id ?>").hide();
                            $("#unfollow_s_<?=$studio->id?>").trigger("click");
                            $('#studio-student-<?php echo $current_id; ?>').remove();
                            $('.append-request-'+id).find('#join_as_student').remove();
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i>Join</a>');                            
                            $('#join_as_student').html('Join as Student</a>');
                            $("#join_as_student").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
                            $('#showposts').empty();
                            load_posts_again();
                            
                        } else{
                            
                            $('.append-request-'+id).find('#join_as_student').remove();
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i>Join</a>');                            
                            $('#join_as_student').html('Join as Student</a>');
                            $("#join_as_student").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
                        }
                    }
                }); 
                return false;
            }
            
            
            function joinAsTeacher(id,status,type){
                var data = new FormData();
                data.append('studio_id', id);
                data.append('status', status);
                data.append('type', type);
                data.append('_token', '<?= csrf_token() ?>');
                if(status == 'join'){
                    var status_new = 'leave';
                    var click_function = 'joinAsTeacher(' + id  + ",'cancel','teachere'"+')';
                } else {
                    var status_new = 'join';
                    var click_function = 'joinAsTeacher(' + id  + ",'join','teachere'"+')';
                }
                    
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('join_studio_member'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        if(status == 'join'){
//                            $('.teachers_list').find('ul').append('<li><a href="<?php// echo asset('/profile_timeline/'.$current_id) ?>"><img src="<?php //echo asset('public/images/'.$current_photo) ?> "></a></li>');
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_as_teacher" onclick='+click_function+' class="btn btn btn-white"><i class="fas fa-minus"></i>Cancel Request</a>');
                            $('#join_studio_id').remove();
                            $('#join_as_teacher').html('<i class="fas fa-minus"></i> Cancel Request as Teacher</a>');
                            $("#join_as_teacher").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
                            
                            socket.emit('notification_get', {
                                "user_id": data.notification.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' wants to join your studio "<?= $studio->name ?>" as a teacher.',
                                "url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "studio_id": '<?= $studio->id ?>',
                                "studio_name": '<?= $studio->name ?>',
                                "type" : type,
                                "studio_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                            });
                    
                        } else if(status == 'leave'){
                            socket.emit('notification_get', {
                                "user_id": <?= $studio->admin_id; ?>,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' left your studio "<?= $studio->name ?>"',
                                "url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "studio_id": '<?= $studio->id ?>',
                                "studio_name": '<?= $studio->name ?>',
                                "type" : type,
                                "request_approve": '2',
                                "studio_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": '<?php echo $current_id; ?>_left_studio_<?= $studio->id ?>',
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                                "left_notification":'1'
                            });
                            $("#post_box_studio_<?= $studio->id ?>").hide();
                            $("#unfollow_s_<?=$studio->id?>").trigger("click");
                            $('#studio-teacher-<?=$current_id?>').remove();
                            $('.append-request-'+id).find('#join_as_teacher').remove();
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i>Join</a>');                            
                            $('#join_as_teacher').html('Join as Teacher</a>');
                            $("#join_as_teacher").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
                            $('#showposts').empty();
                            load_posts_again();
                        } else {
//                            $('#join_studio_id').show();
//                            $('.append-request').children('#join_as_teacher').remove();
//                            $('#join_studio_id').html('Join');
                            $('.append-request-'+id).find('#join_as_teacher').remove();
                            $('.append-request-'+id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i>Join</a>');                            
                            $('#join_as_teacher').html('Join as Teacher</a>');
                            $("#join_as_teacher").attr("onclick",click_function);
                            $('#joinmember').modal('hide');
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
                data.append('message_type', 's');
                data.append('type_id', '<?= $studio->id ?>');
                $('#message' + otherid).val('');
                if (/\S/.test(message)) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_message'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#modal_search_messages' + otherid).modal('hide');
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
                                "chat_type": 's',
                                "chat_type_id": '<?= $studio->id ?>',
                                "to_be_show": 's'
                            });
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                "url": '<?= asset('messages/') ?>',
                                "chat_id": result.chat_id,
                                "chat_type": 's',
                                "chat_type_id": '<?= $studio->id ?>',
                                "to_be_show": 's'

                            });
                        }
                    });
                }
            }

        }
    </script>
<?php } ?>