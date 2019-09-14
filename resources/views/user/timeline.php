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
        #youtube_modal_body {
            max-height: 400px;
            overflow: auto;
        }
         #youtube_modal_body .youtube_search_listing{
           display:-webkit-box;
            display:-ms-flexbox;
            display:flex;
             -webkit-box-align:center;
                 -ms-flex-align:center;
                     align-items:center;
             -webkit-box-orient:horizontal;
             -webkit-box-direction:reverse;
                 -ms-flex-direction:row-reverse;
                     flex-direction:row-reverse;
             -webkit-box-pack: end;
                 -ms-flex-pack: end;
                     justify-content: flex-end;
                         cursor: pointer;
                            -webkit-transition: all 0.35s ease;
                -o-transition: all 0.35s ease;
                transition: all 0.35s ease;
         }
         #youtube_modal_body .youtube_search_listing:hover {
                background: #f1eeee;
                -webkit-transition: all 0.35s ease;
                -o-transition: all 0.35s ease;
                transition: all 0.35s ease;
}
    </style>
    <?php include resource_path('views/includes/top.php'); ?>

    <body>
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xl-3 col-lg-3">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-md-12 col-xl-6 col-lg-9">
                        <div class="alert alert-danger ajax-response" style="display: none;"></div>
                        <div class="box box-shadow clearfix">
                            <div class="row audio_box">
                                <div class="col-sm-12">
                                    <h2 class="page-heading"><span id="counter"></span></h2>
                                    <form style="position: relative;" method="post" action="<?= asset('save_file') ?>" enctype="multipart/form-data"
                                          class="dropzone" id="my-dropzone">
                                        <textarea id="description" placeholder="Write something or add embed code ..." class="create_post_box mention"></textarea>
                                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                                        <div class="wrap">
                                            <div class="dz-message">
                                                <i class="fas fa-plus"></i>
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
                                    <div class="dz-image">
                                        <img data-dz-thumbnail />
                                    </div>
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
                            <div class="create_post_option_btns d-flex flex-sm-row flex-column">
                                <div>
                                    <span class="btn btn-round button_video font-13 ">
                                       <i class="fas fa-image"></i> Add Media
                                    </span>
                                    <input type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_event" style="display: none" />
                                </div>
                                <div id="open_youtube_modal">
                                    <span class="button_yt btn-round font-13 ">
                                       <i class="fab fa-youtube"></i> Add Youtube Link
                                    </span>
                                </div>

                                <div class="modal fade" id="youtube_modal" tabindex="-1" role="dialog"  aria-hidden="true">
                                    <div class="modal-dialog modal-md" role="document">
                                        <div class="modal-content edit-event-popup">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="create_gig_modal">Add Youtube Link</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <i class="fas fa-times-circle"></i>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                               <div class="d-flex align-items-center">
                                                    <input type="text" id="search_youtube_input" class="form-control mr-2" />
                                                <input type="button" id="search_youtube_button" value="search" class="btn btn-gradient" />
                                               </div>
                                                <div id="youtube_modal_body"></div>
                                                <div id="youtube_modal_footer">
                                                    <div class="load_more d-none" id="finder_loader"><img id="post_loader" src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." class="m_loader"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="ml-sm-auto">
                                    <div class="d-flex flex-wrap align-items-center">
                                        <div class="d-flex align-items-start align-items-sm-center flex-sm-row flex-column">
                                            <strong class="text-dark mr-1 font-14 ">POST AS:</strong>
                                            <select class="selectpicker show-tick font-14 " data-live-search="true" id="post_as">
                                                <option data-subtext='<span class="bg_image_round" style="background-image: url(<?php echo $current_photo ?>)"></span>' value="<?= 'u_' . $current_id ?>"><?= $current_name ?></option>
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
                                        </div><!-- flex -->
                                        <div class="ml-auto">
                                            <!-- <button id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-gradient btn_post_audio font-14 ">
                                                Post
                                                <span class="loader_inline" id="post_loader" style="display: none;">
                                                    <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." />
                                                </span>
                                            </button> -->
                                            <div class="post_btns">
                                            <button id="submit_post" onclick="submitPost()"   type="button" value="Post" class="btn btn-gradient btn_post_audio font-14 ">
                                                Post <br/>
                                                <span id="status_name">Public</span>
                                            </button>
                                            <button class="btn-arrow font-14 ">
                                            <span class="drop-arrow"><img src="<?php echo asset('userassets/images/down-arrow.png')?>"/></span>
                                                <!-- <span class="loader_inline" id="post_loader" style="display: none;">
                                                    <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." />
                                                </span> -->
                                                <ul class="post_list un_style" id="post_privacy">
                                                    <li data-list="Public" class="acvtive_list">
                                                        <span><img src="<?php echo asset('userassets/images/earth.png');?>"/></span>Public
                                                    </li>
                                                    <li data-list="Private">
                                                        <span><img src="<?php echo asset('userassets/images/lock.png');?>"/></span>Private
                                                    </li>
                                                    <li data-list="Collaborative Friends">
                                                        <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Collaborative Friends
                                                    </li>
                                                </ul>
                                            </button>
                                            </div>
                                        </div>
                                    </div><!-- flex -->
                                </div>
