<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Interest;
use App\UserInterest;
use App\UserEducation;
use App\UserExperiences;
use App\Category;
use App\Affiliation;
use App\UserFollower;
use App\Group;
use App\GroupImage;
use App\GroupMember;
use App\Notification;
use App\GroupReport;
use Intervention\Image\Facades\Image;
use App\ProfileView;
use App\Booking;
use App\Review;
use App\FollowServie;
use App\Post;
use App\ServiceProfileView;
use App\CollaborativeFriend;
use Illuminate\Support\Facades\File;

use App\ChatGroup;
use App\ChatGroupMember;
use App\ChatGroupMessage;

class GroupController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $userLastName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            $this->userLastName = Auth::user()->last_name;
            return $next($request);
        });
    }
       function getChats() {
        $user_id = $this->userId;
        $other_id = '';
        $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $this->userId)->where('receiver_deleted', 0)->get()->toArray();
        echo '<pre>';print_r($chat_user_sender);exit;
        $chat_user_reciver = Chat::select('receiver_id as uid')->where('sender_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
        $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
        $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();
        $user_accompinist = Accompanist::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_groups = Group::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_studio = TeachingStudio::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $data['chats'] = Chat::with('sender', 'receiver')
                        ->withCount(['messages' => function ($q) {
                                $q->where('is_read', 0);
                            }])
                        ->where(function ($q) use($user_id) {
                            $q->where('sender_id', $user_id);
                            $q->orWhere('receiver_id', $user_id);
                        })->where(function ($q) use($user_accompinist) {
                            $q->whereNotIn('accompanist_id', $user_accompinist)
                            ->orWhereNull('accompanist_id');
                        })
                        ->where(function ($q) use($user_studio) {
                            $q->whereNotIn('studio_id', $user_studio)
                            ->orWhereNull('studio_id');
                        })
                        ->where(function ($q) use($user_groups) {
                            $q->whereNotIn('group_id', $user_groups)
                            ->orWhereNull('group_id');
                        })
                        ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                        ->orderBy('updated_at', 'desc')->get();
//        echo '<pre>';
//        print_r( $data['chats']);exit;
        $data['title'] = 'Messages';

        $data['latest_chat'] = Chat::with('sender', 'receiver')
                        ->withCount(['messages' => function ($q) {
                                $q->where('is_read', 0);
                            }])
                        ->where(function ($q) use($user_id) {
                            $q->where('sender_id', $user_id);
                            $q->orWhere('receiver_id', $user_id);
                        })
                        ->where(function ($q) use($user_accompinist) {
                            $q->whereNotIn('accompanist_id', $user_accompinist)
                            ->orWhereNull('accompanist_id');
                        })
                        ->where(function ($q) use($user_studio) {
                            $q->whereNotIn('studio_id', $user_studio)
                            ->orWhereNull('studio_id');
                        })
                        ->where(function ($q) use($user_groups) {
                            $q->whereNotIn('group_id', $user_groups)
                            ->orWhereNull('group_id');
                        })
                        ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                        ->orderBy('last_message_id', 'desc')->first();

        $data['messages'] = [];
        if ($data['latest_chat']) {
            $other_id = $data['latest_chat']->sender_id;
            if ($data['latest_chat']->sender_id == $user_id) {
                $other_id = $data['latest_chat']->receiver_id;
            }
            ChatMessage::where('chat_id', $data['latest_chat']->id)->where('receiver_id', $user_id)->update(['is_read' => 1]);
            $data['messages'] = ChatMessage::with('sender', 'receiver')
                    ->where('chat_id', $data['latest_chat']->id)
                    ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                    ->take(10)->skip(0)
                    ->orderBy('created_at', 'desc')
                    ->get();
        }
        $data['unread'] = ChatMessage::where('receiver_id', $user_id)->where(function ($q) use($user_accompinist) {
                            $q->whereNotIn('accompanist_id', $user_accompinist)
                            ->orWhereNull('accompanist_id');
                        })
                        ->where(function ($q) use($user_studio) {
                            $q->whereNotIn('studio_id', $user_studio)
                            ->orWhereNull('studio_id');
                        })
                        ->where(function ($q) use($user_groups) {
                            $q->whereNotIn('group_id', $user_groups)
                            ->orWhereNull('group_id');
                        })->where('is_read', 0)->count();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.messages', $data);
    }
    
  function referFriendsToJoinGroup(Request $request) {
        $group = Group::find($request['group_id']);
        $group_type = $request['group_type'];
        $receiver_id = $group->admin_id;
        $member_ids_string=($request->member_ids);
        $member_ids = explode(',', $member_ids_string);
        $notification=[];
   

        if((!empty($member_ids)) && (!empty($group))  && ($request['group_id'])){
           foreach ($member_ids as $key=>$member_id)
           {
                $groupMember = new GroupMember();
                $groupMember->user_id = $member_id;
//                $groupMember->type = $group_type;
                if($this->userId == $group->admin_id ){
                    $groupMember->is_approved = 1;
                }
                $groupMember->group_id = $request['group_id'];
                $groupMember->save();
                $user = User::select('id','first_name', 'last_name', 'photo')->findOrFail($member_id);
                
                if($this->userId != $group->admin_id ){
                    $notification[$key]['notification_for_admin'] = addNotificationForStudioAdminThenGet($groupMember->getGroupAdminDetail->admin_id, 'You are joining group',
                                                                    'wants to join your group "' . $group->name . '"' . '' . ', refer by '.$this->userName .' '.$this->userLastName, 
                                                                    'group',
                                                                    'Group', 
                                                                    $group->id, 
                                                                    'group' . $group->id . '_refer_to'.$user->id.'_by' . $this->userId, 
                                                                    $user);
                    $notification[$key]['refer_user_id'] = $user->id;
                    $notification[$key]['user_fname'] = $user->first_name;
                    $notification[$key]['user_lname'] = $user->last_name;
                    $notification[$key]['user_photo'] = $user->photo;
                } else {
                    $notificationsave = addNotificationThenGet($member_id, 'You are added to the Event Service',
                                                                                                        'added you to the Event Service "' . $group->name . '"', 
                                                                                                        'group',
                                                                                                        'Group', 
                                                                                                        $group->id, 
                                                                                                        'group' . $group->id . 'added_'.$member_id.'by_'.$this->userId);
                    $notificationsave->left_notification = 1;
                    $notificationsave->save();
                    $notification[$key]['notification_for_admin'] = $notificationsave;
                    $notification[$key]['refer_user_id'] = $user->id;
                    $notification[$key]['user_fname'] = $user->first_name;
                    $notification[$key]['user_lname'] = $user->last_name;
                    $notification[$key]['user_photo'] = $user->photo;

                }
             
               
           }
//           print_r($notification);exit;
          return response()->json(array('success' => 'Request Send Successfully ', 'error'=> '', 'user' => $user, 'notification' => $notification));
        }
        else 
        {
            
            return response()->json(array('success' => '', 'error'=>'Something went wrong', 'user' => '', 'notification' => ''));
        }
        

        
    }
     function messageToGroupMembers(Request $request) {
        $message_text = $request->message;
        $validation = $this->validate($request, [
            'receiver_id' => 'required'
        ]);
        
        $ids_string = $request['receiver_id'];
        $receiver_ids = explode(',', $ids_string);

        
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
            $file_extension = $request['file']->getClientOriginalExtension();
        }
        $sender_id = $this->userId;
                                
        $chat_group = new ChatGroup;
        $chat_group->admin_id = $sender_id;
        $chat_group->title = $request->title;

        if ($request->message_type) {
            $chat_group->type = $request->message_type;
            $chat_group->type_id = $request->type_id;
        }
