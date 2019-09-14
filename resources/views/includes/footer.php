<style>
    input.error {
        border: solid 1px red !important;
    }

    textarea.error {
        border: solid 1px red !important;
    }

    #create_event_f label.error {
        width: auto;
        display: none !important;
        color: red;
        font-size: 16px;
        float: right;
    }
</style>
<script src="<?php echo asset('userassets/js/croppie.js') ?>"></script>
<script src="<?php echo asset('userassets/js/ion.rangeSlider.js') ?>"></script>
<script src="<?php echo asset('userassets/js/owl.carousel.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/popper.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/bootstrap.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/bootstrap-datetimepicker.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/jquery.mCustomScrollbar.concat.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/jquery.fancybox.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/bootstrap-select.js') ?>"></script>

<script src="<?php echo asset('userassets/js/script.js') ?>"></script>

<script src="<?php echo asset('userassets/plugin/datepicker/bootstrap-datepicker.js'); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>

<!-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSWD1iUJodwoEA0i0cDWK8carUSDvO_q4&libraries=places" async defer></script> -->
<script src="<?php echo asset('userassets/plugin/geocomplete/jquery.geocomplete.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo asset('userassets/js/jquery.rateyo.min.js') ?>"></script>
<script src="<?php echo asset('userassets/js/share.js') ?>"></script>
<script src="<?php echo asset('userassets/js/general.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/css-element-queries/1.1.1/ResizeSensor.js"></script>
<script src="<?php echo asset('userassets/js/sticky-sidebar.js') ?>"></script>

<span id="showError" class="alert alert-danger" style=" display: none;position: fixed;bottom: 15px;left: 10px;"></span>
<span id="showErrorAll" class="alert alert-danger"
      style=" display: none;position: fixed;bottom: 15px;left: 10px;"></span>
<span id="showSuccess" class="alert alert-success"
      style=" display: none;position: fixed;bottom: 15px;left: 10px;"></span>
<!--<span id="show_notification" class="alert alert-dark" style="display: none; position: fixed;bottom: 15px;right: 10px;padding: 33px 28px">

</span>-->
<div class="flash_message" style="display: none;"></div>
<script>
    $(document).click(function () {
        $("#language_partial_query_dropdown , .select2_select_affiliations ").select2('close');
    });

    function isEmpty(val) {
        return (val === undefined || val == null || val.length <= 0) ? true : false;
    }

    function geolocate(ref) {
        var geocoder = new google.maps.Geocoder;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                var latlng = {
                    lat: position.coords.latitude,
                    lng: position.coords.longitude
                };
                geocoder.geocode({
                    'location': latlng
                }, function (results, status) {
                    if (status === 'OK') {
                        if (results[0]) {
                            $(ref).next('input[name=location]').val(results[0]['formatted_address']);
                            $(ref).next('input[name=location]').trigger("change");
                        }
                    }
                });
            });
        }
    }

    $('#multiple_solo_categories').select2({
        placeholder: "--Select Categories--",
        maximumSelectionLength: 3
    });

    function initAutocomplete() {
        autocomplete = new google.maps.places.Autocomplete(
            (document.getElementById('autocomplete')), {
                types: ['geocode']
            });
        autocomplete.addListener('place_changed', fillInAddress);
    }

    function fillInAddress() {
        // Get the place details from the autocomplete object.
        var place = autocomplete.getPlace();
        var lat = place.geometry.location.lat();
        var lng = place.geometry.location.lng();
        $('#lat').val(lat);
        $('#lng').val(lng);
    }

    $('.categories_select .dropdown-toggle').click(function () {
        $(this).toggleClass('show');
        $('.categories_select .dropdown-menu').toggleClass('show');
    });
    $('body').click(function (e) {
        if (!$(e.target).parents().is('.categories_select')) {
            $('.categories_select .dropdown-toggle').removeClass('show');
            $('.categories_select .dropdown-menu').removeClass('show');
        }
    });
    //    $('input[type=radio][name=cat]').click(function(){
    //        console.log(this.previous);
    //        if (this.previous) {
    //            this.checked = false;
    //        }
    //        this.previous = this.checked;
    //    });

    $('input[type=radio][name=cat]').change(function () {
        $('#header_categories_dropdown').html($(this).attr('data-value'));
    });
    $('body').on('click', '.open_likes_modal', function () {
        let post_id = $(this).attr('data-post-id');
        let likes_count = +$('.likes_counter' + post_id).html();
        if (likes_count > 0) {
            $('#likes_modal' + post_id).modal('show');
            $('#likes_modal' + post_id).css('background', '#0000009e');
        }
    });</script>
