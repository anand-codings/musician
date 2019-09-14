<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Chat;
use App\ChatMessage;
use App\User;
use Illuminate\Support\Facades\Mail;
use App\Emailsetting;
use App\Privacysetting;
use App\Group;
use App\Accompanist;
use App\TeachingStudio;
use App\ChatGroup;
use App\ChatGroupMember;
use App\ChatGroupMessage;
use App\CollaborativeFriend;


class ChatController extends Controller
{

    private $userId;
    private $user;
    private $userName;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getChats()
    {

        $user_id = $this->userId;
        $other_id = '';
        $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $this->userId)->where('receiver_deleted', 0)->get()->toArray();
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
            ->where(function ($q) use ($user_id) {
                $q->where('sender_id', $user_id);
                $q->orWhere('receiver_id', $user_id);
            })->where(function ($q) use ($user_accompinist) {
                $q->whereNotIn('accompanist_id', $user_accompinist)
                    ->orWhereNull('accompanist_id');
            })
            ->where(function ($q) use ($user_studio) {
                $q->whereNotIn('studio_id', $user_studio)
                    ->orWhereNull('studio_id');
            })
            ->where(function ($q) use ($user_groups) {
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
            ->where(function ($q) use ($user_id) {
                $q->where('sender_id', $user_id);
                $q->orWhere('receiver_id', $user_id);
            })
            ->where(function ($q) use ($user_accompinist) {
                $q->whereNotIn('accompanist_id', $user_accompinist)
                    ->orWhereNull('accompanist_id');
            })
            ->where(function ($q) use ($user_studio) {
                $q->whereNotIn('studio_id', $user_studio)
                    ->orWhereNull('studio_id');
            })
            ->where(function ($q) use ($user_groups) {
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
        $data['unread'] = ChatMessage::where('receiver_id', $user_id)->where(function ($q) use ($user_accompinist) {
            $q->whereNotIn('accompanist_id', $user_accompinist)
                ->orWhereNull('accompanist_id');
        })
            ->where(function ($q) use ($user_studio) {
                $q->whereNotIn('studio_id', $user_studio)
                    ->orWhereNull('studio_id');
            })
            ->where(function ($q) use ($user_groups) {
                $q->whereNotIn('group_id', $user_groups)
                    ->orWhereNull('group_id');
            })->where('is_read', 0)->count();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.messages', $data);
    }


    function getFriendsGroupChat()
    {
        $user_id = $this->userId;
        $other_id = '';
        $data['groupchats'] = ChatGroup::whereHas('getRelatedChat')->with('getRelatedChat', 'lastMessage')
            ->where('group_deleted', '0')
            ->where('sender_deleted', '0')
            ->where('type_id', '0')
            ->orderBy('updated_at', 'desc')
            ->get();

        $chat_user_sender = ChatGroup::select('admin_id as uid')->where('admin_id', $this->userId)->where('sender_deleted', 0)->where('group_deleted', 0)->get()->toArray();
        $chat_user_reciver = ChatGroupMember::select('member_id as uid')->where('member_id', $this->userId)->get()->toArray();
        $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
        $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();
        $user_accompinist = Accompanist::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_groups = Group::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_studio = TeachingStudio::select('id')->where('admin_id', $this->userId)->get()->toArray();

        $data['title'] = 'Friends Group Chats';

        $data['latest_chat'] = ChatGroup::with('sender', 'receiver')->whereHas('getRelatedChat')
            ->withCount(['messages' => function ($q) {
                $q->where('is_read', 0);
            }])
            ->where(function ($q) use ($user_accompinist) {
                $q->whereNotIn('type_id', $user_accompinist)
                    ->orWhereNull('type_id');
            })
            ->where(function ($q) use ($user_studio) {
                $q->whereNotIn('type_id', $user_studio)
                    ->orWhereNull('type_id');
            })
            ->where(function ($q) use ($user_groups) {
                $q->whereNotIn('type_id', $user_groups)
                    ->orWhereNull('type_id');
            })
            ->where('group_deleted', 0)
            ->where('sender_deleted', 0)
            ->where('type_id', '0')
            ->orderBy('last_message_id', 'desc')->first();


        $data['messages'] = [];
        if ($data['latest_chat']) {
            ChatGroupMember::where('member_id', $user_id)->where('type_id','0')->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
            $other_id = $data['latest_chat']->admin_id;
            $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
                ->where('chat_group_id', $data['latest_chat']->id)
                ->take(10)->skip(0)
                ->orderBy('created_at', 'desc')
                ->where('sender_deleted', 0)
                ->get();
        }
        $data['unread'] = ChatGroupMember::where('member_id', $user_id)->where('is_read', 0)->count();
        $data['friends'] = CollaborativeFriend::where('friend_id', $this->userId)->with('getFriendDetail')->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.friends_group_messages', $data);
    }

    function getStudentGroupChat($studio_id)
    {
        $data['studio'] = TeachingStudio::where('id', $studio_id)->with('members')->first();
        $user_id = $this->userId;
        $other_id = '';
        $data['groupchats'] = ChatGroup::whereHas('getRelatedChat')->with('getRelatedChat')
            ->where('group_deleted', '0')
            ->where('type_id', $studio_id)
            ->where('type', 's')
            ->orderBy('updated_at', 'desc')
            ->get();
        $chat_user_sender = ChatGroup::select('admin_id as uid')->where('admin_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
        $chat_user_reciver = ChatGroupMember::select('member_id as uid')->where('member_id', $this->userId)->get()->toArray();
        $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
        $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->get();
        $user_accompinist = Accompanist::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_groups = Group::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_studio = TeachingStudio::select('id')->where('admin_id', $this->userId)->get()->toArray();

        $data['title'] = 'Musician | Student Group Chat';

        $data['latest_chat'] = ChatGroup::with('sender', 'receiver')->whereHas('getRelatedChat')
            ->withCount(['messages' => function ($q) {
                $q->where('is_read', 0);
            }])
            ->where('type', 's')
            ->where('type_id', $studio_id)
            ->orderBy('last_message_id', 'desc')->first();
        $data['messages'] = [];
        if ($data['latest_chat']) {
            ChatGroupMember::where('member_id', $user_id)->where('type_id', $studio_id)->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
            $other_id = $data['latest_chat']->admin_id;
            $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
                ->where('chat_group_id', $data['latest_chat']->id)
                ->take(10)->skip(0)
                ->orderBy('created_at', 'desc')
                ->where('sender_deleted', 0)
                ->get();
        }
        $data['unread'] = ChatGroupMember::where('member_id', $user_id)->where('is_read', 0)->count();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.student_group_messages', $data);
    }

    function getTeacherGroupChat($studio_id)
    {
        $data['studio'] = TeachingStudio::where('id', $studio_id)->first();
        $user_id = $this->userId;
        $other_id = '';  //where('admin_id',$user_id)->
        $data['groupchats'] = ChatGroup::whereHas('getRelatedChat')->with('getRelatedChat')
            ->where('group_deleted', '0')
            ->where('type_id', $studio_id)
            ->where('type', 't')
            ->orderBy('updated_at', 'desc')
            ->get();


//         ChatGroup::innerjoin('chat_group_members', function($join){
//                                        $join->on('chat_groups.id', '=', 'chat_group_members.chat_group_id');
//                                         })
//                                        ->where('chat_group_members.member_id', '=', $user_id)
//                                        ->where('chat_groups.group_deleted','0')
//                                        ->orderBy('chat_groups.updated_at', 'desc')
//                                        ->get();

//        $user_groups = ChatGroupMember::where('member_id',$user_id)->where('member_left','0')->where('group_deleted','0')->get();
//        
        $chat_user_sender = ChatGroup::select('admin_id as uid')->where('admin_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
        $chat_user_reciver = ChatGroupMember::select('member_id as uid')->where('member_id', $this->userId)->get()->toArray();
        $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
        $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->get();
        $user_accompinist = Accompanist::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_groups = Group::select('id')->where('admin_id', $this->userId)->get()->toArray();
        $user_studio = TeachingStudio::select('id')->where('admin_id', $this->userId)->get()->toArray();


//        $data['chats'] = ChatGroup::with('sender', 'receiver')
//                        ->withCount(['messages' => function ($q) {
//                                $q->where('is_read', 0);
//                            }])
//                        ->where(function ($q) use($user_accompinist) {
//                            $q->whereNotIn('type_id', $user_accompinist)
//                            ->orWhereNull('type_id');
//                        })
//                        ->where(function ($q) use($user_studio) {
//                            $q->whereNotIn('type_id', $user_studio)
//                            ->orWhereNull('type_id');
//                        })
//                        ->where(function ($q) use($user_groups) {
//                            $q->whereNotIn('type_id', $user_groups)
//                            ->orWhereNull('type_id');
//                        })
//                        ->orderBy('updated_at', 'desc')->get();

        $data['title'] = 'Musician | Teacher Group Chat';

        $data['latest_chat'] = ChatGroup::with('sender', 'receiver')->whereHas('getRelatedChat')
            ->withCount(['messages' => function ($q) {
                $q->where('is_read', 0);
            }])
            ->where('type', 't')
            ->where('type_id', $studio_id)
//                        ->where(function ($q) use($user_accompinist) {
//                            $q->whereNotIn('type_id', $user_accompinist)
//                            ->orWhereNull('type_id');
//                        })
//                        ->where(function ($q) use($user_studio) {
//                            $q->whereNotIn('type_id', $user_studio)
//                            ->orWhereNull('type_id');
//                        })
//                        ->where(function ($q) use($user_groups) {
//                            $q->whereNotIn('type_id', $user_groups)
//                            ->orWhereNull('type_id');
//                        })
            ->orderBy('last_message_id', 'desc')->first();
        $data['messages'] = [];
        if ($data['latest_chat']) {
//            print_r($data['latest_chat']); exit;
            $other_id = $data['latest_chat']->admin_id;
//            if ($data['latest_chat']->sender_id == $user_id) {
//                $other_id = $data['latest_chat']->receiver_id;
//            }
//            ChatGroupMessage::where('chat_group_id', $data['latest_chat']->id)->where('sender_id', $user_id)->update(['is_read' => 1]);
            ChatGroupMember::where('member_id', $user_id)->where('type_id', $studio_id)->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
            $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
                ->where('chat_group_id', $data['latest_chat']->id)
//                    ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->take(10)->skip(0)
                ->orderBy('created_at', 'desc')
                ->where('sender_deleted', 0)
                ->get();
        }
//        echo '<pre>'; print_r($data['messages']);exit;
        $data['unread'] = ChatGroupMember::where('type_id', $studio_id)->where('is_read', 0)->count();

//                        print_r($data['messages']); exit;
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.teacher_group_messages', $data);
    }


    function getChatUserDetails($other_id)
    {
        $check = User::find($other_id);
        if (!$check) {
            return Redirect::to(Url::previous());
        }
        $user_id = $this->userId;
        $data['title'] = 'Messages';
        ChatMessage::where(array('sender_id' => $other_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $chat = Chat::where(function ($q) use ($user_id, $other_id) {
            $q->where('sender_id', $user_id);
            $q->where('receiver_id', $other_id);
        })
            ->orwhere(function ($q) use ($other_id, $user_id) {
                $q->where('sender_id', $other_id);
                $q->where('receiver_id', $user_id);
            })->first();

        if ($chat) {
            $data['chat_user_id'] = $chat->id;
        } else {
            $data['chat_user_id'] = '';
        }
        $data['messages'] = ChatMessage::with('sender', 'receiver')
            ->where(function ($q) use ($user_id, $other_id) {
                $q->where(function ($q) use ($user_id, $other_id) {
                    $q->where('sender_id', $user_id);
                    $q->where('receiver_id', $other_id);
                })
                    ->orwhere(function ($q) use ($other_id, $user_id) {
                        $q->where('sender_id', $other_id);
                        $q->where('receiver_id', $user_id);
                    });
            })
            ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.messages', $data);
    }

    function getChat(Request $request)
    {
        $chat_id = $request->chat_id;
        $user_id = $this->userId;
        ChatMessage::where(array('chat_id' => $chat_id, 'receiver_id' => $user_id))->update(['is_read' => 1]);
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Messages';
        $data['chat_user_id'] = $chat_id;
        $chat = Chat::find($chat_id);
        $other_id = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_id = $chat->receiver_id;
        }
        $data['messages'] = ChatMessage::with('sender', 'receiver')
            ->where('chat_id', $chat_id)
            ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
            ->skip($request->skip)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.messages_ajax', $data);
    }

    function getGroupChat(Request $request)
    {

        $chat_id = $request->chat_id;
        $user_id = $this->userId;
//       ChatGroupMember::where(array('chat_group_id' => $chat_id, 'member_id' => $user_id))->update(['is_read' => 1]);
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Group Messages';
        $data['chat_user_id'] = $chat_id;
        $chat = ChatGroup::find($chat_id);
        $other_id = $chat->admin_id;
//        if ($chat->sender_id == $user_id) {
//            $other_id = $chat->receiver_id;
//        }
        $data['latest_chat'] = ChatGroup::where('id',$chat_id)->with('sender', 'receiver')->whereHas('getRelatedChat')
            ->withCount(['messages' => function ($q) {
                $q->where('is_read', 0);
            }])
            ->where('group_deleted', 0)
            ->where('sender_deleted', 0)
            ->where('type_id', '0')
            ->orderBy('last_message_id', 'desc')->first();

        ChatGroupMember::where('member_id', $user_id)->where('chat_group_id', $chat_id)->update(['is_read' => 1]);
        $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
            ->where('chat_group_id', $chat_id)
            ->skip($request->skip)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        return view('user.messages_ajax', $data);
    }


    function addMessage(Request $request)
    {
        $validation = $this->validate($request, [
            'receiver_id' => 'required'
        ]);
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
            $file_extension = $request['file']->getClientOriginalExtension();
        }
        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $chat_user = Chat::where(function ($q) use ($receiver_id, $sender_id) {
            $q->where(function ($q) use ($receiver_id, $sender_id) {
                $q->where('sender_id', $sender_id)
                    ->where('receiver_id', $receiver_id);
            })->orwhere(function ($q) use ($receiver_id, $sender_id) {
                $q->where('sender_id', $receiver_id);
                $q->where('receiver_id', $sender_id);
            });
        })->when($request->message_type, function ($q) use ($request) {
            $q->where('chat_type', $request->message_type);
            if ($request->message_type == 'g') {
                $q->where('group_id', $request->type_id);
            }
            if ($request->message_type == 'a') {
                $q->where('accompanist_id', $request->type_id);
            }
            if ($request->message_type == 's') {
                $q->where('studio_id', $request->type_id);
            }
        })
            ->when(!$request->message_type, function ($q) {
                $q->where('chat_type', 'u');
            })
            ->first();
        if ($chat_user) {
            if ($chat_user->receiver_id == $sender_id) {
                $chat_user->receiver_deleted = 0;
                $chat_user->sender_deleted = 0;
                $chat_user->save();
            }
            if ($chat_user->sender_id == $sender_id) {
                $chat_user->sender_deleted = 0;
                $chat_user->receiver_deleted = 0;
                $chat_user->save();
            }
        }
        if (!$chat_user) {
            $chat_user = new Chat;
            $chat_user->sender_id = $sender_id;
            $chat_user->receiver_id = $receiver_id;
            $chat_user->chat_type = $request->message_type;
            if ($request->message_type == 'g') {
                $chat_user->group_id = $request->type_id;
            }
            if ($request->message_type == 'a') {
                $chat_user->accompanist_id = $request->type_id;
            }
            if ($request->message_type == 's') {
                $chat_user->studio_id = $request->type_id;
            }
            if (!$request->message_type) {
                $chat_user->chat_type = 'u';
            }
        }

        $chat_user->save();
        $message = new ChatMessage;
        $message->sender_id = $sender_id;
        $message->receiver_id = $receiver_id;
        $message->chat_id = $chat_user->id;
        $message->message = $request['message'];
        $message->message_type = $request->message_type;
        if (!$request->message_type) {
            $message->message_type = 'u';
        }
        if ($request->message_type == 'g') {
            $message->group_id = $request->type_id;
        }
        if ($request->message_type == 's') {
            $message->studio_id = $request->type_id;
        }
        if ($request->message_type == 'a') {
            $message->accompanist_id = $request->type_id;
        }

//        echo $file_type;exit;
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
        $chat_user->last_message_id = $message->id;
        $chat_user->save();
        $other_user = User::find($sender_id);
//        addNotification($receiver_id, $request['message'], $other_user->first_name . ' sent you message', 'message', 'ChatMessage', $message->id, 'message_to' . $receiver_id . '_message_by' . $sender_id);
        ChatMessage::where('sender_id', $receiver_id)->where('receiver_id', $sender_id)->update(['is_read' => 1]);
        $user_id = $this->userId;
        $chat_id = $message->chat_id;
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Messages';
        $data['chat_user_id'] = $chat_id;
        $chat = Chat::find($chat_id);
        $other_id = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_id = $chat->receiver_id;
        }
        $data['messages'] = ChatMessage::with('sender', 'receiver')
            ->where('chat_id', $chat_id)->where('id', $message->id)
            ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        $single_message['append'] = view('user.messages_ajax', $data)->render();
        $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
        $single_message['chat_id'] = $chat_id;
        if ($receiver_id != $this->userId) {
            $user = User::find($receiver_id);
            $setting = Emailsetting::where('user_id', $user->id)->first();
            if ($setting && $setting->on_message) {
                $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
                $viewData['othrername'] = $user->first_name . ' ' . $user->last_name;
                Mail::send('emails.direct_message_email', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Direct Message Email');
                });
            }
        }
        echo json_encode($single_message);
    }


    function addGroupMessage(Request $request)
    {
//        $validation = $this->validate($request, [
//            'receiver_id' => 'required'
//        ]);
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
            $file_extension = $request['file']->getClientOriginalExtension();
        }
//        echo 'sdfds'. $request['chat_group_id']; exit;

        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $chat_user = ChatGroup::find($request['chat_group_id']);
        ChatGroupMember::where('chat_group_id', $chat_user->id)->where('member_id', $sender_id)->update(['is_read' => 1]);
//                ->when($request->message_type, function($q) use($request) {
//                    $q->where('type', $request->message_type);
//                    if ($request->message_type == 'g') {
//                        $q->where('group_id', $request->type_id);
//                    }
//                    if ($request->message_type == 'a') {
//                        $q->where('accompanist_id', $request->type_id);
//                    }
//                    if ($request->message_type == 's') {
//                        $q->where('studio_id', $request->type_id);
//                    }
//                })
//                ->when(!$request->message_type, function($q) {
//                    $q->where('type', 'u');
//                })
//                ->first();
//        if ($chat_user) {
//            if ($chat_user->receiver_id == $sender_id) {
//                $chat_user->receiver_deleted = 0;
//                $chat_user->sender_deleted = 0;
//                $chat_user->save();
//            }
//            if ($chat_user->sender_id == $sender_id) {
//                $chat_user->sender_deleted = 0;
//                $chat_user->receiver_deleted = 0;
//                $chat_user->save();
//            }
//        }
//        if (!$chat_user) {
//            $chat_user = new ChatGroup;
//            $chat_user->sender_id = $sender_id;
////            $chat_user->receiver_id = $receiver_id;
//            $chat_user->type = $request->message_type;
//            if ($request->message_type == 'g') {
//                $chat_user->group_id = $request->type_id;
//            }
//            if ($request->message_type == 'a') {
//                $chat_user->accompanist_id = $request->type_id;
//            }
//            if ($request->message_type == 's') {
//                $chat_user->studio_id = $request->type_id;
//            }
//            if (!$request->message_type) {
//                $chat_user->chat_type = 'u';
//            }
//        }
//        $chat_user->save();
        $message = new ChatGroupMessage;
        $message->sender_id = $sender_id;
        $message->admin_id = $chat_user->admin_id;
        $message->chat_group_id = $chat_user->id;
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
        }
        if ($request->message_type == 'a') {
            $message->accompanist_id = $request->type_id;
            $message->type_id = $request->type_id;
        }

//        echo $file_type;exit;
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
        $chat_user->last_message_id = $message->id;
        $chat_user->save();
        $other_user = User::find($sender_id);
//        addNotification($receiver_id, $request['message'], $other_user->first_name . ' sent you message', 'message', 'ChatMessage', $message->id, 'message_to' . $receiver_id . '_message_by' . $sender_id);
        ChatGroupMessage::where('chat_group_id', $chat_user->id)->where('sender_id', $sender_id)->update(['is_read' => 1]);
        $user_id = $this->userId;
        $chat_id = $message->chat_group_id;
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Group Messages';
        $data['chat_user_id'] = $chat_id;
        $chat = ChatGroup::find($chat_id);

        $other_id = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_id = $chat->receiver_id;
        }
        $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
            ->where('chat_group_id', $chat_id)->where('id', $message->id)
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        $single_message['group_member'] = ChatGroupMember::where('chat_group_id', $chat_id)->select('member_id')->get()->toArray();
        $single_message['append'] = view('user.messages_ajax', $data)->render();
        $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
        $single_message['chat_id'] = $chat_id;
        $single_message['chat_group'] = $chat_user;
        if ($receiver_id != $this->userId) {
            $user = User::find($receiver_id);
            $setting = Emailsetting::where('user_id', $user_id)->first();
            if ($setting && $setting->on_message) {
                $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
                $viewData['othrername'] = $user->first_name . ' ' . $user->last_name;
                Mail::send('emails.direct_message_email', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Direct Message Email');
                });
            }
        }
        echo json_encode($single_message);
    }

    function addStudentMessageFromMessenger(Request $request)
    {
//        $validation = $this->validate($request, [
//            'receiver_id' => 'required'
//        ]);
        if ($request['file']) {
            $file_type = $request['file']->getMimeType();
            $file_extension = $request['file']->getClientOriginalExtension();
        }
//        echo 'sdfds'. $request['chat_group_id']; exit;

        $sender_id = $this->userId;
        $receiver_id = $request['receiver_id'];
        $chat_user = ChatGroup::find($request['chat_group_id']);
        ChatGroupMember::where('chat_group_id', $chat_user->id)->where('member_id', $sender_id)->update(['is_read' => 1]);
//                ->when($request->message_type, function($q) use($request) {
//                    $q->where('type', $request->message_type);
//                    if ($request->message_type == 'g') {
//                        $q->where('group_id', $request->type_id);
//                    }
//                    if ($request->message_type == 'a') {
//                        $q->where('accompanist_id', $request->type_id);
//                    }
//                    if ($request->message_type == 's') {
//                        $q->where('studio_id', $request->type_id);
//                    }
//                })
//                ->when(!$request->message_type, function($q) {
//                    $q->where('type', 'u');
//                })
//                ->first();
//        if ($chat_user) {
//            if ($chat_user->receiver_id == $sender_id) {
//                $chat_user->receiver_deleted = 0;
//                $chat_user->sender_deleted = 0;
//                $chat_user->save();
//            }
//            if ($chat_user->sender_id == $sender_id) {
//                $chat_user->sender_deleted = 0;
//                $chat_user->receiver_deleted = 0;
//                $chat_user->save();
//            }
//        }
//        if (!$chat_user) {
//            $chat_user = new ChatGroup;
//            $chat_user->sender_id = $sender_id;
////            $chat_user->receiver_id = $receiver_id;
//            $chat_user->type = $request->message_type;
//            if ($request->message_type == 'g') {
//                $chat_user->group_id = $request->type_id;
//            }
//            if ($request->message_type == 'a') {
//                $chat_user->accompanist_id = $request->type_id;
//            }
//            if ($request->message_type == 's') {
//                $chat_user->studio_id = $request->type_id;
//            }
//            if (!$request->message_type) {
//                $chat_user->chat_type = 'u';
//            }
//        }
//        $chat_user->save();
        $message = new ChatGroupMessage;
        $message->sender_id = $sender_id;
        $message->admin_id = $chat_user->admin_id;
        $message->chat_group_id = $chat_user->id;
        $message->message = $request['message'];
        $message->message_type = $request->message_type;
        if (!$request->message_type) {
            $message->message_type = 'u';
        }
        if ($request->message_type == 'g') {
            $message->group_id = $request->type_id;
        }
        if ($request->message_type == 's') {
            $message->studio_id = $request->type_id;
        }
        if ($request->message_type == 't') {
            $message->studio_id = $request->type_id;
            $message->type_id = $request->type_id;
        }
        if ($request->message_type == 'a') {
            $message->accompanist_id = $request->type_id;
        }

//        echo $file_type;exit;
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
        $chat_user->last_message_id = $message->id;
        $chat_user->save();
        $other_user = User::find($sender_id);
//        addNotification($receiver_id, $request['message'], $other_user->first_name . ' sent you message', 'message', 'ChatMessage', $message->id, 'message_to' . $receiver_id . '_message_by' . $sender_id);
        ChatGroupMessage::where('chat_group_id', $chat_user->id)->where('sender_id', $sender_id)->update(['is_read' => 1]);
        $user_id = $this->userId;
        $chat_id = $message->chat_group_id;
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Group Messages';
        $data['chat_user_id'] = $chat_id;
        $chat = ChatGroup::find($chat_id);

        $other_id = $chat->sender_id;
        if ($chat->sender_id == $user_id) {
            $other_id = $chat->receiver_id;
        }
        $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
            ->where('chat_group_id', $chat_id)->where('id', $message->id)
            ->get();
        $data['other_message_user'] = User::find($other_id);
        $data['other_user_chat_id'] = $other_id;
        $single_message['group_member'] = ChatGroupMember::where('chat_group_id', $chat_id)->select('member_id')->get()->toArray();
        $single_message['append'] = view('user.messages_ajax', $data)->render();
        $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
        $single_message['chat_id'] = $chat_id;
        $single_message['chat_group'] = $chat_user;
        if ($receiver_id != $this->userId) {
            $user = User::find($receiver_id);
            $setting = Emailsetting::where('user_id', $user_id)->first();
            if ($setting && $setting->on_message) {
                $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
                $viewData['othrername'] = $user->first_name . ' ' . $user->last_name;
                Mail::send('emails.direct_message_email', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Direct Message Email');
                });
            }
        }
        echo json_encode($single_message);
    }

    function addFriendsMessage(Request $request)
    {
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
//        $chat_group = ChatGroup::where('admin_id', $sender_id)
//                                ->when($request->message_type, function($q) use($request) {
//                                    $q->where('type', $request->message_type);
//                                })
//                                ->when(!$request->message_type, function($q) use($request) {
//                                    $q->where('type', 'u');
//                                })
//                                ->when($request->type_id, function($q) use($request) {
//                                    $q->where('type_id', $request->type_id);
//                                })
//                                ->first();

//        if (!$chat_group) {
        $chat_group = new ChatGroup;
        $chat_group->admin_id = $sender_id;
        $chat_group->title = $request->title;

        if ($request->message_type) {
            $chat_group->type = $request->message_type;
            $chat_group->type_id = $request->type_id;
        }
        if (!$request->message_type) {
            $chat_group->type = 'u';
        }
//        }
        $chat_group->save();


        $message = new ChatGroupMessage;
        $message->chat_group_id = $chat_group->id;
        $message->admin_id = $sender_id;
        $message->sender_id = $sender_id;
        $message->message = $message_text;
        $message->message_type = $request->message_type;
        if (!$request->message_type) {
            $message->message_type = 'u';
        }
        if ($request->message_type == 'g') {
            $message->group_id = $request->type_id;
        }
        if ($request->message_type == 's') {
            $message->studio_id = $request->type_id;
        }
        if ($request->message_type == 'a') {
            $message->accompanist_id = $request->type_id;
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
//        addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in group '.$request->title, 'message', 'ChatMessage', $message->id, 'group_message_to' . $chat_group->id . '_message_by' . $sender_id);


        foreach ($receiver_ids as $key=>$receiver_id) {
            $value = User::findOrFail($receiver_id);
            if($key == 0){
                $group_members_images_string =  getUserImage($value->photo, $value->social_photo, $value->gender);
            } else {
                $group_members_images_string = $group_members_images_string.','. getUserImage($value->photo, $value->social_photo, $value->gender);
            }
//            if($key == 0){
//                $js_images_string =  getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);
//            } else {
//                $js_images_string = $js_images_string.','. getUserImage($value->getMemberDetail->photo, $value->getMemberDetail->social_photo, $value->getMemberDetail->gender);
//            }

            $member = new ChatGroupMember();
            $member->chat_group_id = $chat_group->id;
            $member->member_id = $receiver_id;
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
            addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in group ' . $request->title, 'message', 'ChatMessage', $message->id, 'group_message_to' . $chat_group->id . '_message_by' . $sender_id);
        }
        //concatenate of admin photo with
        $group_members_images_string = $group_members_images_string .','.getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $single_message['group_member_images']=$group_members_images_string;
//        dd($group_members_images_string);
        $chat_group->last_message_id = $message->id;
        $chat_group->save();

//        $other_user = User::find($sender_id);
//        ChatGroupMessage::where('chat_group_id', $chat_group->id)->update(['is_read' => 1]);

        $user_id = $this->userId;
        $chat_id = $message->chat_group_id;
        $data['current_id'] = $user_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_name'] = $this->user->first_name . ' ' . $this->user->last_name;
        $data['title'] = 'Friends Group Messages';
        $data['chat_group_id'] = $chat_group->id;

        $chat = ChatGroup::find($chat_group->id);
        $other_id = $chat->admin_id;
//        if ($chat->sender_id == $user_id) {
//            $other_id = $chat->receiver_id;
//        }
        $data['messages'] = ChatGroupMessage::with('chatgroup', 'receiver')
            ->where('chat_group_id', $chat_group->id)->where('id', $message->id)
            ->get();
        $data['other_message_user'] = $this->user;
        $data['other_user_chat_id'] = $this->userId;
        $single_message['append'] = view('user.messages_ajax', $data)->render();
        $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
        $single_message['chat_id'] = $chat_id;

        echo json_encode($single_message);
    }

    function saveStudioGroupMessage(Request $request)
    {

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
//        $chat_group = ChatGroup::where('admin_id', $sender_id)
//                                ->when($request->message_type, function($q) use($request) {
//                                    $q->where('type', $request->message_type);
//                                })
//                                ->when(!$request->message_type, function($q) use($request) {
//                                    $q->where('type', 'u');
//                                })
//                                ->when($request->type_id, function($q) use($request) {
//                                    $q->where('type_id', $request->type_id);
//                                })
//                                ->first();
        $error = false;
        if (isset($request->message_type) && isset($request->type_id) && isset($request->title)) {
            //save chat group
            $chat_group = new ChatGroup;
            $chat_group->admin_id = $sender_id;
            $chat_group->title = $request->title;
            $chat_group->type = $request->message_type;
            $chat_group->type_id = $request->type_id;
            $chat_group->save();

            // save Group Chat Messages
            $message = new ChatGroupMessage;
            $message->chat_group_id = $chat_group->id;
            $message->admin_id = $sender_id;
            $message->sender_id = $sender_id;
            $message->message = $message_text;
            $message->message_type = $request->message_type;

            if ($request->message_type == 's') {
                $message->studio_id = $request->type_id;
                $message->type_id = $request->type_id;

            }
            if ($request->message_type == 't') {
                $message->studio_id = $request->type_id;
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
            $chat_group->last_message_id = $message->id;
            $chat_group->save();

            //save admin in Chat Group Member
            $member = new ChatGroupMember();
            $member->chat_group_id = $chat_group->id;
            $member->member_id = $sender_id;

            if ($request->message_type == 's') {
                $member->studio_id = $request->type_id;
                $member->type_id = $request->type_id;
            }
            if ($request->message_type == 't') {
                $member->studio_id = $request->type_id;
                $member->type_id = $request->type_id;
            }
            $member->save();
//       addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in studio '.$request->title, 'message', 'ChatMessage', $message->id, 'group_message_to' . $chat_group->id . '_message_by' . $sender_id);
            foreach ($receiver_ids as $key=>$receiver_id) {
                $value = User::findOrFail($receiver_id);
                if($key == 0){
                    $group_members_images_string =  getUserImage($value->photo, $value->social_photo, $value->gender);
                } else {
                    $group_members_images_string = $group_members_images_string.','. getUserImage($value->photo, $value->social_photo, $value->gender);
                }
                $member = new ChatGroupMember();
                $member->chat_group_id = $chat_group->id;
                $member->member_id = $receiver_id;
                if ($request->message_type == 's') {
                    $member->studio_id = $request->type_id;
                    $member->type_id = $request->type_id;
                    $member->save();
                    addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in studio ' . $request->title, 'message', 'ChatMessage', $message->id, 'student_studio_message_to' . $message->id . '_message_by' . $sender_id);


                }
                if ($request->message_type == 't') {
                    $member->studio_id = $request->type_id;
                    $member->type_id = $request->type_id;
                    $member->save();
                    addNotification($receiver_id, $message_text, $this->user->first_name . ' sent a message in studio ' . $request->title, 'message', 'ChatMessage', $message->id, 'teacher_studio_message_to' . $message->id . '_message_by' . $sender_id);

                }

            } //close for each
            //concatenate of admin photo with
            $group_members_images_string = $group_members_images_string .','.getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
            $single_message['group_member_images']=$group_members_images_string;

        } //close isset if  

        else {
            $error = true;
        }
        if (!$error) {

//        $other_user = User::find($sender_id);
//        ChatGroupMessage::where('chat_group_id', $chat_group->id)->update(['is_read' => 1]);

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
            $data['messages'] = ChatGroupMessage::with('chatgroup', 'receiver')
                ->where('chat_group_id', $chat_group->id)->where('id', $message->id)
                ->get();
            $data['other_message_user'] = $this->user;
            $data['other_user_chat_id'] = $this->userId;
            $single_message['append'] = view('user.messages_ajax', $data)->render();
            $single_message['other_message'] = view('user.messages_ajax_other', $data)->render();
            $single_message['chat_id'] = $chat_id;

            echo json_encode($single_message);
        }


    }

    function deleteChat(Request $request)
    {
        $id = $request['chat_id'];
        $user_id = $this->userId;
        $chat = Chat::find($id);
        if ($chat->sender_id == $user_id) {
            $chat->sender_deleted = 1;
        } else if ($chat->receiver_id == $user_id) {
            $chat->receiver_deleted = 1;
        }
        $chat->save();
        ChatMessage::where(['chat_id' => $id, 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
        ChatMessage::where(['chat_id' => $id, 'sender_id' => $user_id])->update(['sender_deleted' => 1, 'is_read' => 1]);
        if (isset($request['on_chat_detail_page']) && $request['on_chat_detail_page'] == 1) {
//            Session::flash('success', 'Chat deleted successfully.');
            return Redirect::to('messages');
        }
        return response()->json(['message' => 'success',
            'bookmark' => $chat
        ], 200);
    }

    function deleteMulitipleChat(Request $request)
    {
        $ids = explode(',', $request['ids']);
        $user_id = $this->userId;
        $chats = Chat::whereIn('id', $ids)->get();
        foreach ($chats as $chat) {
            if ($chat->sender_id == $user_id) {
                $chat->sender_deleted = 1;
            } else if ($chat->receiver_id == $user_id) {
                $chat->receiver_deleted = 1;
            }
            $chat->save();
            ChatMessage::where(['chat_id' => $chat->id, 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
            ChatMessage::where(['chat_id' => $chat->id, 'sender_id' => $user_id])->update(['sender_deleted' => 1, 'is_read' => 1]);
        }
        return response()->json(['success' => "Chats deleted successfully"]);
    }


    function deleteMulitipleFriendChat(Request $request)
    {
        $ids = explode(',', $request['ids']);
        $user_id = $this->userId;
        $chats = ChatGroup::whereIn('id', $ids)->get();
        $check = false;
        if (ChatGroupMessage::whereIn('chat_group_id', $ids)->delete()) {
            if (ChatGroupMember::whereIn('chat_group_id', $ids)->delete()) {
                if (ChatGroup::whereIn('id', $ids)->delete()) {
                    $check = true;
                }

            }


        }
        if ($check) {
            return response()->json(['success' => "Chats deleted successfully"]);
        }
        return response()->json(['error' => "Something went wrong"]);


//        ChatGroupMember::whereIn('chat_group_id', $ids)->delete();
//        ChatGroupMessage::whereIn('chat_group_id', $ids)->delete();
//        ChatGroup::whereIn('id', $ids)->delete();
//        foreach ($chats as $chat) {
//            $chat->sender_deleted = 1;
//            $chat->group_deleted = 1;
////            if ($chat->sender_id == $user_id) {
////                $chat->sender_deleted = 1;
////            } else if ($chat->receiver_id == $user_id) {
////                $chat->receiver_deleted = 1;
////            }
//            $chat->save();
////            ChatMessage::where(['chat_id' => $chat->id, 'receiver_id' => $user_id])->update(['receiver_deleted' => 1, 'is_read' => 1]);
//            ChatGroupMessage::where(['chat_group_id' => $chat->id])->update(['sender_deleted' => 1, 'is_read' => 1]);
//        }

    }

    function deleteMessage(Request $request)
    {
        ChatMessage::where(['id' => $request->message_id])->update(['sender_deleted' => 1]);
        $message = ChatMessage::where(['id' => $request->message_id])->first();
        $total_remain = ChatMessage::with('sender', 'receiver')
            ->where('chat_id', $message->chat_id)
            ->whereRaw("IF(`sender_id` = $this->userId, `sender_deleted`, `receiver_deleted`)= 0")
            ->count();
        if (!$total_remain) {
            $chat = Chat::find($message->chat_id);
            if ($chat->sender_id == $this->userId) {
                $chat->sender_deleted = 1;
            } else {
                $chat->receiver_deleted = 1;
            }
            $chat->save();
            echo 'Delete Chat';
        }
    }

    function deleteGroupMessage(Request $request)
    {
        ChatGroupMessage::where(['id' => $request->message_id])->update(['sender_deleted' => 1]);
        $message = ChatGroupMessage::where(['id' => $request->message_id])->first();
        $total_remain = ChatGroupMessage::with('sender', 'receiver')
            ->where('chat_group_id', $message->chat_group_id)
            ->count();

        if (!$total_remain) {
            $chat = ChatGroup::find($message->chat_id);
            if ($chat->sender_id == $this->userId) {
                $chat->sender_deleted = 1;
            } else {
                $chat->receiver_deleted = 1;
            }
            $chat->save();
            echo 'Delete Chat';
        }
    }

    function deleteFriendsMessage(Request $request)
    {
        ChatGroupMessage::where(['id' => $request->message_id])->update(['sender_deleted' => 1]);
        $message = ChatGroupMessage::where(['id' => $request->message_id])->first();
        $total_remain = ChatGroupMessage::with('sender', 'receiver')
            ->where('chat_group_id', $message->chat_group_id)
            ->count();
        if (!$total_remain) {
            $chat = ChatGroup::find($message->chat_id);
            if ($chat->sender_id == $this->userId) {
                $chat->sender_deleted = 1;
            } else {
                $chat->receiver_deleted = 1;
            }
            $chat->save();
            echo 'Delete Chat';
        }
    }

    function downloadFile($message_id)
    {
        $message = ChatMessage::find($message_id);
        return response()->download(public_path('images/' . $message->file_path));
    }

    function downloadGroupFile($message_id)
    {
        $message = ChatGroupMessage::find($message_id);
        return response()->download(public_path('images/' . $message->file_path));
    }

    function getChatGroups($group_id)
    {
        $group = $data['group'] = Group::find($group_id);
        if ($group->admin_id == $this->userId || (!empty($group->checkMember) && $group->checkMember->is_approved == '1')) {

            $user_id = $this->userId;
            $other_id = '';
            $data['groupchats'] = ChatGroup::whereHas('getRelatedChat')->with('getRelatedChat', 'lastMessage')
                ->where('group_deleted', '0')
                ->where('sender_deleted', '0')
                ->where('type_id', $group->id)
                ->orderBy('updated_at', 'desc')
                ->get();
            $chat_user_sender = ChatGroup::select('admin_id as uid')->where('admin_id', $this->userId)->where('sender_deleted', 0)->where('group_deleted', 0)->get()->toArray();
            $chat_user_reciver = ChatGroupMember::select('member_id as uid')->where('member_id', $this->userId)->get()->toArray();
            $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
            $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();

            $data['title'] = 'Event Group Chats';
            
            $data['latest_chat'] = ChatGroup::with('sender', 'receiver')->whereHas('getRelatedChat')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('group_deleted', 0)
                ->where('sender_deleted', 0)
                ->where('type', 'g')
                ->where('type_id', $group->id)
                ->orderBy('last_message_id', 'desc')->first();
                

            $data['messages'] = [];
            if ($data['latest_chat']) {
                ChatGroupMember::where('member_id', $user_id)->where('type_id', $group->id)->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
                $other_id = $data['latest_chat']->admin_id;
                $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
                    ->where('chat_group_id', $data['latest_chat']->id)
                    ->take(10)->skip(0)
                    ->orderBy('created_at', 'desc')
                    ->where('sender_deleted', 0)
                    ->get();
            }
            $data['unread'] = ChatGroupMember::where('member_id', $user_id)->where('is_read', 0)->count();
            $data['friends'] = CollaborativeFriend::where('friend_id', $this->userId)->with('getFriendDetail')->get();
            $data['other_message_user'] = User::find($other_id);
            $data['other_user_chat_id'] = $other_id;


            return view('user.messages_groups', $data);
        } else {
            return Redirect::to(URL::previous());
        }
    }

    function getChatStudio($studio_id)
    {
        $studio = TeachingStudio::find($studio_id);
        if ($studio->admin_id == $this->userId) {
            $user_id = $this->userId;
            $other_id = '';
            $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $this->userId)->where('receiver_deleted', 0)->get()->toArray();
            $chat_user_reciver = Chat::select('receiver_id as uid')->where('sender_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
            $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
            $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();
            $data['chats_data'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')->get();
            $data['title'] = 'Event Service Messages';
            $data['latest_chat'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
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
            $data['studio'] = $studio;
            $data['unread'] = ChatMessage::where('receiver_id', $user_id)->where('studio_id', $studio_id)->where('is_read', 0)->count();
            $data['other_message_user'] = User::find($other_id);
            $data['other_user_chat_id'] = $other_id;
            return view('user.messages_studio', $data);
        } else {
            return Redirect::to(URL::previous());
        }
    }

    function getTeacherStudioChat($studio_id)
    {
        $studio = TeachingStudio::find($studio_id);
        if ($studio->admin_id == $this->userId) {
            $user_id = $this->userId;
            $other_id = '';
            $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $this->userId)->where('receiver_deleted', 0)->get()->toArray();
            $chat_user_reciver = Chat::select('receiver_id as uid')->where('sender_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
            $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
            $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();
            $data['chats_data'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')->get();
            $data['title'] = 'Event Service Messages';
            $data['latest_chat'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('last_message_id', 'desc')->first();
                
                
            $data['messages'] = [];
            if ($data['latest_chat']) {
                $other_id = $data['latest_chat']->sender_id;
                if ($data['latest_chat']->sender_id == $user_id) {
                    $other_id = $data['latest_chat']->receiver_id;
                }
                ChatGroupMember::where('member_id', $user_id)->where('type_id', $group->id)->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
                ChatMessage::where('chat_id', $data['latest_chat']->id)->where('receiver_id', $user_id)->update(['is_read' => 1]);
                $data['messages'] = ChatMessage::with('sender', 'receiver')
                    ->where('chat_id', $data['latest_chat']->id)
                    ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                    ->take(10)->skip(0)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            $data['studio'] = $studio;
            $data['unread'] = ChatMessage::where('receiver_id', $user_id)->where('studio_id', $studio_id)->where('is_read', 0)->count();
            $data['other_message_user'] = User::find($other_id);
            $data['other_user_chat_id'] = $other_id;
            return view('user.teacher_messages_studio', $data);
        } else {
            return Redirect::to(URL::previous());
        }
    }

    function getStudentStudioChat($studio_id)
    {
        $studio = TeachingStudio::find($studio_id);
        if ($studio->admin_id == $this->userId) {
            $user_id = $this->userId;
            $other_id = '';
            $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $this->userId)->where('receiver_deleted', 0)->get()->toArray();
            $chat_user_reciver = Chat::select('receiver_id as uid')->where('sender_id', $this->userId)->where('sender_deleted', 0)->get()->toArray();
            $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
            $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();
            $data['chats_data'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
                ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                ->orderBy('updated_at', 'desc')->get();
                
            $data['title'] = 'Event Service Messages';
            
            $data['latest_chat'] = Chat::with('sender', 'receiver')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('studio_id', $studio_id)
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
            $data['studio'] = $studio;
            $data['unread'] = ChatMessage::where('receiver_id', $user_id)->where('studio_id', $studio_id)->where('is_read', 0)->count();
            $data['other_message_user'] = User::find($other_id);
            $data['other_user_chat_id'] = $other_id;
            return view('user.student_messages_studio', $data);
        } else {
            return Redirect::to(URL::previous());
        }
    }

    function getChatAccompanist($accompanist_id)
    {
        $accompanist = $data['accompanist'] = Accompanist::find($accompanist_id);
        if ($accompanist->admin_id == $this->userId || (!empty($accompanist->checkMember) && $accompanist->checkMember->is_approved == '1')) {

            $user_id = $this->userId;
            $other_id = '';
            $data['groupchats'] = ChatGroup::whereHas('getRelatedChat')->with('getRelatedChat', 'lastMessage')
                ->where('group_deleted', '0')
                ->where('sender_deleted', '0')
                ->where('type_id', $accompanist->id)
                ->orderBy('updated_at', 'desc')
                ->get();

            $chat_user_sender = ChatGroup::select('admin_id as uid')->where('admin_id', $this->userId)->where('sender_deleted', 0)->where('group_deleted', 0)->get()->toArray();
            $chat_user_reciver = ChatGroupMember::select('member_id as uid')->where('member_id', $this->userId)->get()->toArray();
            $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
            $data['not_chated'] = User::whereNotIn('id', $user_chated)->where('id', '!=', $this->userId)->where('type', 'artist')->get();

            $data['title'] = 'Accompanist Chats';

            $data['latest_chat'] = ChatGroup::with('sender', 'receiver')->whereHas('getRelatedChat')
                ->withCount(['messages' => function ($q) {
                    $q->where('is_read', 0);
                }])
                ->where('group_deleted', 0)
                ->where('sender_deleted', 0)
                ->where('type', 'a')
                ->where('type_id', $accompanist->id)
                ->orderBy('last_message_id', 'desc')->first();

            $data['messages'] = [];
            if ($data['latest_chat']) {
                
                ChatGroupMember::where('member_id', $user_id)->where('type_id', $accompanist->id)->where('chat_group_id',$data['latest_chat']->id)->update(['is_read' => 1]);
                $other_id = $data['latest_chat']->admin_id;
                $data['messages'] = ChatGroupMessage::with('sender', 'receiver')
                    ->where('chat_group_id', $data['latest_chat']->id)
                    ->where('accompanist_id', $accompanist->id)
                    ->where('type_id', $accompanist->id)
                    ->take(10)->skip(0)
                    ->orderBy('created_at', 'desc')
                    ->get();
            }
            $data['unread'] = ChatGroupMember::where('member_id', $user_id)->where('is_read', 0)->count();
            $data['friends'] = CollaborativeFriend::where('friend_id', $this->userId)->with('getFriendDetail')->get();
            $data['other_message_user'] = User::find($other_id);
            $data['other_user_chat_id'] = $other_id;


            return view('user.messages_accompanist', $data);
        } else {
            return Redirect::to(URL::previous());
        }
    }

}
