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
                        Add Category
                        <small>Musician</small>
                    </h1>
                    <?php include 'includes/bread_crumbs.php'; ?>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container">
                           <form action="<?= asset('add_category_admin') ?>" method="post" enctype="multipart/form-data">
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
                                    <div class="form-group">
                                        <label>Upload Image</label>
                                        <div class="input-group">
                                            <span class="input-group-btn">
                                                <span class="btn btn-default btn-file">
                                                    Browse… <input type="file" id="imgInp"  name="category_img">
                                                </span>
                                            </span>
                                            <input type="text" class="form-control" readonly>
                                        </div>
                                         <div class="tag_image">
                                            
                                        <img id='img-upload' />
                                    </div>

                                    
                                </div>
                                    </div>
                            <div class="col-md-6">
                                <input type="text" name="title" class="form-control" placeholder="Title" style="margin-top: 23px;">

                                    <input type="checkbox" name="is_enabled_for_musicians"> <strong>Is Enabled for Musicians</strong><br>

                                    <input type="checkbox" name="is_enabled_for_studios"> <strong>Is Enabled for Teaching Studios</strong><br>

                                    <input type="checkbox" name="is_enabled_for_accompanists"> <strong>Is Enabled for Accompanists</strong><br>

                                    <input type="checkbox" name="is_enabled_for_groups"> <strong>Is Enabled for Event Services</strong><br>

                                    <input disabled="" class="solo-ensemble-input" type="radio" name="solo-ensemble" value="solo"> <strong>Is solo</strong><br>

                                    <input disabled="" class="solo-ensemble-input" type="radio" name="solo-ensemble" value="ensemble"> <strong>Is Ensemble</strong><br>

                                    <br><button type="submit" class="btn btn-primary btn-block btn-flat">Save</button>
                            </div>
                            </form>
                        </div>
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
        $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
            label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            console.log(input.val());
            console.log(label);
        input.trigger('fileselect', [label]);
        });

        $('.btn-file :file').on('fileselect', function(event, label) {

            var input = $(this).parents('.input-group').find(':text'),
                log = label;
                

            if( input.length ) {
                input.val(log);
            } else {
                if( log );
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
