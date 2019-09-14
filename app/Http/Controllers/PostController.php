<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Post;
use App\PostFile;
use App\UserFollower;
use App\PostReport;
use App\Emailsetting;
use App\PostEvent;
use App\Accompanist;
use App\Group;
use App\TeachingStudio;
use App\User;
use App\CollaborativeFriend;
use App\GroupImage;
use App\AccompanistImage;
use App\TeachingStudioImage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class PostController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $videos_path;
    private $posters_path;
    private $photos_path;
    private $audio_path;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
        $this->photos_path = 'public/images/posts/';
        $this->audio_path = 'public/audios/posts/';
        $this->videos_path = 'public/videos/posts/';
        $this->posters_path = 'public/images/posts/posters/';
    }

    function addFile(Request $request) {
        $photos = $request->file('file');
        if (!is_array($photos)) {
            $photos = [$photos];
        }
        if (!is_dir($this->photos_path)) {
            mkdir($this->photos_path, 0777);
        }
        $save_name = '';
        $resize_name = '';
        $thumb = '';
        $poster_name = '';
        $duration = '';
        $db_name = '';
        $db_thum = '';
        for ($i = 0; $i < count($photos); $i++) {
            $file = $photos[$i];
            $type = strtolower($file->getClientMimeType());
            if (strpos($type, 'image') !== false) {
                $type = 'image';
            }
            if (strpos($type, 'audio') !== false) {
                $type = 'audio';
            }
            if (strpos($type, 'video') !== false) {
                $type = 'video';
            }
            if ($type == 'image') {
                $name = 'image_' . str_random(10);
                $save_name = $name . '.' . $file->getClientOriginalExtension();
                $resize_name = 'thum_' . $save_name;
                Image::make($file)
                        ->resize(200, null, function ($constraints) {
                            $constraints->aspectRatio();
                        })->orientate()
                        ->save($this->photos_path . '/thumnails/' . $resize_name);
                $file->move($this->photos_path, $save_name);
                $thumb = asset(image_fix_orientation($this->photos_path . '/thumnails/' . $resize_name));
                $db_name = $this->photos_path . $save_name;
                $db_thum = $this->photos_path . '/thumnails/' . $resize_name;
            }

            if ($type == 'video') {
                $name = 'video_' . str_random(10);
                $save_name = $name . '.' . 'mp4'; // renameing image
                $video = $this->videos_path . $save_name;
                $filePath = $file->getRealPath();
                exec("ffmpeg -i $filePath -strict -2 $video 2>&1", $result, $status);
                $db_name = $this->videos_path . $save_name;
                if ($status === 0) {
                    $info = getVideoInformation($result);
                    $duration = $info[0];
                    $poster_name = explode('.', $save_name)[0] . '.jpg';
                    $poster = $this->posters_path . $poster_name;
                    exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");

                    $resize_poster = 'thum_' . $poster_name;
                    Image::make($poster)
                            ->resize(200, null, function ($constraints) {
                                $constraints->aspectRatio();
                            })->orientate()
                            ->save($this->posters_path . 'thumnails/' . $resize_poster);

                    $thumb = asset(image_fix_orientation($this->posters_path . 'thumnails/' . $resize_poster));
                    $db_thum = $this->posters_path . 'thumnails/' . $resize_poster;
                } else {
                    $poster_name = '';
                    $resize_poster = '';
                }
            }
            if ($type == 'audio') {
                $name = 'audio_' . str_random(10);
                $save_name = $name . '.' . $file->getClientOriginalExtension();
                $thumb = asset('userassets/images/audio.jpg');
                $file->move($this->audio_path, $save_name);
                $db_name = $this->audio_path . $save_name;
                $db_thum = $this->photos_path . '/audio.jpg';
            }
        }
        return Response::json([
                    'message' => $type . ' saved Successfully',
                    'file_name' => $save_name,
                    'resize_name' => $resize_name,
                    'type' => $type,
                    'thumnail_path' => $thumb,
                    'duration' => $duration,
                    'poster_name' => $poster_name,
                    'db_name' => $db_name,
                    'db_thumb' => $db_thum
                        ], 200);
    }

    public function addPost(Request $request) {
        if ($request['post_description']) {
            if (searchForVulgarTerms($request['post_description'])) {
                return Response::json(['error' => 1]);
            }
        }
        $privacy='public';
        if($request['privacy'])
        {
            if($request['privacy'] == 'Public')
            {
                 $privacy='public';
            }
            elseif ($request['privacy'] == 'Private')
            {
                $privacy='private';
            }
            elseif (($request['privacy']) == 'Collaborative Friends') {
                $privacy='friend';
            }
            elseif (($request['privacy']) == 'Members') {
                $privacy='group';
            }
            elseif (($request['privacy']) == 'Accompanist') {
                $privacy='accompanist';
            }
            elseif (($request['privacy']) == 'Teachers') {
                $privacy='teacher';
            }
            elseif (($request['privacy']) == 'Students') {
                $privacy='student';
            }
        }
        $type = 'text';
        $attachments = json_decode($request['images']);
        foreach ($attachments as $attachment) {
            $type = $attachment->type;
        }
        $post_as = explode('_', $request->post_as);
        $user_post = new Post;
        $editCheck = '';
        if ($request->post_id) {
            $user_post = Post::find($request->post_id);
            PostFile::where('post_id', $request->post_id)->delete();
            $editCheck = true;
        }
        $user_post->post_type = $post_as[0];
        if ($post_as[0] == 'g') {
            $user_post->event_id = $post_as[1];
        }
        if ($post_as[0] == 'a') {
            $user_post->accompanist_id = $post_as[1];
        }
        if ($post_as[0] == 's') {
            $user_post->studio_id = $post_as[1];
        }
        if ($post_as[0] == 'e') {
            $user_post->group_id = $post_as[1];
        }
        $user_post->user_id = $this->userId;
        $user_post->text = str_replace('@@', '@', trim($request['post_description']));
        $user_post->edit_data = saveMentions($user_post->text);
        $user_post->type = $type;
        $user_post->privacy=$privacy;
        $user_post->save();
        $img_file = '';
        
        if (count($attachments) > 0) {
            foreach ($attachments as $attachment) {
                
                $img_file = $attachment->db_name;
                
                if ($post_as[0] == 'e') {
                    $group_img = new GroupImage();
                    $group_img->file = $attachment->db_name;
                    $group_img->group_id = $post_as[1];
                    $group_img->save();
                    
                } else if ($post_as[0] == 'a') {
                    $accompanist_img = new AccompanistImage();
                    $accompanist_img->file = $attachment->db_name;
                    $accompanist_img->accompanist_id = $post_as[1];
                    $accompanist_img->save();
                    
                } else if ($post_as[0] == 's') {
                    $studio_img = new TeachingStudioImage();
                    $studio_img->file = $attachment->db_name;
                    $studio_img->teaching_studio_id = $post_as[1];
                    $studio_img->save();
                    
                }
                $add_image = new PostFile;
                $add_image->post_id = $user_post->id;
                $add_image->file = $attachment->db_name;
                $add_image->poster = $attachment->poster;
                $add_image->thumbnail = $attachment->db_thumb;
                $add_image->original_name = $attachment->resize_name;
                $add_image->type = $attachment->type;
                $add_image->save();
                if ($add_image->type == 'image') {
                    addMedia($add_image->file, 'image', $attachment->resize_name);
                } else if ($add_image->type == 'video') {
                    addMedia($add_image->file, $add_image->type, $add_image->poster);
                } else if ($add_image->type == 'audio') {
                    addMedia($add_image->file, $add_image->type);
                }
            }
        }
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['posts'] = Post::where('id', $user_post->id)->get();
        $data['current_id'] = $this->userId;
        if ($request->mentioned_users) {
            foreach ($request->mentioned_users as $users) {
                if (!$editCheck)
                    addNotificationThenGet($users['id'], 'Mentioned in a post', 'mentioned you in a post', 'post', 'Post', $user_post->id, 'post' . $user_post->id . '_posted_by_' . $this->userId . '_on_post' . $user_post->id);
            }
        }
        $view = view('user.loader.posts', $data)->render();
        $post_id = $user_post->id;
        return Response::json(['message' => 'success', 'post_id' => $post_id, 'view' => $view, 'file' => $img_file], 200);
//        return Response::json(['data' => $tagged_users], 200);
    }

    function deleteFile(Request $request) {
        $file_name = $request->file_name;
//        $file_type = $request->file_type;
        $file_path = $this->photos_path . '/' . $file_name;
        if (file_exists($file_path)) {
//            unlink($file_path);
        }
        return Response::json(['message' => 'File successfully delete'], 200);
    }

    function fetchPosts(Request $request) {
        $user_follow = UserFollower::select('user_id')->where('followed_by', $this->userId)->get()->toArray();
        $collaborative_friends = CollaborativeFriend::select('user_id')
                                                        ->where('friend_id', Auth::user()->id)
                                                        ->where('is_approved', 1)
                                                        ->get()->toArray();
//        print_r($user_follow);exit;
//        $followed_post = Post::whereIn('user_id', $user_follow)->orderBy('created_at', 'asc')->pluck('id')->toArray();
//        $followed_posts = implode(',', $followed_post);
//        if ($followed_posts == '') {
//            $followed_posts = 0;
//        }
        $user_follow[]['user_id'] = $this->userId;
        $post_type = $request->post_type;
        $post_type_col = $request->post_type_col;
        $post_type_col_id = $request->post_type_col_id;
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $data['current_id'] = $this->userId;
        if (isset($request['search']) && $request['search']) {
            
        }
        $data['posts'] = Post::when(isset($request['search']) && $request['search'], function($q) use($request) {
                    $q->where('text', 'LIKE', '%' . $request['search'] . '%')
                    ->where('text', 'not regexp', '^(https?\:\/\/)?(www\.)?(youtube\.com|youtu\.?be)\/.+$')
                    ->where('text', 'not regexp', '<iframe(.+)</iframe>');
                })
                ->skip($request['skip'])
                 ->with('isMusicianFriend', 'isMusicianFollower')
                ->with(['comments' => function($a) {
                            $a->orderBy('created_at', 'desc')
                        ->whereHas('user', function ($q) {
                                    $q->where('is_active', 1);
                                });
                    }])
                ->when($post_type, function ($q) use($post_type, $post_type_col_id, $post_type_col) {
                    $q->where('post_type', $post_type);
                    $q->where($post_type_col, $post_type_col_id);
                })
                ->whereHas('user', function ($q) {
                    $q->where('is_active', 1);
                })
                ->where(function ($query) use ($user_follow) {
                    $query->whereIn('user_id', $user_follow);
                    $query->orwhereHas('user', function ($q) {
                        $q->where('is_private', '!=', 1);
                    });
                })
                
                
                ->take($request['take'])->withCount('liked', 'bookmarked', 'comments')
                ->orderBy('created_at', 'Desc')->where('type', '!=', 'gig')
                ->get();
//        echo '<pre>';
//       print_r($data);exit;
//         if(Auth::user()->type == 'user')
//         {
//           return view('user.loader.user_group_posts', $data);  
//         }
        return view('user.loader.posts', $data);
    }

    function reportPost(Request $request) {
        $post_flag = PostReport::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_flag) {
            $post_flag = new PostReport;
        }
        $post_flag->post_id = $request['post_id'];
        $post_flag->user_id = $this->userId;
        $post_flag->reason = $request['reason'];
        if ($post_flag->save()) {

            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function deletePost(Request $request) {
        deleteNotification('post', $request['post_id']);
        if (Post::where(['id' => $request['post_id'], 'user_id' => $this->userId])->delete()) {
            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function getPost($post_id) {
        $check = Post::find($post_id);
        if (!$check) {
            return Redirect::to(Url::previous());
        }
        $data['title'] = 'Musician | Timeline';
        $data['is_shown'] = 'true';
        $data['post_count'] = Post::where('type', '!=', 'gig')->count();
        $data['post_id'] = $post_id;
        return view('user.single_post', $data);
    }

    function fetchPost($post_id) {
        $data['current_id'] = $this->userId;
        $data['posts'] = Post::where('id', $post_id)->withCount('liked', 'bookmarked')->where('type', '!=', 'gig')
                ->orderBy('created_at', 'Desc')
                ->get();
        $data['is_shown'] = 'true';
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        return view('user.loader.posts', $data);
    }

    function editPost($post_id) {
        $data['current_id'] = $this->userId;
        $data['current_user'] = $this->user;
        $data['title'] = 'Edit Post';
        $data['post_id'] = $post_id;
        $data['gigs'] = PostEvent::select('title', 'id')->where('user_id', $this->userId)->get();
        $data['groups'] = Group::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['studios'] = TeachingStudio::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['accompanists'] = Accompanist::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['post'] = Post::find($post_id);
        return view('user.edit_post', $data);
    }

    public function getPostImages($post_id) {
        $images = PostFile::where(['post_id' => $post_id])->get();
        $imageAnswer = [];
        foreach ($images as $image) {
            $file = explode('/', $image->file);
            $thumnail = explode('/', $image->thumbnail);
            if ($image->type == 'image') {
                $thumnail = $thumnail[4];
            }
            if ($image->type == 'audio') {
                $thumnail = $thumnail[3];
            }
            if ($image->type == 'video') {
                $thumnail = $thumnail[5];
            }
            $imageAnswer[] = [
                'original' => $image->file,
                'server' => $file[3],
                'type' => $image->type,
                'path' => asset('public/images/' . $image->file),
                'thumnail' => $thumnail,
                'thumnail_path' => asset($image->thumbnail),
                'db_thumb' => $image->thumbnail,
                'poster' => $image->poster,
                'size' => File::size($image->file)
            ];
        }


        return response()->json([
                    'images' => $imageAnswer
        ]);
    }

    function sendMailOnShare(Request $request) {
        $post = Post::find($request->id);
        if ($post->user_id != $this->userId) {
            $user = User::find($post->user_id);
            $setting = Emailsetting::where('user_id', $user->id)->first();
            if ($setting && $setting->on_share) {
                $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
                $viewData['othrername'] = $user->first_name . ' ' . $user->last_name;
                $viewData['other_id'] = $this->userId;
                $viewData['post_id'] = $post->id;
                Mail::send('emails.share_email', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Share Post Email');
                });
            }
        }
    }

}
