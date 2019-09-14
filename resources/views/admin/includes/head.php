    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $title ?></title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="<?= csrf_token() ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/bootstrap/dist/css/bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/font-awesome/css/font-awesome.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/Ionicons/css/ionicons.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/all.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= asset('adminassets/dist/css/skins/skin-blue.css') ?>">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.min.css">
<!--    <link rel="stylesheet" href="<? = asset('adminassets/plugins/iCheck/square/blue.css') ?>">-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <script src="<?= asset('adminassets/bower_components/jquery/dist/jquery.min.js') ?>"></script>
    <link rel="shortcut icon" type="image/png" href="<?= asset('adminassets/images/favicon.png') ?>"/>
</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/1.5.1/socket.io.min.js"></script> 
<script>
    var socket = io('<?= env('SOCKETS')?>');
    base_url = "<?php echo asset('/'); ?>";
</script>
