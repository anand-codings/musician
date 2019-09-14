<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">
    <style type="text/css">
        .dropzone.dz-clickable *{
            float:none !important;
        }
        #status-overlay {
            height: 100%;
            width: 100%;
            background: rgba(0, 0, 0, 0.50);
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99999;
            overflow: hidden;
        }
        #highlight-textarea {
            background: #fff;
        }

        .form-control:focus {
            box-shadow: 0 0 0 2px #3399ff;
            outline: 0;
        }
        h2 {
            font-size: 20px;
        }
        #youtube_modal_body {
            max-height: 400px;
            overflow: auto;
        }
        #youtube_modal_body .youtube_search_listing{
            display:-webkit-box;
            display:-ms-flexbox;
            display:flex;
            -webkit-box-align:center;
            -ms-flex-align:center;
            align-items:center;
            -webkit-box-orient:horizontal;
            -webkit-box-direction:reverse;
            -ms-flex-direction:row-reverse;
            flex-direction:row-reverse;
            -webkit-box-pack: end;
            -ms-flex-pack: end;
            justify-content: flex-end;
            cursor: pointer;
            -webkit-transition: all 0.35s ease;
            -o-transition: all 0.35s ease;
            transition: all 0.35s ease;
        }
        #youtube_modal_body .youtube_search_listing:hover {
            background: #f1eeee;
            -webkit-transition: all 0.35s ease;
            -o-transition: all 0.35s ease;
            transition: all 0.35s ease;
        }
    </style>
    <?php include resource_path('views/includes/top.php'); ?>

    <body>
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xl-3 col-lg-3">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-md-12 col-xl-9 col-lg-9">
                        <div class="collaborative_container">
                            <div class="collaborative-row">
                                <div class="collaborative-header">
                                    <div class="colaborative-header-row">
                                        <h5>Collaborative Friends</h5>
                                        <button data-toggle="modal" data-target="#modal_friends_message" class="btn btn_aqua btn-square font-weight-normal"><i class="fas fa-plus"></i> New Message</button>
