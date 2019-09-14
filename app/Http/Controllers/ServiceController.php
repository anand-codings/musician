<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Group;
use App\Category;
use App\Union;
use App\Language;

class ServiceController extends Controller {

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

    function services() {
        $data['title'] = 'Musician | Services';
        return view('user.all_services', $data);
    }

    function fetchServices(Request $request) {
        if ($request['type'] == 'groups') {
            $response['html'] = view('user.all_services_groups')->render();
        } else if ($request['type'] == 'teaching_studios') {
            $response['html'] = view('user.all_services_teaching_studios')->render();
        } else if ($request['type'] == 'accompanists') {
            $response['html'] = view('user.all_services_accompanists')->render();
        }
        return response()->json($response);
    }

    function createServiceView() {
        $data['title'] = 'Musician | Create Service';
        return view('user.create_service', $data);
    }

    function fetchServiceSection(Request $request) {
        $current_id = Auth::user()->id;
        $current_user = Auth::user();
        $current_photo = getUserImage($current_user->photo, $current_user->social_photo, $current_user->gender);
        $data['current_id'] = $current_id;
        $data['current_user'] = $current_user;
        $data['current_photo'] = $current_photo;
        if ($request['type'] == 'groups') {
            $data['categories'] = Category::where('is_for_group', 1)->orderBy('title')->get();
            $response['html'] = view('user.create_service_group_section', $data)->render();
        } else if ($request['type'] == 'teaching_studios') {
            $data['artistTypes'] = Category::where('is_for_studio', 1)->orderBy('title')->get();
            $data['unions'] = Union::orderBy('title', 'asc')->get();
            $data['languages'] = Language::orderBy('name', 'asc')->get();
            $response['html'] = view('user.create_service_teaching_studio_section', $data)->render();
        } else if ($request['type'] == 'accompanists') {
            $data['artistTypes'] = Category::where('is_for_accompanist', 1)->orderBy('title')->get();
            $data['languages'] = Language::orderBy('name', 'asc')->get();
            $response['html'] = view('user.create_service_accompanist_section', $data)->render();
        }
        return response()->json($response);
    }

}
