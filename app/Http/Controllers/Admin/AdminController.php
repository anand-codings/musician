<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Stripe\Stripe;
use Carbon\Carbon;
use Stripe\Transfer;
use Stripe\Balance;
use Stripe\Charge;
use Stripe\Refund;
use App\Admin;
use App\User;
use App\Post;
use App\PostReport;
use App\Group;
use App\GroupReport;
use App\PostEvent;
use App\Union;
use App\Interest;
use App\Category;
use App\Booking;
use App\Unit;
use App\Review;
use App\TeachingStudio;
use App\Accompanist;
use App\VulgarTerm;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller {

    private $adminId;
    private $admin;

    function __construct() {
        $this->middleware(function ($request, $next) {
            $this->adminId = Auth::guard('admin')->user()->id;
            $this->admin = Auth::guard('admin')->user();
            return $next($request);
        });
    }

    function dashboard() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
        ];
        $total_bookings_data = [];
        $total_bookings_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::whereDate('created_at', $date)->count();
            array_push($total_bookings_data, $count);
            array_push($total_bookings_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['total_bookings_data'] = $total_bookings_data;
        $data['total_bookings_labels'] = $total_bookings_labels;

        $views_stats_data = [];
        $views_stats_percentage = [];
        $views_stats_labels = [];
        if (!isset($_GET['signup_stats_filter']) || (isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'daily')) {
            $date = date('Y-m-d', strtotime('-6 days', strtotime(date('Y-m-d'))));
            while (true) {
                if (strtotime($date) > strtotime(date('d-m-Y'))) {
                    break;
                }
                $count = User::whereDate('created_at', $date)->count();
                array_push($views_stats_data, $count);
                array_push($views_stats_labels, date('D', strtotime($date)));
                $array_length = sizeof($views_stats_data);
                if ($array_length > 1) {
                    $new = $views_stats_data[$array_length - 1];
                    $old = $views_stats_data[$array_length - 2];
                    if (!$old) {
                        $percentage = $new;
                    } else if (!$new) {
                        $percentage = -1 * $old;
                    } else {
                        $percentage = (($new - $old) / $old) * 100;
                    }
                    array_push($views_stats_percentage, $percentage);
                }
                $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            }
        } else if (isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'monthly') {
            $date = date('Y-m', strtotime('-6 months', strtotime(date('Y-m'))));
            while (true) {
                if (strtotime($date) > strtotime(date('Y-m'))) {
                    break;
                }
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $count = User::whereYear('created_at', $year)
                        ->whereMonth('created_at', $month)
                        ->count();
                array_push($views_stats_data, $count);
                array_push($views_stats_labels, date('M', strtotime($date)));
                $array_length = sizeof($views_stats_data);
                if ($array_length > 1) {
                    $new = $views_stats_data[$array_length - 1];
                    $old = $views_stats_data[$array_length - 2];
                    if (!$old) {
                        $percentage = $new;
                    } else if (!$new) {
                        $percentage = -1 * $old;
                    } else {
                        $percentage = (($new - $old) / $old) * 100;
                    }
                    array_push($views_stats_percentage, $percentage);
                }
                $date = date('Y-m', strtotime('+1 months', strtotime($date)));
            }
        } else if (isset($_GET['signup_stats_filter']) && $_GET['signup_stats_filter'] == 'yearly') {
            $date = date('Y-m', strtotime('-6 years', strtotime(date('Y-m'))));
            while (true) {
                if (strtotime($date) > strtotime(date('Y-m'))) {
                    break;
                }
                $year = date('Y', strtotime($date));
                $count = User::whereYear('created_at', $year)
                        ->count();
                array_push($views_stats_data, $count);
                array_push($views_stats_labels, date('Y', strtotime($date)));
                $array_length = sizeof($views_stats_data);
                if ($array_length > 1) {
                    $new = $views_stats_data[$array_length - 1];
                    $old = $views_stats_data[$array_length - 2];
                    if (!$old) {
                        $percentage = $new;
                    } else if (!$new) {
                        $percentage = -1 * $old;
                    } else {
                        $percentage = (($new - $old) / $old) * 100;
                    }
                    array_push($views_stats_percentage, $percentage);
                }
                $date = date('Y-m', strtotime('+1 years', strtotime($date)));
            }
        }
        $data['views_stats_labels'] = $views_stats_labels;
        $data['views_stats_data'] = $views_stats_data;
        $data['views_stats_percentage'] = $views_stats_percentage;

        $deactivation_stats_data = [];
        $deactivation_stats_labels = [];
        if (!isset($_GET['deactivation_stats_filter']) || (isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'daily')) {
            $date = date('Y-m-d', strtotime('-6 days', strtotime(date('Y-m-d'))));
            while (true) {
                if (strtotime($date) > strtotime(date('d-m-Y'))) {
                    break;
                }
                $count = User::where('is_active', 0)
                                ->whereDate('updated_at', $date)->count();
                array_push($deactivation_stats_data, $count);
                array_push($deactivation_stats_labels, date('D', strtotime($date)));
                $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
            }
        } else if (isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'monthly') {
            $date = date('Y-m', strtotime('-6 months', strtotime(date('Y-m'))));
            while (true) {
                if (strtotime($date) > strtotime(date('Y-m'))) {
                    break;
                }
                $year = date('Y', strtotime($date));
                $month = date('m', strtotime($date));
                $count = User::where('is_active', 0)
                        ->whereYear('updated_at', $year)
                        ->whereMonth('updated_at', $month)
                        ->count();
                array_push($deactivation_stats_data, $count);
                array_push($deactivation_stats_labels, date('M', strtotime($date)));
                $date = date('Y-m', strtotime('+1 months', strtotime($date)));
            }
        } else if (isset($_GET['deactivation_stats_filter']) && $_GET['deactivation_stats_filter'] == 'yearly') {
            $date = date('Y-m', strtotime('-6 years', strtotime(date('Y-m'))));
            while (true) {
                if (strtotime($date) > strtotime(date('Y-m'))) {
                    break;
                }
                $year = date('Y', strtotime($date));
                $count = User::where('is_active', 0)
                        ->whereYear('updated_at', $year)
                        ->count();
                array_push($deactivation_stats_data, $count);
                array_push($deactivation_stats_labels, date('Y', strtotime($date)));
                $date = date('Y-m', strtotime('+1 years', strtotime($date)));
            }
        }
        $data['deactivation_stats_labels'] = $deactivation_stats_labels;
        $data['deactivation_stats_data'] = $deactivation_stats_data;

        $data['title'] = 'Admin Dashboard';
        $data['usersCount'] = User::where('type', 'user')->count();
        $data['activeUsersCount'] = User::where('updated_at', '>=', Carbon::today()->subDays(7))->count();
        $data['nonActiveUsersCount'] = User::where('updated_at', '<', Carbon::today()->subDays(7))->count();
        $data['signedUpUsersCount'] = User::where('created_at', '>=', Carbon::today()->subDays(1))->count();
        $data['deactivatedUsersCount'] = User::where('is_active', 0)->count();
        $data['musiciansCount'] = User::where('type', 'artist')->count();
        $data['postsCount'] = Post::count();
        $data['eventsCount'] = PostEvent::count();
        $data['newUsers'] = User::orderByDesc('created_at')->take(8)->get();
        $data['newEvents'] = PostEvent::orderByDesc('created_at')->take(8)->get();
        $totalUsers = User::count();

        $returnedUsers = User::where('is_returned', 1)->count();
        $data['returned_users_percentage'] = round(($returnedUsers / $totalUsers) * 100);
        $data['new_users_percentage'] = 100 - $data['returned_users_percentage'];

        $onlineUsers = User::where('is_online', 1)->count();
        $data['online_users_percentage'] = ($onlineUsers / $totalUsers) * 100;

        $date = date('Y-m-d', strtotime('-6 days', strtotime(date('Y-m-d'))));
        $weeklyActiveUsers = User::where('updated_at', '>=', $date)->count();
        $data['weekly_active_users_percentage'] = ($weeklyActiveUsers / $totalUsers) * 100;

        return view('admin/dashboard', $data);
    }

    function users() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "users_admin", "name" => "Users"],
        ];
        $data['title'] = 'Users';
        $data['users'] = User::where('type', 'user')->get();
        $data['userType'] = 'user';
        return view('admin/users', $data);
    }

    function activeUsers() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "active_users_admin", "name" => "Active Users & Musicians"],
        ];
        $data['title'] = 'Active Users & Musicians';
        $data['users'] = User::where('updated_at', '>=', Carbon::today()->subDays(1))->get();
        if (isset($_GET['filter']) && $_GET['filter'] == 'daily') {
            $data['users'] = User::where('updated_at', '>=', Carbon::today()->subDays(1))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'weekly') {
            $data['users'] = User::where('updated_at', '>=', Carbon::today()->subDays(7))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'monthly') {
            $data['users'] = User::where('updated_at', '>=', Carbon::today()->subDays(30))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'yearly') {
            $data['users'] = User::where('updated_at', '>=', Carbon::today()->subDays(365))->get();
        }
        return view('admin/active_users', $data);
    }

    function downloadActiveUsersCsv() {
        $users = User::where('updated_at', '>=', Carbon::today()->subDays(1))->get();
        if (isset($_GET['filter']) && $_GET['filter'] == 'daily') {
            $users = User::where('updated_at', '>=', Carbon::today()->subDays(1))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'weekly') {
            $users = User::where('updated_at', '>=', Carbon::today()->subDays(7))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'monthly') {
            $users = User::where('updated_at', '>=', Carbon::today()->subDays(30))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'yearly') {
            $users = User::where('updated_at', '>=', Carbon::today()->subDays(365))->get();
        }
        $unique_name = time();
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=" . $unique_name . "_items.csv",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $columns = array('Item#', 'Name', 'Email', 'Address', 'Phone', 'Signup Date');
        $callback = function() use ($users, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            $count = 1;
            foreach ($users as $user) {
                $columns_data = array();
                $columns_data[] = $count;
                $columns_data[] = $user->first_name . ' ' . $user->last_name;
                $columns_data[] = $user->email;
                $columns_data[] = $user->address;
                $columns_data[] = '"' . $user->phone . '"';
                $columns_data[] = date('jS F Y', strtotime($user->created_at));
                $count++;
                fputcsv($file, $columns_data);
            }
            fclose($file);
        };
        return \Illuminate\Support\Facades\Response::stream($callback, 200, $headers);
    }

    function signUpUsers() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "singup_users_admin", "name" => "Signed Up Users"],
        ];
        $data['title'] = 'Signed Up Users';
        $data['users'] = User::where('created_at', '>=', Carbon::today()->subDays(1))->get();
        if (isset($_GET['filter']) && $_GET['filter'] == 'daily') {
            $data['users'] = User::where('created_at', '>=', Carbon::today()->subDays(1))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'weekly') {
            $data['users'] = User::where('created_at', '>=', Carbon::today()->subDays(7))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'monthly') {
            $data['users'] = User::where('created_at', '>=', Carbon::today()->subDays(30))->get();
        } else if (isset($_GET['filter']) && $_GET['filter'] == 'yearly') {
            $data['users'] = User::where('created_at', '>=', Carbon::today()->subDays(365))->get();
        }
        return view('admin/signed_up_users', $data);
    }

    function musicians() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "musicians_admin", "name" => "Musicians"],
        ];
        $data['title'] = 'Musicians';
        $data['users'] = User::where('type', 'artist')->get();
        $data['userType'] = 'artist';
        return view('admin/users', $data);
    }

    function userDetail($user_id) {
        $data['title'] = 'User Detail';
        $data['user'] = User::find($user_id);
        if (!$data['user']) {
            return Redirect::to(URL::previous());
        }
        $data['userType'] = $data['user']->type;

        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => ($data['userType'] == 'user' ? 'users_admin' : 'musicians_admin'), "name" => ($data['userType'] == 'user' ? 'Users' : 'Musicians')],
            ["href" => "user_detail_admin", "name" => "User Detail"],
        ];
        if (isset($_GET['segment'])) {
            if ($_GET['segment'] == 'admin_dashboard') {
                unset($data['breadCrumbs'][1]);
            } else if ($_GET['segment'] == 'events_admin') {
                $data['breadCrumbs'][1] = ["href" => "events_admin", "name" => "Events"];
            } else if ($_GET['segment'] == 'posts_admin') {
                $data['breadCrumbs'][1] = ["href" => "posts_admin", "name" => "Posts"];
            } else if ($_GET['segment'] == 'payments_admin') {
                $data['breadCrumbs'][1] = ["href" => "payments_admin", "name" => "Payments"];
            } else if ($_GET['segment'] == 'teaching_studios_admin') {
                $data['breadCrumbs'][1] = ["href" => "teaching_studios_admin", "name" => "Teaching Studios"];
            }
        }
        return view('admin/user_detail', $data);
    }

    function deleteUser(Request $request) {
        User::where('id', $request->user_id)->delete();
        return Response::json(['message' => 'User successfully deleted.'], 200);
    }

    function featureUser(Request $request) {
        $featured_users_count = User::where('is_featured_by_admin', 1)->count();
        $id = $request->id;
        $status = $request->status;
        $user = User::find($id);
        if ($status) {
            if ($featured_users_count >= 6) {
                $result = array('error' => 1, 'message' => 'Ony 3 users can be selected as suggested user at max.');
                echo json_encode($result);
                return;
            }
        }
        $user->is_featured_by_admin = $status;
        $user->save();
        if ($status == 1) {
            $message = 'User selected as featured user successfully.';
        } else {
            $message = 'User unselected as featured user successfully.';
        }
        $result = array('success' => 1, 'message' => $message);
        echo json_encode($result);
    }

    function categories() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "categories_admin", "name" => "Categories"],
        ];
        $data['title'] = 'Categories';
        $data['categories'] = Category::orderByDesc('updated_at')->get();
        return view('admin/categories', $data);
    }

    function addCategoryView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "add_category_admin", "name" => "Add Category"],
        ];
        $data['title'] = 'Add Category';
        return view('admin/add_category', $data);
    }

    function editCategoryView($id) {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "edit_category_admin/".$id, "name" => "Edit Category"],
        ];

        $data['category'] = Category::find($id);
        $data['title'] = 'Edit Category';
        return view('admin/edit_category', $data);
    }

    function editCategory(Request $request) {
        $request->validate([
            'title' => 'required',
            'category_id' => 'required',
        ]);
        $checkCategory = Category::where('title', $request['title'])->where('id', '!=', $request['category_id'])->first();
        if ($checkCategory) {
            Session::flash('error', 'Category with this title already exist.');
            return Redirect::to(URL::previous());
        }
        $category = Category::find($request['category_id']);
        $category->title = $request['title'];

        if (isset($request['is_enabled_for_musicians'])) {
            $category->is_for_musician = 1;
        } else {
            $category->is_for_musician = 0;
        }

        if (isset($request['is_enabled_for_groups'])) {
            $category->is_for_group = 1;
        } else {
            $category->is_for_group = 0;
        }

        if (isset($request['is_enabled_for_studios'])) {
            $category->is_for_studio = 1;
        } else {
            $category->is_for_studio = 0;
        }

        if (isset($request['is_enabled_for_accompanists'])) {
            $category->is_for_accompanist = 1;
        } else {
            $category->is_for_accompanist = 0;
        }

        if (isset($request['solo-ensemble']) && $request['solo-ensemble'] == 'solo') {
            $category->is_solo = 1;
        } else {
            $category->is_solo = 0;
        }

        if (isset($request['solo-ensemble']) && $request['solo-ensemble'] == 'ensemble') {
            $category->is_ensemble = 1;
        } else {
            $category->is_ensemble = 0;
        }

        $check = $request->hasFile('category_img');

        if( $check ) {
            $image = $request->file('category_img');
            $path = 'adminassets/images';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $category->image = $filename;
        }

        $category->save();
        Session::flash('success', 'Category updated successfully.');
        return redirect('categories_admin');
    }

    function addCategory(Request $request) {
        $request->validate([
            'title' => 'required',
            'category_img' => 'required',
        ]);
        $checkCategory = Category::where('title', $request['title'])->first();
        if ($checkCategory) {
            Session::flash('error', 'Category with this title already exist.');
            return Redirect::to(URL::previous());
        }
        $category = new Category();
        $category->title = $request['title'];

        if (isset($request['is_enabled_for_musicians'])) {
            $category->is_for_musician = 1;
        }

        if (isset($request['is_enabled_for_groups'])) {
            $category->is_for_group = 1;
        }

        if (isset($request['is_enabled_for_studios'])) {
            $category->is_for_studio = 1;
        }

        if (isset($request['is_enabled_for_accompanists'])) {
            $category->is_for_accompanist = 1;
        }

        if (isset($request['solo-ensemble']) && $request['solo-ensemble'] == 'solo') {
            $category->is_solo = 1;
        }

        if (isset($request['solo-ensemble']) && $request['solo-ensemble'] == 'ensemble') {
            $category->is_ensemble = 1;
        }

        $check = $request->hasFile('category_img');

        if( $check ) {
            $image = $request->file('category_img');
            $path = 'adminassets/images';
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->move($path, $filename);
            $category->image = $filename;
        }

        $category->save();
        Session::flash('success', 'Category added successfully.');
        return redirect('categories_admin');
    }

    function deleteCategory(Request $request) {
        Category::where('id', $request->category_id)->delete();
        return Response::json(['message' => 'Category successfully deleted.'], 200);
    }

    function actionOnCategory(Request $request) {
        $category = Category::find($request['category_id']);
        if ($request['action_on'] == 'is_for_musician') {
            if (!$request['is_enabled']) {
                $check = \App\SelectedMusicianCategory::where('category_id', $request['category_id'])->first();
                if ($check) {
                    return Response::json(['error' => 'You cannot deselect this category as it is already used by musicians.'], 200);
                }
            }
            $category->is_for_musician = $request['is_enabled'];
        } else if ($request['action_on'] == 'is_for_studio') {
            if (!$request['is_enabled']) {
                $check = \App\SelectedTeachingStudioCategory::where('category_id', $request['category_id'])->first();
                if ($check) {
                    return Response::json(['error' => 'You cannot deselect this category as it is already used by teaching studios.'], 200);
                }
            }
            $category->is_for_studio = $request['is_enabled'];
        } else if ($request['action_on'] == 'is_for_accompanist') {
            if (!$request['is_enabled']) {
                $check = \App\SelectedTeachingStudioCategory::where('category_id', $request['category_id'])->first();
                if ($check) {
                    return Response::json(['error' => 'You cannot deselect this category as it is already used by accompanists.'], 200);
                }
            }
            $category->is_for_accompanist = $request['is_enabled'];
        } else if ($request['action_on'] == 'is_for_group') {
            if (!$request['is_enabled']) {
                $check = \App\Group::where('category_id', $request['category_id'])->first();
                if ($check) {
                    return Response::json(['error' => 'You cannot deselect this category as it is already used by event services.'], 200);
                }
            }
            $category->is_for_group = $request['is_enabled'];
            if ($request['is_enabled']) {
                $category->is_solo = 1;
                $category->is_ensemble = 0;
            } else {
                $category->is_solo = 0;
                $category->is_ensemble = 0;
            }
        } else if ($request['action_on'] == 'is_solo') {
            if ($request['is_enabled']) {
                $category->is_solo = $request['is_enabled'];
                $category->is_ensemble = 0;
            } else {
                $category->is_solo = 0;
                $category->is_ensemble = 1;
            }
        } else if ($request['action_on'] == 'is_ensemble') {
            if ($request['is_enabled']) {
                $category->is_ensemble = $request['is_enabled'];
                $category->is_solo = 0;
            } else {
                $category->is_ensemble = 0;
                $category->is_solo = 1;
            }
        }
        $category->save();
        return Response::json(['message' => 'success.'], 200);
    }

    function studioCategories() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "studio_categories_admin", "name" => "Studio Categories"],
        ];
        $data['title'] = 'Studio Categories';
        $data['categories'] = Category::where('is_solo', 1)->orderBy('title')->get();
        return view('admin/studio_categories', $data);
    }

    function events() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "events_admin", "name" => "Events"],
        ];
        $data['title'] = 'Events';
        $data['events'] = PostEvent::all();
        return view('admin/events', $data);
    }

    function eventDetail($event_id) {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "events_admin", "name" => "Events"],
            ["href" => "event_detail_admin", "name" => "Event Detail"],
        ];
        if (isset($_GET['segment'])) {
            if ($_GET['segment'] == 'admin_dashboard') {
                unset($data['breadCrumbs'][1]);
            } else if ($_GET['segment'] == 'payments_admin') {
                $data['breadCrumbs'][1] = ["href" => "payments_admin", "name" => "Payments"];
            }
        }
        $data['title'] = 'Event Detail';
        $data['event'] = PostEvent::find($event_id);
        if (!$data['event']) {
            return Redirect::to(URL::previous());
        }
        return view('admin/event_detail', $data);
    }

    function accompanists() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "accompanists_admin", "name" => "Accompanists"],
        ];
        $data['title'] = 'Accompanists';
        $data['accompanists'] = Accompanist::orderBy('updated_at', 'desc')->get();
        return view('admin/accompanists', $data);
    }

    function teachingStudios() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "teaching_studios_admin", "name" => "Teaching Studios"],
        ];
        $data['title'] = 'Teaching Studios';
        $data['studios'] = \App\TeachingStudio::orderBy('updated_at', 'desc')->get();
        return view('admin/teaching_studios', $data);
    }

    function deleteTeachingStudio(Request $request) {
        \App\TeachingStudio::where('id', $request->studio_id)->delete();
        return Response::json(['message' => 'Teaching studio successfully deleted.'], 200);
    }

    function deleteAccompanist(Request $request) {
        Accompanist::where('id', $request->accompanist_id)->delete();
        return Response::json(['message' => 'Accompanist successfully deleted.'], 200);
    }

