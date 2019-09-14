<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use App\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class PaymentsController extends Controller {

    private $userId;
    private $user;
    private $userName;

    public function __construct() {
        $this->middleware('auth');
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        set_time_limit(0);
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            return $next($request);
        });
    }

    function bankAccount() {
        if(isset($_GET['bank_not_verified']) && $_GET['bank_not_verified'] == 1){
            Session::flash('info', 'Please add your bank account before creating gig, group, teaching studio and accompanist');
        }
        $data['title'] = 'Account';
        $account = \Stripe\Account::retrieve($this->user->stripe_payout_account_id);
        $data['bank_account'] = $account;
        $data['status'] = $account->legal_entity->verification->status;
        if ($account->legal_entity->verification->status == 'unverified') {
            return view('user.accountverification', $data);
        } else {
            return view('user.accountverification', $data);
        }
    }

    function saveLegalDetails(Request $request) {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $user = User::where('id', $this->userId)->first();
        $account = \Stripe\Account::retrieve($this->user->stripe_payout_account_id);
        $account->tos_acceptance->date = time();

        $dob = new DateTime($request['dob']);
        $dob = $dob->format('Y-m-d');
        $dob = explode('-', $dob);
        $year = $dob[0];
        $month = $dob[1];
        $day = $dob[2];
        $account->legal_entity->dob->year = $year;
        $account->legal_entity->dob->month = $month;
        $account->legal_entity->dob->day = $day;
        $account->tos_acceptance->ip = \Request::ip();
        $account->legal_entity->first_name = $request['first_name'];
        $account->legal_entity->last_name = $request['last_name'];

        $account->legal_entity->type = 'individual';
        $account->legal_entity->address->state = $request['state'];
        $account->legal_entity->address->city = $request['city'];
        $account->legal_entity->address->line1 = $request['address'];
        $account->legal_entity->address->postal_code = $request['postal_code'];
        $account->legal_entity->ssn_last_4 = $request['ssn_last_4'];
        $account->legal_entity->personal_id_number = $request['ssn'];
        $file = Input::file('legal_personal_id_image');
        $ver_fileName = '';
        if ($file->getClientOriginalExtension() != 'exe') {
            $type = $file->getClientMimeType();
            if ($type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp') {
                $ver_destinationPath = 'public/images/verification'; // upload path
                $ver_extension = $file->getClientOriginalExtension(); // getting image extension
                $ver_fileName = 'profile_' . Str::random(15) . '.' . $ver_extension; // renameing image
                $img = Image::make($file->getRealPath());
                $size = $img->filesize();
                if ($size > 2000) {
                    $height = $img->height();
                    $get_width = $img->width() / 720;
                    $new_height = $height / $get_width;
                    $img->resize(720, $new_height)->save($ver_destinationPath . '/' . $ver_fileName);
                } else {
                    Input::file('legal_personal_id_image')->move($ver_destinationPath, $ver_fileName);
                }
            }
//                    echo $_SERVER['DOCUMENT_ROOT'];exit;
            if($ver_fileName){
                $filename = '/var/www/html/musician/public/images/verification/' . $ver_fileName;
            } else {
                Session::flash('error', 'Please enter a valid image file');
                return Redirect::to(URL::previous())->withInput();
            }
//
//            $chmod = 0644;
//            chmod($filename, $chmod);
            $fp = fopen($filename, 'r');

            $stripe_file = \Stripe\FileUpload::create(array(
                        'purpose' => 'identity_document',
                        'file' => $fp
            ));
            $account->legal_entity->verification->document = $stripe_file->id;
        }
        $catchMessage = '';
        try {
            $account->save();
        } catch (\Stripe\Error\Card $e) {
            $catchMessage = $e->getMessage();
        } catch (\Stripe\Error\RateLimit $e) {
            $catchMessage = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $catchMessage = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $catchMessage = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            $catchMessage = $e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            $catchMessage = $e->getMessage();
        } catch (Exception $e) {
            $catchMessage = $e->getMessage();
        }
        if($catchMessage){
            $catchMessage = str_replace('_', ' ', $catchMessage);
            $catchMessage = str_replace('personal id number', 'personal id', $catchMessage);
            Session::flash('error', $catchMessage);
            return Redirect::to(URL::previous())->withInput();
        }
        $updated_status = \Stripe\Account::retrieve($user->stripe_payout_account_id);
        $user->stripe_payout_account_info = json_encode($updated_status);
        $user->save();
        Session::flash('success', 'Your details has been send for verification');
        return Redirect::to(URL::previous());
    }

    function saveBank(Request $request) {
        $user = Auth::user();
        $account = \Stripe\Account::retrieve($user->stripe_payout_account_id);


        $account->external_accounts->create(array(
            "external_account" => $request['stripeToken'],
            "default_for_currency" => true,
        ));
        $updatedaccount = \Stripe\Account::retrieve($user->stripe_payout_account_id);
        $user->stripe_payout_account_info = json_encode($updatedaccount);
        $user->is_bank_account_verified = 1;
        $user->save();
        Session::flash('success', 'Account has been saved');
        return Redirect::to('bank_account');
    }

    function card() {
        $data['title'] = 'Card';
        return view('user.card', $data);
    }

    function saveCard(Request $request) {
        $token = $request->stripeToken;
        $email = $request->email;
        $user = $this->user;
        if (!$user->stripe_id) {
            try {
           $cus = \Stripe\Customer::create(array(
                        "description" => "Customer for $email",
                        "source" => "$token" // obtained with Stripe.js
            ));
            $user->stripe_id = $cus->id;
            $user->card_brand = $cus->sources->data[0]->brand;
            $user->card_last_four = $cus->sources->data[0]->last4;
            $user->card_id = $cus->default_source;
            $user->exp_month = $cus->sources->data[0]->exp_month;
            $user->exp_year = $cus->sources->data[0]->exp_year;
            $user->save();
            Session::flash('success', 'Your card has been added');
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Card $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\RateLimit $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\InvalidRequest $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Authentication $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\ApiConnection $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (\Stripe\Error\Base $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::to(URL::previous());
        }
            
        } else {
            $customer = \Stripe\Customer::retrieve($user->stripe_id);
            $updated_card=$customer->sources->create(array("source" => $token));
            $user->card_brand =$updated_card->brand;
            $user->card_last_four = $updated_card->last4;
            $user->card_id = $updated_card->id;
            $user->exp_month = $updated_card->exp_month;
            $user->exp_year = $updated_card->exp_year;
            $user->save();
            $customer->default_source=$updated_card->id;
            $customer->save();
            Session::flash('success', 'Your card has been added');
            return Redirect::to(URL::previous());
        }
    }

}