//        }
        $chat_group->save();
        
        
        $message = new ChatGroupMessage;
        $message->chat_group_id = $chat_group->id;
        $message->admin_id = $sender_id;
        $message->sender_id = $sender_id;
        $message->message = $request['message'];
        $message->message_type = $request->message_type;
        if (!$request->message_type) {
            $message->message_type = 'u';
        }
        if ($request->message_type == 'g') {
            $message->group_id = $request->type_id;
            $message->type_id = $request->type_id;
        }
        if ($request->message_type == 's') {
            $message->studio_id = $request->type_id;
            $message->type_id = $request->type_id;
        }
        if ($request->message_type == 'a') {
            $message->accompanist_id = $request->type_id;
            $message->type_id = $request->type_id;
        }
        
        if ($request['file']) {
            if (substr($file_type, 0, 5) == 'image') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'image';
            }
            if ($file_extension == 'pdf') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'pdf';
            }
            if ($file_extension == 'doc' || $file_extension == 'txt' || $file_extension == 'docx' || $file_extension == 'csv' || $file_extension == 'xlsx' || $file_extension == 'xlsx' || $file_extension == 'xls') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'doc';
            }
            if ($file_extension == 'mp3') {
                $message->file_path = addFile($request['file'], 'chat');
                $message->poster = '';
                $message->file_type = 'mp3';
            }
            if (substr($file_type, 0, 5) == 'video') {
                $video = $request['file'];
                $video_data = addVideo($video, 'chat');
                $message->file_path = $video_data['file'];
                $message->poster = $video_data['poster'];
                $message->file_type = 'video';
            }
        }
        $message->save();
        
        
        $member = new ChatGroupMember();
        $member->chat_group_id = $chat_group->id;
        $member->member_id = $sender_id;
        $member->type_id = $request->type_id;
        if ($request->message_type == 'g') {
            $member->group_id = $request->type_id;
        }
        if ($request->message_type == 's') {
            $member->studio_id = $request->type_id;
        }
        if ($request->message_type == 'a') {
            $member->accompanist_id = $request->type_id;
        }
        $member->save();
        
        foreach ($receiver_ids as  $key=>$receiver_id){
            $value = User::findOrFail($receiver_id);
            if($key == 0){
                $group_members_images_string =  getUserImage($value->photo, $value->social_photo, $value->gender);
            } else {
                $group_members_images_string = $group_members_images_string.','. getUserImage($value->photo, $value->social_photo, $value->gender);
            }
            $member = new ChatGroupMember();
            $member->chat_group_id = $chat_group->id;
            $member->member_id = $receiver_id;
            $member->type_id = $request->type_id;
            if ($request->message_type == 'g') {
                $member->group_id = $request->type_id;
            }
            if ($request->message_type == 's') {
                $member->studio_id = $request->type_id;
            }
            if ($request->message_type == 'a') {
                $member->accompanist_id = $request->type_id;
            }
            $member->save();
            addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in event service '.$request->title, 'message', 'ChatMessage', $message->id, 'group_message_to' . $chat_group->id . '_message_by' . $sender_id);
        }
         //concatenate of admin photo with
         $group_members_images_string = $group_members_images_string .','.getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
         $single_message['group_member_images']=$group_members_images_string;
        
        $chat_group->last_message_id = $message->id;
        $chat_group->save();
        $user_id = $this->userId;
        $chat_id = $message->chat_group_id;
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Group Messages';
        $data['chat_group_id'] = $chat_group->id;
        
        $chat = ChatGroup::find($chat_group->id);
        $other_id = $chat->admin_id;
