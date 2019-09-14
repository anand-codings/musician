<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body>        
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_create_group">
            <form id="group-form" action="<?= asset('create_group') ?>" method="post" enctype="multipart/form-data">
                <input id="x" type="hidden" name="x" value="">
                <input id="y" type="hidden" name="y" value="">
                <input id="h" type="hidden" name="h" value="">
                <input id="w" type="hidden" name="w" value="">

                <input id="image_croped" type="hidden" name="image_croped" value="">
                <input id="top" type="hidden" name="top" value="">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                <?php
                $cover = asset('public/images/teaching_studios/cover_photo_demo.png');
                ?>
                <div id="cover_image_header" class="group_profile_cover_photo" id="cover-pic-div" style="display: none; ">
                    <div id="capture"><img class="" id="cover_image"  src="<?= $cover ?>" ></div>
                    <div class="jwc_btns">
                        <input type="button" class="btn btn-info" value="Save" onclick="saveForm()">
                        <input type="button" class="btn btn-danger" value="Cancel" onclick="cancelForm()">
                    </div>
                </div>
                <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
                    <div class="overlay_color">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-sm-4">
                                    <div class="edit_user_profile_pic">
                                        <?php
                                        $pic = asset('public/images/profile_pics/demo.png');
                                        ?>
                                        <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                                        <ul class="un_style no_icon action_dropdown">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                    <a class="dropdown-item profile_upload_btn" href="#">
                                                        <input type="file" name="photo_base64" id="profile-photo" accept="image/*"/>
                                                        <i class="fas fa-cloud-upload-alt"></i> Upload Photo 
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal" id="upload_profile_pic_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Upload Profile Pic</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <div id="upload-demo"></div>
                                                            <input type="hidden" name="original_photo">
                                                            <input type="hidden" name="photo">
                                                            <button type="button" id="save_profile_pic" class="btn btn-success btn-block mt-4">Save</button>
                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- col -->
                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="d-flex justify-content-center">
                                        <div class="custom-file upload_btn text-center mx-auto">
                                            <input type="file" name="cover" id="upload-cover-pic" class="custom-file-input">
                                            <strong class="text_aqua txt-20">+ Add Cover Photo</strong>
                                            <p class="text_grey">Best result size  1920 x 430 pixels</p>
                                        </div>  
                                    </div>  
                                </div> <!-- col -->
                            </div> <!-- row -->
                        </div> <!-- container -->
                    </div> <!-- overlay color -->
                </div> <!-- cover photo -->
                <div class="page_timeline">
                    <div class="container md-fluid-container">
                        <div class="row">
                            <div class="col-xl-11 col-lg-12 mx-auto">
                                <div class="box box-shadow musician_register_form_wrapper clearfix">
                                    <div id="group-created-msg-div" style="display: none;">
                                        <div class="alert alert-success">
                                            Group created successfully.
                                        </div>
                                    </div>
                                    <?php
                                    if ($errors->any()) {
                                        foreach ($errors->all() as $error) {
                                            ?>
                                            <h6 class="alert alert-danger"> <?php echo $error ?></h6>
                                            <?php
                                        }
                                    }
                                    if (Session::has('success')) {
                                        ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('success') ?>
                                        </div>
                                        <?php
                                    }
                                    if (Session::has('error')) {
                                        ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('error') ?>
                                        </div>
                                    <?php } ?>

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Event Service Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="text" name="name" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox text_grey mt-2">
                                                    <input type="checkbox" name="allow_booking" value="1" class="custom-control-input" id="lbl_inactive_events">
                                                    <label class="custom-control-label" for="lbl_inactive_events">Allow peoples to Booking</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Select Category</label>
                                                <select name="artist_type_id" required class="form-control selct2_select" style="width: 100%">
                                                    <?php foreach ($categories as $category) { ?>
                                                        <option value="<?= $category->id ?>"><?= $category->title ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Since</label>
                                                <?php
                                                $currentYear = date("Y");
                                                $oldYear = $currentYear - 50;
                                                ?>
                                                <select name="since" required class="form-control selct2_select" style="width: 100%">
                                                    <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                        <option value="<?= $oldYear ?>"><?= $oldYear ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Location</label>
                                                <input autocomplete="off" id="autocomplete" name="address" required type="text" class="form-control" placeholder="Address" value="<?php echo old('address'); ?>">
                                                <input id="lat" name="lat" type="hidden">
                                                <input id="lng" name="lng" type="hidden">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Add Members</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" id="member-input" class="form-control mr-2" name="members">
                                                <input autocomplete="off" type="text" id="member-search-input" class="form-control mr-2">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul class="un_style group_members">
                                            </ul>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea placeholder="Enter Description" required name="description" class="form-control h_140"></textarea>
                                    </div>
                                    <div class="form-group clearfix mb-1">
                                        <label class="float-left font-weight-bold">Gallery</label>
                                        <label class="custom-file upload_btn float-right font-weight-bold">
                                            <input type="file" name="gallery_images[]" id="gallery-images-input" class="custom-file-input" multiple>
                                            <i class="fas fa-upload"></i> Upload
                                        </label>
                                    </div>
                                    <ul class="un_style clearfix photo_media_list">
                                    </ul>
                                    <div class="form-group text-center mt-2 mb-0">
                                        <button type="submit" class="btn btn-round btn-gradient btn-xl">
                                            <strong>Save</strong>
                                            <span class="loader_inline" id="post_loader" style="display: none;">
                                                <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading..">
                                            </span>
                                        </button>
                                    </div>

                                </div> <!-- Box -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div> <!-- pagetimeline -->
                </div> <!-- container -->
            </form>
            <?php if (Auth::guard('user')->check()) { ?>
                <div class="sidebar show_on_mobile">
                    <?php include resource_path('views/includes/sidebar.php'); ?>
                </div>
            <?php } ?>
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            #group-form label.error {
                width: auto;
                display: none !important;
                color:red;
                font-size: 16px;
                float:right;
            }
            .ui-autocomplete{
                max-height: 200px;
                overflow-y: auto;
                overflow-x: hidden;
            }

        </style>
    </body>
