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
                        Edit Category
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container">
                        <form action="<?= asset('edit_category_admin') ?>" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
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
                                    <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                                    <input type="hidden" name="category_id" value="<?= $category->id ?>">
                                    <div class="form-group">
                                        <label>Update Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    Browse… <input type="file" id="imgInp"  name="category_img">
                                                </span>
                                            </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                        <div class="tag_image" style="background-image: url('<?= asset('adminassets/images/'.$category->image) ?>');">
                                            
                                        </div>
                                        <img id='img-upload' src=""/>
                                    </div>

                            </div>
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" placeholder="Title" value="<?= $category->title ?>" style="margin-top: 23px;">

                                    <input type="checkbox" name="is_enabled_for_musicians" <?php if($category->is_for_musician) { ?> checked <?php } ?> > <strong>Is Enabled for Musicians</strong><br>

                                    <input type="checkbox" name="is_enabled_for_studios" <?php if($category->is_for_studio) { ?> checked <?php } ?> > <strong>Is Enabled for Teaching Studios</strong><br>

                                    <input type="checkbox" name="is_enabled_for_accompanists" <?php if($category->is_for_accompanist) { ?> checked <?php } ?>> <strong>Is Enabled for Accompanists</strong><br>

                                    <input type="checkbox" name="is_enabled_for_groups" <?php if($category->is_for_group) { ?> checked <?php } ?>> <strong>Is Enabled for Event Services</strong><br>

                                    <input disabled="" class="solo-ensemble-input" type="radio" name="solo-ensemble" value="solo" <?php if($category->is_solo) { ?> checked <?php } ?> > <strong>Is solo</strong><br>

                                    <input disabled="" class="solo-ensemble-input" type="radio" name="solo-ensemble" value="ensemble" <?php if($category->is_ensemble) { ?> checked <?php } ?>> <strong>Is Ensemble</strong><br>

                                    <br><button type="submit" class="btn btn-primary btn-block btn-flat">Update</button>

                            </div>
                        </div>
                        </form>
                    </div>
                </section> 
            </div>

            <?php include 'includes/footer_dashboard.php'; ?>
        </div>
    </body>
</html>
<script>


    $('input[name=is_enabled_for_groups]').change(function () {
        if ($(this).is(':checked')) {
            $('.solo-ensemble-input').prop('disabled', false);
            $('input[name=solo-ensemble]:first').prop('checked', true);
        } else {
            $('.solo-ensemble-input').prop('disabled', true);
            $('input[name=solo-ensemble]').prop('checked', false);
        }
    });
    $(document).ready( function() {
        <?php if($category->is_for_group) { ?> 
            $('.solo-ensemble-input').prop('disabled', false);
        <?php } ?>

        $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [label]);
        });

        
        

        $('input[name=is_enabled_for_musicians]').change(function () {
            if (!$(this).is(':checked')) {
                $(this).prop('checked', false); 
            }
        });

        $('input[name=is_enabled_for_studios]').change(function () {
            if (!$(this).is(':checked')) {
                $(this).prop('checked', false); 
            }
        });

        $('input[name=is_enabled_for_accompanists]').change(function () {
            if (!$(this).is(':checked')) {
                $(this).prop('checked', false); 
            }
        });


        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;

            if( input.length ) {
                input.val(log);
            } else {
                if( log ) alert(log);
            }

        });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    // $('#img-upload').attr('src', e.target.result);
                    $('.tag_image').css('background-image', 'url('+e.target.result+')');
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#imgInp").change(function(){
            readURL(this);
        });
    });
</script>
