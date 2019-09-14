<div class="modal fade modal_post" id="modal_post_image<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <i class="fas fa-times"></i>
    </button>            
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="post_popup d-flex">
                    <div class="left_side">
                        <?php if ($post->type == 'video') { ?>
                            <video poster="<?= asset('public/images/posts/posters/'.$post->getFile->poster)?>" controls id="video_popup_<?= $post->id ?>">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } if ($post->type == 'image') { ?>
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <div class="image-view" style="background-image: url(<?php echo asset($post->getFile->file) ?>)"></div>
                                    </div>

                                </div>
                            </div>
                        <?php } ?>
                        <ul class="un_style no_icon action_dropdown float-right">
                            <!--                                    <li class="dropdown">
                                                                    <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                        <i class="fas fa-ellipsis-h"></i>
                                                                    </a>
                                                                    <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                        <a class="dropdown-item" href="http://localhost/musician/edit_post/23"><i class="fas fa-copy"></i> Edit</a>
                                                                        <a onclick="copyPostLink(23)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_23"><i class="fas fa-share-alt"></i> Share</a>
                                                                    </div>
                                                                </li>-->
                        </ul>
                    </div>
                    <div class="right_side">
                        <div class="scroll_area">
                            <div class="post-head d-flex align-items-center">
                                <div class="d-flex">
                                    <div class="pull-left">
                                        <span class="bg_image_round w-50"  style="background-image: url(<?= getUserImage($post->user->photo, $post->user->social_photo, $post->user->gender) ?>)"></span>
                                    </div>
                                    <div>
                                        <a href="<?= asset('profile_timeline/' . $post->user->id) ?>" class="u_name"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                                        <div class="type"><?php
                                            if ($post->user->type == 'artist') {
                                                if (!$post->user->getSelectedCategories->isEmpty()) {
                                                    $getSelectedArtistTypesCount = $post->user->getSelectedCategories->count();

                                                    if ($getSelectedArtistTypesCount <= 2) {
                                                        $i = 1;
                                                        foreach ($post->user->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($getSelectedArtistTypesCount > $i)
                                                                echo ', ';
                                                            $i++;
                                                        }
                                                    } else {
                                                        $i = 1;
                                                        foreach ($post->user->getSelectedCategories as $selectedArtistType) {
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
                                                    <?php
                                                }
                                            }
                                            ?></div>
                                    </div>
                                </div>
                                <div class="ml-auto">
                                    <span class="time"> <?php echo timeago($post->created_at); ?> </span>
                                </div>
                            </div>
                            <div class="post_body">
                                <?php
//                                        if (strpos($post->text, '<iframe') === false) {
                                $post_text = preg_replace('/<iframe.*?\/iframe>/i', '', $post->text);
                                if (strlen($post_text) > 420) {
                                    $post_text = substr($post_text, 0, 420);
                                    ?>
                                    <?= $post_text ?>
                                    <span class="elipsis">...</span>
                                    <a href="javascript:void(0)" onclick="seeAllPostData(this)" class="see_all_post"> see more</a>
                                    <span class="see_all_post_data"><?= substr($post->text, 420) ?></span>
                                <?php } else { ?>
                                    <?= $post_text ?>
                                <?php } ?>
                            </div>
                            <nav class="nav t_post_action_btns">
                                <?php if (Auth::user()) { ?>
                                    <a id="wall-post-single-dislike-<?= $post->id; ?>" onclick="dislike_post('<?= $post->id; ?>')" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?> class="nav-link share_post done wall-post-single-dislike-<?= $post->id; ?>" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Liked </a>
                                    <a id="wall-post-single-like-<?= $post->id; ?>" onclick="like_post('<?= $post->id; ?>')" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?> class="nav-link share_post wall-post-single-like-<?= $post->id; ?>" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Like </a>
                                <?php } else { ?>
                                    <!--<a href="<?= asset('/') ?>"> <i class="fas fa-thumbs-up" style="font-size: 17px;"></i> Like </a>-->
                                <?php } if (Auth::user()) { ?>
                                    <a onclick="focustextareaPopUp('<?= $post->id ?>')" class="nav-link" href="javascript:void(0)"><i class="fas fa-comment-alt"></i> Comment</a>
                                <?php } ?>
<!--<a class="nav-link" href="#"><i class="fas fa-share"></i> Share</a>-->
                                <?php if (Auth::user()) { ?>
                                    <a id="wall-post-single-bookmarkremove-<?= $post->id; ?>" class="wall-post-single-bookmarkremove-<?= $post->id; ?> nav-link bookmark done" onclick="remove_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" href="javascript:void(0)" <?php if (!$post->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart"></i> Favorite</a>
                                    <a id="wall-post-single-bookmarkadd-<?= $post->id; ?>" class="wall-post-single-bookmarkadd-<?= $post->id; ?> nav-link bookmark" onclick="add_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" <?php if ($post->bookmarked_count) { ?> style="display: none" <?php } ?> href="javascript:void(0)"><i class="fas fa-heart"></i> Favorite</a>
                                <?php } else { ?>
                                    <!--<a class="nav-link bookmark" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i> Favorite</a>-->
                                <?php } ?>
                            </nav>
                            <nav class="nav post_counter">
                                <span class="open_likes_modal" data-post-id="<?= $post->id ?>"><span class="likes_counter<?= $post->id ?>"><?=$post->likes->count()?></span> Likes</span>
                                <span class="ml-auto"><span class="comments_counter<?= $post->id ?>"><?= $post->comments->count() ?></span> Comments</span>
                            </nav>
                            <div class="post_comments_section">
                                <div class="view_comments">
                                    <?php if ($post->comments_count > 5) { ?>
                                        <span class="hide_all_comments<?= $post->id ?>" href="#" onclick="showall_comments('<?= $post->id ?>')">View Previous Comments</span>
                                    <?php } ?>
                                </div>
                                <ul class="comments_list un_style wall-comments-area-pop-up<?= $post->id ?>">
                                    <?php
                                    if (isset($post_single_comment)) {
                                        $comments = $post_single_comment;
                                    } else {
//    $comments = $post->comments->take(5);
                                        $comments = $post->comments;
                                    }
                                    $total_comments = count($comments);
                                    $i = 1;
                                    foreach ($comments as $comment) {
                                        ?>
                                        <li class="comments_hidden<?= $post->id ?>" <?php if ($total_comments > 5 && $i <= $total_comments - 5) { ?> style="display: none" <?php }$i++; ?>>
                                            <div class="d-flex">
                                                <figure class="figure mr-2 sx-mr-2">
                                                    <span class="bg_image_round w-35" style="background-image: url('<?php echo getUserImage($comment->user->photo, $comment->user->social_photo, $comment->user->gender) ?>')">
                                                        <?php if ($comment->user->is_online && $comment->user_id != $current_id) { ?>
                                                            <span class="active_status absolute"></span>
                                                        <?php } ?></span>                
                                                </figure>
                                                <div class="comment_body">
                                                    <div class="comment_meta">
                                                        <div class="d-flex">
                                                            <a href="<?= asset('profile_timeline/' . $comment->user->id) ?>"><span class="font-weight-bold text_darkblue"><?= $comment->user->first_name . ' ' . $comment->user->last_name ?></span></a>
                                                            <span class="text_grey ml-auto font-14 hidden-md"> <?= timeago($comment->created_at) ?> </span>
                                                        </div>
                                                        <div class="font-14"><?= getMentions($comment->comment) ?></div>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="post_footer">
                            <?php if (Auth::user()) { ?>
                                <div class="d-flex">
                                    <div class="mr-2">
                                        <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= $current_photo ?>"></span>
                                    </div>

                                    <div class="w-100">
                                        <form class="t_post_comment_form flex-grow-1">
                                            <textarea id="add_comment_popup_<?= $post->id ?>" onkeyup="postCommentPopUp(event, this, <?= $post->id; ?>, '0')" placeholder="Write comment.." class="form-control mention_pop_up<?= $post->id ?>"></textarea>
                                            <input onclick="postCommentPopUp(event, this, '<?= $post->id ?>', '1')" type="button" value="Send">
                                        </form>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div> <!-- modal-body-->
        </div> <!-- modal-content-->
    </div>
</div> <!-- modal -->
<script>
    if ($('.post_popup .scroll_area').length > 0) {
        $('.post_popup .scroll_area').mCustomScrollbar();
    }
</script>