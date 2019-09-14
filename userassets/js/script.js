var target_click;
jQuery(document).ready(function () {
    send_comment = 1;
    $(document).ready(function () {
        sidebar = new StickySidebar('.stickyside', {
            topSpacing: 65,
            bottomSpacing: 40
        });
        sidebarright = new StickySidebar('.stickysideRight', {
            topSpacing: 65,
            bottomSpacing: 40
        });
    });
    if ($('.testimonial_carousel').length > 0) {
        $('.testimonial_carousel').owlCarousel({
            nav: true,
            margin: 10,
            items: 3,
            navText: ['<i class="fas fa-chevron-left"></i>', '<i class="fas fa-chevron-right"></i>'],
            responsive: {
                0: {
                    items: 1
                },
                576: {
                    items: 2
                },
                850: {
                    items: 3
                }
            }
        });
    }

    if ($('.post_popup .scroll_area').length > 0) {
        $('.post_popup .scroll_area').mCustomScrollbar();
    }
    if ($('.invite_group_scollarea').length > 0) {
        $('.invite_group_scollarea').mCustomScrollbar({
            mouseWheel: {
                scrollAmount: '100px'
            }
        });
    }
    if ($('.search-result-dropdown').length > 0) {
        $('.search-result-dropdown').mCustomScrollbar({
            mouseWheel: {
                scrollAmount: '100px'
            }
        });
    }
    //custom scrollBar for chat user list
    if ($('.chat_user_list').length > 0) {
        $(".chat_user_list").mCustomScrollbar();
    }
    //custom Horizontal scrollBar for online user
    if ($('.online-users-wrapper').length > 0) {
        $(".online-users-wrapper").mCustomScrollbar({
            axis: "x",
            moveDragger: true
        });
    }

    setTimeout(scrollTabs(), 3000);

    $('.selct2_select').select2({
        width: 'resolve',
        minimumResultsForSearch: Infinity
    });

    $('.selct2_select_homepage').select2({
        placeholder: "I\'m looking for",
        allowClear: true,
        disabled: false,
        width: 'resolve'
    });

    $('.select2_select_affiliations').select2({
        placeholder: "Search by Union Name",
        allowClear: true,
        width: 'resolve'
    });

    $('.select2_for_language').select2({
        placeholder: "Select a language",
        allowClear: true,
        width: 'resolve'
    });

    $('body').on('click', '.flash_close', function () {
        $(this).parents('.flash_message').fadeOut(200);
    });

    $('.navbar-toggler').click(function () {
        $(this).toggleClass('menuOpen');
    });

    $('.chat_listing .list_outer_wrap > a').click(function () {
        $('.message_box_wrap').addClass('show');
        $('.chat_usersidebar_wrap').addClass('hide');
    });

    $('.iconback').click(function () {
        $('.message_box_wrap').toggleClass('show');
        $('.chat_usersidebar_wrap').toggleClass('hide');
    });

    jQuery(window).scroll(function () {
        if (jQuery(this).scrollTop() > 10) {
            jQuery('.header_home_page.fixed').addClass('headerfixed');
        } else {
            if (jQuery('.header_home_page .navbar-collapse').hasClass('show')) {
                jQuery('.header_home_page').addClass('headerfixed');
            } else {
                jQuery('.header_home_page').removeClass('headerfixed');
            }
        }
    });

    /** Main Menu toggle and Close */
    jQuery('#toggle_timeline_menu').click(function () {
        jQuery('html').toggleClass('opensidemenu');
        jQuery('.mobile_menu_overlay').show();
    });
    jQuery('.icon_side_close').click(function () {
        jQuery('html').toggleClass('opensidemenu');
        jQuery('.mobile_menu_overlay').hide();
        jQuery('.menuOpen').removeClass('menuOpen');
    });
    jQuery('.mobile_menu_overlay').click(function () {
        jQuery('html').toggleClass('opensidemenu');
        jQuery('.mobile_menu_overlay').hide();
        jQuery('.menuOpen').removeClass('menuOpen');
    });

    /** Main Menu toggle */
    jQuery('.mobile_filter_btn').click(function () {
        jQuery('html').toggleClass('opensearch');
        jQuery('.search_menu_overlay').show();
    });
    jQuery('.search_menu_overlay').click(function () {
        jQuery('html').toggleClass('opensearch');
        jQuery(this).hide();
    });
    jQuery('.search_side_close').click(function () {
        jQuery('html').toggleClass('opensearch');
        jQuery('.search_menu_overlay').hide();
    });



    jQuery('.user_info').click(function () {
        jQuery('.user_info').toggleClass('show');
    });

    jQuery('.header_home_page .navbar-toggler').click(function () {
        jQuery('.header_home_page').addClass('headerfixed');
    });

    jQuery('.navbar-toggler').click(function () {
        jQuery('.menu_overlay').toggleClass('show');
    });

    jQuery('.cretate_event_btn').click(function () {
        jQuery('.create_event_form').show();
    });

    jQuery('.discard').click(function () {
        jQuery('.create_event_form').hide();
    });

    jQuery('.search_back').click(function () {
        jQuery('.header').toggleClass('show');
    });


    jQuery('.search_icon_mobile').click(function () {
        jQuery('.header').toggleClass('show');
    });

    jQuery('.create_post_option_btns span.btn').click(function () {
        jQuery(this).siblings('span.btn').removeClass('active');
        jQuery(this).addClass('active');
    });

    jQuery('.audio_media_btns .audio_play').click(function () {
        jQuery(this).toggleClass('pause');
    });


    function resize_users_list() {
        var win_height = jQuery(window).height();
        if (jQuery('.chat_user_list').length > 0) {
            var page_padding_bottom = parseInt(jQuery('.chat_page').css('paddingBottom'));
            var box_offset = parseInt(jQuery('.chat_list_wrap').offset().top);
            var box_header = parseInt(jQuery('.search_user').innerHeight());
            var box_height = parseInt(win_height - box_offset - box_header - page_padding_bottom - 5);
            jQuery('.chat_user_list').css({
                'height': box_height
            });
        }
    }

    //    resize_chat();
    resize_users_list();

    jQuery(window).resize(function () {
        resize_users_list();
    });
});

function scrollTabs() {
    var tabs = $('.public_profile_tabs');
    if (tabs.length > 1) {
        var tabWidth = tabs.innerWidth();
        var activeItem = $('.public_profile_tabs .active');
        var elOffsetLeft = activeItem.offset().left;
        var elWidth = activeItem.innerWidth();
        if ((elOffsetLeft + elWidth) > tabWidth) {
            tabs.scrollLeft(200);
        } else {
            tabs.scrollLeft(0);
        }
    }
}

// Browse Dropdown 
// $(document).ready(function () {
//     $('#browse-dropdown input:checked').parent('label').css('color', '#fff');

//     $('#browse-dropdown input').on('click', function () {

//         if ($(this).find('input:checked')) {
//             $(this).parent('label').css('color', '#fff');
//         } else {
//             $(this).parent('label').css('color', '#000');
//         }
//     });
// });