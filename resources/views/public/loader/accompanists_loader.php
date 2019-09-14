<?php foreach ($accompanists as $accompanist) { ?>    

    <div class="col-sm-6">
        <div class="teaching-class-box">
            <?php
            $cover = asset('public/images/accompanists/cover_photo_demo.jpg');
            if ($accompanist->cover) {
                $cover = asset('public/images/' . $accompanist->cover);
            }
            ?>
            <div class="class_image" style="background-image: url(<?= $cover ?>)" onclick="window.location.href = '<?= asset('accompanist_time_line/' . $accompanist->id) ?>';" style="cursor: pointer;"></div> 
            <div class="class_body">
                <div class="d-flex">
                    <div>
                        <a href="javascript:void(0)" class="text-semibold text_darkblue">
                            <?php
                            $pic = asset('public/images/profile_pics/demo.png');
                            if ($accompanist->pic) {
                                $pic = asset('public/images/' . $accompanist->pic);
                            }
                            ?><span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $pic ?>)"></span>
                        </a>
                    </div>
                    <div>
                        <h4 class="mb-0">
                            <a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="text-semibold text_darkblue">
                                <?= $accompanist->name ?>
                                <?php if ($accompanist->user->is_online) { ?>
                                    <span class="active_status"></span>
                                <?php } ?>
                            </a>
                        </h4>
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
                        </div>
                    </div>
                    <?php if (Auth::user()) { ?>
                        <span class="ml-auto" id="add-bookmark-btn-<?= $accompanist->id ?>" <?php if ($accompanist->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart" onclick="addBookmark('<?= $accompanist->id; ?>')"></i></span>
                        <span class="ml-auto" id="remove-bookmark-btn-<?= $accompanist->id ?>" <?php if (!$accompanist->bookmarked_count) { ?> style="display: none" <?php } ?>><i class="fas fa-heart done" onclick="removeBookmark('<?= $accompanist->id; ?>')"></i></span>
                    <?php } else { ?>
                        <a class="ml-auto" href="<?= asset('/') ?>"> <i class="fas fa-heart"></i></a>
                    <?php } ?>
                </div>
                <hr>
                <div class="text_aqua font-weight-bold text-uppercase">Description</div>
                <div class="text">
                    <p>
                        <?php
                        $studio_description = $accompanist->description;
                        if (strlen($studio_description) > 100) {
                            $studio_description = substr($studio_description, 0, 100) . '...';
                        }
                        echo $studio_description;
                        ?>
                    </p>
                </div>
                <div class="row class_info">
                    <div class="col-6 col-sm-6">
                        <div class="text_aqua text-semibold text-uppercase">Location</div>
                        <p class="text_grey font-18 mb-0">
                            <?php
                            $studio_location = $accompanist->location;
                            if (strlen($studio_location) > 20) {
                                $studio_location = substr($studio_location, 0, 20) . '...';
                            }
                            echo $studio_location;
                            ?>
                        </p>
                    </div>
                    <div class="col-6 col-sm-6">
                        <?php
                        $unit = $accompanist->unit->title;
                        if ($accompanist->unit->title == 'hour') {
                            $unit = 'hr';
                        }
                        ?>
                        <div class="text_aqua text-semibold text-uppercase">Price</div>
                        <p class="text_grey font-18 mb-0">$<?= $accompanist->price ?></strong> / <?= $accompanist->per_unit . ' ' . $unit ?></p>
                    </div>
                </div>
                <div class="d-flex buttons_group">
                    <a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="btn btn-round btn-grey-outline">View Detail</a>
                    <?php if ($accompanist->allow_booking) { ?>
                        <?php if ($accompanist->admin_id != Auth::id()) { ?>
                            <?php
                            if (Auth::user()) {
                                if (Auth::user()->type == 'user') {
                                    ?>
                                    <a href="<?= asset('accompanist_time_line/' . $accompanist->id) ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                                <?php
                                }
                            } else {
                                ?>
                                <a href="<?= asset('login') ?>" class="btn btn_aqua btn-round font-weight-normal">Book Now</a>
                            <?php } ?>
                        <?php } ?>
    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
