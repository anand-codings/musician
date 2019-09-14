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
                                        <h3>Reset Password?</h3>
                                        <p>Enter your email to recover password</p>
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
                                <?php } 
                                if (Session::has('error')) {
                                ?>
                                <div class="alert alert-danger">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                    <?php echo Session::get('error') ?>
                                </div>
                                <?php } ?>
                                <form method="post" action="<?= asset('reset_password')?>" id="resetpasswordform">
                                    <input type="hidden" name="_token" value="<?= csrf_token()?>">
                                    <input type="hidden" name="token" value="<?= $token ?>">
                                    <div class="form-group">                                    
                                        <input id="password" name="password" type="password" class="form-control" placeholder="New Password">
                                    </div>
                                    <div class="form-group">                                    
                                        <input  name="password_confirmation" type="password" class="form-control" placeholder="Confirm Password">
                                    </div>
                                    <div class="form-group">
                                        <input type="submit" value='Reset' class='btn btn-round btn-red btn-submit' />
                                    </div>
                                    <div class="spacereset_password"></div>
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
            #resetpasswordform checkbox.error {
                background-color: red;
            }
            #resetpasswordform label.error {
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
       <?php include resource_path('views/includes/footer.php'); ?>
        <script> 
            $("#resetpasswordform").validate({
                    rules: {
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
                        password_confirmation: {
                            required: "",
                            equalTo: "Please enter the same password as above."
                        }
                    }
                });
                </script>
    </body>
</html>