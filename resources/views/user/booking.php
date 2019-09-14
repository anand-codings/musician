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
                    <div class="col-lg-3 col-md-3">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <div class="box box-shadow no_margin clearfix">
                            <div class="row d-flex mb-2 align-items-center">
                                <div class="col">
                                    <h4 class="font-weight-bold text_darkblue mb-0"> My Bookings </h4>
                                </div>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="standard-booking" role="tabpanel" aria-labelledby="standard-booking-tab">
                                    <table class="table table-hover table_booking table_attribute booking_table">
                                        <thead>
                                            <tr>
                                                <?php if ($current_user_type == 'user') { ?>
                                                    <th>Date</th>
                                                    <th>Professionals</th>
                                                    <!-- <th>Booking On</th>
                                                    <th>Event Name</th> -->
                                                    <th>Booking Type</th>
                                                    <th>Price</th>
                                                    <th>Status</th>
                                                    <th>Payment Request</th>
                                                    <!-- <th>Actions</th> -->
                                                <?php } else if ($current_user_type == 'artist') { ?>
                                                    <th>Date</th>
                                                    <th>Professionals</th>
                                                    <!-- <th>Booking On</th>
                                                    <th>Event Name</th> -->
                                                    <th>Booking Type</th>
                                                    <!-- <th>Email</th> -->
                                                    <!-- <th>Phone</th> -->
                                                    <th>Actions</th>
                                                <?php } ?>
                                            </tr>
                                        </thead>
                                        <tbody id="standrad_booking"></tbody>
                                    </table> <!-- table -->
                                    <div id="msg_standrad_booking"></div>
                                </div> <!-- tab 1 -->
                            </div> <!-- tabs -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <div class="modal fade" id="availability_modal" tabindex="-1" role="dialog" aria-labelledby="availability_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Availability</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body availability_popup">
                        <h5 style="display: none" class="alert alert-danger" id="booking_availabile_error"></h5>
                        <h5 style="display: none" class="alert alert-success" id="booking_availabile_success"></h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><strong>Operation Hours</strong></label>
                                    <div class="row">
                                        <div class='col-sm-5'>
                                            <input id="booking_time_from" required="" type="time" autocomplete="off" class="form-control" placeholder="0:00" />
                                        </div>
                                        <div class='col-sm-1'>
                                            <label class="mt-2"><strong>to</strong></label>
                                        </div>
                                        <div class='col-sm-5'>
                                            <input  id="booking_time_to" required="" type="time" autocomplete="off" class="form-control" placeholder="0:00" />
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-12">
                                <label><strong>Availability Dates</strong></label>
                            </div> <!-- col -->
                            <div class="col-12">
                                <div class="row">
                                    <div class='col-sm-5'>
                                        <input readonly="" id="booking_date_from" type='text' class="form-control date-picker" placeholder="DD - MM - YYYY" />
                                    </div>
                                    <div class='col-sm-1'>
                                        <label class="mt-2"><strong>to</strong></label>
                                    </div>
                                    <div class='col-sm-5'>
                                        <input readonly="" id="booking_date_to" type='text' class="form-control date-picker" placeholder="DD - MM - YYYY" />
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div>
                    <div class="modal-footer justify-content-start pt-2">
                        <button id="availability_modal_btn" type="button" class="btn btn-round btn-gradient btn-xl">Save</button>
                    </div>
                </div>
            </div>
        </div> <!-- modal -->    
        <!-- Accept Model-->
        <div class="modal fade" id="accept" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Accept Booking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <h5 style="display: none" class="alert alert-danger" id="booking_accept_error"></h5>
                            <h5 style="display: none" class="alert alert-success" id="booking_accept_success"></h5>
                            <div>
                                <label class="font-weight-bold" id="bookings_accept_msg">Are you sure you want to Accept this Booking?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button id="accept_booking" type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Accept modal -->
        <!-- Decline Model-->
        <div class="modal fade" id="decline" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Decline</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <h5 style="display: none" class="alert alert-success" id="booking_decline_success"></h5>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to Decline this booking?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button id="decline_booking" type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div>
            </div>
        </div> 
        <!-- Decline modal END --> 

        <!-- Payment Request Model-->
        <div class="modal fade" id="request_payment" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <h5 style="display: none" class="alert alert-success" id="booking_request_payment_success"></h5>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to Request Payment For this booking?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button id="request_payment_btn" type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div>
            </div>
        </div> 
        <!-- Payment Request Model --> 

        <!-- Payment Request Admin Model-->
        <div class="modal fade" id="submit_dispute_reason" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Submit Dispute Reason</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    
                    <div class="modal-body availability_popup">
                        <h5 style="display: none" class="alert alert-success" id="dispute_reason_success"></h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><strong>Reason</strong></label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <textarea class="form-control h-100" id="dispute_reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Any evidence that you want to submit?</strong><br>(multiple files can be uploaded in the form of images)</label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <input type="file" multiple="" id="dispute_evidence_files">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div>
                    <div class="modal-footer justify-content-start pt-2">
                        <button id="submit_dispute_reason_btn" type="button" class="btn btn-round btn-gradient btn-xl">Submit</button>
                    </div>
                    
                </div>
            </div>
        </div> 
        <!-- Payment Request Admin Model --> 
        <!-- Payment Request Admin Model-->
        <div class="modal fade" id="request_admin" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Request Payment Admin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <h5 style="display: none" class="alert alert-success" id="booking_request_payment_admin_success"></h5>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to Request Admin For Payment For this booking?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button id="request_admin_btn" type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div>
            </div>
        </div> 
        <!-- Payment Request Admin Model --> 
        <!--Approve Payment--> 
        <div class="modal fade" id="approve_payment" tabindex="-1" role="dialog" aria-labelledby="availability_modal" aria-hidden="true">
            <div class="modal-dialog  modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Approve Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body availability_popup">
                        <h5 style="display: none" class="alert alert-success" id="booking_approve_success"></h5>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><strong>Tip Amount in USD</strong></label>
                                    <input id="tip_amount" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label><strong>Notes</strong></label>
                                    <textarea id="approve_notes" class="form-control h_140"></textarea>
                                </div>
                                <div class="form-group">
                                    <button id="approve_payment_btn" type="button" class="btn btn-round btn-gradient btn-lg">Approve Payment</button>
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div>
                </div>
            </div>
        </div> <!-- modal -->  
        <!--Approve Payment-->
        <!--Reject Payment--> 
        <div class="modal fade" id="reject_payment" tabindex="-1" role="dialog" aria-labelledby="availability_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reject Payment</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body availability_popup">
                        <h5 style="display: none" class="alert alert-success" id="booking_reject_success"></h5>
                        <div class="row">
                            <div class="col-12">
                                <!-- <div class="form-group">
                                    <label><strong>Notes</strong></label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <textarea class="form-control h-100" id="reject_notes"></textarea>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="form-group">
                                    <label><strong>Rejection Reason</strong></label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <textarea class="form-control h-100" id="reject_reason"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Any evidence that you want to submit?</strong><br>(multiple files can be uploaded in the form of images)</label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <input type="file" multiple="" id="reject_evidence_files">
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div>
                    <div class="modal-footer justify-content-start pt-2">
                        <button id="reject_payment_btn" type="button" class="btn btn-round btn-gradient btn-xl">Reject Payment</button>
                    </div>
                </div>
            </div>
        </div> <!-- modal -->  
        <div class="modal fade" id="partial_refund_modal" tabindex="-1" role="dialog" aria-labelledby="availability_modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Request for partial refund</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body availability_popup">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label><strong>Note:</strong><label> If you request for partial refund then its in musician hands that if he accepts your refund request or deduct whole amount.</label></label>
                                </div>
                                <div class="form-group">
                                    <label><strong>Percentage</strong></label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <input type="number" class="form-control" id="partial_refund_percentage" required=""/>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><strong>Reason</strong></label>
                                    <div class="row">
                                        <div class='col-sm-12'>
                                            <textarea class="form-control h-100" id="partial_refund_reason" required=""></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div>
                    <div class="modal-footer justify-content-start pt-2">
                        <button id="partial_refund_modal_btn" type="button" class="btn btn-round btn-gradient btn-xl">Submit</button>
                    </div>
                </div>
            </div>
        </div> <!-- modal -->  
        <!--Approve Payment-->
        <?php include resource_path('views/includes/footer.php'); ?>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
        <script>
            
            $("#partial_refund_percentage").focusout(function() {
                if($(this).val() > 100){
                    $(this).val(100)
                }
            })

