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
                        <div class="box box-shadow nopadding clearfix">
                            <div class="notification-page">
                                <ul class="un_style notification_list" id="all_notifications">

                                </ul> <!-- notification_list -->
                            </div>
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>          
    </body>
    <script>
        var win = $(window);
        var count = 0;
        var ajaxcall = 1;
        appended_post_count = 0;
        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    $('#loaderposts').remove();
                    var loader = '<div class="loader" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
                    $('#showposts').append(loader);
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 5) + parseInt(appended_post_count);

                    var response = load_notifications(skip, 20);
                }
                $('#loaderposts').remove();
            }
        });
        function load_notifications(skip, take) {
            $('#loaderposts').remove();
            var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
            $('#showposts').append(loader);
            $.ajax({
                type: "GET",
                url: "<?php echo asset('fetch_notifications/'); ?>",
                data: {skip: skip, take: take},
                success: function (response) {
                    $('#loaderposts').remove();
                    if (response) {
                        $("#all_notifications").css("display", "block");
                        $('#all_notifications').append(response);
                        ajaxcall = 1;
                        var a = parseInt(1);
                        var b = parseInt(count);
                        count = b + a;
                        return true;
                    } else {
                        ajaxcall = 0;

                        noposts = '<div id="nomoreposts"><div class="posts_end">No More Post To Show</div></div>';
                        $('#showposts').append(noposts);
                        return false;
                    }
                }
            });
        }
        $(document).ready(function () {

            // load posts
            var skip = 0;
            var take = 20;
            load_notifications(skip, take);
        });

    </script>
</html>