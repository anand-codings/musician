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
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <?php include resource_path('views/includes/musician_profile_sidebar.php'); ?>
                </div> <!-- col -->
                <div class="col-lg-9 col-md-12">
                    <?php include resource_path('views/includes/profile_nav_tabs.php'); ?>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade" id="p_timeline" role="tabpanel" aria-labelledby="timeline">
                        </div> <!-- tab timeline -->

                        <div class="tab-pane fade active show" id="p_services" role="tabpanel" aria-labelledby="services">
                            <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="timeline-tab" data-toggle="tab" href="#gigs" role="tab" aria-controls="nav-timeline" aria-selected="true">
                                    Gigs
                                </a>
                                <a class="nav-item nav-link" id="services-tab" data-toggle="tab" href="#event_group" role="tab" aria-controls="nav-services" aria-selected="false">
                                    Event Services
                                </a>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="gigs" role="tabpanel" aria-labelledby="services">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Events Services list</h4>
                                    <ul class="un_style gigs_list">
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="gig_wrap">
                                                <div class="gig_title">
                                                    <a href="#">Perfessional Jazz & Classic Wedding Ceremeny Pianist</a>
                                                </div>
                                                <div class="gig_info d-flex">
                                                    <div class="">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Location </div>
                                                        <div class="text_grey font-16"> Los Angles </div>
                                                    </div>
                                                    <div class="ml-auto">
                                                        <div class="text_aqua font-weight-bold text-uppercase"> Price </div>
                                                        <div class="text_grey font-16"> <strong class="text_green">$599</strong> / Half Hour </div>
                                                    </div>
                                                </div>
                                                <div class="gig_body">
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. </p>
                                                </div>
                                                <div class="gig_btn">
                                                    <a href="#" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking"> <i class="s_icon ic_booking white"></i> Book Now</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div> <!-- tab services -->
                                <div class="tab-pane fade" id="event_group" role="tabpanel" aria-labelledby="services">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Groups list</h4>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="group-box">
                                                <div class="group_image" style="background-image: url(<?php echo asset('userassets/images/groupimage.jpg') ?>)">
                                                    <ul class="un_style no_icon action_dropdown float-right">                                
                                                        <li class="dropdown">
                                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-flag"></i> Report</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> <!-- group image -->
                                                <div class="group_body">
                                                    <div class="d-flex">
                                                        <h4 class="mb-0"><a href="#" class="text-semibold text_darkblue">MozART Group</a></h4>
                                                        <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                                    </div>                                        
                                                    <span class="text_grey text-semibold font-16"><i class="fas fa-map-marker-alt"></i> New York</span>
                                                    <hr>
                                                    <span class="text_grey font-weight-bold mb-2 d-block font-14">Event Services Members</span>
                                                    <ul class="group_members_list nav align-items-center">
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic_lg.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic1.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_2.jpg') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic4.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_4.jpg') ?>" alt=""></li>
                                                        <li class="ml-2"> <a href="#" class="font-weight-bold text-uppercase font-14 text_aqua"><u>6 Others</u></a></li>
                                                    </ul>
                                                    <a href="#" class="btn btn_aqua btn-round font-weight-normal"> <i class="s_icon ic_booking white mr-2" style="margin-top: -3px"></i>Book Now</a>
                                                </div> <!-- group body -->
                                            </div> <!-- group box -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="group-box">
                                                <div class="group_image" style="background-image: url(<?php echo asset('userassets/images/groupimage.jpg') ?>)">
                                                    <ul class="un_style no_icon action_dropdown float-right">                                
                                                        <li class="dropdown">
                                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-flag"></i> Report</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> <!-- group image -->
                                                <div class="group_body">
                                                    <div class="d-flex">
                                                        <h4 class="mb-0"><a href="#" class="text-semibold text_darkblue">MozART Group</a></h4>
                                                        <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                                    </div>                                        
                                                    <span class="text_grey text-semibold font-16"><i class="fas fa-map-marker-alt"></i> New York</span>
                                                    <hr>
                                                    <span class="text_grey font-weight-bold mb-2 d-block font-14">Group Members</span>
                                                    <ul class="group_members_list nav align-items-center">
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic_lg.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic1.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_2.jpg') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic4.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_4.jpg') ?>" alt=""></li>
                                                        <li class="ml-2"> <a href="#" class="font-weight-bold text-uppercase font-14 text_aqua"><u>6 Others</u></a></li>
                                                    </ul>
                                                    <a href="#" class="btn btn_aqua btn-round font-weight-normal"> <i class="s_icon ic_booking white mr-2" style="margin-top: -3px"></i>Book Now</a>
                                                </div> <!-- group body -->
                                            </div> <!-- group box -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="group-box">
                                                <div class="group_image" style="background-image: url(<?php echo asset('userassets/images/groupimage.jpg') ?>)">
                                                    <ul class="un_style no_icon action_dropdown float-right">                                
                                                        <li class="dropdown">
                                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-flag"></i> Report</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> <!-- group image -->
                                                <div class="group_body">
                                                    <div class="d-flex">
                                                        <h4 class="mb-0"><a href="#" class="text-semibold text_darkblue">MozART Group</a></h4>
                                                        <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                                    </div>                                        
                                                    <span class="text_grey text-semibold font-16"><i class="fas fa-map-marker-alt"></i> New York</span>
                                                    <hr>
                                                    <span class="text_grey font-weight-bold mb-2 d-block font-14">Group Members</span>
                                                    <ul class="group_members_list nav align-items-center">
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic_lg.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic1.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_2.jpg') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic4.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_4.jpg') ?>" alt=""></li>
                                                        <li class="ml-2"> <a href="#" class="font-weight-bold text-uppercase font-14 text_aqua"><u>6 Others</u></a></li>
                                                    </ul>
                                                    <a href="#" class="btn btn_aqua btn-round font-weight-normal"> <i class="s_icon ic_booking white mr-2" style="margin-top: -3px"></i>Book Now</a>
                                                </div> <!-- group body -->
                                            </div> <!-- group box -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="group-box">
                                                <div class="group_image" style="background-image: url(<?php echo asset('userassets/images/groupimage.jpg') ?>)">
                                                    <ul class="un_style no_icon action_dropdown float-right">                                
                                                        <li class="dropdown">
                                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </a>
                                                            <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                <a class="dropdown-item" href="#"><i class="fas fa-copy"></i> Copy</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                <a class="dropdown-item" href="#"><i class="fas fa-flag"></i> Report</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div> <!-- group image -->
                                                <div class="group_body">
                                                    <div class="d-flex">
                                                        <h4 class="mb-0"><a href="#" class="text-semibold text_darkblue">MozART Group</a></h4>
                                                        <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                                    </div>                                        
                                                    <span class="text_grey text-semibold font-16"><i class="fas fa-map-marker-alt"></i> New York</span>
                                                    <hr>
                                                    <span class="text_grey font-weight-bold mb-2 d-block font-14">Group Members</span>
                                                    <ul class="group_members_list nav align-items-center">
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic_lg.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic1.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_2.jpg') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/profile_pic4.png') ?>" alt=""></li>
                                                        <li><img class="align-self-center rounded-circle" src="<?php echo asset('userassets/images/musician_4.jpg') ?>" alt=""></li>
                                                        <li class="ml-2"> <a href="#" class="font-weight-bold text-uppercase font-14 text_aqua"><u>6 Others</u></a></li>
                                                    </ul>
                                                    <a href="#" class="btn btn_aqua btn-round font-weight-normal"> <i class="s_icon ic_booking white mr-2" style="margin-top: -3px"></i>Book Now</a>
                                                </div> <!-- group body -->
                                            </div> <!-- group box -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- tab Group -->
                            </div> <!-- inner tab content -->
                        </div> <!-- tab services -->

                        <div class="tab-pane fade" id="p_media" role="tabpanel" aria-labelledby="media">

                            <!-- inner tab media Start -->
                            <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                                <a class="nav-item nav-link active" id="media_photo_btn" data-toggle="tab" href="#media_photo_tab" role="tab"> Photos </a>
                                <a class="nav-item nav-link" id="media_video_btn" data-toggle="tab" href="#media_video_tab" role="tab"> Videos </a>
                                <a class="nav-item nav-link" id="media_audio_btn" data-toggle="tab" href="#media_audio_tab" role="tab"> Audio </a>
                            </div>

                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade active show" id="media_photo_tab">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Photos</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="un_style clearfix photo_media_list">
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/gallerythumbnail_1.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/post_img.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/groupimage2.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/gallerythumbnail_1.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/post_img.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/groupimage2.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/gallerythumbnail_1.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/post_img.jpg') ?>)"></div></a>
                                                </li>
                                                <li><a href="#"><div class="photo_box" style="background-image:url(<?php echo asset('userassets/images/groupimage2.jpg') ?>)"></div></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> <!-- tab Photo -->
                                <div class="tab-pane fade" id="media_video_tab">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Videos</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="un_style video_media_list">
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/login-bg.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/post_img.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/groupimage2.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/gallerythumbnail_2.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/musician_4.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/groupimage.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/groupimage1.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        <div class="video_box" style="background-image:url(<?php echo asset('userassets/images/gallerythumbnail_1.jpg') ?>)">
                                                            <span class="video_play_icon"></span>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div> <!-- tab Video -->
                                <div class="tab-pane fade" id="media_audio_tab">
                                    <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Audio</h4>
                                    <div class="card">
                                        <div class="card-body">
                                            <ul class="un_style audio_media_list">
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="audio_media_box">
                                                        <span class="icon_audio_music"></span>
                                                        <div class="audio_media_btns">
                                                            <span class="audio_play"></span>
                                                            <span class="audio_stop"></span>
                                                        </div>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>    
                                    </div>
                                </div> <!-- tab Audio -->
                            </div> <!-- inner tab content Media-->
                            <!-- inner tab media END -->

                        </div> <!-- tab media -->

                        <div class="tab-pane fade" id="p_review" role="tabpanel" aria-labelledby="review">
                            <div class="card">
                                <div class="card-header">
                                    <h6 class="card-title d-inline font-weight-bold text-black">Review Kimberly Martin</h6>
                                </div> <!-- card header -->
                                <div class="card-body pt-0">
                                    <div class="rating_reviews clearfix mb-1">
                                        <span class="stars mr-3">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star grey"></i>
                                        </span>
                                        <span class="text-black"> Very Good </span>
                                    </div>
                                    <p>Please include a written review with your rating</p>
                                    <form>
                                        <textarea class="form-control h_140" placeholder="Tell your experience.."></textarea>
                                        <input type="submit" value="Post Review" class="btn btn-round btn-gradient text-semibold btn-lg float-right mt-3">
                                    </form>
                                </div> <!-- card body -->
                            </div> <!-- card -->
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title d-inline text-semibold text_purple_light">Kimberly Ratings</h5>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex flex-column flex-sm-row">
                                        <div class="average_rating text-center align-items-center align-self-center">
                                            <span class="rating">4.7</span>
                                            <span class="reviews">45 reviews</span>
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
                                                    <span class="num"> 20 </span>
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
                                                    <span class="num"> 11 </span>
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
                                                    <span class="num"> 7 </span>
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
                                                    <span class="num"> 5 </span>
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
                                                    <span class="num"> 2 </span>
                                                </div> <!-- progressbar -->
                                            </div> <!-- d-flex -->
                                        </div> <!-- profile_rating_progress -->
                                    </div> <!-- d flex -->
                                </div> <!-- card body -->
                            </div> <!--card -->

                            <div class="card">
                                <div class="card-body">
                                    <ul class="reviews_list un_style">
                                        <li class="pt-0">
                                            <div class="review_header">
                                                <div class="media align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img class="align-self-center rounded-circle user_image" src="<?php echo asset('userassets/images/avatar.png') ?>" alt="">
                                                        <div class="media-body">
                                                            <a href="#" class="u_name">Nick Wale</a>
                                                            <div class="rating_reviews">
                                                                <span> reviewed </span>
                                                                <span class="stars">
                                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                </span>
                                                                <span class="reviews"> 5.0</span>
                                                            </div> 
                                                            <span class="text_grey font-13 d-block d-sm-none">Today - 3:56 AM</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex ml-auto align-items-center">
                                                        <span class="date_time d-none d-sm-block">Today - 3:56 AM</span>
                                                        <ul class="un_style no_icon action_dropdown float-right">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </a>
                                                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- media -->
                                            </div>
                                            <div class="review_body">Pianist Frank Dupree delighted audiences on his UK debut with the London Philharmonic Orchestra on Saturday 21 October, performing Beethoven’s Piano Concerto No. 3 at London’s Royal Festival Hall. Peter Reed (Classical Source) was full of praise, describing the concert as “thrilling” and “unforgettable”, but he reserved his highest praise for the young German pianist, writing..
                                            </div>
                                        </li>
                                    </ul> <!-- reviews list -->
                                </div> <!-- card body -->
                            </div> <!-- card -->

                            <div class="card">
                                <div class="card-body">
                                    <ul class="reviews_list un_style">
                                        <li class="pt-0">
                                            <div class="review_header">
                                                <div class="media align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img class="align-self-center rounded-circle user_image" src="<?php echo asset('userassets/images/avatar.png') ?>" alt="">
                                                        <div class="media-body">
                                                            <a href="#" class="u_name">Nick Wale</a>
                                                            <div class="rating_reviews">
                                                                <span> reviewed </span>
                                                                <span class="stars">
                                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                </span>
                                                                <span class="reviews"> 5.0</span>
                                                            </div> 
                                                            <span class="text_grey font-13 d-block d-sm-none">Today - 3:56 AM</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex ml-auto align-items-center">
                                                        <span class="date_time d-none d-sm-block">Today - 3:56 AM</span>
                                                        <ul class="un_style no_icon action_dropdown float-right">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </a>
                                                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- media -->
                                            </div>
                                            <div class="review_body">Pianist Frank Dupree delighted audiences on his UK debut with the London Philharmonic Orchestra on Saturday 21 October, performing Beethoven’s Piano Concerto No. 3 at London’s Royal Festival Hall. Peter Reed (Classical Source) was full of praise, describing the concert as “thrilling” and “unforgettable”, but he reserved his highest praise for the young German pianist, writing..
                                            </div>
                                        </li>
                                    </ul> <!-- reviews list -->
                                </div> <!-- card body -->
                            </div> <!-- card -->

                            <div class="card">
                                <div class="card-body">
                                    <ul class="reviews_list un_style">
                                        <li class="pt-0">
                                            <div class="review_header">
                                                <div class="media align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img class="align-self-center rounded-circle user_image" src="<?php echo asset('userassets/images/avatar.png') ?>" alt="">
                                                        <div class="media-body">
                                                            <a href="#" class="u_name">Nick Wale</a>
                                                            <div class="rating_reviews">
                                                                <span> reviewed </span>
                                                                <span class="stars">
                                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                </span>
                                                                <span class="reviews"> 5.0</span>
                                                            </div> 
                                                            <span class="text_grey font-13 d-block d-sm-none">Today - 3:56 AM</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex ml-auto align-items-center">
                                                        <span class="date_time d-none d-sm-block">Today - 3:56 AM</span>
                                                        <ul class="un_style no_icon action_dropdown float-right">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </a>
                                                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- media -->
                                            </div>
                                            <div class="review_body">Pianist Frank Dupree delighted audiences on his UK debut with the London Philharmonic Orchestra on Saturday 21 October, performing Beethoven’s Piano Concerto No. 3 at London’s Royal Festival Hall. Peter Reed (Classical Source) was full of praise, describing the concert as “thrilling” and “unforgettable”, but he reserved his highest praise for the young German pianist, writing..
                                            </div>
                                        </li>
                                    </ul> <!-- reviews list -->
                                </div> <!-- card body -->
                            </div> <!-- card -->

                            <div class="card">
                                <div class="card-body">
                                    <ul class="reviews_list un_style">
                                        <li class="pt-0">
                                            <div class="review_header">
                                                <div class="media align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img class="align-self-center rounded-circle user_image" src="<?php echo asset('userassets/images/avatar.png') ?>" alt="">
                                                        <div class="media-body">
                                                            <a href="#" class="u_name">Nick Wale</a>
                                                            <div class="rating_reviews">
                                                                <span> reviewed </span>
                                                                <span class="stars">
                                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                </span>
                                                                <span class="reviews"> 5.0</span>
                                                            </div> 
                                                            <span class="text_grey font-13 d-block d-sm-none">Today - 3:56 AM</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex ml-auto align-items-center">
                                                        <span class="date_time d-none d-sm-block">Today - 3:56 AM</span>
                                                        <ul class="un_style no_icon action_dropdown float-right">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </a>
                                                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- media -->
                                            </div>
                                            <div class="review_body">Pianist Frank Dupree delighted audiences on his UK debut with the London Philharmonic Orchestra on Saturday 21 October, performing Beethoven’s Piano Concerto No. 3 at London’s Royal Festival Hall. Peter Reed (Classical Source) was full of praise, describing the concert as “thrilling” and “unforgettable”, but he reserved his highest praise for the young German pianist, writing..
                                            </div>
                                        </li>
                                    </ul> <!-- reviews list -->
                                </div> <!-- card body -->
                            </div> <!-- card -->

                            <div class="card">
                                <div class="card-body">
                                    <ul class="reviews_list un_style">
                                        <li class="pt-0">
                                            <div class="review_header">
                                                <div class="media align-items-center">
                                                    <div class="d-flex align-items-center">
                                                        <img class="align-self-center rounded-circle user_image" src="<?php echo asset('userassets/images/avatar.png') ?>" alt="">
                                                        <div class="media-body">
                                                            <a href="#" class="u_name">Nick Wale</a>
                                                            <div class="rating_reviews">
                                                                <span> reviewed </span>
                                                                <span class="stars">
                                                                    <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                                                                </span>
                                                                <span class="reviews"> 5.0</span>
                                                            </div> 
                                                            <span class="text_grey font-13 d-block d-sm-none">Today - 3:56 AM</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex ml-auto align-items-center">
                                                        <span class="date_time d-none d-sm-block">Today - 3:56 AM</span>
                                                        <ul class="un_style no_icon action_dropdown float-right">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                </a>
                                                                <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item" href="#"><i class="fas fa-share-alt"></i> Share</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- media -->
                                            </div>
                                            <div class="review_body">Pianist Frank Dupree delighted audiences on his UK debut with the London Philharmonic Orchestra on Saturday 21 October, performing Beethoven’s Piano Concerto No. 3 at London’s Royal Festival Hall. Peter Reed (Classical Source) was full of praise, describing the concert as “thrilling” and “unforgettable”, but he reserved his highest praise for the young German pianist, writing..
                                            </div>
                                        </li>
                                    </ul> <!-- reviews list -->
                                </div> <!-- card body -->
                            </div> <!-- card -->

                        </div><!-- tab Reviews -->

                        <div class="tab-pane fade" id="p_studio" role="tabpanel" aria-labelledby="studio">
                            <h4 class="font-weight-bold text_darkblue text-uppercase mb-4"> Teaching Studios</h4>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="teaching-class-box">
                                        <div class="class_image" style="background-image: url(<?php echo asset('userassets/images/groupimage1.jpg'); ?>)">
                                        </div> <!-- group image -->
                                        <div class="class_body">
                                            <div class="d-flex">
                                                <h4 class="mb-0"><a href="<?php echo asset('teachingstudiodetail'); ?>" class="text-semibold text_darkblue">Russell Music Teaching Studios</a></h4>
                                                <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                            </div>
                                            <hr>
                                            <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                            <div class="text">
                                                <p>One-on-One weekly lessons, for everyone, ages 4 and up, in Guitar, voice, piano, violin, bass, ukulele and music theory. applying classical technique to the songs that inspire you!</p>
                                            </div>
                                            <div class="row class_info">
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Location</div>
                                                    <p class="text_grey font-18 mb-0">Los Angles</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Start Date </div>
                                                    <p class="text_grey font-18 mb-0">15-05-2018</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Time</div>
                                                    <p class="text_grey font-18 mb-0">7pm to 9 pm</p>
                                                </div>
                                            </div>
                                        </div> <!-- group body -->
                                    </div> <!-- group box -->
                                </div> <!-- col -->

                                <div class="col-sm-6">
                                    <div class="teaching-class-box">
                                        <div class="class_image" style="background-image: url(<?php echo asset('userassets/images/groupimage1.jpg'); ?>)">
                                        </div> <!-- group image -->
                                        <div class="class_body">
                                            <div class="d-flex">
                                                <h4 class="mb-0"><a href="<?php echo asset('teachingstudiodetail'); ?>" class="text-semibold text_darkblue">Russell Music Teaching Studios</a></h4>
                                                <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                            </div>
                                            <hr>
                                            <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                            <div class="text">
                                                <p>One-on-One weekly lessons, for everyone, ages 4 and up, in Guitar, voice, piano, violin, bass, ukulele and music theory. applying classical technique to the songs that inspire you!</p>
                                            </div>
                                            <div class="row class_info">
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Location</div>
                                                    <p class="text_grey font-18 mb-0">Los Angles</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Start Date </div>
                                                    <p class="text_grey font-18 mb-0">15-05-2018</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Time</div>
                                                    <p class="text_grey font-18 mb-0">7pm to 9 pm</p>
                                                </div>
                                            </div>
                                        </div> <!-- group body -->
                                    </div> <!-- group box -->
                                </div> <!-- col -->

                                <div class="col-sm-6">
                                    <div class="teaching-class-box">
                                        <div class="class_image" style="background-image: url(<?php echo asset('userassets/images/groupimage1.jpg'); ?>)">
                                        </div> <!-- group image -->
                                        <div class="class_body">
                                            <div class="d-flex">
                                                <h4 class="mb-0"><a href="<?php echo asset('teachingstudiodetail'); ?>" class="text-semibold text_darkblue">Russell Music Teaching Studios</a></h4>
                                                <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                            </div>
                                            <hr>
                                            <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                            <div class="text">
                                                <p>One-on-One weekly lessons, for everyone, ages 4 and up, in Guitar, voice, piano, violin, bass, ukulele and music theory. applying classical technique to the songs that inspire you!</p>
                                            </div>
                                            <div class="row class_info">
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Location</div>
                                                    <p class="text_grey font-18 mb-0">Los Angles</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Start Date </div>
                                                    <p class="text_grey font-18 mb-0">15-05-2018</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Time</div>
                                                    <p class="text_grey font-18 mb-0">7pm to 9 pm</p>
                                                </div>
                                            </div>
                                        </div> <!-- group body -->
                                    </div> <!-- group box -->
                                </div> <!-- col -->

                                <div class="col-sm-6">
                                    <div class="teaching-class-box">
                                        <div class="class_image" style="background-image: url(<?php echo asset('userassets/images/groupimage1.jpg'); ?>)">
                                        </div> <!-- group image -->
                                        <div class="class_body">
                                            <div class="d-flex">
                                                <h4 class="mb-0"><a href="<?php echo asset('teachingstudiodetail'); ?>" class="text-semibold text_darkblue">Russell Music Teaching Studios</a></h4>
                                                <span class="ml-auto"><i class="s_icon ic_bookmark_grey"></i></span>
                                            </div>
                                            <hr>
                                            <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                                            <div class="text">
                                                <p>One-on-One weekly lessons, for everyone, ages 4 and up, in Guitar, voice, piano, violin, bass, ukulele and music theory. applying classical technique to the songs that inspire you!</p>
                                            </div>
                                            <div class="row class_info">
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Location</div>
                                                    <p class="text_grey font-18 mb-0">Los Angles</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Start Date </div>
                                                    <p class="text_grey font-18 mb-0">15-05-2018</p>
                                                </div>
                                                <div class="col-4 col-sm-4">
                                                    <div class="text_aqua text-semibold text-uppercase">Time</div>
                                                    <p class="text_grey font-18 mb-0">7pm to 9 pm</p>
                                                </div>
                                            </div>
                                        </div> <!-- group body -->
                                    </div> <!-- group box -->
                                </div> <!-- col -->
                            </div> <!-- row -->                                    
                        </div> <!-- tab Studio -->

                        <div class="tab-pane fade" id="p_about" role="tabpanel" aria-labelledby="about">
                            <div class="box box-shadow no_margin clearfix">
                                <div class="row">
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Category</span> The Pianist
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-calendar-alt"></i> Professional</span> Since 2004
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> New York 
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 about_head_title">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Languages</span> English, French
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-graduation-cap"></i> Education</span>
                                        <ol class="about_list">
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Associate of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                    </div>
                                                </div>
                                                <div class="text_grey font-weight-normal">
                                                    <p>Full Sail University</p> 
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Bachelor of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                    </div>
                                                </div>
                                                <div class="text_grey font-weight-normal">
                                                    <p>The Art Institutes</p> 
                                                </div>
                                            </li>
                                        </ol>
                                        <hr/> 

                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-briefcase"></i> Experience</span>
                                        <ol class="about_list">
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Lorem ipsum dolor sit amet, consectetur adipiscing elit</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                    </div>
                                                </div>
                                                <div class="text_grey font-weight-normal">
                                                    <p>Full Sail University</p> 
                                                </div>
                                            </li>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold">Bachelor of Arts in Music</span>                                                                
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold">2005 - 2007</span>
                                                    </div>
                                                </div>
                                                <div class="text_grey font-weight-normal">
                                                    <p>The Art Institutes</p> 
                                                </div>
                                            </li>
                                        </ol>
                                        <hr/>
                                        <div class="mb-4">
                                            <span class="d-block font-weight-bold text-uppercase mb-1"> <i class="fas fa-user-shield"></i> affiliations</span>
                                            <p>Performing Rights Organization (P.R.O.) USA</p>
                                        </div>
                                        <div class="mb-4">
                                            <span class="d-block font-weight-bold text-uppercase mb-1"> <i class="fas fa-users"></i> Groups</span>
                                            <p>The Clash, MozART Group, The Birthday Party</p>
                                        </div>
                                        <div class="mb-4">
                                            <span class="d-block font-weight-bold text-uppercase mb-1"> Description</span>
                                            <p>Colin Nicholson is a fine classical pianist, music tutor and piano technician. Born in Rothbury and bred in Morpeth, Northumberland, Colin moved to Yorkshire in 1989. After over 25 years, Colin has now returned to Northumberland for good to fulfil his career, in and about the areas of Morpeth, Amble, Warkworth, Alnwick and visit many more North Eastern areas and coastal regions.</p>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- Box -->
                        </div> <!-- about -tab -->

                    </div> <!-- tab content -->
                </div> <!-- col -->
            </div> <!-- row -->
        </div> <!-- container -->
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
    <!-- Booking modal Start -->
    <div class="modal fade" id="modal_eventbooking" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">First & Last Name </label>
                                    <input type="text" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Your Email</label>
                                    <input type="email" placeholder="" class="form-control" />
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Gig Name</label>
                                    <input type="text" placeholder="" class="form-control" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Location</label>
                                    <input type="text" placeholder="" class="form-control" />
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Date</label>
                                    <div class="d-flex">
                                        <input type="text" placeholder="Day" class="form-control mr-2">
                                        <input type="text" placeholder="Month" class="form-control mr-2">
                                        <input type="text" placeholder="Year" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Hours offering</label>
                                    <input type="text" placeholder="0:00" class="form-control" />
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">Price offering</label>
                                    <input type="text" placeholder="$$$" class="form-control" />
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Description</label>
                                    <textarea class="form-control h_140"></textarea>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn_aqua btn-xl text-semibold "> Book Now </button>
                        </div>
                    </form>                        
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Booking modal -->
    <!-- Booking modal END -->        
</body>
</html>

