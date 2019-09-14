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
        <div class="page_timeline">        
            <div class="container">
                <div class="box shadow musician_register_form_wrapper">
                    <form id="validate-form" action="<?= asset('edit_user_profile') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">
                                <div class="edit_user_profile_pic">
                                    <div class="image" id="profile-pic-div" style="background-image:url(<?= $current_photo ?>)"></div>
                                    <ul class="un_style no_icon action_dropdown">
                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                            <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                <a class="dropdown-item profile_upload_btn" href="#">
                                                    <input type="file" name="photo" id="upload-profile-pic" accept="image/*"/>
                                                    <i class="fas fa-cloud-upload-alt"></i> Upload Photo 
                                                </a>
                                                <a class="dropdown-item" href="#" id="delete-profile-pic" user-id="<?= $user->id ?>">
                                                    <i class="fas fa-times-circle"></i> Remove 
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
                                                        <input type="hidden" id="original_profile_pic">
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

                            <div class="col-md-9 col-sm-12">
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
                                <div class="form_section">
                                    <h2 class="text-semibold text_maroon">Personal Information</h2>      
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">First Name</label>
                                                <input name="first_name" type="text" required class="form-control" placeholder="Enter First Name Here" value="<?= $user->first_name ?>">
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Last Name</label>
                                                <input name="last_name" type="text" required class="form-control" placeholder="Young" value="<?= $user->last_name ?>">
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Email</label>
                                                <input name="email" type="email" required class="form-control" placeholder="joseph@email.com" value="<?= $user->email ?>">
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-12 col-md-6">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Language</label>
                                                        <select class="form-control selct2_select" name="language" style="width: 100%">
                                                            <?php foreach ($languages as $language) { ?>
                                                                <option <?= $user->language == $language->name ? 'Selected' : '' ?>><?= $language->name ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>							
                                                </div> <!-- col -->
                                                <div class="col-sm-7">
                                                    <label class="font-weight-bold mb-3">Gender</label>
                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
                                                            <div class="custom-control custom-radio">
                                                                <input  type="radio" id="male" name="gender" value="male" class="custom-control-input" <?= $user->gender == 'male' ? 'checked' : '' ?>>
                                                                <label class="custom-control-label" for="male">Male</label>
                                                            </div>
                                                        </div><!-- col -->
                                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" id="female" name="gender" value="female" class="custom-control-input" <?= $user->gender == 'female' ? 'checked' : '' ?>>
                                                                <label class="custom-control-label" for="female">Female</label>
                                                            </div>
                                                        </div> <!-- col -->
                                                    </div>							
                                                </div> <!-- col -->
                                            </div> <!-- row -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Bio</label>
                                                <textarea class="form-control h_140" placeholder="Enter Bio" name="description"><?= $user->description ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Add Interests</label>
                                                <select type="text" name="interests[]" class="form-control" id="interest-dropdown" style="width: 100%" multiple="multiple">
                                                    <?php if ($interests) { ?>
                                                        <?php foreach ($interests as $interest) { ?>
                                                            <option id="interest-option-<?= $interest->id ?>" value="<?= $interest->id ?>"><?= $interest->interest ?></option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <ul class="un_style search_selected_options mb-0" id="interests-ul">
                                                <?php if ($selectedInterests) { ?>
                                                    <?php foreach ($selectedInterests as $interest) { ?>
                                                        <li id="li-<?= $interest->id ?>"><span class="search_selection"><?= $interest->interest ?><span class="selection_remove fas fa-times remove-interest" interest-id="<?= $interest->id ?>"></span></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div>      
                                    <div class="row">
                                        <div class="col-sm-11"><h2 class="text-semibold text_maroon">Education</h2></div>
                                        <div class="col-sm-1">
                                            <i class="fa fa-plus add-fields-btn" id="add-education-btn"></i>
                                        </div>
                                    </div>
                                    <input name="education[]" type="hidden">
                                    <div id="education-dynamic-section" class="box">
                                        <?php if (!$user->getEducations->isEmpty()) { ?>
                                            <?php $educationCounter = 0; ?>
                                            <?php foreach ($user->getEducations as $userEducation) { ?>
                                                <div class="row appended-fields">
                                                    <input type="hidden" name="education[<?= $educationCounter ?>][education_id]" value="<?= $userEducation->id ?>">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Degree Title</label>
                                                            <input required name="education[<?= $educationCounter ?>][title]" value="<?= $userEducation->title ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">College/University</label>
                                                            <input required name="education[<?= $educationCounter ?>][institute_name]" value="<?= $userEducation->institute_name ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start Year</label>
                                                            <input required name="education[<?= $educationCounter ?>][start_year]" value="<?= $userEducation->start_year ?>" type="number" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" class="form-control start_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End Year</label>
                                                            <input required name="education[<?= $educationCounter ?>][end_year]" value="<?= $userEducation->end_year ?>" type="number" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" class="form-control end_year">
                                                        </div>
                                                    </div> 
                                                    <button type="button" class="close remove-education-btn" education-id="<?= $userEducation->id ?>"><i class="fa fa-times-circle"></i></button>
                                                </div>
                                                <?php
                                                $educationCounter++;
                                            }
                                            ?>
<?php } ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-11"><h2 class="text-semibold text_maroon">Experience</h2></div>
                                        <div class="col-sm-1">
                                            <i class="fa fa-plus add-fields-btn" id="add-experience-btn"></i>
                                        </div>
                                    </div>
                                    <input name="experience[]" type="hidden">
                                    <div id="experience-dynamic-section" class="box">
                                        <?php if (!$user->getExperiences->isEmpty()) { ?>
                                            <?php $experienceCounter = 0; ?>
    <?php foreach ($user->getExperiences as $userExperience) { ?>
                                                <div class="row appended-fields">
                                                    <input type="hidden" name="experience[<?= $experienceCounter ?>][experience_id]" value="<?= $userExperience->id ?>">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Job Title</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][title]" value="<?= $userExperience->title ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Company</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][institute_name]" value="<?= $userExperience->institute_name ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start Year</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][start_year]" value="<?= $userExperience->start_year ?>" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;}" type="number" class="form-control start_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End Year</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][end_year]" value="<?= $userExperience->end_year ?>" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" type="number" class="form-control end_year">
                                                        </div>
                                                    </div> 
                                                    <button type="button" class="close remove-experience-btn" experience-id="<?= $userExperience->id ?>"><i class="fa fa-times-circle"></i></button>
                                                </div>
                                                <?php
                                                $experienceCounter++;
                                            }
                                            ?>
<?php } ?>
                                    </div>
                                </div> <!-- from section -->

                                <div class="form_section">
                                    <h2 class="text-semibold text_maroon">Contact</h2>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address</label>
                                                <input autocomplete="off" id="autocomplete" name="address" required="" type="text" class="form-control" placeholder="Address" value="<?= $user->address ?>">
                                                <input style="display: none" class="field" id="street_number" name="street" value="<?php echo old('street'); ?>">
                                                <input style="display: none" class="field" id="route" name="route" value="<?php echo old('route'); ?>">
                                                <input style="display: none" class="field"id="administrative_area_level_1" name="administrative_area_level_1" value="<?php echo old('administrative_area_level_1'); ?>">
                                                <input style="display: none" class="field" id="lat" name="lat" value="<?php echo old('lat'); ?>">
                                                <input style="display: none" class="field" id="lng" name="lng" value="<?php echo old('lng'); ?>">
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Timezone</label>
                                                <select name="timezone" class="form-control selct2_select" style="width: 100%">
                                                    <?php foreach ($timezones as $timezone) { ?>
                                                        <option value="<?= $timezone->offset ?>"><?= $timezone->timezone_location . $timezone->gmt ?></option>
<?php } ?>
                                                </select>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->

                                    <div class="row">
                                        <div class="col-md-6 col-sm-12">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Country</label>
                                                <input id="country" readonly="readonly" name="country" type="text" class="form-control" placeholder="Country" value="<?= $user->country ?>">
                                            </div> <!-- form group -->
                                        </div><!-- col -->
                                        <div class="col-md-6 col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">City</label>
                                                        <input id="locality" readonly="readonly" name="city" required="" type="text" class="form-control" placeholder="City" value="<?= $user->city ?>">
                                                    </div> <!-- form group -->
                                                </div><!-- col -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">Zip or postal code</label>
                                                        <input id="postal_code" name="zip_code" type="number" class="form-control" placeholder="Zip Code" value="<?= $user->zip_code ?>">
                                                    </div> <!-- form group -->
                                                </div><!-- col -->
                                            </div><!-- row -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Phone</label>
                                                <input name="phone" placeholder="Phone"  type="text" class="form-control" value="<?= $user->phone ?>">
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="form-group mt-2">
                                        <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                                    </div>
                                </div> <!-- form section -->

                            </div> <!-- col-->
                        </div>	 <!-- row -->		
                    </form>

                    <form id="change_password_user" class="" action="<?= asset('change_password') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="user_id" value="<?= $user->id ?>">
                        <div class="row">
                            <div class="col-md-3 col-sm-12">                                
                            </div> <!-- col -->
                            <div class="col-md-9 col-sm-12">                              
                                <div class="form_section">                                    
                                    <h2 class="text-semibold text_maroon">Reset Password</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">    
                                                <label class="font-weight-bold">Old Password</label>
                                                <input required name="current_password"  type="password" class="form-control" placeholder="Old Password">
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">    
                                                <label class="font-weight-bold">New Password</label>
                                                <input id="password" required name="password" type="password" class="form-control" placeholder="New Password">
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <label class="font-weight-bold">Repeat New Password</label>
                                            <input required name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- form section -->


                                

                                <div class="form_section">                                    
                                    <h2 class="text-semibold text_maroon">Deactive Account</h2>
                                    <div class="row">
                                        <div class="col-12 font-italic">
                                            <p>This is where you fully deactivate your musician profile. It will disable your name and photo, and make you invisible when searched. Some of your info may still be visible for a short period of time. </p>
                                            <p> Don't forget, you can easily block users, change your profile to private, and remove followers at your own will in the settings area. We wouldn't want to see you remove your portfolio from our talent pool before exploring these options. 
                                            </p>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <a data-toggle="modal" data-target="#modal_deactivate" href="#" class="text-underline text-semibold text-black">Deactivate my Account</a>
                                </div> <!-- form section -->
                                <!-- Delete Model-->
        <div class="modal fade" id="modal_deactivate" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Delete</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <?php if($bookings){ ?>
                    <div class="modal-body">
                        <form>
                            <div>
                                <label class="font-weight-bold">Please complete your bookings before deactivating your account.</label>
                            </div>
                            <div class="mt-3 text-center">
                                <!--<a href="<?= asset('deactive_account')?>" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</a>-->
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> Dismiss </button>
                            </div>
                        </form>
                    </div> 
                    <?php }else { ?>
                    <div class="modal-body">
                        <form>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to deactivate your account?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <a href="<?= asset('deactive_account')?>" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</a>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> 
                    <?php } ?>
                    <!-- modal body -->
                </div>
            </div>
        </div> <!-- Delete modal -->
        <!-- Delete modal END --> 
                                <div class="form_section">                                    
                                    <div class="form-group mt-4">
                                        <!--<button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>-->
                                    </div>
                                </div> <!-- form section -->
                            </div> <!-- col-->
                        </div>	 <!-- row -->		
                    </form>
                </div> <!-- musician_register_form_wrapper -->
            </div> <!-- container -->
        </div>
<?php include resource_path('views/includes/footer.php'); ?>

        <style>
            input.error {
                border:solid 1px red !important;
            }
            label.error {
                display:none !important;
            }
            #change_password_user label.error {
                width: auto;
                display: inline;
                color:red;
                font-size: 16px;
                float:right;
            }
        </style>
        <script>

            jQuery.validator.addMethod("phone", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length > 0 &&
                        phone_number.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/);
            }, "Please enter a valid phone number");
            $("#validate-form").validate({
                rules: {
                    phone: {
                        phone: true
                    }
                }
            });
            $("#change_password_user").validate({
                rules: {

                    current_password: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },

                    password_confirmation: {
                        required: true,
                        equalTo: "#password"
                    },
                },
                messages: {
                    password: {
                        required: "",
                        minlength: "Your password must be at least 6 characters long."
                    },
                    current_password: {
                        required: ""
                    },
                    password_confirmation: {
                        required: "",
                        equalTo: "Please enter the same password as above."
                    }
                }
            });
        </script>
    </body>
