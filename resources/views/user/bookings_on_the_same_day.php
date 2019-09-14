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
                                    <h4 class="font-weight-bold text_darkblue mb-0"> Bookings on <?= date('F j, Y', strtotime($bookings[0]->booking_time)) ?></h4>
                                </div>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" >
                                    <table class="table table-hover table_booking table_attribute">
                                        <thead>
                                            <tr>
                                                <th>Users</th>
                                                <th>Booking On</th>
                                                <th>Event Name</th>
                                                <th>Booking Type</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($bookings as $booking) { ?>                                 
                                                <tr>
                                                    <td class="align-middle booking_name" data-header="Professional">
                                                        <div class="media align-items-center">
                                                            <span class="bg_image_round w-43 mr-2" style="background-image: url(<?= getUserImage($booking->user->photo, $booking->user->soical_photo, $booking->user->gender) ?>)" onclick="window.location.href = '<?= asset('profile_timeline/' . $booking->user->id) ?>'" ></span>
                                                            <div class="media-body">
                                                                <a href="<?= asset('profile_timeline/' . $booking->user->id) ?>" class="text_darkblue font-weight-bold font-16"><?= $booking->user->first_name . ' ' . $booking->user->last_name ?></a>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="booking_date" data-header="Booking On">
                                                        <span class="text_darkblue"><?= date('F j, Y', strtotime($booking->booking_time)) ?></span>
                                                    </td>
                                                    <?php
                                                    if ($booking->gig_type == 'gig') {
                                                        $event_name = $booking->gig->title;
                                                    } else if ($booking->gig_type == 'group') {
                                                        $event_name = '<a href="' . asset('group_time_line/' . $booking->group->id) . '">' . $booking->group->name . '</a>';
                                                    } else {
                                                        $event_name = $booking->event_name;
                                                    }
                                                    ?>
                                                    <td class="booking_date" data-header="Event Name">
                                                        <span class="text_darkblue"><?= $event_name ?></span>
                                                    </td>
                                                    <td class="booking_date" data-header="Booking Type">
                                                        <span class="text_darkblue"><?= $booking->gig_type ?></span>
                                                    </td>
                                                    <td class="booking_email" data-header="Email">
                                                        <span class="text_darkblue"><?= $booking->user->email ?></span>
                                                    </td>
                                                    <td class="booking_contact" data-header="Phone">
                                                        <span class="text_darkblue"><?= $booking->user->phone ? $booking->user->phone : 'N/A' ?></span>
                                                    </td>
                                                    <td class="booking_actions" data-header="Actions">
                                                        <div class="btns">
                                                            <a href="<?= asset('booking_details/' . $booking->id) ?>" class="act_accept text_purple">Detail</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div> <!-- tab 1 -->
                            </div> <!-- tabs -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>