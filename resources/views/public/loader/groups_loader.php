<?php foreach ($groups as $group) { ?>    
    <div class="col-sm-6 mb-3" id="group-url-<?= $group->id; ?>" link="<?php echo asset('/group_time_line/' . $group->id) ?>">
        <div class="group-box">
            <?php
            $cover = asset('public/images/groups/cover_photo_demo.jpg');
            if ($group->cover) {
                $cover = asset('public/images/' . $group->cover);
            }
            ?>
            <div class="group_image" style="background-image: url(<?= $cover ?>)">
                <span class="label">
                    <?= $group->getCategory ? $group->getCategory->title : '' ?>
                </span>
                <ul class="un_style no_icon action_dropdown float-right">                                
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                            <i class="fas fa-ellipsis-h"></i>
                        </a>
                        <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                            <a onclick="copyGroupLink(<?= $group->id; ?>)" class="dropdown-item" href="javascript:void(0)"><i class="fas fa-copy"></i> Copy</a>
                            <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $group->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                            <?php if (Auth::user()) { ?>
                                <?php if ($group->admin_id != Auth::id()) { ?>
                                    <a <?php if ($group->reported) { ?> style="display: none" <?php } ?> id="report_group_<?= $group->id ?>" class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_reporting_<?= $group->id ?>"><i class="fas fa-flag"></i> Report</a>

                                    <a <?php if (!$group->reported) { ?> style="display: none" <?php } ?> id="reported_group_<?= $group->id ?>" class="dropdown-item" href="javascript:void(0)" ><i class="fas fa-flag"></i> Reported</a>
                                <?php } ?>

                                <?php if ($group->admin_id == Auth::id()) { ?>
                                    <a class="dropdown-item" href="<?= asset('edit_group/' . $group->id) ?>"><i class="fas fa-edit"></i> Edit</a>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </li>
                </ul>
                <!-- Social Share modal Start -->
                <div class="modal fade" id="modal_social_share_<?= $group->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
                                        <?php
                                        echo Share::page(asset('group_time_line/' . $group->id), $group->name, ['class' => 'posts_class', 'id' => $group->id])
                                                ->facebook($group->name)
                                                ->twitter($group->name)
                                                ->whatsapp($group->name);
                                        ?>
                                    </div>
                                </form>                        
                            </div> <!-- modal-body-->
                        </div> <!-- modal-content-->
                    </div>
                </div> <!-- Social Share modal -->

                <!-- Reporting modal Start -->
                <div class="modal fade" id="modal_reporting_<?= $group->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
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
                                            <input checked="" type="radio" name="reason" class="custom-control-input <?= 'reason_' . $group->id ?>" id="report_offensive<?= $group->id ?>" value="offensive">
                                            <label class="custom-control-label font-weight-bold" for="report_offensive<?= $group->id ?>" > Group is offensive </label>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $group->id ?>" id="report_spam<?= $group->id ?>" value="Spam">
                                            <label class="custom-control-label font-weight-bold" for="report_spam<?= $group->id ?>"> Spam </label>
                                        </div>
                                    </div>
                                    <div class="mb-1">
                                        <div class="custom-control custom-checkbox">
                                            <input type="radio" name="reason" class="custom-control-input <?= 'reason_' . $group->id ?>" id="report_unrelated<?= $group->id ?>" value="Unrelated">
                                            <label class="custom-control-label font-weight-bold" for="report_unrelated<?= $group->id ?>"> Unrelated </label>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-center">
                                        <input type="button" onclick="report_group('<?= $group->id ?>')" class="btn btn-round btn-gradient btn-xl text-semibold" value="Report Group">
                                    </div>
                                </form>                        
                            </div> <!-- modal-body-->
                        </div> <!-- modal-content-->
                    </div>
                </div> <!-- Reporting modal -->

            </div> <!-- group image -->
            <div class="group_body">                                    

                <div class="d-flex align-items-center">
                    <div>
                        <a href="<?= asset('group_time_line/' . $group->id) ?>" class="text-semibold text_darkblue">
                            <?php
                            $studio_pic = asset('public/images/profile_pics/demo.png');
                            if ($group->pic) {
                                $studio_pic = asset('public/images/' . $group->pic);
                            }
                            ?>
                            <span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $studio_pic ?>)"></span>
                        </a>
                    </div>
                    <div>
                        <h6 class="mb-0">
                            <a href="<?= asset('group_time_line/' . $group->id) ?>" class="text-semibold text_darkblue">
                                <?= $group->name ?>
                                <?php if ($group->user->is_online) { ?>
                                    <span class="active_status"></span>
                                <?php } ?>
                            </a>
                        </h6>
                        <div class="rating_reviews">
                            <div class="star-ratings-sprite-gray">
                                <span style="width: <?= $group->rating_percentage ? $group->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                            </div>
                            <span class="reviews text_grey">(<?= $group->number_of_reviews ? $group->number_of_reviews : '0' ?> Reviews)</span>
                        </div>
                    </div>
                    <?php if (Auth::user()) { ?>
                        <span class="ml-auto" id="add-bookmark-btn-<?= $group->id ?>" <?php if ($group->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart" onclick="addBookmark('<?= $group->id; ?>')"></i></span>
                        <span class="ml-auto" id="remove-bookmark-btn-<?= $group->id ?>" <?php if (!$group->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart done" onclick="removeBookmark('<?= $group->id; ?>')"></i></span>
                    <?php } else { ?>
                        <a class="ml-auto" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i></a>
                    <?php } ?>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <span class="text-dark d-md-block"><strong>LOCATION</strong></span>
                        <span class="text_grey">
                            <?php
                            $group_location = $group->location;
                            if (strlen($group_location) > 50) {
                                $group_location = substr($group_location, 0, 50) . '...';
                            }
                            echo $group_location;
                            ?>
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <span class="text-dark d-md-block"><strong>Event Services Members</strong></span>
                        <span class="text_grey"><?= $group->approvedMembers->count() ?></span>
                    </div>
                </div>
                <div class="d-flex buttons_group">
                    <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                    <!--<a href="<?= asset('login') ?>" class="btn btn-round btn-blue">Book Now</a>-->

                    <?php if ($group->allow_booking) { ?>
                        <?php if ($group->admin_id != Auth::id()) { ?>
                            <?php
                            if (Auth::user()) {
                                if (Auth::user()->type == 'user') {
                                    ?>
                                    <a href="<?= asset('group_time_line/' . $group->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                    <?php
                                }
                            } else {
                                ?>
                                <a href="<?= asset('login') ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>

                </div>

            </div> <!-- group body -->
        </div> <!-- group box -->
    </div>
<?php } ?>
