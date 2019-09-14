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
                        <div class="nav nav-tabs inner_tabs justify-content-end align-items-center mt-4" id="nav-tab" role="tablist">
                             <label> <strong>Service Type:&nbsp</strong> </label>
                            <div class="d-flex align-items-center filter_form">
                              <select id="filter" class="form-control">
                                    <option value="groups">Event Services</option>
                                    <option value="teaching_studios">Teaching Studios</option>
                                    <option value="accompanists">Accompanists</option>
                                </select>
                            </div>
                        </div>
                        <div class="box box-shadow no_margin clearfix" id="services_box"></div>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->
        <?php include resource_path('views/includes/footer.php'); ?>
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
        $('#services_box').html(loader);
        $.ajax({
            type: "GET",
            url: "<?= asset('fetch_services'); ?>",
            data: {type: service_type},
            success: function (response) {
                $('#services_box').html(response.html);
            }
        });
    }
</script>