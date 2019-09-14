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
        <div class="page_create_group">

            <?php
            $cover = asset('public/images/groups/cover_photo_demo.jpg');
            if ($gig->image) {
                $cover = $gig->image;
            }
            ?>
            <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
                <div class="overlay_color">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-md-4 text-center align-items-center align-self-center">
                                <div class="edit_user_profile_pic">
                                    <?php
                                    $pic = asset('public/images/profile_pics/demo.png');
                                    if ($gig->profile_pic) {
                                        $pic = $gig->profile_pic;
                                    }
                                    ?>
                                    <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                                </div>
                            </div> <!-- col -->
                            <div class="col-lg-9 col-md-8">
                                <div class="profile_public_info">
                                    <div class="profile_name">
                                        <h2><?= $gig->title ?></h2>
                                    </div>       
                                    <div class="rating_reviews clearfix">
                                        <div class="star-ratings-sprite">
                                            <span style="width: <?= $gig->rating_percentage ? $gig->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                        </div>
                                        <span class="reviews text_grey">(<?= $gig->number_of_reviews ? $gig->number_of_reviews : '0' ?> Reviews)</span>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- row -->
                    </div> <!-- container -->
                </div> <!-- overlay color -->
            </div> <!-- cover photo -->

            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box box-shadow clearfix">

                            <div class="d-flex mb-2 flex-wrap">

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Categories</span>
                                    <?php
                                    if (!$gig->getSelectedCategories->isEmpty()) {
                                        $getSelectedArtistTypesCount = $gig->getSelectedCategories->count();
                                        $i = 1;
                                        foreach ($gig->getSelectedCategories as $studioSelectedCategory) {
                                            echo $studioSelectedCategory->getCategory->title;
                                            if ($getSelectedArtistTypesCount > $i)
                                                echo ', ';
                                            $i++;
                                        }
                                    } else {
                                        ?>
                                        N/A
<?php } ?>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Ensemble Category</span> <?= $gig->ensembleCategory ? $gig->ensembleCategory->title : 'Disabled' ?> 
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $gig->location ? $gig->location : 'N/A' ?> 
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-"></i> Range</span> <?= $gig->range ? $gig->range . ' km' : 'N/A' ?> 
                                </div>

                                <?php
                                $unit = $gig->unit->title;
                                if ($gig->unit->title == 'hour') {
                                    $unit = 'hr';
                                }
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-money-bill-alt"></i> Price</span> $<?= $gig->price . ' / ' . $gig->per_unit . ' ' . $unit ?> 
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-tags"></i> Genre</span> <?= $gig->genre ? $gig->genre : 'N/A' ?> 
                                </div>

                            </div>

                            <div>
                                <h6 class="d-block font-weight-bold text-uppercase">Description</h6>
                                <p><?= $gig->description ? $gig->description : 'N/A' ?></p>
                            </div>
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
                <div class="row">
                    <div class="col-lg-12">

                        <?php
                        if (Auth::user()) {
                            if ($gig->user_id != Auth::user()->id) {
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

        <?php if (isset($review_enabled)) { ?>

                                    <div class="card">
                                        <div class="card-header">
                                            <h6 class="card-title d-inline font-weight-bold text-black">Review <?= $gig->title ?></h6>
                                        </div> <!-- card header -->
                                        <div class="card-body pt-0">
                                            <div class="rating_reviews clearfix mb-1">
                                                <span id="rateYo"></span>
                                                <span id="counter"></span>
                                                <span class="text-black" id="review_msg"></span>
                                            </div>
                                            <p>Please include a written review with your rating</p>
                                            <form id="review-form" action="<?= asset('post_review') ?>" method="post">
                                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                <input type="hidden" name="user_id" value="<?= $gig->user_id ?>">
                                                <input type="hidden" name="booking_id" value="<?= $booking_id ?>">
                                                <input type="hidden" name="gig_type" value="<?= $gig_type ?>">
                                                <input type="hidden" name="gig_type_id" value="<?= $gig_type_id ?>">
                                                <input type="hidden" name="type" value="<?= $gig_type == 'custom' ? 'testimonial' : 'review' ?>">
                                                <input name="rating" id="rating" type="hidden">
                                                <textarea required class="form-control h_140" name="review" placeholder="Tell your experience.."></textarea>
                                                <input type="submit" value="Post Review" class="btn btn-round btn-gradient text-semibold btn-lg float-right mt-3">
                                            </form>
                                        </div> <!-- card body -->
                                    </div> <!-- card -->

                                <?php } ?>        
                            <?php } ?>        
<?php } ?>        
                        <div class="card" id="rating_card">
                            <div class="card-header">
                                <h5 class="card-title d-inline text-semibold text_purple_light"><?= $gig->title ?> Ratings</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column flex-sm-row">
                                    <div class="average_rating text-center align-items-center align-self-center">
                                        <span class="rating" id="average_rating"><?= $gig->rating ?></span>
                                        <span class="reviews"><?= $gig->number_of_reviews ?> reviews</span>
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
                                                <span class="num"><?= $gig->getFiveStarReviews->count() ?></span>
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
                                                <span class="num"><?= $gig->getFourStarReviews->count() ?></span>
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
                                                <span class="num"><?= $gig->getThreeStarReviews->count() ?></span>
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
                                                <span class="num"><?= $gig->getTwoStarReviews->count() ?></span>
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
                                                <span class="num"><?= $gig->getOneStarReviews->count() ?></span>
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
        </div> <!-- page timeline -->
            <?php if (Auth::guard('user')->check()) { ?>
            <div class="sidebar show_on_mobile">
            <?php include resource_path('views/includes/sidebar.php'); ?>
            </div>
        <?php } ?>
<?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>

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

            $('textarea[name=review]').trigger('focus');

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
                                "url": '<?= asset('gig_detail/' . $gig->id) ?>',
                                "notification_icon": '<?= asset('userassets/images/icon-review.png') ?>',
                                "other_url": '<?= asset('gig_detail/' . $gig->id) ?>',
                                "unique_text": response.notification.unique_text,
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('gig_detail/' . $gig->id) ?>';
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
    //         data: {skip: skip, take: take, type: 'gig', 'id': '<?= $gig->id ?>'},
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
