<div class="user_about_content">
    <h4 class="text-left text-uppercase mb-3 font-weight-bold font-22 text_darkblue"> Introduction</h4>
    <!-- <?php if (Auth::guard('user')->check()) { ?>
            <?php
            $check_for_contact_info_privacy = 0;
            if ($user->contact_info_privacy == 'musician' && $current_user_type == 'artist') {
                $check_for_contact_info_privacy = 1;
            } else if ($user->contact_info_privacy == 'following' && $user->checkIfCurrentUserIsFollowedByOpenedProfileMusician) {
                $check_for_contact_info_privacy = 1;
            } else if ($user->contact_info_privacy == 'customers' && $user->checkIfCurrentUserHasBookedProfileMusician) {
                $check_for_contact_info_privacy = 1;
            } else if ($current_id == $user->id) {
                $check_for_contact_info_privacy = 1;
            }
            ?>
            <?php
            if ($check_for_contact_info_privacy) {
            if ($user->id == $current_id || !$privacy || ($privacy && $privacy->email)) { ?>
                    <div class="mb-3">
                        <div><strong class="text-uppercase">Email</strong></div>
                        <span class="text_grey"><?= $user->email ? $user->email : 'N/A' ?></span>
                    </div>
            <?php }
            if ($user->id == $current_id || !$privacy || ($privacy && $privacy->phone)) { ?>
                    <div class="mb-3">
                        <div><strong class="text-uppercase">Phone</strong></div>
                        <span class="text_grey"><?= $user->phone ? $user->phone : 'N/A' ?></span>
                    </div>
                    <?php }
            } ?>
    <?php } ?>
    <?php if ($user->id == $current_id || !$privacy || ($privacy && $privacy->gender)) { ?>
        <div class="mb-3">
        <div><strong class="text-uppercase">Gender</strong></div>
        <span class="text_grey"><?= $user->gender ? $user->gender : 'N/A' ?></span>
        </div>
    <?php }
