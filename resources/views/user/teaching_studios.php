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
                    </div>
                    <div class="col-lg-9 col-md-12">
                        <div class="box box-shadow no_margin clearfix">
                            <div class="row d-flex mb-2 align-items-center">
                                <div class="col">
                                    <h4 class="font-weight-bold text_darkblue mb-0"> My Teaching Studios </h4>
                                </div>
                                <div class="col-sm-auto">
                                    <nav>
                                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                            <a onclick="change_tab('my-created-groups', 'owned')" class="nav-item nav-link active" id="nav-group-created-tab" data-toggle="tab" href="#group-created-tab" role="tab" aria-controls="group-created-tab" aria-selected="true">My Created</a>
                                            <a onclick="change_tab('my-joined-groups', 'joined')" class="nav-item nav-link" id="nav-group-join-tab" data-toggle="tab" href="#group-joined-tab" role="tab" aria-controls="group-joined-tab" aria-selected="false">Joined</a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="group-created-tab" role="tabpanel" aria-labelledby="group-created-tab">
                                    <table class="table table-hover table_attribute table_groups">
                                        <thead>
                                            <tr>
                                                <th>Studio Name</th>
                                                <th>Location</th>
                                                <th>Joined Members</th>
                                                <th>Actions</th>
                                            </tr>                                            
                                        </thead>
                                        <tbody id="my-created-groups">
                                        </tbody>
                                    </table> <!-- table -->
                                    <div id="msg-my-created-groups"></div>
                                    <!-- Delete Model-->
                                    <div class="modal fade" id="modal_delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Delete</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <i class="fas fa-times-circle"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h5 style="display: none" class="alert alert-success" id="group_delete_success"></h5>
                                                    <div>
                                                        <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                                                    </div>
                                                    <div class="mt-3 text-center">
                                                        <button type="button" id="delete-group-button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                                        <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                                    </div>
                                                </div> <!-- modal body -->
                                            </div>
                                        </div>
                                    </div> 
                                    <!-- Delete modal -->
                                </div> <!-- tab 1 -->

                                <div class="tab-pane fade" id="group-joined-tab" role="tabpanel" aria-labelledby="group-joined-tab">
                                    <table class="table table-hover table_attribute table_groups">
                                        <thead>
                                            <tr>
                                                <th>Studio Name</th>
                                                <th>Location</th>
                                                <th>Team</th>
                                            </tr>
                                        </thead>
                                        <tbody id="my-joined-groups">
                                        </tbody>
                                    </table> <!-- table -->  
                                    <div id="msg-my-joined-groups"></div>
                                </div> <!-- tab 2 -->
                            </div> <!-- tabs -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
    </body>
</html>

<script>
    var ajaxcall = 1;
    var isScroll = 0;
    var container = 'my-created-groups';
    var win = $(window);
    var count = 0;
    var type = 'owned';
    appended_post_count = 0;
    $(document).ready(function () {
        var skip = 0;
        var take = 12;
        load_groups(skip, take, type, container, isScroll);

        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            isScroll = 1;
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 12) + parseInt(appended_post_count);
                    load_groups(skip, 12, type, container, isScroll);
                }
            }
        });

    });
    function load_groups(skip, take, type, container, isScroll) {
        $('#loader').show();
        ajaxcall = 0;
        $.ajax({
            type: "GET",
            url: "<?= asset('fetch_teaching_studios'); ?>",
            data: {skip: skip, take: take, type: type},
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
                        $('#' + container).append(response);
                    } else {
                        $('#' + container).html(response);
                    }
                    $('#loader').hide();
                    ajaxcall = 1;
                } else {
                    if ($('#' + container).is(':empty')) {
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#msg-' + container).html(noposts);
                    } else {
                        ajaxcall = 0;
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#msg-' + container).html(noposts);
                    }
                }
            }
        });
    }

    function change_tab(tab_id, showType) {
        $('#' + tab_id).html('');
        container = tab_id;
        type = showType;
        $('#' + container).html('');
        load_groups(0, 12, type, container, isScroll);
    }

    function openDeleteModal(group_id) {
        $('#modal_delete').modal('show');
        $('#delete-group-button').attr('onclick', 'deleteGroup(' + group_id + ')');
    }
    function deleteGroup(teaching_studio_id) {
        $('#delete-group-button').removeAttr('onclick');
        $.ajax({
            type: "POST",
            url: "<?= asset('delete_teaching_studio'); ?>",
            data: {teaching_studio_id: teaching_studio_id, "_token": '<?= csrf_token() ?>'},
            success: function (response) {
                $('#group_delete_success').fadeIn().html(response.success);
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            }
        });
    }
</script>