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