//        if ($chat->sender_id == $user_id) {
//            $other_id = $chat->receiver_id;
//        }
        $data['messages'] = ChatGroupMessage::with('chatgroup','receiver')
                ->where('chat_group_id', $chat_group->id)->where('id', $message->id)
                ->get();
        $data['other_message_user'] = $this->user;
        $data['other_user_chat_id'] = $this->userId;
        $single_message['append'] = view('user.messages_ajax', $data)->render();
        $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
        $single_message['chat_id'] = $chat_id;
        
        echo json_encode($single_message);
    }

   
    function createGroupView() {
        $data['title'] = 'Musician | Create Group';
        $data['categories'] = Category::orderBy('title')->get();
        return view('user.create_group', $data);
    }

    function createGroup(Request $request) {
        $validation = $this->validate($request, [
            'name' => 'required',
            'artist_type_id' => 'required',
            'since' => 'required',
            'address' => 'required',
            'description' => 'required',
        ]);
        $group = new Group();
        $group->name = $request['name'];
        if ($request['allow_booking']) {
            $group->allow_booking = 1;
        }
        $group->since = $request['since'];
        $group->description = $request['description'];
        $group->admin_id = $this->userId;
        $group->category_id = $request['artist_type_id'];
        $group->location = $request['address'];
        $group->lat = $request['lat'];
        $group->lng = $request['lng'];
        $pic = $request->pic;
        if ($pic && $pic != 'undefined') {
            $pic = str_replace('data:image/png;base64,', '', $pic);
            $pic = str_replace(' ', '+', $pic);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            $destinationPath = public_path('../public/images/groups');
            $group->pic = $request->photo;
            $group->original_pic = $request->original_photo;
//            $completePath = 'public/images/groups/' . $image_name;
            addMediaForBase64Images('public/images/' . $request->photo, 'image', '', $request->pic);
        }

        $cover = $request->file('cover');
        if ($cover) {
            $destinationPath = public_path('../public/images/groups');
            $cover_name = "cover-" . uniqid() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/groups/' . $cover_name);
            $group->cover = 'groups/' . $cover_name;
            $input['imagename'] = "cover-" . uniqid() . '.' . $cover->getClientOriginalExtension();
            $group->original_cover = 'groups/' .$input['imagename'];
            $completePath = 'public/images/groups/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);
        }
        $group->save();
        $gender = $group->user->gender;
        if ($gender == 'male') {
            $gender = 'his';
        } else {
            $gender = 'her';
        }
        $notifications = new \Illuminate\Support\Collection();
        if ($request['members']) {
            $members = explode(",", $request['members']);
            foreach ($members as $member) {
                if ($member != $this->userId) {
                    $groupMember = new GroupMember();
                    $groupMember->user_id = $member;
                    $groupMember->group_id = $group->id;
                    $groupMember->save();
                    $notification = addNotificationThenGet($member, 'You are invited to join a group', 'invited you to join ' . $gender . ' event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_invite_request_by_musician' . $this->userId . '_to_user' . $member);
                    $notification->is_group_invite = 1;
                    $notification->is_group_request_response = 1;
                    $notification->save();
                    $notifications->push($notification);
                }
            }
        }
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $groupImage = new GroupImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/groups');
                        $groupImage->file = 'groups/' . $input['imagename'];
                        $groupImage->group_id = $group->id;
                        $groupImage->save();
                        $completePath = 'public/images/groups/' . $input['imagename'];
                        addMedia($completePath, 'image', '', $galleryImage);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }
        return response()->json(array('success' => 'Event service created successfully', 'group_name' => $group->name, 'notifications' => $notifications));
