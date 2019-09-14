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
                        <div class="nav nav-tabs inner_tabs justify-content-sm-end justify-content-center" id="nav-tab" role="tablist">
                            <div class="row w-100">
                                <div class="col-sm-8 ml-auto">
                                    <div class="d-flex align-items-center filter_form">
                                        <div class="label_filter">
                                            <span style="width: 70px; display: block;">FILTER BY</span>
                                        </div>
                                        <select id="user_type_filter" class="form-control mr-2">
                                            <option value="artist">Musicians</option>
                                            <option value="user">Users</option>
                                        </select>
                                        <select id="follow_type_filter" class="form-control">
                                            <option value="followers">Followers</option>
                                            <option value="followings">Followings</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show active" id="gigs" role="tabpanel" aria-labelledby="services">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title" id="title_of_list_type">followers list</h4>
                                <div class="box mt-3" id="followers_list"></div>
                                <div id="js-pg-msg"></div>
                            </div>
                        </div> <!-- inner tab content -->

                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page_timeline -->
    </div> <!-- page timeline -->
    <?php if (Auth::guard('user')->check()) { ?>
        <div class="show_on_mobile clearfix">
            <?php include resource_path('views/includes/sidebar.php'); ?>
        </div>
    <?php } ?>
    <?php include resource_path('views/includes/footer.php'); ?>  

</body>
</html>

<script>

    var user_type_filter = $('#user_type_filter').val();
    var follow_type_filter = $('#follow_type_filter').val();
    var user_id = '<?= $user->id ?>';

    var ajaxcall = 1;
    var isScroll = 0;
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        load_cards(skip, take, isScroll);
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
                load_cards(skip, 12, isScroll);
            }
        }
    });

    function load_cards(skip, take, isScroll) {
        ajaxcall = 0;
        $('#loaderposts').remove();
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#followers_list').append(loader);
        $.ajax({
            type: "POST",
            dataType: "json",
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            url: "<?php echo asset('fetch_followers_profile/'); ?>",
            data: {skip: skip, take: take, user_type_filter: user_type_filter, follow_type_filter: follow_type_filter, user_id: user_id},
            success: function (response) {
                $('#loaderposts').remove();
                if (response.html) {
                    $('#followers_list').append(response.html);
                    ajaxcall = 1;
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    return true;
                } else {
                    if ($('#followers_list').is(':empty')) {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    } else {
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#js-pg-msg').html(noposts);
                    }
                    ajaxcall = 0;
                    return false;
                }
            }
        });
    }

    $('#user_type_filter').change(function () {
        $('#followers_list').html('');
        $('#js-pg-msg').html('');
        skip = 0;
        ajaxcall = 1;
        isScroll = 0;
        win = $(window);
        count = 0;
        appended_post_count = 0;
        user_type_filter = $(this).val();
        load_cards(skip, 12, isScroll);
    });

    $('#follow_type_filter').change(function () {
        $('#followers_list').html('');
        $('#js-pg-msg').html('');
        skip = 0;
        ajaxcall = 1;
        isScroll = 0;
        win = $(window);
        count = 0;
        appended_post_count = 0;
        follow_type_filter = $(this).val();
        if (follow_type_filter == 'followers')
            $('#title_of_list_type').html('Followers List');
        else if (follow_type_filter == 'followings')
            $('#title_of_list_type').html('Followings List');
        load_cards(skip, 12, isScroll);
    });

</script>

