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
            <form id="teaching-studio-form" action="<?php //echo asset('edit_teaching_studio'); ?>" method="post" enctype="multipart/form-data">
                <?php
                $cover = asset('public/images/teaching_studios/cover_photo_demo.png');
                if ($teachingStudio->cover) {
                    $cover = asset('public/images/' . $teachingStudio->cover);
                }
                ?>
<!-- Start Cover Picture Buttons -->
<div class="container">
                <div id="cover_image_header" class="group_profile_cover_photo" id="cover-pic-div" style="display: none; ">
                    <div id="capture"><img class="" id="cover_image"  src="<?= $cover ?>" ></div>
                    <div class="jwc_btns">
                        <input type="button" class="btn btn-info" value="Save" onclick="saveForm()">
                        <input type="button" class="btn btn-danger" value="Cancel" onclick="cancelForm()">
                    </div>
                </div>
                </div>
<!-- End Cover Picture Buttons -->

    <div class="container">
    <div class="new_profile">
                <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
                    <div class="overlay_color">
                       
                            <div class="row align-items-center">
<!-- Start Profile Picture Section -->
                                <div class="col-lg-3 col-sm-4">
<!-- Start Profile Picture View -->
                                    <div class="edit_user_profile_pic">
                                        <?php
                                        $pic = asset('public/images/profile_pics/demo.png');
                                        if ($teachingStudio->pic) {
                                            $pic = asset('public/images/' . $teachingStudio->pic);
                                        }
                                        ?>
                                        <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                                        <ul class="un_style no_icon action_dropdown">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                    <a class="dropdown-item profile_upload_btn" href="#">
                                                        <input type="file" name="photo_base64" id="profile-photo" accept="image/*"/>
                                                        <i class="fas fa-cloud-upload-alt"></i> Upload Photo 
                                                    </a>
                                                    <a class="dropdown-item profile_upload_btn" id="repostion-profile-pic" href="#">
                                                        <i class="fas fa-arrows-alt"></i> Reposition
                                                    </a>
                                                    <a class="dropdown-item" href="#" id="delete-group-profile-pic">
                                                        <input id="delete_profile_val" type="hidden" value="0" name="pro_is_delete">
                                                        <i class="fas fa-times-circle"></i> Remove
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
<!--End Profile Picture View -->
<!--Start Profile Picture Modal -->
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
                                                            <input type="hidden" name="original_photo" value="<?= ($teachingStudio->original_pic) ? asset('public/images/' . $teachingStudio->original_pic) : '' ?>">
                                                            <input type="hidden" name="photo">
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
<!--End Profile Picture Modal -->
                                </div> <!-- col -->
<!-- End Profile Picture Section -->
<!-- Start Cover Picture Section -->
                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="d-flex justify-content-center">
                                        <ul class="un_style no_icon action_dropdown update_cover_photo_btn">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                                    <i class="fas fa-plus"></i> Change Cover Photo <i class="fas fa-chevron-down"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                    <a class="dropdown-item profile_upload_btn" href="#">

                                                        <input id="x" type="hidden" name="x" value="">
                                                        <input id="y" type="hidden" name="y" value="">
                                                        <input id="h" type="hidden" name="h" value="">
                                                        <input id="w" type="hidden" name="w" value="">
                                                        <input type="file" name="cover" id="upload-cover-pic" />
                                                        <input id="image_croped" type="hidden" name="image_croped" value="">
                                                        <input id="top" type="hidden" name="top" value="">
                                                        <input id="delete_cover_val" type="hidden" value="0" name="is_delete">

                                                        <i class="fas fa-cloud-upload-alt"></i> Upload Photo
                                                    </a>

                                                    <a class="dropdown-item" href="#" id="reposition-cover-pic"><i class="fas fa-arrows-alt"></i> Reposition</a>
                                                    <input type="hidden" id="uploaded_cover_val" value="<?= ($teachingStudio->original_cover) ? asset('public/images/' . $teachingStudio->original_cover) : '' ?>">
                                                    <a class="dropdown-item" href="#" id="delete-group-cover-pic" ><i class="fas fa-times-circle"></i> Remove </a>
                                                    <input id="delete_cov_val" type="hidden" value="0" name="cov_is_delete">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div> <!-- col -->
