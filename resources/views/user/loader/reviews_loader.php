<?php foreach ($reviews as $review) { ?>
    <li>
        <div class="review_header">
            <div class="media align-items-center">
                <div class="d-flex align-items-center">
                    <?php
                    $userImage = getUserImage($review->getReviewedByUser->photo, $review->getReviewedByUser->social_photo, $review->getReviewedByUser->gender);
                    ?>
                    <span class="bg_image_round" style="background-image: url(<?= $userImage ?> )" onclick="window.location.href = '<?= asset('profile_timeline/' . $review->getReviewedByUser->id) ?>';"></span>
                    <div class="media-body">
                        <a href="<?= asset('profile_timeline/' . $review->getReviewedByUser->id) ?>" class="u_name"><?= $review->getReviewedByUser->first_name . ' ' . $review->getReviewedByUser->last_name ?></a>
                        <div class="rating_reviews">
                            <span> reviewed </span>
                            <div class="star-ratings-sprite-gray">
                                <span style="width: <?= (($review->rating) / 5) * 100 ?>%;" class="star-ratings-sprite-rating"></span>
                            </div>
                            <span class="reviews"> <?= $review->rating ?></span>
                        </div>
                        <span class="text_grey font-13 d-block d-sm-none"><?= timeago($review->updated_at) ?></span>
                    </div>
                </div>
                <div class="d-flex ml-auto align-items-center">
                    <span class="date_time d-none d-sm-block"><?= timeago($review->updated_at) ?></span>
                    <span class="review_share"><a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#modal_social_share_<?= $review->id ?>"><i class="fas fa-share-alt"></i> Share</a></span>
                </div>
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
            </div> <!-- media -->
        </div>
        <div class="review_body">
            <?= $review->review ?>
        </div>
    </li>
<?php } ?>