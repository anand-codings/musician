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
        <div class="page_title_header" style="background-image: url('<?php echo asset("userassets/images/bg-img2.jpg") ?>')">
            <div class="container">
                <h1>Deposit Account Verification</h1>
                <span>Musician will Deposit your earning into your verified account. </span>
            </div>
        </div>

        <div class="container md-fluid-container mb-4">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <?php include resource_path('views/includes/sidebar.php'); ?>
                </div> <!-- col -->
                <div class="col-lg-9 col-md-12">
                    <div class="box shadow musician_register_form_wrapper">
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
                        <?php } if (Session::has('success')) {
                            ?>
                            <div class="alert alert-success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('success') ?>
                            </div>

                        <?php } else if (Session::has('info')) {
                            ?>
                            <div class="alert alert-info">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                <?php echo Session::get('info') ?>
                            </div>
                        <?php } if ($status == 'unverified') { ?>
                            <form id="validate-form" method="post" action="<?= asset('save_legal_details') ?>" enctype="multipart/form-data">
                                <?= csrf_field(); ?>
                                <div class="form_section">
                                    <h2 class="text-semibold text_maroon">Personal Information</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">First Name</label>
                                                <input required name="first_name" type="text" class="form-control" placeholder="" value="<?php echo old('firs_name'); ?>">
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Last Name</label>
                                                <input required name="last_name" type="text" class="form-control" placeholder="" value="<?php echo old('last_name'); ?>">
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Date of Birth</label>
                                                <input type="text" value="" name="dob" class="form-control date-picker-past" readonly>
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Identity Document</label>
                                                <input required name="legal_personal_id_image" type="file" class="form-control" placeholder="" value="<?php echo old('legal_personal_id_image'); ?>">
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="form_section">
                                    <h2 class="text-semibold text_maroon">Contact</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Address</label>
                                                <input name="address" autocomplete="off" id="autocomplete" type="text" class="form-control" placeholder="" value="<?php echo old('address'); ?>" required>
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">City</label>
                                                        <input name="city" autocomplete="off" id="locality" type="text" class="form-control" placeholder="" value="<?php echo old('city'); ?>" required>
                                                    </div>
                                                </div> <!-- col -->
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label class="font-weight-bold">State</label>
                                                        <input name="state" autocomplete="off" type="text" id="administrative_area_level_1" class="form-control" placeholder="" value="<?php echo old('state'); ?>" required>
                                                    </div>
                                                </div> <!-- col -->
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Postal Code</label>
                                                <input name="postal_code" id="postal_code" type="number" onkeypress="if (this.value.length == 5)
                                                                return false;" class="form-control" placeholder="" value="<?php echo old('postal_code'); ?>" required>
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="form_section">
                                    <h2 class="text-semibold text_maroon">Payment Detail</h2>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Personal ID / SSN Number</label>
                                                <input name="ssn" type="number" onkeypress="if (this.value.length == 9)
                                                                return false;" class="form-control" placeholder="" value="<?php echo old('ssn'); ?>" required>
                                            </div>
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">SSN Last 4 Digits </label>
                                                <input name="ssn_last_4" type="number" onkeypress="if (this.value.length == 4)
                                                                return false;" class="form-control" placeholder="" value="<?php echo old('ssn_last_4'); ?>" required>
                                            </div>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- section -->
                                <div class="form_section">
                                    <input type="submit" value="Submit"  class="btn btn-gradient btn-round text-semibold btn-xl"/>
                                </div> <!-- section -->
                            </form>
                            <?php
                        } if ($status == 'verified') {

                            $account_number = '';
                            $routing_number = '';
                            if (isset($bank_account->external_accounts->data[0])) {
                                $account_number = $bank_account->external_accounts->data[0]->last4;
                                $routing_number = $bank_account->external_accounts->data[0]->routing_number;
                            }
                            ?>
                            <form action="<?php echo asset('savebank'); ?>" method="POST" id="payment-form" class="form-horizontal edit_user_form"> 
                                <?= csrf_field(); ?>
                                <h5 class="bank-errors alert alert-danger" style="display: none"></h5>
                                <?php if ($routing_number) { ?>
                                    <h5 class="alert alert-info">Your account is approved</h5>

                                <?php } ?>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Routing Number</label>
                                            <input required name="routing_number" type="number" onkeypress="if (this.value.length == 9)
                                                            return false;" class="form-control routing-number" placeholder="" value="<?= $routing_number ?>">
                                        </div>
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Account Number</label>
                                            <input required name="account_number" type="number" onkeypress="if (this.value.length == 12)
                                                            return false;" class="form-control account-number" placeholder="" value="<?= $account_number ?>">
                                        </div>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <?php if (!$routing_number) { ?>
                                    <div class="form_section">
                                        <input type="submit" value="Submit"  class="btn btn-gradient btn-round text-semibold btn-xl"/>
                                    </div> <!-- section -->
                                <?php } ?>
                            </form>
                        <?php } if ($status == 'pending') { ?>
                            Please Wait we are verifing your data
                        <?php } ?>
                    </div> <!-- musician_register_form_wrapper -->            </div></div>
        </div> <!-- container -->


        <?php include resource_path('views/includes/footer.php'); ?>     
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>

        <script type="text/javascript">

                                                Stripe.setPublishableKey('pk_test_lXYBASNCh0Y40UJ5Q02U8og7');
                                                $(function () {
                                                    var $form = $('#payment-form');
                                                    $form.submit(function (event) {
                                                        // Disable the submit button to prevent repeated clicks:
                                                        $form.find('.submit').prop('disabled', true);
                                                        //                
                                                        // Request a token from Stripe:
                                                        Stripe.bankAccount.createToken({
                                                            country: 'US',
                                                            currency: 'USD',
                                                            routing_number: $('.routing-number').val(),
                                                            account_number: $('.account-number').val()
                                                        }, stripeResponseHandler);

                                                        // Prevent the form from being submitted:
                                                        return false;
                                                    });
                                                });
                                                function stripeResponseHandler(status, response) {

                                                    // Grab the form:
                                                    var $form = $('#payment-form');

                                                    if (response.error) { // Problem!

                                                        // Show the errors on the form:

                                                        $form.find('.bank-errors').show().text(response.error.message);
                                                        $form.find('button').prop('disabled', false); // Re-enable submission

                                                    } else { // Token created!
                                                        $form.find('.bank-errors').hide();
                                                        // Get the token ID:
                                                        var token = response.id;
                                                        // Insert the token into the form so it gets submitted to the server:
                                                        $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                                                        // Submit the form:
                                                        $form.get(0).submit();

                                                    }
                                                }
        </script>
    </body>
