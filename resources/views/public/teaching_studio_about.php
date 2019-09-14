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
        <?php include resource_path('views/includes/teaching_studio_header.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-3 d-lg-block">
                        <?php include resource_path('views/includes/teaching_studio_sidebar.php'); ?>
                    </div>
                    <div class="col-md-12 col-xl-9 col-lg-9">
                        <div class="box">
                            <h5 class="text_maroon text-semibold mb-0">About</h5>
                            <hr class="mt-3 mb-2" />
                            <div class="row mb-3">
                                <div class="col-12 pb-3">
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

                                <div class="col-12">
                                    <h5 class="text_maroon text-semibold mb-0">Teacher’s Bio</h5>
                                    <hr class="mt-1 mb-2" />
                                    <p><?= $studio->description ? $studio->description : 'N/A' ?></p>
                                    <hr class="mt-3 mb-1" />
                                </div>

                                <div class="col-12 py-3">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-chart-line"></i> Level Taught</span> <?= $studio->level_taught ?>
                                    <hr class="mt-3 mb-0" />
                                </div>

                                <div class="col-12 py-1 pb-3">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-tags"></i> Genre</span> <?= $studio->genre ?>
                                </div>
                                <hr class="mt-1 mb-2" />
                                <div class="col-md-12">
                                    <div class="mb-4">
                                        <h5 class="text_maroon text-semibold mb-0">Education</h5>
                                        <hr class="mt-1 mb-2" />
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
                                    </div>

                                    <div class="mb-4">
                                        <h5 class="text_maroon text-semibold mb-0">Experience</h5>
                                        <hr class="mt-1 mb-2" />
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
                                    </div>
                                </div> <!-- col -->
                                <div class="col-12 py-3">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Language</span> <?= $studio->language ?>
                                </div>
                                <div class="col-12 py-3">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $studio->location ? $studio->location : 'N/A' ?>
                                </div>



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

                            <!-- <h5 class="text_maroon text-semibold mb-0">Join</h5>
                            <hr class="mt-1 mb-2" />
                            <div class="d-flex mb-3 flex-wrap">
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-calendar-alt"></i> Start Date</span> <?= $studio->start_date ? $studio->start_date : 'N/A' ?>
                                </div>
                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-clock"></i> Time</span> <?= date('h:i a', strtotime($studio->studio_time_from)) ?> to <?= date('h:i a', strtotime($studio->studio_time_to)) ?>
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
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-hands-helping"></i> Accepting Students</span> <?= $studio->is_accepting_students ? 'Yes' : 'No' ?>
                                </div>

                                <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-chalkboard-teacher"></i> Lesson Type</span> <?= ucfirst(str_replace("_", " ", $studio->lesson_type)) ?>
                                </div>



                            </div> -->


                            <h6 class="text_maroon font-weight-bold mb-0">TEACHERS & MEMBERS</h6>
                            <hr class="mt-1 mb-2" />

                            <div class="row">
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
                                        <div class="modal fade" id="teachers_modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                        <img onclick="window.location.href = '<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>';" style="cursor: pointer;" src="<?= $memberImage ?>" alt="profile pic" class="rounded-circle">
                                                                        <div class="media-body">
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
                                </div> <!-- col -->
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
                                        <div class="modal fade" id="members_modal" tabindex="-1" role="dialog" aria-hidden="true">
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
                                                                        <img onclick="window.location.href = '<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>';" style="cursor: pointer;" src="<?= $memberImage ?>" alt="profile pic" class="rounded-circle">
                                                                        <div class="media-body">
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
                                </div> <!-- col -->
                            </div> row
                        </div> <!-- box -->
                    </div> <!-- col 9 -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
    <?php include resource_path('views/includes/studio_scripts.php'); ?>

</body>

</html>