<!--                                        <button class="btn btn_aqua btn-square font-weight-normal" data-target="#refer_modal" data-toggle="modal"> <i class="fas fa-plus"></i> Refer</button>-->
                                    </div>
                                </div>
                                <?php
                                if (!empty($friends)) {
                                    foreach ($friends as $key => $friend) {
                                        ?>
                                        <div class="collaborative-body-row">
                                            <div class="collaborative-body-column">
                                                <div class="friends-image" style="background-image:url('<?php echo asset('public/images/' . $friend->getFriendDetail->photo); ?>')"></div>
                                                <a href="<?php echo asset('/profile_timeline/' . $friend->getFriendDetail->id); ?>"><p><?php echo $friend->getFriendDetail->first_name . ' ' . $friend->getFriendDetail->last_name; ?></p></a>
                                            </div>
                                            <div class="collaborative-body-column1">
                                                <a href="javascript:void(0)"  class="btn btn-white-outline" data-target="#firends_messages" data-toggle="modal"> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                    <path class="cls-1" d="M4.922,5.983H15.077a0.707,0.707,0,0,0,0-1.415H4.922a0.707,0.707,0,0,0,0,1.415h0Zm0,0,0,3.414H15.077a0.707,0.707,0,0,0,0-1.414H4.922a0.707,0.707,0,0,0,0,1.414h0Zm0,0M0.706,13.966H2.977v2.328a0.708,0.708,0,0,0,.4.637,0.669,0.669,0,0,0,.31.069,0.749,0.749,0,0,0,.43-0.138L7.9,13.982H19.294A0.7,0.7,0,0,0,20,13.276V0.707A0.7,0.7,0,0,0,19.294,0H0.706A0.7,0.7,0,0,0,0,.707V13.259a0.71,0.71,0,0,0,.706.707h0ZM1.411,1.414h17.16V12.551H7.659a0.752,0.752,0,0,0-.43.138L4.388,14.862v-1.6a0.7,0.7,0,0,0-.7-0.707H1.411V1.414Zm0,0"></path>
                                                    </svg> Message</a>
                                            </div>
                                        </div>

                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div> <!-- col -->

            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- page timeline -->

    <?php include resource_path('views/includes/footer.php'); ?>

    <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
    <script src="<?php echo asset('userassets/js/dropzone-config.js'); ?>"></script>
    <script src="https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js"></script>
    <script src="<?php echo asset('userassets/js/lib/jquery.elastic.js'); ?>"></script>
    <script src="<?php echo asset('userassets/js/jquery.mentionsInput.js'); ?>"></script>

    <script>
        $(document).ready(function () {
            $('#bulk-messages<?= $current_id ?>').select2({
                allowClear: true,
                width: 'resolve',
                minimumResultsForSearch: Infinity,
                placeholder: "Select Friends",
            });
        });

    </script>


    <script>
        var query = '<?= (isset($_GET['search']) && $_GET['search']) ? $_GET['search'] : '' ?>';
        var next_page_token = '';

        $(document).ready(function () {
            $('textarea').on('click', function (e) {
                e.stopPropagation();
            });
        });
        $('textarea.mention').mentionsInput({
            onDataRequest: function (mode, query, callback) {
                $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                    responseData = _.filter(responseData, function (item) {
                        return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                    });
                    callback.call(this, responseData);
                });
            }
        });
        function countTitle(val) {
            limit = 150;
            var len = val.value.length;
            if (len >= limit) {
                val.value = val.value.substring(0, limit);
            } else {
                $('.text_length_title').text(limit - len);
            }
        }

        function countDesc(val) {
            limit = 300;
            var len = val.value.length;
            if (len >= limit) {
                val.value = val.value.substring(0, limit);
            } else {
                $('.text_length_desc').text(limit - len);
            }
        }


    </script>
    <?php if ($welcome_message) { ?>
        <script>
            $('#showSuccess').html('<?= $welcome_message ?>').fadeIn().fadeOut(5000);
        </script>
    <?php } ?>


    <!-- Message modal Start -->
    <div class="modal fade" id="firends_messages" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title text-black" id="exampleModalLabel">Write your message</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row freinds_message">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>To:</label>
                                    <select class="form-control" id="bulk-messages-3" >
                                        <option selected="" value="3" > Second Musician </option>
                                        <option value="2" data-select2-id="55"> First User </option>
                                    </select>

                                </div>
                                <div class="form-group ">
                                    <label>Your Message:</label>
                                    <textarea id="message" class="form-control h_140" placeholder="Write a message"></textarea>
                                </div>
                                <div class="form-group ">
                                    <div class="attact-link">
                                        <label for="link-file">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34.147" height="34.147" viewBox="0 0 34.147 34.147"> <defs> <linearGradient id="linear-gradient" x1="0.063" y1="-0.21" x2="0.93" y2="1.221" gradientUnits="objectBoundingBox"> <stop offset="0" stop-color="#5d2488"/> <stop offset="1" stop-color="#b62e65"/> </linearGradient> </defs> <g id="Group_13" data-name="Group 13" transform="translate(-564 -832)"> <circle id="Ellipse_20" data-name="Ellipse 20" cx="17.074" cy="17.074" r="17.074" transform="translate(564 832)" fill="url(#linear-gradient)"/> <path id="attachment12" d="M4.57,13.5A3.387,3.387,0,0,1,2.176,7.726l7-7A2.509,2.509,0,0,1,12.8.828a2.508,2.508,0,0,1,.106,3.622l-6.58,6.58A1.586,1.586,0,1,1,4.086,8.788L8.543,4.33a.385.385,0,0,1,.544.544L4.63,9.332a.816.816,0,0,0,1.154,1.154l6.58-6.58a1.757,1.757,0,0,0-.106-2.533,1.757,1.757,0,0,0-2.533-.106l-7,7a2.617,2.617,0,0,0,3.7,3.7l7-7a.385.385,0,0,1,.544.544l-7,7A3.363,3.363,0,0,1,4.57,13.5Z" transform="translate(573.32 842.507)" fill="#fff"/> </g> </svg>
                                            <span>Attach Files</span>
                                        </label>
                                        <input type="file" style="display:none;" id="link-file"/>
                                    </div>
                                </div>
                                <div class="profile-img">
                                    <ul class="un_style">
                                        <li>
                                            <div style="background-image:url('<?php echo asset('userassets/images/bg-img2.jpg') ?>')"></div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2">
                            <button type="button"  class="btn btn-gradient btn-xl text-semibold">Send</button>
                        </div>
                    </form>                        
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Description modal -->
    <!--  Message modal END -->
    <!-- Message modal Start -->
    <div class="modal fade" id="refer_modal" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="teaher-header">
                        <h6 class="modal-title text-black" id="exampleModalLabel">Refer as teacher</h6>
                        <button type="button"  class="btn btn-round btn_aqua">Select All</button>
                    </div>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="teacher-box">
                                    <div class="techer-header">
                                        <input type="text" class="form-control" placeholder="Search "/>
                                    </div>
                                    <div class="teacher-lists">
                                        <div class="collaborative_container">
                                            <div class="collaborative-body-row">
                                                <div class="collaborative-body-column">
                                                    <div class="friends-image" style="background-image:url('<?php echo asset('userassets/images/bg-img2.jpg'); ?>')"></div>
                                                    <p>Kelly Clark</p>
                                                </div>
                                                <div class="collaborative-body-column1">
                                                    <label class="checkbox-main">
                                                        <input type="checkbox" id="check-list2" name="inputCheckboxesCall">
                                                        <span class="check-icon"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="collaborative-body-row">
                                                <div class="collaborative-body-column">
                                                    <div class="friends-image" style="background-image:url('<?php echo asset('userassets/images/bg-img2.jpg'); ?>')"></div>
                                                    <p>Kelly Clark</p>
                                                </div>
                                                <div class="collaborative-body-column1">
                                                    <label class="checkbox-main">
                                                        <input type="checkbox" id="check-list2" name="inputCheckboxesCall">
                                                        <span class="check-icon"></span>
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2">
                            <button type="button"  class="btn btn-round btn-gradient btn-xl text-semibold">Refer Now</button>
                        </div>
                    </form>                        
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Description modal -->
    <!--  Refer modal END -->
