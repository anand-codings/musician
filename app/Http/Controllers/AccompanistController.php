<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Accompanist;
use App\AccompanistImage;
use App\AccompanistEducation;
use App\AccompanistExperience;
use App\Notification;
use App\Language;
use Intervention\Image\Facades\Image;
use App\Booking;
use App\FollowServie;
use App\Review;
use App\SelectedAccompanistCategory;
use App\ServiceProfileView;
use App\Category;
use App\AccompanistMember;
use Illuminate\Support\Facades\File;

class AccompanistController extends Controller {

    private $userId;
    private $user;
    private $userName;
    private $userLastName;

    public function __construct() {
        $this->middleware(function ($request, $next) {
            $this->userId = Auth::user()->id;
            $this->user = Auth::user();
            $this->userName = Auth::user()->first_name;
            $this->userLastName = Auth::user()->last_name;

            return $next($request);
        });
    }
     function referFriendToJoinAccompanist(Request $request) {
        $accompanist = Accompanist::find($request['accompanist_id']);
        $accompanist_type = $request['accompanist_type'];
        $receiver_id = $accompanist->admin_id;
        $member_ids_string=($request->member_ids);
        $member_ids = explode(',', $member_ids_string);
        $notification=[];

        if((!empty($member_ids)) && (!empty($accompanist))){
           foreach ($member_ids as $key=>$member_id) {
                $accompanistMember = new AccompanistMember();
                $accompanistMember->user_id = $member_id;
                $accompanistMember->type = $accompanist_type;
                if($this->userId == $accompanist->admin_id ){
                    $accompanistMember->is_approved = 1;
                }
                $accompanistMember->accompanist_id = $request['accompanist_id'];
                $accompanistMember->save();
                $user = User::select('id','first_name', 'last_name', 'photo')->findOrFail($member_id);
                if($this->userId != $accompanist->admin_id ){
                    $notification[$key]['notification_for_admin'] = addNotificationForStudioAdminThenGet($accompanistMember->getAccompanistDetail->admin_id, 'You are joining accompanist',
                                                                                                        'wants to join your accompanist "' . $accompanist->name . '"' . '' . ', refer by '.$this->userName .' '.$this->userLastName, 
                                                                                                        'accompanist',
                                                                                                        'Accompanist', 
                                                                                                        $accompanist->id, 
                                                                                                        'accompanist' . $accompanist->id . '_refer_to'.$user->id.'_by' . $this->userId, 
                                                                                                        $user);
                    $notification[$key]['refer_user_id'] = $user->id;
                    $notification[$key]['user_fname'] = $user->first_name;
                    $notification[$key]['user_lname'] = $user->last_name;
                    $notification[$key]['user_photo'] = $user->photo;

             
                } else {
                    $notificationsave = addNotificationThenGet($member_id, 'You are added to the Accompanist',
                                                                                                        'added you to the Accompanist "' . $accompanist->name . '"', 
                                                                                                        'accompanist',
                                                                                                        'Accompanist', 
                                                                                                        $accompanist->id, 
                                                                                                        'accompanist' . $accompanist->id . 'added_'.$member_id.'by_'.$this->userId);
                    $notificationsave->left_notification = 1;
                    $notificationsave->save();
                    $notification[$key]['notification_for_admin'] = $notificationsave;
                    $notification[$key]['refer_user_id'] = $user->id;
                    $notification[$key]['user_fname'] = $user->first_name;
                    $notification[$key]['user_lname'] = $user->last_name;
                    $notification[$key]['user_photo'] = $user->photo;

                }
           }
          return response()->json(array('success' => 'Teaching studio joined successfully', 'error'=> '', 'user' => $user, 'notification' => $notification));
        } else {
            return response()->json(array('success' => '', 'error'=>'Something went wrong', 'user' => '', 'notification' => ''));
        }
    }
    function createAccompanistView() {
        $data['title'] = 'Musician | Create Accompanist';
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        return view('user.create_accompanist', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    function createAccompanist(Request $request) {
        
        $validation = $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',
            'gender' => 'required',
            'price' => 'required',
            'language' => 'required',
            'address' => 'required',
            'per_unit' => 'required',
            'description' => 'required',
        ]);
        $accompanist = new Accompanist();
        $accompanist->name = $request['name'];
        if ($request['allow_booking']) {
            $accompanist->allow_booking = 1;
        }
        $accompanist->description = $request['description'];
        $accompanist->admin_id = $this->userId;
        $accompanist->location = $request['address'];
        $accompanist->lat = $request['lat'];
        $accompanist->lng = $request['lng'];
        $accompanist->language = $request['language'];
        $accompanist->price = $request['price'];
        $accompanist->unit_id = $request['unit_id'];
        $accompanist->per_unit = $request['per_unit'];
        $accompanist->price = $request['price'];
        $accompanist->gender = $request['gender'];
        $pic = $request->pic;
        if ($pic && $pic != 'undefined') {
            $pic = str_replace('data:image/png;base64,', '', $pic);
            $pic = str_replace(' ', '+', $pic);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            $destinationPath = public_path('../public/images/accompanists');
            $accompanist->pic = $request->photo;
            $accompanist->original_pic = $request->original_photo;
            $completePath = 'public/images/accompanists/' . $image_name;
            addMediaForBase64Images($completePath, 'image', '', $request->pic);
        }
        $cover = $request->file('cover');
        if ($cover) {
            $destinationPath = public_path('../public/images/accompanists');
            $cover_name = "cover-" . time() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/accompanists/' . $cover_name);
            $accompanist->cover = 'accompanists/' . $cover_name;
            $input['imagename'] = "cover-" .uniqid() . '.' . $cover->getClientOriginalExtension();
            $accompanist->original_cover = 'accompanists/' .$input['imagename'];
            $completePath = 'public/images/accompanists/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);
        }
        
        $accompanist->save();
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $accompanistImage = new AccompanistImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/accompanists');
                        $accompanistImage->file = 'accompanists/' . $input['imagename'];
                        $accompanistImage->accompanist_id = $accompanist->id;
                        $accompanistImage->save();
                        $completePath = 'public/images/accompanists/' . $input['imagename'];
                        addMedia($completePath, 'image', '', $galleryImage);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }
        if ($request['education']) {
            foreach ($request['education'] as $education) {
                if ($education) {
                    $accompanistEducation = new AccompanistEducation();
                    $accompanistEducation->title = $education['title'];
                    $accompanistEducation->institute_name = $education['institute_name'];
                    $accompanistEducation->start_year = $education['start_year'];
                    $accompanistEducation->end_year = $education['end_year'];
                    $accompanistEducation->accompanist_id = $accompanist->id;
                    $accompanistEducation->save();
                }
            }
        }
        if ($request['experience']) {
            foreach ($request['experience'] as $experience) {
                if ($experience) {
                    $accompanistExperience = new AccompanistExperience();
                    $accompanistExperience->title = $experience['title'];
                    $accompanistExperience->institute_name = $experience['institute_name'];
                    $accompanistExperience->start_year = $experience['start_year'];
                    $accompanistExperience->end_year = $experience['end_year'];
                    $accompanistExperience->accompanist_id = $accompanist->id;
                    $accompanistExperience->save();
                }
            }
        }
        $request['categories'] = explode(',', $request['categories']);
        foreach ($request['categories'] as $category) {
            $selectedAccompanistCategory = new SelectedAccompanistCategory();
            $selectedAccompanistCategory->accompanist_id = $accompanist->id;
            $selectedAccompanistCategory->accompanist_category_id = $category;
            $selectedAccompanistCategory->save();
        }
        return response()->json(array('success' => 'Accompanist created successfully'));
    }

    function editAccompanistView($accompanistId) {
        $data['accompanist'] = Accompanist::where(['id' => $accompanistId, 'admin_id' => $this->userId])->first();
        if (!$data['accompanist']) {
            return Redirect::to(URL::previous());
        }
        $data['title'] = 'Musician | Edit Accompanist';
        $data['artistTypes'] = Category::where('is_for_accompanist', 1)->orderBy('title')->get();
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        $selectedAccompanistCategoryIds = SelectedAccompanistCategory::where('accompanist_id', $data['accompanist']->id)->pluck('accompanist_category_id');
        $myAccompanistCategoryIds = [];
        foreach ($selectedAccompanistCategoryIds as $accompanistCategoryId) {
            array_push($myAccompanistCategoryIds, $accompanistCategoryId);
        }
        $data['myAccompanistCategoryIds'] = $myAccompanistCategoryIds;
        return view('user.edit_accompanist', $data);
    }

    function editAccompanist(Request $request) {
//        dd($request->all());
        $validation = $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'price' => 'required',
            'language' => 'required',
            'address' => 'required',
            'description' => 'required',
            'accompanist_id' => 'required',
            'per_unit' => 'required',
        ]);
        $accompanist = Accompanist::find($request['accompanist_id']);
        $accompanist->name = $request['name'];
        if ($request['allow_booking']) {
            $accompanist->allow_booking = 1;
        } else {
            $accompanist->allow_booking = 0;
        }
        $accompanist->description = $request['description'];
        $accompanist->admin_id = $this->userId;
        $accompanist->location = $request['address'];
        $accompanist->lat = $request['lat'];
        $accompanist->lng = $request['lng'];
        $accompanist->language = $request['language'];
        $accompanist->price = $request['price'];

        $accompanist->unit_id = $request['unit_id'];
        $accompanist->per_unit = $request['per_unit'];

        $accompanist->gender = $request['gender'];
        $pic = $request->pic;
