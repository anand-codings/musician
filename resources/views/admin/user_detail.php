<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <?= $userType == "user" ? "User Detail" : "Musician Detail" ?>
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">

                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6">

                            <!-- Profile Image -->
                            <div class="box box-primary">
                                <div class="box-body box-profile">
                                    <?php
                                    $image = getUserImage($user->photo, $user->social_photo,  $user->gender);
                                    ?>
                                    
                                    <img class="profile-user-img img-responsive img-circle" src="<?= $image ?>" alt="User profile picture">

                                    <h3 class="profile-username text-center"><?= $user->first_name . ' ' . $user->last_name ?></h3>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Email</b> <p class="pull-right"><?= $user->email ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Language</b> <p class="pull-right"><?= $user->language ? $user->language : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Gender</b> <p class="pull-right"><?= $user->gender ? $user->gender : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Description</b> <p class="<?= $user->description ? '' : 'pull-right' ?>"><?= $user->description ? $user->description : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Country</b> <p class="pull-right"><?= $user->country ? $user->country : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>City</b> <p class="pull-right"><?= $user->city ? $user->city : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Address</b> <p class="pull-right"><?= $user->address ? $user->address : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Zip Code</b> <p class="pull-right"><?= $user->zip_code ? $user->zip_code : 'N/A' ?></p>
                                        </li>

                                        <li class="list-group-item">
                                            <b>Phone</b> <p class="pull-right"><?= $user->phone ? $user->phone : 'N/A' ?></p>
                                        </li>
<!--                                        <li class="list-group-item">
                                            <b>Time zone</b> <p class="pull-right"><? = $user->timezone ? $user->timezone : 'N/A' ?></p>
                                        </li>-->
<!--                                        <li class="list-group-item">
                                            <b>Date of Birth</b> <p class="pull-right"><?= $user->dob ? $user->dob : 'N/A' ?></p>
                                        </li>-->
                                        <li class="list-group-item">
                                            <b>Last Login</b> <p class="pull-right"><?= $user->last_login ? $user->last_login : 'N/A' ?></p>
                                        </li>
                                        <?php if ($userType == "artist") { ?>
                                            <li class="list-group-item">
                                                <b>Category</b> 
                                                <p class="pull-right">
                                                    <?php
                                                    if (!$user->getSelectedCategories->isEmpty()) {
                                                        $getSelectedArtistTypesCount = $user->getSelectedCategories->count();
                                                        $i = 2;
                                                        foreach ($user->getSelectedCategories as $selectedArtistType) {
                                                            echo $selectedArtistType->getCategory->title;
                                                            if ($getSelectedArtistTypesCount >= $i) {
                                                                echo ', ';
                                                            }
                                                            $i++;
                                                        }
                                                    } else {
                                                        ?>
                                                        N/A
                                                    <?php } ?>
                                                </p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Professional Since</b> <p class="pull-right"><?= $user->since ? $user->since : 'N/A' ?></p>
                                            </li>
                                            <li class="list-group-item">
                                                <b>Gigs Availability</b> <p class="pull-right"><?= $user->gigs_availability ? 'Yes' : 'No' ?></p>
                                            </li>                                                                                
                                        <?php } ?>
<!--                                        <li class="list-group-item">
                                            <b>Followers</b> <p class="pull-right"><?= $user->getFollowers->count() ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Following</b> <p class="pull-right"><?= $user->getFollowings->count() ?></p>
                                        </li>-->

                                        <li class="list-group-item">
                                            <strong><i class="fa fa-book margin-r-5"></i> Education</strong>
                                            <?php if(!$user->getEducations->isEmpty()) { ?>
                                                <ul class="list-group">
                                                    <?php foreach($user->getEducations as $education) { ?>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <b><?=$education->title?></b>                                                                
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <span class="font-weight-bold"><?=$education->start_year?> - <?=$education->end_year?></span>
                                                                </div>
                                                            </div>
                                                            <div class="text_grey">
                                                                <p><?=$education->institute_name?></p> 
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>                                            
                                            <?php } else { ?>
                                                <p class="pull-right">N/A</p>
                                            <?php } ?>
                                        </li>

                                        <li class="list-group-item">
                                            <strong><i class="fa fa-briefcase margin-r-5"></i> Experiences</strong>
                                            <?php if(!$user->getExperiences->isEmpty()) { ?>
                                                <ul class="list-group">
                                                    <?php foreach($user->getExperiences as $experience) { ?>
                                                        <li class="list-group-item">
                                                            <div class="row">
                                                                <div class="col-sm-7">
                                                                    <b><?=$experience->title?></b>                                                                
                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <span class="font-weight-bold"><?=$experience->start_year?> - <?=$experience->end_year?></span>
                                                                </div>
                                                            </div>
                                                            <div class="text_grey">
                                                                <p><?=$experience->institute_name?></p> 
                                                            </div>
                                                        </li>
                                                    <?php } ?>
                                                </ul>                                            
                                            <?php } else { ?>
                                                <p class="pull-right">N/A</p>
                                            <?php } ?>
                                        </li>
                                        
                                        <?php if($userType == "artist") { ?>
                                            <li class="list-group-item">
                                                <strong><i class="fa fa-shield margin-r-5"></i> Affiliations</strong>
                                                <?php if(!$user->getAffiliations->isEmpty()) { ?>
                                                    <ol>
                                                        <?php foreach($user->getAffiliations as $affiliation) { ?>
                                                        <li>
                                                            <p><?=$affiliation->union->title?></p>                                                                
                                                        </li>
                                                        <?php } ?>
                                                    </ol>                                            
                                                <?php } else { ?>
                                                    <p class="pull-right">N/A</p>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <!-- /.row -->

                </section>
                <!-- /.content -->
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
