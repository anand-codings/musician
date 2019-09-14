<?php include resource_path('views/includes/services_functions.php'); ?>
<?php if (isset($data) && count($data) > 0) { ?>
    <div class="container">
        <div class="row">
            <?php
            if (isset($data) && count($data) > 0) {
                foreach ($data as $accompanist) {
                    ?>
                    <div class="d-flex flex-column search_result_box">
                        <div>
                            <a href="<?= asset('accompanist_time_line/' . $accompanist->id); ?>">
                                <?php
                                $pic = asset('public/images/profile_pics/demo.png');
                                if ($accompanist->pic) {
                                    $pic = asset('public/images/' . $accompanist->pic);
                                }
                                ?>
                                <div class="thumbnail" style="background-image: url(<?= $pic; ?>);width:100%;">
                                    <img class="img-fluid" src="<?= asset('userassets/images/place.png') ?>" style="position:relative;z-index:-1;">
                                </div>
                            </a>
                        </div> <!-- image thumbnail -->
                        <div class="w-100">

                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <a href="<?= asset('accompanist_time_line/' . $accompanist->id); ?>" class="u_name">
                                        <?= $accompanist->name ?>
                                        <?php if ($accompanist->user->is_online) { ?>
                                            <span class="active_status"></span>
                                        <?php } ?>
                                    </a>
                                    <div class="profession">
                                        <?php
                                        if (!$accompanist->getSelectedCategories->isEmpty()) {
                                            $getSelectedArtistTypesCount = $accompanist->getSelectedCategories->count();

                                            if ($getSelectedArtistTypesCount <= 2) {
                                                $i = 1;
                                                foreach ($accompanist->getSelectedCategories as $selectedArtistType) {
                                                    echo $selectedArtistType->getCategory->title;
                                                    if ($getSelectedArtistTypesCount > $i)
                                                        echo ', ';
                                                    $i++;
                                                }
                                            } else {
                                                $i = 1;
                                                foreach ($accompanist->getSelectedCategories as $selectedArtistType) {
                                                    echo $selectedArtistType->getCategory->title;
                                                    if ($i < 2) {
                                                        echo ', ';
                                                    } else {
                                                        echo ' ...';
                                                        break;
                                                    }
                                                    $i++;
                                                }
                                            }
                                        } else {
                                            ?>
                                            N/A
                                        <?php } ?>
                                    </div>
                                    <div class="rating_reviews">
                                        <div class="star-ratings-sprite-gray">
                                            <span style="width: <?= $accompanist->rating_percentage ? $accompanist->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                                        </div>
                                        <span class="reviews text_grey">(<?= $accompanist->number_of_reviews ? $accompanist->number_of_reviews : '0' ?> Reviews)</span>
                                    </div> <!-- rating reviews -->
                                </div> <!-- col -->
                                <div class="col-md-6 text-right">
                                    <?php
                                    if (Auth::user()) {
                                        if (Auth::user()->type != 'artist') {
                                            ?>
                                            <a href="<?= asset('accompanist_time_line/' . $accompanist->id); ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                        <?php
                                        }
                                    } else {
                                        ?>
                                        <a href="<?= asset('accompanist_time_line/' . $accompanist->id); ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
            <?php } ?>
                                </div>

                            </div> <!-- row -->

                            <div class="text-content">
                                <?php
                                $studio_description = $accompanist->description;
                                if (strlen($studio_description) > 400) {
                                    $studio_description = substr($studio_description, 0, 400) . '...';
                                }
                                echo $studio_description;
                                ?>
                            </div> <!-- text content -->

                            <div class="row">
                                <div class="col-md-6 col-sm-12">
                                    <i class="fa fa-map-marker-alt"></i>
                                    <span class="font-weight-bold">Location:</span>
                                    <?php
                                    $studio_location = $accompanist->location;
                                    if (strlen($studio_location) > 20) {
                                        $studio_location = substr($studio_location, 0, 20) . '...';
                                    }
                                    echo $studio_location;
                                    ?>
                                </div> <!-- col -->
                                <div class="col-md-6 col-sm-12">
                                    <i class="fa fa-users"></i>
                                    <span class="font-weight-bold">Price :</span>
                                    <?php
                                    $unit = $accompanist->unit->title;
                                    if ($accompanist->unit->title == 'hour') {
                                        $unit = 'hr';
                                    }
                                    ?>
                                    <span class="text_grey font-16"> <strong class="text_green">$<?= $accompanist->price ?></strong> / <?= $accompanist->per_unit . ' ' . $unit ?></span>
                                </div> <!-- col -->
                            </div><!-- row -->
                            <div class="w-100 follow_btns">
                                <div class="following_status text-center mt-4">
                                    
                                   
                                    <?php
                                    if (Auth::user()) {
                                         
                                        if (Auth::user()->id != $accompanist->admin_id) {
                                            
                                            ?>
                                            <a <?php if (checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="follow_a_<?= $accompanist->id ?>" onclick="followService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline btn_follow pl-2 pr-2 pt-2 pb-2">Follow</a>
                                            <a <?php if (!checkServiceFollowing('a', $accompanist->id, 'accompanist_id')) { ?> style="display: none" <?php } ?> id="unfollow_a_<?= $accompanist->id ?>"   onclick="unfollowService('a',<?= $accompanist->id ?>, '<?= $accompanist->admin_id ?>')" href="javascript:void(0)" class="btn btn-white-outline btn_follow pl-2 pr-2 pt-2 pb-2">Unfollow</a>
                                            <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $accompanist->id; ?>" class="btn_message pl-2 pr-2 pt-2 pb-2">Message</a>
                                            <?php
                                        }
                                    } else {
                                        
                                        ?>
                                        <a href="<?= asset('login') ?>" class="btn_follow pl-2 pr-2 pt-2 pb-2">Follow</a>
                                        <a href="<?= asset('login') ?>" class="btn_message pl-2 pr- pt-2 pb-2"> Message</a>
            <?php } ?>           


                                        
                                </div> <!-- following buts -->
                            </div> <!-- col -->
                        </div> <!-- right side -->
                    </div> <!-- search_result_box -->
            <?php if (Auth::user()) { ?>
                        <!-- Message modal Start -->
                        <div class="modal fade" id="modal_search_messages<?= $accompanist->id; ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                            <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $accompanist->name; ?> </span></h6>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i class="fas fa-times-circle"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group mb-0">
                                                        <textarea id="message_a<?= $accompanist->id; ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                    </div>
                                                </div>
                                            </div> <!-- row -->
                                            <div class="mt-2">
                                                <button type="button" onclick="sendMessageFromSearchServices('<?= $accompanist->admin_id; ?>', 'a', '<?= $accompanist->id; ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                                            </div>
                                        </form>
                                    </div> <!-- modal-body-->
                                </div> <!-- modal-content-->
                            </div>
                        </div> <!-- Edit Description modal -->
                        <!--  Message modal END -->
                        <?php
                    }
                }
            }
            ?>
        </div>
    </div>
<?php } ?>
