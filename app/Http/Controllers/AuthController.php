<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
//Modal
use App\User;
use App\Affiliation;
use App\Category;
use App\Union;
use App\Timezone;
use App\Language;
use App\SelectedMusicianCategory;
use App\Privacysetting;
use App\Emailsetting;

class AuthController extends Controller {

    function postLogin(Request $request, $remember = false) {

        $request->validate([
            'email' => 'required | email',
            'password' => 'required'
        ]);
        if (isset($request['inputCheckboxesCall'])) {
            $remember = 1;
        }
        $auth = auth()->guard('user');
        if ($auth->attempt(['password' => $request['password'], 'email' => $request['email']], $remember)) {
            $user = User::find(Auth::user()->id);
            $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
            if ($location) {
                $user->lat = $location->latitude;
                $user->lng = $location->longitude;
                $user->country = $location->country_name;
                $user->city = $location->city;
                $user->zip_code = $location->zip;
                $user->save();
            }
            return Redirect::to(URL::previous());
        } else {
            $error_message = 'Invalid Email or Password';
            Session::flash('error', $error_message);
            return Redirect::to('login')->withInput();
        }
    }

    function userRegister(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | email',
            'password' => 'required | min:6 | confirmed',
            'password_confirmation' => 'required'
        ]);
        $check_user = User::where('email', $request['email'])->first();
        if ($check_user) {
            return Redirect::to(URL::previous())->with('error', 'Email Already Taken.')->withInput();
        }
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            $user = new User;
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
        }
        $user->password = bcrypt($request['password']);
        $user->last_login = Carbon::now();
        $user->type = 'user';
        $user->is_web = 1;
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        if ($location) {
            $user->lat = $location->latitude;
            $user->lng = $location->longitude;
            $user->country = $location->country_name;
            $user->city = $location->city;
            $user->zip_code = $location->zip;
        }
        $user->save();
        $viewData['name'] = $user->first_name . ' ' . $user->last_name;
        Mail::send('emails.register', $viewData, function ($m) use ($user) {
            $m->from(env('FROM_EMAIL'), 'Musician App');
            $m->to($user->email, $user->first_name)->subject('Confirmation Email');
        });
        $auth = auth()->guard('user');
        if ($auth->attempt(['password' => $request['password'], 'email' => $request['email']])) {
            return Redirect::to(URL::previous());
        }
        return Redirect::to(URL::previous());
    }

    function artistRegisterView() {
        if (Auth::guard('user')->check()) {
            return redirect('timeline');
        }
        $data['categories'] = Category::where('is_for_musician', 1)->orderBy('title', 'asc')->get();
        $data['unions'] = Union::orderBy('title', 'asc')->get();
        $data['timezones'] = Timezone::orderBy('timezone_location', 'asc')->get();
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        $data['title'] = 'Musician | Musician Register';
        return view('public.musician-register', $data);
    }

    function artistRegister(Request $request) {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required | email',
            'password' => 'required | min:6',
            'country' => 'required',
            'address' => 'required',
            'phone' => 'required'
        ]);
        $check_user = User::where('email', $request['email'])->where('is_web', 1)->first();
        if ($check_user) {
            return Redirect::to(URL::previous())->with('message', 'Email Already Taken')->withInput();
        }
        $user = User::where('email', $request['email'])->first();
        if (!$user) {
            $user = new User;
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->email = $request['email'];
        }
        $user->password = bcrypt($request['password']);
        $user->last_login = Carbon::now();
        $user->type = 'artist';
        $user->is_web = 1;
        $user->artist_lat = $request['lat'];
        $user->artist_lng = $request['lng'];
        $user->country = $request['country'];
        $user->city = $request['city'];
        $user->zip_code = $request['zip_code'];
        $user->timezone = $request['timezone'];
        $user->address = $request['address'];
        $user->gender = $request['gender'];
        $user->language = $request['language'];
        $user->genre = $request['genre'];
