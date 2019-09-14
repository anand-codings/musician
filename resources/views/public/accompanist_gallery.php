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
                                <?php if (!$accompanist->accompanistImages->isEmpty()) { ?>
                                    <ul class="un_style clearfix photo_media_list">
                                        <?php foreach ($accompanist->accompanistImages as $accompanistImage) { ?>
                                            <li>
                                                <a data-fancybox="images" href="<?= asset('public/images/' . $accompanistImage->file); ?>">
                                                    <div class="gallery_image">
                                                        <img src="<?= asset('userassets/images/spacer.png'); ?>" class="spacer" alt="" />
                                                        <div class="img" style="background-image:url(<?= asset('public/images/' . $accompanistImage->file); ?>)"></div>
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
        <?php include resource_path('views/includes/accompanist_scripts.php'); ?>
    </body>
</html>


