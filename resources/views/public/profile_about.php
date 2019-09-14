<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <body> 
        <div class="container">
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <?php include resource_path('views/includes/profile_cover_photo_section.php'); ?>
        </div>
        <!-- cover photo -->
        <div class="page_timeline">
        <div class="container lg-fluid-container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <?php include resource_path(getProfileSidebarPath($user->type)); ?>
                </div> <!-- col -->
                <div class="col-lg-9 col-md-12">
                    <?php include resource_path('views/includes/profile_nav_tabs.php'); ?>
                    <div class="box box-shadow no_margin clearfix">
                        <div class="row">
                            <div class="d-md-none d-lg-none d-md-block text-left clearfix w-100">
                                <div class="show_about_on_mobile clearfix">
                                    <?php include resource_path(getProfileSidebarPath($user->type)); ?>
                                </div>
                            </div> 
                            <?php if ($user->type == 'artist') { ?>
                                <div class="col-6 col-md-3 col-sm-6 mb-2">
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Category</span>
                                    <?php
                                    if (!$user->getSelectedCategories->isEmpty()) {
                                        $getSelectedArtistTypesCount = $user->getSelectedCategories->count();
                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
                                            echo $selectedArtistType->getCategory->title;
                                            if ($getSelectedArtistTypesCount >= $i) {
                                                echo ', ';
                                            }
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
                                    <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-tags"></i> Genre</span> <?= $user->genre ? $user->genre : 'N/A' ?>
                                </div>
                            <?php } ?>
                            <div class="col-6 col-md-3 col-sm-6 mb-2">
                                <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $user->address ? $user->address : 'N/A' ?> 
                            </div>
                            <div class="col-6 col-md-3 col-sm-6 mb-2">
                                <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-globe"></i> Languages</span> <?= $user->language ? $user->language : 'N/A' ?>
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-graduation-cap"></i> Education</span>
                                <?php if (!$user->getEducations->isEmpty()) { ?>
                                    <ol class="about_list">
                                        <?php foreach ($user->getEducations as $userEducation) { ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold"><?= $userEducation->title ?></span> 
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold"><?= $userEducation->start_year . ' - ' . $userEducation->end_year ?></span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p><?= $userEducation->institute_name ?></p> 
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ol> 
                                <?php } else { ?>
                                    <span class="text_grey">N/A</span>
                                <?php } ?>
                                <hr/> 

                                <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-briefcase"></i> Experience</span>
                                <?php if (!$user->getExperiences->isEmpty()) { ?>
                                    <ol class="about_list">
                                        <?php foreach ($user->getExperiences as $userExperience) { ?>
                                            <li>
                                                <div class="row">
                                                    <div class="col-sm-7">
                                                        <span class="font-weight-bold"><?= $userExperience->title ?></span> 
                                                    </div>
                                                    <div class="col-sm-5">
                                                        <span class="font-weight-bold"><?= $userExperience->start_year . ' - ' . $userExperience->end_year ?></span>
                                                    </div>
                                                </div>
                                                <div class="text_grey">
                                                    <p><?= $userExperience->institute_name ?></p> 
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ol> 
                                <?php } else { ?>
                                    <span class="text_grey">N/A</span>
                                <?php } ?>
                                <hr/>
                                <?php if ($user->type == 'artist') { ?>
                                    <div class="mb-2"> 
                                        <i class="fas fa-user-shield"></i>
                                        <span class="font-weight-bold text-uppercase mb-2"> Affiliations </span>
                                    </div>
                                    <?php if (!$user->getAffiliations->isEmpty()) { ?>
                                        <ol>
                                            <?php foreach ($user->getAffiliations as $affiliation) { ?>
                                                <li>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p><?= $affiliation->union->title ?></p> 
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ol> 
                                    <?php } else { ?>
                                        <span class="text_grey">N/A</span>
                                    <?php } ?>
                                    <hr/> 
                                    <div class="mb-2"> 
                                        <i class="fas fa-users"></i>
                                        <span class="font-weight-bold text-uppercase mb-2"> Event Services </span>
                                    </div>
                                    <?php if (!$user->getGroups->isEmpty()) { ?>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="groups_joined">
                                                    <?php foreach ($user->getGroups as $group) { ?>
                                                        <a href="<?= asset('group_time_line/' . $group->id) ?>"><?= $group->name ?></a>,
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <span class="text_grey">N/A</span>
                                    <?php } ?>
                                    <hr/>
                                <?php } ?>
                                <div class="mb-4">
                                    <span class="d-block font-weight-bold text-uppercase mb-1"> Artist’s Bio</span>
                                    <p><?= $user->description ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div> <!-- col -->
            </div> <!-- row -->
        </div> <!-- container -->
        </div> <!-- paeg timeline -->
        <?php if (Auth::guard('user')->check()) { ?>
            <div class="show_on_mobile clearfix">
                <?php include resource_path('views/includes/sidebar.php'); ?>
            </div>
        <?php } ?>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
</body>
</html>
