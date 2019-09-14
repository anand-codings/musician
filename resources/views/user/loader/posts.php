
<?php

use Jenssegers\Agent\Agent;

$agent = new Agent();
//show musician timeline only to its followers
    foreach ($posts as $post) {
        if($post->privacy == 'public')
        {
            ?>
            <input style="display: none" type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get_post/' . $post->id) ?>" >
            <div class="timeline-post clearfix" id="single-post-<?= $post->id ?>">
                <div class="t_post_heads d-flex clearfix">
                    <div class="media align-items-sm-start align-items-md-center">
                        <span class="bg_image_round" style="background-image: url(<?= getUserImage($post->user->photo, $post->user->social_photo, $post->user->gender) ?>)"></span>
                        <div class="media-body line-height-13">
                            <a href="<?= asset('profile_timeline/' . $post->user->id) ?>" class="u_name"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                            <?php if($post->post_type != 'u'){
                                echo 'Posted As ';
                                if($post->post_type == 'g'){ ?>
                                    <img style="height: 20px;width: 20px" src="<?= asset('userassets/images/icon-event.png')?>">
                                    <a href="<?= asset('gig_detail/' . $post->gig->id) ?>" class="u_name"><?= $post->gig->title ?></a>
                                <?php } if($post->post_type == 'e'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/group.png')?>">
                                    <a href="<?= asset('group_time_line/' . $post->events->id) ?>" class="u_name"><?= $post->events->name ?></a>
                                <?php } if($post->post_type == 's'){ ?>
                                    <img  style="height: 20px;width: 20px" src="<?= asset('userassets/images/studio.png')?>">
                                    <a href="<?= asset('teaching_studio_time_line/' . $post->studio->id) ?>" class="u_name"><?= $post->studio->name ?></a>
                                <?php } if($post->post_type == 'a'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/pianist.png')?>">
                                    <a href="<?= asset('accompanist_time_line/' . $post->accompanist->id) ?>" class="u_name"><?= $post->accompanist->name ?></a>
                                <?php }}?>
                            <div class="text_red_dark">
                                <?php
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
                                ?>
                            </div>
                            <span class="time_mobile"> <?php echo timeago($post->created_at); ?> </span>
                        </div>
                    </div> <!-- media -->
                    <div class="ml-auto align-self-center">
                        <ul class="un_style no_icon action_dropdown float-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true"
                                   class="dropdown-toggle">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                    <?php if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="<?= asset('edit_post/' . $post->id) ?>"><i class="fas fa-copy"></i> Edit</a>
                                    <?php } ?>
                                    <a onclick="copyPostLink(<?= $post->id; ?>)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $post->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                                    <?php if ($post->user_id != $current_id) { ?>
                                        <a <?php if ($post->reported) { ?> style="display: none" <?php } ?> id="report_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_reporting_<?= $post->id ?>"><i class="fas fa-flag"></i> Report</a>

                                        <a <?php if (!$post->reported) { ?> style="display: none" <?php } ?> id="reported_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" ><i class="fas fa-flag"></i> Reported</a>
                                    <?php } if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete_<?= $post->id ?>"><i class="fas fa-copy"></i> Delete</a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <span class="time_desktop"> <?php echo timeago($post->created_at); ?> </span>
                    </div> <!-- ml-auto -->
                </div> <!-- timeline header -->
                <?php if ($post->text) { ?>
                    <div class="t_post_content">
                        <p>
                            <?php
                            $post_text = $post->text;
                            if (strpos($post_text, 'youtube.com/') !== false && strpos($post_text, 'iframe') === false) {
                                ?>
                                <?php
                                $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $post_text);
                                echo $iframe;
                                ?>
                                <?php
                            } else {
                                if (strlen($post_text) > 420) {
                                    $post_text = substr($post_text, 0, 420);
                                    ?>
                                    <?= $post_text ?>
                                    <span class="elipsis">...</span>
                                    <a href="javascript:void(0)" onclick="seeAllPostData(this)" class="see_all_post"> see more</a>
                                    <span class="see_all_post_data"><?= substr($post->text, 420) ?></span>
                                <?php } else { ?>
                                    <?= getMentions($post_text) ?>
                                    <?php
                                }
                            }
                            ?>
                        </p>
                    </div>
                <?php } ?>
                <?php if ($post->type == 'video') { ?>
                    <div class="post-media video">
                        <?php if ($agent->isDesktop()) { ?>
                            <video poster="<?= asset('public/images/posts/posters/'.$post->getFile->poster)?>" style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  controls onclick="this.play();playVideo('<?= $post->id ?>')">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } else { ?>
                            <video  controls onclick="this.play()">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                    </div>
                    <?php include 'image_popup.php'; ?>
                <?php } if ($post->type == 'audio') { ?>
                    <div class="post-media audio">
                        <audio controls>
                            <source src="<?php echo asset($post->getFile->file) ?>" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio></div>
                <?php } if ($post->type == 'image') { ?>
                    <div class="post-media image">
                        <?php if ($agent->isDesktop()) { ?>
                            <img style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                        <?php } else {
                            if (!isset($is_shown)) { ?>
                                <a href="<?= asset('get_post/' . $post->id) ?>">
                            <?php } ?>
                            <img style="cursor: pointer"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                            <?php if (!isset($is_shown)) { ?> </a>

                            <?php }
                        } ?>
                    </div>

                    <?php
                    include 'image_popup.php';
                }
                ?>
                <nav class="nav t_post_action_btns">
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-dislike-<?= $post->id; ?>" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a onclick="dislike_post('<?= $post->id; ?>')"  class="nav-link share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Liked </a>
                        </div>
                        <div class="wall-post-single-like-<?= $post->id; ?>" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a id="" onclick="like_post('<?= $post->id; ?>')"  class="nav-link share_post " href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Like </a>
                        </div>
                    <?php } else { ?>
                        <!--<a href="<?= asset('/') ?>"> <i class="fas fa-thumbs-up" style="font-size: 17px;"></i> Like </a>-->
                    <?php } if (Auth::user()) { ?>
                        <a onclick="focustextarea('<?= $post->id ?>')" class="nav-link" href="javascript:void(0)"><i class="fas fa-comment-alt"></i> Comment</a>
                    <?php } ?>
                    <!--<a class="nav-link" href="#"><i class="fas fa-share"></i> Share</a>-->
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-bookmarkremove-<?= $post->id; ?>" <?php if (!$post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark done" onclick="remove_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" href="javascript:void(0)" ><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                        <div class="wall-post-single-bookmarkadd-<?= $post->id; ?>" <?php if ($post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark" onclick="add_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')"  href="javascript:void(0)"><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                    <?php } else { ?>
                        <!--<a class="nav-link bookmark" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i> Favorite</a>-->
                    <?php } ?>
                </nav> <!-- nav -->
                <nav class="nav post_counter">
                    <span class="open_likes_modal" data-post-id="<?= $post->id ?>"><span class="likes_counter<?= $post->id ?>"><?=$post->likes->count()?></span> Likes</span>
                    <span class="ml-auto"><span class="comments_counter<?= $post->id ?>"><?= $post->comments->count() ?></span> Comments</span>
                </nav> <!-- nav -->
                <div class="modal fade" id="likes_modal<?= $post->id ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content edit-event-popup">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create_gig_modal">Likes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div> <!-- modal header -->
                            <div class="modal-body">
                                <ul class="followers_list un_style" id="likes_modal_ul<?= $post->id ?>">
                                    <?php foreach ($post->likes as $like) { ?>
                                        <?php
                                        $member = $like->user;
                                        $memberImage = getUserImage($member->photo, $member->social_photo, $member->gender);
                                        ?>
                                        <li data-is-my-like="<?= ($member->id == $current_id) ? '1' : '' ?>" data-post-id="<?=$post->id?>">
                                            <div class="media align-items-center">
                                                <figure class="figure mr-3 sx-mr-2">
                                            <span class="bg_image_round w-40" onclick="window.location.href='<?= asset('profile_timeline/' . $member->id) ?>';" style="cursor: pointer; background-image: url(<?php echo $memberImage ?>)">
                                                <?php if ($member->is_online && $member->id != $current_id) { ?>
                                                    <span class="active_status absolute"></span>
                                                <?php } ?>
                                            </span>
                                                </figure>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column flex-sm-row">
                                                        <div class="mb-2">
                                                            <a href="<?= asset('profile_timeline/' . $member->id) ?>" class="u_name"><?= $member->first_name . ' ' . $member->last_name ?></a>
                                                        </div>
                                                    </div>
                                                </div> <!-- media body -->
                                            </div> <!-- media-->
                                        </li>
                                    <?php } ?>
                                </ul> <!-- followers list -->
                            </div> <!-- modal body -->
                        </div> <!-- modal content -->
                    </div>
                </div>
                <div class="post_comments_section">
                    <ul class="comments_list un_style wall-comments-area-<?= $post->id ?>" id="wall-comments-area-<?= $post->id ?>">
                        <?php if ($post->comments_count > 5) { ?>
                            <p class="hide_all_comments<?= $post->id ?>" onclick="showall_comments('<?= $post->id ?>')"> <span class="text_darkblue view_all_comments">View all comments</span></p>
                        <?php } ?>
                        <?php include 'comments.php'; ?>

                    </ul>
                    <?php if (Auth::user()) { ?>
                        <div class="post_comments_box d-flex">
                            <figure class="figure mr-3 sx-mr-2 mb-0">
                                <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= $current_photo ? $current_photo : asset('public/images/profile_pics/demo.png') ?>)"></span>
                            </figure>
                            <form class="t_post_comment_form flex-grow-1" >

                                <textarea onkeyup="postComment(event, this, <?= $post->id; ?>, '0')" id="comment_area_<?= $post->id ?>" placeholder="Write comment.." class="form-control mention_<?= $post->id ?>"></textarea>
                                <div id="form_area_<?= $post->id?>">
                                </div>
                                <input type="button" onclick="postComment(event, this, '<?= $post->id ?>', '1')" value="Send"/>
                            </form>
                        </div>
                    <?php } ?>
                </div> <!-- post commend section -->
            </div> <!-- post -->
            <!--Modals-->

            <!-- Reporting modal Start -->
            <div class="modal fade" id="modal_reporting_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason for Reporting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input checked="" type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_offensive<?= $post->id ?>" value="offensive">
                                        <label class="custom-control-label font-weight-bold" for="report_offensive<?= $post->id ?>" > Post is offensive </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_spam<?= $post->id ?>" value="Spam">
                                        <label class="custom-control-label font-weight-bold" for="report_spam<?= $post->id ?>"> Spam </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_unrelated<?= $post->id ?>" value="Unrelated">
                                        <label class="custom-control-label font-weight-bold" for="report_unrelated<?= $post->id ?>"> Unrelated </label>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <input type="button" onclick="report_post('<?= $post->id ?>')" class="btn btn-round btn-gradient btn-xl text-semibold" value="Report Post">
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Reporting modal -->

            <!-- Delete Model-->
            <div class="modal fade" id="modal_delete_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deletePost(<?= $post->id; ?>)">Yes</button>
                                    <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                </div>
                            </form>
                        </div> <!-- modal body -->
                    </div>
                </div>
            </div> <!-- Delete modal -->
            <!-- Social Share modal Start -->
            <div class="modal fade modal_share" id="modal_social_share_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Make a Social Share</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="clearfix">
                                    <?php
                                    echo Share::page(asset('get_post/' . $post->id), $post->text, ['class' => 'posts_class', 'id' => $post->id])
                                        ->facebook($post->text)
                                        ->twitter($post->text)
                                        ->whatsapp($post->text);
                                    ?>
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Social Share modal -->
            <!-- Social Share modal END -->
            <!-- Delete modal END -->
            <script>
                function showall_comments(post_id) {
                    $('.hide_all_comments' + post_id).hide();
                    $('.comments_hidden' + post_id).show();
                }
                $(".posts_class").unbind().click(function () {
                    id = this.id;
                    $('.modal_share').modal('hide');
                    $.ajax({
                        url: "<?= asset('send_mail_on_share') ?>",
                        type: "GET",
                        data: {
                            "id": id, "type": "Question"
                        },
                        success: function (data) {
                        }
                    });
                })
                function playVideo(post_id) {
                    var video = $('#video_popup_' + post_id);
                    video.get(0).play();
                }
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $('video').trigger('pause');
                });


                $('textarea.mention_<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
                $('textarea.mention_pop_up<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
            </script>
        <?php }
        else if($post->user_id == $current_id) { ?>

            <input style="display: none" type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get_post/' . $post->id) ?>" >
            <div class="timeline-post clearfix" id="single-post-<?= $post->id ?>">
                <div class="t_post_heads d-flex clearfix">
                    <div class="media align-items-sm-start align-items-md-center">
                        <span class="bg_image_round" style="background-image: url(<?= getUserImage($post->user->photo, $post->user->social_photo, $post->user->gender) ?>)"></span>
                        <div class="media-body line-height-13">
                            <a href="<?= asset('profile_timeline/' . $post->user->id) ?>" class="u_name"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                            <?php if($post->post_type != 'u'){
                                echo 'Posted As ';
                                if($post->post_type == 'g'){ ?>
                                    <img style="height: 20px;width: 20px" src="<?= asset('userassets/images/icon-event.png')?>">
                                    <a href="<?= asset('gig_detail/' . $post->gig->id) ?>" class="u_name"><?= $post->gig->title ?></a>
                                <?php } if($post->post_type == 'e'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/group.png')?>">
                                    <a href="<?= asset('group_time_line/' . $post->events->id) ?>" class="u_name"><?= $post->events->name ?></a>
                                <?php } if($post->post_type == 's'){ ?>
                                    <img  style="height: 20px;width: 20px" src="<?= asset('userassets/images/studio.png')?>">
                                    <a href="<?= asset('teaching_studio_time_line/' . $post->studio->id) ?>" class="u_name"><?= $post->studio->name ?></a>
                                <?php } if($post->post_type == 'a'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/pianist.png')?>">
                                    <a href="<?= asset('accompanist_time_line/' . $post->accompanist->id) ?>" class="u_name"><?= $post->accompanist->name ?></a>
                                <?php }}?>
                            <div class="text_red_dark">
                                <?php
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
                                ?>
                            </div>
                            <span class="time_mobile"> <?php echo timeago($post->created_at); ?> </span>
                        </div>
                    </div> <!-- media -->
                    <div class="ml-auto align-self-center">
                        <ul class="un_style no_icon action_dropdown float-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true"
                                   class="dropdown-toggle">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                    <?php if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="<?= asset('edit_post/' . $post->id) ?>"><i class="fas fa-copy"></i> Edit</a>
                                    <?php } ?>
                                    <a onclick="copyPostLink(<?= $post->id; ?>)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $post->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                                    <?php if ($post->user_id != $current_id) { ?>
                                        <a <?php if ($post->reported) { ?> style="display: none" <?php } ?> id="report_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_reporting_<?= $post->id ?>"><i class="fas fa-flag"></i> Report</a>

                                        <a <?php if (!$post->reported) { ?> style="display: none" <?php } ?> id="reported_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" ><i class="fas fa-flag"></i> Reported</a>
                                    <?php } if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete_<?= $post->id ?>"><i class="fas fa-copy"></i> Delete</a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <span class="time_desktop"> <?php echo timeago($post->created_at); ?> </span>
                    </div> <!-- ml-auto -->
                </div> <!-- timeline header -->
                <?php if ($post->text) { ?>
                    <div class="t_post_content">
                        <p>
                            <?php
                            $post_text = $post->text;
                            if (strpos($post_text, 'youtube.com/') !== false && strpos($post_text, 'iframe') === false) {
                                ?>
                                <?php
                                $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $post_text);
                                echo $iframe;
                                ?>
                                <?php
                            } else {
                                if (strlen($post_text) > 420) {
                                    $post_text = substr($post_text, 0, 420);
                                    ?>
                                    <?= $post_text ?>
                                    <span class="elipsis">...</span>
                                    <a href="javascript:void(0)" onclick="seeAllPostData(this)" class="see_all_post"> see more</a>
                                    <span class="see_all_post_data"><?= substr($post->text, 420) ?></span>
                                <?php } else { ?>
                                    <?= getMentions($post_text) ?>
                                    <?php
                                }
                            }
                            ?>
                        </p>
                    </div>
                <?php } ?>
                <?php if ($post->type == 'video') { ?>
                    <div class="post-media video">
                        <?php if ($agent->isDesktop()) { ?>
                            <video poster="<?= asset('public/images/posts/posters/'.$post->getFile->poster)?>" style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  controls onclick="this.play();playVideo('<?= $post->id ?>')">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } else { ?>
                            <video  controls onclick="this.play()">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                    </div>
                    <?php include 'image_popup.php'; ?>
                <?php } if ($post->type == 'audio') { ?>
                    <div class="post-media audio">
                        <audio controls>
                            <source src="<?php echo asset($post->getFile->file) ?>" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio></div>
                <?php } if ($post->type == 'image') { ?>
                    <div class="post-media image">
                        <?php if ($agent->isDesktop()) { ?>
                            <img style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                        <?php } else {
                            if (!isset($is_shown)) { ?>
                                <a href="<?= asset('get_post/' . $post->id) ?>">
                            <?php } ?>
                            <img style="cursor: pointer"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                            <?php if (!isset($is_shown)) { ?> </a>

                            <?php }
                        } ?>
                    </div>

                    <?php
                    include 'image_popup.php';
                }
                ?>
                <nav class="nav t_post_action_btns">
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-dislike-<?= $post->id; ?>" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a onclick="dislike_post('<?= $post->id; ?>')"  class="nav-link share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Liked </a>
                        </div>
                        <div class="wall-post-single-like-<?= $post->id; ?>" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a id="" onclick="like_post('<?= $post->id; ?>')"  class="nav-link share_post " href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Like </a>
                        </div>
                    <?php } else { ?>
                        <!--<a href="<?= asset('/') ?>"> <i class="fas fa-thumbs-up" style="font-size: 17px;"></i> Like </a>-->
                    <?php } if (Auth::user()) { ?>
                        <a onclick="focustextarea('<?= $post->id ?>')" class="nav-link" href="javascript:void(0)"><i class="fas fa-comment-alt"></i> Comment</a>
                    <?php } ?>
                    <!--<a class="nav-link" href="#"><i class="fas fa-share"></i> Share</a>-->
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-bookmarkremove-<?= $post->id; ?>" <?php if (!$post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark done" onclick="remove_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" href="javascript:void(0)" ><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                        <div class="wall-post-single-bookmarkadd-<?= $post->id; ?>" <?php if ($post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark" onclick="add_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')"  href="javascript:void(0)"><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                    <?php } else { ?>
                        <!--<a class="nav-link bookmark" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i> Favorite</a>-->
                    <?php } ?>
                </nav> <!-- nav -->
                <nav class="nav post_counter">
                    <span class="open_likes_modal" data-post-id="<?= $post->id ?>"><span class="likes_counter<?= $post->id ?>"><?=$post->likes->count()?></span> Likes</span>
                    <span class="ml-auto"><span class="comments_counter<?= $post->id ?>"><?= $post->comments->count() ?></span> Comments</span>
                </nav> <!-- nav -->
                <div class="modal fade" id="likes_modal<?= $post->id ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content edit-event-popup">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create_gig_modal">Likes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div> <!-- modal header -->
                            <div class="modal-body">
                                <ul class="followers_list un_style" id="likes_modal_ul<?= $post->id ?>">
                                    <?php foreach ($post->likes as $like) { ?>
                                        <?php
                                        $member = $like->user;
                                        $memberImage = getUserImage($member->photo, $member->social_photo, $member->gender);
                                        ?>
                                        <li data-is-my-like="<?= ($member->id == $current_id) ? '1' : '' ?>" data-post-id="<?=$post->id?>">
                                            <div class="media align-items-center">
                                                <figure class="figure mr-3 sx-mr-2">
                                            <span class="bg_image_round w-40" onclick="window.location.href='<?= asset('profile_timeline/' . $member->id) ?>';" style="cursor: pointer; background-image: url(<?php echo $memberImage ?>)">
                                                <?php if ($member->is_online && $member->id != $current_id) { ?>
                                                    <span class="active_status absolute"></span>
                                                <?php } ?>
                                            </span>
                                                </figure>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column flex-sm-row">
                                                        <div class="mb-2">
                                                            <a href="<?= asset('profile_timeline/' . $member->id) ?>" class="u_name"><?= $member->first_name . ' ' . $member->last_name ?></a>
                                                        </div>
                                                    </div>
                                                </div> <!-- media body -->
                                            </div> <!-- media-->
                                        </li>
                                    <?php } ?>
                                </ul> <!-- followers list -->
                            </div> <!-- modal body -->
                        </div> <!-- modal content -->
                    </div>
                </div>
                <div class="post_comments_section">
                    <ul class="comments_list un_style wall-comments-area-<?= $post->id ?>" id="wall-comments-area-<?= $post->id ?>">
                        <?php if ($post->comments_count > 5) { ?>
                            <p class="hide_all_comments<?= $post->id ?>" onclick="showall_comments('<?= $post->id ?>')"> <span class="text_darkblue view_all_comments">View all comments</span></p>
                        <?php } ?>
                        <?php include 'comments.php'; ?>

                    </ul>
                    <?php if (Auth::user()) { ?>
                        <div class="post_comments_box d-flex">
                            <figure class="figure mr-3 sx-mr-2 mb-0">
                                <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= $current_photo ? $current_photo : asset('public/images/profile_pics/demo.png') ?>)"></span>
                            </figure>
                            <form class="t_post_comment_form flex-grow-1" >

                                <textarea onkeyup="postComment(event, this, <?= $post->id; ?>, '0')" id="comment_area_<?= $post->id ?>" placeholder="Write comment.." class="form-control mention_<?= $post->id ?>"></textarea>
                                <div id="form_area_<?= $post->id?>">
                                </div>
                                <input type="button" onclick="postComment(event, this, '<?= $post->id ?>', '1')" value="Send"/>
                            </form>
                        </div>
                    <?php } ?>
                </div> <!-- post commend section -->
            </div> <!-- post -->
            <!--Modals-->

            <!-- Reporting modal Start -->
            <div class="modal fade" id="modal_reporting_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason for Reporting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input checked="" type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_offensive<?= $post->id ?>" value="offensive">
                                        <label class="custom-control-label font-weight-bold" for="report_offensive<?= $post->id ?>" > Post is offensive </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_spam<?= $post->id ?>" value="Spam">
                                        <label class="custom-control-label font-weight-bold" for="report_spam<?= $post->id ?>"> Spam </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_unrelated<?= $post->id ?>" value="Unrelated">
                                        <label class="custom-control-label font-weight-bold" for="report_unrelated<?= $post->id ?>"> Unrelated </label>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <input type="button" onclick="report_post('<?= $post->id ?>')" class="btn btn-round btn-gradient btn-xl text-semibold" value="Report Post">
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Reporting modal -->

            <!-- Delete Model-->
            <div class="modal fade" id="modal_delete_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deletePost(<?= $post->id; ?>)">Yes</button>
                                    <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                </div>
                            </form>
                        </div> <!-- modal body -->
                    </div>
                </div>
            </div> <!-- Delete modal -->
            <!-- Social Share modal Start -->
            <div class="modal fade modal_share" id="modal_social_share_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Make a Social Share</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="clearfix">
                                    <?php
                                    echo Share::page(asset('get_post/' . $post->id), $post->text, ['class' => 'posts_class', 'id' => $post->id])
                                        ->facebook($post->text)
                                        ->twitter($post->text)
                                        ->whatsapp($post->text);
                                    ?>
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Social Share modal -->
            <!-- Social Share modal END -->
            <!-- Delete modal END -->
            <script>
                function showall_comments(post_id) {
                    $('.hide_all_comments' + post_id).hide();
                    $('.comments_hidden' + post_id).show();
                }
                $(".posts_class").unbind().click(function () {
                    id = this.id;
                    $('.modal_share').modal('hide');
                    $.ajax({
                        url: "<?= asset('send_mail_on_share') ?>",
                        type: "GET",
                        data: {
                            "id": id, "type": "Question"
                        },
                        success: function (data) {
                        }
                    });
                })
                function playVideo(post_id) {
                    var video = $('#video_popup_' + post_id);
                    video.get(0).play();
                }
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $('video').trigger('pause');
                });


                $('textarea.mention_<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
                $('textarea.mention_pop_up<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
            </script>


        <?php }

        else if(($post->privacy == 'friend') && (!empty($post->isMusicianFriend) )) { ?>

            <input style="display: none" type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get_post/' . $post->id) ?>" >
            <div class="timeline-post clearfix" id="single-post-<?= $post->id ?>">
                <div class="t_post_heads d-flex clearfix">
                    <div class="media align-items-sm-start align-items-md-center">
                        <span class="bg_image_round" style="background-image: url(<?= getUserImage($post->user->photo, $post->user->social_photo, $post->user->gender) ?>)"></span>
                        <div class="media-body line-height-13">
                            <a href="<?= asset('profile_timeline/' . $post->user->id) ?>" class="u_name"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                            <?php if($post->post_type != 'u'){
                                echo 'Posted As ';
                                if($post->post_type == 'g'){ ?>
                                    <img style="height: 20px;width: 20px" src="<?= asset('userassets/images/icon-event.png')?>">
                                    <a href="<?= asset('gig_detail/' . $post->gig->id) ?>" class="u_name"><?= $post->gig->title ?></a>
                                <?php } if($post->post_type == 'e'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/group.png')?>">
                                    <a href="<?= asset('group_time_line/' . $post->events->id) ?>" class="u_name"><?= $post->events->name ?></a>
                                <?php } if($post->post_type == 's'){ ?>
                                    <img  style="height: 20px;width: 20px" src="<?= asset('userassets/images/studio.png')?>">
                                    <a href="<?= asset('teaching_studio_time_line/' . $post->studio->id) ?>" class="u_name"><?= $post->studio->name ?></a>
                                <?php } if($post->post_type == 'a'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/pianist.png')?>">
                                    <a href="<?= asset('accompanist_time_line/' . $post->accompanist->id) ?>" class="u_name"><?= $post->accompanist->name ?></a>
                                <?php }}?>
                            <div class="text_red_dark">
                                <?php
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
                                ?>
                            </div>
                            <span class="time_mobile"> <?php echo timeago($post->created_at); ?> </span>
                        </div>
                    </div> <!-- media -->
                    <div class="ml-auto align-self-center">
                        <ul class="un_style no_icon action_dropdown float-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true"
                                   class="dropdown-toggle">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                    <?php if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="<?= asset('edit_post/' . $post->id) ?>"><i class="fas fa-copy"></i> Edit</a>
                                    <?php } ?>
                                    <a onclick="copyPostLink(<?= $post->id; ?>)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $post->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                                    <?php if ($post->user_id != $current_id) { ?>
                                        <a <?php if ($post->reported) { ?> style="display: none" <?php } ?> id="report_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_reporting_<?= $post->id ?>"><i class="fas fa-flag"></i> Report</a>

                                        <a <?php if (!$post->reported) { ?> style="display: none" <?php } ?> id="reported_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" ><i class="fas fa-flag"></i> Reported</a>
                                    <?php } if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete_<?= $post->id ?>"><i class="fas fa-copy"></i> Delete</a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <span class="time_desktop"> <?php echo timeago($post->created_at); ?> </span>
                    </div> <!-- ml-auto -->
                </div> <!-- timeline header -->
                <?php if ($post->text) { ?>
                    <div class="t_post_content">
                        <p>
                            <?php
                            $post_text = $post->text;
                            if (strpos($post_text, 'youtube.com/') !== false && strpos($post_text, 'iframe') === false) {
                                ?>
                                <?php
                                $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $post_text);
                                echo $iframe;
                                ?>
                                <?php
                            } else {
                                if (strlen($post_text) > 420) {
                                    $post_text = substr($post_text, 0, 420);
                                    ?>
                                    <?= $post_text ?>
                                    <span class="elipsis">...</span>
                                    <a href="javascript:void(0)" onclick="seeAllPostData(this)" class="see_all_post"> see more</a>
                                    <span class="see_all_post_data"><?= substr($post->text, 420) ?></span>
                                <?php } else { ?>
                                    <?= getMentions($post_text) ?>
                                    <?php
                                }
                            }
                            ?>
                        </p>
                    </div>
                <?php } ?>
                <?php if ($post->type == 'video') { ?>
                    <div class="post-media video">
                        <?php if ($agent->isDesktop()) { ?>
                            <video poster="<?= asset('public/images/posts/posters/'.$post->getFile->poster)?>" style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  controls onclick="this.play();playVideo('<?= $post->id ?>')">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } else { ?>
                            <video  controls onclick="this.play()">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                    </div>
                    <?php include 'image_popup.php'; ?>
                <?php } if ($post->type == 'audio') { ?>
                    <div class="post-media audio">
                        <audio controls>
                            <source src="<?php echo asset($post->getFile->file) ?>" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio></div>
                <?php } if ($post->type == 'image') { ?>
                    <div class="post-media image">
                        <?php if ($agent->isDesktop()) { ?>
                            <img style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                        <?php } else {
                            if (!isset($is_shown)) { ?>
                                <a href="<?= asset('get_post/' . $post->id) ?>">
                            <?php } ?>
                            <img style="cursor: pointer"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                            <?php if (!isset($is_shown)) { ?> </a>

                            <?php }
                        } ?>
                    </div>

                    <?php
                    include 'image_popup.php';
                }
                ?>
                <nav class="nav t_post_action_btns">
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-dislike-<?= $post->id; ?>" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a onclick="dislike_post('<?= $post->id; ?>')"  class="nav-link share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Liked </a>
                        </div>
                        <div class="wall-post-single-like-<?= $post->id; ?>" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a id="" onclick="like_post('<?= $post->id; ?>')"  class="nav-link share_post " href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Like </a>
                        </div>
                    <?php } else { ?>
                        <!--<a href="<?= asset('/') ?>"> <i class="fas fa-thumbs-up" style="font-size: 17px;"></i> Like </a>-->
                    <?php } if (Auth::user()) { ?>
                        <a onclick="focustextarea('<?= $post->id ?>')" class="nav-link" href="javascript:void(0)"><i class="fas fa-comment-alt"></i> Comment</a>
                    <?php } ?>
                    <!--<a class="nav-link" href="#"><i class="fas fa-share"></i> Share</a>-->
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-bookmarkremove-<?= $post->id; ?>" <?php if (!$post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark done" onclick="remove_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" href="javascript:void(0)" ><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                        <div class="wall-post-single-bookmarkadd-<?= $post->id; ?>" <?php if ($post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark" onclick="add_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')"  href="javascript:void(0)"><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                    <?php } else { ?>
                        <!--<a class="nav-link bookmark" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i> Favorite</a>-->
                    <?php } ?>
                </nav> <!-- nav -->
                <nav class="nav post_counter">
                    <span class="open_likes_modal" data-post-id="<?= $post->id ?>"><span class="likes_counter<?= $post->id ?>"><?=$post->likes->count()?></span> Likes</span>
                    <span class="ml-auto"><span class="comments_counter<?= $post->id ?>"><?= $post->comments->count() ?></span> Comments</span>
                </nav> <!-- nav -->
                <div class="modal fade" id="likes_modal<?= $post->id ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content edit-event-popup">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create_gig_modal">Likes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div> <!-- modal header -->
                            <div class="modal-body">
                                <ul class="followers_list un_style" id="likes_modal_ul<?= $post->id ?>">
                                    <?php foreach ($post->likes as $like) { ?>
                                        <?php
                                        $member = $like->user;
                                        $memberImage = getUserImage($member->photo, $member->social_photo, $member->gender);
                                        ?>
                                        <li data-is-my-like="<?= ($member->id == $current_id) ? '1' : '' ?>" data-post-id="<?=$post->id?>">
                                            <div class="media align-items-center">
                                                <figure class="figure mr-3 sx-mr-2">
                                            <span class="bg_image_round w-40" onclick="window.location.href='<?= asset('profile_timeline/' . $member->id) ?>';" style="cursor: pointer; background-image: url(<?php echo $memberImage ?>)">
                                                <?php if ($member->is_online && $member->id != $current_id) { ?>
                                                    <span class="active_status absolute"></span>
                                                <?php } ?>
                                            </span>
                                                </figure>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column flex-sm-row">
                                                        <div class="mb-2">
                                                            <a href="<?= asset('profile_timeline/' . $member->id) ?>" class="u_name"><?= $member->first_name . ' ' . $member->last_name ?></a>
                                                        </div>
                                                    </div>
                                                </div> <!-- media body -->
                                            </div> <!-- media-->
                                        </li>
                                    <?php } ?>
                                </ul> <!-- followers list -->
                            </div> <!-- modal body -->
                        </div> <!-- modal content -->
                    </div>
                </div>
                <div class="post_comments_section">
                    <ul class="comments_list un_style wall-comments-area-<?= $post->id ?>" id="wall-comments-area-<?= $post->id ?>">
                        <?php if ($post->comments_count > 5) { ?>
                            <p class="hide_all_comments<?= $post->id ?>" onclick="showall_comments('<?= $post->id ?>')"> <span class="text_darkblue view_all_comments">View all comments</span></p>
                        <?php } ?>
                        <?php include 'comments.php'; ?>

                    </ul>
                    <?php if (Auth::user()) { ?>
                        <div class="post_comments_box d-flex">
                            <figure class="figure mr-3 sx-mr-2 mb-0">
                                <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= $current_photo ? $current_photo : asset('public/images/profile_pics/demo.png') ?>)"></span>
                            </figure>
                            <form class="t_post_comment_form flex-grow-1" >

                                <textarea onkeyup="postComment(event, this, <?= $post->id; ?>, '0')" id="comment_area_<?= $post->id ?>" placeholder="Write comment.." class="form-control mention_<?= $post->id ?>"></textarea>
                                <div id="form_area_<?= $post->id?>">
                                </div>
                                <input type="button" onclick="postComment(event, this, '<?= $post->id ?>', '1')" value="Send"/>
                            </form>
                        </div>
                    <?php } ?>
                </div> <!-- post commend section -->
            </div> <!-- post -->
            <!--Modals-->

            <!-- Reporting modal Start -->
            <div class="modal fade" id="modal_reporting_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason for Reporting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input checked="" type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_offensive<?= $post->id ?>" value="offensive">
                                        <label class="custom-control-label font-weight-bold" for="report_offensive<?= $post->id ?>" > Post is offensive </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_spam<?= $post->id ?>" value="Spam">
                                        <label class="custom-control-label font-weight-bold" for="report_spam<?= $post->id ?>"> Spam </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_unrelated<?= $post->id ?>" value="Unrelated">
                                        <label class="custom-control-label font-weight-bold" for="report_unrelated<?= $post->id ?>"> Unrelated </label>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <input type="button" onclick="report_post('<?= $post->id ?>')" class="btn btn-round btn-gradient btn-xl text-semibold" value="Report Post">
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Reporting modal -->

            <!-- Delete Model-->
            <div class="modal fade" id="modal_delete_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deletePost(<?= $post->id; ?>)">Yes</button>
                                    <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                </div>
                            </form>
                        </div> <!-- modal body -->
                    </div>
                </div>
            </div> <!-- Delete modal -->
            <!-- Social Share modal Start -->
            <div class="modal fade modal_share" id="modal_social_share_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Make a Social Share</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="clearfix">
                                    <?php
                                    echo Share::page(asset('get_post/' . $post->id), $post->text, ['class' => 'posts_class', 'id' => $post->id])
                                        ->facebook($post->text)
                                        ->twitter($post->text)
                                        ->whatsapp($post->text);
                                    ?>
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Social Share modal -->
            <!-- Social Share modal END -->
            <!-- Delete modal END -->
            <script>
                function showall_comments(post_id) {
                    $('.hide_all_comments' + post_id).hide();
                    $('.comments_hidden' + post_id).show();
                }
                $(".posts_class").unbind().click(function () {
                    id = this.id;
                    $('.modal_share').modal('hide');
                    $.ajax({
                        url: "<?= asset('send_mail_on_share') ?>",
                        type: "GET",
                        data: {
                            "id": id, "type": "Question"
                        },
                        success: function (data) {
                        }
                    });
                })
                function playVideo(post_id) {
                    var video = $('#video_popup_' + post_id);
                    video.get(0).play();
                }
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $('video').trigger('pause');
                });


                $('textarea.mention_<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
                $('textarea.mention_pop_up<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
            </script>



        <?php    }
        else if(($post->privacy == 'private') && (!empty($post->isMusicianFollower))) { ?>

            <input style="display: none" type="text" id="post-url-<?= $post->id; ?>" value="<?php echo asset('/get_post/' . $post->id) ?>" >
            <div class="timeline-post clearfix" id="single-post-<?= $post->id ?>">
                <div class="t_post_heads d-flex clearfix">
                    <div class="media align-items-sm-start align-items-md-center">
                        <span class="bg_image_round" style="background-image: url(<?= getUserImage($post->user->photo, $post->user->social_photo, $post->user->gender) ?>)"></span>
                        <div class="media-body line-height-13">
                            <a href="<?= asset('profile_timeline/' . $post->user->id) ?>" class="u_name"><?= $post->user->first_name . ' ' . $post->user->last_name ?></a>
                            <?php if($post->post_type != 'u'){
                                echo 'Posted As ';
                                if($post->post_type == 'g'){ ?>
                                    <img style="height: 20px;width: 20px" src="<?= asset('userassets/images/icon-event.png')?>">
                                    <a href="<?= asset('gig_detail/' . $post->gig->id) ?>" class="u_name"><?= $post->gig->title ?></a>
                                <?php } if($post->post_type == 'e'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/group.png')?>">
                                    <a href="<?= asset('group_time_line/' . $post->events->id) ?>" class="u_name"><?= $post->events->name ?></a>
                                <?php } if($post->post_type == 's'){ ?>
                                    <img  style="height: 20px;width: 20px" src="<?= asset('userassets/images/studio.png')?>">
                                    <a href="<?= asset('teaching_studio_time_line/' . $post->studio->id) ?>" class="u_name"><?= $post->studio->name ?></a>
                                <?php } if($post->post_type == 'a'){ ?>
                                    <img style="height: 20px;width: 20px"  src="<?= asset('userassets/images/pianist.png')?>">
                                    <a href="<?= asset('accompanist_time_line/' . $post->accompanist->id) ?>" class="u_name"><?= $post->accompanist->name ?></a>
                                <?php }}?>
                            <div class="text_red_dark">
                                <?php
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
                                ?>
                            </div>
                            <span class="time_mobile"> <?php echo timeago($post->created_at); ?> </span>
                        </div>
                    </div> <!-- media -->
                    <div class="ml-auto align-self-center">
                        <ul class="un_style no_icon action_dropdown float-right">
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true"
                                   class="dropdown-toggle">
                                    <i class="fas fa-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                    <?php if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="<?= asset('edit_post/' . $post->id) ?>"><i class="fas fa-copy"></i> Edit</a>
                                    <?php } ?>
                                    <a onclick="copyPostLink(<?= $post->id; ?>)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $post->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                                    <?php if ($post->user_id != $current_id) { ?>
                                        <a <?php if ($post->reported) { ?> style="display: none" <?php } ?> id="report_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_reporting_<?= $post->id ?>"><i class="fas fa-flag"></i> Report</a>

                                        <a <?php if (!$post->reported) { ?> style="display: none" <?php } ?> id="reported_post_<?= $post->id ?>" class="dropdown-item" href="javascript:void(0)" ><i class="fas fa-flag"></i> Reported</a>
                                    <?php } if ($post->user_id == $current_id) { ?>
                                        <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete_<?= $post->id ?>"><i class="fas fa-copy"></i> Delete</a>
                                    <?php } ?>
                                </div>
                            </li>
                        </ul>
                        <span class="time_desktop"> <?php echo timeago($post->created_at); ?> </span>
                    </div> <!-- ml-auto -->
                </div> <!-- timeline header -->
                <?php if ($post->text) { ?>
                    <div class="t_post_content">
                        <p>
                            <?php
                            $post_text = $post->text;
                            if (strpos($post_text, 'youtube.com/') !== false && strpos($post_text, 'iframe') === false) {
                                ?>
                                <?php
                                $iframe = preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/$1\" frameborder=\"0\" allow=\"accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>", $post_text);
                                echo $iframe;
                                ?>
                                <?php
                            } else {
                                if (strlen($post_text) > 420) {
                                    $post_text = substr($post_text, 0, 420);
                                    ?>
                                    <?= $post_text ?>
                                    <span class="elipsis">...</span>
                                    <a href="javascript:void(0)" onclick="seeAllPostData(this)" class="see_all_post"> see more</a>
                                    <span class="see_all_post_data"><?= substr($post->text, 420) ?></span>
                                <?php } else { ?>
                                    <?= getMentions($post_text) ?>
                                    <?php
                                }
                            }
                            ?>
                        </p>
                    </div>
                <?php } ?>
                <?php if ($post->type == 'video') { ?>
                    <div class="post-media video">
                        <?php if ($agent->isDesktop()) { ?>
                            <video poster="<?= asset('public/images/posts/posters/'.$post->getFile->poster)?>" style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  controls onclick="this.play();playVideo('<?= $post->id ?>')">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } else { ?>
                            <video  controls onclick="this.play()">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/ogg">
                                <source src="<?php echo asset($post->getFile->file) ?>" type="video/mp4">
                            </video>
                        <?php } ?>
                    </div>
                    <?php include 'image_popup.php'; ?>
                <?php } if ($post->type == 'audio') { ?>
                    <div class="post-media audio">
                        <audio controls>
                            <source src="<?php echo asset($post->getFile->file) ?>" type="audio/mpeg">
                            Your browser does not support the audio tag.
                        </audio></div>
                <?php } if ($post->type == 'image') { ?>
                    <div class="post-media image">
                        <?php if ($agent->isDesktop()) { ?>
                            <img style="cursor: pointer" data-toggle="modal" data-target="#modal_post_image<?= $post->id ?>"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                        <?php } else {
                            if (!isset($is_shown)) { ?>
                                <a href="<?= asset('get_post/' . $post->id) ?>">
                            <?php } ?>
                            <img style="cursor: pointer"  src="<?php echo asset($post->getFile->file) ?>" alt="image"/>
                            <?php if (!isset($is_shown)) { ?> </a>

                            <?php }
                        } ?>
                    </div>

                    <?php
                    include 'image_popup.php';
                }
                ?>
                <nav class="nav t_post_action_btns">
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-dislike-<?= $post->id; ?>" <?php if (!$post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a onclick="dislike_post('<?= $post->id; ?>')"  class="nav-link share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Liked </a>
                        </div>
                        <div class="wall-post-single-like-<?= $post->id; ?>" <?php if ($post->liked_count) { ?> style="display: none" <?php } ?>>
                            <a id="" onclick="like_post('<?= $post->id; ?>')"  class="nav-link share_post " href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i> Like </a>
                        </div>
                    <?php } else { ?>
                        <!--<a href="<?= asset('/') ?>"> <i class="fas fa-thumbs-up" style="font-size: 17px;"></i> Like </a>-->
                    <?php } if (Auth::user()) { ?>
                        <a onclick="focustextarea('<?= $post->id ?>')" class="nav-link" href="javascript:void(0)"><i class="fas fa-comment-alt"></i> Comment</a>
                    <?php } ?>
                    <!--<a class="nav-link" href="#"><i class="fas fa-share"></i> Share</a>-->
                    <?php if (Auth::user()) { ?>
                        <div class="wall-post-single-bookmarkremove-<?= $post->id; ?>" <?php if (!$post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark done" onclick="remove_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')" href="javascript:void(0)" ><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                        <div class="wall-post-single-bookmarkadd-<?= $post->id; ?>" <?php if ($post->bookmarked_count) { ?> style="display: none" <?php } ?>>
                            <a  class="nav-link bookmark" onclick="add_bookmard('<?= $post->id; ?>', '<?= $post->type ?>')"  href="javascript:void(0)"><i class="fas fa-heart"></i> Favorite</a>
                        </div>
                    <?php } else { ?>
                        <!--<a class="nav-link bookmark" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i> Favorite</a>-->
                    <?php } ?>
                </nav> <!-- nav -->
                <nav class="nav post_counter">
                    <span class="open_likes_modal" data-post-id="<?= $post->id ?>"><span class="likes_counter<?= $post->id ?>"><?=$post->likes->count()?></span> Likes</span>
                    <span class="ml-auto"><span class="comments_counter<?= $post->id ?>"><?= $post->comments->count() ?></span> Comments</span>
                </nav> <!-- nav -->
                <div class="modal fade" id="likes_modal<?= $post->id ?>" tabindex="-1" role="dialog"  aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content edit-event-popup">
                            <div class="modal-header">
                                <h5 class="modal-title" id="create_gig_modal">Likes</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <i class="fas fa-times-circle"></i>
                                </button>
                            </div> <!-- modal header -->
                            <div class="modal-body">
                                <ul class="followers_list un_style" id="likes_modal_ul<?= $post->id ?>">
                                    <?php foreach ($post->likes as $like) { ?>
                                        <?php
                                        $member = $like->user;
                                        $memberImage = getUserImage($member->photo, $member->social_photo, $member->gender);
                                        ?>
                                        <li data-is-my-like="<?= ($member->id == $current_id) ? '1' : '' ?>" data-post-id="<?=$post->id?>">
                                            <div class="media align-items-center">
                                                <figure class="figure mr-3 sx-mr-2">
                                            <span class="bg_image_round w-40" onclick="window.location.href='<?= asset('profile_timeline/' . $member->id) ?>';" style="cursor: pointer; background-image: url(<?php echo $memberImage ?>)">
                                                <?php if ($member->is_online && $member->id != $current_id) { ?>
                                                    <span class="active_status absolute"></span>
                                                <?php } ?>
                                            </span>
                                                </figure>
                                                <div class="media-body">
                                                    <div class="d-flex flex-column flex-sm-row">
                                                        <div class="mb-2">
                                                            <a href="<?= asset('profile_timeline/' . $member->id) ?>" class="u_name"><?= $member->first_name . ' ' . $member->last_name ?></a>
                                                        </div>
                                                    </div>
                                                </div> <!-- media body -->
                                            </div> <!-- media-->
                                        </li>
                                    <?php } ?>
                                </ul> <!-- followers list -->
                            </div> <!-- modal body -->
                        </div> <!-- modal content -->
                    </div>
                </div>
                <div class="post_comments_section">
                    <ul class="comments_list un_style wall-comments-area-<?= $post->id ?>" id="wall-comments-area-<?= $post->id ?>">
                        <?php if ($post->comments_count > 5) { ?>
                            <p class="hide_all_comments<?= $post->id ?>" onclick="showall_comments('<?= $post->id ?>')"> <span class="text_darkblue view_all_comments">View all comments</span></p>
                        <?php } ?>
                        <?php include 'comments.php'; ?>

                    </ul>
                    <?php if (Auth::user()) { ?>
                        <div class="post_comments_box d-flex">
                            <figure class="figure mr-3 sx-mr-2 mb-0">
                                <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= $current_photo ? $current_photo : asset('public/images/profile_pics/demo.png') ?>)"></span>
                            </figure>
                            <form class="t_post_comment_form flex-grow-1" >

                                <textarea onkeyup="postComment(event, this, <?= $post->id; ?>, '0')" id="comment_area_<?= $post->id ?>" placeholder="Write comment.." class="form-control mention_<?= $post->id ?>"></textarea>
                                <div id="form_area_<?= $post->id?>">
                                </div>
                                <input type="button" onclick="postComment(event, this, '<?= $post->id ?>', '1')" value="Send"/>
                            </form>
                        </div>
                    <?php } ?>
                </div> <!-- post commend section -->
            </div> <!-- post -->
            <!--Modals-->

            <!-- Reporting modal Start -->
            <div class="modal fade" id="modal_reporting_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Reason for Reporting</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input checked="" type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_offensive<?= $post->id ?>" value="offensive">
                                        <label class="custom-control-label font-weight-bold" for="report_offensive<?= $post->id ?>" > Post is offensive </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_spam<?= $post->id ?>" value="Spam">
                                        <label class="custom-control-label font-weight-bold" for="report_spam<?= $post->id ?>"> Spam </label>
                                    </div>
                                </div>
                                <div class="mb-1">
                                    <div class="custom-control custom-checkbox">
                                        <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $post->id ?>" id="report_unrelated<?= $post->id ?>" value="Unrelated">
                                        <label class="custom-control-label font-weight-bold" for="report_unrelated<?= $post->id ?>"> Unrelated </label>
                                    </div>
                                </div>
                                <div class="mt-2 text-center">
                                    <input type="button" onclick="report_post('<?= $post->id ?>')" class="btn btn-round btn-gradient btn-xl text-semibold" value="Report Post">
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Reporting modal -->

            <!-- Delete Model-->
            <div class="modal fade" id="modal_delete_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button"data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deletePost(<?= $post->id; ?>)">Yes</button>
                                    <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                </div>
                            </form>
                        </div> <!-- modal body -->
                    </div>
                </div>
            </div> <!-- Delete modal -->
            <!-- Social Share modal Start -->
            <div class="modal fade modal_share" id="modal_social_share_<?= $post->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Make a Social Share</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="clearfix">
                                    <?php
                                    echo Share::page(asset('get_post/' . $post->id), $post->text, ['class' => 'posts_class', 'id' => $post->id])
                                        ->facebook($post->text)
                                        ->twitter($post->text)
                                        ->whatsapp($post->text);
                                    ?>
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Social Share modal -->
            <!-- Social Share modal END -->
            <!-- Delete modal END -->
            <script>
                function showall_comments(post_id) {
                    $('.hide_all_comments' + post_id).hide();
                    $('.comments_hidden' + post_id).show();
                }
                $(".posts_class").unbind().click(function () {
                    id = this.id;
                    $('.modal_share').modal('hide');
                    $.ajax({
                        url: "<?= asset('send_mail_on_share') ?>",
                        type: "GET",
                        data: {
                            "id": id, "type": "Question"
                        },
                        success: function (data) {
                        }
                    });
                })
                function playVideo(post_id) {
                    var video = $('#video_popup_' + post_id);
                    video.get(0).play();
                }
                $('body').on('hidden.bs.modal', '.modal', function () {
                    $('video').trigger('pause');
                });


                $('textarea.mention_<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
                $('textarea.mention_pop_up<?= $post->id ?>').mentionsInput({

                    onDataRequest: function (mode, query, callback) {
                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                            responseData = _.filter(responseData, function (item) {
                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                            });
                            callback.call(this, responseData);
                        });
                    }
                });
            </script>
        <?php }
    }

?>