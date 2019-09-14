<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Comment;
use App\Post;
use App\Notification;
use Illuminate\Support\Facades\Response;
use App\PostLikes;
use App\User;
use App\Emailsetting;
use Illuminate\Support\Facades\Mail;

class PostActionController extends Controller {

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

    function addComment(Request $request) {
        if ($request['comment']) {
            if (searchForVulgarTerms($request['comment'])) {
                return Response::json(['error' => 1]);
            }
        }
        $add_comment = new Comment;
        $editCheck = 0;
        if ($request['old_comment_id']) {
            $add_comment = Comment::find($request['old_comment_id']);
            $editCheck = 1;
        }
        $add_comment->comment = str_replace('@@', '@', trim($request['comment']));
        $add_comment->edit_data = saveMentions($add_comment->comment);

        $add_comment->user_id = $this->userId;
        $add_comment->post_id = $request['post_id'];
        $add_comment->save();
        $data['current_id'] = $this->userId;
        $data['post'] = Post::find($request['post_id']);
        $data['post_single_comment'] = Comment::where('id', $add_comment->id)->get();
        $receiver_id = $add_comment->post->user_id;
        $notification = addNotificationThenGet($receiver_id, $editCheck ? 'You edited the comment on a post' : 'You commented on a post', $editCheck ? 'edited the comment on your post' : 'commented on your post', 'comment', 'Comment', $add_comment->id, 'comment' . $add_comment->id . '_posted_by_' . $this->userId . '_on_post' . $add_comment->post->id);
        if ($request->mentioned_users) {
            foreach ($request->mentioned_users as $users) {
                if (!$editCheck)
                    addNotificationThenGet($users['id'], 'Mentioned in a comment', 'mentioned you in a comment', 'comment', 'Comment', $add_comment->id, 'comment' . $add_comment->id . '_posted_by_' . $this->userId . '_on_post' . $add_comment->id);
            }
        }
        $view = (string) View::make('user.loader.comments', $data);
        $pop_up = (string) View::make('user.loader.comments_popup', $data);
        $post = Post::find($request['post_id']);
        $user = '';
        if ($post->user_id != $this->userId) {
            $user = User::find($post->user_id);
            $setting = Emailsetting::where('user_id', $user->id)->first();
            if ($setting && $setting->on_comment) {
                $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
                $viewData['othrername'] = $user->first_name . ' ' . $user->last_name;
                $viewData['other_id'] = $this->userId;
                $viewData['post_id'] = $post->id;
                Mail::send('emails.comment_email', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Comment on Post Email');
                });
            }
        }
        return Response::json(['message' => 'success', 'setting' => $user, 'notification' => $notification, 'view' => $view, 'pop_up' => $pop_up, 'is_edited' => $editCheck], 200);
    }

    function deleteComment() {
        deleteNotification('comment', $_GET['comment_id']);
        if (Comment::where(['id' => $_GET['comment_id'], 'user_id' => $this->userId])->delete()) {
            return Response::json(['message' => 'success'], 200);
        } else {
            return Response::json(['message' => 'error'], 200);
        }
    }

    function likePost(Request $request) {
        $post_like = PostLikes::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_like) {
            $post_like = new PostLikes;
        }
        if ($request['is_like']) {
            $post_like->post_id = $request['post_id'];
            $post_like->user_id = $this->userId;
            $post_like->save();
            $receiver_id = $post_like->post->user_id;
            $notification = addNotificationThenGet($receiver_id, 'You liked a post', 'liked your post', 'like', 'PostLikes', $post_like->id, 'post' . $post_like->post->id . '_liked_by_' . $this->userId);
            return Response::json(['message' => 'liked', 'liked' => $post_like, 'notification' => $notification], 200);
        } else {
            if ($post_like) {
                deleteNotification('like', $post_like->id);
                $post_like->delete();
                return Response::json(['message' => 'disliked', 'liked' => $post_like], 200);
            }
        }
    }

}
