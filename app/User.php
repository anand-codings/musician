<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable {

    use Notifiable,
        Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    function getUnion() {
        return $this->hasOne('App\Union', 'id', 'union_id');
    }

    function getGigId() {
        return $this->hasOne('App\Post', 'user_id', 'id');
    }

    function getFollowers() {
        return $this->hasMany('App\UserFollower', 'user_id', 'id');
    }

    function getDoneBookings() {
        return $this->hasMany('App\Booking', 'user_id', 'id')->where('status', 'payment_approved');
    }

    function getFollowersIds() {
        return $this->hasMany('App\UserFollower', 'user_id', 'id')->select('followed_by');
    }

    function getFollowings() {
        return $this->hasMany('App\UserFollower', 'followed_by', 'id');
    }

    function getFollowingsIds() {
        return $this->hasMany('App\UserFollower', 'followed_by', 'id')->select('user_id');
    }

    function getSelectedCategories() {
        return $this->hasMany('App\SelectedMusicianCategory', 'artist_id', 'id');
    }

    function checkIfCurrentUserIsFollowedByOpenedProfileMusician() {
        return $this->hasOne('App\UserFollower', 'followed_by', 'id')->where('user_id', Auth::id());
    }

    function checkIfCurrentUserHasBookedProfileMusician() {
        return $this->hasOne('App\Booking', 'user_id', 'id')->where('booked_by', Auth::id());
    }

    function getUserInterests() {
        return $this->hasMany('App\UserInterest', 'user_id', 'id');
    }

    function getEducations() {
        return $this->hasMany('App\UserEducation', 'user_id', 'id');
    }

    function getExperiences() {
        return $this->hasMany('App\UserExperiences', 'user_id', 'id');
    }

    function getReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->orderBy('updated_at', 'desc');
    }
    function getProfileViews() {
        return $this->hasMany(ProfileView::class, 'profile_viewed', 'id')->orderBy('updated_at', 'desc');
    }

    function getAffiliations() {
        return $this->hasMany('App\Affiliation', 'user_id', 'id');
    }

    function getUnionIdsFromAffiliations() {
        return $this->hasMany('App\Affiliation', 'user_id', 'id')->select('union_id');
    }

    function getGroups() {
        return $this->hasMany('App\Group', 'admin_id', 'id');
    }

    function getPostsImages() {
        return $this->hasMany('App\Post', 'user_id', 'id')->where('type', 'image');
    }

    function getPostsAudios() {
        return $this->hasMany('App\Post', 'user_id', 'id')->where('type', 'audio');
    }

    function getPostsVideos() {
        return $this->hasMany('App\Post', 'user_id', 'id')->where('type', 'video');
    }

    function getFiveStarReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->where('rating', '==', 5);
    }

    function getFourStarReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->where('rating', '>=', 4)->where('rating', '<', 5);
    }

    function getThreeStarReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->where('rating', '>=', 3)->where('rating', '<', 4);
    }

    function getTwoStarReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->where('rating', '>=', 2)->where('rating', '<', 3);
    }

    function getOneStarReviews() {
        return $this->hasMany('App\Review', 'user_id', 'id')->where('rating', '>=', 1)->where('rating', '<', 2);
    }

    function getGalleryImages() {
        return $this->hasMany('App\GalleryMedia', 'user_id', 'id')->where('type', 'image');
    }

    function getGalleryAudios() {
        return $this->hasMany('App\GalleryMedia', 'user_id', 'id')->where('type', 'audio');
    }

    function getGalleryVideos() {
        return $this->hasMany('App\GalleryMedia', 'user_id', 'id')->where('type', 'video');
    }
    
    function requests() {
        return $this->hasOne('App\CollaborativeFriend', 'user_id', 'id')
                 ->when(Auth::user(), function($q) {
                        $q->where(['friend_id' => Auth::user()->id]);
                })->where(['is_approved' => '0', 'is_rejected' => '0'])
                    ->orderBy('updated_at', 'desc');
    }

    function friends() {
        return $this->hasMany('App\CollaborativeFriend', 'friend_id', 'id')->where(['is_approved' => '1', 'is_rejected' => '0']);
    }
    
    function checkFriend() {
        return $this->hasOne('App\CollaborativeFriend', 'friend_id', 'id')
                ->when(Auth::user(), function($q) {
                            $q->where(['user_id' => Auth::user()->id]);
                        });
    }

}
