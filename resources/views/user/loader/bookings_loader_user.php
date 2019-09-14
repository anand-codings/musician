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
                <img onclick="window.location.href = '<?= asset('profile_timeline/' . $booking->artist->id) ?>'" style="cursor: pointer;" class="align-self-center mr-2 rounded-circle w-43" src="<?= getUserImage($booking->artist->photo, $booking->artist->soical_photo, $booking->artist->gender) ?>" alt="">
                <div class="media-body">
                    <a href="<?= asset('profile_timeline/' . $booking->artist->id) ?>" class="text_darkblue font-weight-bold font-16"><?= $booking->artist->first_name . ' ' . $booking->artist->last_name ?></a>
                </div>
            </div>
        </td>
        
        <?php
        if ($booking->gig_type == 'gig') {
            $event_name = $booking->gig->title;
        } else if ($booking->gig_type == 'group') {
            $event_name = '<a href="' . asset('group_time_line/' . $booking->group->id) . '">' . $booking->group->name . '</a>';
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
        <td class="booking_email" data-header="Price">
            <span class="text_darkblue"><?= '$' . $booking->price ?></span>
        </td>
        <td class="booking_actions" data-header="Actions">
            <div class="btns">
                <?php if ($booking->status == 'payment_refunded') { ?>
                    
                    <a href="javascript:void(0)" class="act_decline text_red"><i class="fas fa-check"></i> Payment Refunded</a>
                <?php } if ($booking->status == 'pending') { ?>

                    <a href="javascript:void(0)" class="act_accept text_yellow btn_booking"><i class="far fa-clock"></i>Pending</a>

                <?php } if ($booking->status == 'approved') { ?>
                    <a href="javascript:void(0)" class="act_accept text_green btn_booking"><i class="fas fa-check"></i> Accepted</a>
                <?php } if ($booking->status == 'rejected') { ?>
                    <a  href="javascript:void(0)" class="act_decline text_red btn_booking">Declined</a>
                <?php } if ($booking->status == 'payment_approved') { ?>
                    <a href="javascript:void(0)" class="act_accept text_green btn_booking"><i class="fas fa-check"></i> Payment Approved</a>                    <a href="javascript:void(0)" class="act_accept text_green btn_booking"><i class="fas fa-check"></i> Payment Approved</a>
                <?php } if ($booking->status == 'payment_delivered') { ?>
                    <a href="javascript:void(0)" class="act_accept text_blue btn_booking"><i class="fas fa-check"></i> Payment Delivered</a>
                <?php } if ($booking->status == 'payment_rejected') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_red btn_booking" ><i class="fas fa-check"></i> Payment Rejected</a>
                <?php } if ($booking->status == 'payment_requested') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_purple btn_booking"> Payment Requested</a>
                <?php } if ($booking->status == 'admin_requested') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_green btn_booking"><i class="fas fa-check"></i></i> Admin Requested </a>
                <?php } if ($booking->status == 'postponed_updated') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_green btn_booking"><i class="fas fa-check"></i></i> Updated </a>
                <?php } if ($booking->status == 'admin_rejected') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_green"><i class="fas fa-check"></i></i> Admin refunded your payment </a>
                <?php } if ($booking->status == 'disputed') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_red btn_booking"> Disputed </a>
                <?php } if ($booking->status == 'partial_refund_requested') { ?>
                    <a  href="javascript:void(0)" class="act_accept text_red btn_booking"> Partial refund requested </a>
                <?php } ?>
            </div>

            
        </td>
    <!--                                                <td class="booking_contact" data-header="Phone">
            <span class="text_darkblue">+111-222-333</span>
        </td>-->
        <td class="booking_actions" data-header="Actions">
            <div class="btns">
                <?php if ($booking->status == 'payment_requested') { ?>
                    <a onclick="approvePayment('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple">Approve Payment</a>
                    <a onclick="rejectPayment('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple">Reject Payment</a>
                    <a onclick="openPartialRefundModal('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple">Request Partial refund</a>
                <?php } if ($booking->status == 'disputed') { ?>
                    <?php if ($booking->is_user_submitted_evidence == 0) { ?>
                        <?php if (date('Y-m-d h:i:s', time()) < date('Y-m-d h:i:s', strtotime($booking->dispute_start_time_utc . ' + 2 days'))) { ?>
                            <a onclick="openDisputeModal('<?= $booking->id ?>')" href="javascript:void(0)" class="act_accept text_purple"></i> Submit Dispute Reason</a>
                        <?php } else { ?>
                            <a href="javascript:void(0)" class="act_accept text_purple">Admin is looking into this dispute</a>
                        <?php } ?>
                    <?php } ?>
                    <a data-target="#dispute_detail_modal<?=$booking->id?>" data-toggle="modal" href="javascript:void(0)" class="act_accept text_purple"></i> Dispute Detail</a>
                    <div class="modal fade" id="dispute_detail_modal<?=$booking->id?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
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
                                            <img src="<?=asset('public/images/'.$evidence->file_path)?>" style="width: 100%">
                                            <?php } ?>
                                        </div><br><br>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } if ($booking->status == 'postponed') { ?>
                    <a   href="javascript:void(0)" class="act_accept text_darkblue">Postponed</a>
                    <a   href="<?= asset('booking_details/' . $booking->id) ?>" class="act_accept text_purple">View Availability</a>
                <?php } ?>
                    <?php if($booking->status == 'payment_delivered') { ?> 
             <a href="<?= asset('download_invoice/' . $booking->id) ?>" class="act_accept  btn_detail_table">Download Receipt</a>
                    <?php }?>
                <a href="<?= asset('booking_details/' . $booking->id) ?>" class="act_accept  btn_detail_table"><i class="fa fa-eye" aria-hidden="true"></i></a>
            </div>
        </td>
    </tr>
    


<?php } ?>