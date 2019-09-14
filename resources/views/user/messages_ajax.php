<?php
$chat_count = 0;
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
//                    if ($message->message_type == 'g' && $message->group->admin_id == $current_id) {
//                        $pic = asset('public/images/profile_pics/demo.png');
//                        if ($message->group->pic) {
//                            $pic = asset('public/images/' . $message->group->pic);
//                        }
                        ?>
                        <!--<span class="bg_image_round" onclick="location.href = '<?php // echo  asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php // echo $pic ?>)"></span>-->
                        <?php
//                    } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) {
//                        $pic = asset('public/images/profile_pics/demo.png');
//                        if ($message->studio->pic) {
//                            $pic = asset('public/images/' . $message->studio->pic);
//                        }
                        ?>  
                        <!--<span class="bg_image_round" onclick="location.href = '<?php // echo  asset('group_time_line/' . $message->group_id) ?>'" style="background-image: url(<?php // echo $pic ?>)"></span>-->
                        <?php
//                    } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) {
//                        $pic = asset('public/images/profile_pics/demo.png');
//                        if ($message->accompanist->pic) {
//                            $pic = asset('public/images/' . $message->accompanist->pic);
//                        }
                        ?>

                    <?php // } else { ?>

                        <span class="bg_image_round" onclick="location.href = '<?php echo  asset('profile_timeline/' . $current_id) ?>'" style="background-image: url(<?php echo $current_photo ?>)"></span>
                    <?php // } ?>
                </figure>
                <div class="chat_body">
                    <?php //if ($message->message_type == 'g' && $message->group->admin_id == $current_id) { ?>
                        <!--<div onclick="location.href = '<?php // echo asset('group_time_line/' . $message->group->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $message->group->name ?></div>-->   
                    <?php // } elseif ($message->message_type == 'a' && $message->accompanist->admin_id == $current_id) { ?>
                        <!--<div onclick="location.href = '<?php // echo asset('accompanist_time_line/' . $message->accompanist->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $message->accompanist->name ?></div>-->   
                    <?php // } elseif ($message->message_type == 's' && $message->studio->admin_id == $current_id) { ?>
                        <!--<div onclick="location.href = '<?php // echo asset('teaching_studio_time_line/' . $message->studio->id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?php // echo $current_name ?></div>-->   
                    <?php // } else { ?>
                        <div onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue text-right"><?= $current_name ?></div>
                    <?php // } ?>
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
        if ($other_message_user->is_active) {
            $name = $message->sender->first_name.' '.$message->sender->last_name;
            $profile_url = asset('profile_timeline/' . $message->sender->id);
            $profile_pic = getUserImage($message->sender->photo, $message->sender->social_photo, $message->sender->gender);
        }
//        if ($message->message_type == 'u' && $message->group->admin_id == $other_message_user->id) {
//
//            $profile_pic = asset('public/images/profile_pics/demo.png');
//            if ($message->sender->photo) {
//                $profile_pic = asset('public/images/' . $message->sender->photo);
//            }
//            $profile_url = asset('profile_timeline/' . $message->sender->id);
//            $name = $message->sender->first_name.' '.$message->sender->last_name;
//        }
//        if ($message->message_type == 's' && $message->studio->admin_id == $other_message_user->id) {
//
//            $profile_pic = asset('public/images/profile_pics/demo.png');
//            if ($message->studio->pic) {
//                $profile_pic = asset('public/images/' . $message->studio->pic);
//            }
//            $profile_url = asset('group_time_line/' . $message->studio_id);
//            $name = $message->studio->name;
//        }
//        if ($message->message_type == 'a' && $message->accompanist->admin_id == $other_message_user->id) {
//
//            $profile_pic = asset('public/images/profile_pics/demo.png');
//            if ($message->accompanist->pic) {
//                $profile_pic = asset('public/images/' . $message->accompanist->pic);
//            }
//            $profile_url = asset('accompanist_time_line/' . $message->accompanist_id);
//            $name = $message->accompanist->name;
//        }
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
?>