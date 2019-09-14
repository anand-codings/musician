<div class="custom_booking_side">
    <h4 class="text-center text-uppercase mb-3 font-weight-bold font-22 text_darkblue">Custom Booking</h4>
    <h5 id="booking_error_custom" class="alert alert-danger" style="display: none"></h5>
    <h5 id="booking_success_custom" class="alert alert-success" style="display: none"></h5>   
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
    <form class="edit_user_form"  method="post" action="<?= asset('add_custom_booking') ?>">
        <div class="form-group">
            <label>First & Last Name</label>
            <input id="name" required type="text" placeholder="John Doe" value="<?=$current_name?>" class="form-control">
        </div>
        <div class="form-group">
            <label>Your Email</label>
            <input id="email" required type="email" placeholder="johndoe@email.com" value="<?=$current_email?>" class="form-control">
        </div>
        <div class="form-group">
            <label>Event Name</label>
            <input type="text" required id="event_name" placeholder="Wedding, birthday or anniversaries" class="form-control">
        </div>
        <div class="form-group">
            <label>Location</label>
            <input id="location" required type="text" placeholder="Enter Location" class="form-control autofill_location">
        </div>
        <div class="form-group">
            <label>Date</label>
            <div class="d-flex">
                <input id="date" required readonly="" type="text" placeholder="Date" class="form-control mr-2 date-picker">

            </div>
        </div>
        <div class="form-group">
            <label>Hours offering</label>
            <input id="hours_offering" required type="number" placeholder="0:00" class="form-control">
        </div>
        <div class="form-group">
            <label>Price offering</label>
            <input id="price" required type="number" placeholder="$$$" class="form-control">
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea id="description" required placeholder="Enter Description" class="form-control h_140"></textarea>
        </div>
        <?php if (!$book_now) {
            if ($current_id != $user_id_current) {
                ?>
                <div class="form-group text-center mt-4">
                    <input onclick="addBookingCustom()" type="button" value="Submit" class="btn btn-round btn_aqua btn-xl">
                </div>
        <?php }
    } ?>
    </form>
<?php if (Auth::user()) { ?>
        <script>

            function addBookingCustom() {
                $('#booking_error_custom').hide();
                booking_description = $('#description').val();
                booking_hours = $('#hours_offering').val();
                booking_date = $('#date').val();
                booking_location = $('#location').val();
                booking_email = $('#email').val();
                booking_name = $('#name').val();
                booking_price = $('#price').val();
                user_id = '<?= $user_id_current ?>';
                gig_id_ = '';
                event_name = $('#event_name').val()
                if (!booking_date) {
                    return $('#booking_error_custom').html('Date Is Required').show();
                }
                if (!booking_price) {
                    return $('#booking_error_custom').html('Price Is Required').show();
                }
                if (!booking_hours) {
                    return $('#booking_error_custom').html('Hours ars Required').show();
                }
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_booking'); ?>",
                    data: {gig_type: 'custom', event_name: event_name, user_id: user_id, "gig_id": '', booking_price: booking_price, booking_location: booking_location, booking_email: booking_email, booking_date: booking_date, booking_name: booking_name, booking_hours: booking_hours, booking_description: booking_description, "_token": '<?= csrf_token() ?>'},
                    success: function (response) {
                        socket.emit('notification_get', {
                            "user_id": user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name.' '.$current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name.' '.$current_user->last_name; ?>' + response.notification.notification_text,
                            "url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                        });

                        $('#description').val('');
                        $('#hours_offering').val('');
                        $('#date').val('');
                        $('#location').val('');
                        $('#email').val('');
                        $('#name').val('');
                        $('#price').val('');
                        $('#event_name').val('');
                        $('#booking_success_custom').html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>Booking Added Successfully').show();
                    }
                });

            }
        </script>
<?php } ?>
</div>