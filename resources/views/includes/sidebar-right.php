<div class="stickysideRight">
    <div class="sidebar_block">
        <h6 class="title">Suggested Peoples <a href="<?= asset('search?search=&cat=') ?>">See All</a></h6>
        <ul class="suggested_people_list" id="user_suggestions">
            <?php
            if (count(getSuggestions()) > 0) {
                foreach (getSuggestions() as $suggestions) {

                    $followed_by = getFollower($suggestions->id);
                    ?>
                    <li class="d-flex" id="suggestion_user<?= $suggestions->id ?>">
                        <div class="image">
                            <span class="bg_image_round w-50" style="background-image: url(<?php echo getUserImage($suggestions->photo, $suggestions->social_photo, $suggestions->gender) ?>)"></span>
                        </div>
                        <div class="w-100">
                            <a href="<?= asset('profile_timeline/' . $suggestions->id) ?>" class="name"><?= $suggestions->first_name . ' ' . $suggestions->last_name ?></a>
                            <?php if ($followed_by) { ?>
                                <p class="followers_name">Followed by <a href="<?= asset('profile_timeline/' . $followed_by->id) ?>"><?= $followed_by->first_name . ' ' . $followed_by->last_name ?></a></p>
                            <?php } ?>
                            <div class="btns_group">
                                <a href="#" onclick="followUserSideBar('<?= $suggestions->id ?>')">
                                    <svg  width="12" height="12" viewBox="0 0 22 22">
                                    <path d="M10.978,0A6.36,6.36,0,0,0,7.387,11.6,11.013,11.013,0,0,0,0,22H1.715a9.283,9.283,0,0,1,9.263-9.281A6.359,6.359,0,0,0,10.978,0Zm0,11A4.641,4.641,0,1,1,15.61,6.359,4.641,4.641,0,0,1,10.978,11ZM18.4,16.672V13.062H16.682v3.609h-3.6v1.719h3.6V22H18.4V18.391H22V16.672H18.4Z"/>
                                    </svg>
                                    Follow</a>
                                <a href="#" onclick="ignoreUser('<?= $suggestions->id ?>')">Ignore</a>
                            </div>
                        </div>
                    </li>
                    <?php
                }
            } else {
                ?>
                <li class="d-flex">
                    <p class="followers_name">No Record Found</p>    
                </li>
            <?php } ?>
        </ul>
    </div> <!-- sidebar_block -->

    <div class="sidebar_block">
        <h6 class="title">Top Trending</h6>
        <div class="trending_tags">
            <?php foreach (trendingTag() as $tags) { ?>
                <a href="<?= asset('search?search=&cat=' . $tags->id) ?>">#<?= $tags->title ?></a>
            <?php } ?>
        </div>
    </div> <!-- sidebar_block -->

    <div class="sidebar_block">
        <h6 class="title">Invite & Share</h6>
        <div class="invitation_box">
            <div class="social_invitations_wrap">
                <div class="social_invitations">
                    <?php
                    echo Share::page(asset('/'), null, [])
                            ->facebook('')
                            ->twitter('')
                            ->whatsapp('');
                    ?>
                </div>
                <ul class="medias">
                    <li class="invitation_link"><a href="javascript:void(0)" id="copy-link" link="<?= asset('timeline') ?>"><i class="fas fa-link"></i> Copy Link</a></li>
                </ul>
            </div>
        </div> <!-- invitation box -->
        <div class="invite_form_widget">
             <form id="invite_user">
                <input id="invitation_email" required="" type="email" class="form-control" placeholder="Enter email" />
                <button id="invitation_send" class="btn" onclick="sendInvitation()"><i class="fa fa-paper-plane"></i> Invite</button>
            </form>
        </div>
    </div> <!-- sidebar_block -->

    <div class="copyright_timeline">
        <p><a href="#">Privacy & Policy</a> &nbsp;.&nbsp; <a href="#">Terms & Conditions</a><br/>
            Musician &copy; <?= date('Y') ?></p>
    </div> <!-- sidebar_block -->
</div>
<script>
    function sendInvitation() {
        var email = $('#invitation_email').val();
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (!filter.test(email)) {
            $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>Invalid email address').show().fadeOut(5000);

        } else {
            $("#invitation_send").attr("disabled", true);
            $.ajax({
                url: '<?= asset('send_invititaion_mail') ?>',
                type: 'GET',
                data: {'email': email},
                success: function (data) {
                    $("#invitation_send").attr("disabled", false);
                    if (data) {
                        $("#invitation_email").val('');
                        $('#showSuccess').html('Invitation Send successfuly!').fadeIn().fadeOut(5000);
                    } else {
                        $('#showErrorAll').html('<i class="fa fa-exclamation-triangle" aria-hidden="true"></i>This user is already on app').show().fadeOut(5000);

                    }
                }
            });


        }
    }
    function followUserSideBar(other_id) {
        $('#suggestion_user' + other_id).remove();
        $('#showSuccess').html('Followed successfuly!').fadeIn().fadeOut(5000);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('follow_user'); ?>",
            data: {other_id: other_id},
            success: function (response) {

                if (response.message == 'success') {

                    $('#user_suggestions').html('');
                    $('#user_suggestions').html(response.notification.view_data);
                    socket.emit('notification_get', {
                        "user_id": other_id,
                        "other_id": '<?php echo $current_id; ?>',
                        "other_name": '<?php echo $current_user->first_name . ' ' . $current_user->last_name ?>',
                        "photo": '<?php echo $current_photo; ?>',
                        "text": '<?php echo $current_user->first_name . ' ' . $current_user->last_name; ?>' + ' started following you',
                        "url": '<?= asset('profile_timeline/' . $current_id) ?>',
                        "other_url": '<?= asset('profile_timeline/' . $current_id) ?>',
                        "unique_text": response.notification.unique_text,
                        "notification_icon": '<?= asset('userassets/images/icon-follow.svg') ?>',
                    });
                } else {
                    $('#showError').html('Please Try Again').fadeIn().fadeOut(5000);
                }
            }
        });
    }
    function ignoreUser(other_id) {
        $('#suggestion_user' + other_id).remove();
        $('#showSuccess').html('Ignored successfuly!').fadeIn().fadeOut(5000);
        $.ajax({
            type: "GET",
            url: "<?php echo asset('ignore_user'); ?>",
            data: {other_id: other_id},
            success: function (response) {
                $('#user_suggestions').html('');
                $('#user_suggestions').html(response);
            }
        });
    }
</script>