if ($user->id == $current_id || !$privacy || ($privacy && $privacy->birthday)) { ?>
        <div class="mb-3">
            <div><strong class="text-uppercase">Date of birth</strong></div>
            <span class="text_grey"><?= $user->dob ? $user->dob : 'N/A' ?></span>
        </div>
    <?php } ?>
    <div class="mb-3">
        <div><strong class="text-uppercase">Is available for booking?</strong></div>
        <span class="text_grey"><?= $user->allow_booking ? 'Yes' : 'No' ?></span>
    </div> -->
    <div class="mb-4">
        <div class="d-flex align-items-start">
            <span class="mr-2"><i class="fas fa-music"></i></span>
            <div>
                <h6>
                <?php
                $i = 0; 
                foreach ($user->getSelectedCategories as $selectedArtistType) {
                    echo $selectedArtistType->getCategory->title;
                    if ($getSelectedArtistTypesCount > $i)
                        echo ', ';
                        $i++;
                    }
                
                ?>
                </h6>
                <!--- <span class="text-purple-color">Piano Accompaniment</span> --->
            </div>
        </div>
    </div>
    <div class="mb-4">
        <div class="d-flex align-items-start">
            <span class="mr-2"><img width="19px" height="19px" src="<?php echo asset('userassets/images/loc-grey.png'); ?>"></span>
            <div>
                <!-- <h6>Housten</h6> -->
                <?php $address_bio = preg_split('~,(?=[^,]*$)~', $user->address); ?>
                

                <h6><?= (!empty($address_bio[0]))? $address_bio[0] : '' ?></h6>
                <span class="text-purple-color"><?= (!empty($address_bio[1]))? $address_bio[1] : '' ?></span>
            </div>
        </div>
    </div>
    <div class="mb-2">
        <div class="d-flex align-items-start">
            
            <div>
            <?php if (!$user->getExperiences->isEmpty()) { ?>
                <?php foreach ($user->getExperiences as $userExperience) { ?>
                <h6><span class="mr-2"><img width="19px" height="19px" src="<?php echo asset('userassets/images/portfolio.png'); ?>"></span> 
                    <?= $userExperience->title ?> at <span class="text-purple-color"><?= $userExperience->institute_name ?>.</span></h6>
                <?php } ?> 
            <?php } ?>
            </div>
        </div>
    </div>
    


    <?php if (!$user->getEducations->isEmpty()) { ?>
        <?php foreach ($user->getEducations as $userEducation) { ?>
            <div class="mb-2">
                <div class="d-flex align-items-start">
                    <span class="mr-2"><img width="19px" height="19px" src="<?php echo asset('userassets/images/edu.png'); ?>"></span>
                    <div>
                        <h6>Studied <?= $userEducation->title ?> at <span class="text-purple-color"><?= $userEducation->institute_name ?></span></h6>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
   


    <?php if (!$user->getAffiliations->isEmpty()) { ?>
        <?php foreach ($user->getAffiliations as $affiliation) { ?> 
            <div class="mb-2">
                <div class="d-flex align-items-start">
                    <span class="mr-2"><img width="19px" height="19px" src="<?php echo asset('userassets/images/affiliation.png'); ?>"></span>
                    <div>
                        <h6><span class="text-purple-color"><?= $affiliation->union->title ?></span></h6>
                    </div>
                </div>
            </div>
        <?php } ?>
    <?php } ?>
</div>
<div class="sidebar_widgets mt-3 bg-white p-2">
    <h6 class="d-flex"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 20 20" class="mr-2">
            <path class="cls-1" d="M18.137,2.933H1.862V2.862A1.393,1.393,0,0,1,3.271,1.484H17.2a0.931,0.931,0,0,1,.942.921V2.933ZM16.384,1.244H3.616A1.258,1.258,0,0,1,4.887,0H15.112a1.258,1.258,0,0,1,1.272,1.244h0Zm1.854,2.981a0.738,0.738,0,0,1,.745.728V18.278a0.738,0.738,0,0,1-.745.728H1.761a0.738,0.738,0,0,1-.745-0.728V4.953a0.738,0.738,0,0,1,.745-0.728H18.239m0-.994H1.761A1.742,1.742,0,0,0,0,4.953V18.278A1.742,1.742,0,0,0,1.761,20H18.239A1.742,1.742,0,0,0,20,18.278V4.953a1.742,1.742,0,0,0-1.761-1.722h0Zm-5.3,10.449,0.04,0.007a2.5,2.5,0,0,1,1.729,1.62l0.076,0.225,0.04,0.04L15.3,17.206H4.693l0.533-1.823,0-.013,0-.013c0-.01.01-0.038,0.024-0.079,0-.005.017-0.05,0.036-0.1,0.038-.092.158-0.322,0.206-0.405A5.419,5.419,0,0,1,7.035,13.7a3.872,3.872,0,0,0,2.94.968,3.857,3.857,0,0,0,2.963-.992m-0.1-1.019a0.744,0.744,0,0,0-.555.251,2.792,2.792,0,0,1-2.3.765,2.792,2.792,0,0,1-2.3-.765,0.744,0.744,0,0,0-.554-0.251,0.7,0.7,0,0,0-.185.025l-0.174.042A5.94,5.94,0,0,0,4.64,14.245a5.968,5.968,0,0,0-.29.567c-0.032.078-.056,0.149-0.056,0.149-0.02.06-.035,0.111-0.045,0.149L3.64,17.193a0.8,0.8,0,0,0,.145.694,0.816,0.816,0,0,0,.638.312H15.571a0.8,0.8,0,0,0,.638-0.312,0.776,0.776,0,0,0,.145-0.709l-0.609-2.069A0.3,0.3,0,0,0,15.672,15a3.519,3.519,0,0,0-2.479-2.282l-0.174-.028a0.7,0.7,0,0,0-.185-0.025h0Zm-2.743-.22c-1.625,0-3-1.926-3-4.206a3.349,3.349,0,0,1,.063-0.609A2.924,2.924,0,0,1,7.32,7.1a3.271,3.271,0,0,1,.253-0.468A3.12,3.12,0,0,1,9.313,5.39a3.5,3.5,0,0,1,.778-0.1A2.982,2.982,0,0,1,13.1,8.235a5.115,5.115,0,0,1-.936,2.975A2.686,2.686,0,0,1,10.091,12.441ZM7.5,8.658c0.1,1.89,1.258,3.427,2.588,3.427a2.334,2.334,0,0,0,1.854-1.132,4.528,4.528,0,0,0,.747-2.517,1.394,1.394,0,0,0-.016-0.251L12.63,7.909l-0.278.068a1.109,1.109,0,0,1-.25.029,1.43,1.43,0,0,1-.944-0.353L10.94,7.465l-0.17.23a2.5,2.5,0,0,1-2.047.777,4.915,4.915,0,0,1-.9-0.081L7.487,8.329Zm2.587-3.109a2.762,2.762,0,0,1,1.944.786,2.651,2.651,0,0,1,.73,1.275l-0.476.116a0.836,0.836,0,0,1-.186.021,1.166,1.166,0,0,1-.769-0.289L10.9,7.083l-0.341.461a2.248,2.248,0,0,1-1.833.671,4.653,4.653,0,0,1-.855-0.077l-0.5-.094a3.223,3.223,0,0,1,.05-0.365A2.661,2.661,0,0,1,7.564,7.2a3.028,3.028,0,0,1,.23-0.426A2.847,2.847,0,0,1,9.382,5.639a3.174,3.174,0,0,1,.709-0.091m0-.517a3.734,3.734,0,0,0-.847.109A3.377,3.377,0,0,0,7.351,6.492,3.51,3.51,0,0,0,7.076,7a3.141,3.141,0,0,0-.178.571,3.6,3.6,0,0,0-.068.662c0,2.424,1.493,4.465,3.262,4.465,1.74,0,3.276-2.084,3.276-4.465a3.237,3.237,0,0,0-3.276-3.2h0Zm-1.369,3.7a2.743,2.743,0,0,0,2.261-.885,1.7,1.7,0,0,0,1.118.418,1.378,1.378,0,0,0,.314-0.037,1.161,1.161,0,0,1,.013.209c0,1.806-1.093,3.391-2.337,3.391-1.194,0-2.236-1.462-2.324-3.182a5.21,5.21,0,0,0,.955.086h0Z" />
        </svg>Gallery</h6>
    <hr>
    <div class="gallary_widget">
        <ul class="mb-2">
            <?php
            if(isset($records) )
            { 
            foreach ($records as $record) 
            {
              
                if(file_exists( public_path() . '/images/posts/thumnails/' . $record->poster))
                {
                 ?>
                    <li><a href="<?= asset($record->path) ?>" data-fancybox="gallery"><img src="<?= asset('public/images/posts/thumnails/' . $record->poster) ?>"></a></li>

      <?php    }
           }
           }?>
                  

        </ul>
        <?php
        if((isset($record)) && ($user->id)) {?>
        <a class="pull-right d-block text-center" href="<?= asset('profile_media/'.$user->id) ?>">See All</a>
        <?php }
        else 
        { ?>
        <a style="pointer-events: none; cursor: default;" class="pull-right d-block text-center" href="#">No Media</a>
        <?php } ?>
    </div>
</div>
<div class="sidebar_widgets mt-3 bg-white p-2">
    <h6 class="d-flex"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="17" viewBox="0 0 20 20" class="mr-2">
            <path class="cls-1" d="M18.137,2.933H1.862V2.862A1.393,1.393,0,0,1,3.271,1.484H17.2a0.931,0.931,0,0,1,.942.921V2.933ZM16.384,1.244H3.616A1.258,1.258,0,0,1,4.887,0H15.112a1.258,1.258,0,0,1,1.272,1.244h0Zm1.854,2.981a0.738,0.738,0,0,1,.745.728V18.278a0.738,0.738,0,0,1-.745.728H1.761a0.738,0.738,0,0,1-.745-0.728V4.953a0.738,0.738,0,0,1,.745-0.728H18.239m0-.994H1.761A1.742,1.742,0,0,0,0,4.953V18.278A1.742,1.742,0,0,0,1.761,20H18.239A1.742,1.742,0,0,0,20,18.278V4.953a1.742,1.742,0,0,0-1.761-1.722h0Zm-5.3,10.449,0.04,0.007a2.5,2.5,0,0,1,1.729,1.62l0.076,0.225,0.04,0.04L15.3,17.206H4.693l0.533-1.823,0-.013,0-.013c0-.01.01-0.038,0.024-0.079,0-.005.017-0.05,0.036-0.1,0.038-.092.158-0.322,0.206-0.405A5.419,5.419,0,0,1,7.035,13.7a3.872,3.872,0,0,0,2.94.968,3.857,3.857,0,0,0,2.963-.992m-0.1-1.019a0.744,0.744,0,0,0-.555.251,2.792,2.792,0,0,1-2.3.765,2.792,2.792,0,0,1-2.3-.765,0.744,0.744,0,0,0-.554-0.251,0.7,0.7,0,0,0-.185.025l-0.174.042A5.94,5.94,0,0,0,4.64,14.245a5.968,5.968,0,0,0-.29.567c-0.032.078-.056,0.149-0.056,0.149-0.02.06-.035,0.111-0.045,0.149L3.64,17.193a0.8,0.8,0,0,0,.145.694,0.816,0.816,0,0,0,.638.312H15.571a0.8,0.8,0,0,0,.638-0.312,0.776,0.776,0,0,0,.145-0.709l-0.609-2.069A0.3,0.3,0,0,0,15.672,15a3.519,3.519,0,0,0-2.479-2.282l-0.174-.028a0.7,0.7,0,0,0-.185-0.025h0Zm-2.743-.22c-1.625,0-3-1.926-3-4.206a3.349,3.349,0,0,1,.063-0.609A2.924,2.924,0,0,1,7.32,7.1a3.271,3.271,0,0,1,.253-0.468A3.12,3.12,0,0,1,9.313,5.39a3.5,3.5,0,0,1,.778-0.1A2.982,2.982,0,0,1,13.1,8.235a5.115,5.115,0,0,1-.936,2.975A2.686,2.686,0,0,1,10.091,12.441ZM7.5,8.658c0.1,1.89,1.258,3.427,2.588,3.427a2.334,2.334,0,0,0,1.854-1.132,4.528,4.528,0,0,0,.747-2.517,1.394,1.394,0,0,0-.016-0.251L12.63,7.909l-0.278.068a1.109,1.109,0,0,1-.25.029,1.43,1.43,0,0,1-.944-0.353L10.94,7.465l-0.17.23a2.5,2.5,0,0,1-2.047.777,4.915,4.915,0,0,1-.9-0.081L7.487,8.329Zm2.587-3.109a2.762,2.762,0,0,1,1.944.786,2.651,2.651,0,0,1,.73,1.275l-0.476.116a0.836,0.836,0,0,1-.186.021,1.166,1.166,0,0,1-.769-0.289L10.9,7.083l-0.341.461a2.248,2.248,0,0,1-1.833.671,4.653,4.653,0,0,1-.855-0.077l-0.5-.094a3.223,3.223,0,0,1,.05-0.365A2.661,2.661,0,0,1,7.564,7.2a3.028,3.028,0,0,1,.23-0.426A2.847,2.847,0,0,1,9.382,5.639a3.174,3.174,0,0,1,.709-0.091m0-.517a3.734,3.734,0,0,0-.847.109A3.377,3.377,0,0,0,7.351,6.492,3.51,3.51,0,0,0,7.076,7a3.141,3.141,0,0,0-.178.571,3.6,3.6,0,0,0-.068.662c0,2.424,1.493,4.465,3.262,4.465,1.74,0,3.276-2.084,3.276-4.465a3.237,3.237,0,0,0-3.276-3.2h0Zm-1.369,3.7a2.743,2.743,0,0,0,2.261-.885,1.7,1.7,0,0,0,1.118.418,1.378,1.378,0,0,0,.314-0.037,1.161,1.161,0,0,1,.013.209c0,1.806-1.093,3.391-2.337,3.391-1.194,0-2.236-1.462-2.324-3.182a5.21,5.21,0,0,0,.955.086h0Z" />
        </svg>Collaborative Friends(<?= $user->friends->count(); ?>)</h6>
    <hr>
    <div class="gallary_widget friends_list_<?=$user->id?>">
        <ul>
            <?php
            if(!empty($user->friends)){
                foreach($user->friends as $friend) {
//                    print_r($friend); exit;
                    ?>
            <li id="friend_<?=$friend?>">
                <a href="<?php echo asset('/profile_timeline/'.$friend->user_id) ?>"><img src="<?php echo asset('public/images/'.getUserPhoto($friend->user_id)) ?>">
                <div class="friends_name">
                    <h6><?= getUserName($friend->user_id)?></h6>
                </div>
                </a>
            </li>
            <?php
                }
            }
            ?>
       </ul>
        <?php
        if((isset($user->friends)) && ($user->id)) {?>
        <a class="pull-right d-block text-center" href="<?= asset('all_friends/'.$user->id) ?>">See All</a>
        <?php }
        else { ?>
        <a style="pointer-events: none; cursor: default;" class="pull-right d-block text-center" href="#">No Media</a>
        <?php } ?>
    </div>
</div>
<!-- Members -->