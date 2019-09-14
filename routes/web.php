<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */

//Home Page
//Route::get('/', function () {
//    if (Auth::guard('user')->check()) {
//        return redirect('timeline');
//    }
//    $data['title'] = 'Musician | Home Page';
//    return view('public.index', $data);
//});
Route::get('/invoice', function () {
    $data['title'] = 'Musician | Login';
    return view('public.invoice', $data);
});
Route::get('logout_cron', 'AuthController@logoutCron');

Route::get('/', 'PublicController@index');
//Login Section
Route::get('/login', function () {
    if (Auth::guard('user')->check()) {
        return redirect('timeline');
    }
    $data['title'] = 'Musician | Login';
    return view('public.login', $data);
});
//Fb Login

Route::get('facebook-login', 'SocialAuthController@redirect');
Route::get('facebook', 'SocialAuthController@callback');
//google Login
Route::get('google-login', 'SocialAuthController@redirectToProvider');
Route::get('google', 'SocialAuthController@handleProviderCallback');
//User Register
Route::post('login', 'AuthController@postLogin');
Route::get('/register', function () {
    if (Auth::guard('user')->check()) {
        return redirect('timeline');
    }
    $data['title'] = 'Musician | Register';
    return view('public.register', $data);
});
Route::post('register', 'AuthController@userRegister');
//Muscian Register
Route::get('/musician-register', 'AuthController@artistRegisterView');
Route::post('musician-register', 'AuthController@artistRegister');
Route::get('authenticate_email', 'AuthController@authenticateEmail');
//Forget password
Route::get('/forgetpassword', function () {
    if (Auth::guard('user')->check()) {
        return redirect('timeline');
    }
    $data['title'] = 'Musician | Forget Password';
    return view('public.forgetpassword', $data);
});
Route::post('forgetpassword', 'AuthController@forgetEmail');
Route::get('reset_password/{token}', 'AuthController@resetPassword');
Route::post('reset_password', 'AuthController@updatePassword');
//Logout
Route::get('userlogout', function () {
    if (Auth::user()) {
        App\User::where('id', Auth::user()->id)->update(['is_online' => 0]);
        Auth::guard('user')->logout();
    }

    return Redirect::to('/');
});

Route::get('/publicview', function () {
    $data['title'] = 'Musician | Public View';
    return view('public.publicview', $data);
});
Route::get('/signup', function () {
    $data['title'] = 'Musician | Signup';
    return view('public.signup', $data);
});

Route::get('/assets', function () {
    $data['title'] = 'Musician | assets';
    return view('public.assets', $data);
});
Route::get('/about', function () {
    $data['title'] = 'Musician | About';
    return view('public.about', $data);
});

Route::get('/popup', function () {
    $data['title'] = 'Musician | popup';
    return view('public.popup', $data);
});



Route::get('/search', 'PublicController@searchMusician');

Route::get('view_all_categories', 'PublicController@viewAllCategories');

Route::get('/autoCompleteSearch', 'PublicController@searchMusicianAutocomplete');
Route::get('/get_musician', 'PublicController@getMusician');

Route::get('profile_timeline/{user_id}', 'PublicController@profileTimeline');
Route::get('fetch_public_posts', 'PublicController@fetchPublicPosts');
Route::get('profile_gigs_and_groups/{user_id}', 'PublicController@profileGigsAndGroups');
Route::get('fetch_gigs_groups', 'PublicController@fetchGigsGroups');
Route::get('profile_media/{user_id}', 'PublicController@profileMedia');
Route::get('fetch_profile_media', 'PublicController@fetchProfileMedia');

Route::get('profile_reviews/{user_id}', 'PublicController@profileReviews');
Route::get('fetch_profile_reviews', 'PublicController@fetchProfileReviews');

Route::get('fetch_reviews_for_detail_page', 'PublicController@fetchReviewsForDetailPage');

