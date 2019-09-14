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
                        Statistics
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Statistics</h3>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <?php if (Session::has('success')) { ?>
                                        <div class="alert alert-success">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('success') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if (Session::has('error')) { ?>
                                        <div class="alert alert-danger">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                            <?php echo Session::get('error') ?>
                                        </div>
                                    <?php } ?>
                                    <?php if ($errors->any()) { ?>
                                        <div class="alert alert-danger">
                                            <ul>
                                                <?php foreach ($errors->all() as $error) { ?>
                                                    <li><?= $error ?></li>
                                                <?php }
                                                ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                    <div class="row"><div class="col-md-12">
                            <canvas id="followers-statistics-graph"></canvas>
                            <canvas id="gigs-statistics-graph"  class="d-none"></canvas>
                            <canvas id="reviews-statistics-graph" class="d-none"></canvas>
                            <canvas id="profile-statistics-graph" class="d-none"></canvas>
                                    </div>
                                    </div>
                            <label>Last 12 days</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="final_stats hover active" id="followers-statistics">
                                        <div class="label">Events</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $groups ? thousandsNumberFormat($groups->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($followers_stats_data);
                                            if ($followers_stats_data[$array_size - 1] > $followers_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="gigs-statistics">
                                        <div class="label">Studios</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $bookings ? thousandsNumberFormat($studios->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            
                                            $array_size = sizeof($gigs_stats_data);
                                            if ($gigs_stats_data[$array_size - 1] > $gigs_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="reviews-statistics">
                                        <div class="label">Accompinst</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $studios ? thousandsNumberFormat($accompinsts->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($reviews_stats_data);
                                            if ($reviews_stats_data[$array_size - 1] > $reviews_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="profile-statistics">
                                        <div class="label">Users</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $users ? thousandsNumberFormat($users->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($views_stats_data);
                                            if ($views_stats_data[$array_size - 1] > $views_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <label class="mt-4">Over All</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="final_stats" id="followers-statistics">
                                        <div class="label">Events</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $groups ? thousandsNumberFormat($groups->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($followers_stats_data);
                                            if ($followers_stats_data[$array_size - 1] > $followers_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="gigs-statistics">
                                        <div class="label">Studios</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $studios ? thousandsNumberFormat($studios->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($gigs_stats_data);
                                            if ($gigs_stats_data[$array_size - 1] > $gigs_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="reviews-statistics">
                                        <div class="label">Accompinst</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $accompinsts ? thousandsNumberFormat($accompinsts->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($reviews_stats_data);
                                            if ($reviews_stats_data[$array_size - 1] > $reviews_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="reviews-statistics">
                                        <div class="label">Users</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $users ? thousandsNumberFormat($users->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($views_stats_data);
                                            if ($views_stats_data[$array_size - 1] > $views_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fa <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row --> 
                                    
                                    
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                </section> 
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
            <script src="<?php echo asset('userassets/js/chart.bundle.js'); ?>"></script>
        </div>
    </body>
</html>
<script>
            $('#followers-statistics').click(function () {
                $('#followers-statistics-graph').removeClass('d-none');
                $('#gigs-statistics-graph').addClass('d-none');
                $('#reviews-statistics-graph').addClass('d-none');
                $('#profile-statistics-graph').addClass('d-none');
                $(this).addClass('active');
                $('#gigs-statistics').removeClass('active');
                $('#reviews-statistics').removeClass('active');
                $('#profile-statistics').removeClass('active');
            });

            $('#gigs-statistics').click(function () {
                $('#followers-statistics-graph').addClass('d-none');
                $('#gigs-statistics-graph').removeClass('d-none');
                $('#profile-statistics-graph').addClass('d-none');
                $('#reviews-statistics-graph').addClass('d-none');
                $(this).addClass('active');
                $('#followers-statistics').removeClass('active');
                $('#reviews-statistics').removeClass('active');
                $('#profile-statistics').removeClass('active');
            });

            $('#reviews-statistics').click(function () {
                $('#followers-statistics-graph').addClass('d-none');
                $('#gigs-statistics-graph').addClass('d-none');
                $('#profile-statistics-graph').addClass('d-none');
                $('#reviews-statistics-graph').removeClass('d-none');
                $(this).addClass('active');
                $('#followers-statistics').removeClass('active');
                $('#gigs-statistics').removeClass('active');
                $('#profile-statistics').removeClass('active');
            });
            $('#profile-statistics').click(function () {
                $('#followers-statistics-graph').addClass('d-none');
                $('#gigs-statistics-graph').addClass('d-none');
                $('#reviews-statistics-graph').addClass('d-none');
                $('#profile-statistics-graph').removeClass('d-none');
                $(this).addClass('active');
                $('#followers-statistics').removeClass('active');
                $('#gigs-statistics').removeClass('active');
                $('#reviews-statistics').removeClass('active');
            });

            var followers_ctx = document.getElementById("followers-statistics-graph").getContext('2d');
            var followers_chart = new Chart(followers_ctx, {
                type: 'line',
                data: {
                    labels: [
<?php
foreach ($followers_stats_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                    ],
                    datasets: [{
                            label: '',
                            data: [
<?php
foreach ($followers_stats_data as $data) {
    echo $data . ', ';
}
?>
                            ],
                            backgroundColor: 'rgba(182,46,101,0.1)',
                            borderColor: '#b62e65',
                            borderWidth: 4
                        }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0.000001
                        }
                    },
                    scales: {
                        xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    // labelString: 'Month'
                                },
                                gridLines: {
                                    // display: false,
                                    borderDash: [4, 4],
                                    offsetGridLines: true
                                }
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    // forces step size to be 5 units
                                    stepSize: 10
                                },
                                gridLines: {
                                    display: false,
                                }
                            }]
                    }
                }
            });

            var gigs_ctx = document.getElementById("gigs-statistics-graph").getContext('2d');
            var gigs_chart = new Chart(gigs_ctx, {
                type: 'line',
                data: {
                    labels: [
<?php
foreach ($gigs_stats_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                    ],
                    datasets: [{
                            label: '',
                            data: [
<?php
foreach ($gigs_stats_data as $data) {
    echo $data . ', ';
}
?>
                            ],
                            backgroundColor: 'rgba(182,46,101,0.1)',
                            borderColor: '#b62e65',
                            borderWidth: 4
                        }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0.000001
                        }
                    },
                    scales: {
                        xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    // labelString: 'Month'
                                },
                                gridLines: {
                                    // display: false,
                                    borderDash: [4, 4],
                                    offsetGridLines: true
                                }
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    // forces step size to be 5 units
                                    stepSize: 10
                                },
                                gridLines: {
                                    display: false,
                                }
                            }]
                    }
                }
            });

            var reviews_ctx = document.getElementById("reviews-statistics-graph").getContext('2d');
            var reviews_chart = new Chart(reviews_ctx, {
                type: 'line',
                data: {
                    labels: [
<?php
foreach ($reviews_stats_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                    ],
                    datasets: [{
                            label: '',
                            data: [
<?php
foreach ($reviews_stats_data as $data) {
    echo $data . ', ';
}
?>
                            ],
                            backgroundColor: 'rgba(182,46,101,0.1)',
                            borderColor: '#b62e65',
                            borderWidth: 4
                        }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0.000001
                        }
                    },
                    scales: {
                        xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    // labelString: 'Month'
                                },
                                gridLines: {
                                    // display: false,
                                    borderDash: [4, 4],
                                    offsetGridLines: true
                                }
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    // forces step size to be 5 units
                                    stepSize: 10
                                },
                                gridLines: {
                                    display: false,
                                }
                            }]
                    }
                }
            });

//            Profile Views
            var reviews_ctx = document.getElementById("profile-statistics-graph").getContext('2d');
            var reviews_chart = new Chart(reviews_ctx, {
                type: 'line',
                data: {
                    labels: [
<?php
foreach ($views_stats_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                    ],
                    datasets: [{
                            label: '',
                            data: [
<?php
foreach ($views_stats_data as $data) {
    echo $data . ', ';
}
?>
                            ],
                            backgroundColor: 'rgba(182,46,101,0.1)',
                            borderColor: '#b62e65',
                            borderWidth: 4
                        }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    elements: {
                        line: {
                            tension: 0.000001
                        }
                    },
                    scales: {
                        xAxes: [{
                                display: true,
                                scaleLabel: {
                                    display: true,
                                    // labelString: 'Month'
                                },
                                gridLines: {
                                    // display: false,
                                    borderDash: [4, 4],
                                    offsetGridLines: true
                                }
                            }],
                        yAxes: [{
                                display: true,
                                ticks: {
                                    min: 0,
                                    max: 100,
                                    // forces step size to be 5 units
                                    stepSize: 10
                                },
                                gridLines: {
                                    display: false,
                                }
                            }]
                    }
                }
            });
        </script>
