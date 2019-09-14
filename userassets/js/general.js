$(document).ready(function () {
//    $('body').on('keyup','#descriptin_count_f',function(){
//        limit = 300;
//        $this = $(this);
//        var value = $this.val();
//        var len = value.length;
//        if (len >= limit) {
//
//            $this.value = val.value.substring(0, limit);
//        } else {
//            $this.parent().find('.text_length_desc').text(limit - len);
//
//        }
//    });

//    $('body').on('keyup','#title_count_f',function(){
//        limit = 150;
//        $this = $(this);
//        var value = $this.val();
//        var len = value.length;
//        if (len >= limit) {
//
//            $this.value = $this.value.substring(0, limit);
//        } else {
//            $('.text_length_title').text(limit - len);
//
//        }
//    });

//    $('body').on('click', '.btn_create_event_f', function (e) {
        function addGig(){
//        fail;
        $form = $('#create_event_f');
       // $(this).attr('disabled', true);
        var formData = new FormData($form[0]);
        //pick form data
        $.ajax({
            type: "POST",
            url: base_url+'/timeline',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.success) {
                    $('.ajax-response').show();
                    $('.ajax-response').removeClass('alert-danger');
                    $('.ajax-response').addClass('alert-success');
                    $('.ajax-response').html(data.message);
                    $form[0].reset();
                    setTimeout(function(){
                        window.location.href = base_url + '/events';
                    }, 2000);
                } else {
                    $('.ajax-response').show();
                    $('.ajax-response').removeClass('alert-success');
                    $('.ajax-response').addClass('alert-danger');
                    $('.ajax-response').html(data.message);
                }
                $("html, .modal").animate({scrollTop: 0}, 600);
            }
        });
        }
//    });
$('body').on('focus','#autofill_location',function(){
    $("#autofill_location")
        .geocomplete()
        .bind("geocode:result", function (event, result) {
            $("#lat").val(result.geometry.location.lat());
            $("#lng").val(result.geometry.location.lng());
        });
});

$('body').on('focus','.autofill_location',function(){
    $(this).geocomplete();
});
    
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview_event_img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('body').on('change','#cover_image_f',function(){
        $('.events_pic').show();
        $('.upload_image').hide();
        readURL(this);
    });
    
//    function readURLForEdit(input, id) {
//        if (input.files && input.files[0]) {
//            var reader = new FileReader();
//            reader.onload = function (e) {
//                $('#preview_event_img').attr('src', e.target.result);
//            }
//            reader.readAsDataURL(input.files[0]);
//        }
//    }
//    $('body').on('change','#cover_image_f',function(){
//        $('.events_pic').show();
//        $('.upload_image').hide();
//        readURL(this);
//    });

    $('#create_event_modal').on('hidden.bs.modal', function () {
        $('.events_pic').hide();
        $('#create_event_f')[0].reset();

    });
//    $(".year-picker").datepicker({
//        changeMonth: true,
//        changeYear: true,
//        showButtonPanel: true,
//        dateFormat: 'yy',
//        onClose: function(dateText, inst) { 
//            var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
//            var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
//            $(this).datepicker('setDate', new Date(year, month, 1));
//        }
//    });
    $(".date-picker").datepicker({
        dateFormat: "DD, MM d, yy",
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
        minDate:0,
        yearRange: "-150:+0"
    });
    $(".date-picker-past").datepicker({
        dateFormat: "DD, MM d, yy",
        changeYear: true,
        changeMonth: true,
        showButtonPanel: true,
        maxDate:0,
        yearRange: "-150:+0"
    });
    if ( $('input[type="time"]').prop('type') != 'time' ) {
        $('input[type="time"]').timepicker({
            timeFormat: 'h:i a',
            dropdown: false
        });
    }
});
 jQuery.validator.addMethod("phone", function (phone_number, element) {
                phone_number = phone_number.replace(/\s+/g, "");
                return this.optional(element) || phone_number.length > 0 &&
                        phone_number.match(/^((\+)?[1-9]{1,2})?([-\s\.])?((\(\d{1,4}\))|\d{1,4})(([-\s\.])?[0-9]{1,12}){1,2}$/);
            }, "Please enter a valid phone number");
function validateForm() {
    $('.edit_user_form').each(function () {
        $(this).validate({
//            onfocusout: false,
//            onkeyup: false,
//            onclick: false,
            rules: {    
                    phone: {
                        phone: true
                    }
                }
        });
    });
}
validateForm();
$('#delete-profile-pic').click(function () {
    var userId = $(this).attr('user-id');
    $.ajax({
        type: "POST",
        url: base_url + "delete_profile_pic",
        data: {'user_id': userId},
        beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        }
    });
    $('#profile-pic-div').css("background-image", "url("+base_url+"/public/images/profile_pics/demo.png)");
});
$('#delete-cover-pic').click(function () {
    var userId = $(this).attr('user-id');
    $.ajax({
        type: "POST",
        url: base_url + "delete_cover_pic",
        data: {'user_id': userId},
        beforeSend: function (request) {
            return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        }
    });
    $('#cover-pic-div').css("background-image", "url("+base_url+"/public/images/profile_pics/cover_photo_demo.jpg)");
});
function seeAllPostData(ele){
    $(ele).prev('.elipsis').css('display', 'none');
    $(ele).toggle();
    $(ele).next('.see_all_post_data').toggle();
}
