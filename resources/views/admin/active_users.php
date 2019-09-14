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
                        Active Users & Musicians
                        
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                               
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
                                    <h5 style="margin-bottom:0;">Filter By</h5>
                                    <div class="filter_row">
                                    <select id="filter_by">
                                        <option value="daily" <?=isset($_GET['filter']) && $_GET['filter'] == 'daily' ? 'selected' : ''?>>Daily</option>
                                        <option value="weekly" <?=isset($_GET['filter']) && $_GET['filter'] == 'weekly' ? 'selected' : ''?>>Weekly</option>
                                        <option value="monthly" <?=isset($_GET['filter']) && $_GET['filter'] == 'monthly' ? 'selected' : ''?>>Monthly</option>
                                        <option value="yearly" <?=isset($_GET['filter']) && $_GET['filter'] == 'yearly' ? 'selected' : ''?>>Yearly</option>
                                    </select>
                                    <button id="create_report">Create Report</button>
                                    </div>
                                    <table id="datatable" class="table table-bordered table-striped tbl">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <th>Signup Date</th>
                                                <th>Login As</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach($users as $user) { ?>
                                                <tr>
                                                    <td><?php echo $i; $i++; ?></td>
                                                    <td class="table_img"> 
                                                        <?php
                                                        $image = getUserImage($user->photo, $user->social_photo, $user->gender);
                                                        ?>
                                                        <img src="<?=$image?>">
                                                    </td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$user->id)?>"><?=$user->first_name.' '.$user->last_name?></a></td>
                                                    <td><a href="<?=asset('user_detail_admin/'.$user->id)?>"><?=$user->email?></a></td>
                                                    <td><?=$user->address?></td>
                                                    <td><?=$user->phone?></td>
                                                    <td><?=date('jS F Y', strtotime($user->created_at))?></td>
                                                    <td><a target="_blank" href="<?=asset('jump_to_account/'.$user->id)?>">Login</a></td>
                                                    <td><a href="javascript:void(0)" onclick="deleteUser(<?=$user->id?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a></td>
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
                    <!-- /.row -->
                </section>
                <!-- /.content -->
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
<script>
    function deleteUser(user_id){
        if(confirm('Are you sure that you want to delete this user?')){
            $.ajax({
                url: base_url + 'delete_user_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'user_id': user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success:function(data) {
                    console.log(data);
                    window.location.href= base_url+'users_admin';
                }
            });
        }
    }
    $('#filter_by').change(function(){
        window.location.href = '<?=asset('active_users_admin?filter=')?>'+$(this).val();
    });
    $('#create_report').click(function(){
        window.location.href = '<?=asset('download_actives_uers_csv?filter=')?>'+$('#filter_by').val();
    });
</script>
