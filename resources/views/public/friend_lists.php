<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body>     
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <?php include resource_path('views/includes/profile_cover_photo_section.php'); ?>
        <!-- cover photo -->
        <div class="page_timeline">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path(getProfileSidebarPath($user->type)); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <?php include resource_path('views/includes/profile_nav_tabs.php'); ?>
                        <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                            <div class="row w-100">
                                <div class="col-sm-8 ml-auto">
                                    
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="gigs" role="tabpanel" aria-labelledby="services">
                                <div class="all_friends">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase " id="title_of_list_type">All Friends</h4>
                                    <button class="btn btn_aqua btn-square font-weight-normal" data-target="#refer_modal" data-toggle="modal"> <i class="fas fa-plus"></i> Refer</button>
                                </div>
                                <div class="box mt-3" id="followers_list">
                                    <div class="container">
                                        <div class="row">
                                            <?php
                                                if(!empty($user->friends)){
                                                    foreach($user->friends as $friend) {
                                            ?>
                                            <div class="d-flex flex-column  search_result_box">
                                                <div>
                                                    <?php
                                                    $photo = getUserImage($friend->getFriendDetail->photo, $friend->getFriendDetail->social_photo, $friend->getFriendDetail->gender);
                                                    ?>
                                                    <a href="<?= asset('profile_timeline/' . $friend->id) ?>">
                                                        <div class="thumbnail" style="background-image: url('<?= $photo?>');width:100%;">
                                                            <img class="img-fluid" src="http://localhost/musician/userassets/images/place.png" style="position:relative;z-index:-1;">
                                                        </div>
                                                    </a>
                                                </div> <!-- image thumbnail -->
                                                <div class="w-100">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-12">
                                                            <a href="<?php echo asset('/profile_timeline/'.$friend->user_id) ?>" class="u_name">
                                                                <?= $friend->getFriendDetail->first_name. ' ' .$friend->getFriendDetail->last_name    //getUserName($friend->user_id)?>                                                                    </a>
                                                                <div class="profession">Accordion, Alto ...</div> <!-- profession -->
                                                                    <!-- <div>
                                                                    <i class="fas fa-graduation-cap"></i>
                                                                    <?php //if (!$friend->getFriendDetail->getEducations->isEmpty()) { ?>
                                                                        <?php //foreach ($friend->getFriendDetail->getEducations as $userEducation) { ?>   
                                                                            //$userEducation->title 
                                                                           //$userEducation->institute_name 
                                                                         //} 
                                                                    //} ?>
                                                                    </div> -->
                                                                
                                                                    <!-- <div>
                                                                    <i class="fas fa-briefcase"></i>
                                                                    <?php //if (!$friend->getFriendDetail->getExperiences->isEmpty()) { 
                                                                        //foreach ($friend->getFriendDetail->getExperiences as $userExperience) { 
                                                                                //$userExperience->title  //$userExperience->institute_name 
                                                                        //}
                                                                    //} ?>                                 
                                                                    </div> -->
                                                                    <!-- <div class="rating_reviews clearfix">
                                                                        <div class="star-ratings-sprite-gray">
                                                                            <span style="width: 0%;" class="star-ratings-sprite-rating"></span>
                                                                        </div>
                                                                        <span> -  //($friend->getFriendDetail->rating) ? $friend->getFriendDetail->rating : '0'  Reviews</span>
                                                                    </div> -->

                                                            </div> <!-- col -->
                                                        <div class="col-sm-5 text-right">
                                                        </div>
                                                    </div> <!-- row -->
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <i class="fa fa-map-marker-alt"></i> <span class="font-weight-bold">Location:</span><?php echo $friend->getFriendDetail->address;      ?>                      </div> <!-- col -->
                                                        <!-- <div class="col-md-6">
                                                            <i class="fa fa-globe"></i> <span class="font-weight-bold">Languages:</span> <?php echo $friend->getFriendDetail->language;      ?>                          
                                                        </div> -->
                                                         <!-- col -->
                                                    </div> <!-- row -->
                                                    <div class="w-100 follow_btns">
                                                        <div class="following_status text-center mt-4">
                                                            <a onclick="followUser('<?=$friend->user_id?>')" href="javascript:void(0)" class="btn btn-round btn-grey-outline btn_follow followuser_3 pl-2 pr-2 pt-2 pb-2"> Follow</a>
                                                            <a onclick="unfollowUser('<?=$friend->user_id?>')" href="javascript:void(0)" style="display: none" class="btn btn-round btn-grey-outline btn_unfollow unfollowuser_3 pl-2 pr-2 pt-2 pb-2">  Unfollow</a>
                                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $friend->user_id ?>" class="btn_message pl-2 pr-2 pt-2 pb-2"> Message</a>
                                                        </div> <!-- following buts -->
                                                    </div> <!-- col -->
                                                </div> <!-- right side -->
                                                <?php if (Auth::user()) { ?>
                                                    <!-- Message modal Start -->
                                                    <div class="modal fade" id="modal_search_messages<?= $friend->user_id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                                                        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $friend->getFriendDetail->first_name . ' ' . $friend->getFriendDetail->last_name; ?> </span></h6>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form>
                                                                        <div class="row">
                                                                            <div class="col-12">
                                                                                <div class="form-group">
                                                                                    <div class="custom-control custom-checkbox">
                                                                                        <!--<input type="checkbox" class="custom-control-input" name="custom_booking" id="lbl_custom_booking">-->
                                                                                        <!--<label class="custom-control-label font-weight-normal" for="lbl_custom_booking">Send as Broadcast message</label>-->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <select type="text" name="interests[]" class="form-control" id="bulk-messages<?=$friend->user_id?>" style="width: 100%" multiple="multiple">
                                                                                        <option selected="" value="<?=$friend->user_id?>"> <?= $friend->getFriendDetail->first_name . ' ' . $friend->getFriendDetail->last_name ?> </option>
                                                                                        <?php
                                                                                        foreach ($followings as $following) {
                                                                                            if ($following->id != $friend->user_id) {
//                                                                                                ?>
                                                                                                <option value="//<?= $following->id ?>"> <?= $following->first_name . ' ' . $following->last_name ?> </option>
                                                                                                <?php
                                                                                            }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                    <div class="font-14 text-danger text-right"></div>
                                                                                </div>
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold mb-2">Write a Message</label>
                                                                                    <textarea id="message<?=$friend->user_id?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                                                    <div class="font-14 text-danger text-right"></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- row -->
                                                                        <div class="mt-2 text-center">
                                                                            <button type="button" onclick="sendMessage('<?=$friend->user_id?>')" class="btn btn-gradient btn-round btn-xl text-semibold">Send</button>
                                                                        </div>
                                                                    </form>
                                                                </div> <!-- modal-body-->
                                                            </div> <!-- modal-content-->
                                                        </div>
                                                    </div> <!-- Edit Description modal -->
                                                    <!--  Message modal END -->
                                                <?php } ?>
                    <script>
                        $('#bulk-messages<?=$friend->user_id?>').select2({
                            allowClear: true,
                            width: 'resolve',
                            minimumResultsForSearch: Infinity,
                            //                    placeholder: "Select Interests",
                        });

                    </script>
                    <?php if ($current_user) { ?>
                        <script>
                            function sendMessage(otherid) {
                                var message = $('#message' + otherid).val();
                                if (message) {
                                    recivers = $('#bulk-messages' + otherid).val();
                                    counter = 0;
                                    $.each(recivers, function (index, item) {

                                        var data = new FormData();
                                        data.append('message', message);
                                        data.append('receiver_id', item);
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
                                                success: function (data) {
                                                    $('#modal_search_messages' + otherid).modal('hide');
                                                    counter++;
                                                    if (counter == 1) {
                                                        $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                                                    }
                                                    //                                    $('#attachment_loader').hide();
                                                    //                                    $('.tiny-div, .files_upload_box').hide();
                                                    result = JSON.parse(data);
                                                    //                                    $('.chat_box_wrapper .chat').append(result.append);
                                                    //                                    $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                                    socket.emit('message_get', {
                                                        "user_id": item,
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
                                                        "user_id": item,
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
                                    })
                                }
                            }

                        </script>
                    <?php } ?>
                                            </div> <!-- search_result_box -->
                                            
                                            <?php
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div id="js-pg-msg"></div>
                            </div>
                        </div> <!-- inner tab content -->

                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page_timeline -->
    </div> <!-- page timeline -->
    <?php if (Auth::guard('user')->check()) { ?>
        <div class="show_on_mobile clearfix">
            <?php include resource_path('views/includes/sidebar.php'); ?>
        </div>
    <?php } ?>
    <?php include resource_path('views/includes/footer.php'); ?>  

</body>
</html>


