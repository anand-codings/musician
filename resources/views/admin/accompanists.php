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
                        Accompanists
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
                                    <h3 class="box-title">Accompanists</h3>
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
                                                <th>title</th>
                                                <th>time</th>
                                                <th>location</th>
                                                <th>posted by</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($accompanists as $accompanist) { ?>
                                                <tr>
                                                    <td><?php echo $i;
                                            $i++;
                                                ?></td>
                                                    <td>  <?= $accompanist->name ?>
                                                    </td>
                                                    <td><?= date_format(new DateTime($accompanist->start_date), 'g:ia \o\n l jS F Y'); ?></td>
                                                    <td><?= $accompanist->location ?></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $accompanist->admin_id . '?segment=' . $segment) ?>"><?= $accompanist->user->first_name . ' ' . $accompanist->user->last_name ?></a></td>
                                                    <td><a href="javascript:void(0)" onclick="deleteTeachingStudio(<?= $accompanist->id ?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a></td>
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
    function deleteTeachingStudio(accompanist_id) {
        if (confirm('Are you sure that you want to delete this accompanist?')) {
            $.ajax({
                url: base_url + 'delete_accompanist_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'accompanist_id': accompanist_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'accompanists_admin';
                }
            });
        }
    }
</script>
