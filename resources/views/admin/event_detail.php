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
                        Event Detail
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
                                    <div style="background: url(<?=$event->image?>); background-position: center;background-repeat: no-repeat;background-size: cover; height: 250px;"></div>

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>Title</b> <p class="pull-right"><?= $event->title ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Description</b> <p class="<?= $event->description ? '' : 'pull-right' ?>"><?= $event->description ? $event->description : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Time</b> <p class="pull-right"><?= $event->utc_date_time ? date_format(new DateTime($event->utc_date_time), 'g:ia \o\n l jS F Y') : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Price</b> <p class="pull-right"><?= $event->price ? '$'.$event->price.' / '.$event->per_unit.' '.$event->unit->title : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Location</b> <p class="pull-right"><?= $event->location ? $event->location : 'N/A' ?></p>
                                        </li>

                                        <li class="list-group-item">
                                            <b>Range</b> <p class="pull-right"><?= $event->range ? $event->range : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Status</b> <p class="pull-right"><?= $event->status ? $event->status : 'N/A' ?></p>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Custom Booking</b> <p class="pull-right"><?= $event->custom_booking ? $event->custom_booking : 'N/A' ?></p>
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
