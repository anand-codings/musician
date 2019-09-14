<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">
    <?php include resource_path('views/includes/top.php'); ?>
    

    <body>
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-3">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-md-12 col-lg-9">
                        <div class="alert alert-danger ajax-response" style="display: none;"></div>
                        <!-- post -->

                        <div id="showposts"> </div>
                        <?php if (!$post_count) { ?>
                            <div class="text-center">
                                <div class="empty_timeline_message">
                                    <h3>Welcome to Musician</h3>
                                    <p>Get Started by following Musician & friends. You'll see their photos, videos & events here.</p>
                                    <a href="#" class="btn btn-red btn-round">Explore now </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/dropzone-config.js'); ?>"></script>
        <script src="https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js"></script>
        <script src="<?php echo asset('userassets/js/lib/jquery.elastic.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/jquery.mentionsInput.js'); ?>"></script>

        <script>
            $(document).ready(function () {

                $('.button_video').click(function () {
                    $('.post_box').fadeOut('slow', function () {
                        //Toggle forms
                        $('.audio_box').show();
                        $('.ajax-response').hide();
                        //Toggle buttons
                        $('.btn_post_audio').show();
                        $('.btn_post_event').hide();
                        //reset form values

                        $('#create_event')[0].reset();
                    });
                });


            });
            var win = $(window);
            var count = 0;
            var ajaxcall = 1;
            appended_post_count = 0;

            function load_post(skip, take) {
                $('#loaderposts').remove();
                var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
                $('#showposts').append(loader);
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('fetch_post/' . $post_id); ?>",
                    data: {skip: skip, take: take},
                    success: function (response) {
                        $('#loaderposts').remove();
                        if (response) {
                            $("#showposts").css("display", "block");
                            $('#showposts').append(response);
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
                var skip = 0;
                var take = 1;
                load_post(skip, take);
            });

            function report_post(post_id) {
                $('input[name=reason].reason_' + post_id + ':checked').val();
                reason = $('input[name=reason].reason_' + post_id + ':checked').val();

                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('report_single_post'); ?>",
                    data: {"post_id": post_id, "reason": reason},
                    success: function (response) {
                        $('#modal_reporting_' + post_id).modal('hide');
                        $('#report_post_' + post_id).hide();
                        $('#reported_post_' + post_id).show();
                    }
                });
            }

            function deletePost(post_id) {
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('delete_post'); ?>",
                    data: {post_id: post_id},
                    success: function (response) {
                        if (response.message == 'success') {
                            $("#single-post-" + post_id).remove();
                            $('#showSuccess').html('Post Deleted Successfully').fadeIn().fadeOut(5000);
                            $('#modal_delete_' + post_id).modal('hide');
                        } else {
                            $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                            $('#modal_delete_' + post_id).modal('hide');
                        }
                    }
                });

            }

            function copyPostLink(post_id) {
                var copyTextValue = document.getElementById("post-url-" + post_id).value;
                var tempInput = document.createElement("input");
                tempInput.style = "position: absolute; left: -1000px; top: -1000px";
                tempInput.value = copyTextValue;
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand("copy");
                document.body.removeChild(tempInput);
//                                        copyText.style.display = 'block';
//                                        copyText.select();
//                                        document.execCommand("copy");
                $('#showSuccess').html('Copied Successfully').fadeIn().fadeOut(5000);
//                                        copyText.style.display = 'none';
            }

            function add_bookmard(post_id, type) {
                $(".wall-post-single-bookmarkremove-" + post_id).css("display", "block");
                $(".wall-post-single-bookmarkadd-" + post_id).css("display", "none");
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_favourites_post'); ?>",
                    data: {type: type, post_id: post_id, is_like: 1, "_token": '<?= csrf_token() ?>'},
                    success: function (response) {
                        if (response.message == 'success') {
                        } else {
                            $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                        }
                    }
                });
            }

            function remove_bookmard(post_id, type) {
                $(".wall-post-single-bookmarkadd-" + post_id).css("display", "block");
                $(".wall-post-single-bookmarkremove-" + post_id).css("display", "none");
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

    </body>
</html>