//    function TeachingStudioDetail($studio_id) {
//        $data['breadCrumbs'] = [
//            ["href" => "admin_dashboard", "name" => "Dashboard"],
//            ["href" => "teaching_studios_admin", "name" => "Teaching Studios"],
//            ["href" => "teaching_studio_detail_admin", "name" => "Teaching Studio Detail"],
//        ];
//
//        $data['title'] = 'Teaching Studio Detail';
//        $data['studio'] = \App\TeachingStudio::find($studio_id);
//        if (!$data['studio']) {
//            return Redirect::to(URL::previous());
//        }
//        return view('admin/teaching_studio_detail', $data);
//    }

    function posts() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "posts_admin", "name" => "Posts"],
        ];
        $data['title'] = 'Posts';
        $data['posts'] = Post::where('type', '!=', 'gig')->get();
        return view('admin/posts', $data);
    }

    function reportedPosts() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "reported_posts", "name" => "Reported Posts"],
        ];
        $data['users'] = User::orderBy('first_name', 'asc')->get();
        $data['title'] = 'Reported Posts';
        $data['reported_posts'] = PostReport::all();
        return view('admin/reported_posts', $data);
    }

    function deletePost(Request $request) {
        deleteNotification('post', $request->post_id);
        Post::where('id', $request->post_id)->delete();
        return Response::json(['message' => 'Post successfully deleted.'], 200);
    }

    function deleteReport(Request $request) {
        PostReport::where('id', $request->report_id)->delete();
        return Response::json(['message' => 'Report discarded successfully .'], 200);
    }

    function groups() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "groups_admin", "name" => "Groups"],
        ];
        $data['title'] = 'Groups';
        $data['groups'] = Group::all();
        return view('admin/groups', $data);
    }

    function groupDetail($group_id) {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "groups_admin", "name" => "Groups"],
            ["href" => "group_detail_admin", "name" => "Group Detail"],
        ];
        if (isset($_GET['segment'])) {
            if ($_GET['segment'] == 'admin_dashboard') {
                unset($data['breadCrumbs'][1]);
            } else if ($_GET['segment'] == 'payments_admin') {
                $data['breadCrumbs'][1] = ["href" => "payments_admin", "name" => "Payments"];
            }
        }
        $data['title'] = 'Group Detail';
        $data['group'] = Group::find($group_id);
        if (!$data['group']) {
            return Redirect::to(URL::previous());
        }
        return view('admin/group_detail', $data);
    }

    function reportedGroups() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "reported_groups", "name" => "Reported Groups"],
        ];
        $data['title'] = 'Reported Groups';
        $data['reported_groups'] = GroupReport::all();
        return view('admin/reported_groups', $data);
    }

    function deleteGroup(Request $request) {
        Group::where('id', $request->group_id)->delete();
        return Response::json(['message' => 'Group successfully deleted.'], 200);
    }

    function deleteReportGroup(Request $request) {
        GroupReport::where('id', $request->report_id)->delete();
        return Response::json(['message' => 'Report discarded successfully .'], 200);
    }

    function unions() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "unions_admin", "name" => "Unions"],
        ];
        $data['title'] = 'Unions';
        $data['unions'] = Union::all();
        return view('admin/unions', $data);
    }

    function addUnionView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "add_union_admin", "name" => "Add Union"],
        ];
        $data['title'] = 'Add Union';
        return view('admin/add_union', $data);
    }

    function addUnion(Request $request) {
        $request->validate([
            'title' => 'required',
        ]);
        $checkUnion = Union::where('title', $request['title'])->first();
        if ($checkUnion) {
            Session::flash('error', 'Union with this title already exist.');
            return Redirect::to(URL::previous());
        }
        $union = new Union();
        $union->title = $request['title'];
        $union->save();
        Session::flash('success', 'Union added successfully.');
        return redirect('unions_admin');
    }

    function deleteUnion(Request $request) {
        Union::where('id', $request->union_id)->delete();
        return Response::json(['message' => 'Union successfully deleted.'], 200);
    }

    function interests() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "interest_admin", "name" => "Interests"],
        ];
        $data['title'] = 'Interests';
        $data['interests'] = Interest::all();
        return view('admin/interests', $data);
    }

    function addInterestView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "add_interest_admin", "name" => "Add Interests"],
        ];
        $data['title'] = 'Add Interest';
        return view('admin/add_interest', $data);
    }

    function addInterest(Request $request) {
        $request->validate([
            'interest' => 'required',
        ]);
        $checkInterest = Interest::where('interest', $request['interest'])->first();
        if ($checkInterest) {
            Session::flash('error', 'Interest with this title already exist.');
            return Redirect::to(URL::previous());
        }
        $interest = new Interest();
        $interest->interest = $request['interest'];
        $interest->save();
        Session::flash('success', 'Interest added successfully.');
        return redirect('interest_admin');
    }

    function deleteInterest(Request $request) {
        Interest::where('id', $request->interest_id)->delete();
        return Response::json(['message' => 'Interest successfully deleted.'], 200);
    }

    function units() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "units_admin", "name" => "Interests"],
        ];
        $data['title'] = 'Units';
        $data['units'] = Unit::all();
        return view('admin/units', $data);
    }

    function addUnitView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "add_unit_admin", "name" => "Add Unit"],
        ];
        $data['title'] = 'Add Unit';
        return view('admin/add_unit', $data);
    }

    function addUnit(Request $request) {
        $request->validate([
            'title' => 'required',
        ]);
        $checkUnit = Unit::where('title', $request['title'])->first();
        if ($checkUnit) {
            Session::flash('error', 'Unit with this title already exist.');
            return Redirect::to(URL::previous());
        }
        $unit = new Unit();
        $unit->title = $request['title'];
        $unit->save();
        Session::flash('success', 'Unit added successfully.');
        return redirect('units_admin');
    }

    function deleteUnit(Request $request) {
        Unit::where('id', $request->unit_id)->delete();
        return Response::json(['message' => 'Unit successfully deleted.'], 200);
    }

    function changePasswordView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "change_password_admin", "name" => "Change Password"],
        ];
        $data['title'] = 'Change Password';
        return view('admin/change_password', $data);
    }

    function changePassword(Request $request) {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $password = $this->admin->password;
        if (Hash::check($request['current_password'], $password)) {
            $newpass = Hash::make($request['password']);
            Admin::where('id', $this->adminId)->update(['password' => $newpass]);
            User::where('email', $this->admin->email)->update(['password' => $newpass]);
            Session::flash('success', 'Password Updated successfully');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Invalid Old Password');
            return Redirect::to(URL::previous());
        }
    }

    function payments() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "payments_admin", "name" => "Booking & Payments"],
        ];
        $data['title'] = 'Payments';
        $data['bookings'] = Booking::all();
        return view('admin/payments', $data);
    }

    function reviews() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "reviews_admin", "name" => "Reviews"],
        ];
        $data['title'] = 'Reviews';
        $data['reviews'] = Review::all();
        return view('admin/reviews', $data);
    }

    function vulgarTerms() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "vulgar_terms_admin", "name" => "Vulgar Terms"],
        ];
        $data['title'] = 'Vulgar Terms';
        $data['vulgar_terms'] = VulgarTerm::all();
        return view('admin/vulgar_terms', $data);
    }

    function addVulgarTermView() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "add_vulgar_terms_admin", "name" => "Add Vulgar Term"],
        ];
        $data['title'] = 'Add Vulgar Term';
        return view('admin/add_vulgar_term', $data);
    }

    function addVulgarTerm(Request $request) {
        $request->validate([
            'term' => 'required',
        ]);
        $check = VulgarTerm::where('term', $request['term'])->first();
        if ($check) {
            Session::flash('error', 'Term already exist.');
            return Redirect::to(URL::previous());
        }
        $vulgarTerm = new VulgarTerm();
        $vulgarTerm->term = $request['term'];
        $vulgarTerm->save();
        Session::flash('success', 'Vulgar term added successfully.');
        return redirect('vulgar_terms_admin');
    }

    function deleteVulgarTerm(Request $request) {
        VulgarTerm::where('id', $request->id)->delete();
        return Response::json(['message' => 'Vulgar term successfully deleted.'], 200);
    }

    function paymentAction(Request $request) {
        
        $booking = Booking::find($request['booking_id']);
        if ($booking) {
            Stripe::setApiKey(env('STRIPE_SECRET'));
            if ($request['action'] == 'release') {
                try {
                    $balance = Balance::retrieve();
                    $balanceAmount = $balance->available[0]->amount;
                    if ($balanceAmount > 0) {
                        $balanceAmount = number_format(( ($balanceAmount) / 100), 2, '.', '');

                        $refund_amount = 0;
                        $total_amount = $booking->price + $booking->tip_amount;
                        if ($booking->is_refunding) {
                            $refund_amount = ($total_amount * $booking->partial_refund_requested_percentage) / 100;
                            $total_amount = $total_amount - $refund_amount;
                            if ($refund_amount) {
                                Refund::create(array("charge" => $booking->stripe_charge_id, "amount" => $refund_amount * 100));
                            }
                        }
                        if ($balanceAmount >= $total_amount) {
                            
                            $app_deduction_percentage = 14;
                            if($booking->gig_type == 'teaching_studio'){
                               $app_deduction_percentage = 8;
                            }
                            
                            $stripeFee = ((($total_amount * 2.9) / 100) + 0.3) * 100;
                            
                            $amountToTransfer = $total_amount - $stripeFee;
                            
                            
                            $musicianCharges = ($amountToTransfer * $app_deduction_percentage)/100;
                            
                            $amountToTransfer = $amountToTransfer - $musicianCharges;
                            
                            $account = $booking->artist->stripe_payout_account_id;
                            
                            Transfer::create(array(
                                "amount" => round($amountToTransfer * 100),
                                "currency" => "usd",
                                "destination" => $account
                            ));
                            $booking->status = 'payment_delivered';
                            $booking->save();

                            $user = User::find($booking->booked_by);
                            
                            $viewData['totalAmount'] = $total_amount;
                            $viewData['stripeFee'] = $stripeFee;
                            $viewData['amountToTransfer'] = $amountToTransfer;
                            $viewData['tip'] = $booking->tip_amount;
                            $viewData['refundAmount'] = $refund_amount;
                            Mail::send('emails.receipt', $viewData, function ($m) use ($user) {
                                $m->from(env('FROM_EMAIL'), 'Musician App');
                                $m->to($user->email, $user->first_name)->subject('Receipt');
                            });

                            Session::flash('success', 'The payment is released.');
                            $notificationForRequester = addNotificationFromAdminThenGet($booking->booked_by, 'Admin releasing payment', 'Admin approved the booking payment', 'booking', 'Booking', $booking->id, 'admin_refunded_payment_for_booking' . $booking->id);
                            $notificationForResponder = addNotificationFromAdminThenGet($booking->user_id, 'Admin releasing payment', 'Admin released your booking payment', 'booking', 'Booking', $booking->id, 'admin_rejected_payment_for_booking' . $booking->id);
                            return response()->json(array('success' => 'Booking Has Been Approved', 'notification_for_requester' => $notificationForRequester, 'notification_for_responder' => $notificationForResponder));
                        } else {
                            Session::flash('error', 'Your don\'t have enough balance.');
                            return Response::json('', 200);
                        }
                    } else {
                        Session::flash('error', 'Your balance is zero.');
                        return Response::json('', 200);
                    }
                } catch (\Stripe\Error\Base $e) {
                    Session::flash('error', $e->getMessage());
                    return Response::json('', 200);
                } catch (Exception $e) {
                    Session::flash('error', $e->getMessage());
                    return Response::json('', 200);
                }
            } else if ($request['action'] == 'reject') {
                try {
                    Refund::create(array("charge" => $booking->stripe_charge_id));
                    $booking->status = 'admin_rejected';
                    $booking->save();
                    Session::flash('success', 'The payment is rejected.');
                    $notificationForRequester = addNotificationFromAdminThenGet($booking->booked_by, 'Admin rejecting payment', 'Admin refunded your booking payment', 'booking', 'Booking', $booking->id, 'admin_refunded_payment_for_booking' . $booking->id);
                    $notificationForResponder = addNotificationFromAdminThenGet($booking->user_id, 'Admin rejecting payment', 'Admin rejected your booking payment', 'booking', 'Booking', $booking->id, 'admin_rejected_payment_for_booking' . $booking->id);
                    return response()->json(array('success' => 'Booking Has Been Approved', 'notification_for_requester' => $notificationForRequester, 'notification_for_responder' => $notificationForResponder));
                } catch (\Stripe\Error\Base $e) {
                    Session::flash('error', $e->getMessage());
                    return Response::json('', 200);
                } catch (Exception $e) {
                    Session::flash('error', $e->getMessage());
                    return Response::json('', 200);
                }
            } else if ($request['action'] == 'request_more_dispute_evidence') {
                $booking->dispute_start_time_utc = date('Y-m-d h:i:s', time());
                $booking->is_user_submitted_evidence = 0;
                $booking->is_musician_submitted_evidence = 0;
                $booking->save();
            }
        } else {
            Session::flash('error', 'Booking not found.');
            return Response::json('', 200);
        }
    }

    function logout() {
        Auth::guard('admin')->logout();
        return redirect('admin_login');
    }

    public function jumpToAccount($user_id) {
        $user = User::find($user_id);
        Auth::login($user);
        return Redirect::to('/');
    }

    function stats() {
        
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "admin_stats", "name" => "Statistics"],
        ];
        $data['title'] = 'Admin | Statistics';
        $data['users'] = User::all();
        $data['groups'] = Group::all();
        $data['studios'] = TeachingStudio::all();
        $data['accompinsts'] = Accompanist::all();
        $data['bookings'] = Booking::where('status', 'payment_approved')->get();
        $views_stats_data = [];
        $views_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
          
            $count = User::whereDate('created_at', $date)->count();
        
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
            $count = Group::whereDate('created_at', $date)->count();
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
            $count = TeachingStudio::whereDate('created_at', $date)->count();
            

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
            $count = Accompanist::whereDate('created_at', $date)->count();
            array_push($reviews_stats_data, $count);
            array_push($reviews_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['reviews_stats_data'] = $reviews_stats_data;
        $data['reviews_stats_labels'] = $reviews_stats_labels;
//        print_r($data['gigs_stats_data']);exit;
        return view('admin/statistics', $data);
    }

    function bookingStats() {
        $data['breadCrumbs'] = [
            ["href" => "admin_dashboard", "name" => "Dashboard"],
            ["href" => "admin_stats", "name" => "Booking Statistics"],
        ];
        $data['title'] = 'Admin | Booking Statistics';
        $data['total_bookings'] = Booking::get();
        $data['approved_bookings'] = Booking::where('status', 'payment_delivered')->get();
        $data['rejected_bookings'] = Booking::where('status', 'admin_rejected')->get();
        $data['pending_bookings'] = Booking::whereIn('status', ['pending', 'approved', 'postponed', 'postponed_updated', 'payment_requested', 'payment_approved', 'admin_requested'])->get();

        $total_bookings_data = [];
        $total_bookings_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::whereDate('created_at', $date)->count();
            array_push($total_bookings_data, $count);
            array_push($total_bookings_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['total_bookings_data'] = $total_bookings_data;
        $data['total_bookings_labels'] = $total_bookings_labels;

        $approved_bookings_data = [];
        $approved_bookings_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::where('status', 'payment_delivered')
                    ->whereDate('created_at', $date)
                    ->count();
            array_push($approved_bookings_data, $count);
            array_push($approved_bookings_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['approved_bookings_data'] = $approved_bookings_data;
        $data['approved_bookings_labels'] = $approved_bookings_labels;

        $rejected_bookings_data = [];
        $rejected_bookings_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::where('status', 'admin_rejected')
                    ->whereDate('created_at', $date)
                    ->count();
            array_push($rejected_bookings_data, $count);
            array_push($rejected_bookings_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['rejected_bookings_data'] = $rejected_bookings_data;
        $data['rejected_bookings_labels'] = $rejected_bookings_labels;

        $pending_bookings_data = [];
        $pending_bookings_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = Booking::whereIn('status', ['pending', 'approved', 'postponed', 'postponed_updated', 'payment_requested', 'payment_approved', 'admin_requested'])
                    ->whereDate('created_at', $date)
                    ->count();
            array_push($pending_bookings_data, $count);
            array_push($pending_bookings_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['pending_bookings_data'] = $pending_bookings_data;
        $data['pending_bookings_labels'] = $pending_bookings_labels;

        return view('admin/bookings_statistics', $data);
    }

    function sendMessageAll(Request $request) {
        if ($request->send_to_all == "true") {
            $users = User::all();
        } else if ($request->send_to_all == "false") {
            $users = User::whereIn('id', $request->users)->get();
        }
        $viewData['text_message'] = $request->text_message;
        foreach ($users as $user) {
            $viewData['name'] = $user->first_name . ' ' . $user->last_name;
            Mail::send('emails.mail_from_admin', $viewData, function ($m) use ($user) {
                $m->from(env('FROM_EMAIL'), 'Musician App');
                $m->to($user->email, $user->first_name)->subject('Email From Admin');
            });
        }
    }

    function reportedPostMail(Request $request) {
        $user_id = $request->user_id;
        $message = $request->message;
        $user = User::find($user_id);
        $viewData['name'] = $user->first_name . ' ' . $user->last_name;
        $viewData['text_message'] = $message;
        Mail::send('emails.mail_from_admin', $viewData, function ($m) use ($user) {
            $m->from(env('FROM_EMAIL'), 'Musician App');
            $m->to($user->email, $user->first_name)->subject('Email From Admin');
        });
    }

}
