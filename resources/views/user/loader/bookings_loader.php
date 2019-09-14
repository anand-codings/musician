<?php foreach ($bookings as $booking) { ?>                                 
    <tr>
        <td class="booking_date booking_date_style" data-header="Booking On">
            <?php 
               if($booking->booking_time) { ?>
            <span>
                <?php 
                $date = date('d', strtotime($booking->booking_time));
                echo $date;
                ?>
            </span>
                <?php 
                $month = date('M', strtotime($booking->booking_time));                
                $year = date('Y', strtotime($booking->booking_time));

                echo $month .', ',$year;
                } ?>
            <!-- <span class="text_darkblue"><?= date('F j, Y', strtotime($booking->booking_time)) ?></span> -->
        </td>
        <td class="align-middle booking_name" data-header="Professional">
            <div class="media align-items-center">
                <span class="bg_image_round w-43 mr-2" style="background-image: url(<?= getUserImage($booking->user->photo, $booking->user->soical_photo, $booking->user->gender) ?>)" onclick="window.location.href = '<?= asset('profile_timeline/' . $booking->user->id) ?>'"></span>
                <div class="media-body">
                    <a href="<?= asset('profile_timeline/' . $booking->user->id) ?>" class="text_darkblue font-weight-bold font-16"><?= $booking->user->first_name . ' ' . $booking->user->last_name ?></a>
                </div>
            </div>
        </td>
       
        <?php
        if ($booking->gig_type == 'gig') {
            $event_name = $booking->gig->title;
        } else if ($booking->gig_type == 'group') {
            $event_name = '<a href="' . asset('group_detail/' . $booking->group->id) . '">' . $booking->group->name . '</a>';
        } else if ($booking->gig_type == 'teaching_studio') {
            $event_name = '<a href="' . asset('teaching_studio_time_line/' . $booking->studio->id) . '">' . $booking->studio->name . '</a>';
        } else if ($booking->gig_type == 'accompanist') {
            $event_name = '<a href="' . asset('accompanist_time_line/' . $booking->accompanist->id) . '">' . $booking->accompanist->name . '</a>';
        } else {
            $event_name = $booking->event_name;
        }
        ?>
        <!-- <td class="booking_date" data-header="Event Name">
            <span class="text_darkblue"><?= $event_name ?></span>
        </td> -->
        <?php if ($booking->gig_type != 'custom') { ?>
            <td class="booking_date" data-header="Booking Type">
                <?php
                $gig_type = $booking->gig_type;
                if ($gig_type == 'group') {
                    $gig_type = 'event service';
                }
                ?>
                <span class="text_darkblue"><?= str_replace("_", " ", $gig_type) ?></span>
            </td>
        <?php } ?>
        <!-- <td class="booking_email" data-header="Email">
            <span class="text_darkblue"><?= $booking->user->email ?></span>
        </td> -->
        <!-- <td class="booking_contact" data-header="Phone">
            <span class="text_darkblue"><?= $booking->user->phone ? $booking->user->phone : 'N/A' ?></span>
        </td> -->
        <td class="booking_actions" data-header="Actions">
            <div class="btns">
                <?php if ($booking->status == 'payment_refunded'){ ?>
                    <a href="javascript:void(0)" class="act_decline text_red">Payment Refunded</a>
                <?php } if ($booking->status == 'pending') { ?>
                    <a onclick="accept('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept  btn-gradient"><i class="fas fa-check"></i>Accept</a>
                    <a onclick="decline('<?= $booking->id ?>')" href="javascript:void(0)" class="act_decline text_red btn_decline"><i class="fas fa-times"></i>Decline</a>
                    <a href="javascript:void(0)" class="act_accept text_white btn_grey" onclick="showAddAvailability('<?= $booking->id ?>')"><i class="far fa-clock"></i>Add Availability</a>
                <?php } if ($booking->status == 'postponed_updated') { ?>
                    <a onclick="accept('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_green btn_accepted">Accept</a>
                    <a onclick="decline('<?= $booking->id ?>')" href="javascript:void(0)" class="act_decline text_red">Decline</a>
                    <a  href="javascript:void(0)" class="act_accept text_green"><i class="fas fa-check"></i></i> Updated </a>

                <?php } if ($booking->status == 'approved') { ?>
                    <a href="javascript:void(0)" class="act_accept text_green"><i class="fas fa-check"></i> Accepted</a>
                    <a onclick="requestPayment('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple"></i> Request Payment</a>
                <?php } if ($booking->status == 'rejected') { ?>
                    <a  href="javascript:void(0)" class="act_decline text_red">Declined</a>
                <?php } if ($booking->status == 'postponed') { ?>
                    <a   href="javascript:void(0)" class="act_accept text_purple">Availability Added</a>
                <?php } if ($booking->status == 'payment_requested') { ?>
                    <a href="javascript:void(0)" class="act_accept text_purple">Payment Requested</a>
                <?php } if ($booking->status == 'payment_approved') { ?>
                    <a href="javascript:void(0)" class="act_accept text_purple">Payment In Process</a>
                <?php } if ($booking->status == 'payment_delivered') { ?>
                    <a href="javascript:void(0)" class="act_accept text_green"><i class="fas fa-check"></i> Payment Delivered</a>
                    <?php // } if ($booking->status == 'payment_rejected') { ?>
                <?php } if ($booking->status == 'disputed') { ?>
                    <?php if ($booking->is_musician_submitted_evidence == 0) { ?>
                        <?php if ($booking->is_musician_submitted_evidence == 0) { ?>
                            <?php if (date('Y-m-d h:i:s', time()) < date('Y-m-d h:i:s', strtotime($booking->dispute_start_time_utc . ' + 2 days'))) { ?>
                                <a onclick="openDisputeModal('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple"></i> Submit Dispute Reason</a>
                            <?php } else { ?>
                                <a href="javascript:void(0)" class="act_accept text_purple">Admin is looking into this dispute</a>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
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
                <?php } if ($booking->status == 'partial_refund_requested') { ?>
                    <a data-target="#partial_refund_modal<?= $booking->id ?>" data-toggle="modal" href="javascript:void(0)" class="act_accept text_purple"></i> Open Partial Refund Request</a>
                    <div class="modal fade" id="partial_refund_modal<?= $booking->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Partial refund requested by user</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div>
                                        <strong>Partial Refund Requested Percentage:</strong>
                                        <span><?= $booking->partial_refund_requested_percentage ?>%</span>
                                    </div>
                                    <div>
                                        <strong>Partial Refund Reason:</strong>
                                        <span><?= $booking->partial_refund_reason ?></span>
                                    </div><br>
                                    <div>
                                        <span>Note:</span><br>
                                        <span>* If you press yes then the requested percentage will be refunded to user.</span><br>
                                        <span>* If you press no then you will get the whole amount of the booking.</span>
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold" onclick="acceptPartialRefund('<?=$booking->id?>')"> Yes </button>
                                        <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" onclick="rejectPartialRefund('<?=$booking->id?>')"> No </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } if ($booking->status == 'admin_requested') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_green"><i class="fas fa-check"></i></i> Admin Requested </a>
                <?php } if ($booking->status == 'admin_rejected') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_red"><i class="fas fa-check"></i></i> Admin rejected your payment </a>
                <?php } ?>
                <a href="<?= asset('booking_details/' . $booking->id) ?>" class="act_accept btn_detail_table"><i class="fas fa-eye"></i> </a>
            </div>
        </td>
    </tr>
<?php } ?>