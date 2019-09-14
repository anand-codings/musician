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
        <div class="page_timeline">
            <div class="container lg-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path(getProfileSidebarPath($user->type)); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <?php include resource_path('views/includes/profile_nav_tabs.php'); ?>

                        <h4 class="font-weight-bold text_darkblue text-uppercase mb-4"> Teaching Studios</h4>
                        <div class="row" id="teaching-studios-list"></div> <!-- row -->                                    
                        <div id="teaching-studios-msg"></div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page_timeline -->
        <?php if (Auth::guard('user')->check()) { ?>
            <div class="show_on_mobile clearfix">
                <?php include resource_path('views/includes/sidebar.php'); ?>
            </div>
        <?php } ?>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>     
</body>
</html>

<script>

    var ajaxcall = 1;
    var isScroll = 0;
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        loadTeachingStudios(skip, take, isScroll);
    });

    win.on('scroll', function () {
        var docheight = parseInt($(document).height());
        var winheight = parseInt(win.height());
        var differnce = (docheight - winheight) - win.scrollTop();
        isScroll = 1;
        if (differnce < 100) {
            if (ajaxcall === 1) {
                ajaxcall = 0;
                var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                loadTeachingStudios(skip, 12, isScroll);
            }
        }
    });


    function loadTeachingStudios(skip, take, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#teaching-studios-list').append(loader);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('fetch_profile_teaching_studios/'); ?>",
            data: {skip: skip, take: take, 'user_id': '<?= $user->id ?>'},
            success: function (response) {
                $('#loaderposts').remove();
                if (response) {
                    $('#teaching-studios-list').append(response);
                    ajaxcall = 1;
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    return true;
                } else {
                    if ($('#teaching-studios-list').is(':empty')) {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#teaching-studios-msg').html(noposts);
                    } else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#teaching-studios-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }

    function addBookmark(teaching_studio_id) {
        $.ajax({
            type: "POST",
            url: "<?= asset('bookmark_teaching_studio'); ?>",
            data: {teaching_studio_id: teaching_studio_id, is_bookmarked: 1, "_token": '<?= csrf_token() ?>'},
            success: function (response) {
                if (response.message == 'success') {
                    $("#add-bookmark-btn-" + teaching_studio_id).css("display", "none");
                    $("#remove-bookmark-btn-" + teaching_studio_id).css("display", "block");
                } else {
                    $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                }
            }
        });
    }

    function removeBookmark(teaching_studio_id) {
        $.ajax({
            type: "POST",
            url: "<?= asset('bookmark_teaching_studio'); ?>",
            data: {teaching_studio_id: teaching_studio_id, is_bookmarked: 0, "_token": '<?= csrf_token() ?>'},
            success: function (response) {
                if (response.message == 'success') {
                    $("#add-bookmark-btn-" + teaching_studio_id).css("display", "block");
                    $("#remove-bookmark-btn-" + teaching_studio_id).css("display", "none");
                } else {
                    $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                }
            }
        });
    }
</script>

