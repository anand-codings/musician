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
            $cover = asset('public/images/teaching_studios/cover_photo_demo.jpg');
            if ($studio->cover) {
                $cover = asset('public/images/' . $studio->cover);
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
                                    if ($studio->pic) {
                                        $pic = asset('public/images/' . $studio->pic);
                                    }
                                    ?>
                                    <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                                </div>
                            </div> <!-- col -->

                            <div class="col-lg-9 col-md-8">
                                <div class="profile_public_info">
                                    <div class="profile_name">
                                        <h2><?= $studio->name ?></h2>
                                    </div>       
                                    <div class="rating_reviews clearfix">
                                        <div class="star-ratings-sprite">
                                            <span style="width: <?= $studio->rating_percentage ? $studio->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                        </div>
                                        <span class="reviews text_grey">(<?= $studio->number_of_reviews ? $studio->number_of_reviews : '0' ?> Reviews)</span>
                                    </div>
                                </div>
                            </div>

                        </div> <!-- row -->
                    </div> <!-- container -->
                </div> <!-- overlay color -->
            </div> <!-- cover photo -->

            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-3">
                        <?php if ($studio->allow_booking) { ?>
                            <?php if (!Auth::user() || Auth::user()->type == 'user') { ?>
                                <div class="custom_booking_side">
                                    <h3 class="font-22 text-center text-uppercase mb-3 font-weight-bold text_darkblue">Book the Teaching Studio</h3>
                                    <h5 id="booking_error_custom" class="alert alert-danger" style="display: none"></h5>
                                    <h5 id="booking_success_custom" class="alert alert-success" style="display: none"></h5>   
                                    <?php
                                    $book_now = '';
                                    if (Auth::user()) {
                                        if (!Auth::user()->stripe_id) {
                                            $book_now = 1;
                                            ?>
                                            <h5 class="alert alert-info">Please Add Card To Book This Teaching Studio</h5>
                                            <?php
                                        }
                                    } else {
                                        $book_now = 1;
                                        ?> 
                                        <h5 class="alert alert-info">Please Login To Book This Teaching Studio</h5>
                                    <?php } ?>
                                    <form class="book_group_form" id="group_booking_validation" method="post" action="<?= asset('add_group_booking') ?>">
                                        <div class="form-group">
                                            <label>First & Last Name</label>
                                            <input id="name" required name="name" type="text" placeholder="John Doe" value="<?= $current_name ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Your Email</label>
                                            <input id="email" name="email" required type="email" placeholder="johndoe@email.com" value="<?= $current_email ?>" class="form-control">
                                        </div>
                                        <!--                                <div class="form-group">
                                                                            <label>Event Name</label>
                                                                            <input type="text" name="event_name" required id="event_name" placeholder="Wedding, birthday or anniversaries" class="form-control">
                                                                        </div>-->
                                        <div class="form-group">
                                            <label>Location</label>
                                            <input id="location" name="location" required type="text" placeholder="Enter Location" class="form-control autofill_location">
                                        </div>
                                        <div class="form-group">
                                            <label>Date</label>
                                            <div class="d-flex">
                                                <input id="date" name="date" required readonly="" type="text" placeholder="Date" class="form-control mr-2 date-picker">

                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label>Hours offering</label>
                                            <input id="hours_offering" name="hours_offering" required type="number" placeholder="0:00" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Price offering</label>
                                            <input id="price" name="price" required type="number" placeholder="$$$" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Description</label>
                                            <textarea id="description" name="description" required placeholder="Enter Description" class="form-control"></textarea>
                                        </div>

                                        <?php if (!$current_user) { ?>
                                            <div class="form-group text-center mt-4">
                                                <input onclick="window.location.href = '<?= asset('login') ?>'" type="button" value="Submit" class="btn btn-round btn_aqua btn-xl">
                                            </div>
                                        <?php
                                        } else if (!$book_now && $studio->allow_booking) {
                                            if ($current_id != $user_id_current) {
                                                ?>
                                                <div class="form-group text-center mt-4">
                                                    <input type="submit" value="Submit" class="btn btn-round btn_aqua btn-xl">
                                                </div>
                                            <?php }
                                        }
                                        ?>
                                    </form>
                                </div>
    <?php } ?>
<?php } ?>
                    </div> <!-- col -->
                    <div class="col-lg-<?= (Auth::user() && Auth::user()->type == 'artist') || (!$studio->allow_booking) ? '12' : '9' ?>">
                        <div class="box box-shadow clearfix">
                            <div class="d-flex flex-column flex-md-row mb-3">
                                <!--                                <div>
                                                                    <h3 class="mb-0 text-black"><?= $studio->name ?></h3>
                                                                </div>-->

                                <?php if (Auth::user()) { ?>
                                    <?php
                                    if ($studio->admin_id != $current_id && Auth::user()->type == 'user') {
                                        $check = 'join';
                                        $btnText = '<i class="fas fa-plus mr-1"></i>  Join Studio';
                                        if (!$studio->members->isEmpty()) {
                                            foreach ($studio->members as $member) {
                                                if ($member->user_id == $current_id) {
                                                    if ($member->is_approved) {
                                                        $check = 'leave';
                                                        $btnText = 'Leave Studio';
                                                    } else if ($member->is_rejected) {
                                                        $check = 'rejected';
                                                        $btnText = 'Request Rejected';
                                                    } else {
                                                        $check = 'requested';
                                                        $btnText = 'Cancel Request';
                                                    }
                                                    break;
                                                }
                                            }
                                        }
                                        ?>
                                        <div class="ml-md-auto">
                                            <a href="javascript:void(0)" id="join-studio-btn" status="<?= $check ?>" studio-id="<?= $studio->id ?>" class="btn btn-round btn-gradient text-semibold"><?= $btnText ?></a>
                                        </div>

    <?php } ?>
<?php } ?>

                            </div>
                            <div class="d-flex mb-2 flex-wrap">
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Category</span>
                                    <?php
                                    if (!$studio->getSelectedCategories->isEmpty()) {
                                        $getSelectedArtistTypesCount = $studio->getSelectedCategories->count();
                                        $i = 1;
                                        foreach ($studio->getSelectedCategories as $studioSelectedCategory) {
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
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-calendar-alt"></i> Start Date</span> <?= $studio->start_date ? $studio->start_date : 'N/A' ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $studio->location ? $studio->location : 'N/A' ?> 
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-clock"></i> Time</span> <?= date('h:i a', strtotime($studio->studio_time_from)) ?> to <?= date('h:i a', strtotime($studio->studio_time_to)) ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-users"></i> Teachers </span> 
                                        <?php if (!$studio->approvedTeachers->isEmpty()) { ?>
                                        <ul class="un_style group_members_list nav align-items-center mb-0">
                                            <?php $count = 0; ?>
                                            <?php foreach ($studio->approvedTeachers as $member) { ?>
                                                <?php
                                                $memberImage = getUserImage($member->getMemberDetail->photo, $member->getMemberDetail->social_photo, $member->getMemberDetail->gender);
                                                ?>
        <?php if ($count < 3) { ?>
                                                    <li>
                                                        <a href="<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>">
                                                            <img class="align-self-center rounded-circle w-32" src="<?= $memberImage ?>" alt="">
                                                        </a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="ml-2"> <a href="javascript:void(0)" class="font-weight-bold text-uppercase font-14 text_aqua" data-toggle="modal" data-target="#teachers_modal"><u><?= $studio->approvedTeachers->count() - 3 ?> Others</u></a></li>
                                                    <?php
                                                    break;
                                                }
                                                ?>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </ul>

                                        <div class="modal fade" id="teachers_modal" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content edit-event-popup">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="create_gig_modal">Studio Teachers</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </div> <!-- modal header -->
                                                    <div class="modal-body">
                                                        <ul class="followers_list un_style">
                                                            <?php foreach ($studio->approvedTeachers as $member) { ?>
        <?php
        $memberImage = getUserImage($member->getMemberDetail->photo, $member->getMemberDetail->social_photo, $member->getMemberDetail->gender);
        ?>
                                                                <li>
                                                                    <div class="media align-items-center">
                                                                        <img  onclick="window.location.href = '<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>';" style="cursor: pointer;" src="<?= $memberImage ?>" alt="profile pic" class="rounded-circle">                                                                        <div class="media-body">
                                                                            <div class="d-flex flex-column flex-sm-row">
                                                                                <div class="mb-2">
                                                                                    <a href="<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>" class="u_name"><?= $member->getMemberDetail->first_name . ' ' . $member->getMemberDetail->last_name ?></a>
                                                                                    <div class="profession"><?= $member->getMemberDetail->getSpecialization->title ?></div>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- media body -->
                                                                    </div> <!-- media-->
                                                                </li>
    <?php } ?>
                                                        </ul> <!-- followers list -->
                                                    </div> <!-- modal body -->
                                                </div> <!-- modal content -->
                                            </div>
                                        </div>

<?php } else { ?>
                                        N/A
                                    <?php } ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-users"></i> Members </span> 
                                        <?php if (!$studio->approvedMembers->isEmpty()) { ?>
                                        <ul class="un_style group_members_list nav align-items-center mb-0">
                                            <?php $count = 0; ?>
                                            <?php foreach ($studio->approvedMembers as $member) { ?>
                                                <?php
                                                $memberImage = getUserImage($member->getMemberDetail->photo, $member->getMemberDetail->social_photo, $member->getMemberDetail->gender);
                                                ?>
        <?php if ($count < 3) { ?>
                                                    <li>
                                                        <a href="<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>">
                                                            <img class="align-self-center rounded-circle w-32" src="<?= $memberImage ?>" alt="">
                                                        </a>
                                                    </li>
                                                <?php } else { ?>
                                                    <li class="ml-2"> <a href="javascript:void(0)" class="font-weight-bold text-uppercase font-14 text_aqua" data-toggle="modal" data-target="#members_modal"><u><?= $studio->approvedMembers->count() - 3 ?> Others</u></a></li>
                                                    <?php
                                                    break;
                                                }
                                                ?>
                                                <?php
                                                $count++;
                                            }
                                            ?>
                                        </ul>

                                        <div class="modal fade" id="members_modal" tabindex="-1" role="dialog"  aria-hidden="true">
                                            <div class="modal-dialog modal-md" role="document">
                                                <div class="modal-content edit-event-popup">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="create_gig_modal">Studio Members</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </div> <!-- modal header -->
                                                    <div class="modal-body">
                                                        <ul class="followers_list un_style">
                                                            <?php foreach ($studio->approvedMembers as $member) { ?>
        <?php
        $memberImage = getUserImage($member->getMemberDetail->photo, $member->getMemberDetail->social_photo, $member->getMemberDetail->gender);
        ?>
                                                                <li>
                                                                    <div class="media align-items-center">
                                                                        <img  onclick="window.location.href = '<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>';" style="cursor: pointer;" src="<?= $memberImage ?>" alt="profile pic" class="rounded-circle">                                                                        <div class="media-body">
                                                                            <div class="d-flex flex-column flex-sm-row">
                                                                                <div class="mb-2">
                                                                                    <a href="<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>" class="u_name"><?= $member->getMemberDetail->first_name . ' ' . $member->getMemberDetail->last_name ?></a>
                                                                                </div>
                                                                            </div>
                                                                        </div> <!-- media body -->
                                                                    </div> <!-- media-->
                                                                </li>
    <?php } ?>
                                                        </ul> <!-- followers list -->
                                                    </div> <!-- modal body -->
                                                </div> <!-- modal content -->
                                            </div>
                                        </div>

<?php } else { ?>
                                        N/A
<?php } ?>
                                </div>
                            </div>
                            <div class="d-flex mb-4 flex-wrap">
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-tags"></i> Genre</span> <?= $studio->genre ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-chart-line"></i> Level Taught</span> <?= $studio->level_taught ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-user-shield"></i> Affiliation</span> <?= $studio->getUnion ? $studio->getUnion->title : 'N/A' ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-chalkboard-teacher"></i> Lesson Type</span> <?= ucfirst(str_replace("_", " ", $studio->lesson_type)) ?>
                                </div>

                                <?php
                                $unit = $studio->unit->title;
                                if ($studio->unit->title == 'hour') {
                                    $unit = 'hr';
                                }
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-money-bill-alt"></i> Price</span> $<?= $studio->price ?></strong> / <?= $studio->per_unit . ' ' . $unit ?>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Language</span> <?= $studio->language ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-hands-helping"></i> Accepting Students</span> <?= $studio->is_accepting_students ? 'Yes' : 'No' ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-graduation-cap"></i> Education</span>
<?php if (!$studio->getEducations->isEmpty()) { ?>
                                        <ol class="about_list">
    <?php foreach ($studio->getEducations as $studioEducation) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <span class="font-weight-bold"><?= $studioEducation->title ?></span>                                                                
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <span class="font-weight-bold"><?= $studioEducation->start_year . ' - ' . $studioEducation->end_year ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="text_grey">
                                                        <p><?= $studioEducation->institute_name ?></p> 
                                                    </div>
                                                </li>
                                        <?php } ?>
                                        </ol>            
<?php } else { ?>
                                        <span class="text_grey">N/A</span>
                                    <?php } ?>
                                    <hr/> 

                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-briefcase"></i> Experience</span>
<?php if (!$studio->getExperiences->isEmpty()) { ?>
                                        <ol class="about_list">
    <?php foreach ($studio->getExperiences as $studioExperience) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-7">
                                                            <span class="font-weight-bold"><?= $studioExperience->title ?></span>                                                                
                                                        </div>
                                                        <div class="col-sm-5">
                                                            <span class="font-weight-bold"><?= $studioExperience->start_year . ' - ' . $studioExperience->end_year ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="text_grey">
                                                        <p><?= $studioExperience->institute_name ?></p> 
                                                    </div>
                                                </li>
                                        <?php } ?>
                                        </ol>            
<?php } else { ?>
                                        <span class="text_grey">N/A</span>
<?php } ?>
                                    <hr/>
                                </div>
                            </div>
                            <div>
                                <h6 class="d-block font-weight-bold text-uppercase">Description</h6>
                                <p><?= $studio->description ? $studio->description : 'N/A' ?></p>
                            </div>

                            <div>
                                <h6 class="d-block font-weight-bold text-uppercase">Gallery</h6>
                            </div>
<?php if (!$studio->teachingStudioImages->isEmpty()) { ?>
                                <ul class="un_style clearfix photo_media_list">
                                    <?php foreach ($studio->teachingStudioImages as $studioImage) { ?>
                                        <li>
                                            <a href="javascript:void(0)"><div class="photo_box" style="background-image:url(<?= asset('public/images/' . $studioImage->file) ?>)"></div></a>
                                        </li>
                                <?php } ?>
                                </ul>
<?php } else { ?>
                                <div class="posts_end mt-0 mb-0">No images found.</div>
                        <?php } ?>
                        </div> <!-- Box -->

                        <br>
                        <?php
                        if (Auth::user()) {
                            if ($studio->admin_id != Auth::user()->id) {
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
                                            <h6 class="card-title d-inline font-weight-bold text-black">Review <?= $studio->title ?></h6>
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
                                                <input type="hidden" name="user_id" value="<?= $studio->admin_id ?>">
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
                                <h5 class="card-title d-inline text-semibold text_purple_light"><?= $studio->title ?> Ratings</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-column flex-sm-row">
                                    <div class="average_rating text-center align-items-center align-self-center">
                                        <span class="rating" id="average_rating"><?= $studio->rating ?></span>
                                        <span class="reviews"><?= $studio->number_of_reviews ?> reviews</span>
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
                                                <span class="num"><?= $studio->getFiveStarReviews->count() ?></span>
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
                                                <span class="num"><?= $studio->getFourStarReviews->count() ?></span>
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
                                                <span class="num"><?= $studio->getThreeStarReviews->count() ?></span>
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
                                                <span class="num"><?= $studio->getTwoStarReviews->count() ?></span>
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
                                                <span class="num"><?= $studio->getOneStarReviews->count() ?></span>
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
            <?php if (Auth::guard('user')->check()) { ?>
                <div class="sidebar show_on_mobile">
            <?php include resource_path('views/includes/sidebar.php'); ?>
                </div>
<?php } ?>
        </div> <!-- page timeline -->
<?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>
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
                    $("html, body").animate({scrollTop: 0}, "slow");
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

    function loadReviews(skip, take, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#reviews-list').append(loader);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('fetch_reviews_for_detail_page/'); ?>",
            data: {skip: skip, take: take, type: 'teaching_studio', 'id': '<?= $studio->id ?>'},
            success: function (response) {
                response = JSON.parse(response);
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
</script>

