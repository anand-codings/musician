<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
<?php include resource_path('views/includes/top.php'); ?>

<body class="pt-0">
    <div class="loginpage flex-column justify-content-center signup_user_bg">
        <div class="login_pageheader">
            <div class="container">
                <a href="<?php echo asset('/'); ?>" class="d-inline-block">
                    <svg xmlns="http://www.w3.org/2000/svg" width="166" height="42" viewBox="0 0 166 42">
                        <path id="music" fill="#fff" class="cls-1" d="M37.4,32.914V14.5H37.93l4.655,17.36h4.83L52.07,14.5h0.525v18.41h4.83V9.114H49.2L45,26.474,40.8,9.114H32.575v23.8H37.4ZM72.48,28.5l-0.455.14a8.523,8.523,0,0,1-2.905.49,1.979,1.979,0,0,1-2.03-.945,9.937,9.937,0,0,1-.42-3.535v-9.24H61.98v9.17q0,4.725,1.26,6.738t4.9,2.012a9.35,9.35,0,0,0,4.375-1.4v0.98H77.17v-17.5H72.48V28.5ZM93.79,15.9l-1.155-.21A32.727,32.727,0,0,0,87,15.029a7.892,7.892,0,0,0-4.865,1.418,4.919,4.919,0,0,0-1.89,4.2q0,2.782,1.33,3.867a8.656,8.656,0,0,0,4.043,1.54,16.757,16.757,0,0,1,3.36.77,1.033,1.033,0,0,1,.647.98,1.071,1.071,0,0,1-.612,1,5.419,5.419,0,0,1-2.31.332,55.742,55.742,0,0,1-6.037-.56l-0.14,3.92,1.12,0.21a30.542,30.542,0,0,0,5.6.63q7.035,0,7.035-5.67a5.045,5.045,0,0,0-1.19-3.745,7.705,7.705,0,0,0-4.008-1.663,26.607,26.607,0,0,1-3.5-.77,0.95,0.95,0,0,1-.682-0.945,1.087,1.087,0,0,1,.507-1,5.016,5.016,0,0,1,2.24-.315,55.845,55.845,0,0,1,6.072.56Zm9.055,17.01v-17.5h-4.69v17.5h4.691Zm0-19.74V8.414h-4.69v4.76h4.691Zm5.22,3.973q-1.752,2.153-1.75,6.983t1.7,7.017q1.7,2.188,5.583,2.188a32.249,32.249,0,0,0,5.7-.735l-0.14-3.745-4.06.28q-2.451,0-3.238-1.067a7.025,7.025,0,0,1-.787-3.937q0-2.869.787-3.9t3.2-1.033q1.329,0,4.095.28l0.14-3.71-0.945-.21a25.055,25.055,0,0,0-4.655-.56Q109.815,14.994,108.065,17.147Zm19.78,15.767v-17.5h-4.69v17.5h4.69Zm0-19.74V8.414h-4.69v4.76h4.69Zm16.227,3.22q-1.488-1.4-4.865-1.4a27.24,27.24,0,0,0-7.122,1.015l0.14,3.255,6.58-.28a2.484,2.484,0,0,1,1.575.4,1.853,1.853,0,0,1,.49,1.487v1.085l-3.745.28a8.432,8.432,0,0,0-4.62,1.383Q131,24.795,131,27.594q0,5.741,5.425,5.74a11.652,11.652,0,0,0,5.145-1.225,6.4,6.4,0,0,0,2.152.98,13.28,13.28,0,0,0,2.853.245l0.14-3.535a1.3,1.3,0,0,1-.875-0.473,2.779,2.779,0,0,1-.28-1.172v-7.28A5.911,5.911,0,0,0,144.072,16.394Zm-3.2,8.82v3.745l-0.525.14a11.339,11.339,0,0,1-2.905.42q-1.716,0-1.715-1.925a1.9,1.9,0,0,1,1.96-2.1Zm13.975-5.39,0.42-.14a7.931,7.931,0,0,1,2.765-.49,2.108,2.108,0,0,1,2.1,1.068,7.874,7.874,0,0,1,.525,3.307v9.345h4.69V23.429q0-4.3-1.33-6.37t-4.83-2.065a8.768,8.768,0,0,0-4.375,1.4v-0.98h-4.655v17.5h4.69V19.824ZM17.935,34.973L12.414,42c-1.8-2.314-3.462-4.359-4.992-6.5a3.315,3.315,0,0,1-.363-2c0.067-1.133.315-2.256,0.5-3.5-1.336-.732-2.723-1.351-3.952-2.193C1.174,26.143-.273,23.907.046,20.849a6.942,6.942,0,0,1,2.37-4.628,49.946,49.946,0,0,1,4.532-3.312c0.877-.6,1.833-1.094,2.9-1.72C10,9.638,10.136,8.065,10.325,6.5A23.156,23.156,0,0,1,10.9,2.844c0.82-2.835,4.922-3.818,7.042-1.712a2.868,2.868,0,0,1,.812,3.394A31.785,31.785,0,0,1,16.485,8.4a20.811,20.811,0,0,1-1.907,2.14q1.125,8.344,2.283,16.937c5.237-2.281,6.157-6.6,2.428-10.215-0.868-.841-1.874-1.545-3.263-2.677C19.41,15.2,21.9,16.279,23.713,18.5c1.41,1.729,1.8,3.76.473,5.653a18.607,18.607,0,0,1-3.494,3.589,25.712,25.712,0,0,1-3.553,2.085ZM9.66,13.888c-3.728,1.465-5.925,4.517-5.746,7.8a5.8,5.8,0,0,0,4.05,5.5Zm4.506-5.22c1.726-1.964,2.715-3.541,2.631-5.6a1.526,1.526,0,0,0-1.624-1.694,1.4,1.4,0,0,0-1.43,1.583C13.783,4.669,13.985,6.373,14.166,8.668Z" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="login_box sign_up">
                        <div class="l_l_side">
                            <div class="pt-5">

                                <h3>Sign up as Musician?</h3>
                                <p class="pt-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                    incididunt ut labore et dolore magna aliqua. </p>
                                <button class="btn btn-gradient mt-4"><a href="<?=asset('musician-register')?>"> Get Started</a></button>
                            </div>
                        </div>
                        <div class="l_r_side py-5">
                            <figure class="pb-4"><img width="60px" class="img-fluid" src="<?php echo asset('userassets/images/signup_user.png'); ?>"></figure>
                            <h3>Signup as <strong>User</strong></h3>
                            <p class="pt-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry. </p>
                            <button class="btn btn-gradient mt-4 px-5"><a href="<?=asset('register')?>"> Get Started</a></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include resource_path('views/includes/footer.php'); ?>
    <script src="<?php echo asset('userassets/js/jquery.validate.js') ?>"></script>
    <script src="<?php echo asset('userassets/js/additional-methods.js') ?>"></script>
    <script src="<?php echo asset('userassets/js/jquery.validate.min.js') ?>"></script>
    <script src="<?php echo asset('userassets/js/additional-methods.min.js') ?>"></script>
    <style>
        input.error {
            border: solid 1px red !important;
        }

        #userregister checkbox.error {
            background-color: red;
        }

        #userregister label.error {
            width: auto;
            display: inline;
            color: red;
            font-size: 16px;
            float: right;
        }
    </style>

</body>

</html>