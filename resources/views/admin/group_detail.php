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
                        Event Service Detail
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
                                    <div style="background: url(<?=asset('public/images/'.$group->cover)?>); background-position: center;background-repeat: no-repeat;background-size: cover; height: 250px;"></div>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Title</b> <p class="pull-right"><?= $group->title ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Description</b> <p class="<?= $group->description ? '' : 'pull-right' ?>"><?= $group->description ? $group->description : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Since</b> <p class="pull-right"><?= $group->since ? $group->since : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Booking Allowed</b> <p class="pull-right"><?= $group->allow_booking ? 'Yes' : 'No' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Location</b> <p class="pull-right"><?= $group->location ? $group->location : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Created By</b> <p class="pull-right"><a href="<?=asset('user_detail_admin/'.$group->user->id)?>"><?=$group->user->first_name.' '.$group->user->last_name?></a></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Specialization</b> <p class="pull-right"><?= $group->getCategory ? $group->getCategory->title : 'N/A' ?></p>
                                        </li>
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
