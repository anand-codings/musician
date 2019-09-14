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
        <?php include resource_path('views/includes/profile_cover_photo_section.php'); ?>
        <!-- cover photo -->
        <div class="page_timeline">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path(getProfileSidebarPath($user->type)); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <?php include resource_path('views/includes/profile_nav_tabs.php'); ?>
                        <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                            <div class="d-flex align-items-center filter_form">
                                <select id="filter" class="form-control">
                                    <option value="all">All</option>
                                    <!--<option value="gig" <?= isset($review_enabled) && $gig_type == 'gig' ? 'selected' : '' ?>>Gigs</option>-->
                                    <option value="group" <?= isset($review_enabled) && $gig_type == 'group' ? 'selected' : '' ?>>Event Services</option>
                                    <option value="teaching_studio" <?= isset($review_enabled) && $gig_type == 'teaching_studio' ? 'selected' : '' ?>>Teaching Studios</option>
                                    <option value="accompanist" <?= isset($review_enabled) && $gig_type == 'accompanist' ? 'selected' : '' ?>>Accompanists</option>
                                    <option value="testimonial">Testimonials</option>
                                </select>
                            </div>
                        </div>
                        <div class="musician_reviews_listing"></div>
                        <?php
                        if (Auth::user()) {
                            if ($user->id != Auth::user()->id) {
                                ?>
                                <?php
                                if ($errors->any()) {
                                    foreach ($errors->all() as $error) {
                                        ?>
                                        <h6 class="alert alert-danger"> <?php echo $error ?></h6>
                                        <?php
                                    }
                                }
                                if (Session::has('success')) {
                                    ?>
                                    <div class="alert alert-success">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        <?php echo Session::get('success') ?>
                                    </div>
                                    <?php
                                }
                                if (Session::has('error')) {
                                    ?>
                                    <div class="alert alert-danger">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        <?php echo Session::get('error') ?>
                                    </div>
                                <?php } ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title d-inline font-weight-bold text-black">Review <?= $user->first_name . ' ' . $user->last_name ?></h6>
                                    </div> <!-- card header -->
                                    <div class="card-body pt-0">
                                        <?php if (isset($review_enabled)) { ?>
                                            <div class="rating_reviews clearfix mb-1">
                                                <span id="rateYo"></span>
                                                <span id="counter"></span>
                                                <span class="text-black" id="review_msg"></span>
                                            </div>
                                            <p>Please include a written review with your rating</p>
                                        <?php } else { ?>
                                            <p>Please include a written review</p>
                                        <?php } ?>
                                        <form id="review-form" action="<?= asset('post_review') ?>" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id ?>">

                                            <?php if (isset($review_enabled)) { ?>
                                                <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                                                <input type="hidden" name="gig_type" value="<?= $gig_type ?>">
                                                <input type="hidden" name="gig_type_id" value="<?= $gig_type_id ?>">
                                                <input type="hidden" name="type" value="<?= $gig_type == 'custom' ? 'testimonial' : 'review' ?>">
                                                <input name="rating" id="rating" type="hidden">
                                            <?php } else { ?>
                                                <input type="hidden" name="type" value="testimonial">
                                            <?php } ?>

                                            <textarea required class="form-control h_140" name="review" placeholder="Tell your experience.."></textarea>
                                            <input type="submit" value="Post Review" class="btn btn-round btn-gradient text-semibold btn-lg float-right mt-3">
                                        </form>
                                    </div> <!-- card body -->
                                </div> <!-- card -->
                                <?php
                            }
                        }
                        ?>
                        <div class="card" id="rating_card">
                            <div class="card-header">
                                <h5 class="card-title d-inline text-semibold text_purple_light"><span id="rating_type_name"></span> Ratings</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column flex-sm-row">
                                    <div class="average_rating text-center align-items-center align-self-center">
                                        <span class="rating" id="average_rating"></span>
                                        <span class="reviews"><span id="reviews_count"></span> reviews</span>
                                    </div> <!-- total rating -->

                                    <div class="rating_progress">
                                        <div class="d-flex">
                                            <div class="rating_stars">
                                                <span class="star_label">5 Stars </span>                                                    
                                                <span class="rating_reviews">                                                    
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                </span>
                                            </div>
                                            <div class="progress_bar">
                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="num" id="5star"></span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                        <div class="d-flex">
                                            <div class="rating_stars">
                                                <span class="star_label">4 Stars </span>                                                    
                                                <span class="rating_reviews">                                                    
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star grey"></i>
                                                </span>
                                            </div>
                                            <div class="progress_bar">
                                                <div class="progress" style="width:65%">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="num" id="4star"></span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                        <div class="d-flex">
                                            <div class="rating_stars">
                                                <span class="star_label">3 Stars </span>                                                    
                                                <span class="rating_reviews">                                                    
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                </span>
                                            </div>
                                            <div class="progress_bar">
                                                <div class="progress" style="width:45%">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="num" id="3star"></span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                        <div class="d-flex">
                                            <div class="rating_stars">
                                                <span class="star_label">2 Stars </span>                                                    
                                                <span class="rating_reviews">                                                    
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                </span>
                                            </div>
                                            <div class="progress_bar">
                                                <div class="progress" style="width:15%">>
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="num" id="2star"></span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                        <div class="d-flex">
                                            <div class="rating_stars">
                                                <span class="star_label">1 Stars </span>                                                    
                                                <span class="rating_reviews">                                                    
                                                    <i class="fas fa-star"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                    <i class="fas fa-star grey"></i>
                                                </span>
                                            </div>
                                            <div class="progress_bar">
                                                <div class="progress" style="width:5%">
                                                    <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <span class="num" id="1star"></span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                    </div> <!-- profile_rating_progress -->
                                </div> <!-- d flex -->
                            </div> <!-- card body -->
                        </div> <!--card -->
                        <div id="reviews-list" class="musician_reviews_listing"></div>
                        <div id="reviews-msg"></div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page_timeline -->
        <?php if (Auth::guard('user')->check()) { ?>
            <div class="show_on_mobile clearfix">
                <?php include resource_path('views/includes/sidebar.php'); ?>
            </div>
        <?php } ?>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>    
