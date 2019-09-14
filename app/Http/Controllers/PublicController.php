<?php

namespace App\Http\Controllers;

use App\Accompanist;
use App\AccompanistMember;
use App\Category;
use App\CollaborativeFriend;
use App\FollowServie;
use App\GalleryMedia;
use App\Group;
use App\GroupMember;
use App\Language;
use App\Post;
use App\PostEvent;
use App\Privacysetting;
use App\ProfileView;
use App\Review;
use App\ServiceProfileView;
use App\TeachingStudio;
use App\TeachingStudioMember;
use App\Union;
use App\User;
use App\UserFollower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class PublicController extends Controller {

    function index() {
        if (Auth::guard('user')->check()) {
            return redirect('timeline');
        }
        $data['title'] = 'Musician | Home Page';
        $data['top_musican'] = User::where(['type' => 'artist', 'is_featured_by_admin' => 1])
                        ->orderBy('rating_percentage', 'desc')
                        ->orderBy('number_of_reviews', 'desc')
                        ->orderBy('updated_at', 'desc')
                        ->take(6)->get();
        $data['top_gigs'] = PostEvent::withCount('successfulBookings')
                        ->orderBy('successful_bookings_count', 'desc')
                        ->orderBy('updated_at', 'desc')
                        ->take(6)->get();

        $data['top_studios'] = TeachingStudio::
//                            withCount('successfulBookings')
//                            ->orderBy('successful_bookings_count', 'desc')
                        orderBy('updated_at', 'desc')
                        ->take(6)->get();

        $data['top_groups'] = Group::orderBy('updated_at', 'desc')
                        ->take(6)->get();

        $data['top_accompanists'] = Accompanist::orderBy('updated_at', 'desc')
                        ->take(6)->get();

        $data['top_testimonials'] = Review::where('type', 'testimonial')
                        ->orderBy('updated_at', 'desc')
                        ->take(6)->get();

        $data['popular_searches'] = Category::where('search_count', '>', 0)
                        ->orderByDesc('search_count')
                        ->take(4)->get();
        return view('public.index', $data);
    }

    function searchMusician(Request $request) {
       
        $data['title'] = 'Musician | Search';
        $query = User::query();
        if ($request->has('search')) {
            $data['search'] = $request->search;
        }
        $data['ip_location'] = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        if (isset($request['cat']) && $request['cat'] != '') {
            $data['cat'] = $request->cat;
            $category = Category::find($request->cat);

            $data['category'] = $category;
            $category->search_count = $category->search_count + 1;
            $category->save();
        }
        $data['specialization'] = Category::orderBy('title')->get();
        $data['languages'] = Language::orderBy('name')->get();
        $data['union'] = Union::orderBy('title')->get();
        $data['genres'] = ['Baroque', 'Classical', 'Jazz', 'Country', 'World', 'Rock', 'Electronic', 'Popular', 'Wedding'];
        $data['levels_taught'] = ['Beginner', 'Intermediate', 'Advance', 'All levels'];

        // get search-type and match with polular searches
        $type = '';
        if($request->has('search_type'))
        {
            $type = $request->search_type;
        }
        
        if($type == 'musicians')
        {
          $data['popular_searches'] = Category::where('search_count', '>', 0)
                                        ->where('is_for_musician', '=', 1)
                                        ->orderByDesc('search_count')->take(4)->get();
        }
        elseif ($type == 'groups') {
            $data['popular_searches'] = Category::where('search_count', '>', 0)
                                        ->where('is_for_group', '=', 1)
                                        ->orderByDesc('search_count')->take(4)->get();
        
        }
        elseif ($type == 'teaching_studios') {
            $data['popular_searches'] = Category::where('search_count', '>', 0)
                                        ->where('is_for_studio', '=', 1)
                                        ->orderByDesc('search_count')->take(4)->get();
        }
        else if ($type== 'accompanists') {
            $data['popular_searches'] = Category::where('search_count', '>', 0)
                                        ->where('is_for_accompanist', '=', 1)
                                        ->orderByDesc('search_count')->take(4)->get();
        }
        else
        {
             $data['popular_searches'] = Category::where('search_count', '>', 0)->orderByDesc('search_count')->take(4)->get();
        }
        
        
        
        
        return view('public.search', $data);
    }

    function viewAllCategories(Request $request) {
        $data['title'] = 'Musician | All Categories';
        $data['popular_searches_one'] = Category::where('search_count', '>', 0)->where('is_for_studio', 1)->orderByDesc('search_count')->take(4)->get();
        $data['popular_searches_two'] = Category::where('search_count', '>', 0)->where('is_for_group', 1)->orderByDesc('search_count')->take(4)->get();
        $data['categories'] = Category::all();
        return view('user/all_categories', $data);
    }

    //getMusician data Ajax call
    function getMusician(Request $request) {
       //dd($request->all());
        $filter = json_decode($request->filter, true);
//        $lat = $filter['lat'];
//        $lng = $filter['lng'];
        $lat = '';
        $lng = '';
        $skip = isset($filter['skip']) ? $filter['skip'] : 0;
        $limit = isset($filter['take']) ? $filter['take'] : 12;
        $user_id = '';
        $result['current_id'] = '';
        $result['current_photo'] = '';
        $result['current_user'] = '';
        $result['current_name'] = '';
        if (Auth::user()) {
            $user_id = Auth::user()->id;
            $result['current_id'] = $user_id;
            $result['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
            $result['current_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $result['current_user'] = Auth::user();
            $following = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get()->toArray();
            $result['followings'] = User::whereIn('id', $following)->get();
//            
        }

//        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        $address = '';
        $lat = '';
        $lng = '';
        if (isset($filter['loc']) && $filter['loc'] != '') {
            $loc = $filter['loc'];
            $address = str_replace(' ', '+', $loc);
            $geocode = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . $address . '&key=AIzaSyApyIRH_zIWZT32AXvIU2A2Y-A0fvPSv50');
            $geocode = json_decode($geocode, true);
            if ($geocode['status'] != 'ZERO_RESULTS') {
                $lat = $geocode['results'][0]['geometry']['location']['lat'];
                $lng = $geocode['results'][0]['geometry']['location']['lng'];
            }
        }

        $query = '';

        $searchType = $filter['search_type'];

        if ($searchType == 'musicians') {
            $query = User::where('type', 'artist')->where('is_active', 1);
            if ($lat && $lng && isset($filter['radius']) && !empty($filter['radius'])) {
                $query = User::where('is_active', 1)->selectRaw("*,
                                ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(artist_lat) ) *
                                cos( radians(artist_lng) - radians($lng) ) + 
                                sin( radians($lat) ) *
                                sin( radians(artist_lat) ) ) ) 
                                AS distance")
                        ->where('type', 'artist')
                        ->having('distance', '<=', $filter['distance'])
                        ->orderBy('distance', 'asc');
            } else if (isset($filter['loc']) && $filter['loc'] != '') {
                $loc = $filter['loc'];
                $query->where('address', 'like', '%' . $loc . '%');
//                dd($query->get());
            }

            if (Auth::user()) {
                if (isset($filter['get_followings']) && !empty($filter['get_followings'])) {
                    $followingIds = UserFollower::where('followed_by', $user_id)->select('user_id')->get()->toArray();
                    $query->whereIn('id', $followingIds);
                }
            }
        } else if ($searchType == 'gigs') {

            $query = PostEvent::where('status', 'active');
            if ($lat && $lng && isset($filter['radius']) && !empty($filter['radius'])) {
                $query = PostEvent::selectRaw("*,
                                ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(lat) ) *
                                cos( radians(lng) - radians($lng) ) + 
                                sin( radians($lat) ) *
                                sin( radians(lat) ) ) ) 
                                AS distance")
                        ->having('distance', '<=', $filter['distance'])
                        ->where('status', 'active')
                        ->orderBy('distance', 'asc');
            } else if (isset($filter['loc']) && $filter['loc'] != '') {
                $loc = $filter['loc'];
                $query->where('location', 'like', '%' . $loc . '%');
            }
        } else if ($searchType == 'groups') {

            $query = Group::query();
            if ($lat && $lng && isset($filter['radius']) && !empty($filter['radius'])) {
                $query = Group::selectRaw("*,
                                ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(lat) ) *
                                cos( radians(lng) - radians($lng) ) + 
                                sin( radians($lat) ) *
                                sin( radians(lat) ) ) ) 
                                AS distance")
                        ->having('distance', '<=', $filter['distance'])
                        ->orderBy('distance', 'asc');
            } else if (isset($filter['loc']) && $filter['loc'] != '') {
                $loc = $filter['loc'];
                $query->where('location', 'like', '%' . $loc . '%');
            }
        } else if ($searchType == 'accompanists') {

            $query = Accompanist::query();
            if ($lat && $lng && isset($filter['radius']) && !empty($filter['radius'])) {
                $query = Accompanist::selectRaw("*,
                                ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(lat) ) *
                                cos( radians(lng) - radians($lng) ) + 
                                sin( radians($lat) ) *
                                sin( radians(lat) ) ) ) 
                                AS distance")
                        ->having('distance', '<=', $filter['distance'])
                        ->orderBy('distance', 'asc');
            } else if (isset($filter['loc']) && $filter['loc'] != '') {
                $loc = $filter['loc'];
                $query->where('location', 'like', '%' . $loc . '%');
            }
        } else if ($searchType == 'teaching_studios') {

            $query = TeachingStudio::query();
            if ($lat && $lng && isset($filter['radius']) && !empty($filter['radius'])) {
                $query = TeachingStudio::selectRaw("*,
                                ( 6371 * acos( cos( radians($lat) ) *
                                cos( radians(artist_lat) ) *
                                cos( radians(artist_lng) - radians($lng) ) + 
                                sin( radians($lat) ) *
                                sin( radians(artist_lat) ) ) ) 
                                AS distance")
                        ->having('distance', '<=', $filter['distance'])
                        ->orderBy('distance', 'asc');
            } else if (isset($filter['loc']) && $filter['loc'] != '') {
                $loc = $filter['loc'];
                $query->where('location', 'like', '%' . $loc . '%');
            }

            if (isset($filter['lesson_type']) && count($filter['lesson_type']) > 0) {
                $lesson_type = $filter['lesson_type'];
                $query->whereIn('lesson_type', $lesson_type);
            }

            if (isset($filter['accepting_students']) && $filter['accepting_students'] != '') {
                $query->where('is_accepting_students', 1);
            }

            if (isset($filter['levels_taught']) && count($filter['levels_taught']) > 0) {
                $levels_taught = $filter['levels_taught'];
                $query->whereIn('level_taught', $levels_taught);
            }
        }

        if (isset($filter['search']) && !empty($filter['search'])) {
            $search = $filter['search'];

            $query->when($searchType == 'musicians', function($x) use($search) {
                        $x->where(function($x)use($search) {
                            $x->orwhere('first_name', 'LIKE', '%' . $search . '%');
                            $x->orwhere('last_name', 'LIKE', '%' . $search . '%');
                            $x->orWhereRaw("concat(first_name, ' ', last_name) like '%$search%' ");
                        });
                    })
                    ->when($searchType == 'gigs', function($x) use($search) {
                        $x->where('title', 'LIKE', '%' . $search . '%');
                    })
                    ->when($searchType == 'groups' || $searchType == 'teaching_studios' || $searchType == 'accompanists', function($x) use($search) {
                        $x->where('name', 'LIKE', '%' . $search . '%');
                    });
        }

        if (isset($filter['gender']) && count($filter['gender']) > 0) {
            $gender = $filter['gender'];

            $query->when($searchType == 'musicians', function($x) use($gender) {
                        $x->whereIn('gender', $gender);
                    })
                    ->when($searchType == 'teaching_studios' || $searchType == 'gigs' || $searchType == 'groups' || $searchType == 'accompanists', function($x) use($gender) {
                        $x->whereHas('user', function ($q) use($gender) {
                            $q->where('gender', $gender);
                        });
                    });
        }

        if (isset($filter['category']) && !empty($filter['category']) && $searchType != 'accompanists' && $searchType != 'groups') {
            $categoryId = $filter['category'];
            $query->whereHas('getSelectedCategories', function ($q) use($categoryId) {
                $q->where('category_id', $categoryId);
            });
        }

        if (isset($filter['specilaization']) && count($filter['specilaization']) > 0 && $searchType != 'accompanists') {
            $specilaization = $filter['specilaization'];
            if ($searchType == 'groups') {
                $query->where('category_id', $specilaization);
            } else if ($searchType == 'teaching_studios') {
                $query->whereHas('getSelectedCategories', function ($q) use($specilaization) {
                    $q->whereIn('studio_category_id', $specilaization);
                });
            } else {
                $query->whereHas('getSelectedCategories', function ($q) use($specilaization) {
                    $q->whereIn('category_id', $specilaization);
                });
            }
        }

        if (isset($filter['genre']) && count($filter['genre']) > 0 && ($searchType == 'musicians' || $searchType == 'gigs' || $searchType == 'teaching_studios')) {
            $genre = $filter['genre'];
            $query->whereIn('genre', $genre);
        }

        if (isset($filter['languare']) && count($filter['languare']) > 0 && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $languare = $filter['languare'];
            $query->whereIn('language', $languare);
        }

        if (isset($filter['union']) && count($filter['union']) > 0 && ($searchType == 'musicians' || $searchType == 'teaching_studios')) {
            $union = $filter['union'];
            $query->whereHas('getUnion', function ($q) use($union) {
                $q->where('title', $union);
            });
        }

        if (isset($filter['affiliation']) && count($filter['affiliation']) > 0 && ($searchType == 'musicians' || $searchType == 'teaching_studios')) {
            if (count($filter['affiliation']) < 2) {
                $affiliation = $filter['affiliation'];
                if (in_array("union", $affiliation))
                    $query->whereHas('getUnion');
                else if (in_array("non-union", $affiliation))
                    $query->whereDoesntHave('getUnion');
            }
        }

        if (isset($filter['availability']) && $filter['availability'] != '') {
            $query->where('allow_booking', 1);
        }

        if (isset($filter['degree']) && $filter['degree'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $degree = $filter['degree'];
            $query->whereHas('getEducations', function ($q) use($degree) {
                $q->where('title', $degree);
            });
        }

        if (isset($filter['institute']) && $filter['institute'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $institue = $filter['institute'];
            $query->whereHas('getEducations', function ($q) use($institue) {
                $q->where('institute_name', $institue);
            });
        }

        if (isset($filter['education_start_year']) && $filter['education_start_year'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $year = $filter['education_start_year'];
            $query->whereHas('getEducations', function ($q) use($year) {
                $q->where('start_year', $year);
            });
        }

        if (isset($filter['education_end_year']) && $filter['education_end_year'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $year = $filter['education_end_year'];
            $query->whereHas('getEducations', function ($q) use($year) {
                $q->where('end_year', $year);
            });
        }

        if (isset($filter['job_title']) && $filter['job_title'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $title = $filter['job_title'];
            $query->whereHas('getExperiences', function ($q) use($title) {
                $q->where('title', $title);
            });
        }

        if (isset($filter['company_name']) && $filter['company_name'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $institue = $filter['company_name'];
            $query->whereHas('getExperiences', function ($q) use($institue) {
                $q->where('institute_name', $institue);
            });
        }

        if (isset($filter['experience_start_year']) && $filter['experience_start_year'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $year = $filter['experience_start_year'];
            $query->whereHas('getExperiences', function ($q) use($year) {
                $q->where('start_year', $year);
            });
        }

        if (isset($filter['experience_end_year']) && $filter['experience_end_year'] != '' && ($searchType == 'musicians' || $searchType == 'teaching_studios' || $searchType == 'accompanists')) {
            $year = $filter['experience_end_year'];
            $query->whereHas('getExperiences', function ($q) use($year) {
                $q->where('end_year', $year);
            });
        }

        if (isset($filter['price']) && $filter['price'] != '' && isset($filter['price_search']) && !empty($filter['price_search']) && ($searchType == 'gigs' || $searchType == 'accompanists' || $searchType == 'teaching_studios')) {
            $price = $filter['price'];
            if ($price < 200) {
                $query->select('*', DB::raw("IF(unit_id = 1, price / per_unit, price / (per_unit / 60)) AS price_per_hour"))
                        ->having('price_per_hour', '<=', $price);
            } else {
                $query->select('*', DB::raw("IF(unit_id = 1, price / per_unit, price / (per_unit / 60)) AS price_per_hour"))
                        ->having('price_per_hour', '>=', $price);
            }
        }

        $result['data'] = new \Illuminate\Support\Collection;
        if ($searchType == 'musicians') {
            $result['data'] = $query->skip($skip)->take($limit)->when($user_id, function($q) use($user_id) {
                        $q->where('id', '!=', $user_id);
                    })
                    ->orderBy('created_at', 'DESC')
                    ->get();
            $result['current_id'] = '';
            $result['current_user'] = '';
            $result['current_photo'] = '';
            $result['current_name'] = '';
            if (Auth::user()) {
                $result['current_id'] = Auth::user()->id;
                $result['current_user'] = Auth::user();
                $result['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
                $result['current_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            }
            $response['html'] = view('public.loader.getmusician', $result)->render();
        } else if ($searchType == 'gigs') {
            $result['data'] = $query->skip($skip)->take($limit)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            $response['html'] = view('public.loader.get_gigs_for_search', $result)->render();
        } else if ($searchType == 'groups') {

            $result['data'] = $query->skip($skip)->take($limit)
                    ->withCount('bookmarked')
                    ->orderBy('created_at', 'DESC')
                    ->get();

            $response['html'] = view('public.loader.get_groups_for_search_new', $result)->render();
        } else if ($searchType == 'teaching_studios') {
            if (Auth::user()) {
                $result['data'] = $query->skip($skip)->take($limit)
                        ->orderBy('created_at', 'DESC')
                        ->withCount('bookmarked')
                        ->get();
            } else {
                $result['data'] = $query->skip($skip)->take($limit)
                        ->orderBy('created_at', 'DESC')
                        ->get();
            }
            $response['html'] = view('public.loader.get_studios_for_search_new', $result)->render();
        } else if ($searchType == 'accompanists') {

            $result['data'] = $query->skip($skip)->take($limit)
                    ->withCount('bookmarked')
                    ->orderBy('created_at', 'DESC')
                    ->get();

            $response['html'] = view('public.loader.get_accompanists_for_search_new', $result)->render();
        }

        $response['total'] = $result['data']->count();
        $response['distance'] = $filter['distance'];
        return json_encode($response);
    }

    function profileTimeline($user_id) {
        $data['title'] = 'Timeline';
        $data['user'] = User::where('id',$user_id)->with('requests','friends','checkFriend')->first();
        if (!$data['user']) {
            return Redirect::to(Url::previous());
        }
        if (!$data['user']->is_active) {
            return Redirect::to('/timeline');
//            echo "Deactive Acccount <a href='".asset('timeline')."'>Go Home</a>";exit;
        }
        if ($data['user']->is_private) {
//            return Redirect::to('/timeline');
            if (Auth::user() && $data['user']->id != Auth::user()->id) {

                $user_follow = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get();
////                echo '<pre>';
////                print_r($user_follow->pluck('user_id')->toArray());exit;
//                if (!in_array($user_id, $user_follow->pluck('user_id')->toArray())) {
//                    echo "Private Acccount <a href='" . asset('timeline') . "'>Go Home</a>";
//                    exit;
//                }
            } elseif (!Auth::user()) {
                return Redirect::to('/');
                echo "Private Acccount <a href='" . asset('timeline') . "'>Go Home</a>";
                exit;
            }
        }
        $data['gigs'] = [];
        $data['groups'] = [];
        $data['studios'] = [];
        $data['accompanists'] = [];
        if (Auth::user() && $data['user']->id == Auth::user()->id) {
            $data['gigs'] = PostEvent::select('title', 'id')->where('user_id', Auth::user()->id)->get();
            $data['groups'] = Group::select('name', 'id', 'pic')->where('admin_id', Auth::user()->id)->get();
            $data['studios'] = TeachingStudio::select('name', 'id', 'pic')->where('admin_id', Auth::user()->id)->get();
            $data['accompanists'] = Accompanist::select('name', 'id', 'pic')->where('admin_id', Auth::user()->id)->get();
        }
        if (Auth::user() && $data['user']->id != Auth::user()->id) {
            $check_view = ProfileView::where('viewed_by', Auth::user()->id)->where('profile_viewed', $user_id)->first();
            if (!$check_view) {
                $add_view = new ProfileView;
                $add_view->viewed_by = Auth::user()->id;
                $add_view->profile_viewed = $user_id;
                $add_view->save();
            }
        }
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['user_id_current'] = $user_id;
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();
        return view('public.profile_timeline', $data);
    }

    function profileGigsAndGroups($user_id) {
        $data['title'] = 'Services';
        $data['user'] = User::find($user_id);
        $data['user_id_current'] = $user_id;
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();
        return view('public.profile_gigs_and_groups', $data);
    }

    function profileMedia($user_id) {
        $data['title'] = 'Media';
        $data['user_id_current'] = $user_id;
        $data['user'] = User::where('id', $user_id)->with('getPostsImages', 'getPostsAudios', 'getPostsVideos')->first();
//        dd($data['user']->getPostsImages);
        

        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();
        return view('public.profile_media', $data);
    }

    function fetchProfileMedia(Request $request) {
        $data['current_id'] = '';
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
            $data['user_id'] = $request->user_id;
        }
        $user = User::find($request->user_id);
        if ($user && $user->type == 'artist') {
            if ($request->type == 'image') {
                $data['records'] = GalleryMedia::where('user_id', $request->user_id)
                        ->orderBy('updated_at', 'desc')
                        ->skip($request->skip)
                        ->take($request->take)
                        ->where('type', 'image')
                        ->get();
                return view('public.loader.profile_media_loader', $data);
            } else if ($request->type == 'video') {
                $data['records'] = GalleryMedia::where('user_id', $request->user_id)
                        ->orderBy('updated_at', 'desc')
                        ->skip($request->skip)
                        ->take($request->take)
                        ->where('type', 'video')
                        ->get();
                return view('public.loader.profile_media_loader', $data);
            } else if ($request->type == 'audio') {
                $data['records'] = GalleryMedia::where('user_id', $request->user_id)
                        ->orderBy('updated_at', 'desc')
                        ->skip($request->skip)
                        ->take($request->take)
                        ->where('type', 'audio')
                        ->get();
                return view('public.loader.profile_media_loader', $data);
            }
        }
    }

    function profileReviews($user_id) {
        $data['title'] = 'Reviews';
        $data['user'] = User::find($user_id);
        if (!$data['user']) {
            return Redirect::to(URL::previous());
        }
        $data['user_id_current'] = $user_id;
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();
        return view('public.profile_reviews', $data);
    }

    function profileTestimonials($user_id) {
        $data['title'] = 'Testimonials';
        $data['user'] = User::find($user_id);
        if (!$data['user']) {
            return Redirect::to(URL::previous());
        }
        $data['user_id_current'] = $user_id;
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        return view('public.profile_testimonials', $data);
    }

    function profileReviewAfterBooking($booking_id) {

        $booking = \App\Booking::find($booking_id);

        if (Auth::user() && $booking) {

            if ($booking->user->id == Auth::user()->id) {

                $data['user'] = $booking->artist;
                $data['user_id_current'] = $data['user']->id;
                if ($data['user']->type != 'artist') {
                    return Redirect::to(URL::previous());
                }
                if (!$booking->is_reviewed) {
                    $data['review_enabled'] = 1;
                    $data['booking_id'] = $booking_id;
                    $data['gig_type'] = $booking->gig_type;
                    $data['gig_type_id'] = '';
                    if ($booking->gig_type == 'gig') {

                        $data['title'] = 'Musician | Gig Detail';
                        $data['gig_type_id'] = $booking->gig_id;
                        $data['gig'] = PostEvent::find($data['gig_type_id']);
                        $data['user_id_current'] = $data['gig']->user_id;
                        return view('public.gig_detail', $data);
                    } else if ($booking->gig_type == 'group') {

                        $data['title'] = 'Musician | Group Detail';
                        $data['gig_type_id'] = $booking->group_id;
                        $data['group'] = Group::find($data['gig_type_id']);
                        $data['user_id_current'] = $data['group']->admin_id;
                        return view('public.group_reviews', $data);
                    } else if ($booking->gig_type == 'teaching_studio') {

                        $data['title'] = 'Musician | Teaching Studio Detail';
                        $data['gig_type_id'] = $booking->teaching_studio_id;
                        $data['studio'] = TeachingStudio::find($data['gig_type_id']);
                        $data['user_id_current'] = $data['studio']->admin_id;
                        return view('public.teaching_studio_reviews', $data);
                    } else if ($booking->gig_type == 'accompanist') {

                        $data['title'] = 'Musician | Accompanist Detail';
                        $data['gig_type_id'] = $booking->accompanist_id;
                        $data['accompanist'] = Accompanist::find($data['gig_type_id']);
                        $data['user_id_current'] = $data['accompanist']->admin_id;
                        return view('public.accompanist_reviews', $data);
                    }
                }
            }
        }

        return Redirect::to(URL::previous());
    }

    function profileTeachingStudios($user_id) {
        $data['title'] = 'Teaching Studios';
        $data['user'] = User::find($user_id);
        $data['user_id_current'] = $user_id;
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        return view('public.profile_teaching_studios', $data);
    }

    function profileAbout($user_id) {
        $data['title'] = 'About';
        $data['user'] = User::find($user_id);
        $data['user_id_current'] = $user_id;
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();

        return view('public.profile_about', $data);
    }

    function userTimeLine(Request $request) {
        $data['showPosts']=false;
        if (Auth::user()) {
            $user = User::select('id','is_private')->where('id', $request->user_id)->first();
            if ($user->id == Auth::user()->id)
                {
                $data['showPosts'] = TRUE;
//                dd('current u');
            }

            elseif ($user->is_private)
            {

                $user_follow = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get();
                if (in_array($request->user_id, $user_follow->pluck('user_id')->toArray())) {
                    $data['showPosts'] = TRUE;
                }


            }
            elseif($user->is_private == 0)
            {
                $data['showPosts'] = TRUE;
            }

            $data['current_id'] = Auth::user()->id;
            $data['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
//            $data['posts'] = Post::skip($request['skip'])
//                    ->take($request['take'])->withCount('liked', 'bookmarked')
//                    ->where('user_id', $request->user_id)
//                    ->where('type', '!=', 'gig')
//                    ->orderBy('created_at', 'Desc')
//                    ->get();
            $data['posts'] = Post::skip($request['skip'])
                    ->with(['comments' => function($a) {
                            $a->orderBy('created_at', 'desc');
                        }])
                ->with('isMusicianFollower', 'isMusicianFriend')
                    ->take($request['take'])->withCount('liked', 'bookmarked', 'comments')
                    ->where('user_id', $request->user_id)
                    ->where('type', '!=', 'gig')
                    ->orderBy('created_at', 'Desc')
                    ->get();
        } else {
            $data['current_id'] = $data['current_photo'] = '';
//            $data['posts'] = Post::skip($request['skip'])
//                    ->take($request['take'])
//                    ->where('user_id', $request->user_id)
//                    ->where('type', '!=', 'gig')
//                    ->orderBy('created_at', 'Desc')
//                    ->get();
            $data['posts'] = Post::skip($request['skip'])
                    ->with(['comments' => function($a) {
                            $a->orderBy('created_at', 'desc');
                        }])
                    ->take($request['take'])->withCount('liked', 'bookmarked', 'comments')
                    ->where('user_id', $request->user_id)
                    ->where('type', '!=', 'gig')
                    ->orderBy('created_at', 'Desc')
                    ->get();
        }
        return view('user.loader.musician_timeline', $data);
    }

    function fetchGigsGroups(Request $request) {
        $data['current_id'] = '';
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
        }
        $checkMusician = User::find($request->user_id);
        if ($checkMusician && $checkMusician->allow_booking) {
            if ($request->type == 'gigs') {
                $data['gigs'] = \Illuminate\Support\Collection::make(new Post);
                $data['gigs'] = Post::where('user_id', $request->user_id)
                        ->skip($request->skip)
                        ->take($request->take)
                        ->where('type', 'gig')
                        ->whereHas('getEvent', function($q) {
                            $q->where('status', 'active');
                        })
                        ->get();
                return view('public.loader.gigs_loader', $data);
            } else if ($request->type == 'groups') {
                $data['groups'] = Group::where('admin_id', $request->user_id)
                        ->skip($request->skip)
                        ->take($request->take)
                        ->withCount('bookmarked')
                        ->get();
                return view('public.loader.groups_loader', $data);
            } else if ($request->type == 'teaching_studios') {
                $data['teachingStudios'] = TeachingStudio::where('admin_id', $request->user_id)
                        ->skip($request->skip)
                        ->take($request->take)
                        ->withCount('bookmarked')
                        ->get();
                return view('public.loader.teaching_studios_loader', $data);
            } else if ($request->type == 'accompanists') {
                $data['accompanists'] = Accompanist::where('admin_id', $request->user_id)
                        ->skip($request->skip)
                        ->take($request->take)
                        ->withCount('bookmarked')
                        ->get();
                return view('public.loader.accompanists_loader', $data);
            }
        }
    }

    function fetchTeachingStudios(Request $request) {
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
            $data['teachingStudios'] = TeachingStudio::where('admin_id', $request->user_id)
                    ->skip($request->skip)
                    ->take($request->take)
                    ->withCount('bookmarked')
                    ->get();
        } else {
            $data['current_id'] = '';
            $data['teachingStudios'] = TeachingStudio::where('admin_id', $request->user_id)
                    ->skip($request->skip)
                    ->take($request->take)
                    ->get();
        }
        return view('public.loader.teaching_studios_loader', $data);
    }

    function fetchProfileReviews(Request $request) {
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
        } else {
            $data['current_id'] = '';
        }
        $type = $request['type'];
        if (Auth::user()) {
            if (Auth::user()->id == $request->user_id) {
                Review::where('user_id', $request->user_id)->update(['is_viewed' => 1]);
            }
        }
        if ($type == 'testimonial') {
            $data['reviews'] = Review::where('user_id', $request->user_id)
                    ->where('type', $type)
                    ->orderByDesc('created_at')
                    ->skip($request->skip)
                    ->take($request->take)
                    ->get();
        } else {
            $data['reviews'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->orderByDesc('created_at')
                    ->skip($request->skip)
                    ->take($request->take)
                    ->get();

            $response['reviews_count'] = Review::where('user_id', $request->user_id)
                            ->when($type != 'all', function ($q) use($type) {
                                $q->where('gig_type', $type);
                            })->count();

            $response['average_rating'] = Review::where('user_id', $request->user_id)
                            ->when($type != 'all', function ($q) use($type) {
                                $q->where('gig_type', $type);
                            })->avg('rating');

            $response['one_star_reviews_count'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->where('rating', '<=', 1)
                    ->count();

            $response['two_star_reviews_count'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->where('rating', '>', 1)
                    ->where('rating', '<=', 2)
                    ->count();

            $response['three_star_reviews_count'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->where('rating', '>', 2)
                    ->where('rating', '<=', 3)
                    ->count();

            $response['four_star_reviews_count'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->where('rating', '>', 3)
                    ->where('rating', '<=', 4)
                    ->count();

            $response['five_star_reviews_count'] = Review::where('user_id', $request->user_id)
                    ->when($type != 'all', function ($q) use($type) {
                        $q->where('gig_type', $type);
                    })
                    ->where('rating', '>', 4)
                    ->where('rating', '<=', 5)
                    ->count();
        }

        $response['html'] = view('public.loader.reviews_loader', $data)->render();
        return json_encode($response);
    }

    function fetchReviewsForDetailPage(Request $request) {
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
        } else {
            $data['current_id'] = '';
        }
        $type = $request['type'];
        $id = $request['id'];
        if (Auth::user()) {
            if (Auth::user()->id == $request->user_id) {
                Review::where('user_id', $request->user_id)->update(['is_viewed' => 1]);
            }
        }
        $data['reviews'] = Review::where('gig_type', $type)
                ->when($type == 'gig', function ($q) use($id) {
                    $q->where('gig_id', $id);
                })
                ->when($type == 'group', function ($q) use($id) {
                    $q->where('group_id', $id);
                })
                ->when($type == 'teaching_studio', function ($q) use($id) {
                    $q->where('teaching_studio_id', $id);
                })
                ->when($type == 'accompanist', function ($q) use($id) {
                    $q->where('accompanist_id', $id);
                })
                ->orderByDesc('created_at')
                ->skip($request->skip)
                ->take($request->take)
                ->get();

        $response['html'] = view('public.loader.reviews_loader_for_detail_page', $data)->render();
        return json_encode($response);
    }

    function groupDetail($group_id) {
        $data['group'] = Group::find($group_id);
        $data['user_id_current'] = $data['group']->admin_id;
        $data['title'] = 'Musician | Group Detail';
        if ($data['group']) {
            $data['og_image'] = asset('userassets/images/Scrap-Image-Musician.png');
            if ($data['group']->cover) {
                if (exif_imagetype(asset('public/images/' . $data['group']->cover)) == IMAGETYPE_PNG) {
                    $data['og_image'] = asset('public/images/' . $data['group']->cover);
                }
            }
            $data['og_title'] = $data['group']->name;
            $data['og_description'] = $data['group']->description;
            $data['suggestions'] = Group::whereNotIn('id', [$group_id])->inRandomOrder()->take(5)->get();
            return view('public.group_about', $data);
        }

        return Redirect::to(URL::previous());
    }

    function teachingStudioDetail($teaching_studio_id) {
        $data['studio'] = TeachingStudio::find($teaching_studio_id);
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.teaching_studio_about', $data);
        }
        return Redirect::to(URL::previous());
    }

    function teachingStudioTimeLine($teaching_studio_id) {
        $data['studio'] = TeachingStudio::where('id',$teaching_studio_id)->with('teachers')->first();
        if (Auth::user() && $data['studio']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)
                    ->where('studio_id', $teaching_studio_id)
                    ->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 's';
                $add_view->studio_id = $teaching_studio_id;
                $add_view->save();
            }
        }
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        $data['post_count'] = Post::where('studio_id', $teaching_studio_id)->count();
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.teaching_studio_time_line', $data);
        }
        return Redirect::to(URL::previous());
    }

    function teachingStudioReviews($teaching_studio_id) {
        $data['studio'] = TeachingStudio::find($teaching_studio_id);
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.teaching_studio_reviews', $data);
        }
        return Redirect::to(URL::previous());
    }

    function teachingStudioGallery($teaching_studio_id) {
        $data['studio'] = TeachingStudio::find($teaching_studio_id);
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.teaching_studio_gallery', $data);
        }
        return Redirect::to(URL::previous());
    }

    function accompanistDetail($accompanist_id) {
        $data['accompanist'] = Accompanist::find($accompanist_id);
        $data['user_id_current'] = $data['accompanist']->admin_id;
        $data['title'] = 'Musician | Accompanist Detail';
        if ($data['accompanist']) {
            return view('public.accompanist_about', $data);
        }
        return Redirect::to(URL::previous());
    }

    function accompanistReviews($accompanist_id) {
        $data['accompanist'] = Accompanist::find($accompanist_id);
        $data['user_id_current'] = $data['accompanist']->admin_id;
        $data['title'] = 'Musician | Accompanist Detail';
        if ($data['accompanist']) {
            return view('public.accompanist_reviews', $data);
        }
        return Redirect::to(URL::previous());
    }

    function accompanistGalery($accompanist_id) {
        $data['accompanist'] = Accompanist::find($accompanist_id);
        $data['user_id_current'] = $data['accompanist']->admin_id;
        $data['title'] = 'Musician | Accompanist Detail';
        if ($data['accompanist']) {
            return view('public.accompanist_gallery', $data);
        }
        return Redirect::to(URL::previous());
    }

    function accompanistTimeLine($accompanist_id) {
        $data['accompanist'] = Accompanist::where('id',$accompanist_id)->with('members','approvedMembers','checkMember','accompanistImages')->first();
        if (Auth::user() && $data['accompanist']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)
                    ->where('accompanist_id', $accompanist_id)
                    ->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 'a';
                $add_view->accompanist_id = $accompanist_id;
                $add_view->save();
            }
        }
        $data['user_id_current'] = $data['accompanist']->admin_id;
        $data['title'] = 'Musician | Accompanist Detail';
        $data['post_count'] = Post::where('accompanist_id', $accompanist_id)->count();
        if ($data['accompanist']) {
            return view('public.accompanist_time_line', $data);
        }
        return Redirect::to(URL::previous());
    }
    
    function accompanistMemebersList($accompanist_id) {
        $data['accompanist'] = Accompanist::where('id',$accompanist_id)->with('members','approvedMembers','checkMember','accompanistImages')->first();
        $existed_ids = AccompanistMember::where('accompanist_id',$accompanist_id)->select('user_id')->get()->toArray();
        if (Auth::user() && $data['accompanist']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)
                    ->where('accompanist_id', $accompanist_id)
                    ->first();
//            if (!$check_view) {
//                $add_view = new ServiceProfileView;
//                $add_view->user_id = Auth::user()->id;
//                $add_view->post_type = 'a';
//                $add_view->accompanist_id = $accompanist_id;
//                $add_view->save();
//            }
        }
        $data['friends'] = CollaborativeFriend::where('friend_id', Auth::user()->id)->whereNotIn('user_id',$existed_ids)->with('getFriendDetail')->get();
        $data['user_id_current'] = $data['accompanist']->admin_id;
        $data['title'] = 'Musician | Accompanist Members';
        $data['post_count'] = Post::where('accompanist_id', $accompanist_id)->count();
        if ($data['accompanist']) {
            return view('public.accompanist_friend_list', $data);
        }
        return Redirect::to(URL::previous());
    }

    function gigDetail($gig_id) {
        $data['gig'] = PostEvent::find($gig_id);
        $data['user_id_current'] = $data['gig']->user_id;
        $data['title'] = 'Musician | Gig Detail';
        if ($data['gig']) {
            return view('public.gig_detail', $data);
        }
        return Redirect::to(URL::previous());
    }

    function getFollowers($user_id) {
        $data['title'] = 'Musician | Followers';
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $user = User::find($user_id);
        if ($user) {
            $data['filter'] = 'followers';
            $data['user'] = $user;

            return view('public.followers', $data);
        }
        return Redirect::to(URL::previous());
    }

    function getFollowings($user_id) {
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['title'] = 'Musician | Followings';
        $user = User::find($user_id);
        if ($user) {
            $data['filter'] = 'followings';
            $data['user'] = $user;

            return view('public.followers', $data);
        }
        return Redirect::to(URL::previous());
    }

    function fetchFollowers(Request $request) {
        $filter = $request['filter'];
        $type = $request['user_type'];
        $user = User::find($request['user_id']);
        if ($user) {
            $ids = '';
            if ($filter == 'followers') {
                $ids = $user->getFollowersIds->toArray();
            } else if ($filter == 'followings') {
                $ids = $user->getFollowingsIds->toArray();
            }
            $query = User::whereIn('id', $ids)->where('type', $type);
            $result['data'] = $query
                    ->skip($request->skip)
                    ->take($request->take)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            $result['current_id'] = '';
            $result['current_user'] = '';
            $result['current_photo'] = '';
            $result['current_name'] = '';
            $following = UserFollower::select('user_id')->where('followed_by', $user->id)->get()->toArray();
            $result['followings'] = User::whereIn('id', $following)->get();
            if (Auth::user()) {
                $result['current_id'] = Auth::user()->id;
                $result['current_id'] = Auth::user()->id;
                $result['current_user'] = Auth::user();
                $result['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
                $result['current_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            }
            $response['html'] = view('public.loader.getmusician', $result)->render();
            return json_encode($response);
        }
    }

    function fetchFollowersProfile(Request $request) {
        $user_type_filter = $request['user_type_filter'];
        $follow_type_filter = $request['follow_type_filter'];
        $user = User::find($request['user_id']);
        if ($user) {
            $ids = '';
            if ($follow_type_filter == 'followers') {
                $ids = $user->getFollowersIds->toArray();
            } else if ($follow_type_filter == 'followings') {
                $ids = $user->getFollowingsIds->toArray();
            }
            $query = User::whereIn('id', $ids)->where('type', $user_type_filter);
            $result['data'] = $query
                    ->skip($request->skip)
                    ->take($request->take)
                    ->orderBy('created_at', 'DESC')
                    ->get();
            $result['current_id'] = '';
            $result['current_user'] = '';
            $result['current_photo'] = '';
            $result['current_name'] = '';
            $following = UserFollower::select('user_id')->where('followed_by', $user->id)->get()->toArray();
            $result['followings'] = User::whereIn('id', $following)->get();
            if (Auth::user()) {
                $result['current_id'] = Auth::user()->id;
                $result['current_user'] = Auth::user();
                $result['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
                $result['current_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            }
            $response['html'] = view('public.loader.getmusician', $result)->render();
            return json_encode($response);
        }
    }

    function profileAccompanists($user_id) {
        $data['title'] = 'Accompanists';
        $data['user'] = User::find($user_id);
        $data['user_id_current'] = $user_id;
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        return view('public.profile_accompanists', $data);
    }

    function fetchProfileAccompanists(Request $request) {
        if (Auth::user()) {
            $data['current_id'] = Auth::user()->id;
            $data['accompanists'] = Accompanist::where('admin_id', $request->user_id)
                    ->skip($request->skip)
                    ->take($request->take)
                    ->withCount('bookmarked')
                    ->get();
        } else {
            $data['current_id'] = '';
            $data['accompanists'] = Accompanist::where('admin_id', $request->user_id)
                    ->skip($request->skip)
                    ->take($request->take)
                    ->get();
        }
        return view('public.loader.accompanists_loader', $data);
    }

    function profileFollowers($user_id) {
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['title'] = 'Musician | Followings and Followers';
        $data['user'] = User::find($user_id);
        $data['records'] = GalleryMedia::where('user_id', $user_id)
                        ->orderBy('updated_at', 'desc')
                        ->take(6)
                        ->where('type', 'image')
                        ->get();

        return view('public.profile_followers', $data);
    }
    
    function allfriends($user_id) {
        $data['privacy'] = Privacysetting::where('user_id', $user_id)->first();
        $data['title'] = 'Musician | Followings and Followers';
        $data['user'] = User::where('id',$user_id)->with('requests','friends','checkFriend')->first();
        $following = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get()->toArray();
        $data['followings'] = User::whereIn('id', $following)->get();
        return view('public.friend_lists', $data);
    }
    
    function OfflineUser(Request $request) {
        User::where('id', $request->user_id)->update(['is_online' => 0]);
    }

    function searchMusicianAutocomplete() {
        $term = '';
        $search_type = '';
        if (isset($_GET['term'])) {
            $term = $_GET['term'];
        }
        if (isset($_GET['search_type'])) {
            $search_type = $_GET['search_type'];
        }
        if ($search_type == 'musicians') {
            return User::select('*', DB::raw('CONCAT(first_name, " ", last_name) AS name'))
                            ->where('type', 'artist')->where('is_active', 1)
                            ->when(Auth::user(), function ($q) {
                                $q->where('id', '!=', Auth::user()->id);
                            })
                            ->where(function($q) use ($term) {
                                $q->where('first_name', 'LIKE', '%' . $term . '%')
                                ->orWhere('last_name', 'LIKE', '%' . $term . '%')
                                ->orWhere(DB::raw('CONCAT(first_name, " ",last_name)'), 'LIKE', '%' . $term . '%')
                                ->orWhere(DB::raw('CONCAT(first_name, "",last_name)'), 'LIKE', '%' . $term . '%');
                            })
                            ->addSelect(DB::raw("'musicians' as search_type"))
                            ->get();
        } else if ($search_type == 'groups') {
            return Group::select('*', DB::raw("'groups' as search_type"))
                            ->where('name', 'LIKE', '%' . $term . '%')
                            ->when(Auth::user(), function ($q) {
                                $q->where('admin_id', '!=', Auth::user()->id);
                            })
                            ->get();
        } else if ($search_type == 'teaching_studios') {
            return TeachingStudio::select('*', DB::raw("'teaching_studios' as search_type"))
                            ->where('name', 'LIKE', '%' . $term . '%')
                            ->when(Auth::user(), function ($q) {
                                $q->where('admin_id', '!=', Auth::user()->id);
                            })
                            ->get();
        } else if ($search_type == 'accompanists') {
            return Accompanist::select('*', DB::raw("'accompanists' as search_type"))
                            ->where('name', 'LIKE', '%' . $term . '%')
                            ->when(Auth::user(), function ($q) {
                                $q->where('admin_id', '!=', Auth::user()->id);
                            })
                            ->get();
        }
    }

    function groupTimeLine($group_id) {
        $data['group'] = Group::where('id',$group_id)->with('members','approvedMembers','checkMember','groupImages')->first();
        if (Auth::user() && $data['group']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)->where('group_id', $group_id)->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 'g';
                $add_view->group_id = $group_id;
                $add_view->save();
            }
        }
        
        $data['user_id_current'] = $data['group']->admin_id;
        $data['title'] = 'Musician | Group Timeline';
        if ($data['group']) {
            $data['og_image'] = asset('userassets/images/Scrap-Image-Musician.png');
            if ($data['group']->cover) {
                if (exif_imagetype(asset('public/images/' . $data['group']->cover)) == IMAGETYPE_PNG) {
                    
                    $data['og_image'] = asset('public/images/' . $data['group']->cover);
                }
            }
            $data['og_title'] = $data['group']->name;
            $data['og_description'] = $data['group']->description;
            $data['suggestions'] = Group::whereNotIn('id', [$group_id])->inRandomOrder()->take(5)->get();
            $data['welcome_message'] = '';
            $data['post_count'] = Post::where('group_id', $group_id)->count();
            $data['post_images'] = Post::where('group_id', $group_id)->with('getFile')->get();
            return view('public.group_timeline', $data);
        }
    }

    function fetchPublicPosts(Request $request) {
        
        $post_type = $request->post_type;
        $post_type_col = $request->post_type_col;
        $post_type_col_id = $request->post_type_col_id;
        
       
        
        $data['current_photo'] = '';
        $data['current_id'] = '';
        $data['isAccompanistMember']= '';        
        $data['isAccompanistFollower']= '';
        $data['isGroupMember']= '';        
        $data['isGroupFollower']= '';
        $data['isStudioTeacher']= '';             
        $data['isStudioStudent']= '';        
        $data['isStudioFollower']= '';

        if (Auth::user()) {
            $data['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
            $data['current_id'] = Auth::user()->id;
            if(($post_type_col == 'accompanist_id') && ($post_type_col_id != ''))
            {
                $isAccompanistMember = AccompanistMember::where('user_id', $data['current_id'])
                                                           ->where('accompanist_id', $post_type_col_id)
                                                           ->where('is_approved',1)
                                                           ->first();
                $isAccompanistFollower = FollowServie::where('user_id', $data['current_id'])
                                                        ->where('post_type', '=', 'a')
                                                        ->where('accompanist_id', $post_type_col_id )
                                                        ->first();
                
                $data['isAccompanistMember']= $isAccompanistMember;        
                $data['isAccompanistFollower']= $isAccompanistFollower;
                
            }
            
            elseif(($post_type_col == 'group_id') && ($post_type_col_id != ''))
            {
                $isGroupMember = GroupMember::where('user_id', $data['current_id'])
                                                           ->where('group_id', $post_type_col_id)
                                                           ->where('is_approved',1)
                                                           ->first();
                $isGroupFollower = FollowServie::where('user_id', $data['current_id'])
                                                        ->where('post_type', '=', 'g')
                                                        ->where('group_id', $post_type_col_id )
                                                        ->first();
                
                
                $data['isGroupMember']= $isGroupMember;        
                $data['isGroupFollower']= $isGroupFollower;
                
                
            }
             elseif(($post_type_col == 'studio_id') && ($post_type_col_id != ''))
            {
                $isStudioTeacher = TeachingStudioMember::where('user_id', $data['current_id'])
                                                           ->where('teaching_studio_id', $post_type_col_id)
                                                           ->where('is_approved',1)
                                                           ->where('user_type', '=', 'teachere')
                                                           ->first();
                $isStuioStudent =TeachingStudioMember::where('user_id', $data['current_id'])
                                                           ->where('teaching_studio_id', $post_type_col_id)
                                                           ->where('is_approved',1)
                                                           ->where('user_type', '=', 'user')
                                                           ->first();
                
                $isStudioFollower  = FollowServie::where('user_id', $data['current_id'])
                                                        ->where('post_type', '=', 's')
                                                        ->where('studio_id', $post_type_col_id )
                                                        ->first();
//                dd($isStudioFollower);
                $data['isStudioTeacher']= $isStudioTeacher;        
                $data['isStudioStudent']= $isStuioStudent;                
                $data['isStudioFollower']= $isStudioFollower;

                
                
            }
            
            
            
        }
        $data['posts'] = Post::skip($request['skip'])
                ->with(['comments' => function($a) {
                        $a->orderBy('created_at', 'desc')
                        ->whereHas('user', function ($q) {
                                    $q->where('is_active', 1);
                                });
                    }])
//                ->with('checkFriendInGroup', 'checkGroupFollower')
                ->when($post_type, function ($q) use($post_type, $post_type_col_id, $post_type_col) {
                    $q->where('post_type', $post_type);
                    $q->where($post_type_col, $post_type_col_id);
                })
                ->whereHas('user', function ($q) {
                    $q->where('is_active', 1);
                })
                ->take($request['take'])->withCount('liked', 'bookmarked', 'comments')
                ->orderBy('created_at', 'Desc')->where('type', '!=', 'gig')
                ->get();
         
          if(($post_type_col == 'group_id'))
          {         
                    return view('user.loader.group_posts', $data);  
          }
          elseif(($post_type_col == 'accompanist_id'))
          {
                   
                    return view('user.loader.accompanist_posts', $data);  
          }
          elseif(($post_type_col == 'studio_id'))
          {
                   
                    return view('user.loader.studio_posts', $data);  
          }
//        return view('user.loader.posts', $data);
    }

    function groupReviews($group_id) {
        $data['group'] = Group::find($group_id);
        $data['user_id_current'] = $data['group']->admin_id;
        $data['title'] = 'Musician | Group Reviews';
        return view('public.group_reviews', $data);
    }

    function groupGallery($group_id) {
        $data['group'] = Group::where('id',$group_id)->with('groupImages')->first();
        $data['user_id_current'] = $data['group']->admin_id;
        $data['title'] = 'Musician | Group Gallery';
        return view('public.group_gallery', $data);
    }

    function getServicesFollowers($type, $type_id) {
        $data['type'] = $type;
        $data['type_id'] = $type_id;
        if ($type == 'g') {
            $data['column'] = 'group_id';
            $data['service'] = Group::find($type_id);
        }
        if ($type == 'a') {
            $data['column'] = 'accompanist_id';
            $data['service'] = Accompanist::find($type_id);
        }
        if ($type == 's') {
            $data['column'] = 'studio_id';
            $data['service'] = TeachingStudio::find($type_id);
        }
        $data['filter'] = 'followers';
        $data['title'] = 'Musician | Services Followings';
        return view('public.services_followers', $data);
    }

    function fetchServicesFollowers(Request $request) {
        $filter = $request['filter'];
        $type = $request['type'];
        $type_id = $request['type_id'];
        $ids = '';
        if ($type == 'g') {
            $ids = FollowServie::select('user_id')->where('group_id', $type_id)->get()->toArray();
        } else if ($type == 'a') {
            $ids = FollowServie::select('user_id')->where('accompanist_id', $type_id)->get()->toArray();
        } else if ($type == 's') {
            $ids = FollowServie::select('user_id')->where('studio', $type_id)->get()->toArray();
        }
        echo '';
        $query = User::whereIn('id', $ids)->where('type', $filter);
        $result['data'] = $query
                ->skip($request->skip)
                ->take($request->take)
                ->orderBy('created_at', 'DESC')
                ->get();
        $result['current_id'] = '';
        $result['current_user'] = '';
        $result['current_photo'] = '';
        $result['current_name'] = '';
        $result['followings'] = [];
        if (Auth::user()) {
            $result['current_id'] = Auth::user()->id;
            $result['current_id'] = Auth::user()->id;
            $result['current_user'] = Auth::user();
            $result['current_photo'] = getUserImage(Auth::user()->photo, Auth::user()->social_photo, Auth::user()->gender);
            $result['current_name'] = Auth::user()->first_name . ' ' . Auth::user()->last_name;
            $following = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get()->toArray();
            $result['followings'] = User::whereIn('id', $following)->get();
        }

        $response['html'] = view('public.loader.getmusician', $result)->render();
        return json_encode($response);
    }

    function populateCategoriesOnSearchPage(Request $request) {
       
        $type = $request->type;
        if ($type == 'musicians') {
            $type = 'musician';
        } else if ($type == 'groups') {
            $type = 'group';
        } else if ($type == 'teaching_studios') {
            $type = 'studio';
        } else if ($type == 'accompanists') {
            $type = 'accompanist';
        }
        $result['type'] = $type;
        $result['cat_id'] = isset($request->cat_id)? $request->cat_id: '';
        $response['html'] = view('includes.search_category_section_left_sidebar', $result)->render();
        return json_encode($response);
    }
    
    
    function getGroupMembersList($group_id){
        
        $data['group'] = Group::find($group_id);
        if (!$data['group']) {
            return Redirect::to(URL::previous());
        }
        if (Auth::user() && $data['group']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)->where('group_id', $group_id)->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 'g';
                $add_view->group_id = $group_id;
                $add_view->save();
            }
        }
        $data['user_id_current'] = $data['group']->admin_id;
        $data['og_image'] = asset('userassets/images/Scrap-Image-Musician.png');
        if ($data['group']->cover) {
            if (exif_imagetype(asset('public/images/' . $data['group']->cover)) == IMAGETYPE_PNG) {

                $data['og_image'] = asset('public/images/' . $data['group']->cover);
            }
        }
        
        $existed_ids = GroupMember::where('group_id',$group_id)->select('user_id')->get()->toArray();
//        echo"<pre>";print_r($existed_ids);exit;
        $data['friends'] = CollaborativeFriend::where('friend_id', Auth::user()->id)->whereNotIn('user_id',$existed_ids)->with('getFriendDetail')->get();
        $data['og_title'] = $data['group']->name;
        $data['og_description'] = $data['group']->description;
        $data['suggestions'] = Group::whereNotIn('id', [$group_id])->inRandomOrder()->take(5)->get();
        $data['welcome_message'] = '';
        $data['post_count'] = Post::where('group_id', $group_id)->count();
        $data['post_images'] = Post::where('group_id', $group_id)->with('getFile')->get();  
        
        $data['title'] = 'Musician | Group Members';
//        $data['artistTypes'] = Category::where('is_for_group', 1)->orderBy('title')->get();
        return view('public.group_members_list', $data);
    }
    
    function getTeacherMemberList($teaching_studio_id){
        $data['studio'] = TeachingStudio::where('id',$teaching_studio_id)->with('teachers','members','checkMember')->first();
        
        if (Auth::user() && $data['studio']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)
                    ->where('studio_id', $teaching_studio_id)
                    ->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 's';
                $add_view->studio_id = $teaching_studio_id;
                $add_view->save();
            }
        }
        $existed_ids = TeachingStudioMember::where('teaching_studio_id',$teaching_studio_id)->select('user_id')->get()->toArray();
        $data['friends'] = CollaborativeFriend::where('friend_id', Auth::user()->id)->whereNotIn('user_id',$existed_ids)->with('getFriendDetail')->get();
//        print_r($data['friends']); exit;
//        $data['friends'] = CollaborativeFriend::whereNotIn('friend_id', [$group_id])->inRandomOrder()->take(5)->get();
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        $data['post_count'] = Post::where('studio_id', $teaching_studio_id)->count();
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.teachers_list', $data);
        }
        return Redirect::to(URL::previous());
    }
    
    function getStudentMemberList($teaching_studio_id){
        $data['studio'] = TeachingStudio::where('id',$teaching_studio_id)->with('teachers','members','checkMember')->first();
        if (Auth::user() && $data['studio']->admin_id != Auth::user()->id) {
            $check_view = ServiceProfileView::where('user_id', Auth::user()->id)
                    ->where('studio_id', $teaching_studio_id)
                    ->first();
            if (!$check_view) {
                $add_view = new ServiceProfileView;
                $add_view->user_id = Auth::user()->id;
                $add_view->post_type = 's';
                $add_view->studio_id = $teaching_studio_id;
                $add_view->save();
            }
        }
        $existed_ids = TeachingStudioMember::where('teaching_studio_id',$teaching_studio_id)->select('user_id')->get()->toArray();
        $data['friends'] = CollaborativeFriend::where('friend_id', Auth::user()->id)->whereNotIn('user_id',$existed_ids)->with('getFriendDetail')->get();
        $data['user_id_current'] = $data['studio']->admin_id;
        $data['title'] = 'Musician | Teaching Studio Detail';
        $data['post_count'] = Post::where('studio_id', $teaching_studio_id)->count();
        if ($data['studio']) {
//            $data['suggestions'] = TeachingStudio::whereNotIn('id', [$teaching_studio_id])->inRandomOrder()->take(5)->get();
            return view('public.students_list', $data);
        }
        return Redirect::to(URL::previous());
    }
   
}