//        if ($pic && $pic != 'undefined') {
//            $pic = str_replace('data:image/png;base64,', '', $pic);
//            $pic = str_replace(' ', '+', $pic);
//            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
//            $destinationPath = public_path('../public/images/accompanists');
//            $accompanist->pic = $request->photo;
//            $accompanist->original_pic = $request->original_photo;
//            $completePath = 'public/images/accompanists/' . $image_name;
//            addMediaForBase64Images($completePath, 'image', '', $request->pic);
//        }

        $old_photo     = 'public/images/'.$accompanist->pic;
        $old_original_photo     = 'public/images/'.$accompanist->original_pic;
        if ($pic && $pic != 'undefined') {
            $accompanist->pic = $request->photo;
            $accompanist->original_pic = $request->original_photo;
            if(File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if(File::exists($old_photo)) {
                File::delete($old_photo);
            }
        }else{
            if($request->photo){
                $accompanist->pic = $request->photo;
                if(File::exists($old_photo)) {
                    File::delete($old_photo);
                }
            }
        }
        $del_flag   = $request['pro_del_flag'];
        //remove profile pic from server & DB
        if($del_flag==1){
            $accompanist->pic = NULL;
            $accompanist->original_pic = NULL;
            if(File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if(File::exists($old_photo)) {
                File::delete($old_photo);
            }
        }
//        $cover = $request->file('cover');
//        if ($cover) {
//            $destinationPath = public_path('../public/images/accompanists');
//            $cover_name = "cover-" . time() . ".png";
//            Image::make(file_get_contents($request->image_croped))->save('public/images/accompanists/' . $cover_name);
//            $accompanist->cover = 'accompanists/' . $cover_name;
//            $input['imagename'] = uniqid() . '.' . $cover->getClientOriginalExtension();
//            $completePath = 'public/images/accompanists/' . $input['imagename'];
//            addMedia($completePath, 'image', '', $cover);
//            $cover->move($destinationPath, $input['imagename']);
//        }
        $old_cover     = 'public/images/'.$accompanist->cover;
        $old_original_cover     = 'public/images/'.$accompanist->original_cover;
        $cover          = $request->file('cover');
        if ($cover) {
            $destinationPath = public_path('../public/images/accompanists');
            $cover_name = "cover-" . uniqid() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/accompanists/' . $cover_name);
            $accompanist->cover = 'accompanists/' . $cover_name;
            $input['imagename'] = "cover-" . uniqid() . '.' . $cover->getClientOriginalExtension();
            $accompanist->original_cover = 'accompanists/' .$input['imagename'];
            $completePath = 'public/images/accompanists/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);
            if(File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if(File::exists($old_cover)) {
                File::delete($old_cover);
            }
        }else {
            if($request->image_croped) {
                $destinationPath = public_path('../public/images/accompanists');
                $cover_name = "cover-" . uniqid() . ".png";
                Image::make(file_get_contents($request->image_croped))->save('public/images/accompanists/' . $cover_name);
                $accompanist->cover = 'accompanists/' . $cover_name;

                if (File::exists($old_cover)) {
                    File::delete($old_cover);
                }
            }
        }

        //remove cover pic from server & DB
        $cov_is_delete   = $request['cov_del_flag'];
        if($cov_is_delete==1){
            $accompanist->cover = NULL;
            $accompanist->original_cover = NULL;
            if(File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if(File::exists($old_cover)) {
                File::delete($old_cover);
            }
        }
        $accompanist->save();
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $accompanistImage = new AccompanistImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/accompanists');
                        $accompanistImage->file = 'accompanists/' . $input['imagename'];
                        $accompanistImage->accompanist_id = $accompanist->id;
                        $accompanistImage->save();
                        $completePath = 'public/images/accompanists/' . $input['imagename'];
                        addMedia($completePath, 'image', '', $galleryImage);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }
        if ($request['education']) {
            foreach ($request['education'] as $education) {
                if ($education) {
                    if (isset($education['education_id'])) {
                        $oldEducationData = AccompanistEducation::find($education['education_id']);
                        $oldEducationData->title = $education['title'];
                        $oldEducationData->institute_name = $education['institute_name'];
                        $oldEducationData->start_year = $education['start_year'];
                        $oldEducationData->end_year = $education['end_year'];
                        $oldEducationData->save();
                    } else {
                        $accompanistEducation = new AccompanistEducation();
                        $accompanistEducation->title = $education['title'];
                        $accompanistEducation->institute_name = $education['institute_name'];
                        $accompanistEducation->start_year = $education['start_year'];
                        $accompanistEducation->end_year = $education['end_year'];
                        $accompanistEducation->accompanist_id = $accompanist->id;
                        $accompanistEducation->save();
                    }
                }
            }
        }
        if ($request['experience']) {
            foreach ($request['experience'] as $experience) {
                if ($experience) {
                    if (isset($experience['experience_id'])) {
                        $oldExperienceData = AccompanistExperience::find($experience['experience_id']);
                        $oldExperienceData->title = $experience['title'];
                        $oldExperienceData->institute_name = $experience['institute_name'];
                        $oldExperienceData->start_year = $experience['start_year'];
                        $oldExperienceData->end_year = $experience['end_year'];
                        $oldExperienceData->save();
                    } else {
                        $accompanistExperience = new AccompanistExperience();
                        $accompanistExperience->title = $experience['title'];
                        $accompanistExperience->institute_name = $experience['institute_name'];
                        $accompanistExperience->start_year = $experience['start_year'];
                        $accompanistExperience->end_year = $experience['end_year'];
                        $accompanistExperience->accompanist_id = $accompanist->id;
                        $accompanistExperience->save();
                    }
                }
            }
        }
        $request['categories'] = explode(',', $request['categories']);
        SelectedAccompanistCategory::where('accompanist_id', $accompanist->id)->delete();
        foreach ($request['categories'] as $category) {
            $selectedAccompanistCategory = new SelectedAccompanistCategory();
            $selectedAccompanistCategory->accompanist_id = $accompanist->id;
            $selectedAccompanistCategory->accompanist_category_id = $category;
            $selectedAccompanistCategory->save();
        }
        return response()->json(array('success' => 'Accompanist updated successfully'));
    }

    function removeAccompanistEducation(Request $request) {
        AccompanistEducation::where(['accompanist_id' => $request['accompanist_id'], 'id' => $request['education_id']])->delete();
    }

    function removeAccompanistExperience(Request $request) {
        AccompanistExperience::where(['accompanist_id' => $request['accompanist_id'], 'id' => $request['experience_id']])->delete();
    }

    function accompanists() {
        $data['title'] = 'Musician | Accompanists';
        return view('user.accompanists', $data);
    }

    function fetchAccompanists(Request $request) {
        $data['accompanists'] = Accompanist::where('admin_id', $this->userId)
                ->take($request->take)
                ->skip($request->skip)
                ->get();
        return view('user.loader.accompanists_loader', $data);
    }

    function deleteAccompanist(Request $request) {
        $teachingStudio = Accompanist::where(['id' => $request->accompanist_id, 'admin_id' => $this->userId])->first();
        if ($teachingStudio) {
            $teachingStudio->delete();
            return response()->json(array('success' => 'Accompanist delete successfully.'));
        }
        return response()->json(array('error' => 'Teaching studio not found.'));
    }

    function deleteAccompanistImage(Request $request) {
        $image = AccompanistImage::where('id', $request->accompanist_id)->first();
        if ($image) {
            $image->delete();
            return response()->json(array('success' => 'Accompanist image deleted successfully.'));
        }
        return response()->json(array('error' => 'Accompanist image not found.'));
    }

    function stats($accompanist_id) {
        $data['title'] = 'Musician |Event Statistics';
        $data['user'] = $this->user;
        $data['accompanist'] = Accompanist::find($accompanist_id);
$views_stats_data = [];
        $views_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = ServiceProfileView::where('accompanist_id', $accompanist_id)->whereDate('created_at', $date)->count();
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
            $count = FollowServie::where('accompanist_id', $accompanist_id)->whereDate('created_at', $date)->count();
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
            $count = Booking::where(['accompanist_id' => $accompanist_id, 'status' => 'payment_approved'])->whereDate('created_at', $date)->count();
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
            $count = Review::where('accompanist_id', $accompanist_id)->whereDate('created_at', $date)->count();
            array_push($reviews_stats_data, $count);
            array_push($reviews_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['reviews_stats_data'] = $reviews_stats_data;
        $data['reviews_stats_labels'] = $reviews_stats_labels;
        return view('user.statistics_accompanist', $data);
    }
    
    function addAccompanistMember(Request $request){
        
        $accompanist = Accompanist::find($request->accompanist_id);
        $receiver_id = $accompanist->admin_id;
        if ($accompanist) {
            if ($request['status'] == 'leave' || $request['status'] == 'requested'  || $request['status'] == 'cancel') {
                AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $this->userId])->delete();
                $notification = Notification::where([
                    'user_id' => $this->userId,
                    'type' => 'accompanist',
                    'type_id' => $accompanist->id,
                    'unique_text' => 'accompanist' . $accompanist->id . '_join_request_by' . $this->userId
                ])->delete();
                if ($request['status'] == 'leave') {
                    //$notification = addNotificationThenGet($receiver_id, '', 'leaves your Accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_leaves_accompanist_by' . $this->userId);
                    return response()->json(array('success' => 'Accompanist leaved successfully.', 'status' => 'leaved', 'notification' => $notification, 'admin_id' => $receiver_id));
                } 
                return response()->json(array('success' => 'Accompanist leaved successfully.', 'status' => 'leaved', 'notification' => $notification, 'admin_id' => $receiver_id));
            } else if ($request['status'] == 'join') {
                $accompanistMember = new AccompanistMember();
                $accompanistMember->user_id = $this->userId;
                $accompanistMember->accompanist_id = $request['accompanist_id'];
                $accompanistMember->save();
                $notification = addNotificationThenGet($receiver_id, '', 'wants to join you as accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_join_request_by' . $this->userId);
//                $notification->left_notification = 1;
                $notification->save();
                return response()->json(array('success' => 'Accompanist request sent successfully.', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }
    
    
    
    function joinAccompanistResponse(Request $request) {
        $accompanist = Accompanist::find($request['accompanist_id']);
        if ($accompanist) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_accompanist_admin_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $accompanistMember = AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $request['user_id']])->first();
                $accompanistMember->is_rejected = 1;
                $accompanistMember->is_approved = 0;
                $accompanistMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You requested to join the accompanist', 'rejected your request to join accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_response_for' . $receiver_id);
                $notification->is_accompanist_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Accompanist joining request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $user_img = User::find($request['user_id']);
                $accompanistMember = AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $request['user_id']])->first();
                $accompanistMember->is_approved = 1;
                $accompanistMember->is_rejected = 0;
                $accompanistMember->save();
                $notification = addNotificationThenGet($receiver_id, 'Accompanist admin responded to the accompanist join request', 'accepted your request to join accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_response_for' . $receiver_id);
                $notification->is_accompanist_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Accompanist joining request approved.', 'status' => 'approved', 'notification' => $notification,'photo'=>$user_img->photo));
            }
        }
    }

    function inviteAccompanistResponse(Request $request) {
        $accompanist = Accompanist::find($request['accompanist_id']);
        $accompanistMember = AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $this->userId])->first();
        if ($accompanist) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_accompanist_invitee_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $accompanistMember = AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $this->userId])->delete();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the accompanist', 'rejected your invitation to join accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_accompanist_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Accompanist invitation request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $accompanistMember = AccompanistMember::where(['accompanist_id' => $request['accompanist_id'], 'user_id' => $this->userId])->first();
                $accompanistMember->is_approved = 1;
                $accompanistMember->is_rejected = 0;
                $accompanistMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the accompanist', 'accepted your invitation to join accompanist "' . $accompanist->name . '"', 'accompanist', 'Accompanist', $accompanist->id, 'accompanist' . $accompanist->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_accompanist_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Accompanist invitation request approved.', 'status' => 'approved', 'notification' => $notification));
            }
        }
    }

}
