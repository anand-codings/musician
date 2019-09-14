<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bookmark;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;

class FavouriteController extends Controller {

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

    function addFavouritePost(Request $request) {

        $post_bookmark = Bookmark::where(['post_id' => $request['post_id'], 'user_id' => $this->userId])->first();
        if (!$post_bookmark) {
            $post_bookmark = new Bookmark;
        }
        if ($request['is_like']) {
            $post_bookmark->post_id = $request['post_id'];
            $post_bookmark->post_type = $request['type'];
            $post_bookmark->user_id = $this->userId;
            $post_bookmark->save();
        } else {
            if ($post_bookmark) {
                $post_bookmark->delete();
            }
        }
        return Response::json(['message' => 'success',
                    'bookmark' => $post_bookmark
                        ], 200);
    }

    function getFavourites() {
        $data['title'] = 'Musician | Favourites';
        return view('user.favourites', $data);
    }

    function fetchFavourites(Request $request) {
        $filter=$_GET['filter'];
        $data['posts'] = Bookmark::skip($request['skip'])
                ->when($filter, function($q) use($filter) {
                    $q->where('post_type',$filter);
                })
                ->take($request['take'])
                ->orderBy('created_at', 'Desc')
                ->where('user_id', $this->userId);
        $data['posts']->update(['is_viewed' => 1]);
        $data['posts'] = $data['posts']->get();
        return view('user.loader.favourites', $data);
    }
    
    function bookmarkGroup(Request $request) {
//        dd($request->all());
        $bookmark = Bookmark::where(['group_id' => $request['group_id'], 'user_id' => $this->userId])->first();
        if (!$bookmark) {
            $bookmark = new Bookmark;
        }
        if ($request['is_bookmarked']) {
            $bookmark->group_id = $request['group_id'];
            $bookmark->post_type = 'group';
            $bookmark->user_id = $this->userId;
            $bookmark->save();
        } else {
            if ($bookmark) {
                $bookmark->delete();
            }
        }
        return Response::json(['message' => 'success',
                    'bookmark' => $bookmark
                        ], 200);
    }

    function bookmarkTeachingStudio(Request $request) {
//        dd($request->all());
        $bookmark = Bookmark::where(['teaching_studio_id' => $request['teaching_studio_id'], 'user_id' => $this->userId])->first();
        if (!$bookmark) {
            $bookmark = new Bookmark;
        }
        if ($request['is_bookmarked']) {
            $bookmark->teaching_studio_id = $request['teaching_studio_id'];
            $bookmark->post_type = 'teaching_studio';
            $bookmark->user_id = $this->userId;
            $bookmark->save();
        } else {
            if ($bookmark) {
                $bookmark->delete();
            }
        }
        return Response::json(['message' => 'success',
                    'bookmark' => $bookmark
                        ], 200);
    }

    function bookmarkAccompanist(Request $request) {
//        dd($request->all());
        $bookmark = Bookmark::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $this->userId])->first();
        if (!$bookmark) {
            $bookmark = new Bookmark;
        }
        if ($request['is_bookmarked']) {
            $bookmark->accompanist_id = $request['accompanist_id'];
            $bookmark->post_type = 'accompanist';
            $bookmark->user_id = $this->userId;
            $bookmark->save();
        } else {
            if ($bookmark) {
                $bookmark->delete();
            }
        }
        return Response::json(['message' => 'success',
                    'bookmark' => $bookmark
                        ], 200);
    }

}
