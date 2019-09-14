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
                            <div class="box">
                                <div class="d-flex mb-4">
                                    <div class="col-grow-small">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-map-marker-alt"></i> Location</span> <?= $accompanist->location ? $accompanist->location : 'N/A' ?> 
                                    </div>
                                    <div class="col-grow-small">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-language"></i> Language</span> <?= $accompanist->language ? $accompanist->language : 'N/A' ?> 
                                    </div>
                                    <?php
                                    $unit = $accompanist->unit->title;
                                    if ($accompanist->unit->title == 'hour') {
                                        $unit = 'hr';
                                    }
                                    ?>
                                    <div class="col-grow-small">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-money-bill-alt"></i> Price</span> $<?= $accompanist->price ?></strong> / <?= $accompanist->per_unit . ' ' . $unit ?>
                                    </div>
                                    <div class="col-grow-small">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> Gender</span> <?= $accompanist->gender ? $accompanist->gender : 'N/A' ?> 
                                    </div>
                                    
                                    <div class="col-lg-3 col-md-4 col-sm-6 mb-2">
                                        <span class="d-block font-weight-bold text-uppercase"> <i class="fas fa-music"></i> Category</span>
                                        <?php
                                        if (!$accompanist->getSelectedCategories->isEmpty()) {
                                            $getSelectedArtistTypesCount = $accompanist->getSelectedCategories->count();
                                            $i = 1;
                                            foreach ($accompanist->getSelectedCategories as $studioSelectedCategory) {
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
                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-graduation-cap"></i> Education</span>
                                        <?php if (!$accompanist->getEducations->isEmpty()) { ?>
                                            <ol class="about_list">
                                                <?php foreach ($accompanist->getEducations as $accompanistEducation) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <span class="font-weight-bold"><?= $accompanistEducation->title ?></span>
                                                                <span class="text_grey ml-1 font-14"><?= '(' . $accompanistEducation->start_year . ' - ' . $accompanistEducation->end_year . ')' ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="text_grey">
                                                            <p><?= $accompanistEducation->institute_name ?></p> 
                                                        </div>
                                                    </li>
                                                <?php } ?>
                                            </ol>            
                                        <?php } else { ?>
                                            <span class="text_grey">N/A</span>
                                        <?php } ?>
                                        <hr/> 

                                        <span class="d-block font-weight-bold text-uppercase mb-2"> <i class="fas fa-briefcase"></i> Experience</span>
                                        <?php if (!$accompanist->getExperiences->isEmpty()) { ?>
                                            <ol class="about_list">
                                                <?php foreach ($accompanist->getExperiences as $accompanistExperience) { ?>
                                                    <li>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <span class="font-weight-bold"><?= $accompanistExperience->title ?></span>
                                                                <span class="text_grey ml-1 font-14"><?= '(' . $accompanistExperience->start_year . ' - ' . $accompanistExperience->end_year . ')' ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="text_grey">
                                                            <p><?= $accompanistExperience->institute_name ?></p> 
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
                                    <h6 class="d-block font-weight-bold text-uppercase">Accompanist’s Bio</h6>
                                    <p><?= $accompanist->description ? $accompanist->description : 'N/A' ?></p>
                                </div>
                            </div>
                        </div> <!-- col -->
                    </div> <!-- row -->
                </div> <!-- container -->
            </div>
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
        <?php include resource_path('views/includes/accompanist_scripts.php'); ?>
    </body>
</html>