//        Session::flash('success', 'Group created successfully.');
//        return Redirect::to(URL::previous());
    }

    function editGroupView($group_id) {
        $data['group'] = Group::where(['id' => $group_id, 'admin_id' => $this->userId])->first();
        if (!$data['group']) {
            return Redirect::to(URL::previous());
        }
        $data['title'] = 'Musician | Create Group';
        $data['artistTypes'] = Category::where('is_for_group', 1)->orderBy('title')->get();
        return view('user.edit_group', $data);
    }
    
    
    function addGroupMember(Request $request) {
        
        $group = Group::find($request->group_id);
        $receiver_id = $group->admin_id;
        if ($group) {
            if ($request['status'] == 'leave' || $request['status'] == 'requested' || $request['status'] == 'cancel') {
                GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->delete();
                $notification = Notification::where([
                    'user_id' => $this->userId,
                    'type' => 'group',
                    'type_id' => $group->id,
                    'unique_text' => 'group' . $group->id . '_join_request_by' . $this->userId
                ])->delete();
                if ($request['status'] == 'leave') {
                    return response()->json(array('success' => 'Event service left successfully.', 'status' => 'leaved', 'notification' => $notification, 'admin_id'=>$receiver_id));
                }
                return response()->json(array('success' => 'Event service left successfully.', 'status' => 'leaved', 'notification' => $notification, 'admin_id'=>$receiver_id));
            } else if ($request['status'] == 'join') {
                $groupMember = new GroupMember();
                $groupMember->user_id = $this->userId;
                $groupMember->group_id = $request['group_id'];
                $groupMember->save();
                $notification = addNotificationThenGet($receiver_id, '', 'wants to join your event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_join_request_by' . $this->userId);
//                $notification->left_notification = 1;
                $notification->save();
                return response()->json(array('success' => 'Event service joining request sent successfully.', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }

    function editGroup(Request $request) {
//        return response()->json($request->all());
//        dd($request->all());
        $validation = $this->validate($request, [
            'name' => 'required',
            'artist_type_id' => 'required',
            'since' => 'required',
            'address' => 'required',
            'description' => 'required',
            'group_id' => 'required',
        ]);
        $group = Group::find($request['group_id']);
        $group->name = $request['name'];
        if ($request['allow_booking']) {
            $group->allow_booking = 1;
        } else {
            $group->allow_booking = 0;
        }
        $group->since = $request['since'];
        $group->description = $request['description'];
        $group->admin_id = $this->userId;
        $group->category_id = $request['artist_type_id'];
        $group->location = $request['address'];
        $group->lat = $request['lat'];
        $group->lng = $request['lng'];
        $pic = $request->pic;

        $old_photo     = 'public/images/'.$group->pic;
        $old_original_photo     = 'public/images/'.$group->original_pic;
        if ($pic && $pic != 'undefined') {
            $group->pic = $request->photo;
            $group->original_pic = $request->original_photo;
            if(File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if(File::exists($old_photo)) {
                File::delete($old_photo);
            }
        }else{
            if($request->photo){
                $group->pic = $request->photo;
                if(File::exists($old_photo)) {
                    File::delete($old_photo);
                }
            }
        }
        $del_flag   = $request['pro_del_flag'];
        //remove profile pic from server & DB
        if($del_flag==1){
            $group->pic = NULL;
            $group->original_pic = NULL;
            if(File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if(File::exists($old_photo)) {
                File::delete($old_photo);
            }
        }

        $old_cover     = 'public/images/'.$group->cover;
        $old_original_cover     = 'public/images/'.$group->original_cover;
        $cover          = $request->file('cover');
        if ($cover) {
            $destinationPath = public_path('../public/images/groups');
            $cover_name = "cover-" . uniqid() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/groups/' . $cover_name);
            $group->cover = 'groups/' . $cover_name;
            $input['imagename'] = "cover-" . uniqid() . '.' . $cover->getClientOriginalExtension();
            $group->original_cover = 'groups/' .$input['imagename'];
            $completePath = 'public/images/groups/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);

            if(File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if(File::exists($old_cover)) {
                File::delete($old_cover);
            }
        }else {
                if($request->image_croped) {
                    $destinationPath = public_path('../public/images/groups');
                    $cover_name = "cover-" . uniqid() . ".png";
                    Image::make(file_get_contents($request->image_croped))->save('public/images/groups/' . $cover_name);
                    $group->cover = 'groups/' . $cover_name;

                    if (File::exists($old_cover)) {
                        File::delete($old_cover);
                    }
                }
            }

        //remove cover pic from server & DB
        $cov_is_delete   = $request['cov_del_flag'];
        if($cov_is_delete==1){
            $group->cover = NULL;
            $group->original_cover = NULL;
            if(File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if(File::exists($old_cover)) {
                File::delete($old_cover);
            }
        }
        $group->save();
//        dd($request->all());
        $gender = $group->user->gender;
        if ($gender == 'male') {
            $gender = 'his';
        } else {
            $gender = 'her';
        }
        $notifications = new \Illuminate\Support\Collection();
        if ($request['members']) {
            $members = explode(",", $request['members']);
            foreach ($members as $member) {
                if ($member != $this->userId) {
                    $groupMember = new GroupMember();
                    $groupMember->user_id = $member;
                    $groupMember->group_id = $group->id;
                    $groupMember->save();
                    $notification = addNotificationThenGet($member, 'You are invited to join a group', 'invited you to join ' . $gender . ' event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_invite_request_by_musician' . $this->userId . '_to_user' . $member);
                    $notification->is_group_invite = 1;
                    $notification->is_group_request_response = 1;
                    $notification->save();
                    $notifications->push($notification);
                }
            }
        }
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $groupImage = new GroupImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/groups');
                        $groupImage->file = 'groups/' . $input['imagename'];
                        $groupImage->group_id = $group->id;
                        $groupImage->save();
                        $completePath = 'public/images/groups/' . $input['imagename'];
                        addMedia($completePath, 'image', '', $galleryImage);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }
        return response()->json(array('success' => 'Event service updated successfully', 'group_name' => $group->name, 'notifications' => $notifications));
//        Session::flash('success', 'Group created successfully.');
//        return Redirect::to(URL::previous());
    }

    function groups() {
        $data['title'] = 'Musician | Event Services';
        return view('user.groups', $data);
    }

    function fetchGroups(Request $request) {
//        dd($request->all());
        if ($request['type'] == 'owned') {
            $data['groups'] = Group::where('admin_id', $this->userId)
                    ->take($request->take)
                    ->skip($request->skip)
                    ->get();
        } else if ($request['type'] == 'joined') {
            $groupIds = GroupMember::where(['user_id' => $this->userId, 'is_approved' => 1])->select('group_id')->get()->toArray();
            $data['groups'] = Group::whereIn('id', $groupIds)
                    ->take($request->take)
                    ->skip($request->skip)
                    ->get();
        }
        return view('user.loader.groups_loader', $data);
    }

    function deleteGroup(Request $request) {
        $group = Group::where(['id' => $request->group_id, 'admin_id' => $this->userId])->first();
        if ($group) {
            deleteNotification('group', $request->group_id);
            $group->delete();
            return response()->json(array('success' => 'Group delete successfully.'));
        }
        return response()->json(array('error' => 'Group not found.'));
    }

    function removeMemberFromGroup(Request $request) {
        $groupMember = GroupMember::where(['user_id' => $request->group_member_user_id, 'group_id' => $request->group_id])->first();
        if ($groupMember) {
            $groupMember->delete();
            return response()->json(array('success' => 'Group member removed successfully.'));
        }
        return response()->json(array('error' => 'Group member not found.'));
    }

    function deleteGroupImage(Request $request) {
        $image = GroupImage::where('id', $request->group_image_id)->first();
        if ($image) {
            $image->delete();
            return response()->json(array('success' => 'Group image deleted successfully.'));
        }
        return response()->json(array('error' => 'Group image not found.'));
    }

    function joinGroup(Request $request) {
        $group = Group::find($request['group_id']);
        $receiver_id = $group->admin_id;
        if ($group) {
            if ($request['status'] == 'leave' || $request['status'] == 'requested') {
                GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->delete();
                Notification::where([
                    'user_id' => $this->userId,
                    'type' => 'group',
                    'type_id' => $group->id,
                    'unique_text' => 'group' . $group->id . '_join_request_by' . $this->userId
                ])->delete();
                if ($request['status'] == 'leave') {
                    
                    return response()->json(array('success' => 'Event service leaved successfully.', 'status' => 'leaved', 'notification' => $notification));
                }
                return response()->json(array('success' => 'Event service leaved successfully.', 'status' => 'leaved'));
            } else if ($request['status'] == 'join') {
                $groupMember = new GroupMember();
                $groupMember->user_id = $this->userId;
                $groupMember->group_id = $request['group_id'];
                $groupMember->save();
                $notification = addNotificationThenGet($receiver_id, '', 'wants to join your event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_join_request_by' . $this->userId);
                //$notification->left_notification = 1;
                $notification->save();
                return response()->json(array('success' => 'Event service joining request sent successfully.', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }

    function joinGroupResponse(Request $request) {
        $group = Group::find($request['group_id']);
        if ($group) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_group_admin_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $request['user_id']])->delete();
//                  $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $request['user_id']])->first();

//                $groupMember->is_rejected = 1;
//                $groupMember->is_approved = 0;
//                $groupMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You requested to join the group', 'rejected your request to join event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_response_for' . $receiver_id);
                $notification->is_group_request_response = 1;
                $notification->save();
                
                return response()->json(array('success' => 'Event service joining request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $user_img = User::find($request['user_id']);
                $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $request['user_id']])->first();
                $groupMember->is_approved = 1;
                $groupMember->is_rejected = 0;
                $groupMember->save();
                $notification = addNotificationThenGet($receiver_id, 'Group admin responded to the group join request', 'accepted your request to join event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_response_for' . $receiver_id);
                $notification->is_group_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Group joining request approved.', 'status' => 'approved', 'notification' => $notification, 'photo'=> $user_img->photo));
            }
        }
    }

    function inviteGroupResponse(Request $request) {
        $group = Group::find($request['group_id']);
        $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->first();
        if ($group) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_group_invitee_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->delete();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the group', 'rejected your invitation to join event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_group_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Group invitation request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $groupMember = GroupMember::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->first();
                $groupMember->is_approved = 1;
                $groupMember->is_rejected = 0;
                $groupMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the group', 'accepted your invitation to join event service "' . $group->name . '"', 'group', 'Group', $group->id, 'group' . $group->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_group_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Group invitation request approved.', 'status' => 'approved', 'notification' => $notification));
            }
        }
    }

    function reportGroup(Request $request) {
        $post_flag = GroupReport::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->first();
        if (!$post_flag) {
            $post_flag = new GroupReport;
        }
        $post_flag->group_id = $request['group_id'];
        $post_flag->user_id = $this->userId;
        $post_flag->reason = $request['reason'];
        if ($post_flag->save()) {

            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 200);
        }
    }

    function stats($group_id) {
        $data['title'] = 'Musician |Event Statistics';
        $data['user'] = $this->user;
        $data['group']= Group::find($group_id);
        $views_stats_data = [];
        $views_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = ServiceProfileView::where('group_id', $group_id)->whereDate('created_at', $date)->count();
            array_push($views_stats_data, $count);
            array_push($views_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['views_stats_labels'] = $views_stats_labels;
        $data['views_stats_data'] = $views_stats_data;
        $followers_stats_data = [];
        $followers_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = FollowServie::where('group_id', $group_id)->whereDate('created_at', $date)->count();
            array_push($followers_stats_data, $count);
            array_push($followers_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['followers_stats_labels'] = $followers_stats_labels;
        $data['followers_stats_data'] = $followers_stats_data;

        $gigs_stats_data = [];
        $gigs_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::where(['group_id' =>$group_id, 'status' => 'payment_approved'])->whereDate('created_at', $date)->count();
            array_push($gigs_stats_data, $count);
            array_push($gigs_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['gigs_stats_data'] = $gigs_stats_data;
        $data['gigs_stats_labels'] = $gigs_stats_labels;

        $reviews_stats_data = [];
        $reviews_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Review::where('group_id', $group_id)->whereDate('created_at', $date)->count();
            array_push($reviews_stats_data, $count);
            array_push($reviews_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['reviews_stats_data'] = $reviews_stats_data;
        $data['reviews_stats_labels'] = $reviews_stats_labels;
        return view('user.statistics_groups', $data);
    }

}