<?php if ($current_user) { ?>
    <script type="text/javascript" src="<?= asset('userassets/js/jquery.jWindowCrop.js') ?>"></script>
    <script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <script>
        function vulgarTermsErrorAlert() {
            $('#showError').html('Sorry! vulgar content is not allowed to be posted here.').fadeIn().fadeOut(5000);
        }

        $('#copy-link').click(function () {
            var link = $(this).attr('link');
            var textArea = document.createElement("textarea");
            textArea.value = link;
            document.body.appendChild(textArea);
            textArea.select();
            try {
                var successful = document.execCommand('copy');
                $('#showSuccess').html('Copied to clipboard !').fadeIn().fadeOut(5000);
            } catch (err) {
                $('#showError').html('Unable to copy !').fadeIn().fadeOut(5000);
            }
            document.body.removeChild(textArea);
        });

        function changeProfilePicInGigModal(ele) {
            var input = ele;
            var ref = $(ele);
            var filename = $(ele).val();
            var fileType = filename.replace(/^.*\./, '');
            var ValidImageTypes = ["jpg", "jpeg", "png"];
            if ($.inArray(fileType, ValidImageTypes) < 0) {
                alert("The file does not match the upload conditions, You can only upload jpg/jpeg/png files");
                event.preventDefault();
                $(ele).val('');
                return;
            }
            if (input.files[0].size < 2000000) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = (function (e) {
                        ref.parents('.edit_user_profile_pic').find('.gig_profile_pic_div').css("background-image", "url(" + e.target.result + ")");
                    });
                    reader.readAsDataURL(input.files[0]);
                }
            } else {
                alert("The file does not match the upload conditions, The maximum file size for uploads should not exceed 2MB");
            }
        }

        function joinStudioResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var studioId = $(ele).attr('studio-id');
            var studioName = $(ele).attr('studio-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'join_studio_response',
                    type: 'POST',
                    data: {
                        'studio_id': studioId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your request to join studio "' + studioName + '"',
                                "url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "studio_id": studioId,
                                "studio_name": studioName,
                                "type": data.type,
                                "studio_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "other_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                                "request_approve": '1',
                                "left_notification": '1',
                            });
                            if (data.type == 'user') {
                                $('.students_list_tab_' + studioId).children('ul').prepend('<li id="studio-student-' + otherid + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + otherid + '"><img src="<?php echo asset('public/images/') ?>/' + data.photo + '"></a></li>');
                            } else {
                                $('.teachers_list_tab_' + studioId).children('ul').prepend('<li id="studio-teacher-' + otherid + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + otherid + '"><img src="<?php echo asset('public/images/') ?>/' + data.photo + '"></a></li>');
                            }

                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your request to join studio "' + studioName + '"',
                                "url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "studio_id": studioId,
                                "studio_name": studioName,
                                "type": data.type,
                                "studio_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "other_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                                "request_approve": '0',
                                "left_notification": '1',
                            });
                        }
                    }
                });
            }
        }

        function inviteStudioResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var studioId = $(ele).attr('studio-id');
            var studioName = $(ele).attr('studio-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'invite_studio_response',
                    type: 'POST',
                    data: {
                        'studio_id': studioId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "studio_invite": '1',
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your invitation to join studio "' + studioName + '"',
                                "url": '<?= asset('teaching_studio_detail') ?>' + '/' + studioId,
                                "studio_id": studioId,
                                "studio_name": studioName,
                                "studio_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "other_url": '<?= asset('teaching_studio_detail') ?>' + '/' + studioId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId;
                            }, 1000);
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "studio_invite": '1',
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your invitation to join studio "' + studioName + '"',
                                "url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "studio_id": studioId,
                                "studio_name": studioName,
                                "studio_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "other_url": '<?= asset('teaching_studio_time_line') ?>' + '/' + studioId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/studio.png') ?>',
                            });
                        }
                    }
                });
            }
        }


        function joinAccompanistResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var accompanistId = $(ele).attr('accompanist-id');
            var accompanistName = $(ele).attr('accompanist-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'join_accompanist_response',
                    type: 'POST',
                    data: {
                        'accompanist_id': accompanistId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your request to join accompanist "' + accompanistName + '"',
                                "url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "accompanist_id": accompanistId,
                                "accompanist_name": accompanistName,
                                "accompanist_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "other_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "unique_text": data.notification.unique_text,
                                "request_approve": '1',
                                "notification_icon": '<?= asset('userassets/images/pianist.png') ?>',
                                "left_notification": '1',
                            });
                            $('.accompanist_members_' + accompanistId).children('ul').prepend('<li id="accompanist-mem-' + otherid + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + otherid + '"><img src="<?php echo asset('public/images/') ?>/' + data.photo + '"><div class="friends_name"><h6>' + data.other_name + '</h6></div></a></li>');
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your request to join accompanist "' + accompanistName + '"',
                                "url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "accompanist_id": accompanistId,
                                "accompanist_name": accompanistName,
                                "request_approve": '0',
                                "accompanist_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "other_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/pianist.png') ?>',
                                "left_notification": '1',
                            });
                        }
                    }
                });
            }
        }


        function inviteAccompanistResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var accompanistId = $(ele).attr('accompanist-id');
            var accompanistName = $(ele).attr('accompanist-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'invite_accompanist_response',
                    type: 'POST',
                    data: {
                        'accompanist_id': accompanistId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "accompanist_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your invitation to join accompanist "' + accompanistName + '"',
                                "url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "accompanist_id": accompanistId,
                                "accompanist_name": accompanistName,
                                "accompanist_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "other_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/pianist.png') ?>',
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('group_time_line') ?>' + '/' + groupId;
                            }, 1000);
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "accompanist_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your invitation to join accompanist "' + accompanistName + '"',
                                "url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "accompanist_id": accompanistId,
                                "accompanist_name": accompanistName,
                                "accompanist_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "other_url": '<?= asset('accompanist_time_line') ?>' + '/' + accompanistId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/pianist.png') ?>',
                            });
                        }
                    }
                });
            }
        }


        function addFriendResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var friendId = $(ele).attr('friend-id');
            var friendName = $(ele).attr('friend-name');
            var status = $(ele).attr('status');
            var data = new FormData();
            data.append('friend_id', friendId);
            data.append('user_id', otherid);
            data.append('_token', '<?= csrf_token() ?>');
            data.append('status', status);
            data.append('unique_text', uniqueText);
            if (status != 'requested') {
                $.ajax({
                    url: base_url + 'add_friend_response',
                    type: 'POST',
                    data: data,
                    processData: false,
                    contentType: false,
                    //                    beforeSend: function(request) {
                    //                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    //                    },
                    success: function (response) {
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (response.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "user_name": response.name,
                                "user_photo": response.photo,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your friend request',
                                "url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "friend_id": friendId,
                                "friend_name": friendName,
                                "friend_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "friend_response": '1',
                                "other_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "unique_text": response.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                                "left_notification": '1',
                            });
                            $('.friends_list_' + friendId).children('ul').prepend('<li id="friend_' + response.sender_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + response.sender_id + '"><img src="<?php echo asset('public/images/') ?>/' + response.photo + '"></a><div class="friends_name"><h6>' + response.name + '</h6></div></li>');
                        } else if (response.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your friend request',
                                "url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "friend_id": friendId,
                                "friend_name": friendName,
                                "friend_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "other_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "unique_text": response.notification.unique_text,
                                "friend_response": '0',
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                                "left_notification": '1',
                            });
                        }
                    }
                });
                //                return false;
            }
        }


        function inviteFriendResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var friendId = $(ele).attr('friend-id');
            var friendName = $(ele).attr('friend-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'invite_friend_response',
                    type: 'POST',
                    data: {
                        'friend_id': friendId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "friend_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your invitation for friend request "' + friendName + '"',
                                "url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "friend_id": friendId,
                                "friend_name": friendName,
                                "friend_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "other_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('profile_timeline') ?>' + '/' + friendId;
                            }, 1000);
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "friend_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your invitation for friend request "' + friendName + '"',
                                "url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "friend_id": friendId,
                                "friend_name": friendName,
                                "friend_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "other_url": '<?= asset('profile_timeline') ?>' + '/' + friendId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                            });
                        }
                    }
                });
            }
        }


        function joinGroupResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var groupId = $(ele).attr('group-id');
            var groupName = $(ele).attr('group-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'join_group_response',
                    type: 'POST',
                    data: {
                        'group_id': groupId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your request to join event service "' + groupName + '"',
                                "url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "group_id": groupId,
                                "group_name": groupName,
                                "request_approve": '1',
                                "group_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "other_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "left_notification": "1",
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/group.png') ?>',
                            });
                            $('.members_tab').children('ul').prepend('<li id="member-' + otherid + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + otherid + '"><img src="<?php echo asset('public/images/') ?>/' + data.photo + '"></a></li>');
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your request to join event service "' + groupName + '"',
                                "url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "group_id": groupId,
                                "group_name": groupName,
                                "request_approve": '0',
                                "group_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "other_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/group.png') ?>',
                                "left_notification": "1",
                            });
                        }
                    }
                });
            }
        }

        function inviteGroupResponse(ele) {
            var otherid = $(ele).attr('user-id');
            var uniqueText = $(ele).attr('unique-text');
            var groupId = $(ele).attr('group-id');
            var groupName = $(ele).attr('group-name');
            var status = $(ele).attr('status');
            if (status !== 'requested') {
                $.ajax({
                    url: base_url + 'invite_group_response',
                    type: 'POST',
                    data: {
                        'group_id': groupId,
                        'status': status,
                        'user_id': otherid,
                        'unique_text': uniqueText
                    },
                    beforeSend: function (request) {
                        return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                    },
                    success: function (data) {
                        //                    console.log(data);
                        $('.notification' + uniqueText).find('.icon').remove();
                        if (data.status === 'approved') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "group_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' accepted your invitation to join event service "' + groupName + '"',
                                "url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "group_id": groupId,
                                "group_name": groupName,
                                "group_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "other_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/group.png') ?>',
                            });
                            setTimeout(function () {
                                window.location.href = '<?= asset('group_time_line') ?>' + '/' + groupId;
                            }, 1000);
                        } else if (data.status === 'rejected') {
                            socket.emit('notification_get', {
                                "user_id": otherid,
                                "group_invite": '1',
                                "other_id": '<?php echo $current_id; ?>',
                                "other_name": '<?= $current_user->first_name . ' ' . $current_user->last_name ?>',
                                "photo": '<?php echo $current_photo; ?>',
                                "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' rejected your invitation to join event service "' + groupName + '"',
                                "url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "group_id": groupId,
                                "group_name": groupName,
                                "group_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "other_url": '<?= asset('group_time_line') ?>' + '/' + groupId,
                                "unique_text": data.notification.unique_text,
                                "notification_icon": '<?= asset('userassets/images/group.png') ?>',
                            });
                        }
                    }
                });
            }
        }


        function like_post(post_id) {
            $(".wall-post-single-dislike-" + post_id).css("display", "block");
            $(".wall-post-single-like-" + post_id).css("display", "none");
            $.ajax({
                type: "POST",
                url: "<?php echo asset('like_post'); ?>",
                data: {
                    post_id: post_id,
                    is_like: 1,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message === 'liked') {
                        socket.emit('notification_get', {
                            "user_id": response.notification.on_user,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' liked your post',
                            "url": '<?= asset('get_post') ?>' + '/' + post_id,
                            "notification_icon": '<?= asset('userassets/images/icon-likes.png') ?>',
                            "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                            "unique_text": response.notification.unique_text,
                        });
                        var likesCounter = parseInt($(".likes_counter" + post_id).html());
                        likesCounter = likesCounter + 1;
                        $(".likes_counter" + post_id).html(likesCounter);
                        $('#likes_modal_ul' + post_id).prepend(` < li data - is - my - like = "1" data - post - id = "` + post_id + `" >
                                < div class = "media align-items-center" >
                                                                            < img  onclick = "window.location.href = '<?= asset('profile_timeline/' . $current_id) ?>';" style = "cursor: pointer;" src = "<?= $current_photo ?>" alt = "profile pic" class = "rounded-circle" > < div class = "media-body" >
                                                                                                        < div class = "d-flex flex-column flex-sm-row" >
                                                                                                        < div class = "mb-2" >
                                                                                                        < a href = "<?= asset('profile_timeline/' . $current_id) ?>" class = "u_name" ><?= $current_user->first_name . ' ' . $current_user->last_name ?> < /a>
                                                                                                        < /div>
                                                                                                        < /div>
                                                                                                        < /div>
                                                                                                        < /div>
                                                                                                        < /li>`);
                    } else if (response.message !== 'disliked') {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function dislike_post(post_id) {
            $(".wall-post-single-like-" + post_id).css("display", "block");
            $(".wall-post-single-dislike-" + post_id).css("display", "none");
            $.ajax({
                type: "POST",
                url: "<?php echo asset('like_post'); ?>",
                data: {
                    post_id: post_id,
                    is_like: 0,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message === 'disliked') {
                        //                        socket.emit('notification_get', {
                        //                            "user_id": response.notification.on_user,
                        //                            "other_id": '<?php echo $current_id; ?>',
                        //                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                        //                            "photo": '<?php echo $current_photo; ?>',
                        //                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' liked your post',
                        //                            "url": '<?= asset('get_post') ?>' + '/' + post_id,
                        //                            "notification_icon": '<?= asset('userassets/images/icon-likes.png') ?>',
                        //                            "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                        //                            "unique_text": response.notification.unique_text,
                        //                        });
                        var likesCounter = parseInt($(".likes_counter" + post_id).html());
                        likesCounter = likesCounter - 1;
                        $(".likes_counter" + post_id).html(likesCounter);
                        $("li[data-is-my-like='1'][data-post-id='" + post_id + "']").remove();
                    } else if (response.message !== 'disliked') {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function postComment(e, obj, post_id, to_send) {

            if ((e.keyCode === 13 && send_comment === 1) || to_send == 1) {
                var old_comment_id = $('#edit_comment_id' + post_id).val();
                //empty comment area
                $('textarea.mention_' + post_id).mentionsInput('val', function (text) {
                    $('textarea.mention_' + post_id).mentionsInput('getMentions', function (data) {
                        mentioned_users = data;
                    });
                    comment = text;
                    $('#comment_area_' + post_id).val('');
                    var description_data = '';
                    if (comment.length > 0) {
                        $('.edit_scroll_' + post_id).show();
                        $('textarea.mention_' + post_id).mentionsInput('reset');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add_comment'); ?>",
                            //                data: {"old_post_id": old_post_id, "post_id": post_id, "old_comment_id": old_comment_id, "comment": comment, "_token": '<?= csrf_token() ?>'},
                            data: {
                                "post_id": post_id,
                                mentioned_users: mentioned_users,
                                "old_comment_id": old_comment_id,
                                "comment": comment,
                                "_token": '<?= csrf_token() ?>'
                            },
                            success: function (response) {
                                if (response.error) {
                                    vulgarTermsErrorAlert();
                                } else if (response.message === 'success') {
                                    $('.wall-comments-area-' + post_id).append(response.view);
                                    $('.wall-comments-area-pop-up' + post_id).append(response.pop_up);
                                    $('#comment_area_' + post_id).val('');
                                    $('#edit_comment_id' + post_id).val('');
                                    //                        $('#edit_comment_post_id'+post_id).val('');
                                    var notification_text = '';
                                    if (response.is_edited == 0) {
                                        notification_text = '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' commented on your post';
                                    } else if (response.is_edited == 1) {
                                        notification_text = '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' edited the comment on your post';
                                    }
                                    socket.emit('notification_get', {
                                        "user_id": response.notification.on_user,
                                        "other_id": '<?php echo $current_id; ?>',
                                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                        "photo": '<?php echo $current_photo; ?>',
                                        "text": notification_text,
                                        "url": '<?= asset('get_post') ?>' + '/' + post_id,
                                        "notification_icon": '<?= asset('userassets/images/icon-comment.png') ?>',
                                        "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                                        "unique_text": response.notification.unique_text,
                                    });
                                    $.each(mentioned_users, function (key, value) {
                                        socket.emit('notification_get', {
                                            "user_id": value.id,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> mention you in comment',
                                            "url": '<?= asset('get_post') ?>' + '/' + post_id,
                                            "notification_icon": '<?= asset('userassets/images/icon-comment.png') ?>',
                                            "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                                            "unique_text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> mention you in comment' + response.post_id,
                                        });
                                    });
                                    var commentsCounter = parseInt($("#comments_counter" + post_id).html());
                                    commentsCounter = commentsCounter + 1;
                                    $("#comments_counter" + post_id).html(commentsCounter);
                                }
                            }
                        });
                    }
                });
            } else {
                send_comment = 1;
            }
        }

        function postCommentPopUp(e, obj, post_id, to_send) {
            if ((e.keyCode === 13 && send_comment === 1) || to_send == 1) {
                var old_comment_id = $('#edit_comment_id' + post_id).val();
                $('textarea.mention_pop_up' + post_id).mentionsInput('val', function (text) {
                    $('textarea.mention_pop_up' + post_id).mentionsInput('getMentions', function (data) {
                        mentioned_users = data;
                    });
                    var comment = text;
                    $('#add_comment_popup_' + post_id).val('');
                    var description_data = '';
                    if (comment.length > 0) {
                        $('.edit_scroll_' + post_id).show();
                        $('textarea.mention_' + post_id).mentionsInput('reset');
                        $.ajax({
                            type: "POST",
                            url: "<?php echo asset('add_comment'); ?>",
                            //                data: {"old_post_id": old_post_id, "post_id": post_id, "old_comment_id": old_comment_id, "comment": comment, "_token": '<?= csrf_token() ?>'},
                            data: {
                                "post_id": post_id,
                                mentioned_users: mentioned_users,
                                "old_comment_id": old_comment_id,
                                "comment": comment,
                                "_token": '<?= csrf_token() ?>'
                            },
                            success: function (response) {
                                if (response.error) {
                                    vulgarTermsErrorAlert();
                                } else if (response.message === 'success') {
                                    $('.wall-comments-area-' + post_id).append(response.view);
                                    $('.wall-comments-area-pop-up' + post_id).append(response.pop_up);
                                    $('#add_comment_popup_' + post_id).val('');
                                    $('#edit_comment_id' + post_id).val('');
                                    //                        $('#edit_comment_post_id'+post_id).val('');
                                    var notification_text = '';
                                    if (response.is_edited == 0) {
                                        notification_text = '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' commented on your post';
                                    } else if (response.is_edited == 1) {
                                        notification_text = '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>' + ' edited the comment on your post';
                                    }
                                    socket.emit('notification_get', {
                                        "user_id": response.notification.on_user,
                                        "other_id": '<?php echo $current_id; ?>',
                                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                        "photo": '<?php echo $current_photo; ?>',
                                        "text": notification_text,
                                        "url": '<?= asset('get_post') ?>' + '/' + post_id,
                                        "notification_icon": '<?= asset('userassets/images/icon-comment.png') ?>',
                                        "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                                        "unique_text": response.notification.unique_text,
                                    });
                                    $.each(mentioned_users, function (key, value) {
                                        socket.emit('notification_get', {
                                            "user_id": value.id,
                                            "other_id": '<?php echo $current_id; ?>',
                                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                                            "photo": '<?php echo $current_photo; ?>',
                                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> mention you in comment',
                                            "url": '<?= asset('get_post') ?>' + '/' + post_id,
                                            "notification_icon": '<?= asset('userassets/images/icon-comment.png') ?>',
                                            "other_url": '<?= asset('get_post') ?>' + '/' + post_id,
                                            "unique_text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?> mention you in comment' + response.post_id,
                                        });
                                    });
                                    var commentsCounter = parseInt($("#comments_counter" + post_id).html());
                                    commentsCounter = commentsCounter + 1;
                                    $(".comments_counter" + post_id).html(commentsCounter);
                                }
                            }
                        });
                    }
                });
            } else {
                send_comment = 1;
            }
        }

        function editComment(comment_id, post_id, comment) {
            $('textarea.mention_' + post_id).remove();
            $('.edit_scroll_' + post_id).hide();
            new_text_area = '<textarea onkeyup="postComment(event, this,' + post_id + ',0)" id="comment_area_' + post_id + '" placeholder="Write comment.." class="form-control mention_' + post_id + '"></textarea>';
            $('#form_area_' + post_id).append(new_text_area);
            //    $('textarea.mention_'+post_id).parents('.mentions-input-box').find('.mentions').remove();
            if (!comment) {
                comment = $('#hidden_comment_' + comment_id).val();
            }
            old_comment_id = $('#edit_comment_id' + post_id).val();
            //        old_comment_post_id = $('#edit_comment_post_id'+post_id).val();
            if (old_comment_id) {
                $('#comment_area_' + old_comment_post_id).val('');
                $('#single-comment-list-' + old_comment_id).show();
            }
            $('#comment_area_' + post_id).focus();
            $('#comment_area_' + post_id).val(comment);
            $('#single-comment-list-' + comment_id).hide();
            $('.single-comment-list-' + comment_id).hide();
            $('#edit_comment_id' + post_id).val(comment_id);
            $('textarea.mention_' + post_id).mentionsInput({
                defaultValue: comment,
                onDataRequest: function (mode, query, callback) {
                    $.getJSON('<?= asset('get_users_mentions') ?>', function (responseData) {
                        responseData = _.filter(responseData, function (item) {
                            return item.name.toLowerCase().indexOf(query.toLowerCase()) > -1
                        });
                        callback.call(this, responseData);
                    });
                }
            });
            //        $('#edit_comment_post_id'+post_id).val(post_id);
        }

        function deletePostComment(comment_id, post_id) {
            $.ajax({
                type: "GET",
                url: "<?php echo asset('delete_comment'); ?>",
                data: {
                    comment_id: comment_id
                },
                success: function (response) {
                    if (response.message == 'success') {
                        $("#single-comment-list-" + comment_id).remove();
                        $('#showSuccess').html('Comment Deleted Successfully').fadeIn().fadeOut(5000);
                        $('#modal_comment_delete_' + comment_id).modal('hide');
                        var commentsCounter = parseInt($("#comments_counter" + post_id).html());
                        commentsCounter = commentsCounter - 1;
                        $("#comments_counter" + post_id).html(commentsCounter);
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
            $('#delete_post_comment-' + comment_id).hide(300);
        }

        function focustextarea(post_id) {
            $('#comment_area_' + post_id).focus();
        }

        function focustextareaPopUp(post_id) {
            $('#add_comment_popup_' + post_id).focus();
        }

        function readNotificatios() {
            $.ajax({
                type: "GET",
                url: "<?php echo asset('read_notifications'); ?>",
                success: function () {
                    $('#new-notification-dot').find('.rounded-circle').remove();
                }
            });
        }

        function followUser(other_id) {
            $('.followuser_' + other_id).hide();
            $('.unfollowuser_' + other_id).show();
            $.ajax({
                type: "GET",
                url: "<?php echo asset('follow_user'); ?>",
                data: {
                    other_id: other_id
                },
                success: function (response) {

                    if (response.message == 'success') {
                        $('#showposts').empty();
                        load_posts_again();
                        socket.emit('notification_get', {
                            "user_id": other_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' started following you',
                            "url": '<?= asset('profile_timeline/' . $current_id) ?>',
                            "other_url": '<?= asset('profile_timeline/' . $current_id) ?>',
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                        });
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function unfollowUser(other_id) {


            $('.unfollowuser_' + other_id).hide();
            $('.followuser_' + other_id).show();

            $.ajax({
                type: "GET",
                url: "<?php echo asset('unfollow_user'); ?>",
                data: {
                    other_id: other_id
                },
                success:function(response)
                {

                    $('#showposts').empty();
                    load_posts_again();
                    
                }
            });

        }

        function showimage() {
            $('.events_pic').hide();
            $('.upload_image').show();
            $('#preview').attr('src', '');
            $('#cover_image_f').val('');
        }

        function addbooking(gig_id) {
            $('#booking_error').hide();
            booking_description = $('#booking_description' + gig_id).val();
            booking_hours = $('#booking_hours' + gig_id).val();
            booking_date = $('#booking_date' + gig_id).val();
            booking_location = $('#booking_location' + gig_id).val();
            booking_email = $('#booking_email' + gig_id).val();
            booking_name = $('#booking_name' + gig_id).val();
            booking_price = $('#booking_price' + gig_id).val();
            user_id = $('#user_id' + gig_id).val();
            gig_id_ = $('#gig_id_' + gig_id).val();
            var checkIfThereAreErrors = '';
            if (!booking_date) {
                $('#booking_date' + gig_id).addClass('border-for-error');
                checkIfThereAreErrors = 1;
            }
            if (!booking_name) {
                $('#booking_name' + gig_id).addClass('border-for-error');
                checkIfThereAreErrors = 1;
            }
            if (!booking_email) {
                $('#booking_email' + gig_id).addClass('border-for-error');
                checkIfThereAreErrors = 1;
            }
            if (checkIfThereAreErrors) {
                return;
            }
            $.ajax({
                type: "POST",
                url: "<?php echo asset('add_booking'); ?>",
                data: {
                    gig_type: 'gig',
                    user_id: user_id,
                    gig_id: gig_id_,
                    booking_price: booking_price,
                    booking_location: booking_location,
                    booking_email: booking_email,
                    booking_date: booking_date,
                    booking_name: booking_name,
                    booking_hours: booking_hours,
                    booking_description: booking_description,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message == 'success') {
                        socket.emit('notification_get', {
                            "user_id": user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' requested to book your gig',
                            "url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + response.bookig_id,
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                            "is_booking_notification": 1
                        });
                        $('#booking_description' + gig_id).val('');
                        $('#booking_hours' + gig_id).val('');
                        $('#booking_date' + gig_id).val('');
                        $('#booking_price' + gig_id).val('');
                        $('#booking_success' + gig_id).html('<a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>Booking Added Successfully').show();
                    }
                    $(".modal").animate({
                        scrollTop: 0
                    }, "slow");
                    setTimeout(function () {
                        window.location.reload();
                    }, 4000);
                }
            });
        }

        function acceptbooking(booking_id) {
            $('#accept_booking').removeAttr('onclick');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('accept_booking/'); ?>",
                data: {
                    booking_id: booking_id,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.already_have_bookings) {
                        alert(response.already_have_bookings);
                    } else if (response.error) {
                        $('#booking_accept_error').show().html('Payment is declined and booking is cancelled due to some reasons.');
                        socket.emit('notification_get', {
                            "user_id": response.user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' cancelled your booking because, ' + response.error,
                            "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                            "is_booking_notification": 1
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    } else {
                        $('#booking_accept_success').show().html(response.success);
                        socket.emit('notification_get', {
                            "user_id": response.user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' accepted your booking request',
                            "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    }

                }
            });
        }

        function declineBooking(booking_id) {
            $('#decline_booking').removeAttr('onclick');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('decline_booking/'); ?>",
                data: {
                    booking_id: booking_id,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    $('#booking_decline_success').show().html(response.success);
                    socket.emit('notification_get', {
                        "user_id": response.user_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' rejected you booking request',
                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                        "is_booking_notification": 1
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        function requestPaymentSend(booking_id) {
            $('#request_payment_btn').removeAttr('onclick');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('request_payment/'); ?>",
                data: {
                    booking_id: booking_id,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    $('#booking_request_payment_success').show().html(response.success);
                    socket.emit('notification_get', {
                        "user_id": response.user_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' requested for payment release',
                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                        "is_booking_notification": 1
                    });
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        function requestPaymentAdmin(booking_id) {
            $('#request_admin_btn').removeAttr('onclick');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('request_payment_admin/'); ?>",
                data: {
                    booking_id: booking_id,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    $('#booking_request_payment_admin_success').show().html(response.success);
                    setTimeout(function () {
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        function addAvailalabilty(booking_id) {
            $('#request_payment_btn').removeAttr('onclick');
            booking_date_from = $('#booking_date_from').val();
            booking_date_to = $('#booking_date_to').val();
            booking_time_from = $('#booking_time_from').val();
            booking_time_to = $('#booking_time_to').val();
            if (booking_date_from == '' || booking_date_to == '' || booking_time_from == '' || booking_time_to == '') {
                $('#booking_availabile_error').show().html('All Fields Are Required');
                $('#availability_modal_btn').attr('onclick', 'addAvailalabilty(' + booking_id + ')');
            } else {
                $('#booking_availabile_error').hide();
                $.ajax({
                    type: "POST",
                    url: "<?php echo asset('add_availabilty/'); ?>",
                    data: {
                        booking_id: booking_id,
                        "_token": '<?= csrf_token() ?>',
                        booking_time_to: booking_time_to,
                        booking_time_from: booking_time_from,
                        booking_date_to: booking_date_to,
                        booking_date_from: booking_date_from
                    },
                    success: function (response) {
                        $('#booking_availabile_success').show().html(response.success);
                        socket.emit('notification_get', {
                            "user_id": response.user_id,
                            "other_id": '<?php echo $current_id; ?>',
                            "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                            "photo": '<?php echo $current_photo; ?>',
                            "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' postponed booking',
                            "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                            "unique_text": response.notification.unique_text,
                            "notification_icon": '<?= asset('userassets/images/icon-event.png') ?>',
                        });
                        setTimeout(function () {
                            window.location.reload();
                        }, 2500);
                    }
                });
            }
        }

        function approveBookingPayment(booking_id) {
            $('#approve_payment_btn').removeAttr('onclick');
            let notes = $('#approve_notes').val();
            let tip_amount = $('#tip_amount').val();
            $.ajax({
                type: "POST",
                url: "<?php echo asset('approve_payment'); ?>",
                data: {
                    notes: notes,
                    tip_amount: tip_amount,
                    booking_id: booking_id,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    $('#booking_approve_success').show().html(response.success);
                    socket.emit('notification_get', {
                        "user_id": response.user_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' approved your booking payment',
                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                    });
                    setTimeout(function () {
                        window.location.href = base_url + 'review_profile_after_booking/' + booking_id;
                    }, 2500);
                }
            });
        }

        function requestPartialRefund(booking_id) {
            $('#partial_refund_modal_btn').removeAttr('onclick');
            if ($("#partial_refund_percentage").val() > 100) {
                $(this).val(100)
            }
            let percentage = $('#partial_refund_percentage').val();
            let reason = $('#partial_refund_reason').val();
            var form = new FormData();
            form.append('reason', reason);
            form.append('percentage', percentage);
            form.append('booking_id', booking_id);
            form.append('_token', '<?= csrf_token() ?>');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('request_partial_refund'); ?>",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                success: function (response) {
                    //                    $('#booking_reject_success').show().html(response.success);
                    //                    socket.emit('notification_get', {
                    //                        "user_id": response.user_id,
                    //                        "other_id": '<?php echo $current_id; ?>',
                    //                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                    //                        "photo": '<?php echo $current_photo; ?>',
                    //                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' rejected your booking payment',
                    //                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                    //                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                    //                        "unique_text": response.notification.unique_text,
                    //                        "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                    //                    });
                    setTimeout(function () {
                        //                        window.location.href = base_url + 'review_profile_after_booking/' + booking_id;
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        function acceptPartialRefund(booking_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo asset('accept_partial_refund'); ?>",
                data: {'_token': '<?= csrf_token() ?>', 'booking_id': booking_id},
                success: function (response) {
                    //                    setTimeout(function() {
                    //                        window.location.reload();
                    //                    }, 2500);
                }
            });
        }

        function rejectPartialRefund(booking_id) {
            $.ajax({
                type: "POST",
                url: "<?php echo asset('reject_partial_refund'); ?>",
                data: {'_token': '<?= csrf_token() ?>', 'booking_id': booking_id},
                success: function (response) {
                    //                    setTimeout(function() {
                    //                        window.location.reload();
                    //                    }, 2500);
                }
            });
        }

        function submitDisputeReason(booking_id) {
            $('#submit_dispute_reason_btn').removeAttr('onclick');
            let reason = $('#dispute_reason').val();
            var form = new FormData();
            form.append('reason', reason);
            form.append('booking_id', booking_id);
            for (var i = 0; i < $('#dispute_evidence_files').get(0).files.length; ++i) {
                form.append('evidence_files[' + i + ']', $('#dispute_evidence_files').get(0).files[i]);
            }
            form.append('_token', '<?= csrf_token() ?>');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('submit_dispute_reason'); ?>",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                success: function (response) {
                    //                    $('#booking_reject_success').show().html(response.success);
                    //                    socket.emit('notification_get', {
                    //                        "user_id": response.user_id,
                    //                        "other_id": '<?php echo $current_id; ?>',
                    //                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                    //                        "photo": '<?php echo $current_photo; ?>',
                    //                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' rejected your booking payment',
                    //                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                    //                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                    //                        "unique_text": response.notification.unique_text,
                    //                        "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                    //                    });
                    setTimeout(function () {
                        //                        window.location.href = base_url + 'review_profile_after_booking/' + booking_id;
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        function rejectBookingPayment(booking_id) {
            $('#reject_payment_btn').removeAttr('onclick');
            // let notes = $('#reject_notes').val();
            let reason = $('#reject_reason').val();
            var form = new FormData();
            // form.append('notes', notes);
            form.append('reason', reason);
            form.append('booking_id', booking_id);
            for (var i = 0; i < $('#reject_evidence_files').get(0).files.length; ++i) {
                form.append('evidence_files[' + i + ']', $('#reject_evidence_files').get(0).files[i]);
            }
            form.append('_token', '<?= csrf_token() ?>');
            $.ajax({
                type: "POST",
                url: "<?php echo asset('reject_payment'); ?>",
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                data: form,
                success: function (response) {
                    $('#booking_reject_success').show().html(response.success);
                    socket.emit('notification_get', {
                        "user_id": response.user_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' rejected your booking payment',
                        "url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "other_url": '<?= asset('booking_details/') ?>' + '/' + booking_id,
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/payment.png') ?>',
                    });
                    setTimeout(function () {
                        //                        window.location.href = base_url + 'review_profile_after_booking/' + booking_id;
                        window.location.reload();
                    }, 2500);
                }
            });
        }

        current_id = '<?= $current_id ?>';
        socket.on('notification_send', function (data) {
                console.log(data.url);
            if (data.user_id == current_id && data.other_id != current_id) {
                $('#new-notification-dot').html('<span class="indicator rounded-circle"><span class="rounded-circle"></span></span>');
                if (data.is_booking_notification) {
                    if ($('#unread_bookings_count').is(':empty')) {
                        $('#unread_bookings_count').html('1');
                    } else {
                        var unread_bookings_count = parseInt($('#unread_bookings_count').html());
                        $('#unread_bookings_count').html(unread_bookings_count + 1);
                    }
                }

                var text = '';
                if (data.hasOwnProperty('from_admin')) {
                    text = '<i class="flash_close">&times;</i>' +
                        '<a href="' + data.url + '">' +
                        '<div class="msg_body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div class="mr-3">' +
                        '<img src="<?= asset('userassets/images/favicon.png') ?>" alt="pic" class="rounded-circle w-50">' +
                        '</div>' +
                        '<div>' +
                        '<p class="mb-0"> ' + data.text + '</p>' +
                        '</div>';
                    '</div>' +
                    '</div>' +
                    '</a>';
                } else {
                    text = '<i class="flash_close">&times;</i>' +
                        '<a href="' + data.url + '">' +
                        '<div class="msg_body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div class="mr-3">' +
                        '<img src="' + data.photo + '" alt="pic" class="rounded-circle w-50">' +
                        '</div>' +
                        '<div>' +
                        '<span class="title">' + data.other_name + '</span>' +
                        '<p class="mb-0"> ' + data.text + '</p>' +
                        '</div>';
                    '</div>' +
                    '</div>' +
                    '</a>';
                }
                if (data.hasOwnProperty('is_message_notification') && data.is_message_notification == 1) {
                    let segment = '<?= $segment ?>';
                    if (segment != 'messages') {
                        $('.flash_message').html(text).fadeIn(200);
                    }
                } else {
                    $('.flash_message').html(text).fadeIn(200);
                }
                setTimeout(function () {
                    $('.flash_message').fadeOut(1000);
                }, 10000);
                //                $('#show_notification').html(text).fadeIn().fadeOut(5000);
                if (data.hasOwnProperty('from_admin')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round mr-2 w-50" style="background-image: url(<?= asset('userassets/images/favicon.png') ?>)"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' + data.text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('group_invite')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.group_url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' +
                        '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="icon">' +
                        '<img onclick="inviteGroupResponse(this)" unique-text="' + data.unique_text + '" status="reject" group-id="' + data.group_id + '" group-name="' + data.group_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                        '<img onclick="inviteGroupResponse(this)" unique-text="' + data.unique_text + '" status="approve" group-id="' + data.group_id + '" group-name="' + data.group_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                        '</span>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('group_id')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    if (data.left_notification) {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.group_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        if (data.request_approve && data.request_approve == '1') {
                            $('#event_members_count').html(parseInt($('#event_members_count').html(), 10) + 1);
                            $("#post_box_group_" + data.group_id).show();
                            $("#follow_g_" + data.group_id).trigger("click");
                            $("#follow_g_" + data.group_id).trigger("click");
                            $('.append-request-' + data.group_id).children('#group-request-id').html('<i class="fas fa-minus"></i> Joined');
                            $('.append-request-' + data.group_id).children('#group-request-id').attr("onclick", "addGroupMember(" + data.user_id + "," + data.group_id + ",'leave')");
                            $('.members_tab_' + data.group_id).children('ul').prepend('<li id="member-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"></a></li>');
                            $('#showposts').empty();
                            load_posts_again();
                        } else if (data.request_approve && data.request_approve == '2') {
                            $('#event_members_count').html(parseInt($('#event_members_count').html(), 10) - 1);
                            $("#unfollow_g_" + data.group_id).trigger("click");
                            $('#member-' + data.other_id).remove();
                        } else if (data.request_approve && data.request_approve == '0') {
                            $('#event_members_count').html(parseInt($('#event_members_count').html(), 10) - 1);
                            $("#post_box_group_" + data.group_id).hide();
//                                $("#unfollow_g_" + data.group_id).trigger("click");
                            $('.append-request-' + data.group_id).children('#group-request-id').html('<i class="fas fa-plus"></i> Join as Accompanist');
                            $('.append-request-' + data.group_id).children('#group-request-id').removeClass('btn-white');
                            $('.append-request-' + data.group_id).children('#group-request-id').addClass('btn-gradient');
                            $('.append-request-' + data.group_id).children('#group-request-id').attr("onclick", "addGroupMember(" + data.otherid + "," + data.group_id + ",'join')");
                            $('#showposts').empty();
                            load_posts_again();
                        } else {
                            $('#event_members_count').html(parseInt($('#event_members_count').html(), 10) + 1);
                        }
                    } else {

                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.group_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<span class="icon">' +
                            '<img onclick="joinGroupResponse(this)" unique-text="' + data.unique_text + '" status="reject" group-id="' + data.group_id + '" group-name="' + data.group_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                            '<img onclick="joinGroupResponse(this)" unique-text="' + data.unique_text + '" status="approve" group-id="' + data.group_id + '" group-name="' + data.group_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                            '</span>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                    }
//                                                                                                        $('#notification-list-in-header').prepend(text);
                    if (data.request_approve && data.request_approve == '0') {
                        $('#group_messages_li').hide();
//                                                                                                                $('.append-request-' + data.group_id).children('#group-request-id').html('<i class="fas fa-minus"></i> Joined');
//                                                                                                                $('.append-request-' + data.group_id).children('#group-request-id').removeClass('btn-gradient');
//                                                                                                                $('.append-request-' + data.group_id).children('#group-request-id').addClass('btn-white');
//                                                                                                                $('.append-request-' + data.group_id).children('#group-request-id').attr("onclick", "addGroupMember(" + data.otherid + "," + data.group_id + ",'leave')");
                    }

                    $('.append-request-' + data.group_id).children('#group-request-id').html('<i class="fas fa-minus"></i> Joined');
                    $('.append-request-' + data.group_id).children('#group-request-id').removeClass('btn-gradient');
                    $('.append-request-' + data.group_id).children('#group-request-id').addClass('btn-white');
                    $('.append-request-' + data.group_id).children('#group-request-id').attr("onclick", "addGroupMember(" + data.otherid + "," + data.group_id + ",'leave')");
                    $('.members_tab_' + data.group_id).children('ul').prepend('<li id="member-' + data.otherid + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.otherid + '"><img src="<?php echo asset('public/images/') ?>/' + data.photo + '"></a></li>');
                    $('#group_messages_li').show();

                } else if (data.hasOwnProperty('accompanist_invite')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.accompanist_url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' +
                        '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="icon">' +
                        '<img onclick="inviteAccompanistResponse(this)" unique-text="' + data.unique_text + '" status="reject" accompanist-id="' + data.accompanist_id + '" accompanist-name="' + data.accompanist_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                        '<img onclick="inviteAccompanistResponse(this)" unique-text="' + data.unique_text + '" status="approve" accompanist-id="' + data.accompanist_id + '" accompanist-name="' + data.accompanist_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                        '</span>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('accompanist_id')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    if (data.left_notification) {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.accompanist_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        if (data.request_approve && data.request_approve == '1') {
                            $('#accompanist_messages_li').show();
                            $("#post_box_accompanist_" + data.accompanist_id).show();
                            $("#follow_a_" + data.accompanist_id).trigger("click");
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').html('<i class="fas fa-minus"></i> Joined');
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').attr("onclick", "addAccompanistMember(" + data.user_id + "," + data.accompanist_id + ",'leave')");
                            $('.accompanist_members_' + data.accompanist_id).children('ul').prepend('<li id="accompanist-mem-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"><div class="friends_name"><h6>' + data.other_name + '</h6></div></a></li>');
                            $('#showposts').empty();
                            load_posts_again();
                        } else if (data.request_approve && data.request_approve == '2') {
                            $('#accompanist_messages_li').hide();
                            $('#accompanist-mem-' + data.other_id).remove();
                            $('#accompanist_members_count').html(parseInt($('#accompanist_members_count').html(), 10) - 1);
                        } else if (data.request_approve && data.request_approve == '0') {
                            $('#accompanist_messages_li').hide();
                            $('#accompanist_members_count').html(parseInt($('#accompanist_members_count').html(), 10) - 1);
                            $("#post_box_accompanist_" + data.accompanist_id).hide();
//                            $("#unfollow_a_"+ data.accompanist_id).trigger("click");      
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').attr("onclick", "addAccompanistMember(" + data.otherid + "," + data.accompanist_id + ",'join')");
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').html('<i class="fas fa-plus"></i> Join as Accompanist');
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').removeClass('btn-white');
                            $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').addClass('btn-gradient');
                            $('#showposts').empty();
                            load_posts_again();
                        } else {
                            $('.accompanist_members_' + data.accompanist_id).children('ul').prepend('<li id="accompanist-mem-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"><div class="friends_name"><h6>' + data.other_name + '</h6></div></a></li>');
                            $('#accompanist_messages_li').show();
                            var accompanist_members_count = parseInt($('#accompanist_members_count').html(), 10);
                            accompanist_members_count += 1;
                            $('#accompanist_members_count').html(accompanist_members_count);
                        }
                    } else {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.accompanist_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<span class="icon">' +
                            '<img onclick="joinAccompanistResponse(this)" unique-text="' + data.unique_text + '" status="reject" accompanist-id="' + data.accompanist_id + '" accompanist-name="' + data.accompanist_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                            '<img onclick="joinAccompanistResponse(this)" unique-text="' + data.unique_text + '" status="approve" accompanist-id="' + data.accompanist_id + '" accompanist-name="' + data.accompanist_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                            '</span>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                    }

                    $('#notification-list-in-header').prepend(text);
                    $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').attr("onclick", "addAccompanistMember(" + data.user_id + "," + data.accompanist_id + ",'leave')");
                    $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').html('<i class="fas fa-minus"></i> Joined');
                    $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').removeClass('btn-gradient');
                    $('.append-request-accompanist-' + data.accompanist_id).children('#accompanist-request-id').addClass('btn-white');
                } else if (data.hasOwnProperty('friend_invite')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.accompanist_url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' +
                        '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="icon">' +
                        '<img onclick="inviteFriendResponse(this)" unique-text="' + data.unique_text + '" status="reject" friend-id="' + data.friend_id + '" friend-name="' + data.friend_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                        '<img onclick="inviteFriendResponse(this)" unique-text="' + data.unique_text + '" status="approve" friend-id="' + data.friend_id + '" friend-name="' + data.friend_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                        '</span>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('friend_id')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    if (data.left_notification) {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.accompanist_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        if (data.friend_response && data.friend_response == '1') {
                            //load posts again
                            $('#showposts').empty();
                            load_posts_again();
                            $('.friends_list_' + data.friend_id).children('ul').prepend('<li id="friend_' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="<?php echo asset('public/images/') ?>/' + data.user_photo + '"></a><div class="friends_name"><h6>' + data.user_name + '</h6></div></li>');
                            $(".followuser_" + data.friend_id).trigger("click");
//                            $('#friend_'+data.user_id).remove();
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.friend_id + ",'leave')");
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').html('<i class="fas fa-minus"></i> Unfriend');
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').removeClass('btn-gradient');
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').addClass('btn-white');
                        } else if (data.friend_response && data.friend_response == '0') {
                            //load posts again
                            $('#showposts').empty();
                            load_posts_again();
//                            $(".unfollowuser_"+data.friend_id).trigger("click");
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.user_id + ",'join')");
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').html('<i class="fas fa-plus"></i> Add Friend');
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').removeClass('btn-white');
                            $('.append-request-' + data.friend_id + '-' + data.user_id).children('#add-friend-btn').addClass('btn-gradient');
                        } else if (data.friend_response && data.friend_response == '2') {

                            $(".unfollowuser_" + data.friend_id).trigger("click");
                            $('.friends_list_' + data.user_id).find('#friend_' + data.other_id).remove();
                            $('.append-request-' + data.user_id + '-' + data.friend_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.user_id + ",'join')");
                            $('.append-request-' + data.user_id + '-' + data.friend_id).children('#add-friend-btn').html('<i class="fas fa-plus"></i> Add Friend');
                            $('.append-request-' + data.user_id + '-' + data.friend_id).children('#add-friend-btn').removeClass('btn-white');
                            $('.append-request-' + data.user_id + '-' + data.friend_id).children('#add-friend-btn').addClass('btn-gradient');
                        
                        } else if (data.friend_response && data.friend_response == '3') {
                            $(".unfollowuser_" + data.friend_id).trigger("click");
                            $('.friends_list_' + data.user_id).find('#friend_' + data.other_id).remove();
                            $('.append-request-' + data.other_id + '-' + data.user_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.other_id + ",'join')");
                            $('.append-request-' + data.other_id + '-' + data.user_id).children('#add-friend-btn').html('<i class="fas fa-plus"></i> Add Friend');
                            $('.append-request-' + data.other_id + '-' + data.user_id).children('#add-friend-btn').removeClass('btn-white');
                            $('.append-request-' + data.other_id + '-' + data.user_id).children('#add-friend-btn').addClass('btn-gradient');
                        }
                    } else {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.friend_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<span class="icon">' +
                            '<img onclick="addFriendResponse(this)" unique-text="' + data.unique_text + '" status="reject" friend-id="' + data.friend_id + '" friend-name="' + data.friend_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                            '<img onclick="addFriendResponse(this)" unique-text="' + data.unique_text + '" status="approve" friend-id="' + data.friend_id + '" friend-name="' + data.friend_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                            '</span>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        if (data.friend_response && data.friend_response == '1') {
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').html('<i class="fas fa-minus"></i> Unfriend');
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.friend_id + ",'leave')");
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').removeClass('btn-gradient');
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').addClass('btn-white');
                            $('.append-request-' + data.friend_id + '-' + data.other_id).children('#add-friend-btn').html('<i class="fas fa-minus"></i> Unfriend');
                            $('.append-request-' + data.friend_id + '-' + data.other_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.other_id + ",'leave')");
                            $('.append-request-' + data.friend_id + '-' + data.other_id).children('#add-friend-btn').removeClass('btn-gradient');
                            $('.append-request-' + data.friend_id + '-' + data.other_id).children('#add-friend-btn').addClass('btn-white');
                        } else {
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').attr("onclick", "addFriend(" + data.other_id + ",'leave_response')");
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').html('<i class="fas fa-minus"></i> Reject Friend Request');
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').removeClass('btn-gradient');
                            $('.append-request-' + data.other_id + '-' + data.friend_id).children('#add-friend-btn').addClass('btn-white');
                        }
                    }
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('studio_invite')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.studio_url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' +
                        '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<span class="icon">' +
                        '<img onclick="inviteStudioResponse(this)" unique-text="' + data.unique_text + '" status="reject" studio-id="' + data.studio_id + '" studio-name="' + data.studio_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                        '<img onclick="inviteStudioResponse(this)" unique-text="' + data.unique_text + '" status="approve" studio-id="' + data.studio_id + '" studio-name="' + data.studio_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                        '</span>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                } else if (data.hasOwnProperty('studio_id')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    if (data.left_notification) {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.accompanist_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        if (data.request_approve && data.request_approve == '2') {

                            if (data.type == 'user') {
                                $('#studio-student-' + data.other_id).remove();
                            } else {
                                $('#studio-teacher-' + data.other_id).remove();
                            }
                        } else if (data.request_approve && data.request_approve == '0') {
                            $("#post_box_studio_" + data.studio_id).hide();
//                            $("#unfollow_s_"+data.studio_id).trigger("click");
                            if (data.type == 'user') {
                                $('.append-request-' + data.studio_id).find('#join_as_student').remove();
                                $('.append-request-' + data.studio_id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i> Join</a>');
                                $('#join_as_student').html('Join as Student</a>');
                                $("#join_as_student").attr("onclick", "joinAsStudent(" + data.studio_id + ",'join','user')");
                                $('#joinmember').modal('hide');
                            } else if (data.type == 'teachere') {
                                $('.append-request-' + data.studio_id).find('#join_as_teacher').remove();
                                $('.append-request-' + data.studio_id).append('<a href="javascript:void(0)" id="join_studio_id" data-toggle="modal" data-target="#joinmember" class="btn btn btn-gradient btn-lg"><i class="fas fa-plus"></i> Join</a>');
                                $('#join_as_teacher').html('Join as Teacher</a>');
                                $("#join_as_teacher").attr("onclick", "joinAsTeacher(" + data.studio_id + ",'join','user')");
                                $('#joinmember').modal('hide');
                            }
                            $('#showposts').empty();
                            load_posts_again();

                        } else if (data.request_approve && data.request_approve == '3') {

                            $('#join_studio_id').remove();
                            if (data.type == 'user') {
                                $('.append-request-' + data.studio_id).append('<a href="javascript:void(0)" id="join_as_student" onclick=' + "joinAsTeacher(" + data.studio_id + ",'leave','user')" + ' class="btn btn btn-white"><i class="fas fa-minus"></i> Joined</a>');
                                $('.students_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-student-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"><div class="friends_name"><h6>' + data.other_name + '</h6></div></a></li>');
                            } else if (data.type == 'teachere') {
                                $('.append-request-' + data.studio_id).append('<a href="javascript:void(0)" id="join_as_teacher" onclick=' + "joinAsTeacher(" + data.studio_id + ",'leave','teachere')" + ' class="btn btn btn-white"><i class="fas fa-minus"></i> Joined as Teacher</a>');
                                $('.teachers_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-teacher-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"><div class="friends_name"><h6>' + data.other_name + '</h6></div></a></li>');
                            }
                            $('#showposts').empty();
                            load_posts_again();

                        } else {
                            $("#post_box_studio_" + data.studio_id).hide();
                            $("#follow_s_" + data.studio_id).trigger("click");
                            if (data.type == 'user') {
                                $('.append-request-' + data.studio_id).children('#join_as_student').html('<i class="fas fa-minus"></i> Joined');
                                $('.append-request-' + data.studio_id).children('#join_as_student').attr("onclick", "joinAsStudent(" + data.studio_id + ",'leave','user')");
                                $('.append-request-' + data.studio_id).children('#join_as_student').removeClass('btn-gradient');
                                $('.append-request-' + data.studio_id).children('#join_as_student').addClass('btn-white');
                                $('.students_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-student-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"></a></li>');
                            } else if (data.type == 'teachere') {
                                $('.append-request-' + data.studio_id).children('#join_as_teacher').attr("onclick", "joinAsTeacher(" + data.studio_id + ",'leave','teachere')");
                                $('.append-request-' + data.studio_id).children('#join_as_teacher').html('<i class="fas fa-minus"></i> Joined as Teacher');
                                $('.append-request-' + data.studio_id).children('#join_as_teacher').removeClass('btn-gradient');
                                $('.append-request-' + data.studio_id).children('#join_as_teacher').addClass('btn-white');
                                $('.teachers_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-teacher-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"></a></li>');
                            }
                            $('#showposts').empty();
                            load_posts_again();
                        }

                        $('#notification-list-in-header').prepend(text);

                    } else {
                        var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                            '<a href="' + data.studio_url + '">' +
                            '<div class="d-flex flex-column">' +
                            '<div class="media align-items-center">' +
                            '<div>' +
                            '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                            '</div>' +
                            '<div class="media-body">' +
                            '<div class="d-flex align-items-center">' +
                            '<div>' +
                            '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                            '<span class="d-block font-13">Just Now</span>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</a>' +
                            '<span class="icon">' +
                            '<img onclick="joinStudioResponse(this)" unique-text="' + data.unique_text + '" status="reject" studio-id="' + data.studio_id + '" studio-name="' + data.studio_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-close.png') ?>" />' +
                            '<img onclick="joinStudioResponse(this)" unique-text="' + data.unique_text + '" status="approve" studio-id="' + data.studio_id + '" studio-name="' + data.studio_name + '" user-id="' + data.other_id + '" src="<?php echo asset('userassets/images/icon-tick.png') ?>" />' +
                            '</span>' +
                            '<div class="ml-auto mr-2">' +
                            '<span class="notification_icon">' +
                            '<img src="' + data.notification_icon + '" />' +
                            '</span>' +
                            '</div>' +
                            '</li>';
                        $('#notification-list-in-header').prepend(text);
//                                                                                                            if (data.type == 'user'){
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_student').attr("onclick", "joinAsStudent(" + data.studio_id + ",'leave','user')");
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_student').html('<i class="fas fa-minus"></i> Joined');
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_student').removeClass('btn-gradient');
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_student').addClass('btn-white');
//                                                                                                                $('.students_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-student-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"></a></li>');
//                                                                                                            } else if (data.type == 'teachere'){
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_teacher').attr("onclick", "joinAsTeacher(" + data.studio_id + ",'leave','teachere')");
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_teacher').html('<i class="fas fa-minus"></i> Joined as Teacher');
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_teacher').removeClass('btn-gradient');
//                                                                                                                $('.append-request-' + data.studio_id).children('#join_as_teacher').addClass('btn-white');
//                                                                                                                $('.teachers_list_tab_' + data.studio_id).children('ul').prepend('<li id="studio-teacher-' + data.user_id + '"><a href="<?php echo asset('/profile_timeline/') ?>/' + data.user_id + '"><img src="' + data.photo + '"></a></li>');
//                                                                                                            }
//                                                                                                            $('#showposts').empty();
//                                                                                                            load_posts_again();
                    }

                } else if (data.hasOwnProperty('other_url')) {
                    $('#notification-list-in-header').find('.notification' + data.unique_text).remove();
                    var data_text = data.text;
                    data_text = data_text.replace(data.other_name, "");
                    var text = '<li class="notification' + data.unique_text + ' d-flex align-items-center">' +
                        '<a href="' + data.other_url + '">' +
                        '<div class="d-flex flex-column">' +
                        '<div class="media align-items-center">' +
                        '<div>' +
                        '<span class="bg_image_round  mr-2 w-50" style="background-image: url(' + data.photo + ')"></span>' +
                        '</div>' +
                        '<div class="media-body">' +
                        '<div class="d-flex align-items-center">' +
                        '<div>' +
                        '<span class="text_darkblue font-weight-bold font-16">' + data.other_name + '</span>' + data_text +
                        '<span class="d-block font-13">Just Now</span>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</a>' +
                        '<div class="ml-auto mr-2">' +
                        '<span class="notification_icon">' +
                        '<img src="' + data.notification_icon + '" />' +
                        '</span>' +
                        '</div>' +
                        '</li>';
                    $('#notification-list-in-header').prepend(text);
                }
            }
        });
        socket.on('message_send', function (data) {
            if (data.user_id == current_id) {
                if ($('#unread_messages_count').is(':empty')) {
                    $('#unread_messages_count').html('1');
                } else {
                    var unread_messages_count = parseInt($('#unread_messages_count').html());
                    $('#unread_messages_count').html(unread_messages_count + 1);
                }

                $('#new-message-dot').html('<span class="indicator rounded-circle"><span class="rounded-circle"></span></span>');
                let message = data.message;
                if (message.indexOf('ifram') !== -1) {
                    message = 'Embeded Code';
                } else {
                    if (message.length > 65) {
                        message = message.substr(0, 65) + "...";
                    }
                }
                $('#chat_user_filter_listing_li_in_header' + data.chat_id).remove();
                $('#chat_user_filter_listing_in_header').prepend(` < li id = "chat_user_filter_listing_li_in_header` + data.chat_id + `" class = "d-flex align-items-center" >
                                                                < a href = "<?= asset('messages?chat_id=') ?>` + data.chat_id + `" >
                                                                < div class = "d-flex flex-column" >
                                                                < div class = "media align-items-center" >
                                                                < div >
                                                                < span class = "bg_image_round mr-2 w-50" style = "background-image: url(` + data.photo + `)" > < /span>
                                                                                        < /div>
                                                                                        < div class = "media-body" >
                                                                                        < div class = "d-flex align-items-center" >
                                                                                        < div >
                                                                < span class = "text_darkblue font-weight-bold font-16" > ` + data.other_name + ` < /span>
                                                                                                ` + message + `
                                                                < span class = "d-block font-13" > Just Now < /span>
                                                                                                < /div>
                                                                                                < /div>
                                                                                                < /div>
                                                                                                < /div>
                                                                                                < /div>
                                                                                                < /a>
                                                                            < /li>`);
                if ($("ul#chat_user_filter_listing_in_header").children().length > 5) {
                    $('ul#chat_user_filter_listing_in_header li:eq(4)').nextAll().remove();
                }
            }
        });

        socket.on('groupmessage_send', function (data) {
            // console.log(data);
            if (data.user_id == current_id && data.other_id != current_id) {

                $('#new-message-dot').html('<span class="indicator rounded-circle"><span class="rounded-circle"></span></span>');
                let message = data.message;
                if (message.indexOf('ifram') !== -1) {
                    message = 'Embeded Code';
                } else {
                    if (message.length > 65) {
                        message = message.substr(0, 65) + "...";
                    }
                }
                var url_chat;
                if (data.chat_type == 'u') {

                    url_chat = ` <a href = "<?= asset('groupchat?chat_group_id=') ?>` + data.chat_id + `" > `;
                    if ($('#unread_messages_count_friends').is(':empty')) {
                        $('#unread_messages_count_friends').html('1');
                    } else {
                        var unread_messages_count = parseInt($('#unread_messages_count_friends').html());
                        $('#unread_messages_count_friends').html(unread_messages_count + 1);
                    }
                } else if (data.chat_type == 's') {

                    url_chat = ` <a href = "<?= asset('student_studio_messages') ?>/` + data.chat_type_id + `?chat_studio_id=` + data.chat_id + `" > `;
                    if ($('#unread_messages_count').is(':empty')) {
                        $('#unread_messages_count').html('1');
                    } else {
                        var unread_messages_count = parseInt($('#unread_messages_count').html());
                        $('#unread_messages_count').html(unread_messages_count + 1);
                    }
                } else if (data.chat_type == 't') {

                    url_chat = ` <a href = "<?= asset('teacher_studio_messages') ?>/` + data.chat_type_id + `?chat_studio_id=` + data.chat_id + `" > `;
                    if ($('#unread_messages_count').is(':empty')) {
                        $('#unread_messages_count').html('1');
                    } else {
                        var unread_messages_count = parseInt($('#unread_messages_count').html());
                        $('#unread_messages_count').html(unread_messages_count + 1);
                    }

                } else if (data.chat_type == 'g') {

                    url_chat = ` <a href = "<?= asset('event_messages') ?>/` + data.chat_type_id + `?chat_event_id=` + data.chat_id + `" > `;
                    if ($('#unread_messages_count_event').is(':empty')) {
                        $('#unread_messages_count_event').html('1');
                    } else {
                        var unread_messages_count = parseInt($('#unread_messages_count_event').html());
                        $('#unread_messages_count_event').html(unread_messages_count + 1);
                    }
                } else if (data.chat_type == 'a') {
                    url_chat = ` <a href = "<?php echo asset('accompanist_messages') ?>/` + data.chat_type_id + `?chat_accompanist_id=` + data.chat_id + `" > `;
                    if ($('#unread_messages_count_accompanist').is(':empty')) {
                        $('#unread_messages_count_accompanist').html('1');
                    } else {
                        var unread_messages_count = parseInt($('#unread_messages_count_accompanist').html());
                        $('#unread_messages_count_accompanist').html(unread_messages_count + 1);
                    }
                }
                $('#chat_user_filter_listing_li_in_header' + data.chat_id).remove();

                $('#chat_user_filter_listing_in_header').prepend(`<li id="chat_user_filter_listing_li_in_header` + data.chat_id + `" class="d-flex align-items-center">
                                                                                    ` + url_chat + `
                                                                                        <div class="d-flex flex-column">
                                                                                            <div class="media align-items-center">
                                                                                                <div>
                                                                                                    <span class="bg_image_round mr-2 w-50" style="background-image: url(` + data.photo + `)"></span>
                                                                                                </div>
                                                                                                <div class="media-body">
                                                                                                    <div class="d-flex align-items-center">
                                                                                                        <div>
                                                                                                            <span class="text_darkblue font-weight-bold font-16">` + data.other_name + `</span>
                                                                                                            ` + message + `
                                                                                                            <span class="d-block font-13">Just Now</span>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </a>
                                                                                </li>`);
                if ($("ul#chat_user_filter_listing_in_header").children().length > 5) {
                    $('ul#chat_user_filter_listing_in_header li:eq(4)').nextAll().remove();
                }
            }
        });

        $('#create_event_f').validate({
            //        onfocusout: false,
            //        onkeyup: false,
            //        onclick: false,
            submitHandler: function () {
                addGig();
            }
        });

        function addGig() {
            //        fail;
            $('#create_gig_loader').show();
            $form = $('#create_event_f');
            // $(this).attr('disabled', true);
            var formData = new FormData($form[0]);
            //pick form data
            $.ajax({
                type: "POST",
                url: base_url + '/timeline',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    $('#create_gig_loader').hide();
                    if (data.success) {
                        $('.ajax-response').show();
                        $('.ajax-response').removeClass('alert-danger');
                        $('.ajax-response').addClass('alert-success');
                        $('.ajax-response').html(data.message);
                        $form[0].reset();
                        setTimeout(function () {
                            window.location.href = base_url + 'events';
                        }, 2000);
                    } else {
                        $('.ajax-response').show();
                        $('.ajax-response').removeClass('alert-success');
                        $('.ajax-response').addClass('alert-danger');
                        $('.ajax-response').html(data.message);
                    }

                    $("html, .modal").animate({
                        scrollTop: 0
                    }, 600);
                }
            });
        }

        function descriptionCountCharToMax(val, len) {
            var max = len;
            var min = 0;
            var len = val.value.length;
            if (len >= max) {
                val.value = val.value.substring(min, max);
                $('#gig_description').text(+max - len + ' characters');
            } else {
                $('#gig_description').text(+max - len + ' characters');
            }
        }

        function titleCountCharToMax(val, len) {
            var max = len;
            var min = 0;
            var len = val.value.length;
            if (len >= max) {
                val.value = val.value.substring(min, max);
                $('#gig_title').text(+max - len + ' characters');
            } else {
                $('#gig_title').text(+max - len + ' characters');
            }
        }

        function addBookmark(group_id) {
            $.ajax({
                type: "POST",
                url: "<?= asset('bookmark_group'); ?>",
                data: {
                    group_id: group_id,
                    is_bookmarked: 1,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message == 'success') {
                        $("#add-bookmark-btn-" + group_id).css("display", "none");
                        $("#remove-bookmark-btn-" + group_id).css("display", "block");
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function removeBookmark(group_id) {
            $.ajax({
                type: "POST",
                url: "<?= asset('bookmark_group'); ?>",
                data: {
                    group_id: group_id,
                    is_bookmarked: 0,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message == 'success') {
                        $("#add-bookmark-btn-" + group_id).css("display", "block");
                        $("#remove-bookmark-btn-" + group_id).css("display", "none");
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function addBookmarkStudio(teaching_studio_id) {
            $.ajax({
                type: "POST",
                url: "<?= asset('bookmark_teaching_studio'); ?>",
                data: {
                    teaching_studio_id: teaching_studio_id,
                    is_bookmarked: 1,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message == 'success') {
                        $("#add-bookmark-btn-studio-" + teaching_studio_id).css("display", "none");
                        $("#remove-bookmark-btn-studio-" + teaching_studio_id).css("display", "block");
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        function removeBookmarkStudio(teaching_studio_id) {
            $.ajax({
                type: "POST",
                url: "<?= asset('bookmark_teaching_studio'); ?>",
                data: {
                    teaching_studio_id: teaching_studio_id,
                    is_bookmarked: 0,
                    "_token": '<?= csrf_token() ?>'
                },
                success: function (response) {
                    if (response.message == 'success') {
                        $("#add-bookmark-btn-studio-" + teaching_studio_id).css("display", "block");
                        $("#remove-bookmark-btn-studio-" + teaching_studio_id).css("display", "none");
                    } else {
                        $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                    }
                }
            });
        }

        $(window).on('unload', function () {
            $.ajax({
                url: "<?= asset('offline_user') ?>",
                type: "GET",
                data: {
                    "user_id": '<?= $current_id ?>',
                },
            });
        });
    </script>
<?php } ?>

<script>
    $('#search_field_clear_btn').click(function () {
        $(this).hide();
        $('#search_box').val('');
    });

    $('#search_box').keyup(function () {
        if ($(this).val().length > 0) {
            console.log('greater');
            $(this).parents('.search_input').find('.clear_form').show();
        } else {
            console.log('less');
            $(this).parents('.search_input').find('.clear_form').hide();
        }
    });

    $(document).on('keydown.autocomplete', '#search_box', function () {
        search_type = 'musicians';
        <?php if ($segment != 'search') { ?>
        search_type = $('#specialization_header').val();
        <?php } ?>
        $('#search_box').autocomplete({
            source: '<?= asset('autoCompleteSearch'); ?>?search_type=' + search_type
        });
    });

    $('#search_box').autocomplete({
        source: '<?= asset('autoCompleteSearch'); ?>',
        select: function (event, ui) {
            if (ui == null || ui.item == null) {
                return false;
            }
            window.location = ui.item.url;
        },
        focus: function (event, ui) {

            event.preventDefault();
            if (ui == null || ui.item == null) {
                return false;
            }
            $("#search_box").attr('value', ui.item.name);
            $("#search_box").val(ui.item.name);
        },
        change: function (event, ui) {
            event.preventDefault();
            if (ui == null || ui.item == null) {
                return false;
            }
            $("#search_box").attr('value', ui.item.name);
            // $("#search_box").attr('placeholder',ui.item.title.trim() + "-" + ui.item.description.trim());
            $("#search_box").val(ui.item.name);
        }
    }).autocomplete("instance")._renderItem = function (ul, item) {

        ul.addClass('search-result-dropdown'); //Ul custom class here
        if (item == null) {
            return false;
        }
        var base_url = '<?= asset('/') ?>';
        if (item.search_type == 'musicians') {
            var url = '<?= asset('profile_timeline') ?>';
            profile_image = base_url + 'public/images/profile_pics/demo.png';
            if (item.photo) {
                profile_image = base_url + 'public/images/' + item.photo;
            } else if (item.social_photo) {
                profile_image = item.social_photo;
            } else if (item.gender) {
                if (item.gender == 'male')
                    profile_image = base_url + 'public/images/profile_pics/demo.png';
                else if (item.gender == 'female')
                    profile_image = base_url + 'public/images/profile_pics/fdemo.png';
            }
        } else if (item.search_type == 'groups') {
            var url = '<?= asset('group_time_line') ?>';
            profile_image = base_url + 'public/images/profile_pics/demo.png';
            if (item.photo) {
                profile_image = base_url + 'public/images/' + item.photo;
            }
        } else if (item.search_type == 'teaching_studios') {
            var url = '<?= asset('teaching_studio_time_line') ?>';
            profile_image = base_url + 'public/images/profile_pics/demo.png';
            if (item.photo) {
                profile_image = base_url + 'public/images/' + item.photo;
            }
        } else if (item.search_type == 'accompanists') {
            var url = '<?= asset('accompanist_time_line') ?>';
            profile_image = base_url + 'public/images/profile_pics/demo.png';
            if (item.photo) {
                profile_image = base_url + 'public/images/' + item.photo;
            }
        }
        var html = "<div><a href='" + url + "/" + item.id + "' class='d-flex align-items-center'>";
        html += "<span class='bg_image_round w-40 mr-2' style=\"background-image: url('" + profile_image + "')\"></span>";
        html += item.name + "</a></div>";
        return $("<li></li>")
            .data("item.autocomplete", item)
            .append(html)
            .appendTo(ul);
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyApyIRH_zIWZT32AXvIU2A2Y-A0fvPSv50&libraries=places&callback=initAutocomplete"
        async defer></script>

<script>
    // search and refer friends form list
    function searchFriendFromList() {

        var input, filter, div, column, a, i, txtValue;
        input = document.getElementById("searchContent");
        filter = input.value.toUpperCase();
        div = document.getElementById("friend_list");
        column = div.getElementsByClassName("collaborative-body-column");
        for (i = 0; i < column.length; i++) {
            a = column[i].getElementsByTagName("p")[0];
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                column[i].parentNode.style.display = "";
            } else {
                column[i].parentNode.style.display = "none";
            }
        }
    }

    $(document).ready(function () {

        // allow user to add multiple peoples
        $('#group_bulk_messages' +<?= $current_id ?>).select2({
            allowClear: true,
            width: 'resolve',
            minimumResultsForSearch: Infinity,
            placeholder: "Select Friends",
        });
        // allow user to add multiple peoples
        $('#group_bulk_messages').select2({
            allowClear: true,
            width: 'resolve',
            minimumResultsForSearch: Infinity,
            placeholder: "Select Friends",
        });
        // select all or unselect while select people for refer
        var clicked = false;
        $("#select_list").on("click", function () {
            $(".member_list").prop("checked", !clicked);
            clicked = !clicked;
        });
//        $(document).on('change', '.btn-file :file', function() {
//            
//        var input = $(this),
//            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
//        input.trigger('fileselect', [label]);
//        });

//        $('.btn-file :file').on('fileselect', function(event, label) {
//
//            var input = $(this).parents('.input-group').find(':text'),
//                log = label;
//                
//
//            if( input.length ) {
//                input.val(log);
//            } else {
//                if( log );
//            }
//
//        });
//        function readURL(input) {
//            if (input.files && input.files[0]) {
//                console.log(input.files);
//                var reader = new FileReader();
//
//                reader.onload = function (e) {
//                    // $('#img-upload').attr('src', e.target.result);
//                    $('.tag_image').css('background-image', 'url('+e.target.result+')');
//                }
//                
//                reader.readAsDataURL(input.files[0]);
//            }
//        }
//
//        $("#imgInp").change(function(){    
//            
//        readURL(this);
//            
//        });
    });

</script>



