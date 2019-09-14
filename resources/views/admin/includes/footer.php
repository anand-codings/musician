<script src="<?= asset('adminassets/bower_components/bootstrap/dist/js/bootstrap.min.js') ?>"></script>
<script src="<?= asset('adminassets/bower_components/datatables.net/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?= asset('adminassets/plugins/iCheck/icheck.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.4.2/chosen.jquery.min.js"></script>
<script src="<?= asset('adminassets/dist/js/all.min.js') ?>"></script>
<script src="<?= asset('adminassets/dist/js/pages/admin.js') ?>"></script>
<script src="<?= asset('adminassets/dist/js/demo.js') ?>"></script>
<script>
    $(function () {
//        $('input').iCheck({
//            checkboxClass: 'icheckbox_square-blue',
//            radioClass: 'iradio_square-blue',
//            increaseArea: '20%' /* optional */
//        });
        $('#datatable').DataTable({
//            "sScrollX": '200%'
//            'paging': true,
//            'lengthChange': false,
//            'searching': false,
//            'ordering': true,
//            'info': true,
//            'autoWidth': false
        });
    });
    $('.chosen-select').chosen({}).change( function(obj, result) {
});
</script>