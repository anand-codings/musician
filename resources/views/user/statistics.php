<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <?php include resource_path('views/includes/top.php'); ?>
    <script src="<?php echo asset('userassets/js/chart.bundle.js'); ?>"></script>
    <body>
        <?php include resource_path('views/includes/header-timeline.php'); ?>
        <div class="page_timeline">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xl-3 col-lg-3">
                        <?php include resource_path('views/includes/sidebar.php'); ?>
                    </div> <!-- col -->
                    <div class="col-md-12 col-xl-6 col-lg-9">
                        <div class="statistics_page_wrap">
                            <h5 class="text_darkblue font-weight-bold">Statistics </h5>
                            <div class="text-content text_grey">
                                <!--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>-->
                            </div>
                            <canvas id="followers-statistics-graph"></canvas>
                            <canvas id="gigs-statistics-graph" class="d-none"></canvas>
                            <canvas id="reviews-statistics-graph" class="d-none"></canvas>
                            <canvas id="profile-statistics-graph" class="d-none"></canvas>
                            <label>Last 12 days</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="final_stats hover active" id="followers-statistics">
                                        <div class="label">Followers</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getFollowers ? thousandsNumberFormat($user->getFollowers->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($followers_stats_data);
                                            if ($followers_stats_data[$array_size - 1] > $followers_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="gigs-statistics">
                                        <div class="label">Gigs booked</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getDoneBookings ? thousandsNumberFormat($user->getDoneBookings->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($gigs_stats_data);
                                            if ($gigs_stats_data[$array_size - 1] > $gigs_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="reviews-statistics">
                                        <div class="label">Your reviews</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getReviews ? thousandsNumberFormat($user->getReviews->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($reviews_stats_data);
                                            if ($reviews_stats_data[$array_size - 1] > $reviews_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats hover" id="profile-statistics">
                                        <div class="label">Profile Views</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getProfileViews ? thousandsNumberFormat($user->getProfileViews->where('created_at', '>=', \Carbon\Carbon::now()->subDay(11))->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($views_stats_data);
                                            if ($views_stats_data[$array_size - 1] > $views_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row -->
                            <label class="mt-4">Over All</label>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="final_stats" id="followers-statistics">
                                        <div class="label">Followers</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getFollowers ? thousandsNumberFormat($user->getFollowers->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($followers_stats_data);
                                            if ($followers_stats_data[$array_size - 1] > $followers_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="gigs-statistics">
                                        <div class="label">Gigs booked</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getDoneBookings ? thousandsNumberFormat($user->getDoneBookings->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($gigs_stats_data);
                                            if ($gigs_stats_data[$array_size - 1] > $gigs_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="reviews-statistics">
                                        <div class="label">Your reviews</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getReviews ? thousandsNumberFormat($user->getReviews->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($reviews_stats_data);
                                            if ($reviews_stats_data[$array_size - 1] > $reviews_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="final_stats" id="reviews-statistics">
                                        <div class="label">Profile Views</div>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <h2><?= $user->getReviews ? thousandsNumberFormat($user->getProfileViews->count()) : 0 ?></h2>
                                            <?php
                                            $array_size = sizeof($views_stats_data);
                                            if ($views_stats_data[$array_size - 1] > $views_stats_data[$array_size - 2]) {
                                                $class_name = 'fa-sort-up text_green';
                                            } else {
                                                $class_name = 'fa-sort-down text_red';
                                            }
                                            ?>
                                            <i class="fas <?= $class_name ?>"></i>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- row -->
                        </div>
                    </div> <!-- col -->
                    <div class="col-md-12 col-xl-3 d-xl-block d-none">
                        <?php include resource_path('views/includes/sidebar-right.php'); ?>
                    </div> <!-- col -->
                </div> <!-- row -->
            </div> <!-- container -->
        </div> <!-- page timeline -->

        <?php include resource_path('views/includes/footer.php'); ?>
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