</html>

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;
    var componentForm = {
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
        country: 'long_name',
        postal_code: 'short_name'
    };

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
        for (var component in componentForm) {
            document.getElementById(component).value = '';
            //          document.getElementById(component).disabled = false;
        }

        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
            if (componentForm[addressType]) {
                var val = place.address_components[i][componentForm[addressType]];
                document.getElementById(addressType).value = val;
            }
        }
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
</script>

<script>
    $('.remove-interest').click(function () {
        var interestId = $(this).attr('interest-id');
        $.ajax({
            type: "POST",
            url: base_url + "remove_user_interest",
            data: {'interest_id': interestId},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
//                console.log(data);
                $('#li-' + interestId).remove();
                $('#interest-dropdown').append("<option value=" + data.id + ">" + data.interest + "</option>");
            }
        });
    });
    $('#interest-dropdown').select2({
        placeholder: "Select Interests",
        allowClear: true,
        width: 'resolve',
        minimumResultsForSearch: Infinity
    });
    var educationAddClickCount = <?= isset($educationCounter) ? $educationCounter : 0 ?>;
    $('#add-education-btn').click(function () {
        $('#education-dynamic-section').append("<div class='row appended-fields'><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Degree Title</label><input required name='education[" + educationAddClickCount + "][title]' type='text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>College/University</label>\n\<input required name='education[" + educationAddClickCount + "][institute_name]' type=text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Start Year</label><input required name='education[" + educationAddClickCount + "][start_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}'  class='form-control start_year'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>End Year</label><input required name='education[" + educationAddClickCount + "][end_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control end_year'></div></div><button type='button' class='close' onclick='removeDiv(this)'><i class='fa fa-times-circle'></i></button></div>");
        educationAddClickCount++;
//        checkIfStartYearIsLessThanEndYear();
    });
    $('.remove-education-btn').click(function () {
        var educationId = $(this).attr('education-id');
        $.ajax({
            type: "POST",
            url: base_url + "remove_user_education",
            data: {'education_id': educationId},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            }
        });
        $(this).parent('div').remove();
    });
    var experienceAddClickCount = <?= isset($experienceCounter) ? $experienceCounter : 0 ?>;
    $('#add-experience-btn').click(function () {
        $('#experience-dynamic-section').append("<div class='row appended-fields'><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Job Title</label><input required name='experience[" + experienceAddClickCount + "][title]' type='text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Company</label>\n\<input required name='experience[" + experienceAddClickCount + "][institute_name]' type=text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Start Year</label><input required name='experience[" + experienceAddClickCount + "][start_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control start_year'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>End Year</label><input required name='experience[" + experienceAddClickCount + "][end_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control end_year'></div></div><button type='button' class='close' onclick='removeDiv(this)'><i class='fa fa-times-circle'></i></button></div>");
        experienceAddClickCount++;
//        checkIfStartYearIsLessThanEndYear();
    });
    $('.remove-experience-btn').click(function () {
        var experienceId = $(this).attr('experience-id');
        $.ajax({
            type: "POST",
            url: base_url + "remove_user_experience",
            data: {'experience_id': experienceId},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            }
        });
        $(this).parent('div').remove();
    });
    function removeDiv(el) {
        $(el).parent('div').remove();
    }
//    
//    $('#upload-profile-pic').change(handleProfilePicSelect);
//    function handleProfilePicSelect(event)
//    {
//        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
//        var input = this;
//        var filename = $("#upload-profile-pic").val();
//        var fileType = filename.replace(/^.*\./, '');
//        var ValidImageTypes = ["jpg", "jpeg", "png"];
//        if ($.inArray(fileType, ValidImageTypes) < 0) {
//            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
//            event.preventDefault();
//            $('#upload-profile-pic').val('');
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

    $('#upload-profile-pic').on('change', function (event) {       
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#upload-profile-pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#upload-profile-pic').val('');
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
        form.append('pic_type', 'profile_pic');
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
                $('#original_profile_pic').val(data.photo);
            }
        });
        $('#upload_profile_pic_modal').modal('show');
        $('#upload-profile-pic').val('');
    });

    $('#save_profile_pic').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (image) {
            var original_photo = $('#original_profile_pic').val();
            var form = new FormData();
            form.append('photo', image);
            form.append('original_photo', original_photo);
            $.ajax({
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                url: "<?=asset('upload_profile_pic')?>",
                enctype: 'multipart/form-data',
                data: form,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    window.location.reload();
                }
            });
            
        });
    });
</script>