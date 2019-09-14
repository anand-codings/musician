<?php foreach ($data as $key => $value) { ?>
    <tr class="row_<?= $value['post_id'] ?>">
        <td class="align-middle event_name" data-header="Event Names">
            <div class="media align-items-center">
                <span class="icon_43 icon-events rounded-circle mr-2"></span>
                <div class="media-body">
                    <strong><a href="<?=asset('gig_detail/'.$value['id'])?>" class="text_darkblue user_name"><?= $value['title'] ?></a></strong>
                    <div class="date_time"><?=$value->user->getSpecialization ? 'As '.$value->user->getSpecialization->title : '' ?></div>
                </div>
            </div>
        </td>
        <td class="event_stat" data-header="States">
            <span class="text_darkblue"><?=$value->bookings ? $value->bookings->count() : '0 '?> Times Booked</span>
        </td>
        <td class="event_location" data-header="Location">
            <span class="text_darkblue"><?= $value['location'] ?></span>
        </td>
        <td class="event_price" data-header="Price">
            <span class="text_darkblue">$<?= $value['price'] ?></span>
        </td>
        
        <td class="event_actions" data-header="Actions">
            <div class="btns">
                <a href="<?=asset('edit_gig/'.$value['id'])?>" class="act_accept text-black">Edit</a>
                <!--<a href="javascript:void(0)" class="act_accept text-black" data-toggle="modal" data-target="#edit_modal_<?= $value['id'] ?>">Edit</a>-->
                <a href="javascript:void(0)" data-toggle="modal" data-target="#delete_event_<?= $value['id'] ?>" class="act_decline text_red">Delete </a>
            </div>
        </td>
        <td class="hide">
            <div class="modal fade" id="edit_modal_<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="edit_modal" aria-hidden="true">
                <div class="modal-dialog modal-md" role="document">
                    <div class="modal-content edit-event-popup">
                        <div class="modal-header">
                            <h5 class="modal-title" id="edit_modal">Edit Gig</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger ajax-response" style="display: none"></div>
                            <form id="update_event<?= $value['id'] ?>" action="" method="post">
                                <div class="create_event_form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Profile Pic</label>
                                            <div class="row">
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-4">
                                                    <div class="edit_user_profile_pic">
                                                        <?php
                                                        $pic = asset('public/images/profile_pics/demo.png');
                                                        if($value['profile_pic']){
                                                            $pic = asset($value['profile_pic']);    
                                                        }
                                                        ?>
                                                        <div class="image gig_profile_pic_div" style="background-image:url(<?=$pic?>)"></div>
                                                        <ul class="un_style no_icon action_dropdown">
                                                            <li class="dropdown">
                                                                <a href="#" data-toggle="dropdown" role="button" aria-expanded="true" class="dropdown-toggle"> <span class="icon_camera"></span> Change Photo <i class="fas fa-angle-down"></i> </a>
                                                                <div class="dropdown-menu dropdown-menu-right custom_dropdown">
                                                                    <a class="dropdown-item profile_upload_btn" href="#">
                                                                        <input type="file" name="profile_pic" class="gig_profile_pic" onchange="changeProfilePicInGigModal(this)"/>
                                                                        <i class="fas fa-cloud-upload-alt"></i> Upload Photo 
                                                                    </a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div> <!-- col -->
                                                <div class="col-sm-4"></div>
                                            </div>
                                            
                                            <label>Gig Photo</label>
                                            <div  class="form-group upload_image" id="upload_image<?=$value['id']?>" <?= $value['image'] ? "style='display:none;'" : ''?>>
                                                <div class="event_cover_photo d-flex align-items-center align-self-center">
                                                    <div class="custom-file upload_btn text-center mx-auto">
                                                        <input type="file" id="edit-gig-cover-photo-input<?=$value['id']?>" event-id="<?=$value['id']?>" onchange="changeCoverPhotoInEditEvent(this)" id="cover_image<?=$value['id']?>" name="image" class="custom-file-input">
                                                        <p class="text_aqua font-17 mb-0">+ Change Cover Photo</p>
                                                        <p class="text_grey font-13 mb-0">Best result size 980 x 525 pixels</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="events_pic form-group" id="events_pic<?=$value['id']?>" <?= !$value['image'] ? "style='display:none;'" : ''?>>
                                                <img src='<?= $value['image'] ?>' id="preview_event_img<?=$value['id']?>" alt='' class="img-fluid" />
                                                <i class="fas fa-times-circle" event-id="<?=$value['id']?>" onclick="showImageInEditCase(this)"></i>
                                            </div>

                                        </div>
                                        <div class="col-sm-6">
                                            <label>Location</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= $value['location'] ?>" class="form-control" id="autocomplete" name="location" />
                                                <input name="lat" id="lat" type="hidden" value="<?= $value['lat'] ?>">
                                                <input name="lng" id="lng" type="hidden" value="<?= $value['lng'] ?>">
                                            </div><!-- from group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <label>Range (km)</label>
                                            <div class="form-group">
                                                <input type="number" onkeypress="if (this.value.length == 10) return false;" value="<?= $value['range'] ?>" name="range" class="form-control" />
                                            </div><!-- from group -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label>Price</label>
                                            <div class="form-group">
                                                <input type="text" value="<?= $value['price'] ?>" name="price" class="form-control" />
                                            </div><!-- from group -->
                                        </div> <!-- col -->
                                        <div class="col-sm-6">
                                            <label>Per Unit</label>
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <input type="number" value="<?= $value['per_unit'] ?>" name="per_unit" class="form-control" />
                                                    </div><!-- from group -->
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <select class="form-control" name="unit_id">
                                                            <?php foreach(units() as $unit) { ?>
                                                                <option value="<?=$unit->id?>" <?=$value['unit_id'] == $unit->id ? 'selected' : ''?>><?=$unit->title?></option>
                                                            <?php } ?>
                                                        </select><!-- from group -->
                                                    </div><!-- from group -->
                                                </div>
                                            </div> <!-- row -->
                                        </div> <!-- col -->
                                    </div> <!-- row -->
                                    
                                    <div class="row">
                                            <div class="col-sm-12">
                                                <label>Select Categories</label>
                                                <div class="form-group">
                                                    <select required name="categories[]" class="multiple_solo_categories"  multiple="multiple" class="form-control" style="width: 100%">
                                                        <?php foreach (soloCategories() as $artistType) { ?>
                                                            <option value="<?= $artistType->id ?>"><?= $artistType->title ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div><!-- from group -->
                                            </div> <!-- col -->
                                        </div>

                                        <div class="row">
                                            <div class="col-sm-6">
                                                <label>Ensemble Category</label>
                                                <div class="form-group">
                                                    <select required name="ensemble_category" class="form-control" style="width: 100%">
                                                        <?php foreach (ensembleCategories() as $cat) { ?>
                                                            <option value="<?= $cat->id ?>"><?= $cat->title ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div><!-- from group -->
                                            </div> <!-- col -->
                                            <div class="col-sm-6">
                                                <label>Genre</label>
                                                <div class="form-group">
                                                    <select required name="genre" class="form-control selct2_select" style="width: 100%">
                                                        <option value="" selected="">--Select a genre--</option>
                                                        <option>Baroque</option>
                                                        <option>Classical</option>
                                                        <option>Jazz</option>
                                                        <option>Country</option>
                                                        <option>World</option>
                                                        <option>Rock</option>
                                                        <option>Electronic</option>
                                                        <option>Popular</option>
                                                        <option>Wedding</option>
                                                    </select>
                                                </div><!-- from group -->
                                            </div> <!-- col -->
                                        </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Gig Title</label>
                                            <div class="form-group">
                                                <input maxlength="150" type="text" onkeyup="descriptionCountCharToMax(this, 150, '<?= 'gig_title' . $value['id'] ?>')" value="<?= $value['title'] ?>" name="event_title" class="form-control"  />
                                                <input  type="hidden" value="<?= $value['id'] ?>" name="edit_id"/>
                                                <span class='info' id="<?= 'gig_title' . $value['id'] ?>"><span class="text_length_title">150</span> Characters</span>
                                            </div><!-- from group -->
                                        </div>
                                    </div> <!-- row -->
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <label>Gig Detail</label>
                                            <div class="form-group">
                                                <textarea maxlength="300" onkeyup="descriptionCountCharToMax(this, 300, '<?= 'gig_description' . $value['id'] ?>')" class="form-control h_140" name="event_detail"><?= $value['description'] ?></textarea>
                                                <span class='info' id="<?= 'gig_description' . $value['id'] ?>"><span class="text_length_desc">300</span> Characters</span>
                                            </div><!-- from group -->
                                        </div>
                                    </div> <!-- row -->

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" name="custom_booking" id="lbl_custom_booking_<?= $value['id'] ?>" <?= ($value['custom_booking'] == 'yes') ? 'checked' : ''; ?>>
                                                    <label class="custom-control-label font-weight-normal" for="lbl_custom_booking_<?= $value['id'] ?>">Enable booking.</label>
                                                </div>
                                            </div><!-- from group -->
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="status" class="custom-control-input" <?= ($value['status'] == 'inactive') ? 'checked' : ''; ?> id="lbl_inactive_events<?= $value['id'] ?>">
                                                    <label class="custom-control-label font-weight-normal" for="lbl_inactive_events<?= $value['id'] ?>">Inactive Gig</label>
                                                </div>
                                            </div><!-- from group -->
                                        </div>
                                    </div> <!-- row -->
                                </div> <!-- create event form -->
                            </form>
                        </div> <!-- modal body -->
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-round btn-gradient btn-xl text-semibold btn_post_event_update" event-id="<?= $value['id'] ?>">
                                <strong>Save</strong>
                                <span class="loader_inline" id="edit_gig_loader<?=$value['id']?>" style="display: none;">
                                    <img src="<?=asset('userassets/images/loader.gif')?>" alt="loading..">
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Delete Model-->
            <div class="modal fade" id="delete_event_<?= $value['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="delete_event" aria-hidden="true">
                <div class="modal-dialog modal-md modal-dialog-centered" role="document">
                    <div class="modal-content edit-event-popup">
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Gig</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="fas fa-times-circle"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div>
                                    <label class="font-weight-bold">Are you sure you want to Delete this Gig?</label>
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="button"data-id="<?= $value['post_id'] ?>" class="delete_event btn btn-round btn-gradient btn-xl font-weight-bold">Yes</button>
                                    <button type="button" class="btn btn-round btn-red-outlines btn-xl font-weight-bold" data-dismiss="modal"> No </button>
                                </div>
                            </form>
                        </div> <!-- modal body -->
                    </div>
                </div>
            </div> <!-- modal -->

        </td>
    </tr>



    <script>
        $('.multiple_solo_categories').select2(function(
            placeholder: "--Select Categories--",
            maximumSelectionLength: 3
        ));
        function descriptionCountCharToMax(val, len, id_to_show) {
            var max = len;
            var min = 0;
            var len = val.value.length;
            if (len >= max) {
                val.value = val.value.substring(min, max);
                $('#' + id_to_show).text(+max - len + ' characters');
            } else {
                $('#' + id_to_show).text(+max - len + ' characters');
            }
        }
    </script>
<?php } ?>