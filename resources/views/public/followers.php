<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">

    <div class="container lg-fluid-container pt-5 pb-5">
        <div class="row">
            <div class="col-lg-3 col-md-12">
                <div class="followers_sidebar">
                    <?php
                    $coverPhoto = asset('public/images/profile_pics/cover_photo_demo.jpg');
                    if ($user->cover_photo) {
                        $coverPhoto = asset('public/images/' . $user->cover_photo);
                    }
                    ?>
                    <div class="banner" style="background-image: url(<?=$coverPhoto?>);"></div>
                    <div class="info">
                        <div class="profile_pic">
                            <?php
                            $image = getUserImage($user->photo, $user->social_photo, $user->gender);
                            ?>
                            <span class="bg_image_round" style="background-image: url(<?= $image ?>)"></span>
                        </div>
                        <h5 class="mb-0"><a href="<?=asset('profile_timeline/'.$user->id)?>" class="text_darkblue font-weight-bold"><?= $user->first_name . ' ' . $user->last_name ?></a></h5>
                        <div>
                            <span class="text_red">
                                    
                                <?php if($user->type == "artist"){
                                if (!$user->getSelectedCategories->isEmpty()) {
                                    $getSelectedArtistTypesCount = $user->getSelectedCategories->count();

                                    if($getSelectedArtistTypesCount <= 2){
                                        $i = 1;
                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
                                            echo $selectedArtistType->getCategory->title;
                                            if ($getSelectedArtistTypesCount > $i)
                                                echo ', ';
                                            $i++;
                                        }
                                    } else {
                                        $i = 1;
                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
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
                                <?php } } ?>
                                    
                            </span>
                        </div>
                        <div class="mt-1">
                            <span class="font-weight-bold" style="cursor: pointer;" onclick="window.location.href='<?=asset('get_followers/'.$user->id)?>'"><?= $user->getFollowers->count() ?> Followers</span>
                            <span class="divider">|</span>
                            <span class="font-weight-bold" style="cursor: pointer;" onclick="window.location.href='<?=asset('get_followings/'.$user->id)?>'"><?= $user->getFollowings->count() ?> Following</span>                            
                        </div>
                        <?php if ($user->id != $current_id) { ?>
                            <div class="following_status">
                                <a <?php if(checkFollowing($user->id)){ ?> style="display: none" <?php } ?> onclick="followUser('<?= $user->id ?>')" href="javascript:void(0)" class="btn_follow followuser_<?= $user->id?>"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                <a <?php if(!checkFollowing($user->id)){ ?> style="display: none" <?php } ?> onclick="unfollowUser('<?= $user->id ?>')" href="javascript:void(0)" class="btn_unfollow unfollowuser_<?= $user->id?>"> <i class="s_icon ic_follow grey"></i> Unfollow</a>
                                <a href="<?= asset('get_chat_detail/' . $user->id) ?>" class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
                            </div>
                        <?php } ?>
                        
                    </div>
                </div>
            </div>
            <div class="col-lg-9 col-md-12">
                <div class="row">
                    <div class="col-sm-7">
                        <h5 class="font-weight-bold"><?= $filter == 'followers' ? 'FOLLOWERS' : 'FOLLOWINGS' ?> LIST</h5>
                    </div>
                    <div class="col-sm-5">
                        <div class="d-flex align-items-center filter_form">
                            <div class="label_filter">
                                <span>FILTER BY</span>
                            </div>
                            <select id="filter" class="form-control">
                                <option value="artist">Musicians</option>
                                <option value="user">Users</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="box mt-3" id="followers_list"></div>
                <div id="js-pg-msg"></div>
            </div>
        </div>
    </div>
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>

<script>
        
    var filter = '<?= $filter ?>';
    var user_id = '<?= $user->id ?>';
    var user_type = $('#filter').val();
    
    var ajaxcall = 1;
    var isScroll = 0;
    var win = $(window);
    var count = 0;
    appended_post_count = 0;
    
    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        load_cards(skip, take, isScroll);
    });
    
    win.on('scroll', function () {
        var docheight = parseInt($(document).height());
        var winheight = parseInt(win.height());
        var differnce = (docheight - winheight) - win.scrollTop();
        isScroll = 1;
        if (differnce < 100) {
            if (ajaxcall === 1) {
                ajaxcall = 0;
                var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                load_cards(skip, 12, isScroll);
            }
        }
    });

    function load_cards(skip, take, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#followers_list').append(loader);
        $.ajax({
            type: "POST",
            dataType: "json",
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            url: "<?php echo asset('fetch_followers/'); ?>",
            data: {skip: skip, take: take, filter: filter, user_id: user_id, user_type: user_type},
            success: function (response) {
                $('#loaderposts').remove();
                if (response.html) {
                    $('#followers_list').append(response.html);
                    ajaxcall = 1;
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    return true;
                } else {
                    if ($('#followers_list').is(':empty')){
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    }
                    else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }
    
    $('#filter').change(function(){
        $('#followers_list').html('');
        $('#js-pg-msg').html('');
        skip = 0;
        ajaxcall = 1;
        isScroll = 0;
        win = $(window);
        count = 0;
        appended_post_count = 0;
        user_type = $(this).val();
        load_cards(skip, 12, isScroll);
    });

</script>