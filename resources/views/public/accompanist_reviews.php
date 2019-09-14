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
            $cover = asset('public/images/accompanists/cover_photo_demo.jpg');
            if ($accompanist->cover) {
                $cover = asset('public/images/' . $accompanist->cover);
            }
            ?>
            <?php include resource_path('views/includes/accompanist_header.php'); ?>
            <div class="page_timeline">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 col-lg-3">
                            <?php include resource_path('views/includes/accompanist_sidebar.php'); ?>
                        </div>
                        <div class="col-md-12 col-lg-9">
                            <?php
                            if (Auth::user()) {
                                if ($accompanist->admin_id != Auth::user()->id) {
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
                                                <h6 class="card-title d-inline font-weight-bold text-black">Review <?= $accompanist->title ?></h6>
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
                                                    <input type="hidden" name="user_id" value="<?= $accompanist->admin_id ?>">
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
                                    <h5 class="card-title d-inline text-semibold text_purple_light"><?= $accompanist->title ?> Ratings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="average_rating text-center align-items-center align-self-center">
                                            <span class="rating" id="average_rating"><?= $accompanist->rating ?></span>
                                            <span class="reviews"><?= $accompanist->number_of_reviews ?> reviews</span>
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
                                                    <span class="num"><?= $accompanist->getFiveStarReviews->count() ?></span>
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
                                                    <span class="num"><?= $accompanist->getFourStarReviews->count() ?></span>
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
                                                    <span class="num"><?= $accompanist->getThreeStarReviews->count() ?></span>
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
                                                    <span class="num"><?= $accompanist->getTwoStarReviews->count() ?></span>
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
                                                    <span class="num"><?= $accompanist->getOneStarReviews->count() ?></span>
                                                </div> <!-- progressbar -->
                                            </div> <!-- d-flex -->
                                        </div> <!-- profile_rating_progress -->
                                    </div> <!-- d flex -->
                                </div> <!-- card body -->
                            </div> <!--card -->

                            <div id="reviews-list" class="musician_reviews_listing"></div>
                            <div id="reviews-msg"></div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- page_timeline -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
        <?php include resource_path('views/includes/accompanist_scripts.php'); ?>
    </body>
</html>


