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
            <div class="container md-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <div class="box box-shadow nopadding clearfix">
                            <div class="modal-body">
                                <h4 class="font-weight-bold text_darkblue mb-4"> Booking Detail </h4>
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Name</strong>
                                        <p><?= $booking->artist->first_name . ' ' . $booking->artist->last_name ?></p>
                                    </div> <!-- col -->
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Email</strong>
                                        <p><?= $booking->artist->email ?></p>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Event Name</strong>
                                        <?php
                                        if($booking->gig_type == 'gig'){
                                            $event_name = $booking->gig->title;
                                        } else if($booking->gig_type == 'group'){
                                            $event_name = '<a href="'.asset('group_time_line/'.$booking->group->id).'">'.$booking->group->name.'</a>';
                                        } else if($booking->gig_type == 'teaching_studio'){
                                            $event_name = '<a href="'.asset('teaching_studio_time_line/'.$booking->studio->id).'">'.$booking->studio->name.'</a>';
                                        } else if($booking->gig_type == 'accompanist'){
                                            $event_name = '<a href="'.asset('group_time_line/'.$booking->accompanist->id).'">'.$booking->accompanist->name.'</a>';
                                        } else {
                                            $event_name = $booking->event_name;
                                        }
                                        ?>
                                        <p><?= $event_name ?></p>
                                    </div> <!-- col -->
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Booking Type</strong>
                                        <p><?=str_replace("_", " ", $booking->gig_type)?></p>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Location</strong>
                                        <p><?= $booking->location ?></p>
                                    </div> <!-- col -->
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Date</strong>
                                        <p><?= date('F d Y', strtotime($booking->booking_time)) ?></p>
                                    </div>
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Hours Offering</strong>
                                        <p><?= $booking->time ?> hours</p>
                                    </div> <!-- col -->
                                    <div class="col-sm-6 col-xs-12">
                                        <strong>Price Offering</strong>
                                        <p>$<?= $booking->price ?></p>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Description</strong>
                                        <p><?= $booking->booking_description ?></p>
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-12">
                                        <strong>Status</strong>
                                        <p><?= str_replace('_', ' ', $booking->status ) ?></p>
                                    </div> <!-- col -->

                                </div> <!-- row -->
                                <?php if ($booking->status == 'postponed') { ?>
                                    <div class="row">
                                        <div class="col-6">
                                            <strong>Time Available</strong>
                                            <p><?= $booking->availablity->available_from ?> - <?= $booking->availablity->available_to ?></p>
                                        </div> <!-- col -->
                                        <div class="col-6">
                                            <?php if($current_user_type == 'user') { ?>
                                            <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking_update"> <i class="s_icon ic_booking white"></i> Update Now</a>
                                            <?php } else { ?>                                            
                                            <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#update_availability_modal"> <i class="s_icon ic_booking white"></i> Update Now</a>
                                            <?php } ?>

                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                <?php } ?>
                            </div>
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <div class="modal fade" id="modal_eventbooking_update" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $book_now = '';
                        if (Auth::user()) {
                            if (!Auth::user()->stripe_id) {
                                $book_now = 1;
                                ?>
                                <h5 class="alert alert-info">Please Add Card To Book This Gig</h5>
                                <?php
                            }
                        } else {
                            $book_now = 1;
                            ?> 
                            <h5 class="alert alert-info">Please Login To Book This Gig</h5>
                        <?php } ?>
                        <h5 id="booking_error" class="alert alert-danger" style="display: none"></h5>
                        <div id="booking_success<?= $booking->id ?>" class="alert alert-success" style="display: none">


                        </div>
                        <form class="edit_user_form" method="post" action="<?= asset('add_booking') ?>">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First & Last Name </label>
                                        <input disabled="" type="text" placeholder="" class="form-control" value="<?= Auth::user()->first_name . ' ' . Auth::user()->last_name ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Your Email</label>
                                        <input disabled  type="email" placeholder="" class="form-control"  value="<?= Auth::user()->email ?>"/>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Gig Name</label>
                                        <input  disabled="" type="text" placeholder="" class="form-control" value="<?php if( $booking->gig){ echo $booking->gig->title; }else{ echo $booking->event_name; } ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Location</label>
                                        <input disabled type="text" placeholder="" class="form-control" value="<?= $booking->location ?>"/>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Date</label>
                                        <div class="d-flex">
                                            <input required id="booking_date<?= $booking->id ?>" type="text" placeholder="Date" class="form-control mr-2 date-picker" readonly value="<?= $booking_time ?>">
                                            <input required id="user_id<?= $booking->id ?>" type="hidden" value="<?= $booking->user_id ?>"> 
                                            <input required id="booking_id_<?= $booking->id ?>" type="hidden" value="<?= $booking->id ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Hours offering</label>
                                        <input disabled="" required id="booking_hours<?= $booking->id ?>" type="text" placeholder="0:00" class="form-control" value="<?= $booking->time ?>"/>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Price offering</label>
                                        <input disabled value="<?= $booking->price ?>" type="text" placeholder="$$$" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea required id="booking_description<?= $booking->id ?>" class="form-control h_140"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->

                            <div class="mt-2 text-center">
                                <button id="updatebooking" onclick="updateBooking('<?= $booking->id ?>')" type="button" class="btn btn-round btn_aqua btn-xl text-semibold "> Update Now </button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Booking modal -->
        <?php if($booking->availablity) { ?>
        <div class="modal fade" id="update_availability_modal" tabindex="-1" role="dialog" aria-labelledby="availability_modal" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Update Availability</h5>
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
                                            <input type="time" autocomplete="off" class="form-control" placeholder="0:00" value="<?=$available_from_time?>" />
                                        </div>
                                        <div class='col-sm-1'>
                                            <label class="mt-2"><strong>to</strong></label>
                                        </div>
                                        <div class='col-sm-5'>
                                            <input type="time" autocomplete="off" class="form-control" placeholder="0:00" value="<?=$available_to_time?>"/>
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
                                        <input readonly="" id="booking_date_from" type='text' class="form-control date-picker" value="<?=$available_from_date?>" placeholder="DD - MM - YYYY" />
                                    </div>
                                    <div class='col-sm-1'>
                                        <label class="mt-2"><strong>to</strong></label>
                                    </div>
                                    <div class='col-sm-5'>
                                        <input readonly="" id="booking_date_to" type='text' class="form-control date-picker" value="<?=$available_to_date?>" placeholder="DD - MM - YYYY" />
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div>
                    <div class="modal-footer justify-content-start pt-2">
                        <button onclick="addAvailalabilty(<?= $booking->id ?>)" type="button" class="btn btn-round btn-gradient btn-xl">Save</button>
                    </div>
                </div>
            </div>
        </div> <!-- modal -->   
        <?php } ?>

        <?php include resource_path('views/includes/footer.php'); ?>         
        <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
        <script>
            $('#booking_time_to').timepicker({
                timeFormat: 'H:i:s',
                interval: 60,
                startTime: '00:00',
                dropdown: false
            });
            $('#booking_time_from').timepicker({
                timeFormat: 'H:i:s',
                interval: 60,
                startTime: '00:00'
            });
            function updateBooking(booking_id) {
                $('#updatebooking').removeAttr('onclick');
                $('#booking_error').hide();
                booking_description = $('#booking_description' + booking_id).val();
                booking_hours = $('#booking_hours' + booking_id).val();
                booking_date = $('#booking_date' + booking_id).val();
                user_id = $('#user_id' + booking_id).val();
                if (!booking_date) {
                    return $('#booking_error').html('Date Is Required').show();
                }
                if (!booking_hours) {
                    return $('#booking_error').html('Hours ars Required').show();
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('update_booking'); ?>",
                    data: {user_id: user_id, booking_id: booking_id, booking_date: booking_date, booking_hours: booking_hours, booking_description: booking_description, "_token": '<?= csrf_token() ?>'},
                    success: function (response) {
                        socket.emit('notification_get', {
                            "user_id": user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' updated on your availabilty',
                            "url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "unique_text": response.notification.unique_text,
                        });

                        $('#booking_description' + booking_id).val('');
                        $('#booking_hours' + booking_id).val('');
                        $('#booking_date' + booking_id).val('');
                        $('#booking_price' + booking_id).val('');
                        $('#booking_success' + booking_id).html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>Booking Update Successfully').show();
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    }
                });

            }
        </script>
    </body>
</html>