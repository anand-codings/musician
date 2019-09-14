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
        <input type="hidden" name="other_user_chat_id" id="other_user_chat_id" value="<?= $other_user_chat_id ?>">
        <?php
        $chat_type = 'u';
        $type_id = '';
        if ($latest_chat && $latest_chat->chat_type == 'g') {
            $chat_type = 'g';
            $type_id = $latest_chat->group_id;
        }
        if ($latest_chat && $latest_chat->chat_type == 'a') {
            $chat_type = 'a';
            $type_id = $latest_chat->accompanist_id;
        }
        if ($latest_chat && $latest_chat->chat_type == 's') {
            $chat_type = 's';
            $type_id = $latest_chat->studio_id;
        }
        ?>
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
                                        <h5 class="font-weight-bold text_darkblue">Messages
                                            <span class="new_messages_label"><?= $unread ?> New</span>
                                        </h5>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="new_chat_btn">
                                            <i data-toggle="modal" data-target="#followers_modal" class="fa fa-edit"></i>
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
                                    foreach ($chats as $chat) {
                                        if ($chat->chat_type == 'u') {
                                            $other_user = $chat->receiver;
                                            if ($chat->sender_id != $current_id) {
                                                $other_user = $chat->sender;
                                            }
                                            $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                            if ($other_user->is_online == 1) {
                                                $online_count++;
                                            }
                                        }
                                    }
                                    ?>  
                                    <p>Online Peoples <span>(<?= $online_count ?>)</span></p>
                                </div>
                                <div class="online-users-wrapper">
                                    <ul class="online-users-list d-flex ">
                                        <?php
                                        foreach ($chats as $chat) {
                                            if ($chat->chat_type == 'u') {
                                                $other_user = $chat->receiver;
                                                if ($chat->sender_id != $current_id) {
                                                    $other_user = $chat->sender;
                                                }
                                                $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                                if ($other_user->is_online == 1) {
                                                    $name = 'Private User';
                                                    $profile_url = '#';
                                                    if ($other_user->is_active) {
                                                        $name = $other_user->first_name . ' ' . $other_user->last_name;
                                                        $profile_url = asset('profile_timeline/' . $other_user->id);
                                                    }
                                                    ?>
                                                    <li id="check_if_online_<?= $other_user->id ?>" onclick="getOtherChat('chat_id_<?= $chat->id ?>', this, '<?= $chat->id ?>', '<?= $name ?>', '<?= $other_user->id ?>', '<?= $profile_url ?>', '<?php echo $other_image ?>', '0', '10', '<?= $other_user->is_active ?>', 'u', '')"><span class="bg_image_round user_active_status" style="background-image: url(<?php echo $other_image ?>) "><span class="active"></span></span></li>
                                                    <?php
                                                }
                                            }
                                        }
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
                                        foreach ($chats as $chat) {
                                            $i++;
                                            $other_user = $chat->receiver;
                                            if ($chat->sender_id != $current_id) {
                                                $other_user = $chat->sender;
                                            }
                                            $name = 'Private User';
                                            $profile_url = '#';
                                            if ($other_user->is_active) {
                                                $name = $other_user->first_name . ' ' . $other_user->last_name;
                                                $profile_url = asset('profile_timeline/' . $other_user->id);
                                            }
                                            $chat_type_sidebar = 'u';
                                            $chat_type_id_siderbar = '';
                                            $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                            if ($other_user->is_active && $chat->chat_type == 'g') {
                                                $chat_type_sidebar = 'g';
                                                $chat_type_id_siderbar = $chat->group->id;
                                                $name = $chat->group->name;
                                                $profile_url = asset('group_time_line/' . $chat->group->id);
                                                $pic = asset('public/images/profile_pics/demo.png');
                                                if ($chat->group->pic) {
                                                    $pic = asset('public/images/' . $chat->group->pic);
                                                }
                                                $other_image = $pic;
                                            }
                                            if ($other_user->is_active && $chat->chat_type == 'a') {
                                                $chat_type_sidebar = 'a';
                                                $chat_type_id_siderbar = $chat->accompanist->id;
                                                $name = $chat->accompanist->name;
                                                $profile_url = asset('accompanist_time_line/' . $chat->accompanist->id);
                                                $pic = asset('public/images/profile_pics/demo.png');
                                                if ($chat->accompanist->pic) {
                                                    $pic = asset('public/images/' . $chat->accompanist->pic);
                                                }
                                                $other_image = $pic;
                                            }
                                            if ($other_user->is_active && $chat->chat_type == 's') {
                                                $chat_type_sidebar = 's';
                                                $chat_type_id_siderbar = $chat->studio->id;
                                                $name = $chat->studio->name;
                                                $profile_url = asset('teaching_studio_time_line/' . $chat->studio->id);
                                                $pic = asset('public/images/profile_pics/demo.png');
                                                if ($chat->studio->pic) {
                                                    $pic = asset('public/images/' . $chat->studio->pic);
                                                }
                                                $other_image = $pic;
                                            }
                                            ?>
                                            <li data-id="<?= $chat->id ?>" id="single_chat_user<?= $chat->id ?>" class="chat_user_listing <?php if ($i == 1) { ?> active <?php } ?>" >
                                                <div class="list_outer_wrap d-flex">
                                                    <div class="custom-control custom-checkbox">
                                                        <input data-id="<?= $chat->id ?>" type="checkbox" name="" class="custom-control-input single_chat_list" id="user_select<?= $chat->id ?>">
                                                        <label class="custom-control-label no-top-padding txt_left" for="user_select<?= $chat->id ?>"></label>
                                                    </div>
                                                    <a href="#" id="chat_on_left_menu<?= $chat->id ?>" onclick="getOtherChat('chat_id_<?= $chat->id ?>', this, '<?= $chat->id ?>', '<?= $name ?>', '<?= $other_user->id ?>', '<?= $profile_url ?>', '<?php echo $other_image ?>', '0', '10', '<?= $other_user->is_active ?>', '<?= $chat_type_sidebar ?>', '<?= $chat_type_id_siderbar ?>')">
                                                        <div class="d-flex">
                                                            <div>
                                                                <span class="bg_image_round user_active_status" style="background-image: url(<?php echo $other_image ?>) ">
                                                                    <?php if ($other_user->is_online == 1) { ?>
                                                                        <span class="active"></span>
                                                                    <?php } ?>

                                                                </span>
                                                            </div>
                                                            <div class="info">
                                                                <div class="d-flex align-items-center">
                                                                    <div class="name"><?= $name ?></div>
                                                                    <span class="time"><?= timeago($chat->updated_at) ?></span>
                                                                </div>
                                                                <div class="msg">
                                                                    <?php
                                                                    $length = strlen($chat->lastMessage->message);
                                                                    $add_dot = '';

                                                                    if ($length > 65) {
                                                                        $add_dot = '...';
                                                                    }
                                                                    if (strpos($chat->lastMessage->message, 'ifram') !== false) {
                                                                        echo 'Embeded Code';
                                                                    } else {
                                                                        echo substr($chat->lastMessage->message, 0, 65) . $add_dot;
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
                                        <?php } ?>
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
                                        $name = 'Private User';
                                        $profile_url = '#';
                                        if ($other_message_user->is_active && $latest_chat->chat_type == 'u') {
                                            $name = $other_message_user->first_name . ' ' . $other_message_user->last_name;
                                            $profile_url = asset('profile_timeline/' . $other_message_user->id);
                                            $main_image = getUserImage($other_message_user->photo, $other_message_user->social_photo, $other_message_user->gender);
                                        }
                                        if ($latest_chat->chat_type == 'g') {
                                            $profile_url = asset('group_time_line/' . $latest_chat->group_id);
                                            $name = $latest_chat->group->name;
                                            $main_image = asset('public/images/profile_pics/demo.png');
                                            if ($latest_chat->group->pic) {
                                                $main_image = asset('public/images/' . $latest_chat->group->pic);
                                            }
                                        }
                                        if ($latest_chat->chat_type == 'a') {
                                            $profile_url = asset('accompanist_time_line/' . $latest_chat->accompanist_id);
                                            $name = $latest_chat->accompanist->name;
                                            $main_image = asset('public/images/profile_pics/demo.png');
                                            if ($latest_chat->accompanist->pic) {
                                                $main_image = asset('public/images/' . $latest_chat->accompanist->pic);
                                            }
                                        }
                                        if ($latest_chat->chat_type == 's') {
                                            $profile_url = asset('teaching_studio_time_line/' . $latest_chat->studio_id);
                                            $name = $latest_chat->studio->name;
                                            $main_image = asset('public/images/profile_pics/demo.png');
                                            if ($latest_chat->studio->pic) {
                                                $main_image = asset('public/images/' . $latest_chat->studio->pic);
                                            }
                                        }
                                        ?>
                                        <div class="media align-items-center">
                                            <span id="other_user_image" class="bg_image_round" onclick="location.href = '<?= $profile_url ?>'" style="background-image: url(<?php echo $main_image; ?>)">
                                            </span>
                                            <div class="media-body line-height-13">
                                                <a id="active_user_name" href="<?= $profile_url ?>" class="text_darkblue font-18 font-weight-bold"><?= $name ?></a>
                                                <div id="online_section" <?php if ($other_message_user->is_online != 1) { ?> style="display: none" <?php } ?> class=" align-items-center">
                                                    <span class="active_status"></span> Online
                                                </div>
                                            </div>

                                        </div>
                                    <?php } ?><!-- media -->
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
                                            $chat_count++;
                                            if ($chat_count == 1) {
                                                ?>
                                                <input type="hidden" name="chat_id_scroll" id="chat_id_scroll" value="<?= $message->chat_id ?>">
                                                <?php
                                            }
                                            if ($message->sender_id == $current_id) {
                                                ?>
                                                <li class="right" id="single_message<?= $message->id ?>">
                                                    <div class="d-flex flex-row-reverse">
                                                        <figure>
                                                            <?php
                                                            if ($message->message_type == 'g' && $message->group->admin_id == $current_id) {
                                                                $pic = asset('public/images/profile_pics/demo.png');
                                                                if ($message->group->pic) {
                                                                    $pic = asset('public/images/' . $message->group->pic);
                                                                }
                                                                ?>
                                                                <span class="bg_image_round" onclick="location.href = '<?= asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php echo $pic ?>)"></span>
                                                                <?php
                                                            } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) {
                                                                $pic = asset('public/images/profile_pics/demo.png');
                                                                if ($message->studio->pic) {
                                                                    $pic = asset('public/images/' . $message->studio->pic);
                                                                }
                                                                ?>  
                                                                <span class="bg_image_round" onclick="location.href = '<?= asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php echo $pic ?>)"></span>
                                                                <?php
                                                            } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) {
                                                                $pic = asset('public/images/profile_pics/demo.png');
                                                                if ($message->accompanist->pic) {
                                                                    $pic = asset('public/images/' . $message->accompanist->pic);
                                                                }
                                                                ?>

                                                            <?php } else { ?>
                                                                <span class="bg_image_round" onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="background-image: url(<?php echo $current_photo ?>)"></span>
                                                            <?php } ?>
                                                        </figure>
                                                        <div class="chat_body">
                                                            <?php if ($message->message_type == 'g' && $message->group->admin_id == $current_id) { ?>
                                                                <div onclick="location.href = '<?= asset('group_time_line/' . $message->group->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $message->group->name ?></div>   
                                                            <?php } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) { ?>
                                                                <div onclick="location.href = '<?= asset('accompanist_time_line/' . $message->accompanist->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $message->accompanist->name ?></div>   
                                                            <?php } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) { ?>
                                                                <div onclick="location.href = '<?= asset('teaching_studio_time_line/' . $message->studio->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $message->studio->name ?></div>   
                                                            <?php } else { ?>
                                                                <div onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $current_name ?></div>
                                                            <?php } ?>
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
                                                if ($other_message_user->is_active && $message->message_type == 'u') {
                                                    $name = $other_message_user->first_name . ' ' . $other_message_user->last_name;
                                                    $profile_url = asset('profile_timeline/' . $other_message_user->id);
                                                    $profile_pic = getUserImage($other_message_user->photo, $other_message_user->social_photo, $other_message_user->gender);
                                                }
                                                if ($message->message_type == 'g') {

                                                    $profile_pic = asset('public/images/profile_pics/demo.png');
                                                    if ($message->group->pic) {
                                                        $profile_pic = asset('public/images/' . $message->group->pic);
                                                    }
                                                    $profile_url = asset('group_time_line/' . $message->group_id);
                                                    $name = $message->group->name;
                                                }
                                                if ($message->message_type == 's') {

                                                    $profile_pic = asset('public/images/profile_pics/demo.png');
                                                    if ($message->studio->pic) {
                                                        $profile_pic = asset('public/images/' . $message->studio->pic);
                                                    }
                                                    $profile_url = asset('group_time_line/' . $message->studio_id);
                                                    $name = $message->studio->name;
                                                }
                                                if ($message->message_type == 'a') {

                                                    $profile_pic = asset('public/images/profile_pics/demo.png');
                                                    if ($message->accompanist->pic) {
                                                        $profile_pic = asset('public/images/' . $message->accompanist->pic);
                                                    }
                                                    $profile_url = asset('accompanist_time_line/' . $message->accompanist_id);
                                                    $name = $message->accompanist->name;
                                                }
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
                                <?php } ?>
                            </div>

                        </div> <!-- message Box wrap -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>          
    </body>
    <script>
        var url_chat_id = "<?=(isset($_GET['chat_id']) && $_GET['chat_id']) ? $_GET['chat_id'] : ''?>";
        if (url_chat_id) {
           $('#chat_on_left_menu'+url_chat_id).trigger('click'); 
        }
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
                            getOtherChat('', 'ajax', chat_id_scroll, other_name, other_id, url_scroll, image, skip_scroll, 10, '');
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
                    

                    chat_type = $('#chat_type').val();
                    chat_type_id = $('#chat_type_id').val();
                    var chat_url = '<?= asset('messages') ?>';
                    if (chat_type == 'a') {
                        var chat_url = '<?= asset('accompanist_messages') ?>' + '/' + chat_type_id;
                    }
                    if (chat_type == 'g') {
                        var chat_url = '<?= asset('group_messages') ?>' + '/' + chat_type_id;
                    }
                    if (chat_type == 's') {
                        var chat_url = '<?= asset('studio_messages') ?>' + '/' + chat_type_id;
                    }
                    var otherid = $('#other_user_chat_id').val();
                    data.append('message', message);
                    data.append('receiver_id', otherid);
                    data.append('message_type', chat_type);
                    data.append('type_id', chat_type_id);
                    data.append('_token', '<?= csrf_token() ?>');
                    $('#messagetext').val('');
                    if (/\S/.test(message) || files) {
                        files = '';
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add_message'); ?>",
                            data: data,
                            processData: false,
                            contentType: false,
                            success: function (data) {
                                $('#attachment_loader').hide();
                                $('.tiny-div, .files_upload_box').hide();
                                result = JSON.parse(data);
                                $('.chat_box_wrapper .chat').append(result.append);
                                $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                socket.emit('message_get', {
                                    "user_id": otherid,
                                    "other_id": '<?php echo $current_id; ?>',
                                    "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                    "photo": '<?php echo $current_photo; ?>',
                                    "text": result.other_message,
                                    "chat_id": result.chat_id,
                                    "message": message,
                                    "chat_type": chat_type,
                                    "chat_type_id": chat_type_id,
                                    "to_be_show": chat_type
                                });
                                socket.emit('notification_get', {
                                    "user_id": otherid,
                                    "other_id": '<?php echo $current_id; ?>',
                                    "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                    "photo": '<?php echo $current_photo; ?>',
                                    "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                    "url": chat_url,
                                    "is_message_notification": 1,
                                    "chat_id": result.chat_id,
                                    "chat_type": chat_type,
                                    "chat_type_id": chat_type_id,
                                    "to_be_show": chat_type
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
        socket.on('message_send', function (data) {
            if (data.user_id == current_id && other_id == data.other_id && data.to_be_show == 'u') {
                other_id = $('#other_user_chat_id').val();
                var listItems = $(".chat_user_listing");
                var li_exists = '';
                listItems.each(function (idx, li) {
                    var chat_id = ($(li).data('id'));
                    if (chat_id == data.chat_id) {
                        li_exists = '1';
                    }
                });
                if (!li_exists) {
                    chat_li = '<li data-id="' + data.chat_id + '" id="single_chat_user' + data.chat_id + '" class="chat_user_listing" >' +
                            '<div class="list_outer_wrap d-flex">' +
                            '<div class="custom-control custom-checkbox">' +
                            '<input data-id="' + data.chat_id + '" type="checkbox" name="" class="custom-control-input single_chat_list" id="user_select' + data.chat_id + '">' +
                            '<label class="custom-control-label no-top-padding txt_left" for="user_select' + data.chat_id + '"></label>' +
                            '</div>' +
                            '<a href="#" onclick="getOtherChat(\'chat_id_' + data.chat_id + '\', this, \'' + data.chat_id + '\', \'' + data.other_name + '\', \'' + base_path + '/' + data.other_id + '\',, \'' + data.photo + '\',,\'' + 0 + '\',,\'' + 10 + '\',,\'' + 1 + '\')">' +
                            '<div class="d-flex">' +
                            '<div>' +
                            '<span class="bg_image_round user_active_status" style="background-image: url(' + data.photo + ') ">' +
                            '<span class="active"></span>' +
                            '</span></div> <div class="info"><div class="d-flex align-items-center">' +
                            '<div class="name">' + data.other_name + '</div>' +
                            '<span class="time">Just now</span>' +
                            '</div> <div class="msg">' +
                            data.message +
                            '</div></div></div></a><ul class="un_style no_icon action_dropdown float-right">' +
                            '</ul></div></li>';
                    $('#chat_user_filter_listing').prepend(chat_li);
                }
                $('.chat_box_wrapper .chat').append(data.text);
                $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
            }
        });

        function getOtherChat(id, ele, chat_id, other_name, other_id, url, image, skip, take, is_active, type = '', type_id = '') {
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
                    url: "<?php echo asset('get_chat'); ?>",
                    success: function (data) {
                        if (data) {
                            responce_data = data;
                            if (skip == 0) {
                                if ($('#check_if_online_' + other_id).length) {
                                    $('#online_section').show();
                                } else {
                                    $('#online_section').hide();
                                }
                                $('#chat_list').append(data);
                                $('#active_user_name').html(other_name);
                                $('#active_user_name').attr('href', url);
                                $('#other_user_image').attr('href', url);
                                $('#other_user_image').css('backgroundImage', 'url(' + image + ')');
                            } else {
                                $('#chat_list').prepend(data);
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
                url: "<?php echo asset('delete_message'); ?>",
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
                        url: '<?= asset('delete_multiple_chats') ?>',
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
                            socket.emit('message_get', {
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
</html>