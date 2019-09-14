<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">

<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>-->

<?php include resource_path('views/includes/top.php'); ?>

<body>
    <?php include resource_path('views/includes/header-timeline.php'); ?>
    <div class="page_create_group">
        <?php
        $coverPhoto = asset('public/images/profile_pics/cover_photo_demo.jpg');
        if ($user->cover_photo) {
            $coverPhoto = asset('public/images/' . $user->cover_photo);
        }
        ?>
        <div id="cover_image_header" class="group_profile_cover_photo" id="cover-pic-div" style="display: none; ">
            <div id="capture"><img class="" id="cover_image" src="<?= $coverPhoto ?>"></div>
            <div class="jwc_btns">
                <input type="button" class="btn btn-info" value="Save" onclick="saveForm()">
                <input type="button" class="btn btn-danger" value="Cancel" onclick="cancelForm()">
            </div>
        </div>
        <div class="container">
            <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $coverPhoto ?>')">
                <div class="overlay_color">

                    <div class="row align-items-center">
                        <div class="col-lg-3 col-sm-4">
                            <div class="edit_user_profile_pic">
                                <?php
                                $image = getUserImage($user->photo, $user->social_photo, $user->gender);
                                ?>
                                <div class="image" id="profile-pic-div" style="background-image:url(<?= $image ?>)"></div>
                                    <ul class="un_style no_icon action_dropdown">
                                        <li class="dropdown">
                                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                            <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                <a class="dropdown-item profile_upload_btn" href="#">
                                                    <input type="file" name="photo" id="upload-profile-pic" accept="image/*" />
                                                    <i class="fas fa-cloud-upload-alt"></i> Upload Photo
                                                </a>
                                                <a class="dropdown-item profile_upload_btn" id="repostion-profile-pic" href="#">
                                                    <i class="fas fa-arrows-alt"></i> Reposition
                                                </a>
                                                <a class="dropdown-item" href="#" id="delete-profile-pic" user-id="<?= $user->id ?>">
                                                    <i class="fas fa-times-circle"></i> Remove
                                                </a>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            <div class="modal" id="upload_profile_pic_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Upload Profile Pic</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-2"></div>
                                                <div class="col-md-8">
                                                    <div id="upload-demo"></div>
                                                    <input type="hidden" id="original_profile_pic">
                                                    <button type="button" id="save_profile_pic" class="btn btn-success btn-block mt-4">Save</button>
                                                </div>
                                                <div class="col-md-2"></div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- col -->
                        <div class="col-lg-6 d-none d-lg-block">
                            <div class="d-flex justify-content-center">
                                <ul class="un_style no_icon action_dropdown update_cover_photo_btn">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                            <i class="fas fa-plus"></i> Change Cover Photo <i class="fas fa-chevron-down"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                            <a class="dropdown-item profile_upload_btn" href="#">
                                                <form id="update_cover_photo" action="<?= asset('update_cover') ?>" method="post" enctype="multipart/form-data" class="">
                                                    <input id="x" type="hidden" name="x" value="">
                                                    <input id="y" type="hidden" name="y" value="">
                                                    <input id="h" type="hidden" name="h" value="">
                                                    <input id="w" type="hidden" name="w" value="">
                                                    <input type="file" name="cover" id="upload-cover-pic" />
                                                    <input id="image_croped" type="hidden" name="image_croped" value="">
                                                    <input id="top" type="hidden" name="top" value="">

                                                    <?= csrf_field() ?>
                                                </form>

                                                <i class="fas fa-cloud-upload-alt"></i> Upload Photo
                                            </a>

                                            <a class="dropdown-item" href="#" id="reposition-cover-pic"><i class="fas fa-arrows-alt"></i> Reposition</a>
                                            <a class="dropdown-item" href="#" id="delete-cover-pic" user-id="<?= $user->id ?>"><i class="fas fa-times-circle"></i> Remove </a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div> <!-- container -->
            </div> <!-- overlay color -->
        </div> <!-- cover photo -->

        <div class="page_timeline">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="search_menu_overlay"></div>
                    <div class="col-lg-3 col-md-12">
                        <div class="custom_booking_side search_sidebar py-3">
                            <span class="search_side_close"></span>
                            <h4 class="text-uppercase mb-3 font-weight-bold font-20 text_darkblue">Personal Information</h4>
                            <!--<form>-->
                            <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <input type="hidden" name="personal_info" value="1">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input required type="text" name="first_name" required value="<?= $user->first_name ?>" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input required type="text" name="last_name" required value="<?= $user->last_name ?>" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Email</label>
                                    <input required type="email" name="email" required value="<?= $user->email ?>" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input required type="text" name="phone" required value="<?= $user->phone ?>" class="form-control">
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-5">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" name="gender" class="custom-control-input" id="male" value="male" <?= $user->gender == 'male' ? 'checked' : '' ?>>
                                                <label class="custom-control-label no-top-padding txt_left" for="male"> Male </label>
                                            </div>
                                        </div> <!-- col6 -->
                                        <div class="col-sm-5">
                                            <div class="custom-control custom-checkbox">
                                                <input type="radio" name="gender" class="custom-control-input" id="female" value="female" <?= $user->gender == 'female' ? 'checked' : '' ?>>
                                                <label class="custom-control-label no-top-padding txt_left" for="female"> Female </label>
                                            </div>
                                        </div> <!-- col6 -->
                                    </div> <!-- row -->
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Date Of Birth</label>
                                    <div class="d-flex">
                                        <input type="text" value="<?= $user->dob ?>" name="dob" class="form-control date-picker-past" readonly>
                                    </div>
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Contact info shown to</label>
                                    <div class="d-flex">
                                        <select type="text" name="contact_info_privacy" class="form-control">
                                            <option value="musician" <?= $user->contact_info_privacy == 'musician' ? 'selected="selected"' : '' ?>>Musician</option>
                                            <option value="following" <?= $user->contact_info_privacy == 'following' ? 'selected="selected"' : '' ?>>Following</option>
                                            <option value="customers" <?= $user->contact_info_privacy == 'customers' ? 'selected="selected"' : '' ?>>Customers</option>
                                        </select>
                                    </div>
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" name="gigs_availability" class="custom-control-input" value="1" id="availability" <?= $user->allow_booking == 1 ? 'checked' : '' ?>>
                                        <label class="custom-control-label no-top-padding txt_left" for="availability"> Would you available for booking? </label>
                                    </div>
                                </div>
                                <div class="form-group text-center mt-4">
                                    <input type="submit" value="Save" class="btn btn-round btn-gradient text-semibold btn-xl">
                                </div><!-- form group -->
                            </form>
                            <!-- form group -->
                            <div class="clearfix"></div>
                            <form id="change_password_mus" class="" action="<?= asset('change_password') ?>" method="post">
                                <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                <h4 class="text-uppercase mb-2 mt-2 font-weight-bold font-20 text_darkblue">Reset Password</h4>
                                <div class="form-group">
                                    <label>Current Password</label>
                                    <input required type="password" name="current_password" placeholder="Current Password" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>New Password</label>
                                    <input id="password" required type="password" name="password" placeholder="New Password" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input required type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control">
                                </div> <!-- form group -->
                                <div class="form-group text-center mt-4">
                                    <input type="submit" value="Save" class="btn btn-round btn-gradient text-semibold btn-xl">
                                </div>
                            </form>
                            <!-- form group -->
                            <!--</form>-->
                        </div> <!-- custom_booking_side -->
                    </div> <!-- col -->

                    <div class="col-lg-9 col-md-12">
                        <div class="edit_profile_title">
                            <h4> <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20">
                                    <path class="cls-1" d="M10,5a1.251,1.251,0,1,0,1.248,1.251A1.253,1.253,0,0,0,10,5h0Zm0,3.75A1.251,1.251,0,0,0,8.746,10v3.75a1.249,1.249,0,0,0,2.5,0V10A1.25,1.25,0,0,0,10,8.748h0ZM10,0A10,10,0,1,0,20,10,10.01,10.01,0,0,0,10,0h0Zm0,18.122A8.124,8.124,0,1,1,18.12,10,8.134,8.134,0,0,1,10,18.122h0Zm0,0" />
                                </svg> About </h4>
                        </div>
                        <div class="clearfix">
                            <span class="mobile_filter_btn edit_profile_btn mb-2"> Edit Profile</span>
                        </div>
                        <div class="w-100"></div>
                        <div class="w-100"></div>
                        <div class="card">
                            <div class="card-body">
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
                                <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_info"><i class="fas fa-edit"></i> Edit </a>
                                <div class="row">
                                    <div class="col-6 col-md-3 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Speciality </span>
                                        <?php
                                        if (!$user->getSelectedCategories->isEmpty()) {
                                            $getSelectedArtistTypesCount = $user->getSelectedCategories->count();
                                            $i = 1;
                                            foreach ($user->getSelectedCategories as $selectedArtistType) {
                                                echo $selectedArtistType->getCategory->title;
                                                if ($getSelectedArtistTypesCount > $i)
                                                    echo ', ';
                                                $i++;
                                            }
                                        } else {
                                            ?>
                                            N/A
                                        <?php } ?>
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-calendar-alt"></i> Professional</span> <?= $user->since ? 'Since ' . $user->since : 'N/A' ?>
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $user->address ? $user->address : 'N/A' ?>
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Languages</span> <?= $user->language ? $user->language : 'N/A' ?>
                                    </div>
                                    <div class="col-6 col-md-3 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-tags"></i> Genre</span> <?= $user->genre ? $user->genre : 'N/A' ?>
                                    </div>
                                </div>
                                <hr />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="mb-2">
                                            <i class="fas fa-graduation-cap"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Education </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_education"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <?php if (!$user->getEducations->isEmpty()) { ?>
                                            <ol class="about_list">
                                                <?php foreach ($user->getEducations as $userEducation) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <span class="font-weight-bold"><?= $userEducation->title ?></span>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <span class="font-weight-bold"><?= $userEducation->start_year . ' - ' . $userEducation->end_year ?></span>
                                                                    </div>
                                                                    <div class="col-sm-7">
                                                                        <span class="trash_info_btn">
                                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal-delete-<?= $userEducation->id ?>"> <i class="fa fa-trash"></i> </a>
                                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal-edit-education-<?= $userEducation->id ?>"> <i class="fa fa-edit"></i> </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text_grey">
                                                            <p><?= $userEducation->institute_name ?></p>
                                                        </div>
                                                    </li>

                                                    <!-- Education Delete Model-->
                                                    <div class="modal fade" id="modal-delete-<?= $userEducation->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="delete_musician_education" action="<?= asset('delete_musician_education') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="education_id" value="<?= $userEducation->id ?>">
                                                                        <div>
                                                                            <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                                                        </div>
                                                                        <div class="mt-3 text-center">
                                                                            <button type="submit" data-id="" class="delete_event btn btn-round btn-gradient btn-xl text-semibold">Yes</button>
                                                                            <button type="button" class="btn btn-round btn_no btn-xl text-semibold ml-1" data-dismiss="modal"> No </button>
                                                                        </div>
                                                                    </form>
                                                                </div> <!-- modal body -->
                                                            </div>
                                                        </div>
                                                    </div> <!-- modal -->
                                                    <!-- Delete modal END -->
                                                    <!-- Edit Education Start modal -->
                                                    <div class="modal fade" id="modal-edit-education-<?= $userEducation->id ?>" tabindex="-1" role="dialog" aria-labelledby="modal_edit_education" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Education</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="education_info" value="1">
                                                                        <input type="hidden" name="education_id" value="<?= $userEducation->id ?>">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold">College/University</label>
                                                                                    <input required type="text" name="institute_name" required value="<?= $userEducation->institute_name ?>" class="form-control" />
                                                                                </div>
                                                                            </div> <!-- col -->
                                                                        </div> <!-- row -->

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold">Degree Title</label>
                                                                                    <input required type="text" name="title" required value="<?= $userEducation->title ?>" class="form-control" />
                                                                                </div> <!-- form-group -->
                                                                            </div> <!-- col -->
                                                                            <div class="col-sm-6">
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label class="font-weight-bold">Start Year</label>
                                                                                            <?php
                                                                                            $currentYear = date("Y");
                                                                                            $oldYear = $currentYear - 50;
                                                                                            ?>
                                                                                            <select required name="start_year" required class="form-control selct2_select" style="width: 100%">
                                                                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                                                                    <option <?= $oldYear == $userEducation->start_year ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div> <!-- form-group -->
                                                                                    </div> <!-- col -->
                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label class="font-weight-bold">End Year</label>
                                                                                            <?php
                                                                                            $currentYear = date("Y");
                                                                                            $oldYear = $currentYear - 50;
                                                                                            ?>
                                                                                            <select required name="end_year" required class="form-control selct2_select" style="width: 100%">
                                                                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                                                                    <option <?= $oldYear == $userEducation->end_year ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div> <!-- form-group -->
                                                                                    </div> <!-- col -->
                                                                                </div> <!-- row -->
                                                                            </div> <!-- col -->
                                                                        </div> <!-- row -->
                                                                        <div class="mt-2 text-center">
                                                                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div> <!-- modal-body-->
                                                            </div> <!-- modal-content-->
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </ol>
                                        <?php } else { ?>
                                            <span class="text_grey">N/A</span>
                                        <?php } ?>
                                        <hr />
                                        <div class="mb-2">
                                            <i class="fas fa-briefcase"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Experience </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_experience"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <?php if (!$user->getExperiences->isEmpty()) { ?>
                                            <ol class="about_list">
                                                <?php foreach ($user->getExperiences as $userExperience) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <span class="font-weight-bold"><?= $userExperience->title ?></span>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row">
                                                                    <div class="col-sm-5">
                                                                        <span class="font-weight-bold"><?= $userExperience->start_year . ' - ' . $userExperience->end_year ?></span>
                                                                    </div>
                                                                    <div class="col-sm-7">
                                                                        <span class="trash_info_btn">
                                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal-delete-experience-<?= $userExperience->id ?>"> <i class="fa fa-trash"></i> </a>
                                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal-edit-experience-<?= $userExperience->id ?>"> <i class="fa fa-edit"></i> </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="text_grey">
                                                            <p><?= $userExperience->institute_name ?></p>
                                                        </div>
                                                    </li>

                                                    <!-- Experience Delete Model-->
                                                    <div class="modal fade" id="modal-delete-experience-<?= $userExperience->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="delete_musician_experience" action="<?= asset('delete_musician_experience') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="experience_id" value="<?= $userExperience->id ?>">
                                                                        <div>
                                                                            <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                                                        </div>
                                                                        <div class="mt-3 text-center">
                                                                            <button type="submit" data-id="" class="delete_event btn btn-round btn-gradient btn-xl text-semibold">Yes</button>
                                                                            <button type="button" class="btn btn-round btn_no btn-xl text-semibold ml-1" data-dismiss="modal"> No </button>
                                                                        </div>
                                                                    </form>
                                                                </div> <!-- modal body -->
                                                            </div>
                                                        </div>
                                                    </div> <!-- modal -->
                                                    <!-- Delete modal END -->
                                                    <!-- Edit Experience Start modal -->
                                                    <div class="modal fade" id="modal-edit-experience-<?= $userExperience->id ?>" tabindex="-1" role="dialog" aria-labelledby="modal_edit_experience" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Experience</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="experience_info" value="1">
                                                                        <input type="hidden" name="experience_id" value="<?= $userExperience->id ?>">
                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold">Company</label>
                                                                                    <input required type="text" name="institute_name" required value="<?= $userExperience->institute_name ?>" class="form-control" />
                                                                                </div>
                                                                            </div> <!-- col -->
                                                                        </div> <!-- row -->

                                                                        <div class="row">
                                                                            <div class="col-sm-6">
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold">Job Title</label>
                                                                                    <input required type="text" name="title" required value="<?= $userExperience->title ?>" class="form-control" />
                                                                                </div> <!-- form-group -->
                                                                            </div> <!-- col -->
                                                                            <div class="col-sm-6">
                                                                                <div class="row">
                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label class="font-weight-bold">Start Year</label>
                                                                                            <?php
                                                                                            $currentYear = date("Y");
                                                                                            $oldYear = $currentYear - 50;
                                                                                            ?>
                                                                                            <select required name="start_year" required class="form-control selct2_select" style="width: 100%">
                                                                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                                                                    <option <?= $oldYear == $userExperience->start_year ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div> <!-- form-group -->
                                                                                    </div> <!-- col -->
                                                                                    <div class="col-sm-6">
                                                                                        <div class="form-group">
                                                                                            <label class="font-weight-bold">End Year</label>
                                                                                            <?php
                                                                                            $currentYear = date("Y");
                                                                                            $oldYear = $currentYear - 50;
                                                                                            ?>
                                                                                            <select required name="end_year" required class="form-control selct2_select" style="width: 100%">
                                                                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                                                                    <option <?= $oldYear == $userExperience->end_year ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                                                                <?php } ?>
                                                                                            </select>
                                                                                        </div> <!-- form-group -->
                                                                                    </div> <!-- col -->
                                                                                </div> <!-- row -->
                                                                            </div> <!-- col -->
                                                                        </div> <!-- row -->
                                                                        <div class="mt-2 text-center">
                                                                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div> <!-- modal-body-->
                                                            </div> <!-- modal-content-->
                                                        </div>
                                                    </div>

                                                <?php } ?>
                                            </ol>
                                        <?php } else { ?>
                                            <span class="text_grey">N/A</span>
                                        <?php } ?>
                                        <hr />
                                        <div class="mb-2">
                                            <i class="fas fa-user-shield"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Affiliation </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_affiliation"><i class="fas fa-plus-circle"></i> Add </a>
                                        </div>
                                        <?php if (!$user->getAffiliations->isEmpty()) { ?>
                                            <ol>
                                                <?php foreach ($user->getAffiliations as $affiliation) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <p><?= $affiliation->union->title ?></p>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <div class="row">
                                                                    <div class="col-sm-5">

                                                                    </div>
                                                                    <div class="col-sm-7">
                                                                        <span class="trash_info_btn">
                                                                            <a href="#" class="text-semibold text_maroon trash" data-toggle="modal" data-target="#modal-delete-affiliation<?= $affiliation->id ?>"> <i class="fa fa-trash"></i> </a>
                                                                            <a href="#" class="text-semibold text_maroon" data-toggle="modal" data-target="#modal-edit-affiliation<?= $affiliation->id ?>"> <i class="fa fa-edit"></i> </a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>

                                                    <!-- Affiliation Delete Model -->
                                                    <div class="modal fade" id="modal-delete-affiliation<?= $affiliation->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Delete</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="delete_musician_education" action="<?= asset('delete_musician_affiliation') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="affiliation_id" value="<?= $affiliation->id ?>">
                                                                        <div>
                                                                            <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                                                        </div>
                                                                        <div class="mt-3 text-center">
                                                                            <button type="submit" data-id="" class="delete_event btn btn-round btn-gradient btn-xl text-semibold">Yes</button>
                                                                            <button type="button" class="btn btn-round btn_no btn-xl text-semibold ml-1" data-dismiss="modal"> No </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--Delete modal END-->
                                                    <!--Edit Affiliation modal-->
                                                    <div class="modal fade" id="modal-edit-affiliation<?= $affiliation->id ?>" tabindex="-1" role="dialog" aria-labelledby="modal-edit-affiliation<?= $affiliation->id ?>" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Affiliation</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <i class="fas fa-times-circle"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post" enctype="multipart/form-data">
                                                                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                                                        <input type="hidden" name="affiliation_info" value="1">
                                                                        <input type="hidden" name="affiliation_id" value="<?= $affiliation->id ?>">
                                                                        <div class="row">
                                                                            <div class="col-sm-12">
                                                                                <div class="form-group">
                                                                                    <label class="font-weight-bold">Union</label>
                                                                                    <select name="union_id" required class="form-control selct2_select" style="width: 100%">
                                                                                        <option value="<?= $affiliation->union_id ?>" selected=""><?= $affiliation->union->title ?></option>
                                                                                        <?php foreach ($unions as $union) { ?>
                                                                                            <option value="<?= $union->id ?>" <?= $affiliation->union_id == $union->id ? 'selected' : '' ?>><?= $union->title ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="mt-2 text-center">
                                                                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            </ol>
                                        <?php } else { ?>
                                            <span class="text_grey">N/A</span>
                                        <?php } ?>
                                        <hr />
                                        <div class="mb-2">
                                            <i class="fas fa-users"></i>
                                            <span class="font-weight-bold text-uppercase mb-2"> Groups </span>
                                        </div>
                                        <?php if (!$user->getGroups->isEmpty()) { ?>
                                            <ol>
                                                <?php foreach ($user->getGroups as $group) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <p><?= $group->name ?></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ol>
                                        <?php } else { ?>
                                            <span class="text_grey">N/A</span>
                                        <?php } ?>
                                        <hr />
                                        <div class="mb-2">
                                            <span class="font-weight-bold text-uppercase mb-2"> Artist’s Bio </span>
                                            <a href="#" class="float-right text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_description"><i class="fas fa-edit"></i> Edit </a>
                                        </div>
                                        <p><?= $user->description ? $user->description : 'N/A' ?></p>
                                    </div>
                                </div>
                                <hr />
                                <div class="form_section">
                                    <h5 class="text-semibold text_maroon">Account Type</h5>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="custom-control custom-radio">
                                                <input onclick="savePrivate('0')" <?php if ($user->is_private == 0) { ?> checked <?php } ?> type="radio" id="ac_public" name="accont_type" value="male" class="custom-control-input">
                                                <label class="custom-control-label" for="ac_public">
                                                    <strong><i class="fa fa-globe-americas"></i> Public</strong><br />
                                                    <p>You’re viewable by everyone on Musician, anyone can follow you & everyone can like or comment on your timeline (unless you block them).</p>
                                                </label>
                                            </div>
                                            
                                            
<!--                                             <div class="custom-control custom-radio">-->
<!--                                                <input onclick="savePrivate('2')" --><?php //if ($user->is_private == 2) { ?><!-- checked --><?php //} ?><!-- type="radio" id="ac_friends" name="accont_type" value="male" class="custom-control-input">-->
<!--                                                <label class="custom-control-label" for="ac_friends">-->
<!--                                                    <strong><i class="fa fa-users"></i> Friends</strong><br />-->
<!--                                                    <p>You’re viewable by only your friends on Musician.</p>-->
<!--                                                </label>-->
<!--                                            </div>-->
                                            
                                            <div class="custom-control custom-radio">
                                                <input onclick="savePrivate('1')" <?php if ($user->is_private == 1) { ?> checked <?php } ?> type="radio" id="ac_private" name="accont_type" value="male" class="custom-control-input">
                                                <label class="custom-control-label" for="ac_private">
                                                    <strong><i class="fa fa-lock"></i> Private</strong><br />
                                                    <p>You show up in search result but others must follow you to view your timeline or interact with it.</p>
                                                </label>
                                            </div>
                                            
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- form section -->

                                <div class="form_section">
                                    <h5 class="text-semibold text_maroon">Email Notification Settings</h5>
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if ($email_setting && $email_setting->on_follow) { ?> checked="" <?php } ?> onchange="saveEmailSending(this, 'on_follow', 'Emailsetting')" type="checkbox" id="email_noti_1" name="email_notification" class="custom-control-input">
                                                    <label class="custom-control-label" for="email_noti_1"> When someone follows me </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if ($email_setting && $email_setting->on_share) { ?> checked="" <?php } ?> onchange="saveEmailSending(this, 'on_share', 'Emailsetting')" type="checkbox" id="email_noti_2" name="email_notification" class="custom-control-input">
                                                    <label class="custom-control-label" for="email_noti_2"> When someone shares my content </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <!--                                    <div class="col-xl-4 col-sm-6">
                                                                                    <div class="form-group">    
                                                                                        <div class="custom-control custom-checkbox">
                                                                                            <input  type="checkbox" id="email_noti_3" name="email_notification" class="custom-control-input">
                                                                                            <label class="custom-control-label" for="email_noti_3"> When someone likes my content </label>
                                                                                        </div>
                                                                                    </div>  form group 
                                                                                </div>  col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if ($email_setting && $email_setting->on_comment) { ?> checked="" <?php } ?> onchange="saveEmailSending(this, 'on_comment', 'Emailsetting')" type="checkbox" id="email_noti_4" name="email_notification" class="custom-control-input">
                                                    <label class="custom-control-label" for="email_noti_4"> When someone comments on my content </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input <?php if ($email_setting && $email_setting->on_message) { ?> checked="" <?php } ?> onchange="saveEmailSending(this, 'on_message', 'Emailsetting')" type="checkbox" id="email_noti_5" name="email_notification" class="custom-control-input">
                                                    <label class="custom-control-label" for="email_noti_5"> When I receive a direct message </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <!--                                    <div class="col-xl-4 col-sm-6">
                                                                                    <div class="form-group">    
                                                                                        <div class="custom-control custom-checkbox">
                                                                                            <input  type="checkbox" id="email_noti_6" name="email_notification" class="custom-control-input">
                                                                                            <label class="custom-control-label" for="email_noti_6"> When someone views my profile </label>
                                                                                        </div>
                                                                                    </div>  form group 
                                                                                </div>  col -->
                                    </div> <!-- row -->
                                </div> <!-- form section -->

                                <div class="form_section">
                                    <h5 class="text-semibold text_maroon">What Other See</h5>
                                    <div class="row">
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input onchange="saveEmailSending(this, 'gender', 'Privacysetting')" <?php if (($privacy_setting && $privacy_setting->gender) || (!$privacy_setting)) { ?> checked="" <?php } ?> type="checkbox" id="what_other_2" name="what_other" class="custom-control-input">
                                                    <label class="custom-control-label" for="what_other_2"> Gender </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input onchange="saveEmailSending(this, 'email', 'Privacysetting')" <?php if (($privacy_setting && $privacy_setting->email) || (!$privacy_setting)) { ?> checked="" <?php } ?> type="checkbox" id="what_other_3" name="what_other" class="custom-control-input">
                                                    <label class="custom-control-label" for="what_other_3"> Email Address </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input onchange="saveEmailSending(this, 'phone', 'Privacysetting')" <?php if (($privacy_setting && $privacy_setting->phone) || (!$privacy_setting)) { ?> checked="" <?php } ?> type="checkbox" id="what_other_4" name="what_other" class="custom-control-input">
                                                    <label class="custom-control-label" for="what_other_4"> Phone Number </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                        <!--                                    <div class="col-xl-4 col-sm-6">
                                                                                    <div class="form-group">    
                                                                                        <div class="custom-control custom-checkbox">
                                                                                            <input  type="checkbox" id="what_other_5" name="what_other" class="custom-control-input">
                                                                                            <label class="custom-control-label" for="what_other_5"> My Website </label>
                                                                                        </div>
                                                                                    </div>  form group 
                                                                                </div>  col -->
                                        <div class="col-xl-4 col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input onchange="saveEmailSending(this, 'birthday', 'Privacysetting')" <?php if (($privacy_setting && $privacy_setting->birthday) || (!$privacy_setting)) { ?> checked="" <?php } ?> type="checkbox" id="what_other_6" name="what_other" class="custom-control-input">
                                                    <label class="custom-control-label" for="what_other_6"> Birthday </label>
                                                </div>
                                            </div> <!-- form group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- form section -->

                                <div class="form_section">
                                    <h5 class="text-semibold text_maroon">Deactive Account</h5>
                                    <div class="row">
                                        <div class="col-12 font-italic">
                                            <p>This is where you fully deactivate your Musician profile. It will disable your name and photo, and make you invisible when searched. Some of your info may still be visible for a short period of time. </p>
                                            <p> Don't forget, you can easily block users, change your profile to private, and remove followers at your own will in the settings area. We wouldn't want to see you remove your portfolio from our talent pool before exploring these options.
                                            </p>
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <a data-toggle="modal" data-target="#modal_deactivate" href="#" class="text-underline text-semibold text-black">Deactivate my Account</a>
                                </div> <!-- form section -->
                            </div>
                            <!-- Delete Model-->
                            <div class="modal fade" id="modal_deactivate" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Deactivate</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <i class="fas fa-times-circle"></i>
                                            </button>
                                        </div>
                                        <?php if ($bookings) { ?>
                                            <div class="modal-body">
                                                <form>
                                                    <div>
                                                        <label class="font-weight-bold">Please complete your bookings before deactivating your account.</label>
                                                    </div>
                                                    <div class="mt-3 text-center">
                                                        <!--<a href="<?= asset('deactive_account') ?>" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</a>-->
                                                        <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> Dismiss </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php } else { ?>
                                            <div class="modal-body">
                                                <form>
                                                    <div>
                                                        <label class="font-weight-bold">Are you sure you want to deactivate your account?</label>
                                                    </div>
                                                    <div class="mt-3 text-center">
                                                        <a href="<?= asset('deactive_account') ?>" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</a>
                                                        <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php } ?>
                                        <!-- modal body -->
                                    </div>
                                </div>
                            </div> <!-- Delete modal -->
                        </div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- container -->

    </div>
    <?php include resource_path('views/includes/footer.php'); ?>

    <!-- Edit Info modal Start -->
    <div class="modal fade" id="modal_edit_info" tabindex="-1" role="dialog" aria-labelledby="modal_edit_info" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Info </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="edit_info_section" value="1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Speciality</label>
                                    <select required name="artist_type_id[]" id="multiple_specialities" multiple="multiple" class="form-control" style="width: 100%">
                                        <?php foreach ($artistTypes as $artistType) { ?>
                                            <option value="<?= $artistType->id ?>" <?= in_array($artistType->id, $myArtistTypeIds) ? 'selected' : '' ?>><?= $artistType->title ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Since</label>
                                    <?php
                                    $currentYear = date("Y");
                                    $oldYear = $currentYear - 50;
                                    ?>
                                    <select required name="since" required class="form-control selct2_select" style="width: 100%">
                                        <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                            <option value="<?= $oldYear ?>" <?= $oldYear == $user->since ? 'selected' : '' ?>><?= $oldYear ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Location</label>
                                    <input required type="text" name="address" required value="<?= $user->address ?>" class="form-control autofill_location" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Language</label>
                                    <select required name="language" required class="form-control selct2_select" style="width: 100%">
                                        <?php foreach ($languages as $language) { ?>
                                            <option <?= $user->language == $language->name ? 'Selected' : '' ?>><?= $language->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Genre</label>
                                    <select required name="genre" class="form-control selct2_select" style="width: 100%">
                                        <option value="">--Select a genre--</option>
                                        <?php foreach ($genres as $genre) { ?>
                                            <option value="<?= $genre ?>" <?= $user->genre == $genre ? 'selected=""' : '' ?>><?= $genre ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Info modal -->
    <!-- Edit Info modal END -->

    <!-- Edit Description modal Start -->
    <div class="modal fade" id="modal_edit_description" tabindex="-1" role="dialog" aria-labelledby="modal_edit_description" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Description </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="edit_description_info" value="1">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Description</label>
                                    <textarea required class="form-control h_140" name="description" required><?= $user->description ?></textarea>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Description modal -->
    <!-- Edit Description modal END -->

    <!-- Add Affiliation modal Start -->
    <div class="modal fade" id="modal_add_affiliation" tabindex="-1" role="dialog" aria-labelledby="modal_add_affiliation" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Affiliation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="affiliation_info" value="1">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">Union</label>
                                    <select name="union_id" required class="form-control selct2_select" style="width: 100%">
                                        <?php if (!$unions->isEmpty()) { ?>
                                            <?php foreach ($unions as $union) { ?>
                                                <option value="<?= $union->id ?>"><?= $union->title ?></option>
                                            <?php } ?>
                                        <?php } else { ?>
                                            <option value="">--No more unions available--</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Add Affiliation modal -->
    <!-- Add Affiliation modal END -->

    <!-- Add Education Start modal -->
    <div class="modal fade" id="modal_add_education" tabindex="-1" role="dialog" aria-labelledby="modal_add_education" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Education</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="education_info" value="1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">College/University</label>
                                    <input type="text" name="institute_name" required placeholder="Institute Name" class="form-control" />
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Degree Title</label>
                                    <input type="text" name="title" required placeholder="Degree Title" class="form-control" />
                                </div> <!-- form-group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Start Year</label>
                                            <?php
                                            $currentYear = date("Y");
                                            $oldYear = $currentYear - 50;
                                            ?>
                                            <select name="start_year" required class="form-control selct2_select" style="width: 100%">
                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                    <option <?= $oldYear == $currentYear ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">End Year</label>
                                            <?php
                                            $currentYear = date("Y");
                                            $oldYear = $currentYear - 50;
                                            ?>
                                            <select name="end_year" required class="form-control selct2_select" style="width: 100%">
                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                    <option <?= $oldYear == $currentYear ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                </div> <!-- row -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Add Education modal -->
    <!-- Add Education Start modal END -->

    <div class="sidebar show_on_mobile">
        <?php include resource_path('views/includes/sidebar.php'); ?>
    </div>

    <!-- Add Education modal -->
    <!-- Add Education Start modal END -->

    <!-- Job Experience Start modal -->
    <div class="modal fade" id="modal_add_experience" tabindex="-1" role="dialog" aria-labelledby="modal_add_experience" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Job Experience</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="edit_user_form" action="<?= asset('edit_musician_profile') ?>" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                        <input type="hidden" name="experience_info" value="1">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Company</label>
                                    <input type="text" name="institute_name" required placeholder="Company Name" class="form-control" />
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Job Title</label>
                                    <input type="text" name="title" required placeholder="Title" class="form-control" />
                                </div> <!-- form-group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Start Year</label>
                                            <?php
                                            $currentYear = date("Y");
                                            $oldYear = $currentYear - 50;
                                            ?>
                                            <select name="start_year" required class="form-control selct2_select" style="width: 100%">
                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                    <option <?= $oldYear == $currentYear ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">End Year</label>
                                            <?php
                                            $currentYear = date("Y");
                                            $oldYear = $currentYear - 50;
                                            ?>
                                            <select name="end_year" required class="form-control selct2_select" style="width: 100%">
                                                <?php for (; $oldYear <= $currentYear; $oldYear++) { ?>
                                                    <option <?= $oldYear == $currentYear ? 'selected' : '' ?>><?= $oldYear ?></option>
                                                <?php } ?>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                </div> <!-- row -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Experience modal -->
    <!-- Job Experience modal END -->

    <!-- Edit Job Experience Start modal -->
    <div class="modal fade" id="modal_edit_job_experience" tabindex="-1" role="dialog" aria-labelledby="modal_edit_job_experience" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Job Experience</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times-circle"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Company</label>
                                    <input type="text" placeholder="" class="form-control" />
                                </div>
                            </div> <!-- col -->
                        </div> <!-- row -->

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">Job Title</label>
                                    <input type="text" placeholder="" class="form-control" />
                                </div> <!-- form-group -->
                            </div> <!-- col -->
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">Start Year</label>
                                            <select class="form-control selct2_select" style="width: 100%">
                                                <option>2005</option>
                                                <option>2006</option>
                                                <option>2007</option>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">End Year</label>
                                            <select class="form-control selct2_select" style="width: 100%">
                                                <option>2005</option>
                                                <option>2006</option>
                                                <option>2007</option>
                                            </select>
                                        </div> <!-- form-group -->
                                    </div> <!-- col -->
                                </div> <!-- row -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="mt-2 text-center">
                            <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                        </div>
                    </form>
                </div> <!-- modal-body-->
            </div> <!-- modal-content-->
        </div>
    </div> <!-- Edit Job Experience modal -->
    <!-- Edit Job Experience modal END -->

    <style>
        .jwc_frame {
            width: 100%;
        }

        input.error {
            border: solid 1px red !important;
        }

        #change_password_mus label.error {
            width: auto;
            display: inline;
            color: red;
            font-size: 16px;
            float: right;
        }

        /*            #musician_register label.error {
                            display: none !important;
                        }*/
    </style>
    <script>
        $("#change_password_mus").validate({
            rules: {

                current_password: {
                    required: true
                },
                password: {
                    required: true,
                    minlength: 6
                },

                password_confirmation: {
                    required: true,
                    equalTo: "#password"
                },
            },
            messages: {
                password: {
                    required: "",
                    minlength: "Your password must be at least 6 characters long."
                },
                current_password: {
                    required: ""
                },
                password_confirmation: {
                    required: "",
                    equalTo: "Please enter the same password as above."
                }
            }
        });
    </script>
</body>

</html>

<script>
    $(document).ready(function() {
        setTimeout(function() {
            $(".alert").fadeOut();
        }, 5000);
        $('#multiple_specialities').select2({
            placeholder: "--Select Specialities--",
            maximumSelectionLength: 6
        });
    });
    $('#upload-cover-pic').change(handleCoverPicSelect);

    function handleCoverPicSelect(event) {
        $('#cover_image').addClass('crop_me');

        $('.update_cover_photo_btn .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#upload-cover-pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#upload-cover-pic').val('');
            return;
        }
        if (input.files[0].size < 2000000) {
            if (input.files && input.files[0]) {
                var file = input.files[0];
                var reader = new FileReader();
                reader.onload = function(e) {
                    getOrientation(file, function(orientation) {
                        resetOrientation(reader.result, orientation, function(result) {
                            $('#cover-pic-div').hide();
                            $('#cover_image_header').show();
                            $('.jwc_frame').show();
                            $('.jwc_controls').hide();
                            $('#cover_image').attr('src', result);
                            $('#cover-pic-div').css('background-image', 'url(' + result + ')');

                            var width = $(window).width();
                            //                            var width = $('.crop_me')[0].naturalWidth;
                            $('.crop_me').jWindowCrop({
                                targetWidth: width,
                                targetHeight: 300,
                                loadingText: 'loading',
                                onChange: function(result) {
                                    $('#x').val(result.cropX);
                                    $('#top').val($('#cover_image')[0].style.top);
                                    $('#y').val(result.cropY);
                                    $('#w').val(result.cropW);
                                    $('#h').val(result.cropH);

                                }
                            });
                        });
                    });

                }

                reader.readAsDataURL(file);
            } else {
                alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
            }
        }
    }
    $(".date-picker-profile").datepicker({
        dateFormat: "DD, MM d, yy",
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
        yearRange: "-150:+0"
    });

    function savePrivate(isprivate) {
        $.ajax({
            url: "<?php echo asset('update_privacy') ?>",
            type: "GET",
            data: {
                "isprivate": isprivate
            },
            success: function(data) {

            }
        });
    }

    function saveEmailSending(ele, col, table) {
        if (ele.checked) {
            valu = 1;
        } else {
            valu = 0;
        }
        $.ajax({
            url: "<?php echo asset('update_email_setting') ?>",
            type: "GET",
            data: {
                "col_val": valu,
                "col": col,
                "table": table
            },
            success: function(data) {

            }
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $uploadCrop = $('#upload-demo').croppie({
        enableExif: true,
        viewport: {
            width: 200,
            height: 200
        },
        boundary: {
            width: 300,
            height: 300
        }
    });

    $('#upload-profile-pic').on('change', function(event) {
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#upload-profile-pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#upload-profile-pic').val('');
            return;
        }
        var reader = new FileReader();
        reader.onload = function(e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result,
                zoom: 0
            });
        };
        reader.readAsDataURL(this.files[0]);
        var image = this.files[0];
        var form = new FormData();
        form.append('photo', image);
        form.append('pic_type', 'profile_pic');
        $.ajax({
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            async: false,
            url: base_url + "save_original_profile_pic",
            enctype: 'multipart/form-data',
            data: form,
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(data) {
                $('#original_profile_pic').val(data.photo);
            }
        });
        $('#upload_profile_pic_modal').modal('show');
        $('#upload-profile-pic').val('');
    });

    $('#repostion-profile-pic').on('click', function(event) {
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        $uploadCrop.croppie('bind', {
            url: '<?= asset('public/images/' . $current_user->original_photo) ?>',
            zoom: 0
        });
        $('#upload_profile_pic_modal').modal('show');
        $('#original_profile_pic').val('<?= $current_user->original_photo ?>');
        $('#upload-profile-pic').val('');
    });

    function dataURLtoFile(dataurl, filename) {
        var arr = dataurl.split(','),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], filename, {
            type: mime
        });
    }


    $('#reposition-cover-pic').on('click', function(event) {
        var res;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "<?= asset('public/images/' . $current_user->original_cover_photo) ?>", true);
        xhr.responseType = "blob";
        xhr.onload = function(e) {
            var reader = new FileReader();
            reader.onload = function(event) {
                //base64 file
                res = event.target.result;
                console.log(res);
                //File object
                var cover = dataURLtoFile(res, 'cover.jpeg');
                getOrientation(cover, function(orientation) {
                    resetOrientation(reader.result, orientation, function(result) {
                        $('#cover_image').addClass('crop_me');
                        $('#cover-pic-div').hide();
                        $('#cover_image_header').show();
                        $('.jwc_frame').show();
                        $('.jwc_controls').hide();
                        $('#cover_image').attr('src', result);
                        $('#cover-pic-div').css('background-image', 'url(' + result + ')');
                        var width = $(window).width();
                        $('.crop_me').jWindowCrop({
                            targetWidth: width,
                            targetHeight: 300,
                            loadingText: 'loading',
                            onChange: function(result) {
                                $('#x').val(result.cropX);
                                $('#top').val($('#cover_image')[0].style.top);
                                $('#y').val(result.cropY);
                                $('#w').val(result.cropW);
                                $('#h').val(result.cropH);

                            }
                        });
                    });
                });
            }
            var file = this.response;
            reader.readAsDataURL(file)
        };
        xhr.send();
    });

    $('#save_profile_pic').on('click', function(ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(image) {
            var original_photo = $('#original_profile_pic').val();
            var form = new FormData();
            form.append('photo', image);
            form.append('original_photo', original_photo);
            $.ajax({
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                url: "<?= asset('upload_profile_pic') ?>",
                enctype: 'multipart/form-data',
                data: form,
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(data) {
                    window.location.reload();
                }
            });
        });
    });

    function getOrientation(file, callback) {
        var reader = new FileReader();

        reader.onload = function(event) {
            var view = new DataView(event.target.result);

            if (view.getUint16(0, false) != 0xFFD8)
                return callback(-2);

            var length = view.byteLength,
                offset = 2;

            while (offset < length) {
                var marker = view.getUint16(offset, false);
                offset += 2;

                if (marker == 0xFFE1) {
                    if (view.getUint32(offset += 2, false) != 0x45786966) {
                        return callback(-1);
                    }
                    var little = view.getUint16(offset += 6, false) == 0x4949;
                    offset += view.getUint32(offset + 4, little);
                    var tags = view.getUint16(offset, little);
                    offset += 2;

                    for (var i = 0; i < tags; i++)
                        if (view.getUint16(offset + (i * 12), little) == 0x0112)
                            return callback(view.getUint16(offset + (i * 12) + 8, little));
                } else if ((marker & 0xFF00) != 0xFF00)
                    break;
                else
                    offset += view.getUint16(offset, false);
            }
            return callback(-1);
        };

        reader.readAsArrayBuffer(file.slice(0, 64 * 1024));
    }

    function resetOrientation(srcBase64, srcOrientation, callback) {
        var img = new Image();

        img.onload = function() {
            var width = img.width,
                height = img.height,
                canvas = document.createElement('canvas'),
                ctx = canvas.getContext("2d");

            // set proper canvas dimensions before transform & export
            if (4 < srcOrientation && srcOrientation < 9) {
                canvas.width = height;
                canvas.height = width;
            } else {
                canvas.width = width;
                canvas.height = height;
            }

            // transform context before drawing image
            switch (srcOrientation) {
                case 2:
                    ctx.transform(-1, 0, 0, 1, width, 0);
                    break;
                case 3:
                    ctx.transform(-1, 0, 0, -1, width, height);
                    break;
                case 4:
                    ctx.transform(1, 0, 0, -1, 0, height);
                    break;
                case 5:
                    ctx.transform(0, 1, 1, 0, 0, 0);
                    break;
                case 6:
                    ctx.transform(0, 1, -1, 0, height, 0);
                    break;
                case 7:
                    ctx.transform(0, -1, -1, 0, height, width);
                    break;
                case 8:
                    ctx.transform(0, -1, 1, 0, 0, width);
                    break;
                default:
                    break;
            }

            // draw image
            ctx.drawImage(img, 0, 0);

            // export base64
            callback(canvas.toDataURL());
        };

        img.src = srcBase64;
    }

    function saveForm() {
        //                $('#cover_loader').css('display', 'flex');
        html2canvas(document.querySelector("#capture")).then(canvas => {
            //                                    document.body.appendChild(canvas);
            dataURL = canvas.toDataURL();
            $('#image_croped').val(dataURL);
        });

        submitForm();

    }

    function submitForm() {
        setTimeout(function() {
            if ($('#image_croped').val()) {
                $('#update_cover_photo').submit();
            } else {
                submitForm();
            }
        }, 1000);
    }

    function cancelForm() {
        window.location.reload();
    }
</script>