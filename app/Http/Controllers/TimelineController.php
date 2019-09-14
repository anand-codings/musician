<?php

namespace App\Http\Controllers;

use App\Post;
use App\PostEvent;
use App\Category;
use App\SelectedGigCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\Session;
use Alaouy\Youtube\Facades\Youtube;
use App\Group;
use App\TeachingStudio;
use App\Accompanist;
use App\User;
use App\UserFollower;
use App\CollaborativeFriend;

class TimelineController extends Controller {

    private $userId;
    private $user;
    private $userName;
    public $category_type;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function getUserMentions() {
        $following = UserFollower::select('user_id')->where('followed_by', $this->userId)->get()->toArray();
        $users = User::whereIn('id', $following)->get()->toArray();
        $user_data = array();
        foreach ($users as $key => $val) {
            $user_data[$key]['id'] = $val['id'];
            $user_data[$key]['name'] = $val['first_name'] . ' ' . $val['last_name'];
            $user_data[$key]['avatar'] = getUserImage($val['photo'], $val['social_photo'], $val['gender']);
            $user_data[$key]['type'] = 'user';
        }
        echo json_encode($user_data);
    }

    function timeline() {
        $data['title'] = 'Musician | Timeline';
        $data['welcome_message'] = '';
        if (Session::has('welcomeback')) {
            $data['welcome_message'] = Session::get('welcomeback');
        }
        $data['gigs'] = PostEvent::select('title', 'id')->where('user_id', $this->userId)->get();
        $data['groups'] = Group::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['studios'] = TeachingStudio::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['accompanists'] = Accompanist::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
//        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
//        $data['mention_users'] = User::where('id', '!=', $this->userId)->get()->toJson();

        $data['post_count'] = Post::where('type', '!=', 'gig')->count();

        return view('user.timeline', $data);
    }

    function showAllFriends() {
        $data['title'] = 'Musician | Collaborative Friends';
        $data['welcome_message'] = '';
        if (Session::has('welcomeback')) {
            $data['welcome_message'] = Session::get('welcomeback');
        }
        $data['gigs'] = PostEvent::select('title', 'id')->where('user_id', $this->userId)->get();
        $data['groups'] = Group::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['studios'] = TeachingStudio::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['accompanists'] = Accompanist::select('name', 'id', 'pic')->where('admin_id', $this->userId)->get();
        $data['friends'] = CollaborativeFriend::where('friend_id', $this->userId)->with('getFriendDetail')->get();
//        $data['mention_users'] = User::whereIn('id', $user_follows)->get()->toJson();
//        $data['mention_users'] = User::where('id', '!=', $this->userId)->get()->toJson();

        $data['post_count'] = Post::where('type', '!=', 'gig')->count();

        return view('user.collaborative_friends', $data);
    }

    function createGigView() {
        $data['title'] = 'Musician | Create Gig';
        $data['artistTypes'] = Category::where('is_solo', 1)->orderBy('title')->get();
        return view('user.create_gig', $data);
    }

    function editGigView($id) {
        $data['gig'] = PostEvent::find($id);
        if (!$data['gig']) {
            return Redirect::to(URL::previous());
        }
        $data['title'] = 'Musician | Edit Gig';
        $data['categories'] = Category::where('is_solo', 1)->orderBy('title')->get();
        $data['ensembleCategories'] = Category::where('is_ensemble', 1)->orderBy('title')->get();
        $data['genres'] = ['Baroque', 'Classical', 'Jazz', 'Country', 'World', 'Rock', 'Electronic', 'Popular', 'Wedding'];
        $selectedGigCategoryIds = SelectedGigCategory::where('gig_id', $data['gig']->id)->pluck('category_id');
        $categoryIds = [];
        foreach ($selectedGigCategoryIds as $studioCategoryId) {
            array_push($categoryIds, $studioCategoryId);
        }
        $data['categoryIds'] = $categoryIds;
        return view('user.edit_gig', $data);
    }

