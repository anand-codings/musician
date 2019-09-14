<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <link rel="stylesheet" href="<?php echo asset('userassets/css/dropzone.css'); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.mentionsInput.css') ?>">

    <?php include resource_path('views/includes/top.php'); ?>

    <body>
        <?php include resource_path('views/includes/group_header.php'); ?>
        <div class="page_timeline">
            <div class="container ">
                <div class="row">
                    <div class="col-md-12 col-lg-3 d-lg-block">
                        <?php include resource_path('views/includes/groups_sidebar.php'); ?>
                    </div>
                    <div class="col-md-12 col-xl-6 col-lg-9">
                        <div class="alert alert-danger ajax-response" style="display: none;"></div>
                        <?php if (Auth::user() ) { ?>
                            <div class="box box-shadow clearfix" id="post_box_group_<?=$group->id?>" <?=(Auth::user()->id == $group->admin_id ||  (!empty($group->checkMember) &&  $group->checkMember->is_approved=='1'))?'':'style="display:none;"' ?> >
                                <div class="row audio_box">
                                    <div class="col-sm-12">
                                        <h2 class="page-heading"><span id="counter"></span></h2>
                                        <form style="position: relative;" method="post" action="<?= asset('save_file') ?>" enctype="multipart/form-data"
                                              class="dropzone" id="my-dropzone">
                                            <textarea  id="description" placeholder="Write something or add embed code ..." class="create_post_box mention"></textarea>
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
                                    <div>
                                        <span class="btn btn-round button_video">
                                            <span class="icon ic_addphoto"></span>Add Media
                                        </span>
                                        <input type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_event" style="display: none" />
                                    </div>
                                    <div id="open_youtube_modal">
                                    <span class="button_yt btn-round font-13 ">
                                       <i class="fab fa-youtube"></i> Add Youtube Link
                                    </span>
                                    </div>
                                    <!-- youtube modal --> 
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
                                    
                                    <div class="ml-auto">
                                        <input type="hidden" id="post_as" value="e_<?= $group->id ?>">
                        <?php if(Auth::user() && Auth::user()->id == $group->admin_id) { ?>
                                        <div class="post_btns">
                                        <button id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-gradient btn_post_audio">
                                        
                                            Post <br/>
                                                <span id="status_name">Public</span>
                                                
                                            <span class="loader_inline" id="post_loader" style="display: none;">
                                                <img src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.." />
                                            </span>
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
                                                    <li data-list="Members">
                                                        <span><img src="<?php echo asset('userassets/images/high-five.png');?>"/></span>Members
                                                    </li>
                                                </ul>
                                            </button>
                                        </div>
                        <?php } else { ?>
                                     
                                <input id="submit_post" onclick="submitPost()" type="button" value="Post" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_audio">
                                 <div class="fb_loader_img"><img id="post_loader" style="display: none"src="<?php echo asset('userassets/images/loader.gif') ?>" alt="loading.." class="fb_loader" style="height: 50px; width: 50px"></div>

                        <?php } ?>
                                    </div>

                                </nav>
                            </div> <!-- post -->
                        <?php } ?>
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
                    </div>
                    <?php if (Auth::user() && Auth::user()->id == $group->admin_id) { ?>
                        <div class="col-md-12 col-xl-3 d-xl-block d-none">
                            <div class="stickysideRight">
                                <div class="invite_search_form">
                                    <form class="box p-2 mb-0">
                                        <div class="input-group">
                                            <input id="invite_search" type="text" class="form-control" placeholder="Search">
                                            <div class="input-group-append">
                                                <!--<button type="button" class="btn"><i class="search_icons"></i></button>-->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="invite_group_scollarea">
                                    <ul id="invite_section" class="un_style invite_group_user">
                                        <?php
                                        $people_to_invite = getInviteUsers('g', $group->id, 'group_id');
                                        if (count($people_to_invite) > 0) {
                                            foreach ($people_to_invite as $invite) {
                                                ?>
                                                <li id="invite_g_<?= $invite->id ?>">
                                                    <a href="javascript:void(0)" class="d-flex align-items-center" onclick="inviteService('g', '<?= $group->id ?>', '<?= $invite->id ?>')">
                                                        <div>
                                                            <div class="d-flex align-items-center">
                                                                <span class="w-45 bg_image mr-2" style="background-image: url('<?= getUserImage($invite->photo, $invite->soical_photo, $invite->gender) ?>');"></span>
                                                                <span class="u_name"><?= $invite->first_name . ' ' . $invite->last_name ?></span>
                                                            </div>
                                                        </div>
                                                        <div class="ml-auto">
                                                            <span class="invite_btn">Invite </span>
                                                        </div>
                                                    </a>
                                                </li>
                                                <?php
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <a href="#" class="d-flex align-items-center">
                                                    <div>
                                                        <div class="d-flex align-items-center">
                                                            <span class="u_name">Follow more users to invite</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div> <!-- invite_group_scollarea -->
                            </div> <!-- stickysideRight -->
                        </div>
                    <?php } ?>
                </div> <!-- row -->
            </div> <!-- container -->
        </div>
    </div> <!-- page timeline -->
    <?php include resource_path('views/includes/footer.php'); ?>
    <?php include resource_path('views/includes/group_scripts.php'); ?>
    <script src="<?php echo asset('userassets/js/dropzone.js'); ?>"></script>
    <script src="<?php echo asset('userassets/js/dropzone-config.js'); ?>"></script>
    <script src='https://cdn.rawgit.com/jashkenas/underscore/1.8.3/underscore-min.js' type='text/javascript'></script>
    <script src='<?php echo asset('userassets/js/lib/jquery.elastic.js'); ?>' type='text/javascript'></script>
    <script type="text/javascript" src="<?php echo asset('userassets/js/jquery.mentionsInput.js'); ?>"></script>
    <script>
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
    </script>
    <script>
                                          
                                                $(document).ready(function () {
                                                $('textarea').on('click', function (e) {
                                                    e.stopPropagation();
                                                });

                                            });

                                            jQuery("#invite_search").keyup(function () {
                                                var filter = jQuery(this).val();
                                                jQuery("#invite_section li").each(function () {

                                                    if (jQuery(this).text().search(new RegExp(filter, "i")) < 0) {
                                                        jQuery(this).hide();
                                                    } else {
                                                        jQuery(this).show()
                                                    }
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
<?php if ($current_user) { ?>
                                                function submitPost() {
                                                    var privacy ='';
                                                    privacy = $('#status_name').text();

                                                    $('textarea.mention').mentionsInput('val', function (text) {
                                                        post_description = text;
                                                        console.log(post_description);
                                                    });
                                                    //                                            mentioned_users='';
                                                    $('textarea.mention').mentionsInput('getMentions', function (data) {
                                                        mentioned_users = data;
                                                    });
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
                                                                images: images,
                                                                post_as: post_as,
                                                                privacy:privacy,
                                                                mentioned_users: mentioned_users,
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
                                                                    //                                                        console.log(response);
                                                                    //                                                        var response_data=JSON.parse(response);
                                                                    //                                                        console.log(response_data);
                                                                    $("textarea.mention").mentionsInput('reset');
                                                                    $('#welcome_div').hide();
                                                                    var objDZ = Dropzone.forElement(".dropzone");
                                                                    objDZ.emit("resetFiles");
                                                                    total_photos_counter = 0;
                                                                    image_attachments = [];
                                                                    $('.dropzone').removeClass('dz-started');
                                                                    $("#description").val('');
                                                                    appended_post_count = parseInt(appended_post_count) + 1;
                                                                    $('#post_loader').hide();
                                                                    $("#submit_post").css('pointer-events', 'auto');
                                                                    $('#submit_post').bind('click', submitPost);
                                                                    $('#showposts').prepend(response.view);
                                                                    if(response.file != ''){
                                                                        $('.group_gallery').children('ul').prepend('<li><a href="<?= asset('/') ?> '+ response.file +'" data-fancybox="gallery"><img src="<?= asset('/') ?>'+ response.file +'"></a></li>');
                                                                    }   
                                                                    //                                                        console.log(mentioned_users)
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
<?php } ?>
                                            var win = $(window);
                                            var count = 0;
                                            var ajaxcall = 1;
                                            appended_post_count = 0;
                                            win.on('scroll', function () {
                                                var docheight = parseInt($(document).height());
                                                var winheight = parseInt(win.height());
                                                var differnce = (docheight - winheight) - win.scrollTop();
                                                if (differnce < 100) {
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
                                                    url: "<?php echo asset('fetch_public_posts/'); ?>",
                                                    data: {skip: skip, take: take, "post_type": "e", "post_type_col": "group_id", "post_type_col_id": '<?= $group->id ?>'},
                                                    success: function (response) {
                                                        $('#loaderposts').remove();
                                                        if (response) {
                                                            $("#showposts").css("display", "block");
                                                            $('#showposts').append(response);
                                                            ajaxcall = 1;
                                                            var a = parseInt(1);
                                                            var b = parseInt(count);
                                                            count = b + a;
                                                            var skip = (parseInt(count) * 5) + parseInt(appended_post_count);

                                                            load_posts(skip, 5);
                                                            return true;
                                                        } else {
                                                            if ($('#showposts').is(':empty')) {
//                                                        noposts = '<div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No posts found</div></div>';
//                                                        $('#postsmessage').append(noposts);
                                                            } else {
                                                                noposts = '<div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No more posts to show</div></div>';
                                                                $('#postsmessage').append(noposts);
                                                            }
                                                            ajaxcall = 0;
                                                            return false;
                                                        }
                                                    }
                                                });
                                            }
                                            
                                            function load_posts_again(){
                                                count = 0;
                                                load_posts(0, 5);
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
                                                        if (response.message == 'success') {
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
