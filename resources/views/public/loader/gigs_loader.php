<?php foreach ($gigs as $gig) { ?>

    <div class="col-sm-6 mb-3">
        <div class="group-box">
            <?php
            $cover = asset('public/images/groups/cover_photo_demo.jpg');
            if($gig->getEvent->image){
                $cover = $gig->getEvent->image;
            }
            ?>
            <div class="group_image" style="background-image: url(<?=$cover?>)">
                <span class="label">
                    <?php
                    if (!$gig->getEvent->getSelectedCategories->isEmpty()) {
                        $getSelectedArtistTypesCount = $gig->getEvent->getSelectedCategories->count();

                        if($getSelectedArtistTypesCount <= 2){
                            $i = 1;
                            foreach ($gig->getEvent->getSelectedCategories as $selectedArtistType) {
                                echo $selectedArtistType->getCategory->title;
                                if ($getSelectedArtistTypesCount > $i)
                                    echo ', ';
                                $i++;
                            }
                        } else {
                            $i = 1;
                            foreach ($gig->getEvent->getSelectedCategories as $selectedArtistType) {
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
                        <a href="<?=asset('gig_detail/' . $gig->id)?>" class="text-semibold text_darkblue">
                            <?php
                            $gig_pic = asset('public/images/profile_pics/demo.png');
                            if ($gig->getEvent->profile_pic) {
                                $gig_pic = $gig->getEvent->profile_pic;
                            }
                            ?>
                            <span class="bg_image_round w-45 mr-2" style="background-image: url(<?= $gig_pic ?>)"></span> 
                        </a>
                    </div>
                    <div>
                        <h6 class="mb-0"><a href="<?=asset('gig_detail/' . $gig->id)?>" class="text-semibold text_darkblue"><?= $gig->getEvent->title ?></a></h6>
                        <div class="rating_reviews">
                            <div class="star-ratings-sprite-gray">
                                <span style="width: <?= $gig->getEvent->rating_percentage ? $gig->getEvent->rating_percentage : '0' ?>%;" class="star-ratings-sprite-rating-gray"></span>
                            </div>
                            <span class="reviews text_grey">(<?= $gig->getEvent->number_of_reviews ? $gig->getEvent->number_of_reviews : '0' ?> Reviews)</span>
                        </div>
                    </div>
                </div>
                <hr>

                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <span class="text-dark d-md-block"><strong>LOCATION</strong></span>
                        <span class="text_grey">
                            <?php
                                $gig_location = $gig->getEvent->location;
                                if (strlen($gig_location) > 50) {
                                    $gig_location = substr($gig_location, 0, 50). '...';
                                }
                                echo $gig_location;
                            ?>
                        </span>
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <span class="text-dark d-md-block"><strong>PRICE</strong></span>
                        <?php
                        $unit = $gig->getEvent->unit->title;
                        if($gig->getEvent->unit->title == 'hour') { 
                            $unit = 'hr';     
                        }
                        ?>
                        <div class="text_grey font-16"> <strong class="text_green">$<?= $gig->getEvent->price ?></strong> / <?= $gig->getEvent->per_unit.' '.$unit ?></div>
                    </div>
                </div>
                <div class="d-flex buttons_group">
                    <a href="<?=asset('gig_detail/' . $gig->getEvent->id)?>" class="btn btn-round btn-grey-outline">View Detail</a>
                    
                    <?php if($gig->getEvent->allow_booking == 1) { ?>
                        <?php if(Auth::user()) {
                            if(Auth::user()->type == 'user'){ ?>
                            <a href="javascript:void(0)" class="btn btn_aqua btn-round" data-toggle="modal" data-target="#modal_eventbooking<?= $gig->id ?>">Book Now</a>
                        <?php }} else { ?>
                            <a href="<?=asset('login')?>" class="btn btn_aqua btn-round">Book Now</a>
                        <?php } ?>
                    <?php } ?>

                </div>

            </div> <!-- group body -->
        </div> <!-- group box -->
    </div>
   
    <?php if (Auth::user()) { ?>
        <!-- Booking modal Start -->
        <div class="modal fade" id="modal_eventbooking<?= $gig->id ?>" tabindex="-1" role="dialog" aria-labelledby="add_affiliation" aria-hidden="true">
            <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Booking</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i class="fas fa-times-circle"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php
                        $book_now = '';
                        if (Auth::user()) {
                            if (!Auth::user()->stripe_id) {
                                $book_now = 1;
                                ?>
                                <h5 class="alert alert-info">Please Add Card To Book This Gig</h5>
                            <?php
                            }
                        } else {
                            $book_now = 1;
                            ?> 
                            <h5 class="alert alert-info">Please Login To Book This Gig</h5>
        <?php } ?>
                            <h5 id="booking_error<?= $gig->id ?>" class="alert alert-danger" style="display: none"></h5>
                            <div id="booking_success<?=$gig->id ?>" class="alert alert-success" style="display: none">
                                
                                
                            </div>
                            <form class="bookings_forms" method="post" action="<?= asset('add_booking')?>">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="events_pic form-group" style="">
                                        <?php
                                        if($gig->getEvent->image){
                                            $gig_image = $gig->getEvent->image;
                                        ?>
                                        <img src="<?=$gig_image?>" class="img-fluid">
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">First & Last Name </label>
                                        <input required id="booking_name<?=$gig->id ?>" type="text" placeholder="" class="form-control" value="<?= Auth::user()->first_name.' '.Auth::user()->last_name?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Your Email</label>
                                        <input required id="booking_email<?=$gig->id ?>" type="email" placeholder="" class="form-control"  value="<?= Auth::user()->email?>"/>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Gig Name</label>
                                        <input required disabled="" type="text" placeholder="" class="form-control" value="<?= $gig->getEvent->title ?>"/>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Location</label>
                                        <input required readonly="" id="booking_location<?= $gig->id ?>" type="text" placeholder="" class="form-control" value="<?= $gig->getEvent->location?>"/>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Date</label>
                                        <div class="d-flex">
                                            <input required readonly="" id="booking_date<?= $gig->id ?>" type="text" placeholder="Date" class="form-control mr-2 date-picker">
                                            <input id="user_id<?= $gig->id ?>" type="hidden" value="<?= $gig->user_id ?>"> 
                                            <input id="gig_id_<?= $gig->id ?>" type="hidden" value="<?= $gig->getEvent->id ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Range (km)</label>
                                        <input required readonly="" value="<?=$gig->getEvent->range?>" type="text" class="form-control" />
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Offering</label>
                                        <?php 
                                        $unit = $gig->getEvent->unit->title;
                                        if($gig->getEvent->unit->title == 'hour') { 
                                            $unit = 'hr';     
                                        }
                                        ?>
                                        <input required readonly="" id="booking_hours<?= $gig->id ?>" value="<?=$gig->getEvent->per_unit.'/'.$unit?>" type="text" placeholder="0:00" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="font-weight-bold">Ensemble Category</label>
                                    <div class="form-group">
                                        <select required name="ensemble_category" class="form-control" style="width: 100%" readonly="">
                                            <option value="<?= $gig->getEvent->ensembleCategory->title ?>" selected><?= $gig->getEvent->ensembleCategory->title ?></option>
                                        </select>
                                    </div><!-- from group -->
                                </div> <!-- col -->
                                <div class="col-sm-6">
                                    <label class="font-weight-bold">Genre</label>
                                    <div class="form-group">
                                        <select required name="genre" class="form-control selct2_select" style="width: 100%" readonly="">
                                            <option value="<?= $gig->getEvent->genre ?>" selected><?= $gig->getEvent->genre ?></option>
                                        </select>
                                    </div><!-- from group -->
                                </div> <!-- col -->
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Price offering</label>
                                        <input required readonly="" id="booking_price<?= $gig->id ?>" value="<?= $gig->getEvent->price ?>" type="text" placeholder="$$$" class="form-control" />
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">Description</label>
                                        <textarea required readonly="" id="booking_description<?=$gig->id ?>" class="form-control h_140"><?=$gig->getEvent->description?></textarea>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <?php if (!$book_now) {
                                if($current_id != $gig->user_id){?>
                                <div class="mt-2 text-center">
                                    <button onclick="addbooking('<?= $gig->id?>')" type="button" class="btn btn-round btn_aqua btn-xl text-semibold "> Book Now </button>
                                </div>
                            <?php }} ?>
                        </form>                        
                    </div> <!-- modal-body-->
                </div> <!-- modal-content-->
            </div>
        </div> <!-- Booking modal -->
        <!-- Booking modal END -->  
        <script> 
        $(".date-picker").datepicker({
            dateFormat: "DD, MM d, yy",
            changeYear: true,
            changeMonth: true,
            showButtonPanel: true,
            minDate:0,
            yearRange: "-150:+0"
        });
        </script>
    <?php }
} ?>