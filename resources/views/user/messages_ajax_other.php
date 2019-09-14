<?php foreach ($messages as $message) { ?>
    <li>
        <div class="d-flex">
            <figure>
                <span class="bg_image_round" onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="background-image: url(<?php echo $current_photo ?>)"></span>
            </figure>
            <div class="chat_body">
                <div onclick="location.href = '<?= asset('profile_timeline/' . $current_id) ?>'" style="cursor: pointer;" class="font-weight-bold text_darkblue"><?= $current_name ?></div>
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
?>