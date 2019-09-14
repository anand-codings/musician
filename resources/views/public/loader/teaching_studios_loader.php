<?php foreach ($teachingStudios as $val) { ?>    
    <div class="col-sm-6 mb-3">
        <div class="group-box">
            <?php
            $cover = asset('public/images/teaching_studios/cover_photo_demo.jpg');
            if ($val->cover) {
                $cover = asset('public/images/' . $val->cover);
            }
            ?>
            <div class="group_image" style="background-image: url(<?= $cover ?>)" onclick="window.location.href = '<?= asset('teaching_studio_time_line/' . $val->id) ?>';" style="cursor: pointer;">
                <span class="label">
                    <?php
                    if (!$val->getSelectedCategories->isEmpty()) {
                        $getSelectedArtistTypesCount = $val->getSelectedCategories->count();

                        if ($getSelectedArtistTypesCount <= 2) {
                            $i = 1;
                            foreach ($val->getSelectedCategories as $selectedArtistType) {
                                echo $selectedArtistType->getCategory->title;
                                if ($getSelectedArtistTypesCount > $i)
                                    echo ', ';
                                $i++;
                            }
                        } else {
                            $i = 1;
                            foreach ($val->getSelectedCategories as $selectedArtistType) {
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
                </span>
            </div> <!-- group image -->
            <div class="group_body">
                <div class="d-flex align-items-center">
                    <div>
                        <a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="text-semibold text_darkblue">
                            <?php
                            $studio_pic = asset('public/images/profile_pics/demo.png');
                            if ($val->pic) {
                                $studio_pic = asset('public/images/' . $val->pic);
                            }
                            ?>
                            <span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $studio_pic ?>)"></span>
                        </a>
                    </div>
                    <div>
                        <h6 class="mb-0">
                            <a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="text-semibold text_darkblue">
                                <?= $val->name ?>
                                <?php if ($val->user->is_online) { ?>
                                    <span class="active_status"></span>
                                <?php } ?>
                            </a>
                        </h6>
                        <div class="rating_reviews">
                            <div class="star-ratings-sprite-gray">
                                <span style="width: <?= $val->rating_percentage ? $val->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                            </div>
                            <span class="reviews text_grey">(<?= $val->number_of_reviews ? $val->number_of_reviews : '0' ?> Reviews)</span>
                        </div>
                    </div>
                    <?php if (Auth::user()) { ?>
                        <span class="ml-auto" id="add-bookmark-btn-studio-<?= $val->id ?>" <?php if ($val->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart" onclick="addBookmarkStudio('<?= $val->id; ?>')"></i></span>
                        <span class="ml-auto" id="remove-bookmark-btn-studio-<?= $val->id ?>" <?php if (!$val->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart done" onclick="removeBookmarkStudio('<?= $val->id; ?>')"></i></span>
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
                            $studio_location = $val->location;
                            if (strlen($studio_location) > 20) {
                                $studio_location = substr($studio_location, 0, 20) . '...';
                            }
                            echo $studio_location;
                            ?>
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <span class="text-dark d-md-block"><strong>Price</strong></span>
                        <?php
                        $unit = $val->unit->title;
                        if ($val->unit->title == 'hour') {
                            $unit = 'hr';
                        }
                        ?>
                        <div class="text_grey font-16"> <strong class="text_green">$<?= $val->price ?></strong> / <?= $val->per_unit . ' ' . $unit ?></div>
                    </div>
                </div>
                <div class="d-flex buttons_group">
                    <a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                    <?php if ($val->allow_booking) { ?>
                        <?php if ($val->admin_id != Auth::id()) { ?>
                            <?php
                            if (Auth::user()) {
                                if (Auth::user()->type == 'user') {
                                    ?>
                                    <a href="<?= asset('teaching_studio_time_line/' . $val->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                <?php }
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