//                                                $(document).ready(function () {
//                                                    $('#booking_time_to').timepicker({
//                                                        timeFormat: 'H:i:s',
//                                                        interval: 60,
//                                                        startTime: '00:00',
//                                                        dropdown: false
//                                                    });
//                                                    $('#booking_time_from').timepicker({
//                                                        timeFormat: 'H:i:s',
//                                                        interval: 60,
//                                                        startTime: '00:00'
//                                                    });
//                                                });

            var ajaxcall = 1;
            var isScroll = 0;
            var type = 'standard';
            var container = 'standrad_booking';
            var win = $(window);
            var count = 0;
            appended_post_count = 0;

            $(document).ready(function () {
                var skip = 0;
                var take = 12;
                load_actions(skip, take, type, container, isScroll);

                win.on('scroll', function () {
                    var docheight = parseInt($(document).height());
                    var winheight = parseInt(win.height());
                    var differnce = (docheight - winheight) - win.scrollTop();
                    isScroll = 1;
                    if (differnce < 100) {
                        if (ajaxcall === 1) {
                            ajaxcall = 0;
                            var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                            load_actions(skip, 12, type, container, isScroll);
                        }
                    }
                });

            });

            function load_actions(skip, take, type, container, isScroll) {
                $('#loader').show();
                ajaxcall = 0;
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('fetch_bookings/'); ?>",
                    data: {skip: skip, take: take, type: type},
                    beforeSend: function () {
                        $('.loader_center').remove();
                        $('#loader').show();
                    },
                    success: function (response) {
                        if (response) {
                            var a = parseInt(1);
                            var b = parseInt(count);
                            count = b + a;
                            if (isScroll) {
                                $('#' + container).append(response);
                            } else {
                                $('#' + container).html(response);
                            }
                            $('#loader').hide();
                            ajaxcall = 1;
                        } else {
                            if ($('#' + container).is(':empty')) {
                                $('#loader').hide();
                                noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                                $('#msg_' + container).html(noposts);
                            } else {
                                ajaxcall = 0;
                                $('#loader').hide();
                                noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                                $('#msg_' + container).html(noposts);
                            }
                        }
                    }
                });
            }

            function change_tab(tab_id, show_type) {
                $('#' + tab_id).html('');
                type = show_type;
                container = tab_id;
                $('#' + container).html('');
                load_actions(0, 12, type, container, isScroll);
            }
            function showAddAvailability(booking_id) {
                $('#availability_modal').modal('show');
                $('#availability_modal_btn').attr('onclick', 'addAvailalabilty(' + booking_id + ')');
            }
            function accept(booking_id) {
                $('#bookings_accept_msg').html('Are you sure you want to accept this booking ?');
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('check_bookings_on_the_same_day/'); ?>",
                    data: {booking_id: booking_id, "_token": '<?= csrf_token() ?>'},
                    success: function (response) {
                        if (response.success) {
                            $('#bookings_accept_msg').html('You already have bookings on this day (<a href="' + response.href + '">' + response.booking_time + '</a>) !<br>Are you sure you want to accept this booking?');
                        }
                    }
                });
                $('#accept').modal('show');
                $('#accept_booking').attr('onclick', 'acceptbooking(' + booking_id + ')');
            }
            function decline(booking_id) {
                $('#decline').modal('show');
                $('#decline_booking').attr('onclick', 'declineBooking(' + booking_id + ')');
            }
            function requestPayment(booking_id) {
                $('#request_payment').modal('show');
                $('#request_payment_btn').attr('onclick', 'requestPaymentSend(' + booking_id + ')');
            }
            function openDisputeModal(booking_id) {
                $('#submit_dispute_reason').modal('show');
                $('#submit_dispute_reason_btn').attr('onclick', 'submitDisputeReason(' + booking_id + ')');
            }
            function requestAdmin(booking_id) {
                $('#request_admin').modal('show');
                $('#request_admin_btn').attr('onclick', 'requestPaymentAdmin(' + booking_id + ')');
            }
            function approvePayment(booking_id) {
                $('#approve_payment').modal('show');
                $('#approve_payment_btn').attr('onclick', 'approveBookingPayment(' + booking_id + ')');
            }
            function rejectPayment(booking_id) {
                $('#reject_payment').modal('show');
                $('#reject_payment_btn').attr('onclick', 'rejectBookingPayment(' + booking_id + ')');
            }
            function openPartialRefundModal(booking_id) {
                $('#partial_refund_modal').modal('show');
                $('#partial_refund_modal_btn').attr('onclick', 'requestPartialRefund(' + booking_id + ')');
            }
        </script>
    </body>
</html>