Route::get('profile_testimonials/{user_id}', 'PublicController@profileTestimonials');
Route::get('fetch_profile_testimonials', 'PublicController@fetchProfileTestimonials');

Route::get('profile_teaching_studios/{user_id}', 'PublicController@profileTeachingStudios');
Route::get('teaching_studio_time_line/{studio_id}', 'PublicController@teachingStudioTimeLine');
Route::get('teaching_studio_reviews/{studio_id}', 'PublicController@teachingStudioReviews');
Route::get('teaching_studio_gallery/{studio_id}', 'PublicController@teachingStudioGallery');
Route::get('fetch_profile_teaching_studios', 'PublicController@fetchTeachingStudios');

Route::get('profile_accompanists/{user_id}', 'PublicController@profileAccompanists');

Route::get('fetch_profile_accompanists', 'PublicController@fetchProfileAccompanists');

Route::get('teaching_studio_detail/{teaching_studio_id}', 'PublicController@teachingStudioDetail');
Route::get('accompanist_detail/{accompanist_id}', 'PublicController@accompanistDetail');
Route::get('accompanist_time_line/{user_id}', 'PublicController@accompanistTimeLine');
Route::get('accompanist_reviews/{user_id}', 'PublicController@accompanistReviews');
Route::get('accompanist_gallery/{user_id}', 'PublicController@accompanistGalery');
Route::get('accompanist_members_list/{accompanist_id}', 'PublicController@accompanistMemebersList');


Route::get('profile_followers/{user_id}', 'PublicController@profileFollowers');
Route::get('all_friends/{user_id}', 'PublicController@allfriends');
Route::get('profile_about/{user_id}', 'PublicController@profileAbout');
Route::get('group_detail/{group_id}', 'PublicController@groupDetail');
Route::get('group_time_line/{group_id}', 'PublicController@groupTimeLine');
Route::get('get_time_line', 'PublicController@userTimeLine');
Route::get('group_reviews/{group_id}', 'PublicController@groupReviews');
Route::get('groups_gallery/{group_id}', 'PublicController@groupGallery');





Route::get('get_followers/{user_id}', 'PublicController@getFollowers');
Route::get('get_followings/{user_id}', 'PublicController@getFollowings');
Route::post('fetch_followers', 'PublicController@fetchFollowers');
Route::post('fetch_followers_profile', 'PublicController@fetchFollowersProfile');

//Service Follow
Route::get('follow_service', 'UserController@followService');
Route::get('unfollow_service', 'UserController@unfollowService');
Route::get('get_service_followers/{type}/{user_id}', 'PublicController@getServicesFollowers');
Route::post('fetch_service_followers', 'PublicController@fetchServicesFollowers');
//Invite Service
Route::get('invite_service', 'UserController@followInvite');
Route::get('gig_detail/{gig_id}', 'PublicController@gigDetail');

Route::get('populate_categories_on_search_page', 'PublicController@populateCategoriesOnSearchPage');

//Route::get('services', function() {
//    return view('user.services')->with('title', 'Services');
//});
//Route::get('followerslist', function() {
//    return view('public.followers')->with('title', 'Following List');
//});

