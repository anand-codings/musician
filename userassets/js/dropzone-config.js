var total_photos_counter = 0;
var name = "";
var image_attachments = [];

Dropzone.options.myDropzone = {
    uploadMultiple: true,
    parallelUploads: 1,
    maxFilesize: 30,
    previewTemplate: document.querySelector('#preview').innerHTML,
    addRemoveLinks: true,
    dictRemoveFile: 'x',
    dictFileTooBig: 'File is larger than 30MB',
    timeout: 10000000,
    acceptedFiles: 'image/*,video/*,audio/*',
    maxFiles: 1,
    renameFile: function (file) {
        name = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return name;
    },

    init: function () {

        this.on("error", function (file, response) {
            var errMsg = response;
            if (response.message)
                errMsg = response.message;
            if (response.file)
                errMsg = response.file[0];
            $('#showError').html(errMsg).show().fadeOut(5000);
            $('#post_loader').hide();
            $("#submit_post").css('pointer-events', 'auto');
//            alert(errMsg);
//            if(errMsg != 'You can not upload any more files.'){
            this.removeFile(file);
        });
        this.on("removedfile", function (file) {

            $.post({
                url: '/musician/delete_file',
                data: {"file_name": file.saved_file_name, "file_type": file.saved_file_type, "_token": $('[name="_token"]').val()},
//                dataType: 'post',
                success: function (data) {
                    total_photos_counter--;
                    $("#image-counter").text("# " + total_photos_counter);
                    $.each(image_attachments, function (i) {
                        if (image_attachments[i].file_name === file.saved_file_name) {
                            image_attachments.splice(i, 1);
                            return false;
                        }
                    });
                    if (image_attachments.length > 0) {
                        $('.wall-post-write-sec .dropzone .add-more-plus').remove();
                        $('.container-fluid .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
                    } else {
                        $('.wall-post-write-sec .dropzone .add-more-plus').remove();
                    }
                    $('#post_loader').hide();
                    $("#submit_post").css('pointer-events', 'auto');
                    $('#submit_post').bind('click', submitPost);
                }

            });
        });
        this.on("addedfile", function (file) {
            $('.container-fluid .dropzone .add-more-plus').remove();
            $('#post_loader').show();//show loading indicator image
            $("#submit_post").css('pointer-events', 'none'); //disable post button
        });

        this.on("complete", function (file) {
            if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                $('#post_loader').hide();//hide loader
                $("#submit_post").css('pointer-events', 'auto'); //enable post button
            }
        });


        this.on('resetFiles', function () {
            if (this.files.length != 0) {
                for (i = 0; i < this.files.length; i++) {
                    this.files[i].previewElement.remove();
                }
                this.files.length = 0;
            }
        });

    },

    success: function (file, done) {
        total_photos_counter++;
        $("#image-counter").text("# " + total_photos_counter);
        file["customName"] = name;
        file["saved_file_name"] = done.file_name;
        file["saved_resize_name"] = done.resize_name;
//        file["original_name"] = done.original_name;
        file["saved_file_type"] = done.type;
        this.emit("thumbnail", file, done.thumnail_path);
        image_attachments.push({

            "db_name": done.db_name,
            "resize_name": done.resize_name,
            "file_name": done.file_name,
            "duration": done.duration,
            "poster": done.poster_name,
            "type": done.type,
            "db_thumb": done.db_thumb
        });
//        this.createThumbnailFromUrl(file, done.thumnail_path);



//        console.log(image_attachments);
//$('.wall-post-write-sec .dropzone .dz-image-preview.add-more-plus').removeClass('add-more-plus');
        if (image_attachments.length >= 1) {
            $('.container-fluid .dropzone .add-more-plus').remove();
        } else {
            $('.container-fluid .dropzone .add-more-plus').remove();
            $('.wall-post-write-sec .dropzone .dz-image-preview:last').after('<div class="add-more-plus" onclick="$(this).parent().trigger(\'click\')">+</div>');
        }

    },

    accept: function (file, done) {
//        console.log("uploaded");
        done();
    },
};