<!-- collaborative group friend message        -->
        <!-- teacher group messages modal -->
        <?php if (Auth::user()) { ?>
            <!-- Message modal Start -->
            <div class="modal fade" id="modal_friends_message" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title text-black" id="exampleModalLabel">New message To Collaborative Friends
                                <span class="text_maroon"> <?= $value['first_name'] . ' ' . $value['last_name']; ?> </span></h6>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row freinds_message">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <!--<input type="checkbox" class="custom-control-input" name="custom_booking" id="lbl_custom_booking">-->
                                                <!--<label class="custom-control-label font-weight-normal" for="lbl_custom_booking">Send as Broadcast message</label>-->
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="title<?= $current_id ?>" style="width: 100%" placeholder="Enter Title Here" class="form-control" name="title">
                                        </div>
                                        <div class="form-group">
                                            <select type="text" name="friends[]" class="form-control" id="bulk-messages<?= $current_id ?>" style="width: 100%" multiple="multiple">
                                                <?php
                                                if (!empty($friends)) {
                                                    foreach ($friends as $key => $friend) {
                                                        ?>
                                                        <option <?= ($key == '0') ? 'selected=""' : '' ?> value="<?= $friend->getFriendDetail->id ?>"> <?= $friend->getFriendDetail->first_name . ' ' . $friend->getFriendDetail->last_name ?> </option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <div class="font-14 text-danger text-right"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="font-weight-bold mb-2">Write a Message</label>
                                            <textarea id="message<?= $current_id ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                            <div class="font-14 text-danger text-right"></div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="attact-link btn-file">
                                                <label for="attachment_student_files">
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="34.147" height="34.147" viewBox="0 0 34.147 34.147"> <defs> <linearGradient id="linear-gradient" x1="0.063" y1="-0.21" x2="0.93" y2="1.221" gradientUnits="objectBoundingBox"> <stop offset="0" stop-color="#5d2488"/> <stop offset="1" stop-color="#b62e65"/> </linearGradient> </defs> <g id="Group_13" data-name="Group 13" transform="translate(-564 -832)"> <circle id="Ellipse_20" data-name="Ellipse 20" cx="17.074" cy="17.074" r="17.074" transform="translate(564 832)" fill="url(#linear-gradient)"/> <path id="attachment" d="M4.57,13.5A3.387,3.387,0,0,1,2.176,7.726l7-7A2.509,2.509,0,0,1,12.8.828a2.508,2.508,0,0,1,.106,3.622l-6.58,6.58A1.586,1.586,0,1,1,4.086,8.788L8.543,4.33a.385.385,0,0,1,.544.544L4.63,9.332a.816.816,0,0,0,1.154,1.154l6.58-6.58a1.757,1.757,0,0,0-.106-2.533,1.757,1.757,0,0,0-2.533-.106l-7,7a2.617,2.617,0,0,0,3.7,3.7l7-7a.385.385,0,0,1,.544.544l-7,7A3.363,3.363,0,0,1,4.57,13.5Z" transform="translate(573.32 842.507)" fill="#fff"/> </g> </svg>
                                                    <span>Attach Files</span>
                                                </label>
                                                <input type="file"  id="attachment_student_files" style="display: none"  />
                                            </div>
                                        </div>

                                        <div class="profile-img" style="display:none">
                                            <ul class="un_style">
                                                <li>
                                                    <div class="tag_image"  id="tiny-icon-studio" ></div>
                                                </li>

                                            </ul>
                                        </div>

                                        <div class="video_preview" style="display:none">
                                            <ul class="un_style">
                                                <li>
                                                    <div class="tag_image" >
                                                        <video id="tiny-video-studio" src="<?php echo asset('userassets/videos/vid.mp4'); ?>" class="tag_image video"></video>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>

                                    </div>
                                </div> <!-- row -->
                                <div class="mt-2 text-center">
                                    <button type="button" onclick="sendMessageToFriends('<?= $current_id ?>')" class="btn btn-gradient btn-round btn-xl text-semibold">Send</button>
                                </div>
                            </form>
                        </div> <!-- modal-body-->
                    </div> <!-- modal-content-->
                </div>
            </div> <!-- Edit Description modal -->
            <!--  Message modal END -->
        <?php } ?>

        <?php if ($current_user) { ?>
            <script>
                function sendMessageToFriends(otherid) {

                    var recivers_array = [];
                    var message = $('#message' + otherid).val();

                    var title = $('#title' + otherid).val();
                    if(isEmpty(title))
                    {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please add group title').show().fadeOut(5000);
                        return false;
                    }
                    if(isEmpty(message))
                    {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please add group message').show().fadeOut(5000);

                        return false;
                    }
                    var data = new FormData();

                    if(files)
                    {
                        //read input files merge in FormData

                        $.each(files, function (key, value)
                        {
                            data.append('file', value);
                        });

                    }

                    if (message) {
                        recivers = $('#bulk-messages' + otherid).val();
                        if(recivers == '')
                        {
                            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please add Friends in Group').show().fadeOut(5000);
                            return false;
                        }
                        $.each(recivers, function (index, item) {
                            recivers_array.push(item);
                        });

                        // var data = new FormData();
                        data.append('message', message);
                        data.append('receiver_id', recivers_array);
                        data.append('title', title);
                        data.append('_token', '<?= csrf_token() ?>');
//                    data.append('message_type', 'u');
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
                                url: "<?php echo asset('add_friends_message'); ?>",
                                data: data,
                                processData: false,
                                contentType: false,
                                success: function (data) {
                                    $('#modal_friends_message').modal('hide');
                                    counter++;
                                    if (counter == 1) {
                                        $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                                    }
                                    //                                    $('#attachment_loader').hide();
                                    //                                    $('.tiny-div, .files_upload_box').hide();
                                    var result = JSON.parse(data);
                                    //                                    $('.chat_box_wrapper .chat').append(result.append);
                                    //
                                    //                                                                   $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                                    recivers.push('<?=$current_id?>');
                                    $.each(recivers, function (index, item) {

                                        socket.emit('groupmessage_get', {
                                            "user_id": item,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>  added you in group ' + title,
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": result.other_message,
                                            "chat_id": result.chat_id,
                                            "message": message,
                                            "chat_type": 'u',
                                            "chat_type_id": result.chat_id,
                                            "to_be_show": 'u',
                                            "chat_name" : title,
                                        });

                                        if(item != <?=$current_id?>){
                                            socket.emit('notification_get', {
                                                "user_id": item,
                                                "other_id": '<?php echo $current_id; ?>',
                                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                                                "photo": '<?php echo $current_photo; ?>',
                                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' added you in group '+title ,
                                                "url": '<?= asset('groupchat/') ?>',
                                                "chat_id": result.chat_id,
                                                "chat_type": 'u',
                                                "chat_type_id": result.chat_id,
                                                "to_be_show": 'u',
                                                "chat_name" : title,
                                            });
                                        }
                                    });
                                }
                            });
                        }

                    }
                }

            </script>
        <?php } ?>
        <script>
            files = '';
            $("#attachment_student_files").change(function () {

                var fileInput = document.getElementById('attachment_student_files');
                var fileUrl = window.URL.createObjectURL(fileInput.files[0]);
                var image_type = fileInput.files[0].type;
                if (image_type == "image/png" || image_type == "image/gif" || image_type == "image/jpeg" || image_type == "image/bmp" || image_type == "image/jpg") {
//                $('.files_upload_box').show();
                    var file = fileInput.files[0];
                    var reader = new FileReader();
                    reader.onloadend = function (e) {
                        $("#tiny-video").attr("src", '');
                        $("#tiny-video").hide();
                        $(".profile-img").show();
//                    $("#tiny-icon-spacer").show();
                        $("#tiny-icon-studio").css({"backgroundImage": 'url(' + e.target.result + ')'});
                    };
                    reader.readAsDataURL(file);
                } else if (fileInput.files[0].type == "video/mp4" || fileInput.files[0].type == "video/quicktime") {
//                $('.files_upload_box').show();
                    $("#tiny-icon-studio").css({"backgroundImage": 'url()'});
                     $("#tiny-icon-studio").hide();
//                $("#tiny-icon-spacer").hide();

                    $(".video_preview").show();
                    $("#tiny-video-studio").attr("src", fileUrl);
                    var myVideo = document.getElementById("tiny-video-studio");
                    myVideo.addEventListener("loadedmetadata", function ()
                    {
                        duration = (Math.round(myVideo.duration * 100) / 100);
                        if (duration >= 21) {
                            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Video is greater than 20 sec.').show().fadeOut(5000);
                            $("#tiny-video").attr("src", '');
                            $('.tiny-div').hide();
                        }
                    });
                    $("#tiny-icon").attr("src", '');
                    $("#tiny-icon").hide();
                } else if (fileInput.files[0].type == "application/pdf") {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
                    $(".profile-img").show();
                    $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/pdf.png') ?>)'});
                } else if (fileInput.files[0].type == "audio/mp3") {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
//                $("#tiny-icon-spacer").show();
                    $(".profile-img").show();

                    $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/mp3.png') ?>)'});
                } else if (fileInput.files[0].type == "application/vnd.ms-excel" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" || fileInput.files[0].type == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || fileInput.files[0].type == 'application/msword') {
//                $('.files_upload_box').show();
//                $("#tiny-video").attr("src", '');
//                $("#tiny-video").hide();
//                $("#tiny-icon").show();
//                $("#tiny-icon-spacer").show();
                    $(".profile-img").show();

                    $("#tiny-icon-studio").css({"backgroundImage": 'url(<?= asset('userassets/images/docx.png') ?>)'});
                } else {
                    //            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please select a valid file').show().fadeOut(5000);
                    $('.files_upload_box').hide();
                    files = '';
                    $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                    $("#tiny-icon").hide();
                    $(".tiny-div").hide();
                }
            });
            $('#attachment_student_files').on('change', prepareUpload);
            function prepareUpload(event)
            {
                files = event.target.files;
                var input = document.getElementById('attachment_student_files');
                var filePath = input.value;
                var allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif|\.mp4|\.mkv|\.mov|\.flv|\.mpeg|\.webm|\.mpeg|\.avi|\.ts|\.mp3|\.pdf|\.dcx|\.doc|\.docm|\.csv|\.xlsx)$/i;
                if (!allowedExtensions.exec(filePath)) {
                    $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Please Select a valid image,.mp4,.mp3,.pdf,.dcx,.doc,.docm,.docx,.csv,.xlsx').show().fadeOut(5000);
                    $('#attachment').val('');
                    $('#imagePreview').html('');
                    $('.tiny-div').hide();
                    files = '';
                    return false;
                }
            }
        </script>

</body>
</html>