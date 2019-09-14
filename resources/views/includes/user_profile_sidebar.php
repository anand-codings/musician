<div class="user_about_content profile_sidebar">
    <h4 class="text-center text-uppercase mb-3 font-weight-bold font-22 text_darkblue"> About</h4>
    <div class="mb-3">
        <div><strong class="text-uppercase">Email</strong></div>
        <span class="text_grey"><?= $user->email ? $user->email : 'N/A' ?></span>
    </div>
    <div class="mb-3">
        <div><strong class="text-uppercase">Phone</strong></div>
        <span class="text_grey"><?= $user->phone ? $user->phone : 'N/A' ?></span>
    </div>
    <div class="mb-3">
        <div><strong class="text-uppercase">Gender</strong></div>
        <span class="text_grey"><?= $user->gender ? $user->gender : 'N/A' ?></span>
    </div>
    <div class="mb-3">
        <div><strong class="text-uppercase">Interest</strong></div>
        <?php if (!$user->getUserInterests->isEmpty()) { ?>
            <ul class="un_style interested_tags">
                <?php foreach ($user->getUserInterests as $userInterest) { ?>
                    <li><span><?= $userInterest->getInterest->interest ?></span></li>
                <?php } ?>
            </ul>
        <?php } else { ?>
            <span class="text_grey">N/A</span>
        <?php } ?>
    </div>
</div>