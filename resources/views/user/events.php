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
                            <div class="row d-flex mb-2 align-items-center">
                                <div class="col">
                                    <h4 class="font-weight-bold text_darkblue mb-0"> My Gigs </h4>
                                </div>
                                <div class="col-sm-auto">
                                    <nav>
                                        <div class="nav nav-tabs event_type_tab" id="nav-tab" role="tablist">
                                            <a data-type="active" data-div="events_list_view_active" class="event_tab nav-item nav-link active" id="standard-booking-tab" data-toggle="tab" href="#standard-booking" role="tab" aria-controls="nav-home" aria-selected="true">Active</a>
                                            <a data-type="inactive" data-div="events_list_view_inactive" class="event_tab nav-item nav-link" id="custom-booking-tab" data-toggle="tab" href="#custom-booking" role="tab" aria-controls="nav-profile" aria-selected="false">Inactive</a>
                                        </div>
                                    </nav>
                                </div>
                            </div>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="standard-booking" role="tabpanel" aria-labelledby="standard-booking-tab">
                                    <table class="table table-hover table_events table_attribute">
                                        <thead>
                                        <tr>
                                            <th>Gig Names</th>
                                            <th>States</th>
                                            <th>Location</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="events_list_view_active"></tbody>
                                    </table> <!-- table -->
                                    <div id="msg_events_list_view_active"></div>
                                </div> <!-- tab 1 -->
                                <div class="tab-pane fade" id="custom-booking" role="tabpanel" aria-labelledby="custom-booking-tab">
                                    <table class="table table-hover table_events table_attribute">
                                        <thead>
                                            <tr>
                                                <th>Gig Names</th>
                                                <th>States</th>
                                                <th>Location</th>
                                                <th>Price</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="events_list_view_inactive"></tbody>
                                    </table> <!-- table -->
                                    <div id="msg_events_list_view_inactive"></div>
                                    <div id="actions-msg"></div>
                                </div> <!-- tab 2 -->
                            </div> <!-- tabs -->
                        </div> <!-- Box -->
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>
     </body>
<script>

    function changeCoverPhotoInEditEvent(ele)
    {
        var event_id = $(ele).attr('event-id');
        $('#events_pic'+event_id).show();
        $('#upload_image'+event_id).hide();
        if (ele.files && ele.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_event_img'+event_id).attr('src', e.target.result);
            }
            reader.readAsDataURL(ele.files[0]);
        }
    }
    
    function showImageInEditCase(ele){
        var event_id = $(ele).attr('event-id');
        $('#events_pic'+event_id).hide();
        $('#upload_image'+event_id).show();
        $('#preview_event_img'+event_id).attr('src', '');
        $('#cover_image'+event_id).val('');
        $('#edit-gig-cover-photo-input'+event_id).val('');
        $.ajax({
          type: "POST",
          data: {'id' : event_id},
          url: "<?php echo asset('delete_event_pic'); ?>",
          dataType: "json",
          beforeSend: function (request) {
              return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          }
      });
    }
    
    var ajaxcall = 1;
    var isScroll = 0;
    var type = 'active';
    var container = 'events_list_view_active';
    var win = $(window);
    var count = 0;
    appended_post_count = 0;

    $(document).ready(function () {

        $('body').on('keyup','#descriptin_count',function(){
            limit = 300;
            $this = $(this);
            var value = $this.val();
            var len = value.length;
            if (len >= limit) {

                $this.value = val.value.substring(0, limit);
            } else {
                $('.text_length_desc').text(limit - len);

            }
        });

        $('body').on('keyup','#title_count',function(){
            limit = 150;
            $this = $(this);
            var value = $this.val();
            var len = value.length;
            if (len >= limit) {

                $this.value = $this.value.substring(0, limit);
            } else {
                $('.text_length_title').text(limit - len);

            }
        });


      $('body').on('click','.delete_event',function(){
          var id = $(this).attr('data-id');
          $.ajax({
              type: "POST",
              data: {id:id},
              url: "<?php echo asset('delete_event'); ?>",
              dataType: "json",
              beforeSend: function (request) {
                  return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
              },
              success: function (data) {
                  $('.row_'+id).fadeOut('show');
                  $('.modal').modal('hide');
               }
          });

      });


      $('body').on('focus','.setDate',function(){$('.setDate').datepicker()});
      $('body').on('focus','#timepicker1',function(){$('#timepicker1').timepicker();});
      $('body').on('focus','#autocomplete',function(){
        $("#autocomplete")
                .geocomplete()
                .bind("geocode:result", function (event, result) {
                    $("#lat").val(result.geometry.location.lat());
                    $("#lng").val(result.geometry.location.lng());
                });
        });
        var skip = 0;
        var take = 12;
        load_actions(skip, take, type, container, isScroll);


        $('body').on('click', '.btn_post_event_update', function (e) {
            var event_id = $(this).attr('event-id');
            $('#edit_gig_loader'+event_id).show();
            $form = $('#update_event'+event_id);
            var formData = new FormData($form[0]);
            $this = $(this);
            $this.attr('disabled', true);
            //pick form data
            $.ajax({
                type: "POST",
                data: formData,
                url: "<?php echo asset('timeline'); ?>",
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    $('#edit_gig_loader'+event_id).show();
                    if (data.success) {
                        $('.ajax-response').show();
                        $('.ajax-response').removeClass('alert-danger');
                        $('.ajax-response').addClass('alert-success');
                        $('.ajax-response').html('Event Updated Successfully');
                        $form[0].reset();
                    } else {
                        $('.ajax-response').show();
                        $('.ajax-response').removeClass('alert-success');
                        $('.ajax-response').addClass('alert-danger');
                        $('.ajax-response').html(data.message);
                    }
                    $("html, .modal").animate({scrollTop: 0}, 600);
                    setTimeout(function(){
                        window.location.reload();
                    }, 2000);
                },
                complete: function () {
                    $this.attr('disabled', false);
                }
            });

        });

    });

    $('body').on('click','.event_tab',function () {
        isScroll = 0;
       var type  = $(this).attr('data-type');
       container  = $(this).attr('data-div');
       $('#'+container).html('');
        load_actions(0, 12, type, container, isScroll);
        
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

        $('#loader').show();
        ajaxcall = 0;

        $.ajax({
            url: "<?php echo asset('get_events') ?>",
            type: "GET",
            dataType: "json",
            data: {
                "skip": skip,
                "take": take,
                "type": type
            },
            beforeSend: function () {
                $('.loader_center').remove();
                $('#loader').show();
            },
            success: function (data) {
                if (data) {
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    if(isScroll){
                    $('#'+container).append(data);
                    } else {
                        $('#'+container).html(data);
                    }
                    $('#loader').hide();
                    ajaxcall = 1;
                } else {
                    if ($('#'+container).is(':empty')){
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No Record Found</div></div> ';
                        $('#msg_'+container).html(noposts);
                    }
                    else {
                        ajaxcall = 0;
                        $('#loader').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No More Record To Show</div></div> ';
                        $('#msg_'+container).html(noposts);
                    }
                }
            }
        });
    }

function showimage(){
    $('.events_pic').hide();
    $('.upload_image').show();
    $('#preview').attr('src', '');
    $('#cover_image').val('');
}

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('body').on('change','#cover_image',function () {
        $('.upload_image').hide();
        $('.events_pic').show();
        readURL(this);
    });
</script>
</html>