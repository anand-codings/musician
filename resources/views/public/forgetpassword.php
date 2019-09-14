<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body class="pt-0">
        <div class="loginpage">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="login_box">
                            <div class="l_l_side">
                                <div>
                                    <h3>Are you Musician?</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. </p>
                                    <a href="<?php echo asset('musician-register'); ?>" class="btn btn-round btn-white">Register HERE</a>
                                </div>
                            </div>
                            <div class="l_r_side">
                                <div class="login_title">
                                    <div>
                                        <h3>Forgot Password?</h3>
                                        <p>Enter your email to recover password</p>
                                    </div>
                                </div>
                                <?php
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
                                <form class="edit_user_form" method="post" action="<?= asset('forgetpassword') ?>" id="forgetemailform">
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <div class="form-group">                                    
                                        <input type="email" required class="form-control" name="email" value="<?php echo old('email'); ?>"placeholder="Email">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value='Reset' class='btn btn-round btn-red btn-submit' />
                                    </div>
                                    <div class="spaceforget_password"></div>
                                    <div class="form-group">
                                        <div class="signup">Already member? <a href="<?php echo asset('login'); ?>">Sign In</a></div>
                                    </div>
                                </form>
                            </div>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            #forgetemailform label.error {

                width: auto;
                display: none !important;
                color:red;
                font-size: 16px;
                float:right;
            }

        </style>
        <?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>