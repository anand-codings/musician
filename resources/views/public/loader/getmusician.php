<?php if (isset($data) && count($data) > 0) { ?>
    <div class="container">
        <div class="row">
            
            <?php foreach ($data as $key => $value) { ?>
                <div class="d-flex flex-column  search_result_box">
                    <div>
                        <?php
                        $photo = getUserImage($value['photo'], $value['social_photo'], $value['gender']);
                        ?>
                        <a href="<?= asset('profile_timeline/' . $value['id']) ?>">
                            <div class="thumbnail" style="background-image: url('<?= $photo ?>');width:100%;">
                                <img class="img-fluid" src="<?= asset('userassets/images/place.png') ?>" style="position:relative;z-index:-1;">
                            </div>
                        </a>
                    </div> <!-- image thumbnail -->
                    <div class="w-100">
                        <div class="row align-items-center">
                            <div class="col-md-12">
                                <a href="<?= asset('profile_timeline/' . $value['id']) ?>" class="u_name">
                                    <?= $value['first_name'] . ' ' . $value['last_name']; ?>
                                    <?php if ($value['is_online']) { ?>
                                        <span class="active_status"></span>
                                    <?php } ?>
                                </a>
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
                                    </div> <!-- profession -->
                                <?php } ?>
                                <?php if (count($value->getEducations)) { ?>
                                    <div>
                                        <i class="fas fa-graduation-cap"></i>
                                        <?php
                                        $education = $value->getEducations->first();
                                        echo $education->institute_name;
                                        ?>
                                    </div>
                                <?php } ?>
                                <?php if (count($value->getExperiences)) { ?>
                                    <div>
                                        <i class="fas fa-briefcase"></i>
                                        <?php
                                        $experience = $value->getExperiences->first();
                                        echo $experience->title . ' at ' . $experience->institute_name;
                                        ?>
                                    </div>
                                <?php } ?>
                                <div class="rating_reviews clearfix">
                                    <div class="star-ratings-sprite-gray">
                                        <span style="width: <?= $value['rating_percentage'] ? $value['rating_percentage'] : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                    </div>
                                    <span> - <?= $value['rating'] ? $value['rating'] : '0' ?> Reviews </span>
                                </div>
                            </div> <!-- col -->
                            <div class="col-sm-5 text-right">
                            </div>

                        </div> <!-- row -->
                        <div class="text-content">
                            <?= $value['description'] ? substr($value['description'], 0, 400) . ' ...' : '' ?>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <i class="fa fa-map-marker-alt"></i> <span class="font-weight-bold">Location:</span> <?= $value['address'] ?>
                            </div> <!-- col -->
                            <div class="col-md-6">
                                <i class="fa fa-globe"></i> <span class="font-weight-bold">Languages:</span> <?= $value['language'] ?>
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="w-100 follow_btns">
                            <div class="following_status text-center mt-4">
                                <?php if (Auth::user()) { ?>
                                    <?php if (Auth::user()->id != $value['id']) { ?>
                                        <a onclick="followUser('<?= $value['id'] ?>')" href="javascript:void(0)" <?php if (checkFollowing($value['id'])) { ?> style="display: none" <?php } ?> class="btn btn-round btn-grey-outline btn_follow followuser_<?= $value['id'] ?> pl-2 pr-2 pt-2 pb-2">  Follow</a>
                                        <a onclick="unfollowUser('<?= $value['id'] ?>')" href="javascript:void(0)" <?php if (!checkFollowing($value['id'])) { ?> style="display: none" <?php } ?> class="btn btn-round btn-grey-outline btn_unfollow unfollowuser_<?= $value['id'] ?> pl-2 pr-2 pt-2 pb-2">  Unfollow</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a href="<?= asset('/login') ?>" class="btn_follow btn btn-round btn-grey-outline pl-2 pr-2 pt-2 pb-2">  Follow</a>
                                <?php } ?>
                                <?php if (Auth::user()) { ?>
                                    <?php if (Auth::user()->id != $value['id'] && !$value['is_private']) { ?>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $value['id'] ?>" class="btn_message pl-2 pr-2 pt-2 pb-2">  Message</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a href="<?= asset('login') ?>" class="btn_message pl-2 pr-2 pt-2 pb-2">  Message</a>
                                <?php } ?>
                            </div> <!-- following buts -->
                        </div> <!-- col -->
                    </div> <!-- right side -->
                    <?php if (Auth::user()) { ?>
                        <!-- Message modal Start -->
                        <div class="modal fade" id="modal_search_messages<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <!--<input type="checkbox" class="custom-control-input" name="custom_booking" id="lbl_custom_booking">-->
                                                            <!--<label class="custom-control-label font-weight-normal" for="lbl_custom_booking">Send as Broadcast message</label>-->
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <select type="text" name="interests[]" class="form-control" id="bulk-messages<?= $value['id'] ?>" style="width: 100%" multiple="multiple">
                                                            <option selected="" value="<?= $value['id'] ?>"> <?= $value['first_name'] . ' ' . $value['last_name'] ?> </option>
                                                            <?php
                                                            foreach ($followings as $following) {
                                                                if ($following->id != $value['id']) {
                                                                    ?>
                                                                    <option value="<?= $following->id ?>"> <?= $following->first_name . ' ' . $following->last_name ?> </option>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                        <div class="font-14 text-danger text-right"></div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="font-weight-bold mb-2">Write a Message</label>
                                                        <textarea id="message<?= $value['id'] ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                        <div class="font-14 text-danger text-right"></div>
                                                    </div>
                                                </div>
                                            </div> <!-- row -->
                                            <div class="mt-2 text-center">
                                                <button type="button" onclick="sendMessage('<?= $value['id'] ?>')" class="btn btn-gradient btn-round btn-xl text-semibold">Send</button>
                                            </div>
                                        </form>
                                    </div> <!-- modal-body-->
                                </div> <!-- modal-content-->
                            </div>
                        </div> <!-- Edit Description modal -->
                        <!--  Message modal END -->
                    <?php } ?>
                    <script>
                        $('#bulk-messages<?= $value['id']; ?>').select2({
                            allowClear: true,
                            width: 'resolve',
                            minimumResultsForSearch: Infinity,
                            //                    placeholder: "Select Interests",
                        });

                    </script>
                    <?php if ($current_user) { ?>
                        <script>
                            function sendMessage(otherid) {
                                var message = $('#message' + otherid).val();
                                if (message) {
                                    recivers = $('#bulk-messages' + otherid).val();
                                    counter = 0;
                                    $.each(recivers, function (index, item) {

                                        var data = new FormData();
                                        data.append('message', message);
                                        data.append('receiver_id', item);
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
                                                    counter++;
                                                    if (counter == 1) {
                                                        $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                                                    }
                                                    //                                    $('#attachment_loader').hide();
                                                    //                                    $('.tiny-div, .files_upload_box').hide();
                                                    result = JSON.parse(data);
                                                    //                                    $('.chat_box_wrapper .chat').append(result.append);
                                                    //                                    $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                                    socket.emit('message_get', {
                                                        "user_id": item,
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
                                                        "user_id": item,
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
                                    })
                                }
                            }

                        </script>
                    <?php } ?>
                </div> <!-- search_result_box -->
            <?php } ?>
        </div>
    </div>
<?php } ?>
