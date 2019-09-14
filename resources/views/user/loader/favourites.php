<?php
foreach ($posts as $post) {
    if ($post->post_id) {
        $owner_name = $post->posts->user->first_name . ' ' . $post->posts->user->last_name;
    } else if ($post->group_id) {
        $owner_name = $post->group->user->first_name . ' ' . $post->group->user->last_name;
    } else if ($post->teaching_studio_id) {
        $owner_name = $post->teachingStudio->user->first_name . ' ' . $post->teachingStudio->user->last_name;
    } else if ($post->accompanist_id) {
        $owner_name = $post->accompanist->user->first_name . ' ' . $post->accompanist->user->last_name;
    }
?>
    <tr id="single_fave_post_<?= $post->post_id?>">
        <td class="align-middle bookmark_name" data-header="Event Names">
            <div class="media align-items-center">
                <span class="icon_43 icon-bookmarks rounded-circle  mr-2"></span>
                <div class="media-body">
    <?php if ($post->post_type == 'image') { 
        $hrefLink = asset('get_post/'.$post->post_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s photo</a></strong>
                        <div class="date_time">Photo attachment</div>
    <?php } if ($post->post_type == 'text') { 
        $hrefLink = asset('get_post/'.$post->post_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s post</a></strong>
                        <div class="date_time"><?= $post->posts->text ?></div>
    <?php } if ($post->post_type == 'audio') { 
        $hrefLink = asset('get_post/'.$post->post_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s music track</a></strong>
                        <div class="date_time">Audio attachment</div>
    <?php } if ($post->post_type == 'video') { 
        $hrefLink = asset('get_post/'.$post->post_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’ video</a></strong>
                        <div class="date_time">Video attachment</div>
    <?php } if ($post->post_type == 'group') { 
        $hrefLink = asset('group_time_line/'.$post->group_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s group</a></strong>
                        <div class="date_time"><?=$post->group->name?></div>
    <?php } if ($post->post_type == 'teaching_studio') { 
        $hrefLink = asset('teaching_studio_time_line/'.$post->teaching_studio_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s teaching studio</a></strong>
                        <div class="date_time"><?=$post->teachingStudio->name?></div>
    <?php } if ($post->post_type == 'accompanist') { 
        $hrefLink = asset('accompanist_time_line/'.$post->accompanist_id);
        ?>
                        <strong><a href="<?=$hrefLink?>" class="text_darkblue user_name"><?= $owner_name ?>’s accompanist</a></strong>
                        <div class="date_time"><?=$post->accompanist->name?></div>
    <?php } ?>
                </div>
            </div>
        </td>
        <td class="bookmark_date" data-header="Time">
            <span class="text_darkblue"><?= timeago($post->created_at) ?></span>
        </td>
        <td class="bookmark_action" data-header="Actions">
            <div class="btns">
                <a href="<?= $hrefLink ?>" class="act_accept text-black">View</a>
                <a href="#" class="act_decline text_red" onclick="remove_bookmard('<?= $post->post_id?>','<?= $post->post_type?>')">Remove</a>
            </div>
        </td>
    </tr>
<?php } ?>