</html>
<script>

    $('#group-form').validate({
//        onfocusout: false,
//        onkeyup: false,
//        onclick: false,
        submitHandler: function () {
            submitForm();
        }
    });

    function submitForm() {
        $('button[type="submit"]').attr('disabled', 'disabled');
        $('#post_loader').show();
        form = new FormData();
        var pic = $('#profile-photo')[0].files[0];
        var photo = $('input[name=photo]').val();
        var original_photo = $('input[name=original_photo]').val();
        var cover = $('#upload-cover-pic')[0].files[0];
        var name = $('input[name=name]').val();
        var artist_type_id = $('select[name=artist_type_id]').val();
        var since = $('select[name=since]').val();
        var address = $('input[name=address]').val();
        var lat = $('input[name=lat]').val();
        var lng = $('input[name=lng]').val();
        var image_croped = $('#image_croped').val();
        var description = $('textarea[name=description]').val();
        var members = '';
        if ($('input[name=members]').val() != '') {
            members = $('input[name=members]').val();
        }
        var allow_booking = '';
        if ($('input[name=allow_booking]').is(":checked")) {
            allow_booking = $('input[name=allow_booking]').val();
        }
        form.append('pic', pic);
        form.append('photo', photo);
        form.append('original_photo', original_photo);
        form.append('cover', cover);
        form.append('name', name);
        form.append('allow_booking', allow_booking);
        form.append('artist_type_id', artist_type_id);
        form.append('since', since);
        form.append('address', address);
        form.append('lat', lat);
        form.append('lng', lng);
        form.append('image_croped', image_croped);
        form.append('members', members);
        form.append('description', description);
        for (var i = 0; i < $('#gallery-images-input').get(0).files.length; ++i) {
            form.append('gallery_images[' + i + ']', $('#gallery-images-input').get(0).files[i]);
        }
        $.ajax({
            url: base_url + 'create_group',
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: form,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (response) {
                $('#post_loader').hide();
                var notificationsCount = response.notifications.length;
                var notifications = response.notifications;
                if (notificationsCount > 0) {
                    for (var i = 0; i < notificationsCount; i++) {
                        socket.emit('notification_get', {
                            "user_id": notifications[i].on_user,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> ' + notifications[i].notification_text,
                            "url": '<?= asset('group_time_line') ?>' + '/' + notifications[i].type_id,
                            "group_id": notifications[i].type_id,
                            "group_name": response.group_name,
                            "group_url": '<?= asset('group_time_line') ?>' + '/' + notifications[i].type_id,
                            "unique_text": notifications[i].unique_text,
                            "group_invite": 1,
                            "notification_icon": '<?= asset('userassets/images/group.png') ?>',
                        });
                    }
                }
                console.log(response);
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#group-created-msg-div").fadeIn();
                setTimeout(function () {
                    window.location.href = base_url + 'groups';
                }, 5000);
            }
        });
    }

    var membersIds = [];
    membersIds.push(<?= $current_id ?>);

    $("#member-search-input").autocomplete({
        source: base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)),
        minLength: 0,
        select: function (event, ui) {
            membersIds.push(ui.item.id);
            $("#member-search-input").autocomplete('option', 'source', base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)));
            $("#member-input").val(membersIds);
            $("#member-search-input").val('');
            var photo = base_url + 'public/images/profile_pics/demo.png';
            console.log(ui.item.photo);
            if (ui.item.photo) {
                photo = base_url + 'public/images/' + ui.item.photo;
            }
            $(".group_members").append('<li id="member-photo-li-' + ui.item.id + '"><img src="' + photo + '" class="rounded-circle" title="' + ui.item.first_name + ' ' + ui.item.last_name + '" /><i class="fas fa-times-circle" onclick="removeMember(this)"  member-id="' + ui.item.id + '"></i></li>');
            return false;
        }
    })
            .bind('click', function () {
                $(this).autocomplete("search");
            })
            .data("ui-autocomplete")._renderItem = function (ul, item) {
        var profile_pic = 'profile_pics/demo.png';
        if (item.photo) {
            profile_pic = item.photo;
        }
        var inner_html = '<div class="add_member_field d-flex align-items-center"><div class="image"><img class="rounded-circle" style="height:35px; width:35px;" src="' + base_url + 'public/images/' + profile_pic + '" ></div><div class="label"><h4><b>' + item.first_name + ' ' + item.last_name + '</b></h4></div></div>';
        return $("<li></li>")
                .data("item.autocomplete", item)
                .append(inner_html)
                .appendTo(ul);
    };

    function removeMember(el) {
        var memberId = $(el).attr('member-id');
        $('#member-photo-li-' + memberId).remove();
        var index = membersIds.indexOf(parseInt(memberId));
        if (index > -1) {
            membersIds.splice(index, 1);
        }
        $("#member-search-input").autocomplete('option', 'source', base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)));
        $("#member-input").val(membersIds);
    }

    $('#gallery-images-input').change(function ()
    {
        var leng = this.files.length;
        for (i = 0; i < leng; i++)
        {
            var reader = new FileReader();
            reader.onload = function (e)
            {
                $('.photo_media_list').append('<li><a href="#"><div class="gallery_image"> <img src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer" alt="" /><div class="img" style="background-image:url(' + e.target.result + ')"></div></div></a></li>');
            }
            reader.readAsDataURL(this.files[i]);
        }
    });

    $('#upload-cover-pic').change(handleCoverPicSelect);