</html>
<style>
    input.error {
        border:solid 1px red !important;
    }
    select.error {
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
    /*            #musician_register label.error {
                    display: none !important;
                }*/
</style>
<script>

    jQuery.validator.addMethod("ssn", function (value, element) {
        return this.optional(element) || /^\d{3}-?\d{2}-?\d{4}$/.test(value);
    }, "Please enter a valid ssn number");

    jQuery.validator.addMethod("ssn_last_four", function (value, element) {
        return this.optional(element) || /^(?!0{4})\d{4}$/.test(value);
    }, "Please enter valid ssn last four");

    jQuery.validator.addMethod("postal_code", function (value, element) {
        return this.optional(element) || /^([0-9]{5}|[a-zA-Z][a-zA-Z ]{0,49})$/.test(value);
    }, "Please enter a valid postal code");

    $("#validate-form").validate({
        rules: {
            ssn: {
                number: true,
                ssn: true,
            },
            postal_code: {
                number: true,
                postal_code: true,
            },
            ssn_last_4: {
                number: true,
                ssn_last_four: true,
            },
        },
    });
    $("#payment-form").validate({});

</script>

<script>
    // This example displays an address form, using the autocomplete feature
    // of the Google Places API to help users fill in the information.

    // This example requires the Places library. Include the libraries=places
    // parameter when you first load the API. For example:
    // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

    var placeSearch, autocomplete;
    var componentForm = {
        locality: 'long_name',
        administrative_area_level_1: 'short_name',
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