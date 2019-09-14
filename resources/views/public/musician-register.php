<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>   
    <?php include resource_path('views/includes/header-timeline.php'); ?>
    <body>
        <div class="page_title_header">
            <div class="container">
                <h1>Register as Musician</h1>
                <span>Join over 1500+ musician community</span>
            </div>
        </div>

        <div class="container md-fluid-container">
            <div class="box shadow musician_register_form_wrapper">
                <form id="musician_register" method="post" action="<?= asset('musician-register') ?>">
                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                    <div class="form_section">
                        <h2 class="text-semibold text_maroon">Personal Information</h2>      
                        <?php
                        if ($errors->any()) {
                            foreach ($errors->all() as $error) {
                                ?>
                                <h6 class="alert alert-danger"> <?php echo $error ?></h6>
                                <?php
                            }
                        }
                        if (Session::has('error')) {
                            ?>
                            <div class="alert alert-danger">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('error') ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">First Name</label>
                                    <input maxlength="15" name="first_name" required="" type="text" class="form-control" placeholder="First Name" value="<?php echo old('email'); ?>">
                                </div>
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Last Name</label>
                                    <input maxlength="15" name="last_name" required="" type="text" class="form-control" placeholder="Last Name" value="<?php echo old('last_name'); ?>">
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Email Address</label>
                                    <input id="email" name="email" required="" type="email" class="form-control" placeholder="johndoe@example.com" value="<?php echo old('email'); ?>">
                                    <label style="display:none" id="errormessage" class="error" for="">The Given Email was already Taken.</label>

                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Gender</label>
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
                                            <div class="custom-control custom-radio">
                                                <input  type="radio" id="male" name="gender" value="male" class="custom-control-input" checked="">
                                                <label class="custom-control-label" for="male">Male</label>
                                            </div>
                                        </div><!-- col -->
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4 ">
                                            <div class="custom-control custom-radio">
                                                <input type="radio" id="female" name="gender" value="female" class="custom-control-input">
                                                <label class="custom-control-label" for="female">Female</label>
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div><!-- form group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Availability</label>
                                    <div class="custom-control custom-checkbox">
                                        <input name="availability" type="checkbox" class="custom-control-input" id="customCheck1" checked="">
                                        <label class="custom-control-label" for="customCheck1"> Would you available for booking? </label>
                                    </div>
                                </div><!-- form group -->
                            </div><!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Specialization</label>
                                    <select required name="specialization[]" id="multiple_specialities"  multiple="multiple" class="form-control" style="width: 100%">
                                        <?php foreach ($categories as $category) { ?>
                                            <option value="<?= $category->id ?>"><?= $category->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div><!-- form group -->
                            </div><!-- col -->
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <label class="font-weight-bold">Language</label>
                                    <div>
                                        <select name="language" class="form-control selct2_select" style="width: 100%">
                                            <?php foreach ($languages as $language) { ?>
                                                <option><?= $language->name ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div><!-- form group -->
                            </div><!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Genre</label>
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
                                </div><!-- form group -->
                            </div><!-- col -->
                            <div class="col-sm-6"></div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="font-weight-bold">Affiliations</label>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-6 col-lg-4 ">
                                            <div class="custom-control custom-radio">
                                                <input value="yes" checked="" type="radio" id="union" name="affiliation" class="custom-control-input" onclick="showhidedrop('1')">
                                                <label class="custom-control-label" for="union">Union</label>
                                            </div>
                                        </div><!-- col -->
                                        <div class="col-sm-6 col-md-6 col-lg-4 ">
                                            <div class="custom-control custom-radio">
                                                <input value="no" type="radio" id="non-union" name="affiliation" class="custom-control-input" onclick="showhidedrop('0')">
                                                <label class="custom-control-label" for="non-union">Non-Union</label>
                                            </div>
                                        </div><!-- col -->
                                    </div> <!-- row -->
                                </div><!-- form group -->
                            </div><!-- col -->
                            <div class="col-sm-6">
                                <div class="form-group" id="union_drop_down">
                                    <select  name="unions" class="form-control selct2_select" id="selectunion" style="width: 100%">
                                        <option value="" selected="">--Select a union--</option>
                                        <?php foreach ($unions as $union) { ?>
                                            <option value="<?= $union->id ?>"><?= $union->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div><!-- form group -->
                            </div><!-- col -->
                        </div> <!-- row -->
                    </div> <!-- from section -->

                    <div class="form_section">
                        <h2 class="text-semibold text_maroon">Contact</h2>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Address</label>
                                    <input autocomplete="off" id="autocomplete" name="address" required="" type="text" class="form-control" placeholder="Address" value="<?php echo old('address'); ?>">
                                    <input style="display: none" class="field" id="street_number" name="street" value="<?php echo old('street'); ?>">
                                    <input style="display: none" class="field" id="route" name="route" value="<?php echo old('route'); ?>">
                                    <input style="display: none" class="field" id="administrative_area_level_1" name="administrative_area_level_1" value="<?php echo old('administrative_area_level_1'); ?>">
                                    <input style="display: none" class="field" id="lat" name="lat" value="<?php echo old('lat'); ?>">
                                    <input style="display: none" class="field" id="lng" name="lng" value="<?php echo old('lng'); ?>">
                                </div> <!-- form group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Timezone</label>
                                    <select name="timezone" class="form-control selct2_select" id="selecttimezone" style="width: 100%">
                                        <?php foreach ($timezones as $timezone) { ?>
                                            <option value="<?= $timezone->offset ?>"><?= $timezone->timezone_location . $timezone->gmt ?></option>
                                        <?php } ?>
                                    </select>
                                </div> <!-- form group -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Country</label>
                                    <input id="country" name="country" type="text" class="form-control" placeholder="Country" value="<?php echo old('country'); ?>">
                                </div> <!-- form group -->
                            </div><!-- col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">City</label>
                                            <input id="locality" name="city" required="" type="text" class="form-control" placeholder="City" value="<?php echo old('city'); ?>">
                                        </div> <!-- form group -->
                                    </div><!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Zip or postal code</label>
                                            <input id="postal_code" name="zip_code" type="number" class="form-control" placeholder="Zip Code" value="<?php echo old('zip_code'); ?>">
                                        </div> <!-- form group -->
                                    </div><!-- col -->
                                </div><!-- row -->
                            </div> <!-- col -->
                        </div> <!-- row -->



                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Phone</label>
                                    <input name="phone"  required="" type='text' class="form-control" placeholder="Phone" value="<?php echo old('email'); ?>">
                                </div> <!-- form group -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div> <!-- form section -->

                    <div class="form_section">
                        <h2 class="text-semibold text_maroon">Password</h2>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">    
                                    <label class="font-weight-bold">Password</label>
                                    <input id="password" name="password" required="" type="password" class="form-control" placeholder="Password">
                                </div> <!-- form group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <label class="font-weight-bold">Repeat Password</label>
                                <input name="confirm_password" required="" type="password" class="form-control" placeholder="Confirm password">
                            </div> <!-- col -->
                        </div> <!-- row -->

                        <div class="form-group mt-4">
                            <button id="submitform" type="submit" class="btn btn-round btn-gradient btn-xl font-weight-bold">Register</button>
                        </div>
                    </div> <!-- form section -->
                </form>
            </div> <!-- musician_register_form_wrapper -->
        </div> <!-- container -->

        <div class="join_us_section text-center">
            <div class="container-fluid padding_fluid">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section_title">Why you have to <span class="highlight"><strong>Join Right Now?</strong></span></h2>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Discover favorite musicians</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Follow musician wall</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Book for special events</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="join_btns_group">
                            <a href="#" class="btn btn-round btn-white">Join for free</a>
                        </div>
                    </div>
                </div> <!-- row --> 

            </div> <!-- container -->
        </div> <!-- join us section -->

        <footer class="footer">
            <div class="container-fluid padding_fluid">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="widget_about">
                            <h3><strong>Musician .inc</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-lg-5 col-md-12 ml-auto">                         
                        <h4><strong>FIND BY</strong></h4>
                        <ul class="footer_quick_links clearfix">
                            <li><a href="#">Double bass	</a></li>	
                            <li><a href="#">Flute</a></li>	
                            <li><a href="#">Trumpet</a></li>			
                            <li><a href="#">Violin</a></li>
                            <li><a href="#">Drum</a></li>				
                            <li><a href="#">Guitar</a></li>
                            <li><a href="#">Saxophone</a></li>
                            <li><a href="#">Sitar</a></li>
                            <li><a href="#">Piano</a></li>
                            <li><a href="#">Recorder</a></li>
                            <li><a href="#">Cello</a></li>
                            <li><a href="#">Harp</a></li>
                        </ul>                        
                    </div> <!-- col -->
                </div> <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="copyright">
                            <p class="pb-0 my-0">Designed By CodingPixel � All Rights Reserved - 2018</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <ul class="social_media">
                            <li> <a href="#"> <i class="fas fa-rss"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-facebook-f"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-soundcloud"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-twitter"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-google-plus-g"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-vimeo-v"></i> </a> </li>
                        </ul>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </footer>        
        <div class="menu_overlay"></div>
        <?php include resource_path('views/includes/footer.php'); ?>     
        <script src="<?php echo asset('userassets/js/jquery.validate.js') ?>"></script>
        <script src="<?php echo asset('userassets/js/additional-methods.js') ?>"></script>
        <script src="<?php echo asset('userassets/js/jquery.validate.min.js') ?>"></script>
        <script src="<?php echo asset('userassets/js/additional-methods.min.js') ?>"></script>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            #musician_register checkbox.error {
                background-color: red;
            }
            #musician_register label.error {
                width: auto;
                display: inline;
                color:red;
                font-size: 16px;
                float:right;
            }
            /*            #musician_register label.error {
                            display: none !important;
                        }*/
        </style>
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
            $(document).ready(function () {
                $('#multiple_specialities').select2({
                    placeholder: "--Select Specialities--",
                    maximumSelectionLength: 3
                });
                $('#email').focusout(function () {
                    email = $(this).val();
//                    $('#regloader').fadeIn();
                    $.ajax({
                        type: "GET",
                        data: {"email": email},
                        url: "<?php echo asset('authenticate_email'); ?>",
                        success: function (data) {
//                            $("#regloader").fadeOut(1000);
                            if (data) {
                                $('#errormessage').hide();
                                $('#email').css('border-color', 'black');
                                $('#submitform').attr('disabled', false);
                            } else {
                                $('#errormessage').show();
                                $('#email').css('border-color', 'red');
                                $('#submitform').attr('disabled', true);
                            }
                        }
                    });
                });
                jQuery.validator.addMethod("phone", function (phone_number, element) {
                    phone_number = phone_number.replace(/\s+/g, "");
                    return this.optional(element) || phone_number.length > 0 &&
                            phone_number.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/);
                }, "Please enter a valid phone number");
                $("#musician_register").validate({
                    rules: {
                        email: {
                            required: true,
                            email: true
                        },
                        password: {
                            required: true,
                            minlength: 6
                        },
                        confirm_password: {
                            required: true,
                            equalTo: "#password"
                        },

                        first_name: {
                            required: true
                        },
                        last_name: {
                            required: true
                        },
                        city: {
                            required: true
                        },
                        address: {
                            required: true
                        },
                        phone: {
                            required: true,
                            phone: true
                        },
                        country: {
                            required: true
                        },
                        lat: {
                            required: true
                        }
                    }, messages: {
                        lat: {
                            required: "Complete Address Is Required"
                        },
                        password: {
                            required: "",
                            minlength: "Your password must be at least 6 characters long"
                        },
                        first_name: {
                            required: ""
                        },
                        last_name: {
                            required: ""
                        },
                        email: {
                            required: ""
                        },
                        address: {
                            required: ""
                        },
                        city: {
                            required: ""
                        },
                        phone: {
                            required: ""
                        },
                        country: {
                            required: ""
                        },
                        confirm_password: {
                            required: "",
                            equalTo: "Please enter the same password as above"
                        }
                    }
                });
            });
            function showhidedrop(c_val) {
                if (c_val == 1) {
                    $('#union_drop_down').show();
                } else {
                    $('#union_drop_down').hide();
                }
            }
        </script>
    </body>
</html>