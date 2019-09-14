<?php
if (isset($data) && count($data) > 0) {
    foreach ($data as $key => $value) {
        ?>
        <li class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
            <div class="search_result_box grid_view">
                <div class="s_image">
                    <?php
                    $photo = getUserImage($value['photo'], $value['social_photo'], $value['gender']);
                    ?>
                    <span class="bg_image_round cursor_pointer" style="background-image: url(<?= $photo ?>)" onclick="location.href = '<?= asset('profile_timeline/' . $value['id']) ?>'">
                        <?php if ($value['is_online']) { ?>
                            <span class="active_status absolute"></span>
                        </span>
                    <?php } ?>
                </div>
                <a href="<?= asset('profile_timeline/' . $value['id']) ?>" class="u_name"><?= $value['first_name'] . ' ' . $value['last_name']; ?></a>
                <?php if ($value['type'] == 'artist') { ?>
                    <div class="profession">
                        <?php
                        if (!$value->getSelectedCategories->isEmpty()) {
                            $getSelectedArtistTypesCount = $value->getSelectedCategories->count();

                            if ($getSelectedArtistTypesCount <= 2) {
                                $i = 1;
                                foreach ($value->getSelectedCategories as $selectedArtistType) {
                                    echo $selectedArtistType->getCategory->title;
                                    if ($getSelectedArtistTypesCount > $i)
                                        echo ', ';
                                    $i++;
                                }
                            } else {
                                $i = 1;
                                foreach ($value->getSelectedCategories as $selectedArtistType) {
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
                        <?php } ?>
                    </div>
                    <!--                <div class="rating_reviews clearfix">
                                        <div class="star-ratings-sprite-gray">
                                            <span style="width: <?= $value['rating_percentage'] ? $value['rating_percentage'] : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                        </div>
                                        <span>(<?= $value['rating'] ? $value['rating'] : '0' ?>)</span>
                                    </div>-->
                <?php } ?>
                <div class="s_meta">
                    <div> <i class="fa fa-map-marker-alt"></i> <span class="font-weight-bold">Location:</span> <?= $value['address'] ?></div>
                    <div> <i class="fa fa-globe"></i> <span class="font-weight-bold">Languages:</span> <?= $value['language'] ?></div>
                </div>
                <div class="following_status">
                    <?php if (Auth::user()) { ?>
                        <?php if (Auth::user()->id != $value['id']) { ?>
                            <a onclick="followUser('<?= $value['id'] ?>')" href="javascript:void(0)" <?php if (checkFollowing($value['id'])) { ?> style="display: none" <?php } ?> class="btn_follow followuser_<?= $value['id'] ?>"> <i class="s_icon ic_follow grey"></i> Follow</a>
                            <a onclick="unfollowUser('<?= $value['id'] ?>')" href="javascript:void(0)" <?php if (!checkFollowing($value['id'])) { ?> style="display: none" <?php } ?> class="btn_unfollow unfollowuser_<?= $value['id'] ?>"> <i class="s_icon ic_follow grey"></i> Unfollow</a>
                        <?php } ?>
                    <?php } else { ?>
                        <a  href="<?= asset('/login') ?>" class="btn_follow "> <i class="s_icon ic_follow grey"></i> Follow</a>
                    <?php } ?>
                    <?php if (Auth::user()) { ?>
                        <?php if (Auth::user()->id != $value['id'] && !$value['is_private']) { ?>   
                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $value['id'] ?>" class="btn_message"> <i class="s_icon ic_message white"></i> Message</a>
                        <?php } ?>
                    <?php } else { ?>
                        <a href="<?= asset('login') ?>" class="btn_message"> <i class="s_icon ic_message white"></i> Message</a>
                    <?php } ?>
                </div>

            </div>
        </li>
        <!-- Message modal Start -->
        <div class="modal fade" id="modal_search_messages<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $value['first_name'] . ' ' . $value['last_name']; ?> </span></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <textarea id="message<?= $value['id'] ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2">
                                <button type="button" onclick="sendMessage('<?= $value['id'] ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!--  Message modal END -->
        <?php if ($current_user) { ?>
            <script>
                function sendMessage(otherid) {
                    var message = $('#message' + otherid).val();
                    if (message) {
                        var data = new FormData();
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
                                    $('#modal_search_messages' + otherid).modal('hide');
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
                                        "message": message,
                                        "chat_type": 'u',
                                        "chat_type_id": result.chat_id,
                                        "to_be_show": 'u'
                                    });
                                    socket.emit('notification_get', {
                                        "user_id": otherid,
                                        "other_id": '<?php echo $current_id; ?>',
                                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                        "photo": '<?php echo $current_photo; ?>',
                                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                                        "url": '<?= asset('messages/') ?>',
                                        "chat_id": result.chat_id,
                                        "chat_type": 'u',
                                        "chat_type_id": result.chat_id,
                                        "to_be_show": 'u'

                                    });
                                }
                            });
                        }
                    }

                }
            </script>
        <?php } ?>
        <?php
    }
}
?>