Route::group(['middleware' => ['nocache', 'auth']], function () {
    //group
    Route::post('refer_friend_to_join_group', 'GroupController@referFriendsToJoinGroup');
    Route::get('group_members_list/{group_id}', 'PublicController@getGroupMembersList');
    //accompanist
    Route::post('refer_friend_to_join_accompanist', 'AccompanistController@referFriendToJoinAccompanist');
    //show studio friends list
    Route::get('teachers_list/{studio_id}', 'PublicController@getTeacherMemberList');
    Route::get('students_list/{studio_id}', 'PublicController@getStudentMemberList');
    Route::get('offline_user', 'PublicController@OfflineUser');
    Route::get('review_profile_after_booking/{booking_id}', 'PublicController@profileReviewAfterBooking');
    Route::post('post_review', 'UserController@postReview');
    Route::post('post_testimonial', 'UserController@postTestimonial');
    //    Timeline
    Route::get('timeline', 'TimelineController@timeline');
    Route::get('friends', 'TimelineController@showAllFriends');

    Route::get('get_users_mentions', 'TimelineController@getUserMentions');
    Route::post('timeline', 'TimelineController@postTimeline');
    //    Events section
    Route::get('/events', function () {
        $data['title'] = 'Musician | Events';
        return view('user.events', $data);
    });
    Route::get('get_events', 'TimelineController@getEvents');
    Route::post('delete_event', 'TimelineController@deleteEvent');
    Route::post('delete_event_pic', 'TimelineController@deleteEventPic');
    //    Posts section
    Route::post('save_file', 'PostController@addFile');
    Route::post('delete_file', 'PostController@deleteFile');
    Route::post('add_post', 'PostController@addPost');
    Route::get('fetch_posts', 'PostController@fetchPosts');
    Route::get('report_single_post', 'PostController@reportPost');
    Route::get('delete_post', 'PostController@deletePost');
    Route::get('get_post/{post_id}', 'PostController@getPost');
    Route::get('fetch_post/{post_id}', 'PostController@fetchPost');
    Route::get('edit_post/{post_id}', 'PostController@editPost');
    Route::get('get_post_images/{post_id}', 'PostController@getPostImages');
    Route::get('send_mail_on_share', 'PostController@sendMailOnShare');
    Route::post('like_post', 'PostActionController@likePost');
    //    Comments section
    Route::post('add_comment', 'PostActionController@addComment');
    Route::get('delete_comment', 'PostActionController@deleteComment');
    //    Favorites section
    Route::post('add_favourites_post', 'FavouriteController@addFavouritePost');
    Route::get('favourites', 'FavouriteController@getFavourites');
    Route::get('fetch_favourites', 'FavouriteController@fetchFavourites');
    //    User profile section
    Route::get('edit_user_profile', 'UserController@editUserProfileView');
    Route::post('edit_user_profile', 'UserController@editUserProfile');
    Route::get('update_privacy', 'UserController@updatePrivacy');
    Route::get('update_email_setting', 'UserController@addEmailSetting');
    Route::get('update_privacy_setting', 'UserController@addPrivacySetting');
    Route::post('update_cover', 'UserController@updateCover');
    //    Artist profile section
    Route::get('edit_musician_profile', 'UserController@editMusicianProfileView');
    Route::post('edit_musician_profile', 'UserController@editMusicianProfile');
    Route::post('delete_musician_education', 'UserController@deleteMusicianEducation');
    Route::post('delete_musician_experience', 'UserController@deleteMusicianExperience');
    Route::post('delete_musician_affiliation', 'UserController@deleteMusicianAffiliation');
    //    Chat Section
    Route::get('messages', 'ChatController@getChats');
    Route::get('groupchat', 'ChatController@getFriendsGroupChat');
    Route::get('student_studio_messages/{message_id}', 'ChatController@getStudentGroupChat');
    Route::get('teacher_studio_messages/{message_id}', 'ChatController@getTeacherGroupChat');

    Route::get('get_chat_detail/{other_id}', 'ChatController@getChatUserDetails');
    Route::get('get_chat', 'ChatController@getChat');
    Route::get('get_group_chat', 'ChatController@getGroupChat');
    
//    Route::get('get_student_studio_group_chat', 'ChatController@getStudentStudioGroupChat');

    Route::get('delete_message', 'ChatController@deleteMessage');
    Route::get('delete_group_message', 'ChatController@deleteGroupMessage');

    Route::get('delete_friends_message', 'ChatController@deleteFriendsMessage');
    Route::post('/add_message', 'ChatController@addMessage');
    Route::post('/add_group_message', 'ChatController@addGroupMessage');
    Route::post('/add_friends_message', 'ChatController@addFriendsMessage');
    Route::post('/save_studio_group_messages', 'ChatController@saveStudioGroupMessage');
    
    //student group messages
    Route::post('/add_student_message_from_messenger', 'ChatController@addStudentMessageFromMessenger');

    
    Route::post('delete_chat', 'ChatController@deleteChat');
    Route::post('delete_multiple_chats', 'ChatController@deleteMulitipleChat');
    Route::post('delete_multiple_friend_chats', 'ChatController@deleteMulitipleFriendChat');
    Route::get('download_file/{message_id}', 'ChatController@downloadFile');
    // group chat 
    Route::post('/message_to_group_members', 'GroupController@messageToGroupMembers');
    //    Services Chat
    Route::get('event_messages/{message_id}', 'ChatController@getChatGroups');
    Route::get('studio_messages/{message_id}', 'ChatController@getChatStudio');
    

    Route::get('accompanist_messages/{message_id}', 'ChatController@getChatAccompanist');
    //     Services Stats
    Route::get('group_stats/{group_id}', 'GroupController@stats');
    Route::get('teaching_studio_stats/{studio_id}', 'TeachingStudioController@stats');
    Route::get('accompanist_stats/{accompanist_id}', 'AccompanistController@stats');
    //    Payments Section
    Route::get('bank_account', 'PaymentsController@bankAccount');

    Route::post('save_legal_details', 'PaymentsController@saveLegalDetails');
    Route::post('savebank', 'PaymentsController@saveBank');
    Route::get('card', 'PaymentsController@card');
    Route::post('save_card', 'PaymentsController@saveCard');
    //    Booking section
    Route::post('add_booking', 'BookingController@addBooking');
    Route::get('booking', 'BookingController@getBookings');
    Route::get('download_invoice/{booking_id}', 'BookingController@downloadInvoice');
    Route::get('booking_details/{booking_id}', 'BookingController@bookingDetail');
    Route::get('fetch_bookings', 'BookingController@fetchBookings');
    Route::post('accept_booking', 'BookingController@acceptBooking');
    Route::post('check_bookings_on_the_same_day', 'BookingController@checkBookingsOnTheSameDay');
    Route::get('get_bookings_on_the_same_day/{booking_id}', 'BookingController@getBookingsOnTheSameDay');
    Route::post('decline_booking', 'BookingController@declineBooking');
    Route::post('request_payment', 'BookingController@requestPayment');
    Route::post('request_payment_admin', 'BookingController@requestPaymentAdmin');
    Route::post('add_availabilty', 'BookingController@AddAvailabilty');
    Route::post('approve_payment', 'BookingController@approvePayment');
    Route::post('reject_payment', 'BookingController@rejectPayment');
    Route::post('submit_dispute_reason', 'BookingController@submitDisputeReason');
    Route::post('request_partial_refund', 'BookingController@requestPartialRefund');
    Route::post('accept_partial_refund', 'BookingController@acceptPartialRefund');
    Route::post('reject_partial_refund', 'BookingController@rejectPartialRefund');
    Route::post('update_booking', 'BookingController@updateBooking');
    //    Follow Managment
    Route::get('follow_user', 'UserController@followUser');
    Route::get('unfollow_user', 'UserController@unfollowUser');
    Route::get('ignore_user', 'UserController@ignoreUser');
    //    Notifications Section
    Route::get('read_notifications', 'NotifcationController@readNotifications');
    Route::get('notifications', 'NotifcationController@getNotifications');

    Route::post('change_password', 'UserController@changePassword');
    Route::post('remove_user_interest', 'UserController@removeUserInterest');
    Route::post('add_user_interest', 'UserController@addUserInterest');
    Route::post('remove_user_education', 'UserController@removeUserEducation');
    Route::post('remove_user_experience', 'UserController@removeUserExperience');
    Route::post('remove_teaching_studio_education', 'TeachingStudioController@removeTeachingStudioEducation');
    Route::post('remove_teaching_studio_experience', 'TeachingStudioController@removeTeachingStudioExperience');
    Route::post('remove_accompanist_education', 'AccompanistController@removeAccompanistEducation');
    Route::post('remove_accompanist_experience', 'AccompanistController@removeAccompanistExperience');
    Route::post('delete_profile_pic', 'UserController@deleteUserProfilePic');
    Route::post('delete_cover_pic', 'UserController@deleteUserCoverPic');
    Route::post('upload_profile_pic', 'UserController@uploadProfilePic');
    Route::post('upload_service_profile_pic', 'UserController@uploadServiceProfilePic');
    Route::post('save_original_profile_pic', 'UserController@saveOriginalProfilePic');
    Route::post('upload_cover_pic', 'UserController@uploadCoverPic');
    Route::get('fetch_notifications', 'NotifcationController@fetchNotifications');

    Route::post('join_studio', 'TeachingStudioController@joinStudio');
    Route::post('join_studio_member', 'TeachingStudioController@joinStudioMember');   
    Route::post('refer_teacher_to_join_studio', 'TeachingStudioController@referTeacherToJoinStudio');

    Route::post('refer_student_to_join_studio', 'TeachingStudioController@referStudentToJoinStudio');

    
    
    Route::post('add_collaborative_friend', 'FriendController@addFriend');
    Route::post('add_group_member', 'GroupController@addGroupMember');
    Route::post('add_accompanist_member', 'AccompanistController@addAccompanistMember');

    //    Search members
    Route::get('get_all_members', 'UserController@getAllMembers');

    Route::group(['middleware' => ['nocache', 'musician']], function () {
        Route::get('/invitation_page', function () {
            $data['title'] = 'Musician | Invitation Page';
            return view('public.invitation_page', $data);
        });
        Route::post('delete_gallery_media', 'UserController@deleteGalleryMedia');

        Route::group(['middleware' => ['checkBankVerification']], function () {

            Route::get('create_gig', 'TimelineController@createGigView');
            Route::post('create_gig', 'TimelineController@createGig');

            Route::get('create_group', 'GroupController@createGroupView');
            Route::post('create_group', 'GroupController@createGroup');

            Route::get('create_teaching_studio', 'TeachingStudioController@createTeachingStudioView');
            Route::post('create_teaching_studio', 'TeachingStudioController@createTeachingStudio');

            Route::get('create_accompanist', 'AccompanistController@createAccompanistView');
            Route::post('create_accompanist', 'AccompanistController@createAccompanist');
        });

        Route::get('edit_gig/{gig_id}', 'TimelineController@editGigView');
        Route::post('timeline', 'TimelineController@postTimeline');

        Route::get('services', 'ServiceController@services');
        Route::get('create_service', 'ServiceController@createServiceView');
        Route::get('fetch_services', 'ServiceController@fetchServices');
        Route::get('fetch_dynamic_section_for_create_service', 'ServiceController@fetchServiceSection');

        Route::get('edit_group/{group_id}', 'GroupController@editGroupView');
        Route::post('edit_group', 'GroupController@editGroup');
        Route::get('groups', 'GroupController@groups');
        Route::get('fetch_groups', 'GroupController@fetchGroups');
        Route::post('delete_group', 'GroupController@deleteGroup');
        Route::post('remove_member_from_group', 'GroupController@removeMemberFromGroup');
        Route::post('delete_group_image', 'GroupController@deleteGroupImage');
        Route::post('join_group', 'GroupController@joinGroup');


        //        Teaching studio section
        Route::get('edit_teaching_studio/{teaching_studio_id}', 'TeachingStudioController@editTeachingStudioView');
        Route::post('edit_teaching_studio', 'TeachingStudioController@editTeachingStudio');
        Route::get('teaching_studios', 'TeachingStudioController@teachingStudios');
        Route::get('fetch_teaching_studios', 'TeachingStudioController@fetchTeachingStudios');
        Route::post('delete_teaching_studio', 'TeachingStudioController@deleteTeachingStudio');
        Route::post('remove_member_from_teaching_studio', 'TeachingStudioController@removeMemberFromTeachingStudio');
        Route::post('delete_teaching_studio_image', 'TeachingStudioController@deleteTeachingStudioImage');

        //        Accompanist section
        Route::get('edit_accompanist/{accompanist_id}', 'AccompanistController@editAccompanistView');
        Route::post('edit_accompanist', 'AccompanistController@editAccompanist');
        Route::get('accompanists', 'AccompanistController@accompanists');
        Route::get('fetch_accompanists', 'AccompanistController@fetchAccompanists');
        Route::post('delete_accompanist', 'AccompanistController@deleteAccompanist');
        Route::post('delete_accompanist_image', 'AccompanistController@deleteAccompanistImage');

        


        //        Reviews section
        Route::get('reviews', 'UserController@reviews');
        Route::get('fetch_reviews', 'UserController@fetchReviews');
        Route::get('statistics', 'UserController@statistics');
    });
    
    
    Route::post('join_group_response', 'GroupController@joinGroupResponse');
    Route::post('invite_group_response', 'GroupController@inviteGroupResponse');

    Route::post('add_friend_response', 'FriendController@addFriendResponse');
    Route::post('invite_friend_response', 'FriendController@inviteFriendResponse');

    Route::post('join_accompanist_response', 'AccompanistController@joinAccompanistResponse');
    Route::post('invite_accompanist_response', 'AccompanistController@inviteAccompanistResponse');

    Route::post('join_studio_response', 'TeachingStudioController@joinStudioResponse');
    Route::post('invite_studio_response', 'TeachingStudioController@inviteStudioResponse');
    
    
    Route::post('bookmark_group', 'FavouriteController@bookmarkGroup');
    Route::post('bookmark_teaching_studio', 'FavouriteController@bookmarkTeachingStudio');
    Route::post('bookmark_accompanist', 'FavouriteController@bookmarkAccompanist');
    Route::get('delete_review', 'UserController@deleteReview');
    Route::get('report_group', 'GroupController@reportGroup');
    Route::get('send_invititaion_mail', 'UserController@sendInvititaionMail');

    //    Deactivate Account
    Route::get('deactive_account', 'UserController@deactiveAccount');

    Route::get('search_youtube', 'TimelineController@searchYoutube');
    Route::get('get_youtube_video_link', 'TimelineController@getYoutubeVideoLink');
    
});

