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
                        <?= $userType == "user" ? "Users" : "Musicians" ?>
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
                                    <h3 class="box-title"><?= $userType == "user" ? "Users" : "Musicians" ?></h3>
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
                                                <th>Image</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Address</th>
                                                <th>Phone</th>
                                                <?php if ($userType == 'artist') { ?>
                                                    <th>is Featured</th>
                                                <?php } ?>
                                                <th>Login As</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($users as $user) { ?>
                                                <tr>
                                                    <td><?php
                                                        echo $i;
                                                        $i++;
                                                        ?></td>
                                                    <td class="table_img"> 
                                                        <?php
                                                        $image = getUserImage($user->photo, $user->social_photo, $user->gender);
                                                        ?>
                                                        <img src="<?= $image ?>">
                                                    </td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $user->id) ?>"><?= $user->first_name . ' ' . $user->last_name ?></a></td>
                                                    <td><a href="<?= asset('user_detail_admin/' . $user->id) ?>"><?= $user->email ?></a></td>
                                                    <td><?= $user->address ?></td>
                                                    <td><?= $user->phone ?></td>
                                                    <?php if ($userType == 'artist') { ?>
                                                        <td class="text_center">
                                                            <?= ($user->is_featured_by_admin == 1) ? '<span class="text-success user_state">Featured</span>' : '<span class="text-danger user_state">Not Featured</span>'; ?>
                                                            <input type="checkbox" data-id="<?= $user->id; ?>" class="feature_user" name="is_featured_by_admin" value="1" <?= ($user->is_featured_by_admin == 1) ? 'checked' : ''; ?>>
                                                        </td> 
                                                    <?php } ?>
                                                    <td><a target="_blank" href="<?= asset('jump_to_account/' . $user->id) ?>">Login</a></td>
                                                    <td><a href="javascript:void(0)" onclick="deleteUser(<?= $user->id ?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a></td>
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
    function deleteUser(user_id) {
        if (confirm('Are you sure that you want to delete this user?')) {
            $.ajax({
                url: base_url + 'delete_user_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'user_id': user_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'users_admin';
                }
            });
        }
    }
    $('body').on('click', '.feature_user', function (e) {
        e.preventDefault();
        let ref = $(this);
        if (confirm('Do you really want to make this user as featured user?')) {
            var status = '';
            $this = $(this);
            user_state = $(this).prev('.user_state');
            var id = $this.attr('data-id');
            if ($(this).is(':checked')) {
                status = 1;
            } else {
                status = 0;
            }
            $.ajax({
                type: "POST",
                url: base_url + 'feature_user_admin',
                data: {id: id, 'status': status, '_token': '<?= csrf_token(); ?>'},
                dataType: 'json',
                success: function (data) {
                    if (data.success) {
                        if (status == 1) {
                            ref.prop("checked", true);
                            user_state.removeClass('text-danger');
                            user_state.addClass('text-success');
                            user_state.html('Featured');
                        } else {
                            ref.prop("checked", false);
                            user_state.html('Not Featured');
                            user_state.removeClass('text-success');
                            user_state.addClass('text-danger');
                        }
                        $('.web-alert').hide();
                        $('.ajax-msg').show();
                        $(".ajax-msg").removeClass("alert-danger");
                        $(".ajax-msg").addClass("alert-success");
                        $(".ajax-body").html(data.message);
                    } else if (data.error) {
                        alert(data.message);
                    }
                },
                error: function (data) {
                    $('.ajax-msg').show();
                    var response = $.parseJSON(data.responseText);
                    $(".ajax-msg").addClass("alert-danger");
                    $(".ajax-msg").removeClass("alert-success");
                    $(".ajax-msg").html(response.errorMessage);
                }
            });
        }
    });
</script>
