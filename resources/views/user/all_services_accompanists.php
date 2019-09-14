<div class="row d-flex mb-2 align-items-center">
    <div class="col">
        <h4 class="font-weight-bold text_darkblue mb-0"> My Accompanists </h4>
    </div>
</div>
<table class="table table-hover table_attribute table_groups">
    <thead>
        <tr>
            <th>Accompanist Name</th>
            <th>Location</th>
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
            url: "<?= asset('fetch_accompanists'); ?>",
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
                    if(isScroll){
                        $('#' + container).append(response);
                    } else {
                        $('#'+container).html(response);
                    }
                    $('#loader').hide();
                    ajaxcall = 1;
                } else {
                    if ($('#'+container).is(':empty')){
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#msg-'+container).html(noposts);
                    }
                    else {
                        ajaxcall = 0;
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#msg-'+container).html(noposts);
                    }
                }
            }
        });
    }
    function openDeleteModal(group_id) {
        $('#modal_delete').modal('show');
        $('#delete-group-button').attr('onclick', 'deleteGroup(' + group_id + ')');
    }
    function deleteGroup(accompanist_id) {
        $('#delete-group-button').removeAttr('onclick');
        $.ajax({
            type: "POST",
            url: "<?= asset('delete_accompanist'); ?>",
            data: {accompanist_id: accompanist_id, "_token": '<?= csrf_token() ?>'},
            success: function (response) {
                $('#group_delete_success').fadeIn().html(response.success);
                setTimeout(function () {
                    window.location.reload();
                }, 5000);
            }
        });
    }
</script>