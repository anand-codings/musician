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
                        <!-- inner tab media Start -->
                        <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                            <a onclick="change_tab('photo_media_list', 'image')" class="nav-item nav-link active" id="media_photo_btn" data-toggle="tab" href="#media_photo_tab" role="tab"> Photos </a>
                            <a onclick="change_tab('video_media_list', 'video')" class="nav-item nav-link" id="media_video_btn" data-toggle="tab" href="#media_video_tab" role="tab"> Videos </a>
                            <a onclick="change_tab('audio_media_list', 'audio')" class="nav-item nav-link" id="media_audio_btn" data-toggle="tab" href="#media_audio_tab" role="tab"> Audio </a>
                        </div>

                        <div class="tab-content" id="nav-tabContent">

                            <div class="tab-pane fade show active" id="media_photo_tab">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Photos</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="un_style clearfix photo_media_list"></ul>
                                        <div class="pagination-msg posts_end mt-0 mb-0"></div>
                                    </div>
                                </div>    
                            </div>

                            <div class="tab-pane fade" id="media_video_tab">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Videos</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="un_style clearfix video_media_list"></ul>
                                        <div class="pagination-msg posts_end mt-0 mb-0"></div>
                                    </div>
                                </div>    
                            </div>

                            <div class="tab-pane fade" id="media_audio_tab">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Audio</h4>
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="un_style clearfix audio_media_list"></ul>
                                        <div class="pagination-msg posts_end mt-0 mb-0"></div>
                                    </div>
                                </div>    
                            </div>

                        </div> <!-- inner tab content -->

                        <!-- inner tab media END -->
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
<?php if ($current_id && $current_id == $user->id) { ?>
    <script>
        $('body').on('click', '.delete_gallery_media', function () {
            var id = $(this).attr('gallery-media-id');
            $(this).parent('li').remove();
            $.ajax({
                url: base_url + 'delete_gallery_media',
                type: 'POST',
                data: {id: id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    //                window.location.reload();
                }
            });
        });
    </script>
<?php } ?>

<script>
    var ajaxcall = 1;
    var isScroll = 0;
    var type = 'image';
    var container = 'photo_media_list';
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        load_actions(skip, take, type, container, isScroll);

        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            isScroll = 1;
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                    load_actions(skip, 12, type, container, isScroll);
                }
            }
        });

    });

    function load_actions(skip, take, type, container, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('.' + container).next('.pagination-msg').html(loader);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('fetch_profile_media/'); ?>",
            data: {skip: skip, take: take, type: type, 'user_id': '<?= $user->id ?>'},
            success: function (response) {
                $('#loaderposts').remove();
                if (response) {
                    $('.' + container).append(response);
                    ajaxcall = 1;
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    return true;
                } else {
                    if ($('.' + container).is(':empty')) {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('.' + container).next('.pagination-msg').html(noposts);
                    } else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('.' + container).next('.pagination-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }

    function change_tab(tab_class, show_type) {
        $('.' + tab_class).html('');
        type = show_type;
        container = tab_class;
        load_actions(0, 12, type, container, isScroll);
    }
</script>
