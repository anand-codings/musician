<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body>        
        <?php include resource_path('views/includes/header.php'); ?>
    <body class="bg_white">
        <div class="home_page_header">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="banner_content">
                            <h1>Alive and Kicking!</h1>
                            <p>Explore hundreds of musicians near of you, Book and cheers the music wave. Musician provides well thought-out solutions to find best musician community!</p>
                        </div>
                        <div class="s_home clearfix">
                            <form method="get" action="<?= asset('search') ?>" id="header_filter">
                                <div class="search_options">
                                    <?php $type_list = categories(); ?>
                                    <select name="cat" required="" class="selct2_select_homepage" style="width: 100%">
                                        <option></option>
                                        <?php
                                        if (isset($type_list) && count($type_list) > 0) {
                                            foreach ($type_list as $key => $typeval) {
                                                ?>
                                                <option value="<?= $typeval['id'] ?>" <?= (isset($_GET['cat']) && $_GET['cat'] == $typeval['id']) ? 'selected' : '' ?>><?= $typeval['title'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="search_input">
                                    <input autocomplete="off" id="autocomplete" name="location" type="text" class="form-control" placeholder="Location">
                                </div>
                                <input type="hidden" name="search_type" value="musicians">
                                <button type="submit"> <i class="search_icons"></i><span>Search</span></button>
                            </form>
                        </div>
                        <?php if (!$popular_searches->isEmpty()) { ?>
                            <div class="popular_searches">
                                <span class="label">Popular Searches</span>
                                <?php foreach ($popular_searches as $popularSearch) { ?>
                                    <a href="<?= asset("search?cat=" . $popularSearch->id) ?>"><?= $popularSearch->title ?></a>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div> <!-- col -->
                </div> <!-- row --> 
            </div> <!-- container -->
        </div> <!-- top_musicians_section section -->

        <div class="top_events_section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="section_title_medium text-uppercase"><span class="highlight"><strong>Top Teaching Studios </strong></span></h3>
                    </div>
                    <?php
                    if (isset($top_studios) && count($top_studios) > 0) {
                        foreach ($top_studios as $val) {
                            ?>
                            <?php
                            $studio_pic = asset('public/images/teaching_studios/pic_demo.jpg');
                            if ($val->pic) {
                                $studio_pic = asset('public/images/' . $val->pic);
                            }
                            ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 mb-3">
                                <div class="group-box">
                                    <div class="group_image" style="background-image: url(<?= $studio_pic ?>)" onclick="window.location.href = '<?= asset('teaching_studio_time_line/' . $val->id) ?>';" style="cursor: pointer;">
                                        <span class="label">
                                            <?php
                                            if (!$val->getSelectedCategories->isEmpty()) {
                                                $getSelectedArtistTypesCount = $val->getSelectedCategories->count();

                                                if ($getSelectedArtistTypesCount <= 2) {
                                                    $i = 1;
                                                    foreach ($val->getSelectedCategories as $selectedArtistType) {
                                                        echo $selectedArtistType->getCategory->title;
                                                        if ($getSelectedArtistTypesCount > $i)
                                                            echo ', ';
                                                        $i++;
                                                    }
                                                } else {
                                                    $i = 1;
                                                    foreach ($val->getSelectedCategories as $selectedArtistType) {
                                                        echo $selectedArtistType->getCategory->title;
                                                        if ($i < 2) {
                                                            echo ', ';
                                                        } else {
                                                            echo ' ...';
                                                            break;
                                                        }
                                                        $i++;
                                                    }
                                                }
                                            } else {
                                                ?>
                                                N/A
                                            <?php } ?>

                                        </span>
                                    </div> <!-- group image -->
                                    <div class="group_body">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0"><a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="text-semibold text_darkblue"><?= $val->name ?></a></h6>
                                                <div class="rating_reviews">
                                                    <div class="star-ratings-sprite-gray">
                                                        <span style="width: <?= $val->rating_percentage ? $val->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                                                    </div>
                                                    <span class="reviews text_grey">(<?= $val->number_of_reviews ? $val->number_of_reviews : '0' ?> Reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                        <div class="text">
                                            <p>
                                                <?php
                                                $studio_description = $val->description;
                                                if (strlen($studio_description) > 100) {
                                                    $studio_description = substr($studio_description, 0, 100) . '...';
                                                }
                                                echo $studio_description;
                                                ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <span class="text-dark d-md-block"><strong>LOCATION</strong></span>
                                                <span class="text_grey">
                                                    <?php
                                                    $studio_location = $val->location;
                                                    if (strlen($studio_location) > 20) {
                                                        $studio_location = substr($studio_location, 0, 20) . '...';
                                                    }
                                                    echo $studio_location;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <span class="text-dark d-md-block"><strong>Price</strong></span>
                                                <?php
                                                $unit = $val->unit->title;
                                                if ($val->unit->title == 'hour') {
                                                    $unit = 'hr';
                                                }
                                                ?>
                                                <div class="text_grey font-16"> <strong class="text_green">$<?= $val->price ?></strong> / <?= $val->per_unit . ' ' . $unit ?></div>
                                            </div>
                                        </div>
                                        <div class="d-flex buttons_group">
                                            <a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                                            <a href="<?= asset('login') ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                        </div>
                                    </div> <!-- group body -->
                                </div> <!-- group box -->
                            </div>
                        <?php } ?>
                        <div class="col-12 text-center">
                            <a href="<?= asset('search?search_type=teaching_studios') ?>" class="btn btn-round btn-red">More to Explore</a>
                        </div> <!-- col 4 -->
                    <?php } else { ?>
                        <div class="col-12 text-center">
                            <p>No teaching studios found.</p>
                        </div>
                    <?php } ?>
                    <!-- <div class="col-12 text-center">
                         <a href="#" class="btn btn-round btn-red">More to Explore</a>
                     </div>  col 4 -->
                </div> <!-- row --> 
            </div> <!-- container -->
        </div>

        <div class="top_events_section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="section_title_medium text-uppercase"><span class="highlight"><strong>Top Accompanists </strong></span></h3>
                    </div>
                    <?php
                    if (isset($top_accompanists) && count($top_accompanists) > 0) {
                        foreach ($top_accompanists as $accompanist) {
                            ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 mb-3">
                                <div class="teaching-class-box">
                                    <?php
                                    $pic = asset('public/images/profile_pics/demo.png');
                                    if ($accompanist->pic) {
                                        $pic = asset('public/images/' . $accompanist->pic);
                                    }
                                    ?>
                                    <div class="class_image" style="background-image: url(<?= $pic ?>)" onclick="window.location.href = '<?= asset('accompanist_time_line/' . $accompanist->id) ?>';" style="cursor: pointer;">
                                        <span class="label">
                                            <?php
                                            if (!$accompanist->getSelectedCategories->isEmpty()) {
                                                $getSelectedArtistTypesCount = $accompanist->getSelectedCategories->count();

                                                if ($getSelectedArtistTypesCount <= 2) {
                                                    $i = 1;
                                                    foreach ($accompanist->getSelectedCategories as $selectedArtistType) {
                                                        echo $selectedArtistType->getCategory->title;
                                                        if ($getSelectedArtistTypesCount > $i)
                                                            echo ', ';
                                                        $i++;
                                                    }
                                                } else {
                                                    $i = 1;
                                                    foreach ($accompanist->getSelectedCategories as $selectedArtistType) {
                                                        echo $selectedArtistType->getCategory->title;
                                                        if ($i < 2) {
                                                            echo ', ';
                                                        } else {
                                                            echo ' ...';
                                                            break;
                                                        }
                                                        $i++;
                                                    }
                                                }
                                            } else {
                                                ?>
                                                N/A
                                            <?php } ?>

                                        </span>
                                    </div> 
                                    <div class="class_body">
                                        <div class="d-flex">
                                            <div>
                                                <h4 class="mb-0"><a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="text-semibold text_darkblue"><?= $accompanist->name ?></a></h4>
                                                <div class="rating_reviews">
                                                    <div class="star-ratings-sprite-gray">
                                                        <span style="width: <?= $accompanist->rating_percentage ? $accompanist->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                                                    </div>
                                                    <span class="reviews text_grey">(<?= $accompanist->number_of_reviews ? $accompanist->number_of_reviews : '0' ?> Reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                        <div class="text">
                                            <p>
                                                <?php
                                                $studio_description = $accompanist->description;
                                                if (strlen($studio_description) > 100) {
                                                    $studio_description = substr($studio_description, 0, 100) . '...';
                                                }
                                                echo $studio_description;
                                                ?>
                                            </p>
                                        </div>
                                        <div class="row class_info">
                                            <div class="col-12 col-sm-6">
                                                <div class="text_aqua text-semibold text-uppercase">Location</div>
                                                <p class="text_grey font-18 mb-0">
                                                    <?php
                                                    $studio_location = $accompanist->location;
                                                    if (strlen($studio_location) > 20) {
                                                        $studio_location = substr($studio_location, 0, 20) . '...';
                                                    }
                                                    echo $studio_location;
                                                    ?>
                                                </p>
                                            </div>
                                            <div class="col-12 col-sm-6">
                                                <?php
                                                $unit = $accompanist->unit->title;
                                                if ($accompanist->unit->title == 'hour') {
                                                    $unit = 'hr';
                                                }
                                                ?>
                                                <div class="text_aqua text-semibold text-uppercase">Price</div>
                                                <p class="text_grey font-18 mb-0">$<?= $accompanist->price ?></strong> / <?= $accompanist->per_unit . ' ' . $unit ?></p>
                                            </div>
                                        </div>
                                        <div class="d-flex buttons_group">
                                            <a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                                            <?php if ($accompanist->allow_booking) { ?>
                                                <?php if ($accompanist->admin_id != Auth::id()) { ?>
                                                    <?php
                                                    if (Auth::user()) {
                                                        if (Auth::user()->type == 'user') {
                                                            ?>
                                                            <a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="<?= asset('login') ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-12 text-center">
                            <a href="<?= asset('search?search_type=accompanists') ?>" class="btn btn-round btn-red">More to Explore</a>
                        </div> <!-- col 4 -->
                    <?php } else { ?>
                        <div class="col-12 text-center">
                            <p>No accompanists found.</p>
                        </div>
                    <?php } ?>
                    <!-- <div class="col-12 text-center">
                         <a href="#" class="btn btn-round btn-red">More to Explore</a>
                     </div>  col 4 -->
                </div> <!-- row --> 
            </div> <!-- container -->
        </div>

        <div class="top_events_section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="section_title_medium text-uppercase"><span class="highlight"><strong>Top Event Services </strong></span></h3>
                    </div>
                    <?php
                    if (isset($top_groups) && count($top_groups) > 0) {
                        foreach ($top_groups as $group) {
                            ?>
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 mb-3">
                                <div class="group-box">
                                    <?php
                                    $studio_pic = asset('public/images/profile_pics/demo.png');
                                    if ($group->pic) {
                                        $studio_pic = asset('public/images/' . $group->pic);
                                    }
                                    ?>
                                    <div class="group_image" style="background-image: url(<?= $studio_pic ?>)">
                                        <span class="label">
                                            <?= $group->getCategory ? $group->getCategory->title : '' ?>
                                        </span>
                                    </div> <!-- group image -->
                                    <div class="group_body">                                    

                                        <div class="d-flex align-items-center">
                                            <div>
                                                <h6 class="mb-0"><a href="<?= asset('group_time_line/' . $group->id) ?>" class="text-semibold text_darkblue"><?= $group->name ?></a></h6>
                                                <div class="rating_reviews">
                                                    <div class="star-ratings-sprite-gray">
                                                        <span style="width: <?= $group->rating_percentage ? $group->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                                                    </div>
                                                    <span class="reviews text_grey">(<?= $group->number_of_reviews ? $group->number_of_reviews : '0' ?> Reviews)</span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                        <div class="text">
                                            <p>
                                                <?php
                                                $studio_description = $val->description;
                                                if (strlen($studio_description) > 100) {
                                                    $studio_description = substr($studio_description, 0, 100) . '...';
                                                }
                                                echo $studio_description;
                                                ?>
                                            </p>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6 col-sm-12">
                                                <span class="text-dark d-md-block"><strong>LOCATION</strong></span>
                                                <span class="text_grey">
                                                    <?php
                                                    $group_location = $group->location;
                                                    if (strlen($group_location) > 50) {
                                                        $group_location = substr($group_location, 0, 50) . '...';
                                                    }
                                                    echo $group_location;
                                                    ?>
                                                </span>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <span class="text-dark d-md-block"><strong>Team Members</strong></span>
                                                <span class="text_grey"><?= $group->approvedMembers->count() ?></span>
                                            </div>
                                        </div>
                                        <div class="d-flex buttons_group">
                                            <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                                            <!--<a href="<?= asset('login') ?>" class="btn btn-round btn-blue">Book Now</a>-->

                                            <?php if ($group->allow_booking) { ?>
                                                <?php if ($group->admin_id != Auth::id()) { ?>
                                                    <?php
                                                    if (Auth::user()) {
                                                        if (Auth::user()->type == 'user') {
                                                            ?>
                                                            <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                                            <?php
                                                        }
                                                    } else {
                                                        ?>
                                                        <a href="<?= asset('login') ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                                    <?php } ?>
                                                <?php } ?>
                                            <?php } ?>

                                        </div>

                                    </div> <!-- group body -->
                                </div> <!-- group box -->
                            </div>
                        <?php } ?>
                        <div class="col-12 text-center">
                            <a href="<?= asset('search?search_type=groups') ?>" class="btn btn-round btn-red m-3">More to Explore</a>
                        </div> <!-- col 4 -->
                    <?php } else { ?>
                        <div class="col-12 text-center">
                            <p>No groups found.</p>
                        </div>
                    <?php } ?>
                    <!-- <div class="col-12 text-center">
                         <a href="#" class="btn btn-round btn-red">More to Explore</a>
                     </div>  col 4 -->
                </div> <!-- row --> 
            </div> <!-- container -->
        </div>  

        <?php if (isset($top_musican) && count($top_musican) > 0) { ?>
            <div class="top_musicians_section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <h3 class="section_title_medium text-uppercase"><span class="highlight"><strong>Top Musicians </strong></span> Community</h3>
                        </div>
                        <?php foreach ($top_musican as $val) {
                            ?>
                            <div class="col-lg-4 col-sm-6">
                                <div class="musician">  
                                    <a href="<?= asset('profile_timeline/' . $val['id']) ?>">
                                        <?php
                                        $cover = asset('public/images/profile_pics/cover_photo_demo.jpg');
                                        if ($val['cover_photo']) {
                                            $cover = asset('public/images/' . $val['cover_photo']);
                                        }
                                        ?>
                                        <div class="image" style="background-image: url(<?= $cover ?>)">
                                        </div>
                                        <div class="overlay">
                                            <span class="cat">
                                                <?php
                                                if (!$val->getSelectedCategories->isEmpty()) {
                                                    $getSelectedArtistTypesCount = $val->getSelectedCategories->count();

                                                    if ($getSelectedArtistTypesCount <= 2) {
                                                        $i = 1;
                                                        foreach ($val->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($getSelectedArtistTypesCount > $i)
                                                                echo ', ';
                                                            $i++;
                                                        }
                                                    } else {
                                                        $i = 1;
                                                        foreach ($val->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($i < 2) {
                                                                echo ', ';
                                                            } else {
                                                                echo ' ...';
                                                                break;
                                                            }
                                                            $i++;
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    N/A
                                                <?php } ?>
                                            </span>
                                            <div class="musician_info">
                                                <?php
                                                $photo = getUserImage($val['photo'], $val['social_photo'], $val['gender']);
                                                ?>
                                                <span class="bg_image_round" style="background-image: url(<?= $photo ?>)"></span>
                                                <div class="meta">
                                                    <p class="name"><?= $val['first_name'] . ' ' . $val['last_name'] ?></p>
                                                    <!--                                                    <div class="rating_reviews">
                                                                                                            <div class="star-ratings-sprite">
                                                                                                                <span style="width: <?= $val['rating_percentage'] ? $val['rating_percentage'] : '0' ?>%;" class="star-ratings-sprite-rating"></span>
                                                                                                            </div>
                                                                                                            <span class="reviews text_grey">(<?= $val['number_of_reviews'] ? $val['number_of_reviews'] : '0' ?> Reviews)</span>
                                                                                                        </div>-->
                                                </div>
                                            </div>
                                        </div> <!-- overlay -->
                                    </a>
                                </div> <!-- musician -->
                            </div>  
                        <?php } ?>
                        <div class="col-12 text-center">
                            <a href="<?= asset('search?search_type=musicians') ?>" class="btn btn-round btn-red">More to Explore</a>
                        </div> <!-- col 4 -->
                    </div> <!-- row --> 
                </div> <!-- container -->
            </div> <!-- top musicians section -->
        <?php } ?>

        <div class="testimonials_section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h3 class="section_title_medium text-uppercase"><span class="highlight"><strong>TESTIMONIALS </strong></span></h3>
                        <div class="subtitle">
                            <p>This Musician community gain fruitful feedback after providing the best<br/> music services. </p>                                                    
                        </div>
                    </div>
                </div> <!-- row -->

                <?php if (isset($top_testimonials) && count($top_testimonials) > 0) { ?>
                    <div class="owl-carousel testimonial_carousel owl-theme">
                        <?php
                        foreach ($top_testimonials as $val) {
                            $testmonialUser = $val->getUser;
                            ?>
                            <?php
                            $cover = asset('public/images/profile_pics/cover_photo_demo.jpg');
                            if ($testmonialUser->cover_photo) {
                                $cover = asset('public/images/' . $testmonialUser->cover_photo);
                            }
                            ?>
                            <div class="item">
                                <div class="testimonial_wrap">
                                    <div class="image" style="background-image: url(<?= $cover ?>)">
                                        <div class="overlay">
                                            <span class="label">
                                                <?php
                                                if (!$testmonialUser->getSelectedCategories->isEmpty()) {
                                                    $getSelectedArtistTypesCount = $testmonialUser->getSelectedCategories->count();

                                                    if ($getSelectedArtistTypesCount <= 2) {
                                                        $i = 1;
                                                        foreach ($testmonialUser->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($getSelectedArtistTypesCount > $i)
                                                                echo ', ';
                                                            $i++;
                                                        }
                                                    } else {
                                                        $i = 1;
                                                        foreach ($testmonialUser->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($i < 2) {
                                                                echo ', ';
                                                            } else {
                                                                echo ' ...';
                                                                break;
                                                            }
                                                            $i++;
                                                        }
                                                    }
                                                } else {
                                                    ?>
                                                    N/A
                                                <?php } ?>
                                            </span>
                                            <div class="info">
                                                <div class="d-flex align-items-center">
                                                    <?php
                                                    $pic = asset('public/images/profile_pics/demo.png');
                                                    if ($testmonialUser->photo) {
                                                        $pic = asset('public/images/' . $testmonialUser->photo);
                                                    }
                                                    ?>
                                                    <a href="<?= asset('profile_timeline/' . $testmonialUser->id) ?>">
                                                        <span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $pic ?>)"></span>
                                                    </a>
                                                    <span style="color: #fff;">
                                                        <a href="<?= asset('profile_timeline/' . $testmonialUser->id) ?>" class="text-white">
                                                            <?= $testmonialUser->first_name . ' ' . $testmonialUser->last_name ?>
                                                        </a>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- image -->
                                    <div class="testimonial_body">
                                        <div class="testimonial_text">
                                            <p>
                                                "<?php
                                                $review = $val->review;
                                                if (strlen($review) > 100) {
                                                    $review = substr($review, 0, 100) . '...';
                                                }
                                                ?>
                                                <?= $review ?>"
                                            </p>
                                        </div>
                                        <div class="testimonial_meta">
                                            <?php
                                            $pic = asset('public/images/profile_pics/demo.png');
                                            if ($val->getReviewedByUser->photo) {
                                                $pic = asset('public/images/' . $val->getReviewedByUser->photo);
                                            }
                                            ?>
                                            <a href="<?= asset('profile_timeline/' . $val->getReviewedByUser->id) ?>">
                                                <span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $pic ?>)"></span>
                                            </a>
                                            <div>Review By</div>
                                            <div>
                                                <strong class="text-black">
                                                    <a href="<?= asset('profile_timeline/' . $val->getReviewedByUser->id) ?>" class="text-black">
                                                        <?= $val->getReviewedByUser->first_name . ' ' . $val->getReviewedByUser->last_name ?>
                                                    </a>
                                                </strong>
                                            </div>
                                        </div>
                                    </div> <!-- image -->
                                </div>
                            </div> <!-- item -->
                        <?php } ?>
                    </div>    
                <?php } else { ?>
                    <div class="col-12 text-center">
                        <p>No testimonials found.</p>
                    </div>
                <?php } ?>
            </div> <!-- container -->
        </div> <!-- top events section -->

        <div class="join_us_section text-center">
            <div class="container-fluid padding_fluid">
                <div class="row">
                    <div class="col-12">
                        <h2 class="section_title">Why you have to <span class="highlight"><strong>Join Right Now?</strong></span></h2>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Discover favorite musicians</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Follow musician wall</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="text_block">
                            <h3><strong>Book for special events</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="join_btns_group">
                            <a href="<?= asset('register') ?>" class="btn btn-round btn-white">Join for free</a>
                        </div>
                    </div>
                </div> <!-- row --> 

            </div> <!-- container -->
        </div> <!-- join us section -->

        <footer class="footer">
            <div class="container-fluid padding_fluid">
                <div class="row">
                    <div class="col-lg-5 col-md-12">
                        <div class="widget_about">
                            <h3><strong>Musician .inc</strong></h3>
                            <p>Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua.</p>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-5 col-md-12 ml-auto">                         
                        <h4><strong>FIND BY</strong></h4>
                        <ul class="footer_quick_links clearfix">
                            <li><a href="#"> About Us</a></li>
                            <li><a href="#"> Contact Us </a></li>
                            <li><a href="#"> Help & Support </a></li>
                            <li><a href="#"> Terms & Condition </a></li>
                        </ul>                        
                    </div> <!-- col -->
                </div> <!-- row -->
                <div class="row">
                    <div class="col-12">
                        <div class="divider"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-sm-6">
                        <div class="copyright">
                            <p class="pb-0 my-0">Designed By CodingPixel © All Rights Reserved - 2018</p>
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6">
                        <ul class="social_media">
                            <li> <a href="#"> <i class="fas fa-rss"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-facebook-f"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-soundcloud"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-twitter"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-google-plus-g"></i> </a> </li>
                            <li> <a href="#"> <i class="fab fa-vimeo-v"></i> </a> </li>
                        </ul>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </footer>
        <div class="menu_overlay"></div>
        <?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>
<script>
    $('#header_filter').validate({
        rules: {
            cat: {
                required: true
            }
        },
        messages: {
            cat: {
                required: "Required *"
            }
        }
    });
</script>

