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
                        Categories
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
                                    <h3 class="box-title">Categories</h3>
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
                                                <th>Title</th>
                                                <th>Image</th>
                                                <th>Search Count</th>
                                                <th>For Musicians</th>
                                                <th>For Studios</th>
                                                <th>For Accompanists</th>
                                                <th>For Event Services</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($categories as $category) { ?>
                                                <tr>
                                                    <td><?php echo $i;
                                            $i++;
                                                ?></td>
                                                    <td><?= $category->title ?></td>
                                                    <td> <div class="table_image" style="background-image: url('<?= asset('adminassets/images/'.$category->image) ?>')"></div> </td>
                                                    <td><?= $category->search_count ?></td>
                                                    <td>
                                                        <input type="checkbox" <?= $category->is_for_musician ? 'checked' : '' ?> action_on="is_for_musician" category_id="<?= $category->id ?>">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" <?= $category->is_for_studio ? 'checked' : '' ?> action_on="is_for_studio" category_id="<?= $category->id ?>">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" <?= $category->is_for_accompanist ? 'checked' : '' ?> action_on="is_for_accompanist" category_id="<?= $category->id ?>">
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" <?= $category->is_for_group ? 'checked' : '' ?> action_on="is_for_group" category_id="<?= $category->id ?>">
                                                        <label>Is enabled</label><br>

                                                        <input type="radio" name="solo-ensemble<?= $category->id ?>" <?= $category->is_for_group ? '' : 'disabled=""' ?> <?= $category->is_solo ? 'checked' : '' ?> action_on="is_solo" category_id="<?= $category->id ?>">
                                                        <label>Is Solo</label><br>

                                                        <input type="radio" name="solo-ensemble<?= $category->id ?>" <?= $category->is_for_group ? '' : 'disabled=""' ?> <?= $category->is_ensemble ? 'checked' : '' ?> action_on="is_ensemble" category_id="<?= $category->id ?>">
                                                        <label>Is Ensembled</label>
                                                    </td>
                                                    <td><a href="javascript:void(0)" onclick="deleteCategory(<?= $category->id ?>)"  class="text-danger delete"><i class="fa fa-trash-o"></i></a>

                                                        <a href="<?= asset('/edit_category_admin/'.$category->id) ?>" class=""><i class="fa fa-edit"></i></a>

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
    function deleteCategory(category_id) {
        if (confirm('Are you sure that you want to delete this category?')) {
            $.ajax({
                url: base_url + 'delete_category_admin',
                type: 'POST',
                enctype: 'multipart/form-data',
                data: {'category_id': category_id},
                beforeSend: function (request) {
                    return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
                },
                success: function (data) {
                    console.log(data);
                    window.location.href = base_url + 'categories_admin';
                }
            });
        }
    }

    $('input[type="checkbox"], input[type="radio"]').change(function () {
        var is_enabled = 0;
        var action_on = $(this).attr('action_on');
        var category_id = $(this).attr('category_id');
        let ref = $(this);
        if ($(this).is(":checked")) {
            is_enabled = 1;
        }
        if (action_on == 'is_for_group') {
            if (is_enabled) {
                $('input[name=solo-ensemble' + category_id + ']:first').prop('checked', true);
                $('input[name=solo-ensemble' + category_id + ']').prop('disabled', false);
            } else {
                $('input[name=solo-ensemble' + category_id + ']').prop('checked', false);
                $('input[name=solo-ensemble' + category_id + ']').prop('disabled', true);
            }
        }
        $.ajax({
            url: base_url + 'action_on_category_admin',
            type: 'POST',
            enctype: 'multipart/form-data',
            data: {'is_enabled': is_enabled, 'action_on': action_on, 'category_id': category_id},
            beforeSend: function (request) {
                return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
            },
            success: function (data) {
                if (data.error) {
                    alert(data.error);
                    if (ref.is(":checked")) {
                        ref.prop('checked', false);
                    } else {
                        ref.prop('checked', true);
                    }
                }
            }
        });
    });

</script>