</body>
<style>
    input.error {
        border:solid 1px red !important;
    }
    #group-form label.error {
        width: auto;
        display: none !important;
        color:red;
        font-size: 16px;
        float:right;
    }
    .ui-autocomplete{
        max-height: 200px;
        overflow-y: auto;
        overflow-x: hidden;
    }

</style>
</html>
<?php if (Auth::guard('user')->check()) { ?>
    <script>

        $('#review-form').validate({
            //        onfocusout: false,
            //        onkeyup: false,
            //        onclick: false,
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
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' entered a review on your profile',
                            "url": '<?= asset('profile_reviews') ?>' + '/' + response.notification.on_user,
                            "notification_icon": '<?= asset('userassets/images/icon-review.png') ?>',
                            "other_url": '<?= asset('profile_reviews') ?>' + '/' + response.notification.on_user,
                            "unique_text": response.notification.unique_text,
                        });
                        setTimeout(function () {
                            window.location.href = base_url + 'profile_reviews/' + response.notification.on_user;
                        }, 500);
                    }
                }
            });
        }

    </script>
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

    $('#filter').change(function () {
        var filter_val = $(this).val();
        change_filter(filter_val);
    });

    function change_filter(type) {
        $('#reviews-list').html('');
        if (type == 'testimonial') {
            $('#rating_card').hide();
        } else if (type == 'all') {
            $('#rating_card').hide();
        } else {
            $('#rating_card').show();
        }
        loadReviews(0, 12, type, isScroll);
    }

    var ajaxcall = 1;
    var isScroll = 0;
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        var type = $('#filter').val();

        if (type == 'all') {
            $('#rating_card').hide();
        }

        loadReviews(skip, take, type, isScroll);
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            isScroll = 1;
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                    var type = $('#filter').val();
                    loadReviews(skip, take, type, isScroll);
                }
            }
        });
    });

    function loadReviews(skip, take, type, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#reviews-list').append(loader);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('fetch_profile_reviews/'); ?>",
            data: {skip: skip, take: take, type: type, 'user_id': '<?= $user->id ?>'},
            success: function (response) {
                response = JSON.parse(response);
                var typeName = toTitleCase(type.replace(/_/g, " "));
                $('#reviews_count').html(response.reviews_count);
                if (response.average_rating) {
                    $('#average_rating').html(Number((response.average_rating).toFixed(1)));
                }
                $('#1star').html(response.one_star_reviews_count);
                $('#2star').html(response.two_star_reviews_count);
                $('#3star').html(response.three_star_reviews_count);
                $('#4star').html(response.four_star_reviews_count);
                $('#5star').html(response.five_star_reviews_count);
                if (typeName == 'Group') {
                    typeName = 'Event Service';
                }
                $('#rating_type_name').html(typeName + 's');
                $('#loaderposts').remove();
                if (response.html) {
                    $('#reviews-list').append(response.html);
                    ajaxcall = 1;
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    return true;
                } else {
                    if ($('#reviews-list').is(':empty')) {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#reviews-msg').html(noposts);
                    } else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#reviews-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }

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

    function toTitleCase(str) {
        return str.replace(/\w\S*/g, function (txt) {
            return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
        });
    }

</script>
