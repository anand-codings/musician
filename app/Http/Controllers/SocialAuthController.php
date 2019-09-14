<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use \Socialite;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;

class SocialAuthController extends Controller {

    public function redirect() {
        if (Auth::guard('user')->check()) {
            return redirect('timeline');
        }
        return Socialite::driver('facebook')->redirect();
    }

    public function callback() {
        $providerUser = Socialite::driver('facebook')->user();
        $check_fb_id = User::where(array('fb_id' => $providerUser->id))->first();
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        if ($check_fb_id) {
            $auth = auth()->guard('user');
            $auth->login($check_fb_id);

            if ($location) {
                $check_fb_id->lat = $location->latitude;
                $check_fb_id->lng = $location->longitude;
                $check_fb_id->country = $location->country_name;
                $check_fb_id->city = $location->city;
                $check_fb_id->zip_code = $location->zip;
            }
            $check_fb_id->social_photo = $providerUser->avatar;
            $check_fb_id->save();
            return Redirect::to(URL::previous());
        }


        $check_other = User::where(array('email' => $providerUser->email))->first();
        if ($check_other) {
            $check_other->fb_id = $providerUser->id;
            $check_other->social_photo = $providerUser->avatar;

            $auth = auth()->guard('user');
            $auth->login($check_other);
//            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
            if ($location) {
                $check_other->lat = $location->latitude;
                $check_other->lng = $location->longitude;
                $check_other->country = $location->country_name;
                $check_other->city = $location->city;
                $check_other->zip_code = $location->zip;
            }
            $check_other->save();
        } else {
            $user = new User;
            $email = $providerUser->email;
            if (!$providerUser->email) {
                $email = $providerUser->id . '@musician.com';
            }
            $name= explode(' ', $providerUser->name);
                $first_name='';
                $last_name='';
                if(isset($name[0])){
                    $first_name=$name[0];
                }
                 if(isset($name[1])){
                   $last_name =$name[1];
                }
            $user->email = $email;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->password = '';
            $user->fb_id = $providerUser->id;
            $user->social_photo = $providerUser->avatar;
            $user->type = 'user';
            $user->last_login = Carbon::now();
            if ($location) {
                $user->lat = $location->latitude;
                $user->lng = $location->longitude;
                $user->country = $location->country_name;
                $user->city = $location->city;
                $user->zip_code = $location->zip;
            }
            $user->save();
            $viewData['name'] = $providerUser->name;
            Mail::send('emails.register', $viewData, function ($m) use ($user) {
                $m->from(env('FROM_EMAIL'), 'Musician App');
                $m->to($user->email, $user->first_name)->subject('Confirmation Email');
            });
            $auth = auth()->guard('user');
            $auth->login($user);
            return redirect('/');
        }
    }

    public function redirectToProvider() {
        if (Auth::guard('user')->check()) {
            return redirect('timeline');
        }
        return Socialite::with('google')->redirect();
    }

    /**
     * Obtain the user information from Twitter.
     *
     * @return Response
     */
    public function handleProviderCallback() {
       if (Auth::guard('user')->check()) {
            return redirect('timeline');
        }
        $google_user = Socialite::driver('google')->user();
        
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        if ($google_user->email) {
            $check_g_id = User::where(array('google_id' => $google_user->id))->first();
            if ($check_g_id) {
                $auth = auth()->guard('user');
                $auth->login($check_g_id);
                if ($location) {
                    $check_g_id->lat = $location->latitude;
                    $check_g_id->lng = $location->longitude;
                    $check_g_id->country = $location->country_name;
                    $check_g_id->city = $location->city;
                    $check_g_id->zip_code = $location->zip;
                }
                $check_g_id->social_photo = $google_user->avatar;
                $check_g_id->save();
                return Redirect::to('timeline');
            }

            $check_other = User::where(array('email' => $google_user->email))->first();
            if ($check_other) {
                $check_other->google_id = $google_user->id;
                $auth = auth()->guard('user');
                $auth->login($check_other);
                if ($location) {
                    $check_other->lat = $location->latitude;
                    $check_other->lng = $location->longitude;
                    $check_other->country = $location->country_name;
                    $check_other->city = $location->city;
                    $check_other->zip_code = $location->zip;
                }
                $check_other->save();
                return Redirect::to('timeline');
            } else {
                $user = new User;
                $email = $google_user->email;
                if (!$google_user->email) {
                    $email = $google_user->id . '@musician.com';
                }
                $name= explode(' ', $google_user->name);
                $first_name='';
                $last_name='';
                if(isset($name[0])){
                    $first_name=$name[0];
                }
                 if(isset($name[1])){
                   $last_name =$name[1];
                }
                $user->email = $email;
                $user->first_name = $first_name;
                $user->last_name = $last_name;
                $user->password = '';
                $user->google_id = $google_user->id;
                $user->social_photo = $google_user->avatar;
                $user->type = 'user';
                $user->last_login = Carbon::now();
                if ($location) {
                    $user->lat = $location->latitude;
                    $user->lng = $location->longitude;
                    $user->country = $location->country_name;
                    $user->city = $location->city;
                    $user->zip_code = $location->zip;
                }
                $user->save();
                $viewData['name'] = $google_user->name;
                Mail::send('emails.register', $viewData, function ($m) use ($user) {
                    $m->from(env('FROM_EMAIL'), 'Musician App');
                    $m->to($user->email, $user->first_name)->subject('Confirmation Email');
                });
                $auth = auth()->guard('user');
                $auth->login($user);
                return Redirect::to('timeline');
            }
        } else {
            Session::flash('error', 'Please Attach Email To your Google Account');
            return Redirect::to('login');
        }
    }

}