//Admin section
Route::get('admin_login', 'Admin\AuthController@loginView');
Route::post('admin_login', 'Admin\AuthController@login');

Route::group(['middleware' => ['checkAdmin', 'nocache']], function () {

    Route::get('admin_dashboard', 'Admin\AdminController@dashboard');
    Route::get('users_admin', 'Admin\AdminController@users');
    Route::get('active_users_admin', 'Admin\AdminController@activeUsers');
    Route::get('download_actives_uers_csv', 'Admin\AdminController@downloadActiveUsersCsv');
    Route::get('singup_users_admin', 'Admin\AdminController@signUpUsers');
    Route::get('musicians_admin', 'Admin\AdminController@musicians');
    Route::get('user_detail_admin/{user_id}', 'Admin\AdminController@userDetail');
    Route::get('jump_to_account/{user_id}', 'Admin\AdminController@jumpToAccount');
    Route::post('delete_user_admin', 'Admin\AdminController@deleteUser');
    Route::post('feature_user_admin', 'Admin\AdminController@featureUser');

    Route::get('categories_admin', 'Admin\AdminController@categories');
    Route::get('add_category_admin', 'Admin\AdminController@addCategoryView');
    Route::post('add_category_admin', 'Admin\AdminController@addCategory'); 
    Route::get('edit_category_admin/{id}', 'Admin\AdminController@editCategoryView');
    Route::post('edit_category_admin', 'Admin\AdminController@editCategory');
    Route::post('delete_category_admin', 'Admin\AdminController@deleteCategory');
    Route::post('action_on_category_admin', 'Admin\AdminController@actionOnCategory');

    Route::get('studio_categories_admin', 'Admin\AdminController@studioCategories');
    Route::get('add_studio_category_admin', 'Admin\AdminController@addStudioCategoryView');
    Route::post('add_studio_category_admin', 'Admin\AdminController@addStudioCategory');
    Route::post('delete_studio_category_admin', 'Admin\AdminController@deleteStudioCategory');

    Route::get('posts_admin', 'Admin\AdminController@posts');
    Route::get('reported_posts', 'Admin\AdminController@reportedPosts');
    Route::post('reported_post_mail', 'Admin\AdminController@reportedPostMail');
    Route::post('delete_post_admin', 'Admin\AdminController@deletePost');
    Route::post('delete_report_admin', 'Admin\AdminController@deleteReport');
    Route::post('send_message_all', 'Admin\AdminController@sendMessageAll');

    Route::get('groups_admin', 'Admin\AdminController@groups');
    Route::get('group_detail_admin/{group_id}', 'Admin\AdminController@groupDetail');
    Route::get('reported_groups', 'Admin\AdminController@reportedGroups');
    Route::post('delete_group_admin', 'Admin\AdminController@deleteGroup');
    Route::post('delete_group_report', 'Admin\AdminController@deleteReportGroup');

    Route::get('events_admin', 'Admin\AdminController@events');
    Route::get('event_detail_admin/{event_id}', 'Admin\AdminController@eventDetail');

    Route::get('teaching_studios_admin', 'Admin\AdminController@teachingStudios');
    Route::get('accompanists_admin', 'Admin\AdminController@accompanists');
    Route::post('delete_teaching_studio_admin', 'Admin\AdminController@deleteTeachingStudio');
    Route::post('delete_accompanist_admin', 'Admin\AdminController@deleteAccompanist');

    Route::get('unions_admin', 'Admin\AdminController@unions');
    Route::get('add_union_admin', 'Admin\AdminController@addUnionView');
    Route::post('add_union_admin', 'Admin\AdminController@addUnion');
    Route::post('delete_union_admin', 'Admin\AdminController@deleteUnion');

    Route::get('interest_admin', 'Admin\AdminController@interests');
    Route::get('add_interest_admin', 'Admin\AdminController@addInterestView');
    Route::post('add_interest_admin', 'Admin\AdminController@addInterest');
    Route::post('delete_interest_admin', 'Admin\AdminController@deleteInterest');

    Route::get('units_admin', 'Admin\AdminController@units');
    Route::get('add_unit_admin', 'Admin\AdminController@addUnitView');
    Route::post('add_unit_admin', 'Admin\AdminController@addUnit');
    Route::post('delete_unit_admin', 'Admin\AdminController@deleteUnit');

    Route::get('payments_admin', 'Admin\AdminController@payments');
    Route::post('payment_action_admin', 'Admin\AdminController@paymentAction');

    Route::get('reviews_admin', 'Admin\AdminController@reviews');

    Route::get('vulgar_terms_admin', 'Admin\AdminController@vulgarTerms');
    Route::get('add_vulgar_term_admin', 'Admin\AdminController@addVulgarTermView');
    Route::post('add_vulgar_term_admin', 'Admin\AdminController@addVulgarTerm');
    Route::post('delete_vulgar_term_admin', 'Admin\AdminController@deleteVulgarTerm');

    Route::get('change_password_admin', 'Admin\AdminController@changePasswordView');
    Route::post('change_password_admin', 'Admin\AdminController@changePassword');

    Route::get('admin_stats', 'Admin\AdminController@stats');
    Route::get('admin_booking_stats', 'Admin\AdminController@bookingStats');

    Route::get('logout_admin', 'Admin\AdminController@logout');
});

Route::get('/test', function () {
    return view('user/test');
});