<!--                                <input id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_audio">
                            <div class="fb_loader_img"><img id="post_loader" style="display: none"src="<?php echo asset('userassets/images/loader.gif') ?>" alt="loading.." class="fb_loader" style="height: 50px; width: 50px"></div>
                                -->
                            </div>
                        </div> <!-- post -->

                        <div id="showposts"></div>
                        <div id="postsmessage"></div>
                        <?php if (!$post_count) { ?>
                            <div class="text-center" id="welcome_div">
                                <div class="empty_timeline_message">
                                    <h3>Welcome to Musician</h3>
                                    <p>Get Started by following Musician & friends. You'll see their photos, videos & events here.</p>
                                    <a href="<?= asset('search?search=') ?>" class="btn btn-red btn-round">Explore now </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div> <!-- col -->
                    <div class="col-md-12 col-xl-3 d-xl-block d-none">
                        <?php include resource_path('views/includes/sidebar-right.php'); ?>
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
                                                var query = '<?= (isset($_GET['search']) && $_GET['search']) ? $_GET['search'] : '' ?>';
                                                
                                                var next_page_token = '';
                                                var allow_youtube_search = 1;
                                                $('#open_youtube_modal').click(function () {
                                                    allow_youtube_search = 1;
                                                    next_page_token = '';
                                                    $('#search_youtube_input').val('');
                                                    $('#youtube_modal_body').html('');
                                                    $('#youtube_modal').modal('show');
                                                });
                                                $('#search_youtube_button').click(function () {
                                                    allow_youtube_search = 1;
                                                    next_page_token = '';
                                                    $('#youtube_modal_body').html('');
                                                    searchYoutube();
                                                });
                                                $('#search_youtube_input').keyup(function(e){
                                                    if(e.keyCode == 13)
                                                    {
                                                        allow_youtube_search = 1;
                                                        next_page_token = '';
                                                        $('#youtube_modal_body').html('');
                                                        searchYoutube();
                                                    }
                                                });
                                                function searchYoutube() {
                                                    if (allow_youtube_search == 1) {
                                                        $('#finder_loader').removeClass('d-none');
                                                        let q = $('#search_youtube_input').val();
                                                        $.ajax({
                                                            type: "GET",
                                                            url: "<?php echo asset('search_youtube'); ?>",
                                                            data: {'q': q, 'token': next_page_token},
                                                            success: function (response) {
                                                                $('#finder_loader').addClass('d-none');
                                                                if (response.html == false) {
                                                                    allow_youtube_search = 0;
                                                                } else if (response.html) {
                                                                    $('#youtube_modal_body').append(response.html);
                                                                }
                                                                next_page_token = response.next_page_token;
                                                            }
                                                        });
                                                    }
                                                }
                                                
                                                $('body').on('click', '.youtube_search_listing', function(){
                                                    let video_id = $(this).attr('data-id');
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "<?php echo asset('get_youtube_video_link'); ?>",
                                                        data: {'id': video_id},
                                                        success: function (response) {
                                                            var str = response.player.embedHtml;
                                                            var regex = /<iframe.*?src="(.*?)"/;
                                                            var src = 'https:'+regex.exec(str)[1];
                                                            let backup = $('#description').val();
                                                            var src = src.replace("embed/", "watch?v=");
                                                            if (backup) {
                                                                $('#description').val(backup+'\n'+src);
                                                            } else {
                                                                $('#description').val(src);
                                                            }
                                                            $('#youtube_modal').modal('hide');
                                                        }
                                                    });
                                                });

                                                $('#youtube_modal_body').on('scroll', function () {
                                                    if ($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
                                                        searchYoutube();
                                                    }
                                                });

                                                $(document).ready(function () {
                                                    $('textarea').on('click', function (e) {
                                                        e.stopPropagation();
                                                    });
                                                });
                                                $('textarea.mention').mentionsInput({
                                                    onDataRequest: function (mode, query, callback) {
                                                        $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                                                            responseData = _.filter(responseData, function (item) {
                                                                return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                                                            });
                                                            callback.call(this, responseData);
                                                        });
                                                    }
                                                });
                                                function countTitle(val) {
                                                    limit = 150;
                                                    var len = val.value.length;
                                                    if (len >= limit) {
                                                        val.value = val.value.substring(0, limit);
                                                    } else {
                                                        $('.text_length_title').text(limit - len);
                                                    }
                                                }

                                                function countDesc(val) {
                                                    limit = 300;
                                                    var len = val.value.length;
                                                    if (len >= limit) {
                                                        val.value = val.value.substring(0, limit);
                                                    } else {
                                                        $('.text_length_desc').text(limit - len);
                                                    }
                                                }

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
                                                    $('.cretate_event_btn').click(function () {
                                                        $('.audio_box').fadeOut('slow', function () {
                                                            //Toggle forms
                                                            $('.post_box').show()
                                                            $('.ajax-response').hide();
                                                            //Toggle buttons
                                                            $('.btn_post_audio').hide();
                                                            $('.btn_post_event').show();
                                                        });
                                                    });
                                                    $('#timepicker1').timepicker();
                                                    $('.setDate').datepicker();
                                                    $('body').on('click', '.btn_post_event', function (e) {
                                                        $form = $('#create_event');
                                                        $this = $(this);
                                                        $this.attr('disabled', true);
                                                        //pick form data
                                                        //create_event
                                                        $.ajax({
                                                            type: "POST",
                                                            data: $form.serialize(),
                                                            url: "<?php echo asset('timeline'); ?>",
                                                            dataType: "json",
                                                            beforeSend: function (request) {
                                                                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                                                            },
                                                            success: function (data) {
                                                                if (data.success) {
                                                                    $('.ajax-response').show();
                                                                    $('.ajax-response').removeClass('alert-danger');
                                                                    $('.ajax-response').addClass('alert-success');
                                                                    $('.ajax-response').html(data.message);
                                                                    $form[0].reset();
                                                                } else {
                                                                    $('.ajax-response').show();
                                                                    $('.ajax-response').removeClass('alert-success');
                                                                    $('.ajax-response').addClass('alert-danger');
                                                                    $('.ajax-response').html(data.message);
                                                                }
                                                                $("html, body").animate({scrollTop: 0}, 600);
                                                            },
                                                            complete: function () {
                                                                $this.attr('disabled', false);
                                                            }
                                                        });
                                                    });
                                                });
                                                function submitPost() {
                                              
                                                           var privacy="" ;
                                                            privacy =( $('#status_name').text());
                                                           
                                                 
                                                    $('textarea.mention').mentionsInput('val', function (text) {
                                                        post_description = text;
                                                    });
//                                            mentioned_users='';
                                                    $('textarea.mention').mentionsInput('getMentions', function (data) {
                                                        mentioned_users = data;
                                                    });
                                                    $('#post_loader').show(); //show loading indicator image
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
                                                                images: images,
                                                                post_as: post_as,
                                                                mentioned_users: mentioned_users,
                                                                _token: $('[name="_token"]').val(),
                                                                privacy:privacy
                                                            },
                                                            //                    processData: false,
                                                            //                    contentType: false,
                                                            success: function (response) {
                                                                if (response.error) {
                                                                    vulgarTermsErrorAlert();
                                                                    $("#submit_post").css('pointer-events', 'auto');
                                                                    $('#post_loader').hide();
                                                                } else {
                                                                    console.log(response);
//                    var response_data=JSON.parse(response);
//                console.log(response_data);
                                                                    $("textarea.mention").mentionsInput('reset');
                                                                    $('#welcome_div').hide();
                                                                    var objDZ = Dropzone.forElement(".dropzone");
                                                                    objDZ.emit("resetFiles");
                                                                    total_photos_counter = 0;
                                                                    image_attachments = [];
                                                                    $('#post_as').prop('selectedIndex', 0);
                                                                    $('.filter-option-inner-inner').html('<?= $current_name ?>');
                                                                    $('.dropzone').removeClass('dz-started');
                                                                    $("#description").val('');
                                                                    appended_post_count = parseInt(appended_post_count) + 1;
                                                                    $('#post_loader').hide();
                                                                    $("#submit_post").css('pointer-events', 'auto');
                                                                    $('#submit_post').bind('click', submitPost);
                                                                    $('#showposts').prepend(response.view);
                                                                    //                                                        console.log(menti            oned_users)
                                                                    $.each(mentioned_users, function (key, value)
                                                                    {

                                                                        socket.emit('notification_get', {
                                                                            "user_id": value.id,
                                                                            "other_id": '<?php echo $current_id; ?>',
                                                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                                                            "photo": '<?php echo $current_photo; ?>',
                                                                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> mention you in post',
                                                                            "url": '<?= asset('get_post') ?>' + '/' + response.post_id,
                                                                            "notification_icon": '<?= asset('userassets/images/icon-comment.png') ?>',
                                                                            "other_url": '<?= asset('get_post') ?>' + '/' + response.post_id,
                                                                            "unique_text": response.post_id,
                                                                        });
                                                                    });
                                                                    //console.log(mentioned_users)
                                                                }
                                                            }
                                                        });
                                                    }
                                                }
                                                var win = $(window);
                                                var count = 0;
                                                var ajaxcall = 1;
                                                appended_post_count = 0;
                                                win.on('scroll', function () {
                                                    var docheight = parseInt($(document).height());
                                                    var winheight = parseInt(win.height());
                                                    var differnce = (docheight - winheight) - win.scrollTop();
                                                    if (differnce < 300) {
                                                        if (ajaxcall === 1) {
                                                            //                        console.log(ajaxcall);
                                                            $('#loaderposts').remove();
                                                            var loader = '<div class="load_more" id="loaderposts" ><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader" /></div>';
                                                            $('#showposts').append(loader);
                                                            ajaxcall = 0;
                                                            var skip = (parseInt(count) * 5) + parseInt(appended_post_count);
                                                            if (skip != 0) {
                                                                var response = load_posts(skip, 5);
                                                                //                        console.log('ajax response: ', response);
                                                            }
                                                        }
                                                        $('#loaderposts').remove();
                                                    }
                                                });
                                                function load_posts(skip, take) {
                                                    $('#loaderposts').remove();
                                                    var loader = '<div class="load_more" id="loaderposts"><img src="<?php echo asset('userassets/images/loader.gif') ?>" class="m_loader" /></div>';
                                                    $('#postsmessage').append(loader);
                                                    $.ajax({
                                                        type: "GET",
                                                        url: "<?php echo asset('fetch_posts'); ?>",
                                                        data: {skip: skip, take: take, search: query},
                                                        success: function (response) {
                                                            sidebarright.updateSticky();
                                                            sidebar.updateSticky();
                                                            $('#loaderposts').remove();
                                                            if (response) {
                                                                $("#showposts").css("display", "block");
                                                                $('#showposts').append(response);
                                                                ajaxcall = 1;
                                                                var a = parseInt(1);
                                                                var b = parseInt(count);
                                                                count = b + a;
                                                                var skip = (parseInt(count) * 5) + parseInt(appended_post_count);
//                                                                load_posts(skip, 5);
                                                                sidebarright.updateSticky();
                                                                sidebar.updateSticky();
                                                                setTimeout(function () {
                                                                    sidebarright.updateSticky();
                                                                    sidebar.updateSticky();
                                                                }, 1000);
//                                                                stickyside();
                                                                return true;
                                                            } else {
                                                                if ($('#showposts').is(':empty')) {
//                                                        noposts = '<div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No posts found</div></div>';
//                                                        $('#postsmessage').append(noposts);
//                                                                    stickyside();
                                                                } else {
//                                                                    stickys/ide();
                                                                    noposts = '<div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No more posts to show</div></div>';
                                                                    $('#postsmessage').append(noposts);
                                                                }
//                                                                stickyside();
                                                                ajaxcall = 0;
                                                                return false;
                                                            }
                                                        }
                                                    });
                                                }
                                                $(document).ready(function () {

                                                    // load posts
                                                    var skip = 0;
                                                    var take = 5;
                                                    load_posts(skip, take);
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
                                                            if (response.message === 'success') {
                                                            } else {
                                                                $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                                                            }
                                                        }
                                                    });
                                                }
                                                $('.button_video').click(function () {
                                                    $('.dz-message').toggle();
                                                });
        </script>
        <?php if ($welcome_message) { ?>
            <script>
                $('#showSuccess').html('<?= $welcome_message ?>').fadeIn().fadeOut(5000);
            </script>
        <?php } ?>
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