//        $user->affiliation = $request['affiliation'];
        if ($request['affiliation'] == 'yes') {
            $user->union_id = $request['unions'];
        }
        if (isset($request['availability'])) {
            $user->allow_booking = 1;
        }
        $user->phone = $request['phone'];
        $location = json_decode(file_get_contents('http://api.ipstack.com/' . \Request::ip() . '?access_key=a8dd21ef5b997c650ce9b402b5538960'));
        if ($location) {
            $user->lat = $location->latitude;
            $user->lng = $location->longitude;
        }
        $email = $request['email'];
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $acc = \Stripe\Account::create(array(
                    "type" => "custom",
                    "country" => "US",
                    "email" => "$email"
        ));
        $user->account_status = 'Unverified';
        $user->stripe_payout_account_id = $acc->id;
        $user->stripe_payout_account_public_key = $acc->keys->publishable;
        $user->stripe_payout_account_secret_key = $acc->keys->secret;
        $user->stripe_payout_account_info = json_encode($acc);
        $user->save();
        foreach ($request['specialization'] as $artistTypeIds) {
            $selectedArtistType = new SelectedMusicianCategory();
            $selectedArtistType->artist_id = $user->id;
            $selectedArtistType->category_id = $artistTypeIds;
            $selectedArtistType->save();
        }
        if ($request['unions']) {
            $newAffiliation = new Affiliation();
            $newAffiliation->union_id = $request['unions'];
            $newAffiliation->user_id = $user->id;
            $newAffiliation->save();
        }
        $add_email_setting = new Emailsetting();
        $add_email_setting->user_id = $user->id;
        $add_email_setting->save();
        $add_privacy_setting = new Privacysetting();
        $add_privacy_setting->user_id = $user->id;
        $add_privacy_setting->save();
        $viewData['name'] = $user->first_name . ' ' . $user->last_name;
        Mail::send('emails.register', $viewData, function ($m) use ($user) {
            $m->from(env('FROM_EMAIL'), 'Musician App');
            $m->to($user->email, $user->first_name)->subject('Confirmation Email');
        });
        $auth = auth()->guard('user');
        if ($auth->attempt(['password' => $request['password'], 'email' => $request['email']])) {
            return Redirect::to(URL::previous());
        }
        return Redirect::to(URL::previous());
    }

    function forgetEmail(Request $request) {
        $user = User::where('email', $request['email'])->first();
        if ($user) {
            $this->securekey = md5('email');
            $ivlen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
            $this->iv = openssl_random_pseudo_bytes($ivlen);
            $plain_text = time();
            $token = base64_encode(openssl_encrypt($plain_text, "AES-128-CBC", $this->securekey, $options = OPENSSL_RAW_DATA, $this->iv));

            $newtoken = str_replace('/', '_', $token);

            User::where('email', $request['email'])
                    ->update(array('emaillestorecode' => $newtoken));
            $user = User::where('email', $request['email'])->first();
            $data['token'] = $newtoken;
            $data['name'] = $user->first_name;
            $emaildata = array('to' => $request['email'], 'to_name' => $user->first_name);
            Mail::send('emails.forgetpassword', $data, function($message) use ($emaildata) {
                $message->to($emaildata['to'], $emaildata['to_name'])
                        ->from(env('FROM_EMAIL'), 'Musician App')
                        ->subject('Reset Your Password');
            });
            Session::flash('success', "Email Has been sent to you");
            return Redirect::to(URL::previous());
        } else {
            $error_message = 'Email Not Found';
            Session::flash('error', $error_message);
            return Redirect::to(URL::previous())->withInput();
        }
    }

    public function resetPassword($token) {
        if (Auth::guard('user')->check()) {
            return redirect('timeline');
        } $data['token'] = $token;
        $check_token = User::where('emaillestorecode', $token)->first();
        if ($check_token) {
            $data['title'] = 'Musician | Reset Password';
            return view('public.resetpassword', $data);
        }
        return view('public.page_not_found', $data);
    }

    public function updatePassword(Request $request) {
        $request->validate([
            'password' => 'required | min:6 | confirmed',
            'password_confirmation' => 'required'
        ]);
        if (isset($request['token'])) {
            if ($request['password'] == $request['password_confirmation']) {
                $user = User::where('emaillestorecode', $request['token'])->first();
                $user->password = bcrypt($request['password']);
                $user->emaillestorecode = '';
                $user->save();
                Session::flash('success', 'Password Changed SuccessFully Login To Continue');
                return Redirect::to('login');
            } else {
                Session::flash('error', 'Password Not Match Confirm Password');
                return Redirect::to(URL::previous());
            }
        } else {
            Session::flash('error', 'Token Expired');
            return Redirect::to(URL::previous());
        }
    }

    function authenticateEmail(Request $request) {
        $check_user = User::where('email', $request['email'])->where('is_web', 1)->first();
        if ($check_user) {
            echo False;
        } else {
            echo True;
        }
    }

    function logoutCron() {
        User::where('is_online', 1)
                ->where('updated_at', '<=', Carbon::now()->subDays(1))
                ->update(['is_online' => 0]);
    }

}
