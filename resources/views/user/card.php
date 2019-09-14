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
                        <?php } ?>
                        <form class="edit_user_form" id="payment-form" method="post" action="<?= asset('save_card') ?>" enctype="multipart/form-data">
                            <?= csrf_field(); ?>
                            <h5 class="payment-errors alert alert-danger" style="display: none"></h5>
                            <div class="form_section">
                                <h2 class="text-semibold text_maroon">Card Information</h2>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Card Number</label>
                                            <input  required size="16" pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 16)
                                                        return false;
                                                    "name="number" data-stripe="number" type="number" class="form-control" placeholder="" value="<?= $current_user->card_last_four ?>" required="">
                                        </div>
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Email</label>
                                            <input required name="email" type="email" class="form-control" placeholder="" value="" required >
                                        </div>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Expiration (MM/YYYY)</label>
                                            <div class="d-flex">
                                                <div class="flex-grow-1 mr-2">
                                                    <input class="form-control" required="" type="number"  name="exp_month" data-stripe="exp-month"  size="2" pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 2)
                                                                return false;" value="<?= $current_user->exp_month ?>">
                                                </div>
                                                <div class="flex-grow-1 mr-3">
                                                    <input type="number" class="form-control" placeholder="" required="" data-stripe="exp-year" name="exp_year" size="04" pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 4)
                                                                return false;" value="<?= $current_user->exp_year ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Cvc</label>
                                            <input size="4" pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 4)
                                                        return false;" data-stripe="cvc" name="cvc" type="number" class="form-control" placeholder="" value="" required>
                                        </div>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                            </div>
                            <div class="form_section">
                                <input type="submit" value="Submit"  class="btn btn-gradient btn-round text-semibold btn-xl"/>
                            </div> <!-- section -->
                        </form>

                    </div> <!-- musician_register_form_wrapper -->            </div></div>
        </div> <!-- container -->




        <?php include resource_path('views/includes/footer.php'); ?>
        <script type="text/javascript" src="https://js.stripe.com/v2/"></script>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            #payment-form label.error {

                width: auto;
                display: none !important;
                color:red;
                font-size: 16px;
                float:right;
            }

        </style>
        <script type="text/javascript">
                                                // This identifies your website in the createToken call below
                                                Stripe.setPublishableKey('pk_test_lXYBASNCh0Y40UJ5Q02U8og7');
                                                // ...
                                                jQuery(function ($) {
                                                    $('#payment-form').submit(function (event) {
                                                        var $form = $(this);

                                                        // Disable the submit button to prevent repeated clicks
                                                        $form.find('button').prop('disabled', true);

                                                        Stripe.card.createToken($form, stripeResponseHandler);

                                                        // Prevent the form from submitting with the default action
                                                        return false;
                                                    });
                                                });
                                                function stripeResponseHandler(status, response) {
                                                    var $form = $('#payment-form');

                                                    if (response.error) {
                                                        // Show the errors on the form
                                                        $form.find('.payment-errors').show().text(response.error.message);
                                                        $form.find('button').prop('disabled', false);
                                                    } else {
                                                        // response contains id and card, which contains additional card details
                                                        var token = response.id;
//            console.log(response);
//            alert(response)
                                                        // Insert the token into the form so it gets submitted to the server
                                                        $form.append($('<input type="hidden" name="stripeToken" />').val(token));

                                                        // and submit
                                                        $form.get(0).submit();
                                                    }
                                                }


        </script>
    </body>
</html>