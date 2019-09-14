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
        <div class="sidebar show_on_mobile">
            <?php include resource_path('views/includes/sidebar.php'); ?>
        </div>

        
        <?php
        $chat_type = 'a';
        $type_id = '';
        $accompanist_type_id = '';
        if ($latest_chat && $latest_chat->type == 'g') {
//            $chat_type = 'g';

        } if ($latest_chat && $latest_chat->type == 'a') {
//            $chat_type = 'a';
            $accompanist_type_id = $latest_chat->type_id;
            $type_id = $latest_chat->id;
           
        } if ($latest_chat && $latest_chat->type == 's') {
//            $chat_type = 's';
//            $type_id = $latest_chat->studio_id;
        } if ($latest_chat && $latest_chat->type == 'u') {
//            $chat_type = 'u';
        }
        
        ?>
        <input type="hidden" name="other_user_chat_id" id="other_user_chat_id" value="<?=$current_id?>">
        <input type="hidden" name="group_chat_id" id="group_chat_id" value="<?= $type_id ?>">
        <input type="hidden" name="group_id" id="group_id" value="<?= $accompanist_type_id ?>">
        <input type="hidden" name="accompanist_id" id="accompanist_id" value="<?= $accompanist->id ?>">
        <input type="hidden" id="chat_type" value="<?= $chat_type ?>">
        <input type="hidden" id="chat_type_id" value="<?= $type_id ?>">
        <div class="chat_page">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-4">
                        <div class="chat_usersidebar_wrap">
                            <div class="chat_alluser_wrap">
                                <div class="head d-flex">
                                    <div>
                                        <h5 class="font-weight-bold text_darkblue">Accompanist Messages
                                            <span class="new_messages_label"><span><?php echo  $unread ?></span> New</span>
                                        </h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="new_chat_btn">
                                            <i data-toggle="modal" data-target="#modal_friends_message" class="fa fa-edit"></i>
                                        </span>
                                    </div>
                                </div>
                                <!-- Followers modal Start -->
                                <div class="modal fade" id="followers_modal" tabindex="-1" role="dialog" aria-labelledby="followers_modal" aria-hidden="true">
                                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                                        <div class="modal-content edit-event-popup">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="create_gig_modal">Start new chat</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div> <!-- modal header -->
                                            <div class="modal-body">
                                                <ul class="followers_list un_style">
                                                    <?php
                                                    if (count($not_chated) > 0) {
                                                        foreach ($not_chated as $ntchated) {
                                                            $photo = getUserImage($ntchated->photo, $ntchated->social_photo, $ntchated->gender);
                                                            ?>
                                                            <li>
                                                                <div class="media align-items-center">
                                                                    <img src="<?= $photo ?>" alt="profile pic" class="rounded-circle">
                                                                    <div class="media-body">
                                                                        <div class="d-flex flex-column flex-sm-row">
                                                                            <div class="mb-2">
                                                                                <a href="#" class="u_name"><?= $ntchated->first_name . ' ' . $ntchated->last_name; ?></a>
                                                                                <div class="profession"><?php
                                                                                    if (!$ntchated->getSelectedCategories->isEmpty()) {
                                                                                        $getSelectedArtistTypesCount = $ntchated->getSelectedCategories->count();

                                                                                        if ($getSelectedArtistTypesCount <= 2) {
                                                                                            $i = 1;
                                                                                            foreach ($ntchated->getSelectedCategories as $selectedArtistType) {
                                                                                                echo $selectedArtistType->getCategory->title;
                                                                                                if ($getSelectedArtistTypesCount > $i)
                                                                                                    echo ', ';
                                                                                                $i++;
                                                                                            }
                                                                                        } else {
                                                                                            $i = 1;
                                                                                            foreach ($ntchated->getSelectedCategories as $selectedArtistType) {
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
                                                                                    <?php } ?></div>
                                                                            </div>
                                                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                                                <div class="following_status">
                                                                                    <a onclick="hideModal('followers_modal', 'modal_new_messages<?= $ntchated->id ?>')" href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div> <!-- media body -->
                                                                </div> <!-- media-->
                                                            </li>


                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <li>No Record Found</li>     
                                                    <?php } ?>
                                                </ul> <!-- followers list -->
                                            </div> <!-- modal body -->
                                        </div> <!-- modal content -->
                                    </div>
                                </div>


                                <!-- Followers modal END -->
                                <?php foreach ($not_chated as $ntchated) { ?>
                                    <!-- Message modal Start -->
                                    <div class="modal fade" id="modal_new_messages<?= $ntchated->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $ntchated->first_name . ' ' . $ntchated->last_name; ?> </span></h6>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="form-group mb-0">
                                                                    <textarea id="message<?= $ntchated->id ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                                </div>
                                                            </div>
                                                        </div> <!-- row -->
                                                        <div class="mt-2">
                                                            <button type="button" onclick="sendMessagePopUp('<?= $ntchated->id ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                                                        </div>
                                                    </form>                        
                                                </div> <!-- modal-body-->
                                            </div> <!-- modal-content-->
                                        </div>
                                    </div> <!-- Edit Description modal -->
                                    <!--  Message modal END -->
                                <?php } ?>
                                <div class="online-users-stat">
                                    <?php

                                    $online_count = 0;
                                    if(!empty($groupchats)){
                                        foreach ($groupchats as $g_chat) {

                                            if ($g_chat->type == 'u') {
                                                $other_user = $g_chat->receiver;
                                                if ($g_chat->sender_id != $current_id) {
                                                    $other_user = $g_chat->sender;
                                                }
                                                $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                                if ($other_user->is_online == 1) {
                                                    $online_count++;
                                                }
                                            }
                                        }
                                    }
                                    ?>  
                                    <!--<p>Online Groups <span>( // $online_count )</span></p>-->
                                </div>
                                <div class="online-users-wrapper">
                                    <ul class="online-users-list d-flex ">
                                        <?php
//                                        foreach ($groupchats as $g_chat) {
//                                            if ($g_chat->type == 'u') {
//                                                $other_user = $g_chat->receiver;
//                                                if ($g_chat->sender_id != $current_id) {
//                                                    $other_user = $g_chat->sender;
//                                                }
//                                                $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
//                                                if ($other_user->is_online == 1) {
//                                                    $name = 'Private User';
//                                                    $profile_url = '#';
//                                                    if ($other_user->is_active) {
//                                                        $name = $other_user->first_name . ' ' . $other_user->last_name;
//                                                        $profile_url = asset('profile_timeline/' . $other_user->id);
//                                                    }
//                                                    ?>
                                                    <!--<li id="check_if_online_//<?php // echo $other_user->id; ?>" onclick="getOtherChat('chat_id_<?php // echo $g_chat->id ?>', this, '<?php //$g_chat->id ?>', '<?php // $name ?>', '<?php // $other_user->id ?>', '<?php // $profile_url ?>', '<?php// echo $other_image ?>', '0', '10', '<?php // $other_user->is_active ?>', 'u', '')"><span class="bg_image_round user_active_status" style="background-image: url(<?php // echo $other_image ?>) "><span class="active"></span></span></li>-->
                                                    <?php
//                                                }
//                                            }
//                                        }
                                        ?>  
                                    </ul>
                                </div>
                            </div>
                            <div class="chat_list_wrap">
                                <div class="search_user d-flex">
                                    <div class="user_search_field">
                                        <input id="filter_chat_users" type="text" placeholder="Search messages..." />
                                        <span class="user_search_icon"></span>
                                    </div>
                                    <div class="delete_btn_wrap">
                                        <a href="#" class="delete_btn d-flex align-items-center">
                                            <span class="icon-delete"></span>
                                            Delete
                                        </a>
                                    </div>
                                </div>
                                <div class="chat_user_list">
                                    <ul class="chat_listing" id="chat_user_filter_listing">
                                        <?php
                                        $i = 0;
                                        if(!empty($groupchats)){
                                            foreach ($groupchats as $g_chat) {
                                           
                                            $i++;
//                                            $other_user = $chat->receiver;
//                                            if ($chat->sender_id != $current_id) {
//                                                $other_user = $chat->sender;
//                                            }
                                            $name = $g_chat->title;
                                            $profile_url = '#';
//                                            if ($other_user->is_active) {
//                                                $name = $other_user->first_name . ' ' . $other_user->last_name;
//                                                $profile_url = asset('profile_timeline/' . $other_user->id);
//                                            }
//                                            $chat_type_sidebar = 'u';
                                            $chat_type_id_siderbar = $g_chat->id;
//                                            $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
//                                            if ($other_user->is_active && $chat->chat_type == 'g') {
                                                $chat_type_sidebar = 'a';
                                                $other_user_imgs = $g_chat->receiver;
                                                $other_images=[];
                                                foreach ($other_user_imgs as $key => $value) {
                                                    if ($key == 3) {
                                                        break;
                                                    } else {

                                                        $other_images[$key] = getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);
                                                        if ($key == 0) {
                                                            $js_images_string = getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);
                                                        } else {
                                                            $js_images_string = $js_images_string . ',' . getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);
                                                        }

                                                    }

                                                }
//                                                $chat_type_id_siderbar = $chat->group->id;
//                                                $name = $chat->group->name;
//                                                $profile_url = asset('group_time_line/' . $chat->group->id);
//                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                if ($chat->group->pic) {
//                                                    $pic = asset('public/images/' . $chat->group->pic);
//                                                }
//                                                $other_image = $pic;
//                                            }
//                                            if ($other_user->is_active && $chat->chat_type == 'a') {
//                                                $chat_type_sidebar = 'a';
//                                                $chat_type_id_siderbar = $chat->accompanist->id;
//                                                $name = $chat->accompanist->name;
//                                                $profile_url = asset('accompanist_time_line/' . $chat->accompanist->id);
//                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                if ($chat->accompanist->pic) {
//                                                    $pic = asset('public/images/' . $chat->accompanist->pic);
//                                                }
//                                                $other_image = $pic;
//                                            }
//                                            if ($other_user->is_active && $chat->chat_type == 's') {
//                                                $chat_type_sidebar = 's';
//                                                $chat_type_id_siderbar = $chat->studio->id;
//                                                $name = $chat->studio->name;
//                                                $profile_url = asset('teaching_studio_time_line/' . $chat->studio->id);
//                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                if ($chat->studio->pic) {
//                                                    $pic = asset('public/images/' . $chat->studio->pic);
//                                                }
//                                                $other_image = $pic;
//                                            }
                                            ?>
                                            <li data-id="<?= $g_chat->id ?>" id="single_chat_user<?= $g_chat->id ?>" class="chat_user_listing <?php if ($i == 1) { ?> active <?php } ?>" >
                                                <div class="list_outer_wrap d-flex">
                                                    <div class="custom-control custom-checkbox">
                                                        <?php 
                                                        if($g_chat->admin_id == $current_id){
                                                        ?>
                                                            <input data-id="<?= $g_chat->id ?>" type="checkbox" name="" class="custom-control-input single_chat_list" id="user_select<?= $g_chat->id ?>">
                                                            <label class="custom-control-label no-top-padding txt_left" for="user_select<?= $g_chat->id ?>"></label>
                                                         <?php 
                                                        }
                                                        ?>
                                                    </div>
                                                    <a href="#" id="chat_on_left_menu<?= $g_chat->id ?>" onclick="getOtherChat('chat_id_<?= $g_chat->id ?>', this, '<?= $g_chat->id ?>', '<?= $name ?>', '<?= $other_user->id ?>', '<?= $profile_url ?>', '<?php echo $js_images_string ?>', '0', '10', '<?= $other_user->is_active ?>', '<?= $chat_type_sidebar ?>', '<?= $chat_type_id_siderbar ?>')">
                                                        <div class="d-flex">
                                                            <div class="user_images_profile">

                                                                <?php

                                                                if (isset($other_images[0])) { ?>
                                                                    <span class="bg_image_round user_active_status second-group-image"
                                                                          style="background-image: url(<?= $other_images[0] ?>); ">
                                                                 </span>
                                                                <?php }
                                                                if (isset($other_images[1])) { ?>
                                                                    <span class="bg_image_round user_active_status second-group-image"
                                                                          style="background-image: url(<?= $other_images[1] ?>); ">

                                                                    </span>
                                                                <?php }
                                                                if (isset($other_images[2])) { ?>
                                                                    <span class="bg_image_round user_active_status second-group-image"
                                                                          style="background-image: url(<?= $other_images[2] ?>); ">

                                                                    </span>
                                                                <?php }
                                                                ?>
                                                            </div>
                                                            <div class="info">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="name"><?= $name ?></div>
                                                                    <span class="time"><?= timeago($g_chat->updated_at) ?></span>
                                                                </div>
                                                                <div class="msg">
                                                                    <?php
                                                                    if($g_chat->getLoggedInStatus->is_read == 0){
                                                                    ?>
                                                                        <span class="active_status" style="background-color:blue;"></span>
                                                                    <?php
                                                                    }                                                    
                                                                    $length = strlen($g_chat->lastMessage->message);
                                                                    $add_dot = '';

                                                                    if ($length > 65) {
                                                                        $add_dot = '...';
                                                                    }
                                                                    if (strpos($g_chat->lastMessage->message, 'ifram') !== false) {
                                                                        echo 'Embeded Code';
                                                                    } else {
                                                                        echo substr($g_chat->lastMessage->message, 0, 65) . $add_dot;
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                    <ul class="un_style no_icon action_dropdown float-right">

                                                    </ul>
                                                </div>
                                            </li>
                                        <?php }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div> <!-- col -->
                    <div class="col-xl-9 col-lg-8 col-md-8">
                        <div class="message_box_wrap">
                            <div style="display: none" id="messges_get_loader" class="loader_absolute">
                                <div class="inner d-flex align-items-center justify-content-center">
                                    <div class="icon_loader"></div>
                                </div>
                            </div>
                            <div class="chat_header_box">
                                <div class="chat_header d-flex align-items-center clearfix">
                                    <div class="d-sm-block d-md-none mr-3">
                                        <span class="iconback"></span>
                                    </div>
                                    <?php
                                    if ($other_message_user) {
                                    $other_user_imgs = $g_chat->receiver;
                                    foreach ($other_user_imgs as $key => $value) {
                                        if ($key == 3) {
                                            break;
                                        } else {

                                            $other_images[$key] = getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);


                                        }
                                    }
                                        $name = 'Private User';
                                        $profile_url = '#';
                                        $profile_url = asset('profile_timeline/' . $other_message_user->id);
//                                        if ($other_message_user->is_active && $latest_chat->type == 'u') {
                                            $name = $other_message_user->first_name . ' ' . $other_message_user->last_name;
                                            $profile_url = asset('profile_timeline/' . $other_message_user->id);
                                            $main_image = getUserImage($other_message_user->photo, $other_message_user->social_photo, $other_message_user->gender);
//                                        }
//                                        if ($latest_chat->type == 'g') {
//                                            $profile_url = asset('group_time_line/' . $latest_chat->group_id);
//                                            $name = $latest_chat->group->name;
//                                            $main_image = asset('public/images/profile_pics/demo.png');
//                                            if ($latest_chat->group->pic) {
//                                                $main_image = asset('public/images/' . $latest_chat->group->pic);
//                                            }
//                                        }
//                                        if ($latest_chat->type == 'a') {
//                                            $profile_url = asset('accompanist_time_line/' . $latest_chat->accompanist_id);
//                                            $name = $latest_chat->accompanist->name;
//                                            $main_image = asset('public/images/profile_pics/demo.png');
//                                            if ($latest_chat->accompanist->pic) {
//                                                $main_image = asset('public/images/' . $latest_chat->accompanist->pic);
//                                            }
//                                        }
//                                        if ($latest_chat->type == 's') {
//                                            $profile_url = asset('teaching_studio_time_line/' . $latest_chat->studio_id);
//                                            $name = $latest_chat->studio->name;
//                                            $main_image = asset('public/images/profile_pics/demo.png');
//                                            if ($latest_chat->studio->pic) {
//                                                $main_image = asset('public/images/' . $latest_chat->studio->pic);
//                                            }
//                                        }
//                                        if ($latest_chat->type == 'u') {
                                            $name = $latest_chat->title;
//                                            $main_image = asset('public/images/profile_pics/demo.png');
//                                        }
                                        ?>
                                        <div class="media align-items-center">
                                            <div class="user_images_profile" id="group_profile_images_div">
                                                <?php if (!empty($other_images[0])) { ?>
                                                    <span id="other_user_image0" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[0]; ?>)">
                                            </span>
                                                <?php } ?>
                                                <?php if (!empty($other_images[1])) { ?>
                                                    <span id="other_user_image1" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[1]; ?>)">
                                            </span>
                                                <?php } ?>
                                                <?php if (!empty($other_images[2])) { ?>
                                                    <span id="other_user_image2" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[2]; ?>)">
                                            </span>
                                                <?php } ?>
                                            </div>
                                            <div class="media-body line-height-13">
                                                <a id="active_user_name" href="<?= $profile_url ?>" class="text_darkblue font-18 font-weight-bold"><?= $name ?></a>
                                                <div id="online_section" <?php if ($other_message_user->is_online != 1) { ?> style="display: none" <?php } ?> class=" align-items-center">
                                                    <span class="active_status"></span> Online
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?><!-- media -->
                                        <div class="media align-items-center li_header_chat" style="display:none;">
                                            <div class="user_images_profile" id="group_profile_images_div">
                                                <?php if (!empty($other_images[0])) { ?>
                                                    <span id="other_user_image0" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[0]; ?>)">
                                            </span>
                                                <?php } ?>
                                                <?php if (!empty($other_images[1])) { ?>
                                                    <span id="other_user_image1" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[1]; ?>)">
                                            </span>
                                                <?php } ?>
                                                <?php if (!empty($other_images[2])) { ?>
                                                    <span id="other_user_image2" class="bg_image_round second-group-image"
                                                          onclick="location.href = '<?= $profile_url ?>'"
                                                          style="background-image: url(<?php echo $other_images[2]; ?>)">
                                            </span>
                                                <?php } ?>
                                            </div>
                                            <div class="media-body line-height-13">
                                                <a id="active_user_name" href="#" class="text_darkblue font-18 font-weight-bold"></a>
                                                <div id="online_section"  class=" align-items-center dot_and_online_status" style="display: none">
                                                    <span class="active_status"></span> Online
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="ml-auto align-self-center">  
                                    </div> <!-- ml-auto -->
                                </div> <!-- timeline header -->
                            </div>
                            <div class="chat_box_wrapper">
                                <ul class="chat chat_list" id="chat_list">
                                    <?php
                                    $chat_count = 0;
                                    if (count($messages) > 0) {
                                        $sotrted = $messages->sortBy('created_at');
                                        foreach ($sotrted->values()->all() as $message) {
//                                            print_r($message); exit;
                                            $chat_count++;
                                            if ($chat_count == 1) {
                                                ?>
                                                <input type="hidden" name="chat_id_scroll" id="chat_id_scroll" value="<?= $message->chat_group_id ?>">
                                                <?php
                                            }
                                            if ($message->sender_id == $current_id) {
                                                ?>
                                                <li class="right" id="single_message<?= $message->id ?>">
                                                    <div class="d-flex flex-row-reverse">
                                                        <figure>
                                                            <?php
//                                                            if ($message->message_type == 'g' && $message->group->admin_id == $current_id) {
//                                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                                if ($message->group->pic) {
//                                                                    $pic = asset('public/images/' . $message->group->pic);
//                                                                }
                                                                ?>
                                                                <!--<span class="bg_image_round" onclick="location.href = '<?php // echo asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php //  echo $pic ?>)"></span>-->
                                                                <?php
//                                                            } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) {
//                                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                                if ($message->studio->pic) {
//                                                                    $pic = asset('public/images/' . $message->studio->pic);
//                                                                }
                                                                ?>  
                                                                <!--<span class="bg_image_round" onclick="location.href = '<?php // echo asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php // echo $pic ?>)"></span>-->
                                                                <?php
//                                                            } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) {
//                                                                $pic = asset('public/images/profile_pics/demo.png');
//                                                                if ($message->accompanist->pic) {
//                                                                    $pic = asset('public/images/' . $message->accompanist->pic);
//                                                                }
                                                                ?>

                                                            <?php // } else { ?>
                                                                <span class="bg_image_round" onclick="location.href = '<?php echo asset('profile_timeline/' . $current_id) ?>'" style="background-image: url(<?php echo $current_photo ?>)"></span>
                                                            <?php // } ?>
                                                        </figure>
                                                        <div class="chat_body">
                                                            <?php // if ($message->message_type == 'g' && $message->group->admin_id == $current_id) { ?>
                                                                <!--<div onclick="location.href = '<?php // echo asset('group_time_line/' . $message->group->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $message->group->name ?></div>-->   
                                                            <?php // } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) { ?>
                                                                <!--<div onclick="location.href = '<?php // echo asset('accompanist_time_line/' . $message->accompanist->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $message->accompanist->name ?></div>-->   
                                                            <?php // } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) { ?>
                                                                <!--<div onclick="location.href = '<?php // echo asset('teaching_studio_time_line/' . $message->studio->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $message->studio->name ?></div>-->   
                                                            <?php // } else { ?>
                                                                <div onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $current_name ?></div>
                                                            <?php// } ?>
                                                            <div class="chat_txt highlight">
                                                                <?php if ($message->file_type && $message->file_type == 'image') { ?>
                                                                    <div class="uploaded_image">
                                                                        <a href="<?= asset('public/images/' . $message->file_path); ?>" data-fancybox="images">
                                                                            <img src="<?= asset('public/images/' . $message->file_path); ?>">
                                                                        </a>
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                <?php } if ($message->file_type && $message->file_type == 'pdf') { ?>
                                                                    <div class="uploaded_image">
                                                                        <img src="<?= asset('userassets/images/pdf.png') ?>">
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if ($message->file_type && $message->file_type == 'doc') {
                                                                    ?>
                                                                    <div class="uploaded_image">
                                                                        <img src="<?= asset('userassets/images/docx.png') ?>">
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                <?php } if ($message->file_type && $message->file_type == 'mp3') { ?>
                                                                    <div class="uploaded_image">
                                                                        <audio controls="" src="<?= asset('public/images/' . $message->file_path) ?>"></audio>

                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                <?php } if ($message->file_type && $message->file_type == 'video') { ?>
                                                                    <div class="uploaded_image">
                                                                        <a href="<?= asset('public/videos/' . $message->file_path); ?>" data-fancybox="bigbuckbunny">
                                                                            <video width="320" height="240" controls src="<?= asset('public/videos/' . $message->file_path); ?>"></video>
                                                                        </a>
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <!--<span class="image_download_btn"></span>-->
                                                                        </a>
                                                                    </div>
                                                                <?php } ?>
                                                                <?= $message->message ?>
                                                            </div>
                                                            <ul class="un_style no_icon">
                                                                <li class="dropdown dropup">
                                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                                                                        <i class="fas fa-ellipsis-h"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                        <div class="message_dropdown_wrap">
                                                                            <?php if ($message->message) { ?>
                                                                                <input style="display: none" type="text" value="<?= $message->message ?>" id="copy_<?= $message->id ?>">
                                                                                <a onclick="copyMessage('<?= $message->id ?>')" href="javascript:void(0)">Copy</a>
                                                                            <?php } ?>
                                                                            <a onclick="deleteMessage('<?= $message->id ?>', '<?= $message->chat_id ?>')" href="javascript:void(0)">Delete</a>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <div class="msg_time text-right"><?= timeago($message->created_at) ?></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            } else {
                                                $name = 'Private User';
                                                $profile_url = '#';
                                                $name = $message->sender->first_name . ' ' . $message->sender->last_name;
                                                $profile_url = asset('profile_timeline/' .$message->sender->id);
                                                $profile_pic = getUserImage($message->sender->photo, $message->sender->social_photo, $message->sender->gender);
                                                
                                                ?>
                                                <li  id="single_message<?= $message->id ?>">
                                                    <div class="d-flex">
                                                        <figure>
                                                            <span class="bg_image_round" onclick="location.href = '<?= $profile_url ?>'" style="background-image: url(<?php echo $profile_pic ?>)"></span>
                                                        </figure>
                                                        <div class="chat_body">
                                                            <div onclick="location.href = '<?= $profile_url ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue"><?= $name ?></div>

                                                            <div class="chat_txt">
                                                                <?php if ($message->file_type && $message->file_type == 'image') { ?>
                                                                    <div class="uploaded_image">
                                                                        <a href="<?= asset('public/images/' . $message->file_path); ?>" data-fancybox="images">
                                                                            <img src="<?= asset('public/images/' . $message->file_path); ?>">
                                                                        </a>
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                    <span class="image_download_btn"></span>
                                                                <?php } if ($message->file_type && $message->file_type == 'pdf') { ?>
                                                                    <div class="uploaded_image">
                                                                        <img src="<?= asset('userassets/images/pdf.png') ?>">
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                <?php } if ($message->file_type && $message->file_type == 'doc') { ?>
                                                                    <div class="uploaded_image">
                                                                        <img src="<?= asset('userassets/images/docx.png') ?>">
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                        <span class="image_download_btn"></span>
                                                                    </div>
                                                                    <?php
                                                                }
                                                                if ($message->file_type && $message->file_type == 'mp3') {
                                                                    ?>
                                                                    <div class="uploaded_image">

                                                                        <img src="<?= asset('userassets/images/mp3.png') ?>">
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                        <span class="image_download_btn"></span>
                                                                    </div>
                                                                <?php } if ($message->file_type && $message->file_type == 'video') { ?>
                                                                    <div class="uploaded_image">
                                                                        <a href="<?= asset('public/videos/' . $message->file_path); ?>" data-fancybox="bigbuckbunny">
                                                                            <video width="320" height="240" controls src="<?= asset('public/videos/' . $message->file_path); ?>"></video>
                                                                        </a>
                                                                        <a href="<?= asset('download_file/' . $message->id) ?>">
                                                                            <span class="image_download_btn"></span>
                                                                        </a>
                                                                    </div>
                                                                <?php } ?>

                                                                <?= $message->message ?>
                                                            </div>
                                                            <ul class="un_style no_icon">
                                                                <li class="dropdown dropup">
                                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
                                                                        <i class="fas fa-ellipsis-h"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                        <div class="message_dropdown_wrap">
                                                                            <?php if ($message->message) { ?>
                                                                                <input style="display: none" type="text" value="<?= $message->message ?>" id="copy_<?= $message->id ?>">
                                                                                <a onclick="copyMessage('<?= $message->id ?>')" href="javascript:void(0)">Copy</a>
                                                                            <?php } ?>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <div class="msg_time"><?= timeago($message->created_at) ?></div>
                                                        </div>
                                                    </div>
                                                </li>
                                                <?php
                                            }
                                        }
                                    }
                                    ?>
                                </ul>
                            </div>
                            <div class="chat_footer_box">
                                <div style="display: none" class="files_upload_box">
                                    <div class="d-flex flex-row-reverse">
                                        <div class="uploaded_file">
                                            <div class="icon-close">
                                                <span>×</span>
                                            </div>
                                            <img id="tiny-icon-spacer" src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer">
                                            <div id="tiny-icon" class="image" style="background-image: url(<?= asset('userassets/images/groupimage1.jpg'); ?>);"></div>
                                            <video style="max-width: 75px; " id="tiny-video" src="<?php echo asset('userassets/videos/vid.mp4'); ?>" class="video"></video>
                                            <div style="display: none" id="attachment_loader" class="loader_absolute">
                                                <div class="inner d-flex align-items-center justify-content-center">
                                                    <div  class="icon_loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php if (count($messages) > 0) { ?>
                                    <div class="chat_footer" id="chat_area_messages" <?php if (!$other_message_user->is_active) { ?> style="display: none" <?php } ?>>
                                        <textarea onkeyup="sendMessage(event, this, '0')"  id="messagetext" placeholder="Write here your message.." class="form-control"></textarea>
                                        <div class="btn_wrap">
                                            <div class="d-flex align-items-center">
                                                <div class="file_attachment">
                                                    <input type="file" id="attachment"accept="image/*,video/*,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx">
                                                    <span class="icon-attachment"></span>
                                                </div>
                                                <button onclick="sendMessage(event, this, '1')" type="button" class="btn btn-round btn-gradient btn-xl text-semibold"/> <span>Send</span><i class="icon-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="private_user" <?php if ($other_message_user->is_active) { ?> style="display: none" <?php } ?>>You can't reply to this conversation.</div>
                                <?php }
                                else { ?>

                                    <div class="chat_footer" id="chat_area_messages">
                                        <textarea onkeyup="sendMessage(event, this, '0')"  id="messagetext" placeholder="Write here your message.." class="form-control"></textarea>
                                        <div class="btn_wrap">
                                            <div class="d-flex align-items-center">
                                                <div class="file_attachment">
                                                    <input type="file" id="attachment"accept="image/*,video/*,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx">
                                                    <span class="icon-attachment"></span>
                                                </div>
                                                <button onclick="sendMessage(event, this, '1')" type="button" class="btn btn-round btn-gradient btn-xl text-semibold"/> <span>Send</span><i class="icon-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>

                                <?php } ?>

                            </div>

                        </div> <!-- message Box wrap -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
         <?php if (Auth::user()) { ?>
        <!-- Message modal Start -->
        <div class="modal fade" id="modal_friends_message" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-black" id="exampleModalLabel">New Accompanist Message To <span class="text_maroon"> <?= $value['first_name'] . ' ' . $value['last_name']; ?> </span></h6>
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
                                        <input type="text" id="title<?= $current_id ?>" style="width: 100%" placeholder="Enter Title Here" class="form-control" name="title">
                                    </div>
                                    <div class="form-group">
                                        <select type="text" name="friends[]" class="form-control" id="bulk-messages<?= $current_id ?>" style="width: 100%" multiple="multiple">
                                            <?php
                                            if (!empty($accompanist->members)) {
                                                foreach ($accompanist->members as $key => $member) {
                                                    if($member->is_approved == 1){
                                                        if($member->getMemberDetail->id != $current_id){
                                                        ?>
                                                        <option <?= ($key == '0') ? 'selected=""' : '' ?> value="<?= $member->getMemberDetail->id ?>"> <?= $member->getMemberDetail->first_name . ' ' . $member->getMemberDetail->last_name ?> </option>
                                                        <?php
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </select>
                                        <div class="font-14 text-danger text-right"></div>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold mb-2">Write a Message</label>
                                        <textarea id="message<?= $current_id ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                        <div class="font-14 text-danger text-right"></div>
                                    </div>

                                    <div class="form-group ">
                                        <div class="attact-link btn-file">
                                            <label for="attachment_student_files">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34.147" height="34.147" viewBox="0 0 34.147 34.147"> <defs> <linearGradient id="linear-gradient" x1="0.063" y1="-0.21" x2="0.93" y2="1.221" gradientUnits="objectBoundingBox"> <stop offset="0" stop-color="#5d2488"/> <stop offset="1" stop-color="#b62e65"/> </linearGradient> </defs> <g id="Group_13" data-name="Group 13" transform="translate(-564 -832)"> <circle id="Ellipse_20" data-name="Ellipse 20" cx="17.074" cy="17.074" r="17.074" transform="translate(564 832)" fill="url(#linear-gradient)"/> <path id="attachment" d="M4.57,13.5A3.387,3.387,0,0,1,2.176,7.726l7-7A2.509,2.509,0,0,1,12.8.828a2.508,2.508,0,0,1,.106,3.622l-6.58,6.58A1.586,1.586,0,1,1,4.086,8.788L8.543,4.33a.385.385,0,0,1,.544.544L4.63,9.332a.816.816,0,0,0,1.154,1.154l6.58-6.58a1.757,1.757,0,0,0-.106-2.533,1.757,1.757,0,0,0-2.533-.106l-7,7a2.617,2.617,0,0,0,3.7,3.7l7-7a.385.385,0,0,1,.544.544l-7,7A3.363,3.363,0,0,1,4.57,13.5Z" transform="translate(573.32 842.507)" fill="#fff"/> </g> </svg>
                                                <span>Attach Files</span>
                                            </label>
                                            <input type="file"  id="attachment_student_files" style="display: none"  />
                                        </div>
                                    </div>

                                    <div class="profile-img" style="display:none">
                                        <ul class="un_style">
                                            <li>
                                                <div class="tag_image"  id="tiny-icon-studio" ></div>
                                            </li>

                                        </ul>
                                    </div>

                                    <div class="video_preview" style="display:none">
                                        <ul class="un_style">
                                            <li>
                                                <div class="tag_image" >
                                                    <video id="tiny-video-studio" src="<?php echo asset('userassets/videos/vid.mp4'); ?>" class="tag_image video"></video>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>

                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="button" onclick="sendMessageToFriends('<?= $current_id ?>')" class="btn btn-gradient btn-round btn-xl text-semibold">Send</button>
                            </div>
                        </form>
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!--  Message modal END -->
    <?php } ?>
        <?php include resource_path('views/includes/footer.php'); ?>          
    </body>
    <!-- attach file in student list -->
    <script>
        files = '';
        $("#attachment_student_files").change(function () {

            var fileInput = document.getElementById('attachment_student_files');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;
            if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
//                $('.files_upload_box').show();
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onloadend = function (e) {
                    $("#tiny-video").attr("src", '');
                    $("#tiny-video").hide();
                    $(".profile-img").show();
//                    $("#tiny-icon-spacer").show();

                    $("#tiny-icon-studio").css({"background-image": 'url(' + e.target.result + ')'});
                };
                reader.readAsDataURL(file);
            } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {
//                $('.files_upload_box').show();
                $(".video_preview").show();
//                $("#tiny-icon").hide();
//                $("#tiny-icon-spacer").hide();
                $("#tiny-icon-studio").css({"backgroundImage": 'url()'});
                $("#tiny-video-studio").attr("src", fileUrl);
                var myVideo = document.getElementById("tiny-video-studio");
                myVideo.addEventListener("loadedmetadata", function ()
                {
                    duration = (Math.round(myVideo.duration * 100) / 100);
                    if (duration >= 21) {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Video is greater than 20 sec.').show().fadeOut(5000);
                        $("#tiny-video").attr("src", '');
                        $('.tiny-div').hide();
                    }
                });
                $("#tiny-icon").attr("src", '');
                $("#tiny-icon").hide();
            } else if (fileInput.files[0].type == "application/pdf") {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
                $(".profile-img").show();
                $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/pdf.png') ?>)'});
            } else if (fileInput.files[0].type == "audio/mp3") {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
//                $("#tiny-icon-spacer").show();
                $(".profile-img").show();

                $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/mp3.png') ?>)'});
            } else if (fileInput.files[0].type == "application/vnd.ms-excel" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || fileInput.files[0].type == 'application/msword') {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
//                $("#tiny-icon-spacer").show();
                $(".profile-img").show();

                $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/docx.png') ?>)'});
            } else {
                //            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select a valid file').show().fadeOut(5000);
                $('.files_upload_box').hide();
                files = '';
                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                $("#tiny-icon").hide();
                $(".tiny-div").hide();
            }
        });
        $('#attachment_student_files').on('change', prepareUpload);
        function prepareUpload(event)
        {
            files = event.target.files;
            var input = document.getElementById('attachment_student_files');
            var filePath = input.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.mp3|\.pdf|\.dcx|\.doc|\.docm|\.csv|\.xlsx)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                $('#attachment').val('');
                $('#imagePreview').html('');
                $('.tiny-div').hide();
                files = '';
                return false;
            }
        }
    </script>
    <script>
        $(document).ready(function () {
            $('#bulk-messages<?= $current_id ?>').select2({
                allowClear: true,
                width: 'resolve',
                minimumResultsForSearch: Infinity,
                placeholder: "Select Friends",
            });
        });

    </script>
    <script>
        $(document).ready(function(){
            var old_id = $('#group_chat_id').val();
            $('.chat_box_wrapper').addClass('chat_box_wrapper_' + old_id);
            
            var url_chat_id = "<?=(isset($_GET['chat_accompanist_id']) && $_GET['chat_accompanist_id']) ? $_GET['chat_accompanist_id'] : ''?>";
            if (url_chat_id) {
               $('#chat_on_left_menu'+url_chat_id).trigger('click'); 
            }
        });
        
        var skip_scroll = 0;
        var testing = '';
        var responce_data = '';
        window.addEventListener('load', function () {
            if (document.getElementsByClassName('chat').length > 0) {
                $(".chat_box_wrapper").mCustomScrollbar({
                    setTop: "-100000000px",
                    callbacks: {
                        onTotalScrollBack: function () {
                            $('.message_box_wrap').addClass('show');
                            skip_scroll = parseInt(skip_scroll) + parseInt(10);
                            other_id = $('#other_user_chat_id').val();
                            chat_id_scroll = $('#chat_id_scroll').val();
                            other_name = $('#active_user_name').html();
                            bg = $('#other_user_image').css('background-image');
                            image = bg.replace('url(', '').replace(')', '').replace(/\"/gi, "");
                            base_url = '<?= asset('profile_timeline/') ?>';
                            url_scroll = base_url + '/' + other_id;
                            var chat_group_id = $('#group_chat_id').val();
//                            getOtherChat(id, ele, chat_id, other_name, other_id, url, image, skip, take, is_active, type = '', type_id = '') {
                            getOtherChat('', 'ajax', chat_id_scroll, other_name, other_id, url_scroll, image, skip_scroll, 10, '','a',chat_group_id);
//                            myCustomFn(this);
                        }
                    }
                });
            }
        });
        files = '';
//        testing = ScrollHeight[0].mcs.content.height();

        function myCustomFn(el) {
            console.log($(el));
            upadted_length = el.mcs.content.height();

            console.log(upadted_length);

            remaining_length = upadted_length - testing;

            console.log(remaining_length);

            testing = upadted_length;

            console.log(testing);

            $(".content").mCustomScrollbar("scrollTo", remaining_length, {
                scrollInertia: 0
            });

        }
        function sendMessage(e, obj, to_be_send) {
            if (e.keyCode === 13 || to_be_send == 1) {
                var message = $('#messagetext').val();
                if (message || files) {

                    if (files) {
                        $('#attachment_loader').show();
                    }
                    var data = new FormData();
                    $.each(files, function (key, value)
                    {
                        data.append('file', value);
                    });

                    var chat_type = $('#chat_type').val();
                    var chat_type_id = $('#chat_type_id').val();
                    var group_id = $('#group_id').val();
                    var chat_group_id = $('#group_chat_id').val();

                    if(!group_id)
                    {
                        group_id=$('#accompanist_id').val();
                    }
                    var chat_url = '<?= asset('messages') ?>';
                    if (chat_type == 'a') {
                        chat_url = '<?= asset('accompanist_messages') ?>' + '/' + group_id;
                    }
                    if (chat_type == 'g') {
                        chat_url = '<?= asset('event_messages') ?>' + '/' + group_id;
                    }
                    if (chat_type == 's') {
                        chat_url = '<?= asset('studio_messages') ?>' + '/' + chat_type_id;
                    }
                    if (chat_type == 'u') {
                        chat_url = '<?= asset('groupchat') ?>';
                    }
                    var otherid = $('#other_user_chat_id').val();
                    data.append('message', message);
                    data.append('receiver_id', otherid);
                    data.append('message_type', chat_type);
                    data.append('type_id', group_id);
                    data.append('chat_group_id', chat_group_id);
                    data.append('_token', '<?= csrf_token() ?>');
                    $('#messagetext').val('');
                    if (/\S/.test(message) || files) {
                        files = '';
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add_group_message'); ?>",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('#attachment_loader').hide();
                                $('.tiny-div, .files_upload_box').hide();
                                var result = JSON.parse(data);
                                $('.chat_box_wrapper .chat').append(result.append);
                                $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                
                                
                                $.each(result.group_member, function (key, value){
                                    
                                    if(value.member_id != '<?= $current_id ?>'){
                                        socket.emit('groupmessage_get', {
                                            "user_id": value.member_id,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?> in ' + result.chat_group.title,
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": result.other_message,
                                            "chat_id": result.chat_id,
                                            "message": message,
                                            "chat_type": 'a',
                                            "chat_type_id": group_id,
                                            "to_be_show": 'a',
                                            "chat_name" : result.chat_group.title,
                                        });
                                        socket.emit('notification_get', {
                                            "user_id": value.member_id,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent message in '+ result.chat_group.title,
                                            "url": chat_url,
                                            "is_message_notification": 1,
                                            "chat_id": result.chat_id,
                                            "chat_type": 'a',
                                            "chat_type_id": group_id,
                                            "to_be_show": 'a',
                                            "chat_name" : result.chat_group.title,
                                        }); 
                                    }
                                });
                            }
                        });
                    }
                }
            }
        }
        current_id =<?= $current_id ?>;
        other_id = $('#other_user_chat_id').val();
        base_path = '<?= asset('profile_timeline/') ?>';
        
        
        socket.on('groupmessage_send', function (data) {
            console.log(data.group_member_profile_images);
            var chat_group_id = $('#group_chat_id').val();
                if (data.user_id == current_id && data.to_be_show == 'a') {
                    var group_member_images_array =data.group_member_profile_images.split(',');
                    other_id = $('#other_user_chat_id').val();
                    var listItems = $(".chat_user_listing");
                    var li_exists = '';
                    var count_li = 0;
                    listItems.each(function (idx, li) {
                        count_li ++;
                        var chat_id = ($(li).data('id'));
                        if (chat_id == data.chat_id) {
                            li_exists = '1';
                        } 
                    });

                    if (li_exists == '') {
                        if(count_li == 0){
                            $('.li_header_chat').show();
                        }
                        var chat_li = '<li data-id="' + data.chat_id + '" id="single_chat_user' + data.chat_id + '" class="chat_user_listing" >' +
                                '<div class="list_outer_wrap d-flex">' +
                                '<div class="custom-control custom-checkbox">';
                        if(data.other_id == current_id){
                            chat_li += '<input data-id="' + data.chat_id + '" type="checkbox" name="" class="custom-control-input single_chat_list" id="user_select' + data.chat_id + '">' +
                                '<label class="custom-control-label no-top-padding txt_left" for="user_select' + data.chat_id + '"></label>'; 
                        }
                        chat_li += '</div>' +
                                '<a href="#" onclick="getOtherChat(\'chat_id_' + data.chat_id + '\', this, \'' + data.chat_id + '\', \'' + data.chat_name + '\', \'' + data.other_id + '\',\' # \', \'' + data.group_member_profile_images + '\',\'0\',\'10\',\'1\',\'a\',\'' + data.chat_id + '\')">' +
                                '<div class="d-flex">' +
                            '<div class="user_images_profile">';
                        //append user profile images in group header
                        $.each(group_member_images_array, function (index, value) {
                            chat_li += '<span id="other_user_image' + index + '" class="bg_image_round user_active_status second-group-image"  style="background-image: url(' + value + ')"></span>';
                        });

                                // '<span class="bg_image_round user_active_status" style="background-image: url(' + data.photo + ') ">' +
                        chat_li +='<span class="active"></span>' +
                                '</span></div> <div class="info"><div class="d-flex align-items-center">' +
                                '<div class="name">' + data.chat_name + '</div>' +
                                '<span class="time">Just now</span>' +
                                '</div> <div class="msg"><span class="active_status" style="background-color:blue;"></span>' +
                                data.message +
                                '</div></div></div></a><ul class="un_style no_icon action_dropdown float-right">' +
                                '</ul></div></li>';
                        if($('#chat_type_id').val()=='' || $('#group_id').val()==''){
                            $('#group_id').val(data.chat_type_id);
                            $('#chat_type_id').val(data.chat_id);
                            $('#group_chat_id').val(data.chat_id);
                        }
                        $('#chat_user_filter_listing').prepend(chat_li);
                        $('.new_messages_label span').html(parseInt($('.new_messages_label span').html(),10)+1);
                        
                    } else {
                        if(chat_group_id == data.chat_id ){
                            $('#chat_on_left_menu'+data.chat_id+ ' .msg').html('<strong>'+data.message+'</strong>');
                        } else {
                            $('#chat_on_left_menu'+data.chat_id+ ' .msg').html('<span class="active_status" style="background-color:blue;"></span><strong>'+data.message+'</strong>');
                            $('.new_messages_label span').html(parseInt($('.new_messages_label span').html(),10)+1);
                        }
                        
                    }
                    if(data.other_id != current_id && chat_group_id == data.chat_id){
                        $('.chat_box_wrapper_'+data.chat_id+ ' .chat').append(data.text);
                        $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                    }
                }
        });

        function getOtherChat(id, ele, chat_id, other_name, other_id, url, image, skip, take, is_active, type = '', type_id = '') {

            var old_id = $('#group_chat_id').val();
            if($('#chat_on_left_menu'+chat_id+ ' .msg').find('.active_status').length > 0){
                $('.new_messages_label span').html(parseInt($('.new_messages_label span').html(),10)-1);
            }
            var new_msg = $('#chat_on_left_menu'+chat_id+ ' .msg strong').html();
            $('#chat_on_left_menu'+chat_id+ ' .msg').find('.active_status').remove();
            $('#chat_on_left_menu'+chat_id+ ' .msg').find('strong').remove();
            $('#chat_on_left_menu'+chat_id+ ' .msg').html(new_msg);
            
            $('.chat_box_wrapper').removeClass('chat_box_wrapper_'+ old_id);
            $('.chat_box_wrapper').addClass('chat_box_wrapper_'+ type_id);    
            if (type) {
                $('#chat_type_id').val(type_id);
                $('#chat_type').val(type);
            }
            
            $('.message_box_wrap').addClass('show');
            $('.chat_usersidebar_wrap').addClass('hide');
            if (!$(ele).parents('.active').length || ele == 'ajax') {
                $('#chat_id_scroll').val(chat_id);
                if (skip == 0) {
                    skip_scroll = 0;
                    $('.chat_user_listing').removeClass('active');
                    $(ele).closest('li').addClass('active');
                    $('#single_chat_user' + chat_id).addClass('active');
                    $('#chat_list').html('');
                    $('#messges_get_loader').show();
                    $('#group_chat_id').val(chat_id);
                    $('#other_user_chat_id').val(other_id);
                    if (is_active == 1) {
                        $('#chat_area_messages').show();
                        $('#private_user').hide();
                    } else {
                        $('#chat_area_messages').hide();
                        $('#private_user').show();
                    }
                }
                $.ajax({
                    type: "GET",
                    data: {"chat_id": chat_id, "skip": skip, "take": take},
                    url: "<?php echo asset('get_group_chat'); ?>",
                    success: function (data) {
                        if (data) {
                            responce_data = data;
                            if (skip == 0) {
                                // if ($('#check_if_online_' + other_id).length) {
                                //     $('#online_section').show();
                                // } else {
                                //     $('#online_section').hide();
                                // }
                                $('#online_section').show();
                                $('#chat_list').append(data);
                                $('#active_user_name').html(other_name);
                                $('#active_user_name').attr('href', url);
                                $('#other_user_image').attr('href', url);
                                // $('#other_user_image').css('backgroundImage', 'url(' + image + ')');
                                $('#group_profile_images_div').empty();
                                var group_member_images = image.split(',');
                                //append user profile images in group header
                                $.each(group_member_images, function (index, value) {
                                    $('#group_profile_images_div').append('<span id="other_user_image' + index + '" class="bg_image_round second-group-image"  style="background-image: url(' + value + ')"></span>');
                                });
                            } else {
                                $('# ').prepend(data);
                                $('.chat_box_wrapper').mCustomScrollbar("scrollTo", $('#' + $(data).last().attr('id')).position().top, {
//                            timeout:1000,
                                    scrollInertia: 0
                                });
                            }
                            $('#messges_get_loader').hide();
                            setTimeout(function () {
                                if (skip == 0) {
                                    $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                }
                            }, 400);
                        } else {
                            $('#messges_get_loader').hide();
                        }
                    }
                });
        }
        }
        $('.icon-close').click(function (e) {
            e.preventDefault();
            $('.tiny-div, .files_upload_box').hide();
            $("#tiny-video").attr("src", '');
            $("#tiny-icon").attr("src", '');
            $("#tiny-video").hide();
            $("#tiny-icon").hide();
            $("#attachment").val('');
            files = '';
        });
        $("#attachment").change(function () {

            var fileInput = document.getElementById('attachment');
            var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
            var image_type = fileInput.files[0].type;
            if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
                $('.files_upload_box').show();
                var file = fileInput.files[0];
                var reader = new FileReader();
                reader.onloadend = function (e) {
                    $("#tiny-video").attr("src", '');
                    $("#tiny-video").hide();
                    $("#tiny-icon").show();
                    $("#tiny-icon-spacer").show();
                    $("#tiny-icon").css({"backgroundImage": 'url(' + e.target.result + ')'});
                };
                reader.readAsDataURL(file);
            } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {
                $('.files_upload_box').show();
                $("#tiny-video").show();
                $("#tiny-icon").hide();
                $("#tiny-icon-spacer").hide();
                $("#tiny-icon").css({"backgroundImage": 'url()'});
                $("#tiny-video").attr("src", fileUrl);
                var myVideo = document.getElementById("tiny-video");
                myVideo.addEventListener("loadedmetadata", function ()
                {
                    duration = (Math.round(myVideo.duration * 100) / 100);
                    if (duration >= 21) {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Video is greater than 20 sec.').show().fadeOut(5000);
                        $("#tiny-video").attr("src", '');
                        $('.tiny-div').hide();
                    }
                });
                $("#tiny-icon").attr("src", '');
                $("#tiny-icon").hide();
            } else if (fileInput.files[0].type == "application/pdf") {
                $('.files_upload_box').show();
                $("#tiny-video").attr("src", '');
                $("#tiny-video").hide();
                $("#tiny-icon").show();
                $("#tiny-icon-spacer").show();
                $("#tiny-icon").css({"backgroundImage": 'url(<?= asset('userassets/images/pdf.png') ?>)'});
            } else if (fileInput.files[0].type == "audio/mp3") {
                $('.files_upload_box').show();
                $("#tiny-video").attr("src", '');
                $("#tiny-video").hide();
                $("#tiny-icon").show();
                $("#tiny-icon-spacer").show();
                $("#tiny-icon").css({"backgroundImage": 'url(<?= asset('userassets/images/mp3.png') ?>)'});
            } else if (fileInput.files[0].type == "application/vnd.ms-excel" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || fileInput.files[0].type == 'application/msword') {
                $('.files_upload_box').show();
                $("#tiny-video").attr("src", '');
                $("#tiny-video").hide();
                $("#tiny-icon").show();
                $("#tiny-icon-spacer").show();
                $("#tiny-icon").css({"backgroundImage": 'url(<?= asset('userassets/images/docx.png') ?>)'});
            } else {
                //            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select a valid file').show().fadeOut(5000);
                $('.files_upload_box').hide();
                files = '';
                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                $("#tiny-icon").hide();
                $(".tiny-div").hide();
            }
        });
        $('#attachment').on('change', prepareUpload);
        function prepareUpload(event)
        {
            files = event.target.files;
            var input = document.getElementById('attachment');
            var filePath = input.value;
            var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.mp3|\.pdf|\.dcx|\.doc|\.docm|\.csv|\.xlsx)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                $('#attachment').val('');
                $('#imagePreview').html('');
                $('.tiny-div').hide();
                files = '';
                return false;
            }
        }
        function deleteMessage(message_id, chat_id) {
            $('#single_message' + message_id).remove();
            $.ajax({
                type: "GET",
                data: {"message_id": message_id},
                url: "<?php echo asset('delete_group_message'); ?>",
                success: function (data) {
                    if (data == 'Delete Chat') {
                        window.location.reload();
                    }
                }
            });
        }
        jQuery("#filter_chat_users").keyup(function () {
            var filter = jQuery(this).val();
            jQuery("#chat_user_filter_listing li").each(function () {

                if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                    jQuery(this).hide();
                } else {
                    jQuery(this).show()
                }
            });
        });
        $('.delete_btn').on('click', function (e) {
            var allVals = [];
            $(".single_chat_list:checked").each(function () {
                allVals.push($(this).attr('data-id'));
            });
            if (allVals.length <= 0)
            {
                alert("Please select row.");
            } else {
                var check = confirm("Are you sure you want to delete these rows?");
                if (check == true) {
                    $('#loader').show();
                    var join_selected_values = allVals.join(",");
                    $.ajax({
                        url: '<?= asset('delete_multiple_friend_chats') ?>',
                        type: 'POST',
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids=' + join_selected_values,
                        success: function (data) {
                            if (data['success']) {
                                $(".single_chat_list:checked").each(function () {
                                    $(this).parents("li").remove();
                                });
                                alert(data['success']);
                                window.location.reload();
                            } else if (data['error']) {
                                alert(data['error']);
                            } else {
                                alert('Whoops Something went wrong!!');
                            }
                        },
                        error: function (data) {
                            alert(data.responseText);
                        }
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 6000);
                    $.each(allVals, function (index, value) {
                        $('table tr').filter("[data-row-id='" + value + "']").remove();
                    });
                }
            }
        });
        function copyMessage(message_id) {
            $("#copy_" + message_id).show();
            var copyText = document.getElementById("copy_" + message_id);
            copyText.select();
            document.execCommand("copy");
            $("#copy_" + message_id).hide();
            $('#showSuccess').html("Copied successfully.").fadeIn().fadeOut(5000);
            //            alert();
        }
        function hideModal(id, show_id) {
            $('#' + id).modal('hide');
            setTimeout(function () {
                $('#' + show_id).modal('show');
            }, 500);
        }
        function sendMessagePopUp(otherid) {
            var message = $('#message' + otherid).val();
            if (message) {
                var data = new FormData();
                chat_type = $('#chat_type').val();
                chat_type_id = $('#chat_type_id').val();
                data.append('receiver_id', otherid);
                data.append('message_type', chat_type);
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
                        success: function (data) {
                            $('#modal_new_messages' + otherid).modal('hide');
                            $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                            //                                    $('#attachment_loader').hide();
                            //                                    $('.tiny-div, .files_upload_box').hide();
                            result = JSON.parse(data);
                            //                                    $('.chat_box_wrapper .chat').append(result.append);
                            //                                    $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                            socket.emit('messagegroup_send', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": result.other_message,
                                "chat_id": result.chat_id,
                                "message": message
                            });
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                "url": '<?= asset('messages/') ?>',
                                "chat_id": result.chat_id
                            });
                            setTimeout(function () {
                                window.location.reload();
                            }, 500);
                        }
                    });
                }
            }
        }

    </script>
     <?php if ($current_user) { ?>
        <script>
            function sendMessageToFriends(otherid) {

                var recivers_array = [];
                var message = $('#message' + otherid).val();
                var title = $('#title' + otherid).val();
                var group_id = $('#group_id').val();
                var accompanist_id = $('#accompanist_id').val();

                if (message) {
                    recivers = $('#bulk-messages' + otherid).val();
                    counter = 0;
                    $.each(recivers, function (index, item) {
                        recivers_array.push(item);
                    });
                    
                    var data = new FormData();
                    
                    if(files){
                        $.each(files, function (key, value)
                        {
                            data.append('file', value);
                        });
                    }
                    data.append('message', message);
                    data.append('receiver_id', recivers_array);
                    data.append('title', title);
                    data.append('type_id', accompanist_id);
                    data.append('_token', '<?= csrf_token() ?>');
                    data.append('message_type', 'a');
                    
                    
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
                            url: "<?php echo asset('message_to_group_members'); ?>",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('#modal_friends_message').modal('hide');
                                counter++;
                                if (counter == 1) {
                                    $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                                }
                                //                                    $('#attachment_loader').hide();
                                //                                    $('.tiny-div, .files_upload_box').hide();
                                var result = JSON.parse(data);
                                //                                    $('.chat_box_wrapper .chat').append(result.append);
                                //     
                                //                                                                   $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                recivers.push('<?=$current_id?>');
                                $.each(recivers, function (index, item) {

                                    socket.emit('groupmessage_get', {
                                        "user_id": item,
                                        "other_id": '<?php echo $current_id; ?>',
                                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>  added you in chat group ' + title,
                                        "photo": '<?php echo $current_photo; ?>',
                                        "group_member_profile_images": result.group_member_images,
                                        "text": result.other_message,
                                        "chat_id": result.chat_id,
                                        "message": message,
                                        "chat_type": 'a',
                                        "chat_type_id": group_id,
                                        "to_be_show": 'a',
                                        "chat_name" : title,
                                    });
                                
                                    if(item != <?=$current_id?>){
                                        socket.emit('notification_get', {
                                            "user_id": item,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' added you in chat group '+title ,
                                            "url": '<?= asset('accompanist_messages/') ?>/'+group_id,
                                            "chat_id": result.chat_id,
                                            "chat_type": 'a',
                                            "chat_type_id": group_id,
                                            "to_be_show": 'a',
                                            "chat_name" : title,
                                        });
                                    }
                                });
                            }
                        });
                    }

                }
            }

        </script>
    <?php } ?>

</html>