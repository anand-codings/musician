<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">
    
    <?php include resource_path('views/includes/top.php'); ?>
    
    <body>
        <?php include resource_path('views/includes/group_header.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-3">
                        <?php include resource_path('views/includes/groups_sidebar.php'); ?>
                    </div>
                    <div class="col-md-12 col-lg-9">
                        <div class="box">
                            <div class="d-flex flex-column flex-md-row mb-3">
                                <?php
                                if ($current_user_type == 'artist') {
                                    if ($group->admin_id != $current_id) {
                                        $check = 'join';
                                        $btnText = '<i class="fas fa-plus mr-1"></i>  Join Event Service';
                                        if (!$group->members->isEmpty()) {
                                            foreach ($group->members as $member) {
                                                if ($member->user_id == $current_id) {
                                                    if ($member->is_approved) {
                                                        $check = 'leave';
                                                        $btnText = 'Leave Event Service';
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
                                            <a href="javascript:void(0)" id="join-group-btn" status="<?= $check ?>" group-id="<?= $group->id ?>" class="btn btn-round btn-gradient text-semibold"><?= $btnText ?></a>
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="d-md-flex mb-3">
                                <div class="col-grow-small mb-2">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-music"></i> Category</span> <?= $group->getCategory->title ?>
                                </div>
                                <div class="col-grow-small mb-2">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-calendar-alt"></i> Professional</span> <?= $group->since ? 'Since ' . $group->since : 'N/A' ?>
                                </div>
                                <div class="col-grow-small mb-2">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $group->location ? $group->location : 'N/A' ?> 
                                </div>
                                <div class="col-grow-big mb-2">
                                    <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-users"></i> Team members </span> 

                                    <?php if (!$group->approvedMembers->isEmpty()) { ?>
                                        <ul class="un_style group_members_list nav align-items-center mt-1 mb-0">
                                            <?php $count = 0; ?>
                                            <?php foreach ($group->approvedMembers as $member) { ?>
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
                                                    <li class="ml-2"> <a href="javascript:void(0)" class="font-weight-bold text-uppercase font-14 text_aqua" data-toggle="modal" data-target="#members_modal"><u><?= $group->approvedMembers->count() - 3 ?> Others</u></a></li>
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
                                                        <h5 class="modal-title" id="create_gig_modal">Team Members</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <i class="fas fa-times-circle"></i>
                                                        </button>
                                                    </div> <!-- modal header -->
                                                    <div class="modal-body">
                                                        <ul class="followers_list un_style">
                                                            <?php foreach ($group->approvedMembers as $member) { ?>
                                                                <?php
                                                                $memberImage = getUserImage($member->getMemberDetail->photo, $member->getMemberDetail->social_photo, $member->getMemberDetail->gender);
                                                                ?>
                                                                <li>
                                                                    <div class="media align-items-center">
                                                                        <img  onclick="window.location.href = '<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>';" style="cursor: pointer;" src="<?= $memberImage ?>" alt="profile pic" class="rounded-circle">                                                                        <div class="media-body">
                                                                            <div class="d-flex flex-column flex-sm-row">
                                                                                <div class="mb-2">
                                                                                    <a href="<?= asset('profile_timeline/' . $member->getMemberDetail->id) ?>" class="u_name"><?= $member->getMemberDetail->first_name . ' ' . $member->getMemberDetail->last_name ?></a>
                                                                                    <div class="profession"><?= (!empty($member->getMemberDetail->getSpecialization->title)? $member->getMemberDetail->getSpecialization->title : '' ) ?></div>
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
                            <div>
                                <h6 class="d-block font-weight-bold text-uppercase">Artists’ Bio</h6>
                                <p><?= $group->description ? $group->description : 'N/A' ?></p>
                            </div>
                        </div> <!-- box -->
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
    <?php include resource_path('views/includes/group_scripts.php'); ?>

</body>
</html>
