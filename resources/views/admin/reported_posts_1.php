<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Reported Posts
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Reported Posts</h3>
                                </div>
                                <div class="message_outer">
                                    <div class="col-md-12">
                                        <div class="send-messages-editor">
                                            <div class="chat-user">
                                                <a href="#" class="chat_user-img pull-left">
                                                    <img src="images/users/img-4.png" class="img-circle" title="user name" alt="">
                                                </a>
                                                <div class="message_box">
                                                    <h6 id="message_error" class="alert alert-danger" style="display: none">Please select user or check all</h6>
                                                    <h6 id="message_success" class="alert alert-success" style="display: none">Message will be delivered shortly</h6>
                                                    <form enctype="multipart/form-data" action="<?php echo asset('send_user_message'); ?>" method="post" >
                                                        <input type="hidden" id="user_id" name="user_id" >
                                                        <input type="hidden" value="<?php echo csrf_token() ?>" name="_token">
                                                        <div class="panel">
                                                            <div class="message_header">
                                                                <select id="users" data-placeholder="Choose a User..." class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                                    <?php foreach ($users as $user) { ?>
                                                                        <option value="<?= $user->id ?>"><?= $user->first_name . ' ' . $user->last_name ?></option>
                                                                    <?php } ?>
                                                                </select> &nbsp; | &nbsp;
                                                                <span><input id="allusers" name="allusers" type="checkbox">Send To All </span>
                                                            </div>
                                                            <p></p>
                                                            <div class="message_body">
                                                                <textarea id="message_to_send" name="message" class="form-control" placeholder="Some Message here . . . " cols="4" rows="3"></textarea>
                                                            </div>
                                                            <p></p>
                                                            <div class="message_footer">
                                                                <div>

                                                                    <input type="button" value="Send" class="msg_send_btn btn btn-primary pull-right" onclick="sendMail()">

                                                                </div>
                                                                <div class="clear"></div>
                                                            </div>
                                                        </div></form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php if (Session::has('success')) { ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('success') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (Session::has('error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('error') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($errors->any()) { ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach ($errors->all() as $error) { ?>
                                                    <li><?= $error ?></li>
                                                <?php }
                                                ?>
                                            </ul>
                                        </div>
                                    <?php } ?>

                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Post By</th>
                                                <th>Post</th>
                                                <th>Reported By</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                                <th>Reply</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($reported_posts as $post_report) { ?>
                                                <tr>
                                                    <td><?php
                                                        echo $i;
                                                        $i++;
                                                        ?></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $post_report->post->user->id . '?segment=' . $segment) ?>"><?= $post_report->post->user->first_name . ' ' . $post_report->post->user->last_name ?></a></td>
                                                    <td class="table_img"> 
                                                        <?php if ($post_report->post->getFile) { ?>
                                                            <?php if ($post_report->post->type == 'image') { ?>
                                                                <img src="<?= $post_report->post->getFile->file ?>">
                                                            <?php } else if ($post_report->post->type == 'video') { ?>
                                                                <video width="160" height="" controls>
                                                                    <source src="<?= $post_report->post->getFile->file ?>" type="video/mp4">
                                                                </video>
                                                            <?php } else if ($post_report->post->type == 'audio') { ?>
                                                                <audio controls>
                                                                    <source src="<?php echo asset($post_report->post->getFile->file) ?>" type="audio/mpeg">
                                                                    Your browser does not support the audio tag.
                                                                </audio>
                                                            <?php } ?>
                                                        <?php } else { ?>
                                                            N/A
                                                        <?php } ?>
                                                        <?php
                                                        if (isset($post_report->post->text)) {
                                                            echo $post_report->post->text;
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $post_report->user_id . '?segment=' . $segment) ?>"><?= $post_report->user->first_name . ' ' . $post_report->user->last_name ?></a></td>
                                                    <td><?php
                                                        if (isset($post_report->reason)) {
                                                            echo $post_report->reason;
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="deletePost(<?= $post_report->post_id ?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a>
                                                        <a href="javascript:void(0)"  onclick="deleteReport(<?= $post_report->id ?>)" class="text-success "><i class="fa fa-flag fa-fw"></i></a>
                                                    </td>
                                                    <td>
                                                        <input data-status="" type="button" class="btn btn-primary reply" id="m_reply" data-userid="<?= $post_report->user->id ?>"
                                                               data-toggle="modal" data-target="#modal-default" value="Reply" data-id="">
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                </section>
            </div>
            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content" id="test">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Reply</h4>
                        </div>
                        <div class="modal-body">

                        </div>

                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
<script>
    function deletePost(post_id) {
        if (confirm('Are you sure that you want to delete this post?')) {
            $.ajax({
                url: base_url + 'delete_post_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'post_id': post_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'reported_posts';
                }
            });
        }
    }


    function deleteReport(report_id) {
        if (confirm('Are you sure you want to delete this report?')) {
            $.ajax({
                url: base_url + 'delete_report_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'report_id': report_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'reported_posts';
                }
            });
        }
    }
    function sendMail() {
        message = $('#message_to_send').val();
        send_to_all = false;
        if ($('#allusers').is(":checked")) {
            send_to_all = true;
        }
        users = $('#users').val();
        if (!message) {
            $('#message_to_send').css('border', '1px solid red');
        } else {
            if (!send_to_all && users.length == 0) {
                $('#message_to_send').css('border', '1px solid gray');
                $('#message_error').show();
            } else {
                $('#message_to_send').css('border', '1px solid gray');
                $('#message_error').hide();
            }
            $("#message_success").show().fadeOut(5000);
            $('#message_to_send').val('');
            $('#allusers').prop('checked', false);
            $('.chosen-select').val('').trigger("chosen:updated");
            $.ajax({
                url: base_url + 'send_message_all',
                type: 'POST',
                data: {'users': users, text_message: message, send_to_all: send_to_all},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
            });
        }
    }

    $(document).ready(function () {
        $('body').on('click', '.reply', function () {
            var id, email, dir = "";
            id = $(this).data('userid');
            console.log(id);
            dir = "<?= asset('public/images') . '/'; ?>";
            // console.log(status+" on click .identity");
            $('.modal-body').empty();
            $('#test').find('.modal-body').append('<div class="col-sm-12">\
                      <div class="form-group">\
                        <textarea class="form-control" id="message' + id + '"></textarea>\
                        </div>\
                    </div>\
                    <div class="modal-footer">\
                      <button type="button" class="btn btn-default pull-left close_modal" data-dismiss="modal">Close</button>\
                      <button type="button" class="btn btn-primary send_email" data-id="' + id + '">Send Reply</button>\
                    </div>\
                    ');
        });
        $('body').on('click', '.send_email', function () {
            var id, message = "";
            id = $(this).data('id');
            message = $('#message' + id).val();
            if(!message){
                $('#message' + id).css('border', '1px solid red');
            }else{
                $('#message' + id).css('border', '1px solid gray');
                $('#message' + id).val('');
            $(".close_modal").click();
            $("#message_success").show().fadeOut(5000);
            //console.log(val);
            $.ajax({
                url: "<?= asset('reported_post_mail'); ?>",
                data: {
                    '_token': '<?= csrf_token(); ?>',
                    user_id: id,
                    message: message,
                },
                type: "POST",
                success: function (response) {
                }
            });
            }
        });
        
    });
</script>
