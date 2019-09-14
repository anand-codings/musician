<div class="sidebar">
    <?php $segment = Request::segment(1); ?>
    <div class="user_info clearfix">
        <div class="info-box clearfix">
            <div class="image">
                <img src="<?php echo asset('userassets/images/profile_pic_lg.png') ?>" alt="" class="rounded-circle w-120"/>
                <h4 class="txt-20 font-weight-bold mb-0">Kimberly Martin  <i class="fas fa-caret-down"></i><i class="fas fa-caret-up"></i></h4>                            
            </div>
            <a href="#" class="text_aqua edit_profile_btn">Edit Profile</a>            
        </div>
        <div class="dropdown dropdown_user">
            <ul class="un_style">
                <li> <a href="#" class="text_grey"> <i class="fas fa-user"></i> Profile </a> </li>
                <li> <a href="#" class="text_grey"> <i class="fas fa-edit"></i> Edit </a> </li>
                <li> <a href="http://localhost/musician/userlogout" class="text_grey"> <i class="fas fa-share"></i> Logout </a> </li>
            </ul>
        </div>
    </div> <!-- user info -->
    <ul class="timeline_nav un_style">
        <li <?php if ($segment == 'timeline') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('timeline'); ?>">
                <i class="s_icon ic_timeline"></i>
                Timeline
            </a>
        </li>
        <li <?php if ($segment == 'messages') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('messages'); ?>">
                <i class="s_icon ic_message"></i>
                Messages
                <span class="badge badge-gradient badge-pill">2</span>                                    
            </a>
        </li>
        <li <?php if ($segment == 'booking') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('booking'); ?>">
                <i class="s_icon ic_booking"></i>
                Bookings
                <span class="badge badge-gradient badge-pill">56</span>
            </a>
        </li>
        <li <?php if ($segment == 'events') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('events'); ?>">
                <i class="s_icon ic_calender"></i>
                Events
            </a>
            <a href="#" class="text_aqua create_link">Create</a>
        </li>
        <li <?php if ($segment == 'groups') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('groups'); ?>">
                <i class="s_icon ic_media"></i>
                Event Services
            </a>
            <a href="<?php echo asset('create_group'); ?>" class="text_aqua create_link">Create</a>
        </li>
        <li <?php if ($segment == 'reviews') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('reviews'); ?>">
                <i class="s_icon ic_review"></i>
                Reviews
                <span class="badge badge-pill">146</span>
            </a>
        </li>
        <li <?php if ($segment == 'bookmarks') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('bookmarks'); ?>">
                <i class="s_icon ic_bookmark"></i>
                Bookmarks
            </a>
        </li>
        <li <?php if ($segment == 'about') { ?> class="active" <?php } ?>>
            <a href="<?php echo asset('about'); ?>">
                <i class="s_icon ic_about"></i>
                About
            </a>
        </li>
    </ul> <!-- timeline nav -->
</div> <!-- sidebar -->