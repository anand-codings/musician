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
                                        <h6 class="card-title d-inline font-weight-bold text-black">Testimonial for <?= $user->first_name . ' ' . $user->last_name ?></h6>
                                    </div> <!-- card header -->
                                    <div class="card-body pt-0">
                                        <p>Please give your testimonial</p>
                                        <form id="review-form" action="<?= asset('post_review') ?>" method="post">
                                            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                            <input type="hidden" name="user_id" value="<?= $user->id ?>">
                                            <textarea required class="form-control h_140" name="review" placeholder="Tell your experience.."></textarea>
                                            <input type="submit" value="Post Review" class="btn btn-round btn-gradient text-semibold btn-lg float-right mt-3">
                                        </form>
                                    </div> <!-- card body -->
                                </div> <!-- card -->

                                <?php
                            }
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title d-inline text-semibold text_purple_light"><?= $user->first_name . ' ' . $user->last_name ?> Ratings</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column flex-sm-row">
                                    <div class="average_rating text-center align-items-center align-self-center">
                                        <span class="rating"><?= $user->rating ?></span>
                                        <span class="reviews"><?= $user->number_of_reviews ?> reviews</span>
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
                                                <span class="num"> <?= $user->getFiveStarReviews->count() ?> </span>
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
                                                <span class="num"> <?= $user->getFourStarReviews->count() ?> </span>
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
                                                <span class="num"> <?= $user->getThreeStarReviews->count() ?> </span>
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
                                                <span class="num"> <?= $user->getTwoStarReviews->count() ?> </span>
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
                                                <span class="num"> <?= $user->getOneStarReviews->count() ?> </span>
                                            </div> <!-- progressbar -->
                                        </div> <!-- d-flex -->
                                    </div> <!-- profile_rating_progress -->
                                </div> <!-- d flex -->
                            </div> <!-- card body -->
                        </div> <!--card -->
                        <div id="reviews-list"></div>
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
            $.ajax({
                url: base_url + 'post_review',
                type: 'POST',
                data: {'user_id': user_id, 'booking_id': booking_id, 'rating': rating, 'review': review},
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
                    loadReviews(skip, 12, isScroll);
                }
            }
        });
    });

    function loadReviews(skip, take, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#reviews-list').append(loader);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('fetch_profile_reviews/'); ?>",
            data: {skip: skip, take: take, 'user_id': '<?= $user->id ?>'},
            success: function (response) {
                $('#loaderposts').remove();
                if (response) {
                    $('#reviews-list').append(response);
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

</script>
