<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
<link rel="stylesheet" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">
<style type="text/css">
    .dropzone.dz-clickable * {
        float: none !important;
    }

    #status-overlay {
        height: 100%;
        width: 100%;
        background: rgba(0, 0, 0, 0.50);
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        overflow: hidden;
    }

    #highlight-textarea {
        background: #fff;
    }

    .form-control:focus {
        box-shadow: 0 0 0 2px #3399ff;
        outline: 0;
    }

    h2 {
        font-size: 20px;
    }
</style>
<?php include resource_path('views/includes/top.php'); ?>
<?php if ($current_user) { ?>
    <?php include resource_path('views/includes/header-timeline.php'); ?>
<?php } else { ?>
    <?php include resource_path('views/includes/header-search.php'); ?>
<?php } ?>

<body>

    <div class="page_timeline search-results mt-4">
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div class="browse_search mx-auto pt-3 pb-3" id="header_filter">

                        <div class="ensembles mt-3 mb-4">
                            <h4 class="text-uppercase p-3 text-center font-weight-bold d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 29 21" style="display:inline-block;">
                                    <path class="cls-1" fill="#b62e65" d="M19.149,0.364A1.959,1.959,0,0,0,17.324.125L7.3,3.887A2.032,2.032,0,0,0,6,5.788v11.5a2.84,2.84,0,0,0-2.111-.46,4.524,4.524,0,0,0-2.529,1.347A4.666,4.666,0,0,0,.036,20.748a2.875,2.875,0,0,0,.723,2.479A2.646,2.646,0,0,0,2.691,24a3.471,3.471,0,0,0,.5-0.037,4.524,4.524,0,0,0,2.529-1.347,4.666,4.666,0,0,0,1.322-2.577,3.7,3.7,0,0,0,.035-0.432c0-.008,0-9.968,0-9.968L18.919,5.2v7.239a2.84,2.84,0,0,0-2.111-.46,4.524,4.524,0,0,0-2.529,1.347A4.667,4.667,0,0,0,12.957,15.9a2.875,2.875,0,0,0,.723,2.479,2.646,2.646,0,0,0,1.932.773,3.459,3.459,0,0,0,.5-0.037,4.524,4.524,0,0,0,2.529-1.347,4.667,4.667,0,0,0,1.322-2.577C19.985,15.044,20,2.026,20,2.026A2.039,2.039,0,0,0,19.149.364ZM6,19.546a2.525,2.525,0,0,1-.025.338,3.553,3.553,0,0,1-1.016,1.953,3.447,3.447,0,0,1-1.918,1.036,1.715,1.715,0,0,1-1.516-.425A1.792,1.792,0,0,1,1.106,20.9,3.554,3.554,0,0,1,2.122,18.95,3.449,3.449,0,0,1,4.04,17.914a2.4,2.4,0,0,1,.343-0.026,1.6,1.6,0,0,1,1.173.45A1.664,1.664,0,0,1,6,19.528v0.017H6ZM18.919,4.022L7.079,8.465V5.788A0.927,0.927,0,0,1,7.673,4.92L17.7,1.158a0.882,0.882,0,0,1,.833.109,0.918,0.918,0,0,1,.388.758v2Zm0,10.674a2.546,2.546,0,0,1-.025.339,3.554,3.554,0,0,1-1.016,1.954,3.446,3.446,0,0,1-1.918,1.036,1.715,1.715,0,0,1-1.516-.424,1.793,1.793,0,0,1-.417-1.545A3.554,3.554,0,0,1,15.043,14.1a3.446,3.446,0,0,1,1.918-1.035A2.383,2.383,0,0,1,17.3,13.04a1.6,1.6,0,0,1,1.173.45,1.665,1.665,0,0,1,.442,1.191V14.7h0Z" />
                                </svg>Teaching Studio</h4>
                        </div>
                        <div class="searches-category mt-3 mb-4 text-center">
                            <h6><strong>Popular Searches:</strong></h6>
                            <ul class="d-flex align-items-center mb-0">
                                <?php foreach($popular_searches_one as $search) { ?>
                                    <li>
                                        <a href="<?= asset('search?search=&cat='.$search->id) ?>">
                                            <?= $search->title ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <div class="d-flex browse-checkboxes">
                            <?php
                            $type_list = categories('studio');
                            if (isset($type_list) && count($type_list) > 0) {
                                foreach ($type_list as $key => $typeval) {
                                    ?>

                                    <a class="category-image" style="background-image:url('<?= asset('adminassets/images/'.$typeval['image']) ?>')" href="<?= asset('search?search_type=teaching_studios&cat=' . $typeval['id']) ?>"><?= $typeval['title'] ?></a>
                                <?php
                            }
                        }
                        ?>

                        </div>

                        <div class="ensembles mt-3 mb-4">
                            <h4 class="text-uppercase p-3 text-center font-weight-bold d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 29 21" style="display:inline-block;">
                                    <path fill="#b62e65" id="Forma_1" data-name="Forma 1" class="cls-1" d="M15.428,8.986a2.37,2.37,0,0,1-2.355-2.38A6.579,6.579,0,0,0,6.536,0,6.579,6.579,0,0,0,0,6.606V18.588a0.612,0.612,0,0,0,.609.615H3.557v1.182a0.609,0.609,0,1,0,1.217,0V19.2h9.452v1.182a0.609,0.609,0,1,0,1.217,0V19.2h2.948A0.612,0.612,0,0,0,19,18.588V12.6A3.6,3.6,0,0,0,15.428,8.986ZM3.556,17.972H1.217V14.41H3.354v1.182a0.82,0.82,0,0,0,.2.541v1.839h0Zm3.557,0H4.774V16.133a0.821,0.821,0,0,0,.2-0.541V14.41H6.91v1.182a0.82,0.82,0,0,0,.2.541v1.839Zm3.557,0H8.331V16.133a0.821,0.821,0,0,0,.2-0.541V14.41h1.933v1.182a0.82,0.82,0,0,0,.2.541v1.839Zm3.556,0H11.887V16.133a0.82,0.82,0,0,0,.2-0.541V14.41h1.933v1.182a0.821,0.821,0,0,0,.2.541v1.839h0ZM1.217,13.18V6.606A5.353,5.353,0,0,1,6.536,1.231a5.353,5.353,0,0,1,5.319,5.376,3.6,3.6,0,0,0,3.573,3.611,2.37,2.37,0,0,1,2.355,2.38V13.18H1.217Zm16.565,4.793H15.444V16.133a0.82,0.82,0,0,0,.2-0.541V14.41h2.136v3.562h0Z"></path>
                                </svg>
                                Accompanist</h4>
                        </div>
                        
                        <div class="d-flex browse-checkboxes">
                            <?php
                            $type_list = categories('accompanist');
                            if (isset($type_list) && count($type_list) > 0) {
                                foreach ($type_list as $key => $typeval) {
                                    ?>
                                    <a class="category-image" style="background-image:url('<?= asset('adminassets/images/'.$typeval['image']) ?>')" href="<?= asset('search?search_type=accompanist&cat=' . $typeval['id']) ?>"><?= $typeval['title'] ?></a>
                                <?php
                            }
                        }
                        ?>
                        </div>

                        <div class="ensembles mt-3 mb-4">
                            <h4 class="text-uppercase p-3 text-center font-weight-bold d-flex align-items-center justify-content-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 29 21" style="display:inline-block;">
                                    <path class="cls-1" fill="#b62e65" d="M18.137,2.933H1.862V2.862A1.393,1.393,0,0,1,3.271,1.484H17.2a0.931,0.931,0,0,1,.942.921V2.933ZM16.384,1.244H3.616A1.258,1.258,0,0,1,4.887,0H15.112a1.258,1.258,0,0,1,1.272,1.244h0Zm1.854,2.981a0.738,0.738,0,0,1,.745.728V18.278a0.738,0.738,0,0,1-.745.728H1.761a0.738,0.738,0,0,1-.745-0.728V4.953a0.738,0.738,0,0,1,.745-0.728H18.239m0-.994H1.761A1.742,1.742,0,0,0,0,4.953V18.278A1.742,1.742,0,0,0,1.761,20H18.239A1.742,1.742,0,0,0,20,18.278V4.953a1.742,1.742,0,0,0-1.761-1.722h0Zm-5.3,10.449,0.04,0.007a2.5,2.5,0,0,1,1.729,1.62l0.076,0.225,0.04,0.04L15.3,17.206H4.693l0.533-1.823,0-.013,0-.013c0-.01.01-0.038,0.024-0.079,0-.005.017-0.05,0.036-0.1,0.038-.092.158-0.322,0.206-0.405A5.419,5.419,0,0,1,7.035,13.7a3.872,3.872,0,0,0,2.94.968,3.857,3.857,0,0,0,2.963-.992m-0.1-1.019a0.744,0.744,0,0,0-.555.251,2.792,2.792,0,0,1-2.3.765,2.792,2.792,0,0,1-2.3-.765,0.744,0.744,0,0,0-.554-0.251,0.7,0.7,0,0,0-.185.025l-0.174.042A5.94,5.94,0,0,0,4.64,14.245a5.968,5.968,0,0,0-.29.567c-0.032.078-.056,0.149-0.056,0.149-0.02.06-.035,0.111-0.045,0.149L3.64,17.193a0.8,0.8,0,0,0,.145.694,0.816,0.816,0,0,0,.638.312H15.571a0.8,0.8,0,0,0,.638-0.312,0.776,0.776,0,0,0,.145-0.709l-0.609-2.069A0.3,0.3,0,0,0,15.672,15a3.519,3.519,0,0,0-2.479-2.282l-0.174-.028a0.7,0.7,0,0,0-.185-0.025h0Zm-2.743-.22c-1.625,0-3-1.926-3-4.206a3.349,3.349,0,0,1,.063-0.609A2.924,2.924,0,0,1,7.32,7.1a3.271,3.271,0,0,1,.253-0.468A3.12,3.12,0,0,1,9.313,5.39a3.5,3.5,0,0,1,.778-0.1A2.982,2.982,0,0,1,13.1,8.235a5.115,5.115,0,0,1-.936,2.975A2.686,2.686,0,0,1,10.091,12.441ZM7.5,8.658c0.1,1.89,1.258,3.427,2.588,3.427a2.334,2.334,0,0,0,1.854-1.132,4.528,4.528,0,0,0,.747-2.517,1.394,1.394,0,0,0-.016-0.251L12.63,7.909l-0.278.068a1.109,1.109,0,0,1-.25.029,1.43,1.43,0,0,1-.944-0.353L10.94,7.465l-0.17.23a2.5,2.5,0,0,1-2.047.777,4.915,4.915,0,0,1-.9-0.081L7.487,8.329Zm2.587-3.109a2.762,2.762,0,0,1,1.944.786,2.651,2.651,0,0,1,.73,1.275l-0.476.116a0.836,0.836,0,0,1-.186.021,1.166,1.166,0,0,1-.769-0.289L10.9,7.083l-0.341.461a2.248,2.248,0,0,1-1.833.671,4.653,4.653,0,0,1-.855-0.077l-0.5-.094a3.223,3.223,0,0,1,.05-0.365A2.661,2.661,0,0,1,7.564,7.2a3.028,3.028,0,0,1,.23-0.426A2.847,2.847,0,0,1,9.382,5.639a3.174,3.174,0,0,1,.709-0.091m0-.517a3.734,3.734,0,0,0-.847.109A3.377,3.377,0,0,0,7.351,6.492,3.51,3.51,0,0,0,7.076,7a3.141,3.141,0,0,0-.178.571,3.6,3.6,0,0,0-.068.662c0,2.424,1.493,4.465,3.262,4.465,1.74,0,3.276-2.084,3.276-4.465a3.237,3.237,0,0,0-3.276-3.2h0Zm-1.369,3.7a2.743,2.743,0,0,0,2.261-.885,1.7,1.7,0,0,0,1.118.418,1.378,1.378,0,0,0,.314-0.037,1.161,1.161,0,0,1,.013.209c0,1.806-1.093,3.391-2.337,3.391-1.194,0-2.236-1.462-2.324-3.182a5.21,5.21,0,0,0,.955.086h0Z" />
                                </svg>Event Service</h4>
                        </div>
                        <div class="searches-category mt-3 mb-4 text-center">
                            <h6><strong>Popular Searches:</strong></h6>
                            <ul class="d-flex align-items-center mb-0">
                                <?php foreach($popular_searches_two as $search) { ?>
                                    <li>
                                        <a href="<?= asset('search?search=&cat='.$search->id) ?>">
                                            <?= $search->title ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="d-flex browse-checkboxes">
                            <h5 class="font-weight-bold text-center d-block w-100">SOLO</h5>
                            <?php
                            $type_list = categories('group', 'solo');
                            if (isset($type_list) && count($type_list) > 0) {
                                foreach ($type_list as $key => $typeval) {
                                    ?>
                                    <a class="category-image" style="background-image:url('<?= asset('adminassets/images/'.$typeval['image']) ?>')" href="<?= asset('search?search_type=groups&cat=' . $typeval['id']) ?>"><?= $typeval['title'] ?></a>
                                <?php
                            }
                        }
                        ?>
                        </div>
                        <div class="d-flex browse-checkboxes">
                            <h5 class="font-weight-bold text-center d-block w-100">ENSEMBLE</h5>
                            <?php
                            $type_list = categories('group', 'ensemble');
                            if (isset($type_list) && count($type_list) > 0) {
                                foreach ($type_list as $key => $typeval) {
                                    ?>
                                    <a class="category-image" style="background-image:url('<?= asset('adminassets/images/'.$typeval['image']) ?>')" href="<?= asset('search?search_type=groups&cat=' . $typeval['id']) ?>"><?= $typeval['title'] ?></a>
                                <?php
                            }
                        }
                        ?>
                        </div>

                    </div>

                </div>
            </div>
        </div> <!-- container -->
    </div> <!-- page timeline -->

    <?php include resource_path('views/includes/footer.php'); ?>
    <script>
        function geolocate() {
            var geocoder = new google.maps.Geocoder;
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var latlng = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                    geocoder.geocode({
                        'location': latlng
                    }, function(results, status) {
                        if (status === 'OK') {
                            if (results[0]) {
                                $('#autocomplete').val(results[0]['formatted_address']);
                                $('#autocomplete').trigger("change");
                            }
                        }
                    });

                });
            }
        }
    </script>
    <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
    <script src="<?php echo asset('userassets/js/dropzone-config.js'); ?>"></script>
    <script src="https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js"></script>
    <script src="<?php echo asset('userassets/js/lib/jquery.elastic.js'); ?>"></script>
    <script src="<?php echo asset('userassets/js/jquery.mentionsInput.js'); ?>"></script>
</body>

</html>