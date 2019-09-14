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
                        Booking & Payments
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
                                    <h3 class="box-title">Booking & Payments</h3>
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
                                                <th>Gig</th>
                                                <th>Event Service</th>
                                                <th>Artist</th>
                                                <th>Booked By</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th>Notes</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($bookings as $booking) { ?>
                                                <tr>
                                                    <td><?php
                                                        echo $i;
                                                        $i++;
                                                        ?></td>   
                                                    <td><?php if (isset($booking->gig)) { ?><a href="<?= asset('event_detail_admin/' . $booking->gig_id . '?segment=' . $segment) ?>"><?= $booking->gig->title; ?></a><?php } else { ?> N/A <?php } ?></td>
                                                    <td><?php if ($booking->group) { ?><a href="<?= asset('group_detail_admin/' . $booking->group_id) ?>"><?= $booking->group->name ?></a><?php
                                                        } else {
                                                            echo 'N/A'
                                                            ?><?php } ?></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $booking->user_id . '?segment=' . $segment) ?>"><?= $booking->artist->first_name . ' ' . $booking->artist->last_name ?></a></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $booking->booked_by . '?segment=' . $segment) ?>"><?= $booking->user->first_name . ' ' . $booking->user->last_name ?></a></td>
                                                    <td><?= $booking->gig_type ?></td>
                                                    <td>
                                                        <?php
                                                        $status = str_replace('_', ' ', $booking->status);
                                                        if ($status == 'pending')
                                                            echo 'Pending from musician side';
                                                        else if ($status == 'cancelled')
                                                            echo 'Cancelled due to stripe error';
                                                        else if ($status == 'approved')
                                                            echo 'Accepted by musician';
                                                        else if ($status == 'rejected')
                                                            echo 'Rejected by musician';
                                                        else if ($status == 'postponed')
                                                            echo 'Postponed by musician';
                                                        else if ($status == 'payment requested')
                                                            echo 'Musician requested user for payment';
                                                        else if ($status == 'payment requested')
                                                            echo 'Musician requested user for payment';
                                                        else if ($status == 'payment approved')
                                                            echo 'User approved musician\'s request for payment';
                                                        else if ($status == 'payment rejected')
                                                            echo 'User rejected musician\'s request for payment';
                                                        else if ($status == 'payment delivered')
                                                            echo 'Admin delivered booking payment to musician';
                                                        else if ($status == 'admin requested')
                                                            echo 'Musician requested admin for payment release after user rejected the payment request';
                                                        else if ($status == 'postponed updated')
                                                            echo 'User updated the availability';
                                                        else if ($status == 'admin rejected')
                                                            echo 'Admin refunded the payment to user';
                                                        else if ($status == 'disputed') {
                                                            if (date('Y-m-d h:i:s', time()) < date('Y-m-d h:i:s', strtotime($booking->dispute_start_time_utc . ' + 2 days'))) {
                                                                if ($booking->is_user_submitted_evidence && $booking->is_user_submitted_evidence) {
                                                                    echo 'Disputed and waiting for admin to react on this dispute';
                                                                } else {
                                                                    echo 'Disputed and waiting for both parties to submit evidence';
                                                                }
                                                            } else {
                                                                echo 'Disputed and waiting for admin to react on this dispute';
                                                            }
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $booking->notes ?></td>
                                                    <td>
                                                        <?php if ($booking->status == 'payment_approved') { ?>
                                                            <button type="button" class="btn btn-success" onclick="action(<?= $booking->id ?>, 'release')">Release Payment</button>
                                                        <?php } else if ($booking->status == 'payment_refunded') { ?>
                                                            <button type="button" class="btn btn-warning">Payment Refunded</button>
                                                        <?php } else if ($booking->status == 'admin_requested') { ?>
                                                            <button type="button" class="btn btn-success" onclick="action(<?= $booking->id ?>, 'release')">Release Payment</button>
                                                            <button type="button" class="btn btn-danger" onclick="action(<?= $booking->id ?>, 'reject')">Reject Payment</button>
                                                        <?php } else if ($booking->status == 'disputed') { ?>
                                                            <?php if ( (date('Y-m-d h:i:s', time()) > date('Y-m-d h:i:s', strtotime($booking->dispute_start_time_utc . ' + 2 days'))) || ($booking->is_user_submitted_evidence && $booking->is_user_submitted_evidence) ) { ?> 
                                                                <a data-target="#dispute_detail_modal<?= $booking->id ?>" data-toggle="modal" href="javascript:void(0)" class="act_accept text_purple"></i> Dispute Detail</a>
                                                                <div class="modal fade" id="dispute_detail_modal<?= $booking->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title">Dispute Detail</h5>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i class="fas fa-times-circle"></i>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <?php foreach ($booking->disputeHistory as $dispute) { ?>
                                                                                    <div>
                                                                                        <strong><?= $dispute->user->first_name . ' ' . $dispute->user->last_name ?>:</strong>
                                                                                        <span><?= $dispute->reason ?></span><br>
                                                                                        <strong>Evidences:</strong>
                                                                                        <?php foreach ($dispute->disputeEvidence as $evidence) { ?>
                                                                                            <img src="<?= asset('public/images/' . $evidence->file_path) ?>" style="width: 100%">
                                                                                        <?php } ?>
                                                                                    </div><br><br>
                                                                                <?php } ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <button type="button" class="btn btn-default" onclick="action(<?= $booking->id ?>, 'request_more_dispute_evidence')">Request for more dispute evidence</button>
                                                                <button type="button" class="btn btn-success" onclick="action(<?= $booking->id ?>, 'release')">Release Payment</button>
                                                                <button type="button" class="btn btn-danger" onclick="action(<?= $booking->id ?>, 'reject')">Reject Payment</button>
                                                            <?php } ?> 
                                                        <?php } ?>
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

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
<script>
    function action(booking_id, action) {
        console.log(booking_id);
        check = false;
        if (action == 'release') {
            confirm('Are you sure that you want to release this payment?');
            check = true;
        } else if (action == 'reject') {
            confirm('Are you sure that you want to reject this payment?');
            check = true;
        } else if (action == 'request_more_dispute_evidence') {
            confirm('Are you sure that you want to request for more evidence for this dispute?');
            check = true;
        }
        if (check) {
            $.ajax({
                url: base_url + 'payment_action_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'booking_id': booking_id, 'action': action},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (response) {
//                    notification for requester
                    if (response.success) {
                        socket.emit('notification_get', {
                            "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "user_id": response.notification_for_requester.on_user,
                            "text": response.notification_for_requester.notification_text,
                            "unique_text": response.notification_for_requester.unique_text,
                            "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                            "from_admin": 'yes'
                        });
                        //                    notification for responder
                        socket.emit('notification_get', {
                            "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "user_id": response.notification_for_responder.on_user,
                            "text": response.notification_for_responder.notification_text,
                            "unique_text": response.notification_for_responder.unique_text,
                            "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                            "from_admin": 'yes'
                        });
                    }
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                }
            });
        }
    }
</script>
