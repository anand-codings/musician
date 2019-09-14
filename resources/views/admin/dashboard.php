<!DOCTYPE html>
<html>
    <?php include 'includes/head.php'; ?>
    <link rel="stylesheet" href="<?= asset('userassets/css/jquery.circliful.css') ?>">
        <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }

        #chartjs-tooltip {
            opacity: 1;
            position: absolute;
            background: rgba(0, 0, 0, .7);
            color: white;
            border-radius: 3px;
            -webkit-transition: all .1s ease;
            transition: all .1s ease;
            pointer-events: none;
            white-space: nowrap;
            -webkit-transform: translate(25%, -50%);
            transform: translate(25%, -50%);
        }
        #chartjs-tooltip:after{
            content:"";
            background:transparent;
            width:10px;
            height:10px;
            position:absolute;
            left:-10.5px;
            opacity:0.7;
            top:30%;
            bottom:0;
            transform:rotate(-90deg);
            border-style: solid;
            border-width: 0px 6px 6px 6px;
            border-color: transparent transparent rgba(0, 0, 0, .7) transparent;
        }

        .chartjs-tooltip-key {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin-right: 10px;
        }

    </style>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includes/header.php'; ?>
            <?php include 'includes/sidebar.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Dashboard
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Info boxes -->
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('users_admin') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Users</span>
                                        <span class="info-box-number"><?= $usersCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('musicians_admin') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Musicians</span>
                                        <span class="info-box-number"><?= $musiciansCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <!-- fix for small devices only -->
                        <div class="clearfix visible-sm-block"></div>

                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('posts_admin') ?>"><div class="info-box">
                                    <span class="info-box-icon bg-green"><i class="fa fa-edit"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Posts</span>
                                        <span class="info-box-number"><?= $postsCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('events_admin') ?>"><div class="info-box">
                                    <span class="info-box-icon bg-yellow"><i class="fa fa-calendar"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Events</span>
                                        <span class="info-box-number"><?= $eventsCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('active_users_admin?filter=weekly') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Active Users &<br>Musicians</span>
                                        <span class="info-box-number"><?= $activeUsersCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="<?= asset('singup_users_admin?filter=daily') ?>">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Signups Per Day</span>
                                        <span class="info-box-number"><?= $signedUpUsersCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="javascript:void(0)">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Deactivation</span>
                                        <span class="info-box-number"><?= $deactivatedUsersCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <a href="javascript:void(0)">
                                <div class="info-box">
                                    <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>

                                    <div class="info-box-content">
                                        <span class="info-box-text">Non Active Users</span>
                                        <span class="info-box-number"><?= $nonActiveUsersCount ?></span>
                                    </div>
                                    <!-- /.info-box-content -->
                                </div>
                            </a>
                            <!-- /.info-box -->
                        </div>
                    </div>
                    <!-- /.row -->



                    <!-- Main row -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="signup_stats_filter_by">
                                        <option value="daily" <?=isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'daily' ? 'selected' : ''?>>Daily</option>
                                        <option value="monthly" <?=isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'monthly' ? 'selected' : ''?>>Monthly</option>
                                        <option value="yearly" <?=isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'yearly' ? 'selected' : ''?>>Yearly</option>
                                    </select>
                                    <canvas id="user-statistics-graph"></canvas>
                                    <label style="position: absolute;right: 0; left: 0;" class="text-center" >Signup Stats</label>
                                    <!-- <a class="pull-right btn btn-success margin-bottom" href="<?= asset('/admin_stats') ?>"> View all</a> -->
                                </div>
                                <div class="col-md-6">
                                    <select id="deactivation_stats_filter_by">
                                        <option value="daily" <?=isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'daily' ? 'selected' : ''?>>Daily</option>
                                        <option value="monthly" <?=isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'monthly' ? 'selected' : ''?>>Monthly</option>
                                        <option value="yearly" <?=isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'yearly' ? 'selected' : ''?>>Yearly</option>
                                    </select>
                                    <canvas id="deactivation-statistics-graph"></canvas>
                                    <label style="position: absolute;right: 0; left: 0;" class="text-center" >Deactivation Stats</label>
                                    <!-- <a class="pull-right btn btn-success margin-bottom" href="<?= asset('/admin_stats') ?>"> View all</a> -->
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-md-6">
                                    <canvas id="booking-statistics-graph"></canvas>
                                    <label style="position: absolute;right: 0; left: 0;" class="text-center" >Booking Statistics</label>
                                    <a class="pull-right btn btn-success margin-bottom" href="<?= asset('/admin_booking_stats') ?>"> View all</a>
                                </div>
                                <div class="col-sm-6">
                                 <div class="col-lg-4">
                                    <div id="returned_users_chart"></div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="active_now_users_chart"></div>
                                </div>
                                <div class="col-lg-4">
                                    <div id="active_weekly_users_chart"></div>
                                </div>
                                </div>
                            </div>
                            <!-- /.box -->
                            <!-- <div class="row">
                                <div class="col-lg-3">
                                    <div id="returned_users_chart"></div>
                                </div>
                                <div class="col-lg-3">
                                    <div id="active_now_users_chart"></div>
                                </div>
                                <div class="col-lg-3">
                                    <div id="active_weekly_users_chart"></div>
                                </div>
                            </div> -->
                            
                            <div class="row">

                                <!-- /.col -->

                                <?php if (!$newUsers->isEmpty()) { ?>
                                    <div class="col-md-6">
                                        <!-- USERS LIST -->
                                        <div class="box box-danger">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Latest Members</h3>

                                                <div class="box-tools pull-right">
                                                    <span class="label label-danger"><?= $newUsers->count() ?> New Members</span>
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body no-padding">
                                                <ul class="users-list clearfix">
                                                    <?php foreach ($newUsers as $newUser) { ?>
                                                        <li>
                                                            <?php
                                                            $photo = getUserImage($newUser->photo, $newUser->social_photo, $newUser->gender);
                                                            ?>
                                                            <div onclick="location.href = '<?= asset('user_detail_admin/' . $newUser->id . '?segment=' . $segment) ?>'" style="cursor: pointer;">
                                                                <div class="image-on-background" style="background:url(<?= $photo ?>);background-position: center;background-repeat: no-repeat;background-size: cover;"></div>
                                                                <span class="users-list-name"><?= $newUser->first_name . ' ' . $newUser->last_name ?></span>
                                                            </div>
                                                            <span class="users-list-date"><?= timeago($newUser->created_at) ?></span>
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                                <!-- /.users-list -->
                                            </div>
                                            <!-- /.box-body -->

                                        </div>
                                        <!--/.box -->
                                    </div>
                                <?php } ?>
                                <!-- /.col -->

                                <!-- /.row -->

                                <!-- TABLE: LATEST ORDERS -->
                                <?php if (!$newEvents->isEmpty()) { ?>
                                    <div class="col-md-6">
                                        <div class="box box-info">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Latest Events</h3>

                                                <div class="box-tools pull-right">
                                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <!-- /.box-header -->
                                            <div class="box-body">
                                                <div class="table-responsive">
                                                    <table class="table no-margin">
                                                        <thead>
                                                            <tr>
                                                                <th>Sr#</th>
                                                                <th>Post title</th>
                                                                <th>Status</th>
                                                                <th>Date</th>
                                                                <th>Post By</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $i = 1;
                                                            foreach ($newEvents as $newEvent) {
                                                                ?>
                                                                <tr>
                                                                    <td><?php
                                                                        echo $i;
                                                                        $i++;
                                                                        ?></td>
                                                                    <td><a href="<?= asset('event_detail_admin/' . $newEvent->id . '?segment=' . $segment) ?>"><?= $newEvent->title ?></a></td>
                                                                    <td><span class="label <?= $newEvent->status == 'active' ? 'label-success' : 'label-danger' ?>"><?= $newEvent->status ?></span></td>
                                                                    <td>
                                                                        <div class="sparkbar" data-color="#00a65a" data-height="20"><?= $newEvent->created_at ?></div>
                                                                    </td>
                                                                    <td><?= $newEvent->user->first_name . ' ' . $newEvent->user->last_name ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <!-- /.table-responsive -->
                                            </div>
                                            <!-- /.box-body -->
                                            <?php if ($eventsCount > 8) { ?>
                                                <div class="box-footer clearfix">
                                                    <a href="posts.html" class="btn btn-sm btn-default btn-flat pull-right">View All Events</a>
                                                </div>
                                            <?php } ?>
                                            <!-- /.box-footer -->
                                        </div>
                                    </div> 
                                <?php } ?>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                        <!-- /.content -->
                    </div>
                </section> 
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
            <script src="<?php echo asset('userassets/js/chart.bundle.js'); ?>"></script>
            <script src="<?php echo asset('userassets/js/jquery.circliful.min.js'); ?>"></script>
        </div>

    <script>
        $("#returned_users_chart").circliful({
            animationStep: 5,
            foregroundBorderWidth: 5,
            backgroundBorderWidth: 5,
            percentages: [
                {'percent': <?=$returned_users_percentage?>, 'color': '#3180B8', 'title': 'Returned Users' },
		{'percent': <?=$new_users_percentage?>, 'color': '#b62e65', 'title': 'New Users' }
            ],
            foregroundColor: '#b62e65',
            textBelow: true,
            text: 'Returned Users vs New Users'
        });
        $("#active_now_users_chart").circliful({
            animationStep: 5,
            foregroundBorderWidth: 10,
            backgroundBorderWidth: 10,
            percent: <?=$online_users_percentage?>,
            foregroundColor: '#b62e65',
            textBelow: true,
            text: 'Active Now Users'
        });
        $("#active_weekly_users_chart").circliful({
            animationStep: 5,
            foregroundBorderWidth: 10,
            backgroundBorderWidth: 10,
            percent: <?=$weekly_active_users_percentage?>,
            foregroundColor: '#b62e65',
            textBelow: true,
            text: 'Active Weekly Users'
        });
    </script>
        
        <script>
            var views_stats_percentage = <?php echo json_encode($views_stats_percentage); ?>;
            
            var customTooltips = function(tooltip) {
            // Tooltip Element
            var tooltipEl = document.getElementById('chartjs-tooltip');

            if (!tooltipEl) {
                tooltipEl = document.createElement('div');
                tooltipEl.id = 'chartjs-tooltip';
                tooltipEl.innerHTML = '<table></table>';
                this._chart.canvas.parentNode.appendChild(tooltipEl);
            }

            // Hide if no tooltip
            if (tooltip.opacity === 0) {
                tooltipEl.style.opacity = 0;
                return;
            }

            // Set caret Position
            tooltipEl.classList.remove('above', 'below', 'no-transform');
            if (tooltip.yAlign) {
                tooltipEl.classList.add(tooltip.yAlign);
            } else {
                tooltipEl.classList.add('no-transform');
            }

            function getBody(bodyItem) {
                return bodyItem.lines;
            }

            // Set Text
            if (tooltip.body) {
                var titleLines = tooltip.title || [];
                let index = tooltip.dataPoints[0]['index'];
                var bodyLines = tooltip.body.map(getBody);

                var innerHtml = '<thead>';

                titleLines.forEach(function(title) {
                    //                    innerHtml += '<tr><th>' + +'</th></tr>';
                });
                innerHtml += '</thead><tbody>';

                bodyLines.forEach(function(body, i) {

                    var colors = tooltip.labelColors[i];
                    var style = 'background:' + colors.backgroundColor;
                    style += '; border-color:' + colors.borderColor;
                    style += '; border-width: 2px';
                    var arrow_up = '<i class="fa fa-arrow-up"></i>';
                    var arrow_down = '<i class="fa fa-arrow-down"></i>';
                    var span = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
                    if (index == 0) {
                        innerHtml += '<tr><td>' + body + '</td></tr>';
                    } else {
                        if(views_stats_percentage[index-1] >= 0) {
                            innerHtml += '<tr><td>' + body + '  ' + arrow_up + ' ' + Math.round(Math.abs(views_stats_percentage[index-1])) + '% </td></tr>';
                        } else if(views_stats_percentage[index-1] < 0) {
                            innerHtml += '<tr><td>' + body + '  ' + arrow_down + ' ' + Math.round(Math.abs(views_stats_percentage[index-1])) + '% </td></tr>';
                        }
                    }
                });
                innerHtml += '</tbody>';


                var tableRoot = tooltipEl.querySelector('table');
                tableRoot.innerHTML = innerHtml;
            }

            var positionY = this._chart.canvas.offsetTop;
            var positionX = this._chart.canvas.offsetLeft;

            // Display, position, and set styles for font
            tooltipEl.style.opacity = 1;
            tooltipEl.style.left = positionX + tooltip.caretX + 'px';
            tooltipEl.style.top = positionY + tooltip.caretY + 'px';
            tooltipEl.style.fontFamily = tooltip._bodyFontFamily;
            tooltipEl.style.fontSize = tooltip.bodyFontSize + 'px';
            tooltipEl.style.fontStyle = tooltip._bodyFontStyle;
            tooltipEl.style.padding = tooltip.yPadding + 'px ' + tooltip.xPadding + 'px';
        };
        
    var reviews_ctx = document.getElementById("user-statistics-graph").getContext('2d');
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
                                                                        },
                                                                        tooltips: {
                        enabled: false,
                        mode: 'index',
                        position: 'nearest',
                        custom: customTooltips
                    }
                                                                    }
                                                                });
                                                                
        var reviews_ctx = document.getElementById("deactivation-statistics-graph").getContext('2d');
                                                                var reviews_chart = new Chart(reviews_ctx, {
                                                                    type: 'line',
                                                                    data: {
                                                                        labels: [
<?php
foreach ($deactivation_stats_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                                                                        ],
                                                                        datasets: [{
                                                                                label: '',
                                                                                data: [
<?php
foreach ($deactivation_stats_data as $data) {
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


                                                                var followers_ctx = document.getElementById("booking-statistics-graph").getContext('2d');
                                                                var followers_chart = new Chart(followers_ctx, {
                                                                    type: 'line',
                                                                    data: {
                                                                        labels: [
<?php
foreach ($total_bookings_labels as $label) {
    echo '"' . $label . '", ';
}
?>
                                                                        ],
                                                                        datasets: [{
                                                                                label: '',
                                                                                data: [
<?php
foreach ($total_bookings_data as $data) {
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

            $('#signup_stats_filter_by').change(function(){
                window.location.href = base_url+'admin_dashboard?signup_stats_filter='+$(this).val()+'&deactivation_stats_filter='+$('#deactivation_stats_filter_by').val();
            });                                                    
            $('#deactivation_stats_filter_by').change(function(){
                window.location.href = base_url+'admin_dashboard?signup_stats_filter='+$('#signup_stats_filter_by').val()+'&deactivation_stats_filter='+$(this).val();
            });                                                    

        </script>
    </body>
</html>
