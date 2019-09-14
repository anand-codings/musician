<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Accompanist;
use App\AccompanistImage;
use App\AccompanistEducation;
use App\AccompanistExperience;
use App\Notification;
use App\Language;
use Intervention\Image\Facades\Image;
use App\Booking;
use App\FollowServie;
use App\Review;
use App\SelectedAccompanistCategory;
use App\ServiceProfileView;
use App\Category;
use App\AccompanistMember;
use App\CollaborativeFriend;
use Illuminate\Support\Facades\File;

class FriendController extends Controller
{
    private $userId;
    private $user;
    private $userName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }
    
    function addFriend(Request $request) {
        
        $friend = User::find($request->user_id);
        $receiver_id = $friend->id;
        
        if ($friend) {
            
            if ($request['status'] == 'leave_response' || $request['status'] == 'cancel' || $request['status'] == 'requested') {
                    if(!empty($friend->requests)){
                        $collab_friend = CollaborativeFriend::where(['friend_id' => $this->userId, 'user_id' => $request['user_id']])->first();
                    } else {
                        $collab_friend = CollaborativeFriend::where(['friend_id' => $request['user_id'], 'user_id' => $this->userId])->first();
                    }
                    
                    if($collab_friend->is_approved == 1){
                        CollaborativeFriend::where(['user_id' => $request['user_id'], 'friend_id' => $this->userId])->delete();
                    }
                    
                    if(!empty($friend->requests)){
                        CollaborativeFriend::where(['friend_id' => $this->userId, 'user_id' => $request['user_id']])->delete();
                        $notification = Notification::where([
                            'user_id' => $friend->id,
                            'type' => 'friend',
                            'type_id' => $this->userId,
                            'unique_text' => 'friend' . $this->userId . '_request_by' . $friend->id
                        ])->delete();
                        
                    } else {
                        CollaborativeFriend::where(['friend_id' => $request['user_id'], 'user_id' => $this->userId])->delete();
                        $notification = Notification::where([
                            'user_id' => $this->userId,
                            'type' => 'friend',
                            'type_id' => $friend->id,
                            'unique_text' => 'friend' . $friend->id . '_request_by' . $this->userId
                        ])->delete();
                    }
//                    if ($request['status'] == 'leave') {
//                        return response()->json(array('success' => 'Unfriended successfully.', 'status' => 'leaved', 'notification' => $notification));
//                    }
                    return response()->json(array('success' => 'Unfriended successfully.', 'status' => 'leaved'));
                
            } else if ($request['status'] == 'leave') {
                
                    $collab_friend = CollaborativeFriend::where(['user_id' => $request['user_id'], 'friend_id' => $this->userId])->first();
                    if($collab_friend->is_approved == 1){
                        CollaborativeFriend::where(['friend_id' => $request['user_id'], 'user_id' => $this->userId])->delete();
                    }
                    
                    CollaborativeFriend::where(['user_id' => $request['user_id'], 'friend_id' => $this->userId])->delete();
                    $notification = Notification::where([
                        'user_id' => $this->userId,
                        'type' => 'friend',
                        'type_id' => $friend->id,
                        'unique_text' => 'friend' . $friend->id . '_request_by' . $this->userId
                    ])->delete();
                    
                    return response()->json(array('success' => 'Request Rejected successfully.', 'status' => 'leaved', 'notification' => $notification, 'on_user' => $receiver_id));

            } else if ($request['status'] == 'join') {
                
                    $collabfriend = new CollaborativeFriend();
                    $collabfriend->user_id = $this->userId;
                    $collabfriend->friend_id = $request['user_id'];
                    $collabfriend->type = 'main';
                    $collabfriend->save();
                    $notification = addNotificationThenGet($receiver_id, '', 'sent you a friend request ', 'friend', 'Friend', $friend->id, 'friend' . $friend->id . '_request_by' . $this->userId);
//                    $notification->save();
                    return response()->json(array('success' => 'Friend request sent successfully.', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }
    
    function addFriendResponse(Request $request){
        $friend = User::find($request['friend_id']);
        if ($friend) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_friend_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                CollaborativeFriend::where(['friend_id' => $request['friend_id'], 'user_id' => $request['user_id']])->delete();
                
                $notification = addNotificationThenGet($receiver_id, 'You sent friend request', 'rejected your friend request', 'friend', 'Friend', $friend->id, 'friend' . $friend->id . '_response_for' . $receiver_id);
                $notification->is_friend_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Musician friend request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $user_detail = User::find($request['user_id']);
                $collaborativeFriend = CollaborativeFriend::where(['friend_id' => $request['friend_id'], 'user_id' => $request['user_id']])->first();
                $collaborativeFriend->is_approved = 1;
                $collaborativeFriend->is_rejected = 0;
                $collaborativeFriend->save();
                
                $collaborativeFriend2 = new CollaborativeFriend;
                $collaborativeFriend2->user_id = $request['friend_id'];
                $collaborativeFriend2->friend_id = $request['user_id'];
                $collaborativeFriend2->type = 'main';
                $collaborativeFriend2->is_rejected = 0;
                $collaborativeFriend2->is_approved = 1;
                $collaborativeFriend2->save();
                
                $notification = addNotificationThenGet($receiver_id, 'Musician responded to the friend request', 'accepted your friend request', 'friend', 'Friend', $friend->id, 'friend' . $friend->id . '_response_for' . $receiver_id);
                $notification->is_friend_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Musician friend request approved.', 'status' => 'approved', 'notification' => $notification, 'photo' => $user_detail->photo, 'sender_id' => $user_detail->id, 'name'=> $user_detail->first_name.' '.$user_detail->last_name));
            }
        }
    }
    
    
    function inviteFriendResponse(Request $request){
        $friend = User::find($request['friend_id']);
        if ($friend) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_friend_invitee_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $collaborativeFriend = CollaborativeFriend::where(['friend_id' => $request['friend_id'], 'user_id' => $this->userId])->delete();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the friend invite request', 'rejected your invitation for friend request "' . $friend->name . '"', 'friend', 'Friend', $friend->id, 'friend' . $friend->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_friend_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Musician invitation request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $collaborativeFriend = CollaborativeFriend::where(['friend_id' => $request['friend_id'], 'user_id' => $this->userId])->first();
                $collaborativeFriend->is_approved = 1;
                $collaborativeFriend->is_rejected = 0;
                $collaborativeFriend->save();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of Musician', 'accepted your friend invitation "' . $friend->name . '"', 'friend', 'Friend', $friend->id, 'friend' . $friend->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_friend_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Friend invitation request approved.', 'status' => 'approved', 'notification' => $notification));
            }
        }
    }
}
