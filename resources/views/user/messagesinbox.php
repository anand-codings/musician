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
        <div class="page_message">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <div class="box box-shadow no_margin clearfix">
                            <h4 class="font-weight-bold text_darkblue"> Inbox - <span><?= $chats->count() ?></span> </h4>
                            <table class="table table-hover table_messages">
                                <?php
                                foreach ($chats as $chat) {
                                    $other_user = $chat->receiver;
                                    if ($chat->sender_id != $current_id) {
                                        $other_user = $chat->sender;
                                    }
                                    $other_image = getUserImage($other_user->photo, $other_user->social_photo, $other_user->gender);
                                    ?>
                                    <tr id="chat_listing_<?= $chat->id ?>">
                                        <td class="message_info">
                                            <a href="<?= asset('/get_chat_detail/' . $other_user->id) ?>">                                            
                                                <div class="media align-items-center">
                                                    <span class="bg_image_round  mr-2 w-43" style="background-image: url(<?php echo $other_image ?>);"></span>
                                                    <div class="media-body line-height-13">
                                                        <span class="text_darkblue font-16 text_darkblue font-weight-bold"><?= $other_user->first_name . ' ' . $other_user->last_name ?></span>
                                                        <div class="text_grey font-14"><?= timeago($chat->created_at) ?></div>
                                                    </div>
                                                </div>
                                            </a>
                                        </td> <!-- td -->
                                        <td class="message_txt">
                                            <a href="<?= asset('/get_chat_detail/' . $other_user->id) ?>">
                                                <?php 
                                                 $length= strlen($chat->lastMessage->message);
                                                        $add_dot ='';if($length > 65){
                                                            $add_dot='...';
                                                        }
                                               echo substr($chat->lastMessage->message, 0,65).$add_dot;  ?>
                                            </a>
                                        </td>
                                        <td width="73px">
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#chat_delete_<?= $chat->id ?>" class="text-black msg_delete_btn"><i class="fas fa-trash"></i> Delete </a>
                                        </td> <!-- td -->
                                    </tr> <!-- tr -->

                                    <!-- Delete Model-->
                                    <div class="modal fade" id="chat_delete_<?= $chat->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <form>
                                                        <div>
                                                            <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                                        </div>
                                                        <div class="mt-3 text-center">
                                                            <button onclick="deleteChat('<?= $chat->id ?>')" type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                                            <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                                        </div>
                                                    </form>
                                                </div> <!-- modal body -->
                                            </div>
                                        </div>
                                    </div> <!-- Delete modal -->
                                    <!-- Delete modal END -->   
                                <?php } ?>
                            </table> <!-- table -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>         
        <script>
            function deleteChat(chat_id) {
                $('#chat_delete_' + chat_id).modal('hide');
                $('#chat_listing_' + chat_id).remove();
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('delete_chat'); ?>",
                    data: {chat_id: chat_id, "_token": '<?= csrf_token() ?>'},
                    success: function (response) {
                        if (response.message == 'success') {
                            window.location.reload();
                        } else {
                            $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                        }
                    }
                });
            }
        </script>
    </body>
</html>