    function postTimeline(Request $request) {
        $validator = Validator::make($request->all(), [
                    'location' => 'required|max:191',
                    'range' => 'required',
                    'price' => 'required|numeric',
                    'per_unit' => 'required',
                    'event_title' => 'required',
                    'event_detail' => 'required'
        ]);
        if ($validator->fails()) {
            $errors = implode($validator->errors()->all(), '<br>');
            $result = array('success' => 0, 'message' => $errors);
            return json_encode($result);
        }

        $msg = 'Event Created Successfully';
        $edit_id = ($request->edit_id) ? $request->edit_id : '';
        if (isset($edit_id) && $edit_id != '') {
            $post_event = PostEvent::find($edit_id);
            $msg = 'Event Updated Successfully';
            SelectedGigCategory::where('gig_id', $edit_id)->delete();
        } else {
            $post = new Post();
            $post->text = $request->event_title;
            $post->type = 'gig';
            $post->user_id = $this->userId;
            $post->save();
            $post_event = new PostEvent();
            $post_event->post_id = $post->id;
            $post_event->user_id = $this->userId;
        }
        $post_event->title = $request->event_title;
        $post_event->description = $request->event_detail;
        $post_event->location = $request->location;
        $post_event->lat = $request->lat;
        $post_event->lng = $request->lng;
        $post_event->range = $request->range;
        $post_event->price = $request->price;
        $post_event->per_unit = $request->per_unit;
        $post_event->unit_id = $request->unit_id;
        $post_event->ensemble_category_id = $request->ensemble_category;
        $post_event->genre = $request->genre;
        $post_event->status = ($request->status) ? 'inactive' : 'active';
        $post_event->allow_booking = ($request->custom_booking) ? '1' : '0';

        $pic = $request->profile_pic;
        if ($pic) {
            $pic = str_replace('data:image/png;base64,', '', $pic);
            $pic = str_replace(' ', '+', $pic);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            $destinationPath = public_path('../uploads/events');
            $post_event->profile_pic = $request->photo;
            $post_event->original_profile_pic = $request->original_photo;
            $completePath = 'uploads/events/' . $image_name;
            addMediaForBase64Images($completePath, 'image', '', $request->profile_pic);
        }

        $cover = $request->file('cover');
        if ($cover) {
            $photo_name = uniqid() . '.' . $cover->getClientOriginalExtension();
            $completePath = 'uploads/events/' . $photo_name;
            $photo_name = asset('uploads/events/' . $photo_name);
            $post_event->image = $photo_name;
            addMedia($completePath, 'image', '', $cover);
            $cover->move('uploads/events', $photo_name);
        }

        /*
         * Get time zone form lat lng
         */
        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $lat = $request->lat;
        $lng = $request->lng;
        $curl_url = "https://maps.googleapis.com/maps/api/timezone/json?location=$lat,$lng&timestamp=$timestamp&key=AIzaSyDdxlXEZmkr-7RJsFN7wqX5bJpBUTfzhxk";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $curl_url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = json_decode(curl_exec($ch));
        curl_close($ch);
        if ($response->status == 'OK') {
            $gmtTime = (($response->rawOffset) - $response->dstOffset);
            if (strpos($response->rawOffset, '-') !== FALSE)
                if (isset($gmtTime) && $gmtTime != '') {
                    $gmpOffset = ($gmtTime / 60);
                    $post_event->timezone = $gmpOffset / 60;
                }
        }
        $save_time_zone = -($post_event->timezone);
        $new_time = date("Y-m-d H:i:s", strtotime("$save_time_zone hours"));
        $post_event->utc_date_time = $new_time;
        $post_event->save();

        $request['categories'] = explode(',', $request['categories']);
        foreach ($request['categories'] as $category) {
            $selectedStudioCategory = new SelectedGigCategory();
            $selectedStudioCategory->gig_id = $post_event->id;
            $selectedStudioCategory->category_id = $category;
            $selectedStudioCategory->save();
        }

        $result = array('success' => 1, 'message' => $msg);
        return json_encode($result);
    }

    //Get Events data Ajax call
    function getEvents(Request $request) {
        $type = $request->type;
        $skip = $request->skip;
        $limit = $request->take;
        $result['data'] = PostEvent::skip($skip)->take($limit)->where('status', $type)->where('user_id', $this->userId)->orderBy('created_at', 'DESC')->get();
        $result = view('user.loader.getevents', $result)->render();
        return json_encode($result);
    }

    function deleteEvent(Request $request) {
        $id = $request->id;
        deleteNotification('post', $id);
        Post::where('id', $id)->delete();
        return 1;
    }

    function deleteEventPic(Request $request) {
        PostEvent::where('id', $request->id)->update(['image' => '']);
        return 1;
    }

    function searchYoutube() {
        $q = $_GET['q'];
        $token = $_GET['token'];
        $params = [
            'q' => $q,
            'type' => 'video',
            'part' => 'id, snippet'
        ];
        $search = Youtube::paginateResults($params, $token);
        $response['html'] = '';
        if ($search['results']) {
            $data['results'] = $search['results'];
            $response['html'] = view('user.loader.youtube_loader', $data)->render();
        } else {
            $response['html'] = false;
        }
        $response['next_page_token'] = $search['info']['nextPageToken'];
        return response()->json($response);
    }

    function getYoutubeVideoLink() {
        $id = $_GET['id'];
        $video = Youtube::getVideoInfo($id);
        return response()->json($video);
    }

}
