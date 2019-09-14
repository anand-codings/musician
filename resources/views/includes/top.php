<?php
$current_id = '';
$current_name = '';
$current_user = '';
$current_user_type = '';
$current_photo = '';
$current_email = '';
$segment = Request::segment(1);
if (Auth::user()) {
    $current_id = Auth::user()->id;
    $current_email = Auth::user()->email;
    $current_name = Auth::user()->first_name . ' ' . Auth::user()->last_name;
    $current_user = Auth::user();
    $current_user_type = Auth::user()->type;
    $current_photo = getUserImage($current_user->photo, $current_user->social_photo, $current_user->gender);
}
?>
<head>
    <?php if (isset($og_image)) { ?>
        <meta property="og:image" content="<?php echo $og_image ?>" />

    <?php } ?>

    <?php if (isset($og_title)) { ?>
        <meta property="og:title" content="<?php echo $og_title ?>" />

    <?php } ?>

    <?php if (isset($og_description)) { ?>
        <meta property="og:description" content="<?php echo $og_description ?>" />
    <?php } ?>
    <title> <?= $title ?> </title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?= csrf_token(); ?>">
    <link rel="icon" href="<?php echo asset('userassets/images/favicon.png') ?>" type="image/gif" sizes="16x16">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Titillium+Web:300,400,600,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700">

    <link rel="stylesheet" type="text/css" href="<?= asset('userassets/css/jWindowCrop.css') ?>" media="screen"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/bootstrap.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/bootstrap-datetimepicker.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/select2.min.css') ?>"/>
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.mCustomScrollbar.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/croppie.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/owl.carousel.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/all.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.rateyo.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/jquery.fancybox.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/ion.rangeSlider.css') ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="<?php echo asset('userassets/css/scss/style.css') ?>" />

    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="<?php echo asset('userassets/js/select2.min.js') ?>"></script>
    <style>
        
          #youtube_modal_body {
            max-height: 400px;
            overflow: auto;
        }
         #youtube_modal_body .youtube_search_listing{
           display:-webkit-box;
            display:-ms-flexbox;
            display:flex;
             -webkit-box-align:center;
                 -ms-flex-align:center;
                     align-items:center;
             -webkit-box-orient:horizontal;
             -webkit-box-direction:reverse;
                 -ms-flex-direction:row-reverse;
                     flex-direction:row-reverse;
             -webkit-box-pack: end;
                 -ms-flex-pack: end;
                     justify-content: flex-end;
                         cursor: pointer;
                            -webkit-transition: all 0.35s ease;
                -o-transition: all 0.35s ease;
                transition: all 0.35s ease;
         }
         #youtube_modal_body .youtube_search_listing:hover {
                background: #f1eeee;
                -webkit-transition: all 0.35s ease;
                -o-transition: all 0.35s ease;
         }
    </style>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script> 
<script>
    var socket = io('<?= env('SOCKETS') ?>');
    base_url = "<?php echo asset('/'); ?>"
</script>
