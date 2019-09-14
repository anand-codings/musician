<?php if ($current_user) { ?>
    <script>

        $('#group_booking_validation').validate({
    //        onfocusout: false,
    //        onkeyup: false,
    //        onclick: false,
            submitHandler: function () {
                addGroupBooking();
            }
        });

        function addGroupBooking() {
            $('#booking_error_custom').hide();
            booking_description = $('#description').val();
            booking_hours = $('#hours_offering').val();
            booking_date = $('#date').val();
            booking_location = $('#location').val();
            booking_email = $('#email').val();
            booking_name = $('#name').val();
            booking_price = $('#price').val();
            user_id = '<?= $user_id_current ?>';
    //        event_name = $('#event_name').val();
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
                data: {gig_type: 'teaching_studio',
    //        event_name: event_name, 
                    user_id: user_id, "teaching_studio_id": '<?= $studio->id ?>', booking_price: booking_price, booking_location: booking_location, booking_email: booking_email, booking_date: booking_date, booking_name: booking_name, booking_hours: booking_hours, booking_description: booking_description, "_token": '<?= csrf_token() ?>'},
                success: function (response) {
                    socket.emit('notification_get', {
                        "user_id": user_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + response.notification.notification_text,
                        "url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                        "other_url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                        "is_booking_notification": 1
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
                    $("#booknow").animate({scrollTop: 0}, "slow");
                    setTimeout(function(){ window.location = '<?=asset('booking')?>'; }, 5000);
                }
            });

        }

        $('#join-studio-btn').click(function () {
            var otherid = '<?= $studio->admin_id ?>';
            var studioId = $(this).attr('studio-id');
            var status = $(this).attr('status');
            if (status !== 'rejected') {
                $.ajax({
                    url: base_url + 'join_studio',
                    type: 'POST',
                    data: {'studio_id': studioId, 'status': status},
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        console.log(data);
                        if (data.status === 'requested') {
                            $('#join-studio-btn').html('Cancel Request');
                            $('#join-studio-btn').attr('status', 'requested');
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' wants to join your studio "<?= $studio->name ?>"',
                                "url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "studio_id": '<?= $studio->id ?>',
                                "studio_name": '<?= $studio->name ?>',
                                "studio_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                            });
                        } else if (data.status === 'leaved') {
                            $('#join-studio-btn').html(' <i class="fas fa-plus mr-1"></i>  Join Studio');
                            $('#join-studio-btn').attr('status', 'join');
                        }
    //                        setTimeout(function () {
    //                            window.location.reload();
    //                        }, 1000);
                    }
                });
            }
        });

    </script>
<?php } ?>

<?php if (Auth::guard('user')->check()) { ?>
    <?php if (isset($review_enabled)) { ?>
        <script>

            var el = $('.card');
            var elOffset = el.offset().top;
            var elHeight = el.height();
            var windowHeight = $(window).height();
            var offset;

            if (elHeight < windowHeight) {
                offset = elOffset - ((windowHeight / 2) - (elHeight / 2));
            } else {
                offset = elOffset;
            }

            $('html,body').animate({
                scrollTop: offset
            }, 'slow');
            $('#review-form').validate({
                submitHandler: function () {
                    submitForm();
                }
            });

            function submitForm() {
                $('input[type="submit"]').attr('disabled', 'disabled');
                var user_id = $('input[name="user_id"]').val();
                var booking_id = $('input[name="booking_id"]').val();
                var rating = $('input[name="rating"]').val();
                var review = $('textarea[name="review"]').val();
                var gig_type = $('input[name="gig_type"]').val();
                var gig_type_id = $('input[name="gig_type_id"]').val();
                var type = $('input[name="type"]').val();
                $.ajax({
                    url: base_url + 'post_review',
                    type: 'POST',
                    data: {'user_id': user_id, 'booking_id': booking_id, 'rating': rating, 'review': review,
                        'gig_type': gig_type, 'gig_type_id': gig_type_id, 'type': type
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (response) {
                        if (response.error) {
                            vulgarTermsErrorAlert();
                            $('input[type="submit"]').removeAttr('disabled');
                        } else {
                            socket.emit('notification_get', {
                                "user_id": response.notification.on_user,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> ' + response.notification.notification_text,
                                "url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "notification_icon": '<?= asset('userassets/images/icon-review.png') ?>',
                                "other_url": '<?= asset('teaching_studio_time_line/' . $studio->id) ?>',
                                "unique_text": response.notification.unique_text,
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('teaching_studio_time_line/' . $studio->id) ?>';
                            }, 500);
                        }
                    }
                });
            }

        </script>
    <?php } ?>
<?php } ?>

<script>
    $("#rateYo").rateYo({
        starWidth: "20px",
        normalFill: "#bfbfbf",
        ratedFill: "#ff8441",
    }).on("rateyo.change", function (e, data) {
        var rating = data.rating;
        $('#counter').text(rating);
        $('#rating').val(rating);
        if (rating <= 2) {
            $('#review_msg').html('Below average');
        } else if (rating <= 3) {
            $('#review_msg').html('Average');
        } else if (rating <= 4) {
            $('#review_msg').html('Very Good');
        } else if (rating <= 5) {
            $('#review_msg').html('Excellent');
        }
    });
    var ajaxcall = 1;
    var isScroll = 0;
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {
        var skip = 0;
        var take = 12;

        loadReviews(skip, take, isScroll);
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            isScroll = 1;
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                    loadReviews(skip, take, isScroll);
                }
            }
        });
    });

    // function loadReviews(skip, take, isScroll) {
    //     ajaxcall = 0;
    //     $('#loaderposts').remove();
    //     var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
    //     $('#reviews-list').append(loader);
    //     $.ajax({
    //         type: "GET",
    //         url: "<?php echo asset('fetch_reviews_for_detail_page/'); ?>",
    //         data: {skip: skip, take: take, type: 'teaching_studio', 'id': '<?= $studio->id ?>'},
    //         success: function (response) {
    //             response = JSON.parse(response);
    //             $('#loaderposts').remove();
    //             if (response.html) {
    //                 $('#reviews-list').append(response.html);
    //                 ajaxcall = 1;
    //                 var a = parseInt(1);
    //                 var b = parseInt(count);
    //                 count = b + a;
    //                 return true;
    //             } else {
    //                 if ($('#reviews-list').is(':empty')) {
    //                     noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
    //                     $('#reviews-msg').html(noposts);
    //                 } else {
    //                     noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
    //                     $('#reviews-msg').html(noposts);
    //                 }
    //                 ajaxcall = 0;
    //                 return false;
    //             }
    //         }
    //     });
    // }

    function deleteReview(review_id) {
        $.ajax({
            type: "GET",
            url: "<?php echo asset('delete_review'); ?>",
            data: {review_id: review_id},
            success: function (response) {
                if (response.message == 'success') {
                    $('#review-card' + review_id).hide('slow', function () {
                        $('#review-card' + review_id).remove();
                    });
                    $('#showSuccess').html('Review Deleted Successfully').fadeIn().fadeOut(5000);
                    $('#modal_social_share_' + review_id).modal('hide');
                    $('#modal_delete_' + review_id).modal('hide');
//                                                            
                } else {
                    $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                }
            }
        });
    }
</script>