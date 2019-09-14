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
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 col-lg-3">
                        <?php include resource_path('views/includes/groups_sidebar.php'); ?>
                    </div>
                    <div class="col-md-12 col-lg-9">
                        <div class="box">
                            <?php if (!empty($group->groupImages)) { ?>
                                <ul class="un_style clearfix photo_media_list">
                                    <?php foreach ($group->groupImages as $groupImage) { ?>
                                        <li>
                                            <a data-fancybox="images" href="<?= asset($groupImage->file); ?>">
                                                <div class="gallery_image">
                                                    <img src="<?= asset($groupImage->file); ?>" class="spacer" alt="" />
                                                    <div class="img" style="background-image:url(<?= asset($groupImage->file); ?>)"></div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } else { ?>
                                <div class="posts_end mt-0 mb-0">No images found.</div>
                            <?php } ?>
                        </div>
                    </div>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
    <?php include resource_path('views/includes/group_scripts.php'); ?>
</body>
</html>
