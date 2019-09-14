<?php foreach ($reviews as $review) { ?>

    <div class="review_wrap" id="review-card<?= $review->id ?>">
        <?php if ($review->type == 'review') { ?>
            <?php

            $cover = asset('public/images/profile_pics/cover_photo_demo.png');
            $pic = asset('public/images/profile_pics/demo.png');
            $nameOfReviewDataType = '';
            $idOfReviewDataType = '';
            $icon = '';
            $linkOfReviewDataType = '';
            $gig_type = ucfirst(str_replace('_', ' ', $review->type));

            if ($review->gig_type == 'gig') {

                $icon = 'ic_calender';
                $idOfReviewDataType = $review->gig->id;
                $linkOfReviewDataType = 'javascript:void(0)';
                $nameOfReviewDataType = $review->gig->title;
                if ($review->gig->image) {
                    $cover = $review->gig->image;
                }
                if ($review->gig->profile_pic) {
                    $pic = $review->gig->profile_pic;
                }
            } else if ($review->gig_type == 'group') {

                $icon = 'ic_media';
                $idOfReviewDataType = $review->group->id;
                $linkOfReviewDataType = asset('group_time_line/' . $review->group->id);
                $nameOfReviewDataType = $review->group->name;
                if ($review->group->cover) {
                    $cover = asset('public/images/' . $review->group->cover);
                }
                if ($review->group->pic) {
                    $pic = asset('public/images/' . $review->group->pic);
                }
            } else if ($review->gig_type == 'teaching_studio') {
                $icon = 'ic_music';
                $idOfReviewDataType = $review->studio->id;
                $linkOfReviewDataType = asset('teaching_studio_time_line/' . $review->studio->id);
                $nameOfReviewDataType = $review->studio->name;
                if ($review->studio->cover) {
                    $cover = asset('public/images/' . $review->studio->cover);
                }
                if ($review->studio->pic) {
                    $pic =  asset('public/images/' . $review->studio->pic);
                }
            } else if ($review->gig_type == 'accompanist') {
                $icon = 'ic_accompainst_w';
                $idOfReviewDataType = $review->accompanist->id;
                $linkOfReviewDataType = asset('accompanist_time_line/' . $review->accompanist->id);
                $nameOfReviewDataType = $review->accompanist->name;
                if ($review->accompanist->cover) {
                    $cover = asset('public/images/' . $review->accompanist->cover);
                }
                if ($review->accompanist->pic) {
                    $pic = asset('public/images/' . $review->accompanist->pic);
                }
            }
            ?>
            <div class="review_header" style="background-image: url('<?= $cover ?>'); background-size: cover;">
                <div class="overlay">
                    <div class="d-flex align-items-center">
                        <div class="image">
                            <span class="bg_image_round" style="background-image: url(<?= $pic ?>);"></span>
                        </div>
                        <div class="title">
                            <h3>
                                <a href="<?= $linkOfReviewDataType ?>" class="text-white"><?= $nameOfReviewDataType ?></a>
                            </h3>
                            <span><i class="s_icon white <?= $icon ?>"></i> <?= $review->gig_type == 'group' ? 'Event Services' : ucfirst(str_replace("_", " ", $review->gig_type)) . 's' ?></span>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="review_body">
            <div class="meta d-flex">
                <div>
                    <?php if ($review->type == 'review') { ?>
                        <div class="star-ratings-sprite-gray">
                            <span style="width: <?= (($review->rating) / 5) * 100 ?>%;" class="star-ratings-sprite-rating"></span>
                        </div>
                        <span class="reviews"> <?= $review->rating ?></span>
                    <?php } ?>
                </div>
                <div class="d-flex ml-auto align-items-center">
                    <span class="date_time d-none d-sm-block"><?= timeago($review->created_at) ?></span>
                    <ul class="un_style no_icon action_dropdown float-right">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle">
                                <i class="fas fa-ellipsis-h"></i>
                            </a>
                            <div class="dropdown-menu tip_right dropdown-menu-right custom_dropdown">
                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $review->id ?>"><i class="fas fa-share-alt"></i> Share</a>
                                <?php if ($review->reviewed_by == $current_id) { ?>
                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_delete_<?= $review->id ?>"><i class="fas fa-copy"></i> Delete</a>
                                <?php } ?>
                            </div>
                        </li>
                    </ul>
                    <!-- Social Share modal Start -->
                    <div class="modal fade" id="modal_social_share_<?= $review->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
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
                                            <?php
                                            echo Share::page(asset('profile_reviews/' . $review->getUser->id), $review->review, ['class' => 'posts_class', 'id' => $review->id])
                                                ->facebook($review->review)
                                                ->twitter($review->review)
                                                ->whatsapp($review->review);
                                            ?>
                                        </div>
                                    </form>
                                </div> <!-- modal-body-->
                            </div> <!-- modal-content-->
                        </div>
                    </div> <!-- Social Share modal -->
                    <!-- Social Share modal END -->
                    <!-- Delete Model-->
                    <div class="modal fade" id="modal_delete_<?= $review->id ?>" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md" role="document">
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
                                            <button type="button" data-id="" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold" onclick="deleteReview(<?= $review->id; ?>)">Yes</button>
                                            <button type="button" class="btn btn-round btn_no btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                        </div>
                                    </form>
                                </div> <!-- modal body -->
                            </div>
                        </div>
                    </div> <!-- Delete modal -->
                </div>
            </div>
            <div class="text">
                <p><?= $review->review ?></p>
            </div>
            <div class="d-flex align-items-center">
                <div class="image mr-3">
                    <?php
                    $imageOfReviewedByUser = asset('public/images/profile_pics/demo.png');
                    if ($review->getReviewedByUser->photo) {
                        $imageOfReviewedByUser = asset('public/images/' . $review->getReviewedByUser->photo);
                    }
                    ?>
                    <a href="<?= asset('profile_timeline/' . $review->getReviewedByUser->id) ?>">
                        <span class="bg_image_round w-45" style="background-image: url('<?= $imageOfReviewedByUser ?>')"></span>
                    </a>
                </div>
                <div class="title">
                    <strong>
                        <a href="<?= asset('profile_timeline/' . $review->getReviewedByUser->id) ?>" class="text_darkblue"><?= $review->getReviewedByUser->first_name . ' ' . $review->getReviewedByUser->last_name ?></a>
                    </strong>
                </div>
            </div>
        </div>
    </div>

<?php } ?>