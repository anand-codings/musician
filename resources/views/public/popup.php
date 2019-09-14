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

        <div class="page_timeline">
            <div class="container"> 

               
                <br/><br/><br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_affiliation"> Add Affliation </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_delete"> Delete </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_education"> Add Education </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_job_experience"> Add Job Experience </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_description"> Edit Description </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_edit_info"> Edit Info </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_reporting"> Reporting </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_social_share"> Social Share </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_eventbooking"> Event Booking </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_add_availability"> Add Availability </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#create_gig_modal"> Create Gig </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#followers_modal"> Followers </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_post"> Post Image </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_post_video"> Post Video </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_sound_cloud"> Embed SoundCloud </a> <br/>
                <a href="#" class="text_aqua text-semibold" data-toggle="modal" data-target="#modal_search_messages"> Search Message Popup </a> <br/>
                 <button type="button" 
                        class="btn btn-lg btn-danger" 
                        data-toggle="popover" 
                        data-placement="top"
                        data-trigger="focus" 
                        data-html ="true"
                        title="<b>Example popover</b> - title"
                        data-content=''
                        >
                    Click to toggle popover
                </button>
                
                <span 
                    data-toggle="popover" 
                    data-placement="top" 
                    data-trigger="focus" 
                    data-html="true" 
                    data-content="<input style=&quot;display: none&quot; type=&quot;text&quot; value=&quot;hi&quot; id=&quot;copy_235&quot;><a onclick=&quot;copyMessage(235)&quot; class=&quot;dropdown-item&quot; href=&quot;javascript:void(0)&quot;>Copy</a>                                                                  <a onclick=&quot;deleteMessage(235, 2)&quot; class=&quot;dropdown-item&quot; href=&quot;javascript:void(0)&quot;>Delete</a>" data-original-title="<b>Example popover</b> - title">
                                                                    <i class="fas fa-ellipsis-h"></i>
                                                                  </span>
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <!-- Message modal Start -->
        <div class="modal fade" id="modal_search_messages" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> NabEl </span></h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <textarea class="form-control h_140" placeholder="Write a message"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2">
                                <button type="submit" class="btn btn-gradient btn-xl text-semibold">Send</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!--  Message modal END -->

        <!-- Edit Description modal Start -->
        <div class="modal fade" id="modal_sound_cloud" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Embed Soundcloud Track</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group mb-0">
                                        <textarea class="form-control h_140"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2">
                                <button type="submit" class="btn btn-gradient btn-xl text-semibold">Post</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!-- Edit Description modal END -->

        <!-- Add Availabiltiy modal Start -->
        <div class="modal fade modal_post" id="modal_post" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>            
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="post_popup d-flex">
                            <div class="left_side">


                                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <div class="image-view" style="background-image: url(<?= asset('userassets/images/tree.jpg'); ?>)"></div>
                                        </div>
                                        <div class="carousel-item">
                                            <div class="image-view" style="background-image: url(<?= asset('userassets/images/greenery-bushes.jpg'); ?>)"></div>
                                        </div>
                                    </div>
                                    <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="sr-only">Next</span>
                                    </a>
                                </div>

                                <ul class="un_style no_icon action_dropdown float-right">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                            <a class="dropdown-item" href="http://localhost/musician/edit_post/23"><i class="fas fa-copy"></i> Edit</a>
                                            <a onclick="copyPostLink(23)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_23"><i class="fas fa-share-alt"></i> Share</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="right_side">
                                <div class="scroll_area">
                                    <div class="post-head d-flex align-items-center">
                                        <div class="d-flex">
                                            <div class="pull-left">
                                                <span class="bg_image_round w-50"  style="background-image: url(<?= asset('userassets/images/tree.jpg'); ?>)"></span>
                                            </div>
                                            <div>
                                                <a href="#" class="name">Juan T Bryant</a>
                                                <div class="type">The Guitar Master</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="time">Today - 3:56 AM</span>
                                        </div>
                                    </div>
                                    <div class="post_body">
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                                    </div>
                                    <nav class="nav t_post_action_btns">
                                        <a class="share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i>Liked</a>
                                        <a class="" href="javascript:void(0)"><i class="fas fa-comment-alt"></i>Comment</a>
                                        <a class="bookmark" href="javascript:void(0)"><i class="fas fa-heart"></i>Favorite</a>
                                    </nav>
                                    <nav class="nav post_counter">
                                        <span><span id="likes_counter18">1</span> Likes</span>
                                        <span class="ml-auto"><span id="comments_counter18">3</span> Comments</span>
                                    </nav>
                                    <div class="post_comments_section">
                                        <div class="view_comments">
                                            <span href="#">View Previouse Comments</span>
                                        </div>
                                        <ul class="comments_list un_style">
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_footer">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= asset('userassets/images/tree.jpg'); ?>)"></span>
                                        </div>
                                        <div class="w-100">
                                            <form class="t_post_comment_form flex-grow-1">
                                                <textarea placeholder="Write comment.." class="form-control"></textarea>
                                                <input type="button" value="Send">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- modal -->
        <!-- Add Availabiltiy modal END -->


        <!-- Add Availabiltiy modal Start -->
        <div class="modal fade modal_post" id="modal_post_video" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <i class="fas fa-times"></i>
            </button>            
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="post_popup d-flex">
                            <div class="left_side">
                                <video controls>
                                    <source src="<?= asset('userassets/video/windowsill.mp4'); ?>" type="video/mp4">
                                </video>
                                <ul class="un_style no_icon action_dropdown">
                                    <li class="dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </a>
                                        <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                            <a class="dropdown-item" href="http://localhost/musician/edit_post/23"><i class="fas fa-copy"></i> Edit</a>
                                            <a onclick="copyPostLink(23)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_23"><i class="fas fa-share-alt"></i> Share</a>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="right_side">
                                <div class="scroll_area">
                                    <div class="post-head d-flex align-items-center">
                                        <div class="d-flex">
                                            <div class="pull-left">
                                                <span class="bg_image_round w-50"  style="background-image: url(<?= asset('userassets/images/tree.jpg'); ?>)"></span>
                                            </div>
                                            <div>
                                                <a href="#" class="name">Juan T Bryant</a>
                                                <div class="type">The Guitar Master</div>
                                            </div>
                                        </div>
                                        <div class="ml-auto">
                                            <span class="time">Today - 3:56 AM</span>
                                        </div>
                                    </div>
                                    <div class="post_body">
                                        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. 
                                    </div>
                                    <nav class="nav t_post_action_btns">
                                        <a class="share_post done" href="javascript:void(0)"> <i class="fas fa-thumbs-up"></i>Liked</a>
                                        <a class="" href="javascript:void(0)"><i class="fas fa-comment-alt"></i>Comment</a>
                                        <a class="bookmark" href="javascript:void(0)"><i class="fas fa-heart"></i>Favorite</a>
                                    </nav>
                                    <nav class="nav post_counter">
                                        <span><span id="likes_counter18">1</span> Likes</span>
                                        <span class="ml-auto"><span id="comments_counter18">3</span> Comments</span>
                                    </nav>
                                    <div class="post_comments_section">
                                        <div class="view_comments">
                                            <span href="#">View Previouse Comments</span>
                                        </div>
                                        <ul class="comments_list un_style">
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="d-flex">
                                                    <figure class="figure mr-3 sx-mr-2">
                                                        <span class="bg_image_round w-35" style="background-image: url(http://localhost/musician/public/images/profile_pics/1540992384.jpg)"></span>                
                                                    </figure>
                                                    <div class="comment_body">
                                                        <div class="comment_meta">
                                                            <div class="d-flex flex-column">
                                                                <a href="http://localhost/musician/profile_timeline/2"><span class="font-weight-bold text_darkblue">First User</span></a>
                                                                <div class="font-14">Duis aute irure dolor in reprehenderit in voluptat.</div>
                                                                <span class="text_grey font-14"> 4 days ago </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="post_footer">
                                    <div class="d-flex">
                                        <div class="mr-2">
                                            <span class="bg_image_round w-45 xm-s-40" style="background-image: url(<?= asset('userassets/images/tree.jpg'); ?>)"></span>
                                        </div>
                                        <div class="w-100">
                                            <form class="t_post_comment_form flex-grow-1">
                                                <textarea placeholder="Write comment.." class="form-control"></textarea>
                                                <input type="button" value="Send">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- modal -->
        <!-- Add Availabiltiy modal END -->

        <!-- Followers modal Start -->
        <div class="modal fade" id="followers_modal" tabindex="-1" role="dialog" aria-labelledby="followers_modal" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                <div class="modal-content edit-event-popup">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create_gig_modal">Followers</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div> <!-- modal header -->
                    <div class="modal-body">
                        <ul class="followers_list un_style">
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                            <li>
                                <div class="media align-items-center">
                                    <img src="http://localhost/musician/userassets/images/profile_pic_lg.png" alt="profile pic" class="rounded-circle">
                                    <div class="media-body">
                                        <div class="d-flex flex-column flex-sm-row">
                                            <div class="mb-2">
                                                <a href="#" class="u_name">test test</a>
                                                <div class="profession">The Guitar Master</div>
                                            </div>
                                            <div class="d-flex align-items-center  ml-sm-auto">
                                                <div class="following_status">
                                                    <a href="#" class="btn_follow"> <i class="s_icon ic_follow grey"></i> Follow</a>
                                                    <a href="#" class="btn_message"> <i class="s_icon ic_message white"></i> Message </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- media body -->
                                </div> <!-- media-->
                            </li>
                        </ul> <!-- followers list -->
                    </div> <!-- modal body -->
                </div> <!-- modal content -->
            </div>
        </div>
        <!-- Followers modal END -->

        <!-- Create Gig modal Start -->
        <div class="modal fade" id="create_gig_modal" tabindex="-1" role="dialog" aria-labelledby="create_gig_modal" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content edit-event-popup">
                    <div class="modal-header">
                        <h5 class="modal-title" id="create_gig_modal">Create Gig</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div> <!-- modal header -->
                    <div class="modal-body">
                        <form name="" id="create_event_f">
                            <div class="create_event_form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <label>Event Photo</label>
                                        <div class="form-group">
                                            <div class="event_cover_photo d-flex align-items-center align-self-center">
                                                <div class="custom-file upload_btn text-center mx-auto">
                                                    <input type="file" id="cover_image_f" name="image" class="custom-file-input">
                                                    <p class="text_aqua font-17 mb-0">+ Add Cover Photo</p>
                                                    <p class="text_grey font-13 mb-0">Best result size 980 x 525 pixels</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <label>Location</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="" class="form-control" name="location" id="autofill_location"/>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <label>Range (km)</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="" class="form-control" name="range"/>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Price</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="" class="form-control" name="price"/>
                                        </div><!-- from group -->
                                    </div> <!-- col -->
                                    <div class="col-sm-6">
                                        <label>Per Unit</label>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <input type="text" placeholder="" class="form-control" name="per_unit"/>
                                                </div><!-- from group -->
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <select class="form-control selct2_select" style="width: 100%">
                                                        <option value="Hour"> Hour </option>
                                                        <option value="Half Hour"> Half Hour </option>
                                                        <option value="Song"> Song </option>
                                                    </select><!-- from group -->
                                                </div><!-- from group -->
                                            </div>
                                        </div> <!-- row -->
                                    </div> <!-- col -->
                                </div> <!-- row -->

                                <div class="row mb-1">
                                    <div class="col-sm-12">
                                        <label>Event Title</label>
                                        <div class="form-group">
                                            <input type="text" placeholder="" class="form-control" id="title_count_f" name="event_title"/>
                                            <span class='info'><span class="text_length_title">150</span> Characters</span>
                                        </div><!-- from group -->
                                    </div>
                                </div> <!-- row -->
                                <div class="row mb-1">
                                    <div class="col-sm-12">
                                        <label>Event Detail</label>
                                        <div class="form-group">
                                            <textarea class="form-control h_140" placeholder="" id="descriptin_count_f" name="event_detail"></textarea>
                                            <span class='info'><span class="text_length_desc">300</span> Characters</span>
                                        </div><!-- from group -->
                                    </div>
                                </div> <!-- row -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="custom_booking" id="lbl_custom_booking">
                                                <label class="custom-control-label" for="lbl_custom_booking">Enable custom booking.</label>
                                            </div>
                                        </div><!-- from group -->
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" name="status" class="custom-control-input" id="lbl_inactive_events">
                                                <label class="custom-control-label" for="lbl_inactive_events">Inactive Event</label>
                                            </div>
                                        </div><!-- from group -->
                                    </div>
                                </div> <!-- row -->
                            </div> <!-- create event form -->
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-round btn-gradient btn-xl text-semibold btn_create_event_f">Create Event
                                </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div> <!-- modal content -->
            </div>
        </div>
        <!-- Create Gig modal END -->

        <!-- Add Availabiltiy modal Start -->
        <div class="modal fade" id="modal_add_availability" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Availablity</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Select Time </label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                                <div class="col-sm-1">
                                    <span class="arrow_divider"></span>
                                </div> <!-- col -->
                                <div class="col-sm-5">
                                    <div class="availability_text">
                                        <p class="text_label">Select time between</p>
                                        <p class="booking_timing"> 7:00 AM - 5:00 PM</p>
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Availability Dates </label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                                <div class="col-sm-1">
                                    <span class="arrow_divider"></span>
                                </div> <!-- col -->
                                <div class="col-sm-5">
                                    <div class="availability_text">
                                        <p class="text_label">Select Dates between</p>
                                        <p class="booking_timing"> 15-05-2018 - 20-06-2018</p>
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="form-group">
                                <button type="submit" class="btn btn-round btn-gradient"> Submit </button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- modal -->
        <!-- Add Availabiltiy modal END -->

        <!-- Booking modal Start -->
        <div class="modal fade" id="modal_eventbooking" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First & Last Name </label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Your Email</label>
                                        <input type="email" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Gig Name</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Location</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Date</label>
                                        <div class="d-flex">
                                            <input type="text" placeholder="Day" class="form-control mr-2">
                                            <input type="text" placeholder="Month" class="form-control mr-2">
                                            <input type="text" placeholder="Year" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Hours offering</label>
                                        <input type="text" placeholder="0:00" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Price offering</label>
                                        <input type="text" placeholder="$$$" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control h_140"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn_aqua btn-xl font-weight-bold "> Book Now </button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Booking modal -->
        <!-- Booking modal END -->

        <!-- Social Share modal Start -->
        <div class="modal fade" id="modal_social_share" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Make a Social Share</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mt-2 mb-2">
                                <ul class="un_style share_media">
                                    <li class="share_fb"><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                    <li class="share_tw"><a href="#"><i class="fab fa-twitter"></i></a></li>
                                    <li class="share_gp"><a href="#"><i class="fab fa-google-plus-g"></i></a></li>
                                </ul>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Social Share modal -->
        <!-- Social Share modal END -->

        <!-- Reporting modal Start -->
        <div class="modal fade" id="modal_reporting" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Reason for Reporting</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_enable" class="custom-control-input" id="report_offensive">
                                    <label class="custom-control-label font-weight-bold" for="report_offensive"> Post is offensive </label>
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_enable" class="custom-control-input" id="report_spam">
                                    <label class="custom-control-label font-weight-bold" for="report_spam"> Spam </label>
                                </div>
                            </div>
                            <div class="mb-1">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="is_enable" class="custom-control-input" id="report_unrelated">
                                    <label class="custom-control-label font-weight-bold" for="report_unrelated"> Unrelated </label>
                                </div>
                            </div>
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl font-weight-bold ">Report Post </button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Reporting modal -->
        <!-- Reporting modal END -->

        <!-- Edit Info modal Start -->
        <div class="modal fade" id="modal_edit_info" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Info </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Speciality</label>
                                        <select class="form-control selct2_select" style="width: 100%">
                                            <option>The Pianist</option>
                                            <option>The Pianist</option>
                                            <option>The Pianist</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Since</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Location</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Language</label>
                                        <select class="form-control selct2_select" style="width: 100%">
                                            <option>English</option>
                                            <option>Arabic</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Info modal -->
        <!-- Edit Info modal END -->

        <!-- Edit Description modal Start -->
        <div class="modal fade" id="modal_edit_description" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Description </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea class="form-control h_140"></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Edit Description modal -->
        <!-- Edit Description modal END -->

        <!-- Add Affiliation modal Start -->
        <div class="modal fade" id="modal_add_affiliation" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Affiliation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Union</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Add Affiliation modal -->
        <!-- Add Affiliation modal END -->

        <!-- Add Education Start modal -->
        <div class="modal fade" id="modal_add_education" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Education</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">College/University</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Degree Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control selct2_select" style="width: 100%">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control selct2_select" style="width: 100%">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Add Education modal -->
        <!-- Add Education Start modal END --> 

        <!-- Job Experience Start modal -->
        <div class="modal fade" id="modal_add_job_experience" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Job Experience</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Company</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div>
                                </div> <!-- col -->
                            </div> <!-- row -->

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Job Title</label>
                                        <input type="text" placeholder="" class="form-control" />
                                    </div> <!-- form-group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Start Year</label>
                                                <select class="form-control selct2_select" style="width: 100%">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="font-weight-bold">End Year</label>
                                                <select class="form-control selct2_select" style="width: 100%">
                                                    <option>2005</option>
                                                    <option>2006</option>
                                                    <option>2007</option>
                                                </select>
                                            </div> <!-- form-group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                </div> <!-- col -->
                            </div> <!-- row -->
                            <div class="mt-2 text-center">
                                <button type="submit" class="btn btn-round btn-gradient btn-xl text-semibold">Save</button>
                            </div>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Experience modal -->
        <!-- Job Experience modal END --> 

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
                        <form>
                            <div>
                                <label class="font-weight-bold">Are you sure you want to Delete this?</label>
                            </div>
                            <div class="mt-3 text-center">
                                <button type="button" class="btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                            </div>
                        </form>
                    </div> <!-- modal body -->
                </div>
            </div>
        </div> <!-- Delete modal -->
        <!-- Delete modal END -->   

        <?php include resource_path('views/includes/footer.php'); ?>
        <script>
            $(function () {
                $('[data-toggle="popover"]').popover()
            });
        </script>
    </body>
</html>