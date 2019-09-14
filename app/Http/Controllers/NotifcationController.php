<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Illuminate\Support\Facades\Auth;

class NotifcationController extends Controller {

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

    function readNotifications() {
        Notification::where('on_user', $this->userId)->update(['is_read' => 1]);
    }

    function getNotifications() {
        $data['title'] = 'Musician | All Notification';
        return view('user.allnotification', $data);
    }

    function fetchNotifications() {
        $data['notifications'] = notifications($_GET['take'], $_GET['skip']);
        return view('user.loader.notifications', $data);
    }
 
}
