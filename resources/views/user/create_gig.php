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
            <form id="teaching-studio-form" action="<?= asset('timeline') ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                <?php
                $cover = asset('public/images/accompanists/cover_photo_demo.png');
                ?>
                <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
                    <div class="overlay_color">
                        <div class="container">
                            <div class="row">
                                <div class="col-sm-3">
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
                                <div class="col-sm-9 align-self-center text-center">
                                    <div class="custom-file upload_btn text-center mx-auto">
                                        <input type="file" name="cover" id="cover-photo" class="custom-file-input">
                                        <strong class="text_aqua txt-20">+ Add Cover Photo</strong>
                                        <p class="text_grey">Best result size  1920 x 430 pixels</p>
                                    </div>  
                                </div> <!-- col -->
                            </div> <!-- row -->
                        </div> <!-- container -->
                    </div> <!-- overlay color -->
                </div> <!-- cover photo -->
                <div class="container md-fluid-container">
                    <div class="row">
                        <div class="col">
                            <div class="box box-shadow musician_register_form_wrapper clearfix">
                                <div id="group-created-msg-div" style="display: none;">
                                    <div class="alert alert-success">
                                        Gig created successfully.
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
                                        <label class="font-weight-bold">Gig Title</label>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input onkeyup="titleCountCharToMax(this, 150)" maxlength="150" type="text" placeholder="" required class="form-control" name="event_title"/>
                                            <span class='info' id="gig_title"><span class="text_length_title">150</span> Characters</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox text_grey mt-2">
                                                <input type="checkbox" name="custom_booking" value="1" class="custom-control-input" id="lbl_custom_booking">
                                                <label class="custom-control-label" for="lbl_custom_booking">Enable Booking</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox text_grey mt-2">
                                                <input type="checkbox" name="status" value="1" class="custom-control-input" id="lbl_inactive_events">
                                                <label class="custom-control-label" for="lbl_inactive_events">Inactive Gig</label>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Location</label>
                                            <input autocomplete="off" id="autocomplete" name="location" required type="text" class="form-control" placeholder="Address" value="<?php echo old('address'); ?>">
                                            <input id="lat" name="lat" type="hidden">
                                            <input id="lng" name="lng" type="hidden">
                                        </div>
                                    </div><!-- col -->

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Range (km)</label>
                                            <input type="number" onkeypress="if (this.value.length == 10)
                                                        return false;" min="0" required="" class="form-control" name="range">
                                        </div>
                                    </div>

                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Price</label>
                                            <input type="number" min="0" required="" class="form-control" name="price">
                                        </div>
                                    </div><!-- col -->
                                    <div class="col-sm-6">    
                                        <label class="font-weight-bold">Per Unit</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="number" placeholder="" required class="form-control" name="per_unit"/>
                                                </div><!-- from group -->
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select class="form-control selct2_select" required name="unit_id" style="width: 100%">
                                                        <?php foreach (units() as $unit) { ?>
                                                            <option value="<?= $unit->id ?>"><?= $unit->title ?></option>
                                                        <?php } ?>
                                                    </select><!-- from group -->
                                                </div><!-- from group -->
                                            </div>
                                        </div> <!-- row -->

                                    </div> <!-- col -->
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="font-weight-bold">Select Categories</label>
                                        <div class="form-group">
                                            <select required name="categories" id="multiple_solo_categories"  multiple="multiple" class="form-control" style="width: 100%">
                                                <?php foreach (soloCategories() as $artistType) { ?>
                                                    <option value="<?= $artistType->id ?>"><?= $artistType->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <label class="font-weight-bold">Ensemble Category</label>
                                        <div class="form-group">
                                            <select required name="ensemble_category" class="form-control" style="width: 100%">
                                                <?php foreach (ensembleCategories() as $cat) { ?>
                                                    <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                                                <?php } ?>
                                            </select>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                </div>

                                <div class="row">                                    
                                    <div class="col-sm-6">
                                        <label class="font-weight-bold">Genre</label>
                                        <div class="form-group">
                                            <select required name="genre" class="form-control selct2_select" style="width: 100%">
                                                <option value="" selected="">--Select a genre--</option>
                                                <option>Baroque</option>
                                                <option>Classical</option>
                                                <option>Jazz</option>
                                                <option>Country</option>
                                                <option>World</option>
                                                <option>Rock</option>
                                                <option>Electronic</option>
                                                <option>Popular</option>
                                                <option>Wedding</option>
                                            </select>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                </div>


                                <div class="form-group">
                                    <label class="font-weight-bold">Description</label>
                                    <textarea onkeyup="descriptionCountCharToMax(this, 300)" maxlength="300" class="form-control h_140" required placeholder="" id="descriptin_count_f" name="event_detail"></textarea>
                                    <span class='info' id="gig_description"><span class="text_length_desc">300</span> Characters</span>
                                </div>
                                <div class="form-group text-center mt-2 mb-0">
                                    <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">
                                        <strong>Save</strong>
                                        <span class="loader_inline" id="post_loader" style="display: none;">
                                            <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading..">
                                        </span>
                                    </button>
                                </div>
                            </div> <!-- Box -->
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div> <!-- container -->
            </form>    
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            label.error {
                display: none !important;
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
<script>

                                        $('#teaching-studio-form').validate({
//        onfocusout: false,
//        onkeyup: false,
//        onclick: false,
                                            submitHandler: function () {
                                                submitForm();
                                            }
                                        });

    function submitForm(){
        $('button[type="submit"]').attr('disabled', 'disabled');
        $('#post_loader').show();
        
        form = new FormData();
        var profile_pic = $('#profile-photo')[0].files[0];
        var photo = $('input[name=photo]').val();
        var original_photo = $('input[name=original_photo]').val();
        var cover = $('#cover-photo')[0].files[0];
        var event_title = $('input[name=event_title]').val();
        var custom_booking = '';
        if($('input[name=custom_booking]').is(":checked")){
            custom_booking = $('input[name=custom_booking]').val();
        }
        var status = '';
        if($('input[name=status]').is(":checked")){
            status = $('input[name=status]').val();
        }
        var location = $('input[name=location]').val();
        var lat = $('input[name=lat]').val();
        var lng = $('input[name=lng]').val();
        var range = $('input[name=range]').val();
        var price = $('input[name=price]').val();
        var per_unit = $('input[name=per_unit]').val();
        var unit_id = $('select[name=unit_id]').val();
        var categories = $('select[name=categories]').val();
        var ensemble_category = $('select[name=ensemble_category]').val();
        var genre = $('select[name=genre]').val();
        var event_detail = $('textarea[name=event_detail]').val();
        
        form.append('profile_pic', profile_pic);
        form.append('photo', photo);
        form.append('original_photo', original_photo);
        form.append('cover', cover);
        form.append('event_title', event_title);
        form.append('custom_booking', custom_booking);
        form.append('status', status);
        form.append('location', location);
        form.append('lat', lat);
        form.append('lng', lng);
        form.append('range', range);
        form.append('price', price);
        form.append('per_unit', per_unit);
        form.append('unit_id', unit_id);
        form.append('categories', categories);
        form.append('ensemble_category', ensemble_category);
        form.append('genre', genre);
        form.append('event_detail', event_detail);
        
        $.ajax({
            url: base_url + 'timeline',
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: form,
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success:function(response) {
                $('#post_loader').hide();
                $("html, body").animate({scrollTop: 0}, "slow");
                $("#group-created-msg-div").fadeIn();
                setTimeout(function(){ window.location.href= base_url+'events'; }, 5000);
            }
        });
    }    
    
    $('#cover-photo').change(handleCoverPicSelect);
    function handleCoverPicSelect(event)
    {
        var input = this;
        var filename = $("#cover-photo").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#cover-photo').val('');
            return;
        }
        if (input.files[0].size < 2000000) {
            if (input.files && input.files[0])
            {
                var reader = new FileReader();
                reader.onload = (function (e)
                {
                    $('.group_profile_cover_photo').css("background-image", "url(" + e.target.result + ")");
                });
                reader.readAsDataURL(input.files[0]);
            }
        } else {
            alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
        }
    }
    
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
        form.append('pic_type', 'gig_pic');
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
            form.append('pic_type', 'gig_pic');
            $.ajax({
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                url: "<?=asset('upload_service_profile_pic')?>",
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
</script>