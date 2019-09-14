<?php foreach ($records as $record) { ?>
    <li>
        <?php if ($record->type == 'image') { ?>
            <a data-fancybox="images" href="<?= asset($record->path) ?>">
                <div class="gallery_image">
                    <img src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer" alt="" />
                    <div class="img" style="background-image:url(<?= asset('public/images/posts/thumnails/' . $record->poster) ?>)"></div>
                </div>
            </a>
            <?php if ($current_id && $current_id == $user_id) { ?>
                <i class="fas fa-times-circle delete_gallery_media" gallery-media-id="<?= $record->id ?>"></i>
            <?php } ?>
        <?php } else if ($record->type == 'video') { ?>
            <video controls="controls" style="width: 100%;height: 100%;">
                <source src="<?= asset($record->path) ?>">
                <p>Your browser does not support the video tag.</p>
            </video>
            <?php if ($current_id && $current_id == $user_id) { ?>
                <i class="fas fa-times-circle delete_gallery_media" gallery-media-id="<?= $record->id ?>"></i>
            <?php } ?>
        <?php } else if ($record->type == 'audio') { ?>
            <div class="audio_box">
                <audio controls>
                    <source src="<?= asset($record->path) ?>">
                    Your browser does not support the audio element.
                </audio>
                <?php if ($current_id && $current_id == $user_id) { ?>
                    <i class="fas fa-times-circle delete_gallery_media" gallery-media-id="<?= $record->id ?>"></i>
                <?php } ?>
            </div>
        <?php } ?>
    </li>
<?php } ?>