<!-- End Cover Picture Section -->
                            </div> <!-- row -->
                        </div> <!-- container -->
                    </div> <!-- overlay color -->
                    </div>
                </div> <!-- cover photo -->
                <div class="page_timeline">
                    <div class="container md-fluid-container">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12 ">
                                <div class="box box-shadow musician_register_form_wrapper clearfix">
                                    <div id="group-created-msg-div" style="display: none;">
                                        <div class="alert alert-success">
                                            Teaching studio updated successfully.
                                        </div>
                                    </div>
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

                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Studio Name</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input required type="text" name="name" value="<?= $teachingStudio->name ?>" required class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox text_grey mt-2">
                                                    <input type="checkbox" name="allow_booking" value="1" class="custom-control-input" id="lbl_inactive_events" <?= $teachingStudio->allow_booking ? 'checked=""' : '' ?>>
                                                    <label class="custom-control-label" for="lbl_inactive_events">Allow peoples to Booking</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Select Category</label>
                                                <select required name="categories" id="multiple_categories"  multiple="multiple" class="form-control" style="width: 100%">
                                                    <?php foreach ($artistTypes as $artistType) { ?>
                                                        <option value="<?= $artistType->id ?>" <?= in_array($artistType->id, $myStudioCategoryIds) ? 'selected' : '' ?>><?= $artistType->title ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label required class="font-weight-bold">Start Date</label>
                                                <input name="start_date" autocomplete="off" required class="form-control" value="<?= $teachingStudio->start_date ?>">
                                            </div>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Location</label>
                                                <input required autocomplete="off" id="autocomplete" name="address" required type="text" class="form-control" placeholder="Address" value="<?= $teachingStudio->location ?>">
                                                <input id="lat" name="lat" type="hidden" value="<?= $teachingStudio->lat ?>">
                                                <input id="lng" name="lng" type="hidden" value="<?= $teachingStudio->lng ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Studio Time</label>
                                                <div class="d-flex">
                                                    <input required type="time" name="studio_time_from" value="<?= $teachingStudio->studio_time_from ?>" class="form-control" placeholder="0:00" autocomplete="off">
                                                    <div class="pl-2 pr-2 pt-2 pb-2"> to </div>
                                                    <input required type="time" name="studio_time_to" value="<?= $teachingStudio->studio_time_to ?>" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Genre</label>
                                                <select required name="genre" class="form-control selct2_select" style="width: 100%">
                                                    <option value="">--Select a genre--</option>
                                                    <?php foreach ($genres as $genre) { ?>
                                                        <option value="<?= $genre ?>" <?= $teachingStudio->genre == $genre ? 'selected=""' : '' ?>><?= $genre ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Levels Taught</label>
                                                <select required name="level_taught" class="form-control selct2_select" style="width: 100%">
                                                    <option value="">--Select a level--</option>
                                                    <?php foreach ($levels as $level) { ?>
                                                        <option value="<?= $level ?>" <?= $teachingStudio->level_taught == $level ? 'selected=""' : '' ?>><?= ucfirst($level) ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Lessons Type</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-4 ">
                                                        <div class="custom-control custom-radio">
                                                            <input value="in_home" <?= $teachingStudio->lesson_type == 'in_home' ? 'checked=""' : '' ?> type="radio" id="in_home" name="lesson_type" class="custom-control-input">
                                                            <label class="custom-control-label" for="in_home">In-Home</label>
                                                        </div>
                                                    </div><!-- col -->
                                                    <div class="col-sm-6 col-md-6 col-lg-4 ">
                                                        <div class="custom-control custom-radio">
                                                            <input value="in_studio" <?= $teachingStudio->lesson_type == 'in_studio' ? 'checked=""' : '' ?> type="radio" id="in_studio" name="lesson_type" class="custom-control-input">
                                                            <label class="custom-control-label" for="in_studio">In-Studio</label>
                                                        </div>
                                                    </div><!-- col -->
                                                </div> <!-- row -->
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Currently Accepting Students</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6 col-md-6 col-lg-4 ">
                                                        <div class="custom-control custom-radio">
                                                            <input value="1" <?= $teachingStudio->is_accepting_students ? 'checked=""' : '' ?> type="radio" id="is_accepting_students_yes" name="is_accepting_students" class="custom-control-input">
                                                            <label class="custom-control-label" for="is_accepting_students_yes">Yes</label>
                                                        </div>
                                                    </div><!-- col -->
                                                    <div class="col-sm-6 col-md-6 col-lg-4 ">
                                                        <div class="custom-control custom-radio">
                                                            <input value="0" <?= $teachingStudio->is_accepting_students ? '' : 'checked=""' ?> type="radio" id="is_accepting_students_no" name="is_accepting_students" class="custom-control-input">
                                                            <label class="custom-control-label" for="is_accepting_students_no">No</label>
                                                        </div>
                                                    </div><!-- col -->
                                                </div> <!-- row -->
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">                                    
                                                <label class="font-weight-bold">Price</label>
                                                <input type="number" min="0" required="" class="form-control" name="price" value="<?= $teachingStudio->price ?>">
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                        <div class="col-sm-6">    
                                            <label class="font-weight-bold">Per Unit</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input type="number" placeholder="" required class="form-control" name="per_unit" value="<?= $teachingStudio->per_unit ?>"/>
                                                    </div><!-- from group -->
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select class="form-control selct2_select" required name="unit_id" style="width: 100%">
                                                            <?php foreach (units() as $unit) { ?>
                                                                <option value="<?= $unit->id ?>" <?= $teachingStudio->unit_id == $unit->id ? 'selected' : '' ?>><?= $unit->title ?></option>
                                                            <?php } ?>
                                                        </select><!-- from group -->
                                                    </div><!-- from group -->
                                                </div>
                                            </div> <!-- row -->
                                        </div> <!-- col -->
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">                                    
                                                <label class="font-weight-bold">Language</label>
                                                <div>
                                                    <select id="studio_lang" name="language" class="form-control selct2_select" style="width: 100%">
                                                        <?php foreach ($languages as $language) { ?>
                                                        <option value="<?= $language->name ?>" <?= $language->name == $teachingStudio->language ? 'selected=""' : '' ?>><?= $language->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div><!-- form group -->
                                        </div><!-- col -->
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label class="font-weight-bold">Add Teachers</label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <input type="hidden" id="member-input" class="form-control mr-2" name="members">
                                                <input autocomplete="off" type="text" id="member-search-input" class="form-control mr-2">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <ul class="un_style group_members">
                                                <?php if (!$teachingStudio->approvedTeachers->isEmpty()) { ?>
                                                    <?php foreach ($teachingStudio->approvedTeachers as $teachingStudioMember) { ?>
                                                        <li id="member-photo-li-<?= $teachingStudioMember->user_id ?>">
                                                            <?php
                                                            $teachingStudioMemberPhoto = getUserImage($teachingStudioMember->getMemberDetail->photo, $teachingStudioMember->getMemberDetail->social_photo, $teachingStudioMember->getMemberDetail->gender);
                                                            ?>
                                                            <img src="<?= $teachingStudioMemberPhoto ?>" class="rounded-circle" title="<?= $teachingStudioMember->getMemberDetail->first_name . ' ' . $teachingStudioMember->getMemberDetail->last_name ?>">
                                                            <i class="fas fa-times-circle remove-member" member-id="<?= $teachingStudioMember->user_id ?>"></i>
                                                        </li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-11"><h2 class="text-semibold text_maroon">Education</h2></div>
                                        <div class="col-sm-1">
                                            <i class="fa fa-plus add-fields-btn" id="add-education-btn"></i>
                                        </div>
                                    </div>
                                    <input name="education[]" type="hidden">
                                    <div id="education-dynamic-section" class="box">
                                        <?php if (!$teachingStudio->getEducations->isEmpty()) { ?>
                                            <?php $educationCounter = 0; ?>
                                            <?php foreach ($teachingStudio->getEducations as $teachingStudioEducation) { ?>
                                                <div class="row appended-fields">
                                                    <input type="hidden" name="education[<?= $educationCounter ?>][education_id]" value="<?= $teachingStudioEducation->id ?>">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Degree Title</label>
                                                            <input required name="education[<?= $educationCounter ?>][title]" value="<?= $teachingStudioEducation->title ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">College/University</label>
                                                            <input required name="education[<?= $educationCounter ?>][institute_name]" value="<?= $teachingStudioEducation->institute_name ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start Year</label>
                                                            <input required name="education[<?= $educationCounter ?>][start_year]" value="<?= $teachingStudioEducation->start_year ?>" type="number" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" class="form-control start_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End Year</label>
                                                            <input required name="education[<?= $educationCounter ?>][end_year]" value="<?= $teachingStudioEducation->end_year ?>" type="number" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" class="form-control end_year">
                                                        </div>
                                                    </div> 
                                                    <button type="button" class="close remove-education-btn" education-id="<?= $teachingStudioEducation->id ?>"><i class="fa fa-times-circle"></i></button>
                                                </div>
                                                <?php
                                                $educationCounter++;
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-11"><h2 class="text-semibold text_maroon">Experience</h2></div>
                                        <div class="col-sm-1">
                                            <i class="fa fa-plus add-fields-btn" id="add-experience-btn"></i>
                                        </div>
                                    </div>
                                    <input name="experience[]" type="hidden">
                                    <div id="experience-dynamic-section" class="box">
                                        <?php if (!$teachingStudio->getExperiences->isEmpty()) { ?>
                                            <?php $experienceCounter = 0; ?>
                                            <?php foreach ($teachingStudio->getExperiences as $teachingStudioExperience) { ?>
                                                <div class="row appended-fields">
                                                    <input type="hidden" name="experience[<?= $experienceCounter ?>][experience_id]" value="<?= $teachingStudioExperience->id ?>">
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Job Title</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][title]" value="<?= $teachingStudioExperience->title ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Company</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][institute_name]" value="<?= $teachingStudioExperience->institute_name ?>" type="text" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">Start Year</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][start_year]" value="<?= $teachingStudioExperience->start_year ?>" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" type="number" class="form-control start_year">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="form-group">
                                                            <label class="font-weight-bold">End Year</label>
                                                            <input required name="experience[<?= $experienceCounter ?>][end_year]" value="<?= $teachingStudioExperience->end_year ?>" onkeypress="if ($(this).val().length > 3) {
                                                                        return false;
                                                                    }" type="number" class="form-control end_year">
                                                        </div>
                                                    </div> 
                                                    <button type="button" class="close remove-experience-btn" experience-id="<?= $teachingStudioExperience->id ?>"><i class="fa fa-times-circle"></i></button>
                                                </div>
                                                <?php
                                                $experienceCounter++;
                                            }
                                            ?>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <label class="font-weight-bold">Teacher’s Bio</label>
                                        <textarea placeholder="Enter Teacher’s Bio" required name="description" class="form-control h_140"><?= $teachingStudio->description ?></textarea>
                                    </div>
                                    <div class="form-group clearfix mb-1">
                                        <label class="float-left font-weight-bold">Gallery</label>
                                        <label class="custom-file upload_btn float-right font-weight-bold">
                                            <input type="file" name="gallery_images[]" id="gallery-images-input" class="custom-file-input" multiple>
                                            <i class="fas fa-upload"></i> Upload
                                        </label>
                                    </div>
                                    <ul class="un_style clearfix photo_media_list">
                                        <?php if (!$teachingStudio->teachingStudioImages->isEmpty()) { ?>
                                            <?php foreach ($teachingStudio->teachingStudioImages as $teachingStudioImages) { ?>
                                                <li>
                                                    <a data-fancybox="images" href="<?= asset('public/images/' . $teachingStudioImages->file); ?>">
                                                        <div class="gallery_image">
                                                            <img src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer" alt="" />
                                                            <div class="img" style="background-image:url(<?= asset('public/images/' . $teachingStudioImages->file); ?>)"></div>
                                                        </div>
                                                    </a>
                                                    <i class="fas fa-times-circle delete_group_gallery_image" teaching-studio-image-id="<?= $teachingStudioImages->id ?>"></i>
                                                </li>
                                            <?php } ?>        
                                        <?php } ?>        
                                    </ul>
                                    <div class="form-group text-center mt-2 mb-0">
                                        <button type="submit" class="btn btn-round btn-gradient btn-xl">
                                            <strong>Save</strong>
                                            <span class="loader_inline" id="post_loader" style="display: none;">
                                                <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading..">
                                            </span>
                                        </button>
                                    </div>
                                </div> <!-- Box -->
                            </div> <!-- col -->
                        </div> <!-- row -->
                    </div> <!-- container -->
                </div> <!-- page timeline -->
            </form>
            <div class="loader_img" style="display: none">
                <img id="loading-image" src="<?= asset('userassets/images/loader.gif'); ?>" alt="Loading..." style="">
            </div>

        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
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
            /*For Loader Image*/
            .loader_img {
                position: absolute;
                top: 0;
                width: 100%;
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
            }

        </style>
    </body>
</html>
<link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.10.0/jquery.timepicker.js"></script>
<script>
    //To hide the profile pic drop down option "repostion,remove" if profile pic is empty
    <?php
    $pic = $teachingStudio->pic;
    if (!$pic) { ?>
    $('#repostion-profile-pic,#delete-group-profile-pic').hide();
    <?php } ?>
    //To hide the cover pic drop down option "repostion,remove" if profile pic is empty
    <?php
    $cover = $teachingStudio->cover;
    if (!$cover) { ?>
    $('#reposition-cover-pic,#delete-group-cover-pic').hide();
    <?php } ?>

    //    $('input[name=studio_time_from], input[name=studio_time_to]').timepicker({
//        timeFormat: 'H:i:s',
//        interval: 60,
//        startTime: '00:00',
//        dropdown: false
    //    });
    function showhidedrop(c_val) {
        if (c_val == 1) {
            $('#union_drop_down').show();
        } else {
            $('#union_drop_down').hide();
        }
    }

    <?php if (!$teachingStudio->union_id) { ?>
    $('#union_drop_down').hide();
    <?php } ?>

    $('#multiple_categories').select2({
        placeholder: "--Select Categories--",
        maximumSelectionLength: 3
    });
    $('#teaching-studio-form').validate({
        //        onfocusout: false,
        //        onkeyup: false,
        //        onclick: false,
        rules: {
            name: {
                required: true
            },
            start_date: {
                required: true
            },
            address: {
                required: true
            },
            description: {
                required: true
            },
        },
        messages: {

            name: {
                required: ""
            },
            start_date: {
                required: ""
            },
            address: {
                required: ""
            },
            description: {
                required: ""
            },
            studio_time_from: {
                required: ""
            },
            studio_time_to: {
                required: ""
            },
        },
        submitHandler: function() {
            submitForm();
        }
    });

    $("input[name=start_date]").datepicker({
        dateFormat: "yy-mm-dd",
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
        minDate: 0
    });

    function submitForm() {
        $('button[type="submit"]').attr('disabled', 'disabled');
        $('#post_loader').show();
        form = new FormData();
        var pic = $('#profile-photo')[0].files[0];
        var pro_del_flag = $('input[name=pro_is_delete]').val();
        var cov_del_flag = $('input[name=cov_is_delete]').val();
        var photo = $('input[name=photo]').val();
        var original_photo = $('input[name=original_photo]').val();
        var cover = $('#upload-cover-pic')[0].files[0];
        var name = $('input[name=name]').val();
        var start_date = $('input[name=start_date]').val();
        var studio_time_from = $('input[name=studio_time_from]').val();
        var studio_time_to = $('input[name=studio_time_to]').val();
        var address = $('input[name=address]').val();
        var lat = $('input[name=lat]').val();
        var lng = $('input[name=lng]').val();
        var description = $('textarea[name=description]').val();
        var genre = $('select[name=genre]').val();
        var categories = $('select[name=categories]').val();
        var level_taught = $('select[name=level_taught]').val();
        var language = $('#studio_lang').val();
        var lesson_type = $('input[name=lesson_type]:checked').val();
        var affiliation = $('input[name=affiliation]:checked').val();
        var unions = $('select[name=unions]').val();
        var price = $('input[name=price]').val();
        var image_croped = $('#image_croped').val();
        var is_accepting_students = $('input[name=is_accepting_students]:checked').val();
        var members = '';
        if ($('input[name=members]').val() != '') {
            members = $('input[name=members]').val();
        }
        var allow_booking = '';
        if ($('input[name=allow_booking]').is(":checked")) {
            allow_booking = $('input[name=allow_booking]').val();
        }
        var per_unit = $('input[name=per_unit]').val();
        var unit_id = $('select[name=unit_id]').val();
        form.append('per_unit', per_unit);
        form.append('unit_id', unit_id);
        form.append('teaching_studio_id', <?= $teachingStudio->id ?>);
        form.append('pic', pic);
        form.append('pro_del_flag', pro_del_flag);
        form.append('cov_del_flag', cov_del_flag);
        form.append('photo', photo);
        form.append('original_photo', original_photo);
        form.append('cover', cover);
        form.append('name', name);
        form.append('allow_booking', allow_booking);
        form.append('start_date', start_date);
        form.append('studio_time_from', studio_time_from);
        form.append('studio_time_to', studio_time_to);
        form.append('address', address);
        form.append('lat', lat);
        form.append('lng', lng);
        form.append('members', members);
        form.append('description', description);
        form.append('genre', genre);
        form.append('categories', categories);
        form.append('level_taught', level_taught);
        form.append('lesson_type', lesson_type);
        form.append('affiliation', affiliation);
        form.append('unions', unions);
        form.append('language', language);
        form.append('price', price);
        form.append('image_croped', image_croped);
        form.append('is_accepting_students', is_accepting_students);
        for (var i = 0; i < $('#gallery-images-input').get(0).files.length; ++i) {
            form.append('gallery_images[' + i + ']', $('#gallery-images-input').get(0).files[i]);
        }
        var education = document.querySelectorAll('input[name*=education]');
        for (var i = 0; i < education.length; i++) {
            form.append(education[i].name, education[i].value);
        }
        var experience = document.querySelectorAll('input[name*=experience]');
        for (var i = 0; i < experience.length; i++) {
            form.append(experience[i].name, experience[i].value);
        }
        $.ajax({
            url: base_url + 'edit_teaching_studio',
            type: 'POST',
            contentType: false,
            cache: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: form,
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(response) {
                $('#post_loader').hide();
                var notificationsCount = response.notifications.length;
                var notifications = response.notifications;
                if (notificationsCount > 0) {
                    for (var i = 0; i < notificationsCount; i++) {
                        socket.emit('notification_get', {
                            "user_id": notifications[i].on_user,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> ' + notifications[i].notification_text,
                            "url": '<?= asset('teaching_studio_time_line') ?>' + '/' + notifications[i].type_id,
                            "studio_id": notifications[i].type_id,
                            "studio_name": response.studio_name,
                            "studio_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + notifications[i].type_id,
                            "unique_text": notifications[i].unique_text,
                            "studio_invite": 1,
                            "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                        });
                    }
                }
                $("html, body").animate({
                    scrollTop: 0
                }, "slow");
                $("#group-created-msg-div").fadeIn();
                setTimeout(function() {
                    window.location.href = base_url + 'services';
                }, 5000);
            }
        });
    }

    var membersIds = [];
    membersIds.push(<?= $current_id ?>);
    <?php if (!$teachingStudio->teachers->isEmpty()) { ?>
    <?php foreach ($teachingStudio->teachers as $teachingStudioMember) { ?>
    membersIds.push(<?= $teachingStudioMember->user_id ?>);
    <?php } ?>
    <?php } ?>

    $("#member-search-input").autocomplete({
        source: base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)),
        minLength: 0,
        select: function(event, ui) {
            membersIds.push(ui.item.id);
            $("#member-search-input").autocomplete('option', 'source', base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)));
            $("#member-input").val(membersIds);
            $("#member-search-input").val('');
            var photo = base_url + 'public/images/profile_pics/demo.png';
            if (ui.item.photo) {
                photo = base_url + 'public/images/' + ui.item.photo;
            }
            $(".group_members").append('<li id="member-photo-li-' + ui.item.id + '"><img src="' + photo + '" class="rounded-circle" title="' + ui.item.first_name + ' ' + ui.item.last_name + '" /><i class="fas fa-times-circle" onclick="removeMember(this)"  member-id="' + ui.item.id + '"></i></li>');
            return false;
        }
    })
        .bind('click', function() {
            $(this).autocomplete("search");
        })
        .data("ui-autocomplete")._renderItem = function(ul, item) {
        var profile_pic = 'profile_pics/demo.png';
        if (item.photo) {
            profile_pic = item.photo;
        }
        var inner_html = '<div class="add_member_field d-flex align-items-center"><div class="image"><img class="rounded-circle" style="height:43px; width:43px;" src="' + base_url + 'public/images/' + profile_pic + '"></div><div class="label"><h4><b>' + item.first_name + ' ' + item.last_name + '</b></h4></div></div>';
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append(inner_html)
            .appendTo(ul);
    };

    function removeMember(el) {
        var memberId = $(el).attr('member-id');
        $('#member-photo-li-' + memberId).remove();
        var index = membersIds.indexOf(parseInt(memberId));
        if (index > -1) {
            membersIds.splice(index, 1);
        }
        $("#member-search-input").autocomplete('option', 'source', base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)));
        $("#member-input").val(membersIds);
    };

    $('.remove-member').click(function() {
        var memberId = $(this).attr('member-id');
        $('#member-photo-li-' + memberId).remove();

        var index = membersIds.indexOf(parseInt(memberId));
        if (index > -1) {
            membersIds.splice(index, 1);
        }
        $("#member-search-input").autocomplete('option', 'source', base_url + 'get_all_members?ids=' + encodeURIComponent(JSON.stringify(membersIds)));
        //        $("#member-input" ).val(membersIds);
        $.ajax({
            url: base_url + 'remove_member_from_teaching_studio',
            type: 'POST',
            data: {
                teaching_studio_member_user_id: memberId,
                teaching_studio_id: <?= $teachingStudio->id ?>
            },
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(data) {
                console.log(data);

            }
        });
    });
    //encode cover img into base 64
    function encodeImageFileAsURL(base64Img)
    {
        return function () {
            var file = this.files[0];
            var reader = new FileReader();
            reader.onloadend = function () {
                base64Img(reader.result);
            }
            reader.readAsDataURL(file);
        }
    }
    $('#upload-cover-pic').change(handleCoverPicSelect).change(encodeImageFileAsURL(function(base64Img) {
        $('#reposition-cover-pic,#delete-group-cover-pic').show();
        $('#uploaded_cover_val').val('');
        $('#uploaded_cover_val').val(base64Img);
        // alert(base64Img);
    }));
    $('#delete-group-profile-pic').click(removeProfile);
    $('#delete-group-cover-pic').click(removeCover);
    $('#reposition-cover-pic').on('click', function(event) {
        $('.loader_img').show();
        var full_cover =  $('#uploaded_cover_val').val();

        var res;
        var xhr = new XMLHttpRequest();
        xhr.open("GET", full_cover, true);
        xhr.responseType = "blob";
        xhr.onload = function(e) {
            var reader = new FileReader();
            reader.onload = function(event) {
                //base64 file
                res = event.target.result;
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
                        $('.loader_img').hide();
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
    $('#repostion-profile-pic').on('click', function(event) {
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        var pro_pic = $('input[name="original_photo"]').val();
        $uploadCrop.croppie('bind', {
            url: pro_pic,
            zoom: 0
        });
        $('#upload_profile_pic_modal').modal('show');
        //$('#original_profile_pic').val('<?= $teachingStudio->original_pic ?>');
        $('#upload-profile-pic').val('');
    });

    $('.delete_group_gallery_image').click(function() {
        var teachingStudioImageId = $(this).attr('teaching-studio-image-id');
        $(this).parents('li').remove();
        $.ajax({
            url: base_url + 'delete_teaching_studio_image',
            type: 'POST',
            data: {
                teaching_studio_image_id: teachingStudioImageId
            },
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function(data) {
                console.log(data);

            }
        });
    });

    $('#gallery-images-input').change(function() {
        var leng = this.files.length;
        for (i = 0; i < leng; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.photo_media_list').append('<li><a href="#"><div class="gallery_image"> <img src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer" alt="" /><div class="img" style="background-image:url(' + e.target.result + ')"></div></div></a></li>');
            }
            reader.readAsDataURL(this.files[i]);
        }
    });

    $('#upload-cover-pic').change(handleCoverPicSelect);


    var educationAddClickCount = <?= isset($educationCounter) ? $educationCounter : 0 ?>;
    $('#add-education-btn').click(function() {
        $('#education-dynamic-section').append("<div class='row appended-fields'><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Degree Title</label><input required name='education[" + educationAddClickCount + "][title]' type='text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>College/University</label>\n\<input required name='education[" + educationAddClickCount + "][institute_name]' type=text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Start Year</label><input required name='education[" + educationAddClickCount + "][start_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}'  class='form-control start_year'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>End Year</label><input required name='education[" + educationAddClickCount + "][end_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control end_year'></div></div><button type='button' class='close' onclick='removeDiv(this)'><i class='fa fa-times-circle'></i></button></div>");
        educationAddClickCount++;
    });
    $('.remove-education-btn').click(function() {
        var educationId = $(this).attr('education-id');
        var teachingStudioId = '<?= $teachingStudio->id ?>';
        $.ajax({
            type: "POST",
            url: base_url + "remove_teaching_studio_education",
            data: {
                'education_id': educationId,
                'teaching_studio_id': teachingStudioId
            },
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            }
        });
        $(this).parent('div').remove();
    });
    var experienceAddClickCount = <?= isset($experienceCounter) ? $experienceCounter : 0 ?>;
    $('#add-experience-btn').click(function() {
        $('#experience-dynamic-section').append("<div class='row appended-fields'><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Job Title</label><input required name='experience[" + experienceAddClickCount + "][title]' type='text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Company</label>\n\<input required name='experience[" + experienceAddClickCount + "][institute_name]' type=text' class='form-control'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>Start Year</label><input required name='experience[" + experienceAddClickCount + "][start_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control start_year'></div></div><div class='col-sm-3'><div class='form-group'><label class='font-weight-bold'>End Year</label><input required name='experience[" + experienceAddClickCount + "][end_year]' type='number' onkeypress='if($(this).val().length > 3){return false;}' class='form-control end_year'></div></div><button type='button' class='close' onclick='removeDiv(this)'><i class='fa fa-times-circle'></i></button></div>");
        experienceAddClickCount++;
    });
    $('.remove-experience-btn').click(function() {
        var experienceId = $(this).attr('experience-id');
        var teachingStudioId = '<?= $teachingStudio->id ?>';
        $.ajax({
            type: "POST",
            url: base_url + "remove_teaching_studio_experience",
            data: {
                'experience_id': experienceId,
                'teaching_studio_id': teachingStudioId
            },
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            }
        });
        $(this).parent('div').remove();
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
    function removeDiv(el) {
        $(el).parent('div').remove();
    }

    var placeSearch, autocomplete;

    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
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

    $('#profile-photo').on('change', function(event) {
        $("#delete_profile_val").val('0');
        $('#repostion-profile-pic,#delete-group-profile-pic').show();
        $('.edit_user_profile_pic .custom_dropdown').removeClass('show');
        var input = this;
        var filename = $("#profile-photo").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
        if ($.inArray(fileType, ValidImageTypes) < 0) {
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#profile-photo').val('');
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
        form.append('pic_type', 'studio_pic');
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
                $('input[name="original_photo"]').val('');
                $('input[name="original_photo"]').val(data.photo);
            }
        });
        $('#upload_profile_pic_modal').modal('show');
    });

    $('#save_profile_pic').on('click', function(ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function(image) {
            var form = new FormData();
            form.append('photo', image);
            form.append('pic_type', 'studio_pic');
            $.ajax({
                type: 'POST',
                contentType: false,
                cache: false,
                processData: false,
                url: "<?= asset('upload_service_profile_pic') ?>",
                enctype: 'multipart/form-data',
                data: form,
                beforeSend: function(request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function(data) {
                    $('input[name="photo"]').val(data.photo);
                    $('#profile-pic-div').css("background-image", "url(" + image + ")");
                    $('#upload_profile_pic_modal').modal('hide');
                }
            });
        });
    });

    function handleCoverPicSelect(event) {
        $("#delete_cov_val").val('0');
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

                        //                            alert(orientation);
                        resetOrientation(reader.result, orientation, function(result) {

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

                reader.readAsDataURL(file);
            } else {
                alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
            }
        }
    }

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
        html2canvas(document.querySelector("#capture")).then(canvas => {
            //                                    document.body.appendChild(canvas);
            dataURL = canvas.toDataURL();
            $('#image_croped').val(dataURL);
            $('#cover-pic-div').css('background-image', 'url(' + dataURL + ')');
            $('#cover-pic-div').show();
            $('#cover_image_header').hide();
        });

    }

    function cancelForm() {
        window.location.reload();
    }
    //Remove profile picture function
    function removeProfile (){
        $('input[name=photo]').val('');
        $('input[name=original_photo]').val('');
        $("#profile-photo").val('');
        $("#delete_profile_val").val('1');
        $('#repostion-profile-pic,#delete-group-profile-pic').hide();
        $('#profile-pic-div').css("background-image", "url("+base_url+"/public/images/profile_pics/demo.png)");
    };
    //Remove Cover picture function
    function removeCover (){
        //cropped cover image
        $('input[name=image_croped]').val('');
        $('input[name=cover]').val('');
        $("#profile-photo").val('');
        $("#delete_cov_val").val('1');
        $('#reposition-cover-pic,#delete-group-cover-pic').hide();
        $('#cover-pic-div').css("background-image", "url("+base_url+"public/images/teaching_studios/cover_photo_demo.png)");
    };
</script>