<html lang="en">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">
    <?php include resource_path('views/includes/top.php'); ?>
    <style type="text/css">
        .dropzone.dz-clickable *{
            float:none !important;
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
                        <div class="box box-shadow clearfix">

                            <div class="row audio_box" style="">
                                <div class="col-sm-12">
                                    <h2 class="page-heading"><span id="counter"></span></h2>
                                    <form style="position: relative;" method="post" action="<?= asset('save_file') ?>" enctype="multipart/form-data"
                                          class="dropzone" id="my-dropzone">
                                        <textarea  id="description" placeholder="Write something or make an event..." class="create_post_box h_140 mention"></textarea>
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="dz-message" >
                                            <div class="col-xs-8">
                                                <div class="message">
                                                    <p>Drop file here or Click to Upload</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="fallback">
                                            <input type="file" name="file">
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div id="preview" style="display: none;">

                                <div class="dz-preview dz-file-preview">
                                    <div class="dz-image"><img data-dz-thumbnail/></div>

                                    <div class="dz-details">
                                        <div class="dz-size"><span data-dz-size></span></div>
                                        <div class="dz-filename"><span data-dz-name></span></div>
                                    </div>
                                    <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
                                    <div class="dz-error-message"><span data-dz-errormessage></span></div>


                                    <div class="dz-success-mark">

                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>Check</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                           sketch:type="MSPage">
                                        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                              id="Oval-2" stroke-opacity="0.198794158" stroke="#747474"
                                              fill-opacity="0.816519475" fill="#FFFFFF"
                                              sketch:type="MSShapeGroup"></path>
                                        </g>
                                        </svg>

                                    </div>
                                    <div class="dz-error-mark">

                                        <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"
                                             xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                             xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
                                        <title>error</title>
                                        <desc>Created with Sketch.</desc>
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                           sketch:type="MSPage">
                                        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474"
                                           stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
                                        <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"
                                              id="Oval-2" sketch:type="MSShapeGroup"></path>
                                        </g>
                                        </g>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                            <nav class="nav create_post_option_btns">
                                <span class="btn btn-round button_video"><span class="icon ic_addphoto"></span>Add Media</span>
                                <?php if ($current_user->type == 'artist') { ?>

                                <div class="d-flex align-items-end ml-sm-auto">
                                            <div class="d-flex align-items-center flex-wrap">
                                        <strong class="text-dark mr-1">POST AS:</strong>
                                        <select class="selectpicker" id="post_as">
                                            <option value="<?= 'u_' . $current_id ?>"><?= $current_name ?></option>
                                            <optgroup data-icon="fa fa-user" label="Event Services">
                                                <?php foreach ($groups as $group) {
                                                    ?>
                                                    <option data-subtext='<span class="bg_image_round" style="background-image: url(<?php echo getServicsImage($group->pic) ?>)"></span>'  value="e_<?= $group->id ?>"><?= $group->name ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <optgroup label="Teaching Studios">
                                                <?php foreach ($studios as $studio) { ?>
                                                    <option data-subtext='<span class="bg_image_round" style="background-image: url(<?php echo getServicsImage($studio->pic) ?>)"></span>'  value="s_<?= $studio->id ?>"><?= $studio->name ?></option>
                                                <?php } ?>
                                            </optgroup>
                                            <optgroup label="Accompanists">
                                                <?php foreach ($accompanists as $accompanist) { ?>
                                                    <option data-subtext='<span class="bg_image_round" style="background-image: url(<?php echo getServicsImage($accompanist->pic) ?>)"></span>' value="a_<?= $accompanist->id ?>"><?= $accompanist->name ?></option>
                                                <?php } ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                <?php } ?>  <input type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_event" style="display: none">
                                <!--<input id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_audio">-->
                                <div class="post_btns">
                                                
                                                <button id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-gradient btn_post_audio">
                                                    Post
                                                    <br/>
                                                <span id="status_name">Public</span>
                                                    <span class="loader_inline" id="post_loader" style="display: none;">
                                                        <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." />
                                                    </span>
                                                </button> 
                                                
                                               
                                                <button class="btn-arrow font-14 ">
                                                <span class="drop-arrow"><img src="<?php echo asset('userassets/images/down-arrow.png')?>"/></span>
                                                     <span class="loader_inline" id="post_loader" style="display: none;">
                                                        <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." />
                                                    </span> 
                                                    <ul class="post_list un_style" id="post_privacy">
                                                        <li data-list="Public" class="acvtive_list">
                                                            <span><img src="<?php echo asset('userassets/images/earth.png');?>"/></span>Public
                                                        </li>
                                                        <li data-list="Private">
                                                            <span><img src="<?php echo asset('userassets/images/lock.png');?>"/></span>Private
                                                        </li>
                                                         <?php if($post->post_type == 'u') { ?>
                                                        <li data-list="Collaborative Friends">
                                                            <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Collaborative Friends
                                                        </li>
                                                         <?php } elseif($post->post_type == 'e') { ?>
                                                        <li data-list="Members">
                                                           <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Members
                                                        </li> 
                                                         <?php } elseif($post->post_type == 'a') { ?>
                                                        <li data-list="Accompanist">
                                                           <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Accompanist
                                                        </li>
                                                         <?php } elseif($post->post_type == 's') { ?>
                                                        <li data-list="Teachers">
                                                           <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Teachers
                                                        </li>
                                                        <li data-list="Students">
                                                           <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Students
                                                        </li>
                                                         <?php } ?>

                                                        
                                                        
                                                    </ul>
                                                </button>
                                                         
                                                
                                </div>
                                <div class="fb_loader_img"><img id="post_loader" style="display: none"src="<?php echo asset('userassets/images/loader.gif') ?>" alt="loading.." class="fb_loader" style="height: 50px; width: 50px"></div>
                                </div>
                            </nav>    
                        </div> <!-- post -->
                        <input type="hidden" name="post_id" id="post_id" value="<?= $post_id ?>">

                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>
        <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
        <script src="<?php echo asset('userassets/js/dropzone-config_edit.js'); ?>"></script>
        <script src='https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js' type='text/javascript'></script>
        <script src='<?php echo asset('userassets/js/lib/jquery.elastic.js'); ?>' type='text/javascript'></script>
        <script type="text/javascript" src="<?php echo asset('userassets/js/jquery.mentionsInput.js'); ?>"></script>
        <script>
                                    $('textarea.mention').mentionsInput({
                                        defaultValue: '<?= $post->edit_data ?>',
                                        onDataRequest: function (mode, query, callback) {
                                            $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                                                responseData = _.filter(responseData, function (item) {
                                                    return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                                                });
                                                callback.call(this, responseData);
                                            });
                                        }
                                    });
                                    function submitPost() {
                                    var privacy = '';
                                    privacy = $('#status_name').text();
                                        $('textarea.mention').mentionsInput('val', function (text) {
                                            post_description = text;
                                        });
                                        post_id = '<?= $post_id ?>';
                                        $('#post_loader').show();//show loading indicator image
                                        $("#submit_post").css('pointer-events', 'none'); //disable post button
                                        $("#submit_post").unbind("click");
                                        var post_as = $('#post_as').val();
                                        if (!post_description.trim() && image_attachments.length === 0) {
                                            $('#showError').html('Please insert post data.').show().fadeOut(3000);
                                            $('#post_loader').hide();
                                            $("#submit_post").css('pointer-events', 'auto');
                                            $('#submit_post').bind('click', submitPost);
                                        } else {
                                            var images = JSON.stringify(image_attachments);
                                            $.ajax({
                                                type: "POST",
                                                url: "<?php echo asset('add_post'); ?>",
                                                data: {

                                                    post_description: post_description,
                                                    post_as: post_as,
                                                    images: images,
                                                    post_id: post_id,
                                                    privacy: privacy,
                                                    _token: $('[name="_token"]').val()
                                                },
                                                //                    processData: false,
                                                //                    contentType: false,
                                                success: function (response) {
                                                    if (response.error) {
                                                        vulgarTermsErrorAlert();
                                                        $("#submit_post").css('pointer-events', 'auto');
                                                        $('#post_loader').hide();
                                                    } else {
                                                        var objDZ = Dropzone.forElement(".dropzone");
                                                        objDZ.emit("resetFiles");
                                                        total_photos_counter = 0;
                                                        image_attachments = [];
                                                        window.location.href = '<?= asset('timeline') ?>';
                                                        $('.dropzone').removeClass('dz-started');
                                                        $("#description").val('');
                                                        $('#post_as').prop('selectedIndex', 0);
//                                                    appended_post_count = parseInt(appended_post_count) + 1;
                                                        $('#post_loader').hide();
                                                        $("#submit_post").css('pointer-events', 'auto');
                                                        $('#submit_post').bind('click', submitPost);
                                                        $('#showposts').prepend(response);
                                                    }
                                                }
                                            });
                                        }
                                    }
                                    $('.button_video').click(function () {
                                        $('.dz-message').toggle();
                                    });
        </script>
         <script>
            $('.drop-arrow').click(function(){
                $('.post_list').slideToggle();
            });
            $('.post_list li').click(function(){
                $('.post_list').fadeOut();
                var list = $(this).attr('data-list');
                $('.post_list li.acvtive_list').removeClass('acvtive_list');
                $(this).addClass('active_list');
                $('#status_name').empty();
                $('#status_name').append(list);
                // alert(list);
            });
        </script>
    </body>
</html>