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
                <div class="row">
                    <div class="col-lg-3 col-sm-12">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12 bg-white">
                        <div class="invitation_page">
                            <div class="invitation_image">
                                <img src="<?php echo asset('userassets/images/invite.png'); ?>" alt="Invite"/>
                            </div>
                            <div class="text">
                                <h3>Invite peoples to join this Great Commmunity!</h3>
                                <p>How do you talk to the people you know?<br/>
                                    Choose a service:</p>
                            </div>
                            <div class="social_invitations">
                                <?php
                                echo Share::page(asset('timeline'), null, [])
                                        ->facebook('')
                                        ->twitter('')
                                        ->whatsapp('');
                                ?>
                            </div>
                            <div class="invitation_form">
                                <!--<form>-->
                                    <input id="invitation_email" type="email" class="form-control" placeholder="Enter email to invite" />
                                    <button type="button" id="invitation_send" onclick="sendInvitation()" class="btn btn-round">Send Invitation</button>
                                <!--</form>-->
                            </div>
                        </div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page_timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>

        <script>
            function sendInvitation() {
                var email = $('#invitation_email').val();
                var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!filter.test(email)) {
                    $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Invalid email address').show().fadeOut(5000);

                } else {
                    $("#invitation_send").attr("disabled", true);
                    $.ajax({
                        url: '<?= asset('send_invititaion_mail') ?>',
                        type: 'GET',
                        data: {'email': email},
                        success: function (data) {
                            $("#invitation_send").attr("disabled", false);
                            if (data) {
                                $("#invitation_email").val('');
                                $('#showSuccess').html('Invitation Send successfuly!').fadeIn().fadeOut(5000);
                            } else {
                                $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>This user is already on app').show().fadeOut(5000);

                            }
                        }
                    });
                }
            }
        </script>
    </body>
</html>