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
        <div class="page_create_group">
            <form id="service-form" action="<?= asset('create_group') ?>" method="post" enctype="multipart/form-data">
                <?php
                $cover = asset('public/images/teaching_studios/cover_photo_demo.png');
                ?>
                <div id="cover_image_header" class="group_profile_cover_photo" id="cover-pic-div" style="display: none; ">
                    <div id="capture"><img class="" id="cover_image"  src="<?= $cover ?>" ></div>
                    <div class="jwc_btns">
                        <input type="button" class="btn btn-info" value="Save" onclick="saveForm()">
                        <input type="button" class="btn btn-danger" value="Cancel" onclick="cancelForm()">
                    </div>
                </div>
                <div class="group_profile_cover_photo" id="cover-pic-div" style="background-image: url('<?= $cover ?>')">
                    <div class="overlay_color">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-lg-3 col-sm-4">
                                    <div class="edit_user_profile_pic">
                                        <?php
                                        $pic = asset('public/images/profile_pics/demo.png');
                                        ?>
                                        <div class="image" id="profile-pic-div" style="background-image:url(<?= $pic ?>)"></div>
                                        <ul class="un_style no_icon action_dropdown">
                                            <li class="dropdown">
                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                                <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                    <a class="dropdown-item profile_upload_btn" href="#">
                                                        <input type="file" name="photo_base64" id="profile-photo" accept="image/*"/>
                                                        <i class="fas fa-cloud-upload-alt"></i> Upload Photo 
                                                    </a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>

                                    <div class="modal" id="upload_profile_pic_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Upload Profile Pic</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-2"></div>
                                                        <div class="col-md-8">
                                                            <div id="upload-demo"></div>
                                                            <input type="hidden" name="original_photo">
                                                            <input type="hidden" name="photo">
                                                            <button type="button" id="save_profile_pic" class="btn btn-success btn-block mt-4">Save</button>
                                                        </div>
                                                        <div class="col-md-2"></div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div> <!-- col -->
                                <div class="col-lg-6 d-none d-lg-block">
                                    <div class="d-flex justify-content-center">
                                        <div class="custom-file upload_btn text-center mx-auto">
                                            <input type="file" name="cover" id="upload-cover-pic" class="custom-file-input">
                                            <strong class="text_aqua txt-20">+ Add Cover Photo</strong>
                                            <p class="text_grey">Best result size  1920 x 430 pixels</p>
                                        </div>
                                    </div>  
                                </div> <!-- col -->
                            </div> <!-- row -->
                        </div> <!-- container -->
                    </div> <!-- overlay color -->
                </div> <!-- cover photo -->

                <div class="filter_form mt-4 text-center">
                  <label> <strong>Service Type:&nbsp</strong> </label>
                    <select id="filter" class="form-control" style="width: 292px; margin: auto;max-width: 100%;">
                        <option value="groups">Event Services</option>
                        <option value="teaching_studios">Teaching Studios</option>
                        <option value="accompanists">Accompanists</option>
                    </select>
                </div>

                <div id="dynamic_section"></div>

            </form>
            <?php if (Auth::guard('user')->check()) { ?>
                <div class="sidebar show_on_mobile">
                    <?php include resource_path('views/includes/sidebar.php'); ?>
                </div>
            <?php } ?>
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
        <style>
            input.error {
                border:solid 1px red !important;
            }
            #group-form label.error {
                width: auto;
                display: none !important;
                color:red;
                font-size: 16px;
                float:right;
            }
            .ui-autocomplete{
                max-height: 200px;
                overflow-y: auto;
                overflow-x: hidden;
            }
        </style>
    </body>
</html>
<script>
    $(document).ready(function () {
        var filter_val = $('#filter').val();
        load_services(filter_val);
    });
    $('#filter').change(function () {
        var filter_val = $(this).val();
        load_services(filter_val);
    });
    function load_services(service_type) {
        var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader"></div>';
        $('#dynamic_section').html(loader);
        $.ajax({
            type: "GET",
            url: "<?= asset('fetch_dynamic_section_for_create_service'); ?>",
            data: {type: service_type},
            success: function (response) {
                $('#dynamic_section').html(response.html);
                initAutocomplete();
            }
        });
    }
     function readFile() {
        var filename = $("#upload-cover-pic").val();
        var fileType = filename.replace(/^.*\./, '');
        var ValidImageTypes = ["jpg", "jpeg", "png"];
          if ($.inArray(fileType, ValidImageTypes) < 0) {
            document.getElementById("test").innerHTML  = '';
            document.getElementById("original_cover").value  = '';
            alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
            event.preventDefault();
            $('#upload-cover-pic').val('');
            $('#original_cover').val('');
              return;
          }
      if (this.files && this.files[0]) {

        var FR= new FileReader();

        FR.addEventListener("load", function(e) {
          document.getElementById("original_cover").value  = '';
          document.getElementById("original_cover").value  = e.target.result;
        });

        FR.readAsDataURL( this.files[0] );
      }
    }

</script>