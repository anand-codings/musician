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
<style>
    #overlay {
        padding: 6px;
        position: fixed;
        z-index: 1000;
        top: 71px;
        color: rgb(255, 255, 255);
        background: -webkit-linear-gradient(35deg, #b62e65, #58248a);
        width: 100px;
        margin: auto;
        left: 0px;
        right: 0px;
        height: 38px;
        font-size: 16px;
        text-align: center;
        font-weight: 600;
        box-shadow: rgb(0, 0, 0) 0px 0px 3px;
        border-radius: 0px 0px 5px 5px;
        display: none;
    }

    #pagination {
        margin: 0px auto 0px auto;
        width: 100%;
        clear: both;
        max-width: 767px;
        text-align: center;
        overflow: hidden;
    }

    .range-slider {
        display: none;
        position: relative;
        height: 40px;
        margin-bottom: 30px;
    }

    .for_studios,
    .for_gigs,
    .for_groups,
    .for_accompanists {
        display: none;
    }

</style>
<?php if (Auth::guard('user')->check()) { ?>
    <div class="sidebar show_on_mobile">
        <?php include resource_path('views/includes/sidebar.php'); ?>
    </div>
<?php } ?>
<div class="page_timeline">

    <?php
    $category_for_header = '';
    if (isset($category) && $category) {
        $category_for_header = $category->title;
    }
    $location_for_header = '';
    if (isset($_GET['location']) && $_GET['location']) {
        $location_for_header = $_GET['location'];
    }
    $search_type = '';
    if (isset($_GET['search_type']) && $_GET['search_type']) {
        $search_type = $_GET['search_type'];
    }
    ?>

    <!-- if category and loc then show category and show in header_search otherwise show search type --->

    <div class="search_bg text-center d-none" id="search_header"
         style="background-image:linear-gradient(#00000070 , #00000091) , url('<?php echo asset('userassets/images/bg-img3.jpg'); ?>')">
        <h2><?= $location_for_header . ' ' . $category_for_header . ' ' . ucfirst($search_type) ?></h2>
    </div>


    <div class="text-center d-none search_breacrumbs" id="search_header_breadcrumbs">
        <span><span><?= ucfirst($search_type) ?></span> / <span><?= $category_for_header ?></span> / <span><?= $location_for_header ?></span> / <?= $location_for_header . ', ' . $category_for_header . ', ' . ucfirst($search_type) ?> </span>
    </div>
    <div class="container">
        <div class="d-block d-lg-flex row mt-3">
            <div class="col-lg-3 col-sm-12">
                <form name="search_filter" id="search_filter">
                    <div class="mobile_menu_overlay"></div>
                    <div class="search_menu_overlay"></div>

                    <div class="search_sidebar">

                        <input id="distance" name="distance" type="hidden" value="100">
                        <div class="section">
                            <div class="search_field">
                                <i class="s_icon icon_search "></i>
                                <i class="s_icon icon_current_location" onclick="geolocate()"
                                   title="Get Current Location"></i>
                                <input name="location" id="autocomplete_loc" placeholder="Search By Location"
                                       onFocus="geolocate()" type="text" class="form-control"
                                       value="<?= isset($_GET['location']) && $_GET['location'] ? $_GET['location'] : '' ?>">
                            </div>
                        </div> <!-- section-->
                        <div class="section for_musicians for_gigs for_groups for_studios for_accompanists">
                            <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse9">
                                <h4>Categories</h4>
                            </div>
                            <div id="categories_on_left_bar"></div>
                        </div>
                        <span class="search_side_close"></span>

                        <div class="search_side_header d-flex align-items-center mt-2" id="search_toggle"
                             style="cursor: pointer;">
                            <div>
                                <h5 class="mb-0">Filter By</h5>
                            </div>
                            <div class="ml-auto">
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>

                        <div class="slideup_search_wrap" style="display: none">

                            <div class="section">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="radius"
                                                   id="radius" value="radius search">
                                            <label class="custom-control-label" for="radius">Radius Search</label>
                                        </div>
                                    </div><!-- col 3 -->
                                </div> <!-- row -->
                            </div> <!-- section-->
                            <div class="section">
                                <div class="search_field range-slider" id="distance-range-slider">
                                    <input id="distance-range" type="text" class="js-range-slider"
                                           style="display: none;">
                                </div>
                            </div> <!-- section-->
                            <div class="section">
                                <div class="toggle_head" style="cursor:unset;">
                                    <h4>Search Type</h4>
                                    <!-- <span class="icon"></span> -->
                                </div>
                                <div id="collapse1">
                                    <div class="toggle_body">
                                        <div class="custom-control custom-radio">
                                            <input onchange="resetTriger()" type="radio" class="custom-control-input"
                                                   name="search_type" id="search_type_musician" value="musicians"
                                                   is_search_type_input="1" checked="">
                                            <label class="custom-control-label"
                                                   for="search_type_musician">Musicians</label><br>
                                        </div>
                                        <!--                                            <div class="custom-control custom-radio">
                                                                                            <input type="radio" class="custom-control-input" name="search_type" id="search_type_gigs" value="gigs" is_search_type_input="1">
                                                                                            <label class="custom-control-label" for="search_type_gigs">Gigs</label>
                                                                                        </div>-->
                                        <div class="custom-control custom-radio">
                                            <input onchange="resetTriger()" type="radio" class="custom-control-input"
                                                   name="search_type" id="search_type_groups" value="groups"
                                                   is_search_type_input="1">
                                            <label class="custom-control-label" for="search_type_groups">Event
                                                Services</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input onchange="resetTriger()" type="radio" class="custom-control-input"
                                                   name="search_type" id="search_type_studio" value="teaching_studios"
                                                   is_search_type_input="1">
                                            <label class="custom-control-label" for="search_type_studio">Teaching
                                                Studios</label>
                                        </div>
                                        <div class="custom-control custom-radio">
                                            <input onchange="resetTriger()" type="radio" class="custom-control-input"
                                                   name="search_type" id="search_type_accompanists" value="accompanists"
                                                   is_search_type_input="1">
                                            <label class="custom-control-label" for="search_type_accompanists">Accompanists</label>
                                        </div>
                                    </div> <!-- toggle_body -->
                                </div>
                            </div> <!-- section -->

                            <div class="section">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse2">
                                    <h4>Gender</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="gender[]"
                                                       id="male" value="male">
                                                <label class="custom-control-label" for="male">Male</label>
                                            </div>
                                        </div><!-- col 3 -->
                                        <div class="col-md-4">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="gender[]"
                                                       id="female" value="female">
                                                <label class="custom-control-label" for="female">Female</label>
                                            </div>
                                        </div> <!-- col 3 -->
                                    </div> <!-- row -->
                                </div> <!-- toggle_body -->
                            </div> <!-- section-->
                            <div class="section">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse3">
                                    <h4>Availability</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input musician_input" id="gigs"
                                               name="availability" value="Has a gig profile?">
                                        <label class="custom-control-label" for="gigs">Only see that which is available
                                            for booking?</label>
                                    </div>
                                </div>
                            </div> <!-- section-->
                            <?php if (Auth::guard('user')->check()) { ?>
                                <div class="section for_musicians">
                                    <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse4">
                                        <h4>Followers</h4>
                                    </div>
                                    <div class="toggle_body">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input musician_input"
                                                   id="get_followings" name="get_followings" value="Get followings">
                                            <label class="custom-control-label" for="get_followings">Only see who you
                                                have followed?</label>
                                        </div>
                                    </div>
                                </div> <!-- section-->
                            <?php } ?>

                            <div class="section for_studios">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse6">
                                    <h4>Accepting Students</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input studio_input"
                                               id="accepting_students" name="is_accepting_students"
                                               value="Studios that are accepting students">
                                        <label class="custom-control-label" for="accepting_students">Only see which are
                                            accepting students?</label>
                                    </div>
                                </div>
                            </div> <!-- section-->
                            <div class="section for_studios">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse7">
                                    <h4>Lesson Type</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input studio_input"
                                                       name="lesson_type[]" id="in_home" value="in_home">
                                                <label class="custom-control-label" for="in_home">In-Home</label>
                                            </div>
                                        </div><!-- col 3 -->
                                        <div class="col-md-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input studio_input"
                                                       name="lesson_type[]" id="in_studio" value="in_studio">
                                                <label class="custom-control-label" for="in_studio">In-Studio</label>
                                            </div>
                                        </div> <!-- col 3 -->
                                    </div> <!-- row -->
                                </div>
                            </div> <!-- section-->
                            <div class="section for_studios">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse8">
                                    <h4>Levels Taught</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="search_box">
                                        <?php
                                        if (isset($levels_taught) && !empty($levels_taught)) {
                                            foreach ($levels_taught as $key => $value) {
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox"
                                                           class="custom-control-input side_filter studio_input"
                                                           id="sp_1_<?= $value ?>" name="levels_taught[]"
                                                           value="<?= $value ?>" data_id="<?= $value ?>">
                                                    <label class="custom-control-label"
                                                           for="sp_1_<?= $value ?>"> <?= $value ?> </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div class="section for_studios for_gigs for_accompanists">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse5">
                                    <h4>Price</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="price_search" id="price_search" value="price search">
                                                    <label class="custom-control-label" for="price_search">Price (per
                                                        hour)</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="section">
                                        <div class="search_field range-slider" id="price-range-slider">
                                            <input id="price-range" type="text" class="js-range-slider"
                                                   style="display: none;">
                                            <input id="price" name="price" type="hidden" value="100">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="section for_musicians for_gigs for_studios">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse10">
                                    <h4>Genre</h4>
                                </div>

                                <div class="toggle_body">
                                    <div class="search_box">
                                        <?php
                                        if (isset($genres) && !empty($genres)) {
                                            foreach ($genres as $key => $value) {
                                                ?>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input side_filter"
                                                           id="sp_1_<?= $value ?>" name="genre[]" value="<?= $value ?>"
                                                           data_id="<?= $value ?>">
                                                    <label class="custom-control-label"
                                                           for="sp_1_<?= $value ?>"> <?= $value ?> </label>
                                                </div>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div> <!-- section-->

                            <div class="section for_musicians for_studios for_accompanists">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse11">
                                    <h4>Language</h4>
                                </div>
                                <div class="toggle_body">
                                    <select id="language_partial_query_dropdown" name="languare[]" multiple="multiple"
                                            required="" class="select2_for_language" style="width: 100%">
                                        <option></option>
                                        <?php
                                        if (isset($languages) && !empty($languages)) {
                                            foreach ($languages as $key => $value) {
                                                ?>
                                                <option value="<?= $value['name'] ?>"><?= $value['name'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> <!-- section-->

                            <div class="section for_musicians">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse12">
                                    <h4>Unions</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="affiliation[]"
                                                       id="aff_1" value="union">
                                                <label class="custom-control-label" for="aff_1"> Union </label>
                                            </div>
                                        </div> <!-- col-6 -->
                                        <div class="col-sm-6">
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" name="affiliation[]"
                                                       id="af_2" value="non-union">
                                                <label class="custom-control-label" for="af_2"> Non-Union </label>
                                            </div>
                                        </div> <!-- col-6 -->
                                    </div> <!-- row -->
                                </div>
                            </div> <!-- section-->

                            <div class="section for_musicians">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse13">
                                    <h4>Affiliations</h4>
                                </div>
                                <div class="toggle_body">
                                    <select id="select2_select_affiliation" name="union_value[]" multiple="multiple" required=""
                                            class="select2_select_affiliations" multiple="" style="width: 100%">
                                        <option></option>
                                        <?php
                                        if (isset($union) && count($union) > 0) {
                                            foreach ($union as $key => $typeval) {
                                                ?>
                                                <option value="<?= $typeval['title'] ?>"><?= $typeval['title'] ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div> <!-- section-->

                            <div class="section for_musicians for_studios for_accompanists">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse14">
                                    <h4>Education</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="search_field">
                                        <i class="s_icon icon_search"></i>
                                        <input autocomplete="off" type="text" class="form-control" name="degree"
                                               placeholder="Search By Degree"/>
                                    </div>
                                    <div class="search_field">
                                        <i class="s_icon icon_search"></i>
                                        <input autocomplete="off" type="text" class="form-control" name="institute"
                                               placeholder="Search By College/University"/>
                                    </div>
                                </div>
                            </div> <!-- section-->

                            <div class="section for_musicians for_studios for_accompanists">
                                <div class="toggle_head collapsed" data-toggle="collapse" data-target="#collapse15">
                                    <h4>Experience</h4>
                                </div>
                                <div class="toggle_body">
                                    <div class="search_field">
                                        <i class="s_icon icon_search"></i>
                                        <input autocomplete="off" type="text" class="form-control" name="job_title"
                                               placeholder="Search By Job Title"/>
                                    </div>
                                    <div class="search_field">
                                        <i class="s_icon icon_search"></i>
                                        <input autocomplete="off" type="text" class="form-control" name="company_name"
                                               placeholder="Search By Company Name"/>
                                    </div>
                                </div>
                            </div> <!-- section-->


                        </div> <!-- slideup search wrap -->
                        <input class="btn btn_aqua btn-round btn-block mt-3" type="button" id="save_form"
                               onclick="searchForm()" value="Apply Filters">

                        <button type="button" id="btn_clear_all_filters" class="btn btn-round btn-block">
                            <i class="fas fa-times mr-1"></i> Clear all Filters
                        </button>
                    </div> <!-- search sidebar -->

                </form>
            </div> <!-- col -->
            <div class="col-lg-9 col-md-12">
                <div id="overlay">Loading...</div>
                <div class="records_founds">
                    <span class="records_founds_total_span"><strong
                                class="records_founds_total"></strong> items found</span> <span
                            class="mobile_filter_btn"> <i class="icon_filter"></i>Filters</span>
                </div>
                <ul class="un_style search_selected_options" id="search_filter_tags" style="display: none">
                    <li>Filter Applied:</li>
                    <!--                            <li id="search-clear-all-btn"><a href="javascript:void(0)" id="reset" class="text-underline">Clear All</a></li>-->
                </ul> <!-- search tags -->
                <!-- Popular Searches -->

                <div class="searches-category d-none mt-3 mb-4 text-center">
                    <h6><strong>Popular Searches:</strong></h6>
                    <ul class="d-flex align-items-center mb-0">
                        <?php foreach ($popular_searches as $popularSearch) { ?>
                            <li>
                                <a href="<?= asset("search?cat=" . $popularSearch->id . "&search_type=" . $search_type) ?>"><?= $popularSearch->title ?></a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>


                <div class="" id="musician_data_list">
                </div>
                <div id="pagination">
                    <div class="load_more" id="finder_loader">
                        <img id="post_loader" src="<?= asset('userassets/images/loader.gif') ?>" alt="loading.."
                             class="m_loader">
                    </div>
                </div>
            </div> <!-- col -->
        </div> <!-- row -->
    </div> <!-- container -->
</div>
<?php include resource_path('views/includes/footer.php'); ?>
<script>
    var category_for_header = '<?= $category_for_header ?>';
    var location_for_header = '<?= $location_for_header ?>';
    var search_type = '<?= $search_type ?>';
    //convert first character to uppercase
    search_type = search_type.charAt(0).toUpperCase() + search_type.slice(1);

    function checkSearchAfterSubmission() {

        //initail hide popular search

        if ((category_for_header == '') && (search_type != 'accompanists')) {
            $('.searches-category').removeClass('d-none');
}

        if ((category_for_header != '') && (location_for_header != '')) {

            $('#search_header').html('<h2>' + location_for_header + '. ' + category_for_header + ', ' + search_type + '</h2>');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + '</span> / <span>' + category_for_header + '</span> / <span>' + location_for_header + '</span> / ' + location_for_header + '. ' + category_for_header + ', ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
            $('#search_header').removeClass('d-none');
        } else if ((location_for_header != '') && (category_for_header == '')) {

            $('#search_header').html('<h2>' + location_for_header + '. ' + search_type + '</h2>');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + '</span> / <span>' + location_for_header + '</span> / ' + location_for_header + ', ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
            $('#search_header').removeClass('d-none');
        } else if ((category_for_header != '') && (location_for_header == '') && (search_type!='')) {
            // alert('3');
            $('#search_header').html('<h2>' + category_for_header + ', ' + search_type + '</h2>');
            $('#search_header').removeClass('d-none');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + '</span> / <span>' + category_for_header + '</span> / ' + category_for_header + ' / ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
        } else if ((search_type != '')) {


            $('#search_header').html('<h2>' + search_type + '</h2>');
            $('#search_header').removeClass('d-none');

//              $('#search_header_breadcrumbs').html('<span><span>' + search_type + '</span> / ' + search_type + '</span>');
//                $('#search_header_breadcrumbs').removeClass('d-none');

        } else if ((category_for_header != '') && (location_for_header == '') && (search_type == '')) {

            $('#search_header').html('<h2>' + category_for_header + '</h2>');
            $('#search_header').removeClass('d-none');
            $('#search_header_breadcrumbs').html('<span><span>' + category_for_header + '</span> / ' + category_for_header + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');

        }
    }

    //call to method
    checkSearchAfterSubmission();

    //show hide breadcrumbs
    if ((category_for_header != '') && (location_for_header != '')) {
        $('#search_header_breadcrumbs').removeClass('d-none');

    }

    $('#search_submit_button').click(function (e) {
        e.preventDefault();
        searchForm();
    });

    $('#btn_clear_all_filters').click(function () {

        $('#search_type_musician').trigger('click');
        $('#search_filter').trigger("reset");
        $('#autocomplete_loc').val('');
        $("#search_category_type").val('').trigger("change");
        $("#language_partial_query_dropdown").val('').trigger("change");
        $("#select2_select_affiliation").val('').trigger("change");
        localStorage.clear()

        $('.range-slider').hide();

        searchForm();
    });

    var toggle_increment = 1;
    $('#search_toggle').click(function (e) {

        $('.slideup_search_wrap').slideToggle();
        var elem = $(this);
        if (toggle_increment === 1) {
            elem.find('.fa').attr('class', 'fa fa-chevron-up');
            toggle_increment = 0;
            return;
        }
        if (toggle_increment === 0) {
            elem.find('.fa').attr('class', 'fa fa-chevron-down');
            toggle_increment = 1;
            return;
        }
    });

    var global_lat = global_lng = '';

    var $distancerange = $("#distance-range");
    $distancerange.ionRangeSlider({
        from: 100,
        min: 0,
        max: 100,
        step: 5,
        grid: true,
        postfix: " mi",
        onFinish: function (data) {
            $('#distance').val(data.from);
            $("#distance").trigger("change");
        }
    });

    distancerangeinstance = $distancerange.data("ionRangeSlider");

    $("#price-range").ionRangeSlider({
        from: 100,
        min: 0,
        max: 200,
        step: 10,
        grid: true,
        prefix: "$",
        max_postfix: "+",
        onFinish: function (data) {
            $('#price').val(data.from);
            $("#price").trigger("change");
        }
    });

</script>
<script>
    function searchForm() {
        $('.records_founds_total').html(0);

        ajaxcall = 1;
        //                    var ref = this;
        //                    e.preventDefault();
        //                    if (e.target.type == 'text' || e.target.type == 'number') {
        //                        $('body').click(function (evt) {
        //                            if (evt.target.type == 'radio' || evt.target.type == 'checkbox') {
        //                                $(this).off(evt);
        //                                return false;
        //                            }
        //                        });
        //                    }

        //                    $('#search_filter_tags').show();
        //                    var Select_opt = $(this).val();
        //                    var Select_opt_id = $(this).attr('id');
        //                    if (Select_opt_id == $('#distance-range').attr('id')) {
        //                        return false;
        //                    }

        checkAttr = $(this).attr("is_search_type_input");
        if (checkAttr === 1) {
            if ($(this).is(':checked')) {
                $("#search-clear-all-btn").prepend('<li><span class="search_selection" data-p-id="' + Select_opt_id + '">' + Select_opt + '<span class="selection_remove fas fa-times"></span></span></li>');
            } else {
                $('#search_filter_tags').find('[data-p-id="' + Select_opt_id + '"]').remove();
            }
        } else {
            $('#musician_data_list').empty();

            var value_of_search_radio = $('input[name=search_type]:checked').val();


            $('#search_filter_tags').hide();
            $('#search_filter_tags').find('.search_selection').parent().remove();
            //
            if (value_of_search_radio == 'musicians') {
                $("#search_type_musician").prop("checked", true);
            } else if (value_of_search_radio == 'gigs') {
                $("#search_type_gigs").prop("checked", true);
            } else if (value_of_search_radio == 'groups') {
                $("#search_type_groups").prop("checked", true);
            } else if (value_of_search_radio == 'teaching_studios') {
                $("#search_type_studio").prop("checked", true);

            } else if (value_of_search_radio == 'accompanists') {
                $("#search_type_accompanists").prop("checked", true);
            }
        }

        //                    lat = $("input[name^='lat']").val();
        //                    lng = $("input[name^='lng']").val();

        search = $('#header_filter').find('input[name="search"]').val();
        search_type = $("input[name^='search_type']:checked").val();
        //convert first character to uppercase
        search_type = search_type.charAt(0).toUpperCase() + search_type.slice(1);

        // loc = $("input[name^='location']").val();
        loc = $("#autocomplete_loc").val();
        distance = $("input[name^='distance']").val();
        radius = '';
        if ($("input[name^='radius']").is(":checked")) {
            radius = $("input[name^='radius']").val();
        }
        lesson_type = $("input[name^='lesson_type']:checked").map(function (idx, ele) {
            return $(ele).val();
        }).get();

        levels_taught = $("input[name^='levels_taught']:checked").map(function (idx, ele) {
            return $(ele).val();
        }).get();

        accepting_students = $("input[name^='is_accepting_students']:checked").val();

        price = $("input[name='price']").val();
        price_search = '';
        if ($("input[name='price_search']").is(":checked")) {
            price_search = $("input[name='price_search']").val();
        }

//                specilaization = $("input[name^='specilaization']:checked").map(function (idx, ele) {
//                    return $(ele).attr('data_id');
//                }).get();
        specilaization = $("option[name^='specilaization']:selected").map(function (idx, ele) {
            return $(ele).attr('data_id');
        }).get();

        specilaization_value = $("option[name^='specilaization']:selected").map(function (idx, ele) {
            return $(ele).attr('value');
        }).get();
        if(specilaization_value == '')
        {
            localStorage.clear();
        }

        genre = $("input[name^='genre']:checked").map(function (idx, ele) {
            return $(ele).val();
        }).get();

        union = $("select[name^='union_value']").val();

        affiliation = $("input[name^='affiliation']:checked").map(function (idx, ele) {
            return $(ele).val();
        }).get();

        gender = $("input[name^='gender']:checked").map(function (idx, ele) {
            return $(ele).val();
        }).get();

        availability = $("input[name^='availability']:checked").val();

        get_followings = $("input[name^='get_followings']:checked").val();

        languare = $('#language_partial_query_dropdown').val();

        degree = $("input[name^='degree']").val();
        institute = $("input[name^='institute']").val();
        education_start_year = $("input[name^='education_start_year']").val();
        education_end_year = $("input[name^='education_end_year']").val();

        job_title = $("input[name^='job_title']").val();
        company_name = $("input[name^='company_name']").val();
        experience_start_year = $("input[name^='experience_start_year']").val();
        experience_end_year = $("input[name^='experience_end_year']").val();

        if ($('.search_selection').length == 0) {
            $('#search_filter_tags').hide();
        }

        //second

        //get selected parameters
        let number_of_categories_selected = $('#search_category_type option:selected').length;
        // console.log(number_of_categories_selected);
        category_for_header = $("#search_category_type").val();
        location_for_header = loc;

        //show popular search
        if ((category_for_header == '') && (search_type != 'accompanists')) {
            $('.searches-category').removeClass('d-none');
        } else {
            $('.searches-category').addClass('d-none');
        }
        //set header and breadcrumbs


        if ((category_for_header != '') && (location_for_header != '')) {

            $('#search_header').html('<h2>' + location_for_header + '. ' + category_for_header[0] + ', ' + search_type + '</h2>');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + '</span> / <span>' + category_for_header[0] + ' </span> / <span>' + location_for_header + '</span> / ' + location_for_header + ' / ' + category_for_header[0] + ' / ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
            $('#search_header').removeClass('d-none');
        } else if ((category_for_header == '') && (location_for_header != '')) {
            $('#search_header').html('<h2>' + location_for_header + '. ' + search_type + '</h2>');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + ' </span> / <span>' + location_for_header + '</span> / ' + location_for_header + '. ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
            $('#search_header').removeClass('d-none');
        } else if ((category_for_header != '') && (location_for_header == '')) {

            $('#search_header').html('<h2>' + category_for_header[0] + ', ' + search_type + '</h2>');
            $('#search_header_breadcrumbs').html('<span><span>' + search_type + ' </span> / <span>' + category_for_header[0] + '</span> / ' + category_for_header[0] + ' / ' + search_type + '</span>');
            $('#search_header_breadcrumbs').removeClass('d-none');
            $('#search_header').removeClass('d-none');
        } else if ((category_for_header == '') && (location_for_header == '') && (search_type != '')) {
            $('#search_header').html('<h2>' + search_type + '</h2>');
            $('#search_header').removeClass('d-none');
//                   $('#search_header_breadcrumbs').html('<span><span>' + search_type +' </span> / ' + search_type + '</span>');
            $('#search_header_breadcrumbs').addClass('d-none');

        }

        search_type = search_type.charAt(0).toLowerCase() + search_type.slice(1);

        var data = JSON.stringify({
            skip: skip,
            take: take,
            isScroll: 0,
            search_type: search_type,
            lesson_type: lesson_type,
            levels_taught: levels_taught,
            accepting_students: accepting_students,
            price: price,
            specilaization: specilaization,
            specilaization_value:specilaization_value,
            genre: genre,
            union: union,
            affiliation: affiliation,
            availability: availability,
            languare: languare,
            loc: loc,
            //                        lat: lat,
            //                        lng: lng,
            distance: distance,
            radius: radius,
            price_search: price_search,
            category: category,
            search: search,
            degree: degree,
            institute: institute,
            education_start_year: education_start_year,
            education_end_year: education_end_year,
            job_title: job_title,
            company_name: company_name,
            experience_start_year: experience_start_year,
            experience_end_year: experience_end_year,
            gender: gender,
            get_followings: get_followings
        });
        //                    alert('a')
        if (ajaxcall === 1) {
            //                         alert('b')
            ajaxcall = 0;

            $('#musician_data_list').empty();
            load_actions(data);
        }
    }

    var ajaxcall = 1;
    var is_checkbox_or_radio_call = 0;

    var isScroll = 0;
    win = $(window), count = 0, appended_post_count = 0, skip = 0,
        take = 12, specilaization = [], union = [], affiliation = [], genre = []
    availability = '', loc = '', languare = [], gender = [], lesson_type = [], levels_taught = [], accepting_students = '', price = '',
        search = '', category = '', get_followings = '', lat = '', lng = '', distance = '', radius = '', price_search = '', search_type = '',
        degree = '', institute = '', education_start_year = '', education_end_year = '';
    job_title = '', company_name = '', experience_start_year = '', experience_end_year = '';

    function populateCategories() {
        var type = $('input[name=search_type]:checked').val();
        $.ajax({
            url: "<?php echo asset('populate_categories_on_search_page') ?>",
            type: "GET",
            dataType: "json",
            async: false,
            data: {
                'type': type,
                'cat_id': '<?= isset($_GET['cat']) && $_GET['cat'] ? $_GET['cat'] : '' ?>'
            },
            success: function (data) {

                $('#categories_on_left_bar').html(data.html);
            }
        });
    }

    $(document).ready(function () {
        populateCategories();

        $('.for_musicians').show();
        search = $('#header_filter').find('input[name="search"]').val();
        search_type_from_url = '<?= isset($_GET['search_type']) ? $_GET['search_type'] : 'musicians' ?>';

        <?php if (isset($_GET['cat']) && $_GET['cat']) { ?>
        specilaization.push('<?= $_GET['cat'] ?>');
        <?php } ?>

        // loc = $("input[name^='location']").val();
        loc = $("#autocomplete_loc").val();

        <?php if (isset($_GET['location']) && $_GET['location']) { ?>
        loc = "<?= $_GET['location'] ?>";
        <?php } ?>
        $("input[name^='search_type'][value^='" + search_type_from_url + "']").prop("checked", true);
        $("input[name^='specilaization'][id='sp_1_" + '<?= isset($_GET['cat']) && $_GET['cat'] ? $_GET['cat'] : '' ?>' + "']").prop("checked", true);

        $('.for_musicians, .for_gigs, .for_groups, .for_studios, .for_accompanists').hide();
        if (search_type_from_url == 'musicians') {
            $('.for_musicians').show();
            distancerangeinstance.update({
                from: 100,
                min: 0,
                max: 100,
                step: 5,
            });
        } else if (search_type_from_url == 'gigs') {
            $('.for_gigs').show();
            distancerangeinstance.update({
                from: 100,
                min: 0,
                max: 100,
                step: 5,
            });
        } else if (search_type_from_url == 'groups') {
            $('.for_groups').show();
            distancerangeinstance.update({
                from: 120,
                min: 0,
                max: 200,
                step: 5,
            });
        } else if (search_type_from_url == 'teaching_studios') {
            $('.for_studios').show();
            distancerangeinstance.update({
                from: 15,
                min: 0,
                max: 60,
                step: 5
            });
        } else if (search_type_from_url == 'accompanists') {
            $('.for_accompanists').show();
            distancerangeinstance.update({
                from: 30,
                min: 0,
                max: 200,
                step: 5,
            });
        }

        search_type = $("input[name^='search_type']:checked").val();
        //                lat = $("input[name^='lat']").val();
        //                lng = $("input[name^='lng']").val();
        distance = $("input[name^='distance']").val();

        $('body').on('click', '.selection_remove', function () {
            var owner_id = $(this).parent().attr('data-p-id');
            $('#' + owner_id).trigger('click');
        });

        //                $('body').on('click', '#reset', function () {
        //                    $('.range-slider').hide();
        //                    $('#search_filter_tags').hide();
        //                    $('#search_filter_tags').find('.search_selection').parent().remove();
        //                    $('#search_filter').trigger("reset");
        //                    $("#search_type_musician").prop("checked", true);
        //                    search_type = $("input[name^='search_type']:checked").val();
        //                    distance = $("input[name^='distance']").val();
        //                    var data = JSON.stringify({
        //                        skip: 0,
        //                        take: 12,
        //                        isScroll: 0,
        //                        search: search,
        //                        search_type: search_type,
        //                        distance: distance,
        //                    });
        //                    $('#musician_data_list').empty();
        //                    load_actions(data);
        //                });

        //                $('body').on('change', '#search_filter :input', function (e) {
        //$('#save_form').on('click', function (e) {

        //                });

        /*
         *Lasy load data
         */
        var data = JSON.stringify({
            skip: skip,
            take: take,
            isScroll: 0,
            search_type: search_type,
            lesson_type: lesson_type,
            levels_taught: levels_taught,
            accepting_students: accepting_students,
            price: price,
            specilaization: specilaization,
            genre: genre,
            union: union,
            affiliation: affiliation,
            availability: availability,
            languare: languare,
            loc: loc,
            //                    lat: lat,
            //                    lng: lng,
            distance: distance,
            radius: radius,
            price_search: price_search,
            category: category,
            search: search,
            degree: degree,
            institute: institute,
            education_start_year: education_start_year,
            education_end_year: education_end_year,
            job_title: job_title,
            company_name: company_name,
            experience_start_year: experience_start_year,
            experience_end_year: experience_end_year,
            gender: gender,
            get_followings: get_followings
        });
        load_actions(data);


        win.on('scroll', function () {
            var docheight = parseInt($(document).height());
            var winheight = parseInt(win.height());
            var differnce = (docheight - winheight) - win.scrollTop();
            isScroll = 1;
            if (differnce < 100) {
                if (ajaxcall === 1) {
                    ajaxcall = 0;
                    var skip = (parseInt(count) * 12) + parseInt(appended_post_count);

                    $('#finder_loader').show();
                    var data = JSON.stringify({
                        skip: skip,
                        take: take,
                        isScroll: 0,
                        search_type: search_type,
                        lesson_type: lesson_type,
                        levels_taught: levels_taught,
                        accepting_students: accepting_students,
                        price: price,
                        specilaization: specilaization,
                        genre: genre,
                        union: union,
                        affiliation: affiliation,
                        availability: availability,
                        languare: languare,
                        loc: loc,
                        //                                lat: lat,
                        //                                lng: lng,
                        distance: distance,
                        radius: radius,
                        price_search: price_search,
                        category: category,
                        search: search,
                        degree: degree,
                        institute: institute,
                        education_start_year: education_start_year,
                        education_end_year: education_end_year,
                        job_title: job_title,
                        company_name: company_name,
                        experience_start_year: experience_start_year,
                        experience_end_year: experience_end_year,
                        gender: gender,
                        get_followings: get_followings
                    });
                    load_actions(data);
                }
            }
        });
    });

    $('body').on('submit', '#header_filter', function (e) {
        e.preventDefault();
        element = $(this);
        initialUrl = window.history.pushState("", "", '?' + element.serialize());
        var currenturl = window.location.href;
        if (!initialUrl) {
            initialUrl = decodeURIComponent(currenturl);
        }
        var decodedUri2 = initialUrl.replace("&manufacturer[]=", "/").replace("&page=", "/").replace("&sort=", "/").replace("&order=", "/");
        history.pushState("", "", decodedUri2);

        category = element.find('select[name="cat"]').val();
        search = element.find('input[name="search"]').val();
        var data = JSON.stringify({
            skip: skip,
            take: take,
            isScroll: 0,
            search_type: search_type,
            lesson_type: lesson_type,
            levels_taught: levels_taught,
            accepting_students: accepting_students,
            price: price,
            specilaization: specilaization,
            genre: genre,
            union: union,
            affiliation: affiliation,
            availability: availability,
            languare: languare,
            loc: loc,
            //                    lat: lat,
            //                    lng: lng,
            distance: distance,
            radius: radius,
            price_search: price_search,
            search: search,
            degree: degree,
            institute: institute,
            education_start_year: education_start_year,
            education_end_year: education_end_year,
            job_title: job_title,
            company_name: company_name,
            experience_start_year: experience_start_year,
            experience_end_year: experience_end_year,
            category: category,
            gender: gender,
            get_followings: get_followings
        });
        $('#musician_data_list').empty();
        load_actions(data);

    });

    function load_actions(data) {

        //JSON.parse to convert string to object because i need to get filter value and assign to query string
        var filter_data =JSON.parse(data);
        if(filter_data.distance != 100)
        {
            if(filter_data.loc == '')
            {
                alert('Please add location for Radius Search');
                return false;
            }
        }

        if ((typeof filter_data.specilaization_value != 'undefined') && (filter_data.specilaization_value != ''))
        {

            localStorage.setItem("user_selected_categories", JSON.stringify(filter_data.specilaization_value));
            console.log('inside set');

        }

        //get data from query string
        if (history.pushState) {
            var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?search=&search_type='+filter_data.search_type+'&cat=&location='+filter_data.loc;
            window.history.pushState({path:newurl},'',newurl);
        }
        //                alert('asdasd')

        ajaxcall = 0;
        $.ajax({
            url: "<?php echo asset('get_musician') ?>",
            type: "GET",
            dataType: "json",
            data: {
                'filter': data
            },

            beforeSend: function () {
                $('#overlay').show();
            },
            success: function (data) {
                $('#musician_data_list').append(data.html);
                $('#loader').hide();

                if (data.total) {
                    ajaxcall = 1;
                    $('.records_founds_total_span').show();
                    let records_found_total = $('.records_founds_total').html();
                    if (records_found_total == '') {
                        records_found_total = 0;
                    }
                    $('.records_founds_total').html(parseInt(records_found_total) + data.total);
                    var a = parseInt(1);
                    var b = parseInt(count);
                    count = b + a;
                    $('#nomoreposts').remove();
                } else {
                    ajaxcall = 0;
                    if ($('#musician_data_list').is(':empty')) {
                        $('#loader').hide();
                        $('.records_founds_total_span').hide();
                        noposts = ' <div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No record found</div></div> ';
                        $('#nomoreposts').remove();
                        $('#musician_data_list').after(noposts);
                    } else {
                        //                                ajaxcall = 0;
                        $('#loader').hide();
                        noposts = '<div class="loader_center text-center" id="nomoreposts"><div class="posts_end">No more record to show</div></div> ';
                        $('#nomoreposts').remove();
                        $('#musician_data_list').after(noposts);
                    }
                }

            },
            complete: function () {
                if(localStorage.getItem(('user_selected_categories')) != null){
                    var result = JSON.parse(localStorage.getItem("user_selected_categories"));
                    $('#search_category_type').val(result);
                    $('#search_category_type').trigger('change');
                }

                setTimeout(function () {
                    $('#overlay').hide();
                    $('#finder_loader').hide();
                }, 200);

            }
        });
    }

    $('#radius').change(function () {
        if ($(this).is(":checked")) {
            $('#distance-range-slider').show();
        } else {
            $('#distance-range-slider').hide();
        }
    });

    $('#price_search').change(function () {
        if ($(this).is(":checked")) {
            $('#price-range-slider').show();
        } else {
            $('#price-range-slider').hide();
        }
    });

    $('input[name=search_type]').change(function () {
        populateCategories();
        var val = $('input[name=search_type]:checked').val();
        $('.for_musicians, .for_gigs, .for_groups, .for_studios, .for_accompanists').hide();
        if (val == 'musicians') {
            $('.for_musicians').show();
            distancerangeinstance.update({
                from: 100,
                min: 0,
                max: 100,
                step: 5,
            });
        } else if (val == 'gigs') {
            $('.for_gigs').show();
            distancerangeinstance.update({
                from: 100,
                min: 0,
                max: 100,
                step: 5,
            });
        } else if (val == 'groups') {
            $('.for_groups').show();
            distancerangeinstance.update({
                from: 120,
                min: 0,
                max: 200,
                step: 5,
            });
        } else if (val == 'teaching_studios') {
            $('.for_studios').show();
            distancerangeinstance.update({
                from: 15,
                min: 0,
                max: 60,
                step: 5
            });
        } else if (val == 'accompanists') {
            $('.for_accompanists').show();
            distancerangeinstance.update({
                from: 30,
                min: 0,
                max: 200,
                step: 5,
            });
        }
    });

    function resetTriger() {
        var value_of_search_radio = $('input[name=search_type]:checked').val();
        $('#search_filter').trigger("reset");
        $('.range-slider').hide();
        if (value_of_search_radio == 'musicians')
            $("#search_type_musician").prop("checked", true);
        else if (value_of_search_radio == 'gigs')
            $("#search_type_gigs").prop("checked", true);
        else if (value_of_search_radio == 'groups')
            $("#search_type_groups").prop("checked", true);
        else if (value_of_search_radio == 'teaching_studios')
            $("#search_type_studio").prop("checked", true);
        else if (value_of_search_radio == 'accompanists')
            $("#search_type_accompanists").prop("checked", true);
    }
    <?php if ($current_user) { ?>

    function sendMessageFromSearchServices(otherid, type, type_id) {

        var message = $('#message_' + type + type_id).val();
        if (message) {
            var data = new FormData();
            data.append('message', message);
            data.append('receiver_id', otherid);
            data.append('_token', '<?= csrf_token() ?>');
            data.append('message_type', type);
            data.append('type_id', type_id);
            $('#message' + otherid).val('');
            if (/\S/.test(message)) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_message'); ?>",
                    data: data,
                    processData: false,
                    contentType: false,
                    success: function (data) {
                        $('#modal_search_messages' + type_id).modal('hide');
                        $('#showSuccess').html('Message Send Successfully !').fadeIn().fadeOut(5000);
                        result = JSON.parse(data);
                        $('.chat_box_wrapper').mCustomScrollbar("scrollTo", 'bottom');
                        socket.emit('message_get', {
                            "user_id": otherid,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": result.other_message,
                            "chat_id": result.chat_id,
                            "message": message,
                            "chat_type": type,
                            "chat_type_id": type_id,
                            "to_be_show": type
                        });
                        socket.emit('notification_get', {
                            "user_id": otherid,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' sent you message',
                            "url": '<?= asset('messages/') ?>',
                            "chat_id": result.chat_id,
                            "chat_type": type,
                            "chat_type_id": type_id,
                            "to_be_show": type

                        });
                    }
                });
            }
        }
    }
    <?php } ?>

</script>
<script>
    var placeSearch, autocomplete;


    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('autocomplete_loc')),
            {types: ['geocode']});

        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();


        // Get each component of the address from the place details
        // and fill the corresponding field on the form.
        for (var i = 0; i < place.address_components.length; i++) {
            var addressType = place.address_components[i].types[0];
        }
    }

    // Bias the autocomplete object to the user's geographical location,
    // as supplied by the browser's 'navigator.geolocation' object.
    function geolocate() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var geolocation = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                var circle = new google.maps.Circle({
                    center: geolocation,
                    radius: position.coords.accuracy
                });
                autocomplete.setBounds(circle.getBounds());
            });
        }
    }
</script>
</body>

</html>
