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
        <div class="page_message">
            <div class="container md-fluid-container">
                <div class="row">
                    <div class="col-lg-3 col-md-12">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-lg-9 col-md-12">
                        <div class="box box-shadow no_margin clearfix">
                            <div class="d-flex mb-2 align-items-center">
                                <div>
                                    <h4 class="font-weight-bold text_darkblue mb-0"> Favourites </h4>
                                </div>
                                <div class="ml-auto">
                                    <form method="get">
                                        <div class="bookmark_dropdown">
                                            <select name="filter" onchange="this.form.submit()" class="form-control selct2_select" style="width: 100%">
                                                <option  value="">All Favourites</option>
                                                <option <?php if (isset($_GET['filter'])) {
                            if ($_GET['filter'] == 'text') {
                                ?> selected=""<?php }
                                            }
                        ?> value="text">Text</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                if ($_GET['filter'] == 'image') {
                                                    ?> selected=""<?php }
                                            }
                        ?> value="image">Photo</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                        if ($_GET['filter'] == 'video') {
                                ?> selected=""<?php }
                                            }
                        ?> value="video">Video</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                        if ($_GET['filter'] == 'audio') {
                                ?> selected=""<?php }
                                            }
                        ?> value="audio">Music</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                if ($_GET['filter'] == 'group') {
                                                    ?> selected=""<?php }
                                            }
                        ?> value="group">Group</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                if ($_GET['filter'] == 'teaching_studio') {
                                                    ?> selected=""<?php }
                                            }
                        ?> value="teaching_studio">Teaching Studio</option>
                                                <option <?php if (isset($_GET['filter'])) {
                                                if ($_GET['filter'] == 'accompanist') {
                                                    ?> selected=""<?php }
                                            }
                        ?> value="accompanist">Accompanist</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-hover table_bookmarks table_attribute">
                                <thead>
                                    <tr>
                                        <th>Event Names</th>
                                        <th>Time</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="showfavourites"></tbody>
                            </table> <!-- table -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
<?php include resource_path('views/includes/footer.php'); ?>
<?php
$filter = '';
if (isset($_GET['filter'])) {
    $filter = $_GET['filter'];
}
?>
    </body>
    <script>

        var win = $(window);
        var count = 0;
        var ajaxcall = 1;
        var isScroll = 0;
        appended_post_count = 0;
        var filter = '<?= $filter ?>';

        function load_posts(skip, take) {
            $('#loader').show();
            ajaxcall = 0;
            $.ajax({
                type: "GET",
                url: "<?php echo asset('fetch_favourites/'); ?>",
                data: {skip: skip, take: take, filter: filter},
                beforeSend: function () {
                    $('.loader_center').remove();
                    $('#loader').show();
                },
                success: function (response) {
                    if (response) {
                        var a = parseInt(1);
                        var b = parseInt(count);
                        count = b + a;
                        if (isScroll) {
                            $('#showfavourites').append(response);
                        } else {
                            $('#showfavourites').html(response);
                        }
                        $('#loader').hide();
                        ajaxcall = 1;
                    } else {
                        if ($('#showfavourites').is(':empty')) {
                            $('#loader').hide();
                            noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                            $('table').after(noposts);
                        } else {
                            ajaxcall = 0;
                            $('#loader').hide();
                            noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                            $('table').after(noposts);
                        }
                    }
                }
            });
        }
        $(document).ready(function () {
            // load posts
            var skip = 0;
            var take = 20;
            load_posts(skip, take);

            win.on('scroll', function () {
                var docheight = parseInt($(document).height());
                var winheight = parseInt(win.height());
                var differnce = (docheight - winheight) - win.scrollTop();
                if (differnce < 100) {
                    if (ajaxcall === 1) {
                        //                        console.log(ajaxcall);
                        $('#loaderposts').remove();
                        var loader = '<div class="loader" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
                        $('#showposts').append(loader);
                        ajaxcall = 0;
                        var skip = (parseInt(count) * 5) + parseInt(appended_post_count);

                        var response = load_posts(skip, 20);
                        //                        console.log('ajax response: ', response);
                    }
                    $('#loaderposts').remove();
                }
            });

        });

        function remove_bookmard(post_id, type) {
            $('#single_fave_post_' + post_id).remove();
            $.ajax({
                type: "POST",
                url: "<?php echo asset('add_favourites_post'); ?>",
                data: {type: type, post_id: post_id, is_like: 0, "_token": '<?= csrf_token() ?>'},
                success: function (response) {
                    if (response.message == 'success') {
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }
    </script>
</html>

