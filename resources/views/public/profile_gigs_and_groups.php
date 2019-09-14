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
                            <!--                        <a onclick="change_tab('show_gigs', 'gigs')" class="nav-item nav-link active" id="timeline-tab" data-toggle="tab" href="#gigs" role="tab" aria-controls="nav-timeline" aria-selected="true">
                                                        Gigs
                                                    </a>
                                                    <a onclick="change_tab('show_groups', 'groups')" class="nav-item nav-link" id="services-tab" data-toggle="tab" href="#event_group" role="tab" aria-controls="nav-services" aria-selected="false">
                                                        Groups
                                                    </a>-->
                            <div class="d-flex align-items-center filter_form">
                                <select id="filter" class="form-control">
                                    <!--<option value="gigs">Gigs</option>-->
                                    <option value="groups">Event Services</option>
                                    <option value="teaching_studios">Teaching Studios</option>
                                    <option value="accompanists">Accompanists</option>
                                </select>
                            </div>
                        </div>

                        <div class="tab-content" id="nav-tabContent">
                            <!--                        <div class="tab-pane fade show active" id="gigs" role="tabpanel" aria-labelledby="services">
                                                        <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Gigs Services list</h4>
                                                        <ul class="un_style gigs_list clearfix" id="show_gigs"></ul>
                                                        <div class="pagination-msg"></div>
                                                    </div>  tab services -->
                            <div class="tab-pane fade" id="event_group" role="tabpanel" aria-labelledby="services">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Event Services list</h4>
                                <div class="row" id="show_groups"></div> <!-- row -->
                                <div class="pagination-msg"></div>
                            </div> <!-- tab Group -->
                            <div class="tab-pane fade" id="teaching_studios" role="tabpanel" aria-labelledby="services">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Teaching Studios list</h4>
                                <div class="row" id="show_teaching_studios"></div> <!-- row -->
                                <div class="pagination-msg"></div>
                            </div> <!-- tab Group -->
                            <div class="tab-pane fade" id="accompanists" role="tabpanel" aria-labelledby="services">
                                <h4 class="font-weight-bold text_darkblue text-uppercase inner_tab_title">Accompanists list</h4>
                                <div class="row" id="show_accompanists"></div> <!-- row -->
                                <div class="pagination-msg"></div>
                            </div> <!-- tab Group -->
                        </div> <!-- inner tab content -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php if (Auth::guard('user')->check()) { ?>
            <div class="show_on_mobile clearfix">
                <?php include resource_path('views/includes/sidebar.php'); ?>
            </div>
        <?php } ?>
        <?php include resource_path('views/includes/footer.php'); ?>  

        <script>
            $('#filter').change(function () {
                var filter_val = $(this).val();

                if (filter_val === 'gigs') {
                    $('#gigs').show();
                    $('#gigs').addClass('show');
                    $('#event_group').hide();
                    $('#event_group').removeClass('show');
                    $('#teaching_studios').hide();
                    $('#teaching_studios').removeClass('show');
                    $('#accompanists').hide();
                    $('#accompanists').removeClass('show');
                    change_tab('show_gigs', 'gigs');
                } else if (filter_val === 'groups') {
                    $('#gigs').hide();
                    $('#gigs').removeClass('show');
                    $('#event_group').show();
                    $('#event_group').addClass('show');
                    $('#teaching_studios').hide();
                    $('#teaching_studios').removeClass('show');
                    $('#accompanists').hide();
                    $('#accompanists').removeClass('show');
                    change_tab('show_groups', 'groups');
                } else if (filter_val === 'teaching_studios') {
                    $('#gigs').hide();
                    $('#gigs').removeClass('show');
                    $('#event_group').hide();
                    $('#event_group').removeClass('show');
                    $('#teaching_studios').show();
                    $('#teaching_studios').addClass('show');
                    $('#accompanists').hide();
                    $('#accompanists').removeClass('show');
                    change_tab('show_teaching_studios', 'teaching_studios');
                } else if (filter_val === 'accompanists') {
                    $('#gigs').hide();
                    $('#gigs').removeClass('show');
                    $('#event_group').hide();
                    $('#event_group').removeClass('show');
                    $('#teaching_studios').hide();
                    $('#teaching_studios').removeClass('show');
                    $('#accompanists').show();
                    $('#accompanists').addClass('show');
                    change_tab('show_accompanists', 'accompanists');
                }
            });

            function copyGroupLink(post_id) {
                var copyTextValue = $("#group-url-" + post_id).attr('link');
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

            function report_group(group_id) {
                $('input[name=reason].reason_' + group_id + ':checked').val();
                reason = $('input[name=reason].reason_' + group_id + ':checked').val();
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('report_group'); ?>",
                    data: {"group_id": group_id, "reason": reason},
                    success: function (response) {
                        $('#modal_reporting_' + group_id).modal('hide');
                        $('#report_group_' + group_id).hide();
                        $('#reported_group_' + group_id).show();
                    }
                });
            }

            var ajaxcall = 1;
            var isScroll = 0;
            var type = 'groups';
            var container = 'show_groups';
            var win = $(window);
            var count = 0;
            appended_post_count = 0;

            $(document).ready(function () {
                $('#gigs').hide();
                $('#gigs').removeClass('show');
                $('#event_group').show();
                $('#event_group').addClass('show');
                $('#teaching_studios').hide();
                $('#teaching_studios').removeClass('show');
                $('#accompanists').hide();
                $('#accompanists').removeClass('show');
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
                $('#' + container).append(loader);
                $.ajax({
                    type: "GET",
                    url: "<?php echo asset('fetch_gigs_groups/'); ?>",
                    data: {skip: skip, take: take, type: type, 'user_id': '<?= $user->id ?>'},
                    success: function (response) {
                        $('#loaderposts').remove();
                        if (response) {
                            $('#' + container).append(response);
                            ajaxcall = 1;
                            var a = parseInt(1);
                            var b = parseInt(count);
                            count = b + a;
                            return true;
                        } else {
                            if ($('#' + container).is(':empty')) {
                                noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                                $('#' + container).next('.pagination-msg').html(noposts);
                            } else {
                                noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                                $('#' + container).next('.pagination-msg').html(noposts);
                            }
                            ajaxcall = 0;
                            return false;
                        }
                    }
                });
            }

            function change_tab(tab_id, show_type) {
                $('#' + tab_id).html('');
                type = show_type;
                container = tab_id;
                load_actions(0, 12, type, container, isScroll);
            }
        </script>
    </body>
</html>

