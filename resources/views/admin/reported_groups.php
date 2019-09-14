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
                        Reported Event Services
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Reported Event Services</h3>
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
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Created By</th>
                                                <th>Event Service Name</th>
                                                <th>Event Service cover</th>
                                                <th>Reported By</th>
                                                <th>Reason</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($reported_groups as $group_report) { ?>
                                                <tr>
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$group_report->group->user->id.'?segment='.$segment)?>"><?= $group_report->group->user->first_name.' '.$group_report->group->user->last_name ?></a></td>
                                                    <td><?= $group_report->group->name?></a></td>
                                                    <td class="table_img"> 
                                                        <?php if(isset($group_report->group->cover)) { ?>
                                                                <img src="<?= asset('public/images/'.$group_report->group->cover) ?>">
                                                        <?php } ?>
                                                    </td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$group_report->user_id.'?segment='.$segment)?>"><?=$group_report->reporterUser->first_name.' '.$group_report->reporterUser->last_name?></a></td>
                                                    <td><?php if(isset($group_report->reason)){ 
                                                                echo $group_report->reason ;
                                                            } ?></td>
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="deleteGroup(<?=$group_report->group_id?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a>
                                                        <a href="javascript:void(0)"  onclick="deleteReport(<?=$group_report->id?>)" class="text-success "><i class="fa fa-flag fa-fw"></i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
        </div>
    </body>
</html>
<script>
    function deleteGroup(group_id){
        if(confirm('Are you sure that you want to delete this group?')){
            $.ajax({
                url: base_url + 'delete_group_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'group_id': group_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    console.log(data);
                    window.location.href= base_url+'groups_admin';
                }
            });
        }
    }
    
    function deleteReport(report_id){
        if(confirm('Are you sure you want to delete this report?')){
            $.ajax({
                url: base_url + 'delete_group_report',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'report_id': report_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    console.log(data);
                    window.location.href= base_url+'reported_groups';
                }
            });
        }
    }
</script>
