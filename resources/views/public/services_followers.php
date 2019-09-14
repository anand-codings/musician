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
                    if ($service->cover_photo) {
                        $coverPhoto = asset('public/images/' . $service->cover_photo);
                    }
                    ?>
                    <div class="banner" style="background-image: url(<?= $coverPhoto ?>);"></div>
                    <div class="info">
                        <div class="profile_pic">
                            <?php
                            $image = getServicsImage($service->pic);
                            ?>
                            <span class="bg_image_round" style="background-image: url(<?= $image ?>)"></span>
                        </div>
                        <h5 class="mb-0"><a href="<?= asset('profile_timeline/' . $service->id) ?>" class="text_darkblue font-weight-bold"><?= $service->name ?></a></h5>
                        <div>
                            <span class="text_red">

                            </span>
                        </div>
                        <div class="mt-1">
                            <span class="font-weight-bold" style="cursor: pointer;"><?= getFollowingCount($type, $type_id, $column) ?> Followers</span>                            
                        </div>
                        <?php if (Auth::user() && $service->admin_id != $current_id) { ?>
                        <div class="following_status">
                            <a <?php if (checkServiceFollowing($type, $service->id, $column)) { ?> style="display: none" <?php } ?> id="follow_<?= $type ?>_<?= $service->id ?>" onclick="followService(<?= $type ?>,<?= $service->id ?>, '<?= $service->admin_id ?>')" href="javascript:void(0)" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                            <a <?php if (!checkServiceFollowing($type, $service->id, $column)) { ?> style="display: none" <?php } ?> id="unfollow_<?= $type ?>_<?= $service->id ?>"   onclick="unfollowService(<?= $type ?>,<?= $service->id ?>, '<?= $service->admin_id ?>')" href="javascript:void(0)" class="btn_unfollow"> <i class="s_icon ic_follow grey"></i> Unfollow</a>
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $service->admin_id; ?>"class="btn btn-gradient"> <i class="s_icon ic_message white"></i> Message</a>
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


    <!-- Message modal Start -->
    <div class="modal fade" id="modal_search_messages<?= $service->admin_id; ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $service->name; ?> </span></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group mb-0">
                                    <textarea id="message<?= $service->admin_id; ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2">
                            <button type="button" onclick="sendMessageFromFollowers('<?= $service->admin_id; ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                        </div>
                    </form>                        
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Description modal -->
    <!--  Message modal END -->
    <?php include resource_path('views/includes/header-timeline.php'); ?>
    <?php include resource_path('views/includes/footer.php'); ?>


</body>
</html>

<script>
    var filter = $('#filter').val();
    var type = '<?= $type ?>';
    var type_id = '<?= $type_id ?>';

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
            url: "<?php echo asset('fetch_service_followers/'); ?>",
            data: {skip: skip, type: type, type_id: type_id, take: take, filter: filter},
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
                    if ($('#followers_list').is(':empty')) {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    } else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }

    $('#filter').change(function () {
        $('#followers_list').html('');
        $('#js-pg-msg').html('');
        skip = 0;
        ajaxcall = 1;
        isScroll = 0;
        win = $(window);
        count = 0;
        appended_post_count = 0;
        filter = $(this).val();
        load_cards(skip, 12, isScroll);
    });

</script>
<?php include resource_path('views/includes/services_functions.php'); ?>
<?php if ($current_user) { ?>

    <script>
        function sendMessageFromFollowers(otherid) {
            var message = $('#message' + otherid).val();
            console.log(message)
            alert('asdsa')
            if (message) {
                var data = new FormData();
                data.append('message', message);
                data.append('receiver_id', otherid);
                data.append('_token', '<?= csrf_token() ?>');
                data.append('message_type', '<?= $type ?>');
                data.append('type_id', '<?= $service->id ?>');
                $('#message' + otherid).val('');
                if (/\S/.test(message)) {
                    $.ajax({
                        type: "POST",
                        url: "<?php echo asset('add_message'); ?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (data) {
                            $('#modal_search_messages' + otherid).modal('hide');
                            $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                            result = JSON.parse(data);
                            $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                            socket.emit('message_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": result.other_message,
                                "chat_id": result.chat_id,
                                "message": message,
                                "chat_type": '<?= $type ?>',
                                "chat_type_id": '<?= $service->id ?>',
                                "to_be_show": '<?= $type ?>'
                            });
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                "url": '<?= asset('messages/') ?>',
                                "chat_id": result.chat_id,
                                "chat_type": '<?= $type ?>',
                                "chat_type_id": '<?= $service->id ?>',
                                "to_be_show": '<?= $type ?>'

                            });
                        }
                    });
                }
            }

        }
    </script>
<?php } ?>