//    function handleCoverPicSelect(event)
//    {
//        var input = this;
//        var filename = $("#cover-photo").val();
//        var fileType = filename.replace(/^.*\./, '');
//        var ValidImageTypes = ["jpg", "jpeg", "png"];
//        if ($.inArray(fileType, ValidImageTypes) < 0) {
//            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
//            event.preventDefault();
//            $('#cover-photo').val('');
//            return;
//        }
//        if (input.files[0].size < 2000000) {
//            if (input.files && input.files[0])
//            {
//                var reader = new FileReader();
//                reader.onload = (function (e)
//                {
//                    $('.group_profile_cover_photo').css("background-image", "url(" + e.target.result + ")");
//                });
//                reader.readAsDataURL(input.files[0]);
//            }
//        } else {
//            alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
//        }
//    }
//    $('#profile-photo').change(handleProfilePicSelect);
//    function handleProfilePicSelect(event)
//    {
//        var input = this;
//        var filename = $("#profile-photo").val();
//        var fileType = filename.replace(/^.*\./, '');
//        var ValidImageTypes = ["jpg", "jpeg", "png"];
//        if ($.inArray(fileType, ValidImageTypes) < 0) {
//            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
//            event.preventDefault();
//            $('#profile-photo').val('');
//            return;
//        }
//        if (input.files[0].size < 2000000) {
//            if (input.files && input.files[0])
//            {
//                var reader = new FileReader();
//                reader.onload = (function (e)
//                {
//                    $('#profile-pic-div').css("background-image", "url(" + e.target.result + ")");
//                });
//                reader.readAsDataURL(input.files[0]);
//            }
//        } else {
//            alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
//        }
//    }

    var placeSearch, autocomplete;

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
                /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
                {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#profile-photo').on('change', function (event) {
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#profile-photo").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#profile-photo').val('');
            return;
        }
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result,
                zoom: 0
            });
        };
        reader.readAsDataURL(this.files[0]);
        var image = this.files[0];
        var form = new FormData();
        form.append('photo', image);
        form.append('pic_type', 'group_pic');
        $.ajax({
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            url: base_url + "save_original_profile_pic",
            enctype: 'multipart/form-data',
            data: form,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                $('input[name="original_photo"]').val(data.photo);
            }
        });
        $('#upload_profile_pic_modal').modal('show');
    });

    $('#save_profile_pic').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (image) {
            var form = new FormData();
            form.append('photo', image);
            form.append('pic_type', 'group_pic');
            $.ajax({
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                url: "<?= asset('upload_service_profile_pic') ?>",
                enctype: 'multipart/form-data',
                data: form,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    $('input[name="photo"]').val(data.photo);
                    $('#profile-pic-div').css("background-image", "url(" + image + ")");
                    $('#upload_profile_pic_modal').modal('hide');
                }
            });
        });
    });

    function handleCoverPicSelect(event)
    {
        $('#cover_image').addClass('crop_me');

        $('.update_cover_photo_btn .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#upload-cover-pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#upload-cover-pic').val('');
            return;
        }
        if (input.files[0].size < 2000000) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var reader = new FileReader();
                reader.onload = function (e) {
                    getOrientation(file, function (orientation) {

//                            alert(orientation);
                        resetOrientation(reader.result, orientation, function (result) {

                            $('#cover-pic-div').hide();
                            $('#cover_image_header').show();
                            $('.jwc_frame').show();
                            $('.jwc_controls').hide();
                            $('#cover_image').attr('src', result);
                            $('#cover-pic-div').css('background-image', 'url(' + result + ')');

                            var width = $(window).width();
                            $('.crop_me').jWindowCrop({
                                targetWidth: width,
                                targetHeight: 300,
                                loadingText: 'loading',
                                onChange: function (result) {
                                    $('#x').val(result.cropX);
                                    $('#top').val($('#cover_image')[0].style.top);
                                    $('#y').val(result.cropY);
                                    $('#w').val(result.cropW);
                                    $('#h').val(result.cropH);

                                }
                            });
                        });
                    });

                }

                reader.readAsDataURL(file);
            } else {
                alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
            }
        }
    }
    function getOrientation(file, callback) {
        var reader = new FileReader();

        reader.onload = function (event) {
            var view = new DataView(event.target.result);

            if (view.getUint16(0, false) != 0xFFD8)
                return callback(-2);

            var length = view.byteLength,
                    offset = 2;

            while (offset < length) {
                var marker = view.getUint16(offset, false);
                offset += 2;

                if (marker == 0xFFE1) {
                    if (view.getUint32(offset += 2, false) != 0x45786966) {
                        return callback(-1);
                    }
                    var little = view.getUint16(offset += 6, false) == 0x4949;
                    offset += view.getUint32(offset + 4, little);
                    var tags = view.getUint16(offset, little);
                    offset += 2;

                    for (var i = 0; i < tags; i++)
                        if (view.getUint16(offset + (i * 12), little) == 0x0112)
                            return callback(view.getUint16(offset + (i * 12) + 8, little));
                } else if ((marker & 0xFF00) != 0xFF00)
                    break;
                else
                    offset += view.getUint16(offset, false);
            }
            return callback(-1);
        };

        reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
    }
    function resetOrientation(srcBase64, srcOrientation, callback) {
        var img = new Image();

        img.onload = function () {
            var width = img.width,
                    height = img.height,
                    canvas = document.createElement('canvas'),
                    ctx = canvas.getContext("2d");

            // set proper canvas dimensions before transform & export
            if (4 < srcOrientation && srcOrientation < 9) {
                canvas.width = height;
                canvas.height = width;
            } else {
                canvas.width = width;
                canvas.height = height;
            }

            // transform context before drawing image
            switch (srcOrientation) {
                case 2:
                    ctx.transform(-1, 0, 0, 1, width, 0);
                    break;
                case 3:
                    ctx.transform(-1, 0, 0, -1, width, height);
                    break;
                case 4:
                    ctx.transform(1, 0, 0, -1, 0, height);
                    break;
                case 5:
                    ctx.transform(0, 1, 1, 0, 0, 0);
                    break;
                case 6:
                    ctx.transform(0, 1, -1, 0, height, 0);
                    break;
                case 7:
                    ctx.transform(0, -1, -1, 0, height, width);
                    break;
                case 8:
                    ctx.transform(0, -1, 1, 0, 0, width);
                    break;
                default:
                    break;
            }

            // draw image
            ctx.drawImage(img, 0, 0);

            // export base64
            callback(canvas.toDataURL());
        };

        img.src = srcBase64;
    }
    function saveForm() {
        html2canvas(document.querySelector("#capture")).then(canvas => {
//                                    document.body.appendChild(canvas);
            dataURL = canvas.toDataURL();
            $('#image_croped').val(dataURL);
            $('#cover-pic-div').css('background-image', 'url(' + dataURL + ')');
            $('#cover-pic-div').show();
            $('#cover_image_header').hide();
        });

    }
    function cancelForm() {
        window.location.reload();
    }
</script>