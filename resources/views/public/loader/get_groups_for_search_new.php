<?php if (isset($data) && count($data) > 0) { ?>
    <div class="container">
        <div class="row">
            <?php foreach ($data as $group) { ?>

                <div class="d-flex flex-column search_result_box">
                    <div>
                        <a href="<?= asset('group_time_line/' . $group->id); ?>">
                            <?php
                            $studio_pic = asset('public/images/profile_pics/demo.png');
                            if ($group->pic) {
                                $studio_pic = asset('public/images/' . $group->pic);
                            }
                            ?>
                            <div class="thumbnail" style="background-image: url(<?= $studio_pic; ?>);width:100%;">
                                <img class="img-fluid"  src="<?= asset('userassets/images/place.png') ?>" style="position:relative;z-index:-1;">
                            </div>
                        </a>
                    </div> <!-- image thumbnail -->
                    <div class="w-100">

                        <div class="row align-items-center">
                            <div class="col-md-7">
                                <a href="<?= asset('group_time_line/' . $group->id) ?>" class="u_name">
                                    <?= $group->name ?>
                                    <?php if ($group->user->is_online) { ?>
                                        <span class="active_status"></span>
                                    <?php } ?>
                                </a>
                                <div class="profession"><?= $group->getCategory ? $group->getCategory->title : '' ?></div>
                                <div class="rating_reviews">
                                    <div class="star-ratings-sprite-gray">
                                        <span style="width: <?= $group->rating_percentage ? $group->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                                    </div>
                                    <span class="reviews text_grey">(<?= $group->number_of_reviews ? $group->number_of_reviews : '0' ?> Reviews)</span>
                                </div>
                            </div> <!-- col -->
                            <div class="col-md-5 text-right">
                                <?php
                                if (Auth::user()) {
                                    if (Auth::user()->type != 'artist') {
                                        ?>
                                        <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                    <?php }
                                } else {
                                    ?>
                                    <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                <?php } ?>
                            </div>

                        </div> <!-- row -->

                        <div class="text-content">
                            <?= substr($group['description'], 0, 400) . ' ...'; ?>
                        </div> <!-- text content -->

                        <div class="row">
                            <div class="col-md-6">
                                <i class="fa fa-map-marker-alt"></i>
                                <span class="font-weight-bold">Location:</span>
                                <?php
                                $group_location = $group->location;
                                if (strlen($group_location) > 50) {
                                    $group_location = substr($group_location, 0, 50) . '...';
                                }
                                echo $group_location;
                                ?>

                            </div> <!-- col -->
                            <div class="col-md-6">
                                <i class="fa fa-users"></i>
                                <span class="font-weight-bold">Team Members :</span> <?= $group->approvedMembers->count() ?>
                            </div> <!-- col -->
                        </div> <!-- row -->
                        <div class="w-100 follow_btns">
                            <div class="following_status text-center mt-4">
                                <?php
                                if (Auth::user()) {
                                    if (Auth::user()->id != $group->admin_id) {
                                        ?>
                                        <a href="#" class="btn_follow pl-2 pr-2 pt-2 pb-2"> Follow</a>
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#modal_search_messages<?= $group->id; ?>" class="btn_message pl-2 pr-2 pt-2 pb-2">Message</a>
                                    <?php }
                                } else {
                                    ?>
                                    <a href="<?= asset('login') ?>" class="btn_follow pl-2 pr-2 pt-2 pb-2">Follow</a>
                                    <a href="<?= asset('login') ?>" class="btn_message pl-2 pr-2 pt-2 pb-2">Message</a>
                                <?php } ?>
                            </div> <!-- following buts -->
                        </div> <!-- col -->

                    </div> <!-- right side -->
                </div>

                <!-- search_result_box -->

        <?php if (Auth::user()) { ?>
                    <!-- Message modal Start -->
                    <div class="modal fade" id="modal_search_messages<?= $group->id; ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title text-black" id="exampleModalLabel">New message To <span class="text_maroon"> <?= $group->name; ?> </span></h6>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i class="fas fa-times-circle"></i>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group mb-0">
                                                    <textarea id="message_g<?= $group->id; ?>" class="form-control h_140" placeholder="Write a message"></textarea>
                                                </div>
                                            </div>
                                        </div> <!-- row -->
                                        <div class="mt-2">
                                            <button type="button" onclick="sendMessageFromSearchServices('<?= $group->admin_id; ?>', 'g', '<?= $group->id; ?>')" class="btn btn-gradient btn-xl text-semibold">Send</button>
                                        </div>
                                    </form>
                                </div> <!-- modal-body-->
                            </div> <!-- modal-content-->
                        </div>
                    </div> <!-- Edit Description modal -->
                    <!--  Message modal END -->
        <?php }
    }
    ?>
        </div>
    </div>
<?php } ?>