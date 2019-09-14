<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\User;
use App\Interest;
use App\UserInterest;
use App\UserEducation;
use App\UserExperiences;
use App\Category;
use App\Affiliation;
use App\UserFollower;
use App\TeachingStudio;
use App\TeachingStudioImage;
use App\TeachingStudioMember;
use App\Notification;
use App\SelectedTeachingStudioCategory;
use App\Union;
use App\Language;
use App\TeachingStudioEducation;
use App\TeachingStudioExperience;
use Intervention\Image\Facades\Image;
use App\FollowServie;
use App\Review;
use App\Booking;
use App\ServiceProfileView;
use Illuminate\Support\Facades\File;

class TeachingStudioController extends Controller {

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

    function createTeachingStudioView() {
        $data['title'] = 'Musician | Create Teaching Studio';
        $data['artistTypes'] = Category::where('is_solo', 1)->orderBy('title')->get();
        $data['unions'] = Union::orderBy('title', 'asc')->get();
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        return view('user.create_teaching_studio', $data);
    }

    function createTeachingStudio(Request $request) {

        $validation = $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',
            'start_date' => 'required',
            'address' => 'required',
            'description' => 'required',
            'per_unit' => 'required',
            'studio_time_from' => 'required',
            'studio_time_to' => 'required',
        ]);
        $teachingStudio = new TeachingStudio();
        $teachingStudio->name = $request['name'];
        if ($request['allow_booking']) {
            $teachingStudio->allow_booking = 1;
        }

        $teachingStudio->start_date = $request['start_date'];
        $teachingStudio->description = $request['description'];
        $teachingStudio->admin_id = $this->userId;
        $teachingStudio->location = $request['address'];
        $teachingStudio->lat = $request['lat'];
        $teachingStudio->lng = $request['lng'];
        $teachingStudio->studio_time_from = $request['studio_time_from'];
        $teachingStudio->studio_time_to = $request['studio_time_to'];
        $teachingStudio->genre = $request['genre'];
        $teachingStudio->level_taught = $request['level_taught'];
        $teachingStudio->lesson_type = $request['lesson_type'];
        $teachingStudio->language = $request['language'];
        $teachingStudio->price = $request['price'];
        $teachingStudio->per_unit = $request['per_unit'];
        $teachingStudio->unit_id = $request['unit_id'];
        $teachingStudio->is_accepting_students = $request['is_accepting_students'];
        $pic = $request->pic;
        if ($pic && $pic != 'undefined') {
            $pic = str_replace('data:image/png;base64,', '', $pic);
            $pic = str_replace(' ', '+', $pic);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            $destinationPath = public_path('../public/images/teaching_studios');
            $teachingStudio->pic = $request->photo;
            $teachingStudio->original_pic = $request->original_photo;
            $completePath = 'public/images/teaching_studios/' . $image_name;
            addMediaForBase64Images($completePath, 'image', '', $request->pic);
        }
        $cover = $request->file('cover');
        if ($cover) {

            $destinationPath = public_path('../public/images/teaching_studios');
            $cover_name = "cover-" . uniqid() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/teaching_studios/' . $cover_name);
            $teachingStudio->cover = 'teaching_studios/' . $cover_name;
            $input['imagename'] = uniqid() . '.' . $cover->getClientOriginalExtension();
            $teachingStudio->original_cover = 'groups/' . $input['imagename'];
            $completePath = 'public/images/teaching_studios/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);

//
//            $input['imagename'] = uniqid() . '.' . $cover->getClientOriginalExtension();
//            $destinationPath = public_path('../public/images/teaching_studios');
//            $teachingStudio->cover = 'teaching_studios/' . $input['imagename'];
//            $completePath = 'public/images/teaching_studios/'.$input['imagename'];
//            addMedia($completePath, 'image', '', $cover);
//            $cover->move($destinationPath, $input['imagename']);
        }

        $teachingStudio->save();
        $request['categories'] = explode(',', $request['categories']);
        foreach ($request['categories'] as $category) {
            $selectedStudioCategory = new SelectedTeachingStudioCategory();
            $selectedStudioCategory->teaching_studio_id = $teachingStudio->id;
            $selectedStudioCategory->studio_category_id = $category;
            $selectedStudioCategory->save();
        }
        $gender = $teachingStudio->user->gender;
        if ($gender == 'male') {
            $gender = 'his';
        } else {
            $gender = 'her';
        }
        $notifications = new \Illuminate\Support\Collection();
        if ($request['members']) {
            $members = explode(",", $request['members']);
            foreach ($members as $member) {
                if ($member != $this->userId) {
                    $teachingStudioMember = new TeachingStudioMember();
                    $teachingStudioMember->user_id = $member;
                    $teachingStudioMember->teaching_studio_id = $teachingStudio->id;
                    $teachingStudioMember->save();
                    $notification = addNotificationThenGet($member, 'You are invited to join a studio', 'invited you to join ' . $gender . ' studio "' . $teachingStudio->name . '"', 'teaching_studio', 'TeachingStudio', $teachingStudio->id, 'studio' . $teachingStudio->id . '_invite_request_by_musician' . $this->userId . '_to_user' . $member);
                    $notification->is_studio_invite = 1;
                    $notification->is_studio_request_response = 1;
                    $notification->save();
                    $notifications->push($notification);
                }
            }
        }
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $teachingStudioImage = new TeachingStudioImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/teaching_studios');
                        $teachingStudioImage->file = 'teaching_studios/' . $input['imagename'];
                        $teachingStudioImage->teaching_studio_id = $teachingStudio->id;
                        $teachingStudioImage->save();
                        $completePath = 'public/images/teaching_studios/' . $input['imagename'];
                        addMedia($completePath, 'image', '', $galleryImage);
                        $galleryImage->move($destinationPath, $input['imagename']);
                    }
                }
            }
        }

        if ($request['education']) {
            foreach ($request['education'] as $education) {
                if ($education) {
                    $studioEducation = new TeachingStudioEducation;
                    $studioEducation->title = $education['title'];
                    $studioEducation->institute_name = $education['institute_name'];
                    $studioEducation->start_year = $education['start_year'];
                    $studioEducation->end_year = $education['end_year'];
                    $studioEducation->teaching_studio_id = $teachingStudio->id;
                    $studioEducation->save();
                }
            }
        }
        if ($request['experience']) {
            foreach ($request['experience'] as $experience) {
                if ($experience) {
                    $studioExperience = new TeachingStudioExperience();
                    $studioExperience->title = $experience['title'];
                    $studioExperience->institute_name = $experience['institute_name'];
                    $studioExperience->start_year = $experience['start_year'];
                    $studioExperience->end_year = $experience['end_year'];
                    $studioExperience->teaching_studio_id = $teachingStudio->id;
                    $studioExperience->save();
                }
            }
        }

        return response()->json(array('success' => 'Studio created successfully', 'studio_name' => $teachingStudio->name, 'notifications' => $notifications));
//        Session::flash('success', 'TeachingStudio created successfully.');
//        return Redirect::to(URL::previous());
    }

    function editTeachingStudioView($teachingStudioId) {
        $data['teachingStudio'] = TeachingStudio::where(['id' => $teachingStudioId, 'admin_id' => $this->userId])->first();
        if (!$data['teachingStudio']) {
            return Redirect::to(URL::previous());
        }
        $data['title'] = 'Musician | Edit Teaching Studio';
        $data['artistTypes'] = Category::where('is_for_studio', 1)->orderBy('title')->get();
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        $data['genres'] = ['Baroque', 'Classical', 'Jazz', 'Country', 'World', 'Rock', 'Electronic', 'Popular', 'Wedding'];
        $data['levels'] = ['beginner', 'intermediate', 'advance', 'all levels'];
        $selectedStudioCategoryIds = SelectedTeachingStudioCategory::where('teaching_studio_id', $data['teachingStudio']->id)->pluck('studio_category_id');
        $myStudioCategoryIds = [];
        foreach ($selectedStudioCategoryIds as $studioCategoryId) {
            array_push($myStudioCategoryIds, $studioCategoryId);
        }
        $data['myStudioCategoryIds'] = $myStudioCategoryIds;

        return view('user.edit_teaching_studio', $data);
    }

    function editTeachingStudio(Request $request) {
//        dd($request->all());
        $validation = $this->validate($request, [
            'name' => 'required',
            'categories' => 'required',
            'start_date' => 'required',
            'address' => 'required',
            'description' => 'required',
            'studio_time_from' => 'required',
            'studio_time_to' => 'required',
            'per_unit' => 'required',
            'teaching_studio_id' => 'required',
        ]);
        $teachingStudio = TeachingStudio::find($request['teaching_studio_id']);
        $teachingStudio->name = $request['name'];
        if ($request['allow_booking']) {
            $teachingStudio->allow_booking = 1;
        } else {
            $teachingStudio->allow_booking = 0;
        }
        $teachingStudio->start_date = $request['start_date'];
        $teachingStudio->description = $request['description'];
        $teachingStudio->admin_id = $this->userId;
//        $teachingStudio->category_id = $request['artist_type_id'];
        $teachingStudio->location = $request['address'];
        $teachingStudio->lat = $request['lat'];
        $teachingStudio->lng = $request['lng'];
        $teachingStudio->studio_time_from = $request['studio_time_from'];
        $teachingStudio->studio_time_to = $request['studio_time_to'];
        $teachingStudio->genre = $request['genre'];
        $teachingStudio->level_taught = $request['level_taught'];
        $teachingStudio->lesson_type = $request['lesson_type'];
        $teachingStudio->language = $request['language'];
        $teachingStudio->price = $request['price'];

        $teachingStudio->per_unit = $request['per_unit'];
        $teachingStudio->unit_id = $request['unit_id'];

        $teachingStudio->is_accepting_students = $request['is_accepting_students'];
        $pic = $request->pic;
        /*
          if ($pic && $pic != 'undefined') {
          $pic = str_replace('data:image/png;base64,', '', $pic);
          $pic = str_replace(' ', '+', $pic);
          $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
          $destinationPath = public_path('../public/images/teaching_studios');
          $teachingStudio->pic = $request->photo;
          $teachingStudio->original_pic = $request->original_photo;
          $completePath = 'public/images/teaching_studios/' . $image_name;
          addMediaForBase64Images($completePath, 'image', '', $request->pic);
          } */
        $old_photo = 'public/images/' . $teachingStudio->pic;
        $old_original_photo = 'public/images/' . $teachingStudio->original_pic;
        if ($pic && $pic != 'undefined') {
            $teachingStudio->pic = $request->photo;
            $teachingStudio->original_pic = $request->original_photo;
            if (File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if (File::exists($old_photo)) {
                File::delete($old_photo);
            }
        } else {
            if ($request->photo) {
                $teachingStudio->pic = $request->photo;
                if (File::exists($old_photo)) {
                    File::delete($old_photo);
                }
            }
        }
        $del_flag = $request['pro_del_flag'];
        //remove profile pic from server & DB
        if ($del_flag == 1) {
            $teachingStudio->pic = NULL;
            $teachingStudio->original_pic = NULL;
            if (File::exists($old_original_photo)) {
                File::delete($old_original_photo);
            }
            if (File::exists($old_photo)) {
                File::delete($old_photo);
            }
        }/*
          $cover = $request->file('cover');
          if ($cover) {
          $destinationPath = public_path('../public/images/teaching_studios');
          $cover_name = "cover-" . time() . ".png";
          Image::make(file_get_contents($request->image_croped))->save('public/images/teaching_studios/' . $cover_name);
          $teachingStudio->cover = 'teaching_studios/' . $cover_name;
          $input['imagename'] = uniqid() . '.' . $cover->getClientOriginalExtension();
          $completePath = 'public/images/teaching_studios/' . $input['imagename'];
          addMedia($completePath, 'image', '', $cover);
          $cover->move($destinationPath, $input['imagename']);
          //            $input['imagename'] = uniqid() . '.' . $cover->getClientOriginalExtension();
          //            $destinationPath = public_path('../public/images/teaching_studios');
          //            $teachingStudio->cover = 'teaching_studios/' . $input['imagename'];
          //            $completePath = 'public/images/teaching_studios/' . $input['imagename'];
          //            addMedia($completePath, 'image', '', $cover);
          //            $cover->move($destinationPath, $input['imagename']);
          } */
        $old_cover = 'public/images/' . $teachingStudio->cover;
        $old_original_cover = 'public/images/' . $teachingStudio->original_cover;
        $cover = $request->file('cover');
        if ($cover) {
            $destinationPath = public_path('../public/images/teaching_studios');
            $cover_name = "cover-" . uniqid() . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/teaching_studios/' . $cover_name);
            $teachingStudio->cover = 'teaching_studios/' . $cover_name;
            $input['imagename'] = "cover-" . uniqid() . '.' . $cover->getClientOriginalExtension();
            $teachingStudio->original_cover = 'teaching_studios/' . $input['imagename'];
            $completePath = 'public/images/teaching_studios/' . $input['imagename'];
            addMedia($completePath, 'image', '', $cover);
            $cover->move($destinationPath, $input['imagename']);
            if (File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if (File::exists($old_cover)) {
                File::delete($old_cover);
            }
        } else {
            if ($request->image_croped) {
                $destinationPath = public_path('../public/images/teaching_studios');
                $cover_name = "cover-" . uniqid() . ".png";
                Image::make(file_get_contents($request->image_croped))->save('public/images/teaching_studios/' . $cover_name);
                $teachingStudio->cover = 'teaching_studios/' . $cover_name;

                if (File::exists($old_cover)) {
                    File::delete($old_cover);
                }
            }
        }

        //remove cover pic from server & DB
        $cov_is_delete = $request['cov_del_flag'];
        if ($cov_is_delete == 1) {
            $teachingStudio->cover = NULL;
            $teachingStudio->original_cover = NULL;
            if (File::exists($old_original_cover)) {
                File::delete($old_original_cover);
            }
            if (File::exists($old_cover)) {
                File::delete($old_cover);
            }
        }
        $teachingStudio->save();
        $request['categories'] = explode(',', $request['categories']);
        SelectedTeachingStudioCategory::where('teaching_studio_id', $teachingStudio->id)->delete();
        foreach ($request['categories'] as $category) {
            $selectedStudioCategory = new SelectedTeachingStudioCategory();
            $selectedStudioCategory->teaching_studio_id = $teachingStudio->id;
            $selectedStudioCategory->studio_category_id = $category;
            $selectedStudioCategory->save();
        }
        $gender = $teachingStudio->user->gender;
        if ($gender == 'male') {
            $gender = 'his';
        } else {
            $gender = 'her';
        }
        $notifications = new \Illuminate\Support\Collection();
        if ($request['members']) {
            $members = explode(",", $request['members']);
            foreach ($members as $member) {
                if ($member != $this->userId) {
                    $teachingStudioMember = new TeachingStudioMember();
                    $teachingStudioMember->user_id = $member;
                    $teachingStudioMember->teaching_studio_id = $teachingStudio->id;
                    $teachingStudioMember->save();
                    $notification = addNotificationThenGet($member, 'You are invited to join a studio', 'invited you to join ' . $gender . ' studio "' . $teachingStudio->name . '"', 'teaching_studio', 'TeachingStudio', $teachingStudio->id, 'studio' . $teachingStudio->id . '_invite_request_by_musician' . $this->userId . '_to_user' . $member);
                    $notification->is_studio_invite = 1;
                    $notification->is_studio_request_response = 1;
                    $notification->save();
                    $notifications->push($notification);
                }
            }
        }
        if (isset($request['gallery_images'])) {
            if ($request->hasfile('gallery_images')) {
                if ($galleryImages = $request->file('gallery_images')) {
                    foreach ($galleryImages as $galleryImage) {
                        $teachingStudioImage = new TeachingStudioImage();
                        $input['imagename'] = uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                        $destinationPath = public_path('../public/images/teaching_studios');
                        $teachingStudioImage->file = 'teaching_studios/' . $input['imagename'];
                        $teachingStudioImage->teaching_studio_id = $teachingStudio->id;
                        $teachingStudioImage->save();
                        $completePath = 'public/images/teaching_studios/' . $input['imagename'];
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
                        $oldEducationData = TeachingStudioEducation::find($education['education_id']);
                        $oldEducationData->title = $education['title'];
                        $oldEducationData->institute_name = $education['institute_name'];
                        $oldEducationData->start_year = $education['start_year'];
                        $oldEducationData->end_year = $education['end_year'];
                        $oldEducationData->save();
                    } else {
                        $studioEducation = new TeachingStudioEducation();
                        $studioEducation->title = $education['title'];
                        $studioEducation->institute_name = $education['institute_name'];
                        $studioEducation->start_year = $education['start_year'];
                        $studioEducation->end_year = $education['end_year'];
                        $studioEducation->teaching_studio_id = $teachingStudio->id;
                        $studioEducation->save();
                    }
                }
            }
        }
        if ($request['experience']) {
            foreach ($request['experience'] as $experience) {
                if ($experience) {
                    if (isset($experience['experience_id'])) {
                        $oldExperienceData = TeachingStudioExperience::find($experience['experience_id']);
                        $oldExperienceData->title = $experience['title'];
                        $oldExperienceData->institute_name = $experience['institute_name'];
                        $oldExperienceData->start_year = $experience['start_year'];
                        $oldExperienceData->end_year = $experience['end_year'];
                        $oldExperienceData->save();
                    } else {
                        $studioExperience = new TeachingStudioExperience();
                        $studioExperience->title = $experience['title'];
                        $studioExperience->institute_name = $experience['institute_name'];
                        $studioExperience->start_year = $experience['start_year'];
                        $studioExperience->end_year = $experience['end_year'];
                        $studioExperience->teaching_studio_id = $teachingStudio->id;
                        $studioExperience->save();
                    }
                }
            }
        }

        return response()->json(array('success' => 'Studio updated successfully', 'studio_name' => $teachingStudio->name, 'notifications' => $notifications));
//        Session::flash('success', 'TeachingStudio created successfully.');
//        return Redirect::to(URL::previous());
    }

    function removeTeachingStudioEducation(Request $request) {
        TeachingStudioEducation::where(['teaching_studio_id' => $request['teaching_studio_id'], 'id' => $request['education_id']])->delete();
    }

    function removeTeachingStudioExperience(Request $request) {
        TeachingStudioExperience::where(['teaching_studio_id' => $request['teaching_studio_id'], 'id' => $request['experience_id']])->delete();
    }

    function teachingStudios() {
        $data['title'] = 'Musician | Teaching Studios';
        return view('user.teaching_studios', $data);
    }

    function fetchTeachingStudios(Request $request) {
//        dd($request->all());
        if ($request['type'] == 'owned') {
            $data['teachingStudios'] = TeachingStudio::where('admin_id', $this->userId)
                    ->take($request->take)
                    ->skip($request->skip)
                    ->get();
        } else if ($request['type'] == 'joined') {
            $teachingStudioIds = TeachingStudioMember::where(['user_id' => $this->userId, 'is_approved' => 1])->select('teaching_studio_id')->get()->toArray();
            $data['teachingStudios'] = TeachingStudio::whereIn('id', $teachingStudioIds)
                    ->take($request->take)
                    ->skip($request->skip)
                    ->get();
        }
        return view('user.loader.teaching_studio_loader', $data);
    }

    function deleteTeachingStudio(Request $request) {
        $teachingStudio = TeachingStudio::where(['id' => $request->teaching_studio_id, 'admin_id' => $this->userId])->first();
        if ($teachingStudio) {
            deleteNotification('teaching_studio', $request->teaching_studio_id);
            $teachingStudio->delete();
            return response()->json(array('success' => 'Teaching studio delete successfully.'));
        }
        return response()->json(array('error' => 'Teaching studio not found.'));
    }

    function removeMemberFromTeachingStudio(Request $request) {
        $teachingStudioMember = TeachingStudioMember::where(['user_id' => $request->teaching_studio_member_user_id, 'teaching_studio_id' => $request->teaching_studio_id])->first();
        if ($teachingStudioMember) {
            $teachingStudioMember->delete();
            return response()->json(array('success' => 'Teaching studio member removed successfully.'));
        }
        return response()->json(array('error' => 'Teaching studio member not found.'));
    }

    function deleteTeachingStudioImage(Request $request) {
        $image = TeachingStudioImage::where('id', $request->teaching_studio_image_id)->first();
        if ($image) {
            $image->delete();
            return response()->json(array('success' => 'TeachingStudio image deleted successfully.'));
        }
        return response()->json(array('error' => 'TeachingStudio image not found.'));
    }

    function joinStudio(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        $receiver_id = $studio->admin_id;
        if ($studio) {
            if ($request['status'] == 'leave' || $request['status'] == 'requested') {
                TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $this->userId])->delete();
                Notification::where([
                    'user_id' => $this->userId,
                    'type' => 'teaching_studio',
                    'type_id' => $studio->id,
                    'unique_text' => 'teaching_studio' . $studio->id . '_joined_by' . $this->userId
                ])->delete();
                return response()->json(array('success' => 'Studio leaved successfully.', 'status' => 'leaved'));
            } else if ($request['status'] == 'join') {
                $studioMember = new TeachingStudioMember();
                $studioMember->user_id = $this->userId;
                $studioMember->user_type = 'user';
                $studioMember->teaching_studio_id = $request['studio_id'];
                $studioMember->save();
                $notification = addNotificationThenGet($studioMember->getTeachingStudio->admin_id, 'You are joining teaching studio', 'wants to join your teaching studio "' . $studio->name . '"', 'teaching_studio', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . '_joined_by' . $this->userId);
                return response()->json(array('success' => 'Teaching studio joined successfully', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }

    function joinStudioMember(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        $type = $request['type'];

        $receiver_id = $studio->admin_id;
        if ($studio) {
            if ($request['status'] == 'leave' || $request['status'] == 'requested' || $request['status'] == 'cancel') {
                TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $this->userId])->delete();
                Notification::where([
                    'user_id' => $this->userId,
                    'type' => 'teaching_studio',
                    'type_id' => $studio->id,
                    'unique_text' => 'teaching_studio' . $studio->id . '_joined_by' . $this->userId
                ])->delete();
                return response()->json(array('success' => 'Studio leaved successfully.', 'status' => 'leaved'));
            } else if ($request['status'] == 'join') {
                $studioMember = new TeachingStudioMember();
                $studioMember->user_id = $this->userId;
                $studioMember->user_type = $type;
                $studioMember->teaching_studio_id = $request['studio_id'];
                $studioMember->save();
                $notification = addNotificationThenGet($studioMember->getTeachingStudio->admin_id, 'You are joining teaching studio', 'wants to join your teaching studio "' . $studio->name . '" as a ' . $type, 'teaching_studio', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . '_joined_by' . $this->userId);
                return response()->json(array('success' => 'Teaching studio joined successfully', 'status' => 'requested', 'notification' => $notification));
            }
        }
    }

    function referTeacherToJoinStudio(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        $studio_type = $request['studio_type'];
        $receiver_id = $studio->admin_id;
        $member_ids_string = ($request->member_ids);
        $member_ids = explode(',', $member_ids_string);
        $notification = [];

        if ((!empty($member_ids)) && (!empty($studio))) {
            foreach ($member_ids as $key => $member_id) {
                $studioMember = new TeachingStudioMember();
                $studioMember->user_id = $member_id;
                $studioMember->user_type = 'teachere';
                if ($this->userId == $studio->admin_id) {
                    $studioMember->is_approved = 1;
                }
                $studioMember->teaching_studio_id = $request['studio_id'];
                $studioMember->save();
                $user = User::select('id', 'first_name', 'last_name', 'photo')->findOrFail($member_id);

                if ($this->userId != $studio->admin_id) {
                    $notification[$key]['notification_for_admin'] = addNotificationForStudioAdminThenGet($studioMember->getTeachingStudio->admin_id, 'You are joining teaching studio', 'wants to join your teaching studio "' . $studio->name . '" as a Teacher, refer by ' . $this->userName . ' ' . $this->userLastName, 'teachere', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . '_refer_to' . $user->id . '_by' . $this->userId, $user);
                } else {
                    $notificationsave = addNotificationThenGet($member_id, 'You are added to the Teaching Studio', 'added you to the Teaching Studio "' . $studio->name . '" as a Teacher', 'teachere', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . 'added_' . $member_id . 'by_' . $this->userId);
                    $notificationsave->left_notification = 1;
                    $notificationsave->save();
                    $notification[$key]['notification_for_admin'] = $notificationsave;
                }
                
                $notification[$key]['refer_user_id'] = $user->id;
                $notification[$key]['user_fname'] = $user->first_name;
                $notification[$key]['user_lname'] = $user->last_name;
                $notification[$key]['user_photo'] = $user->photo;
            }
            return response()->json(array('success' => 'Teaching studio joined successfully', 'error' => '', 'user' => $user, 'notification' => $notification));
        } else {
            return response()->json(array('success' => '', 'error' => 'Something went wrong', 'user' => '', 'notification' => ''));
        }
    }

    function referStudentToJoinStudio(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        $studio_type = $request['studio_type'];
        $receiver_id = $studio->admin_id;
        $member_ids_string = ($request->member_ids);
        $member_ids = explode(',', $member_ids_string);
        $notification = [];

        if ((!empty($member_ids)) && (!empty($studio))) {
            foreach ($member_ids as $key => $member_id) {
                $studioMember = new TeachingStudioMember();
                $studioMember->user_id = $member_id;
                $studioMember->user_type = $studio_type;
                if ($this->userId == $studio->admin_id) {
                    $studioMember->is_approved = 1;
                }
                $studioMember->teaching_studio_id = $request['studio_id'];
                $studioMember->save();
                $user = User::select('id', 'first_name', 'last_name', 'photo')->findOrFail($member_id);
                
                if ($this->userId != $studio->admin_id) {
                    $notification[$key]['notification_for_admin'] = addNotificationForStudioAdminThenGet($studioMember->getTeachingStudio->admin_id, 'You are joining teaching studio', 'wants to join your teaching studio "' . $studio->name . '" as a Student, refer by ' . $this->userName . ' ' . $this->userLastName, 'user', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . '_refer_to' . $user->id . '_by' . $this->userId, $user);
                } else {
                    $notificationsave = addNotificationThenGet($member_id, 'You are added to the Teaching Studio', 'added you to the Teaching Studio "' . $studio->name . '"', 'user', 'TeachingStudio', $studio->id, 'teaching_studio' . $studio->id . 'added_' . $member_id . 'by_' . $this->userId);
                    $notificationsave->left_notification = 1;
                    $notificationsave->save();
                    $notification[$key]['notification_for_admin'] = $notificationsave;
                }
                $notification[$key]['refer_user_id'] = $user->id;
                $notification[$key]['user_fname'] = $user->first_name;
                $notification[$key]['user_lname'] = $user->last_name;
                $notification[$key]['user_photo'] = $user->photo;
            }
            return response()->json(array('success' => 'Teaching studio joined successfully', 'error' => '', 'user' => $user, 'notification' => $notification));
        } else {
            return response()->json(array('success' => '', 'error' => 'Something went wrong', 'user' => '', 'notification' => ''));
        }
    }

    function joinStudioResponse(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        if ($studio) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_studio_admin_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $studioMember = TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $request['user_id']])->first();
                TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $request['user_id']])->delete();
//                $studioMember->is_rejected = 1;
//                $studioMember->is_approved = 0;
//                $studioMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You requested to join the studio', 'rejected your request to join studio "' . $studio->name . '"', 'teaching_studio', 'TeachingStudio', $studio->id, 'studio' . $studio->id . '_response_for' . $receiver_id);
                $notification->is_studio_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Studio joining request rejected.', 'status' => 'rejected', 'notification' => $notification, 'type' => $studioMember->user_type,));
            } else if ($request['status'] == 'approve') {
                $user_img = User::find($request['user_id']);
                $studioMember = TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $request['user_id']])->first();
                $studioMember->is_approved = 1;
                $studioMember->is_rejected = 0;
                $studioMember->save();
                $notification = addNotificationThenGet($receiver_id, 'Studio admin responded to the studio join request', 'accepted your request to join studio "' . $studio->name . '"', 'teaching_studio', 'TeachingStudio', $studio->id, 'studio' . $studio->id . '_response_for' . $receiver_id);
                $notification->is_studio_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Studio joining request approved.', 'status' => 'approved', 'notification' => $notification, 'type' => $studioMember->user_type, 'photo' => $user_img->photo));
            }
        }
    }

    function inviteStudioResponse(Request $request) {
        $studio = TeachingStudio::find($request['studio_id']);
        $studioMember = TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $this->userId])->first();
        if ($studio) {
            $notification = Notification::where('unique_text', $request['unique_text'])->first();
            $notification->is_studio_invitee_responded = 1;
            $notification->save();
            $receiver_id = $notification->user_id;
            if ($request['status'] == 'reject') {
                $studioMember = TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $this->userId])->delete();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the studio', 'rejected your invitation to join studio "' . $studio->name . '"', 'teaching_studio', 'TeachingStudio', $studio->id, 'studio' . $studio->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_studio_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Studio invitation request rejected.', 'status' => 'rejected', 'notification' => $notification));
            } else if ($request['status'] == 'approve') {
                $studioMember = TeachingStudioMember::where(['teaching_studio_id' => $request['studio_id'], 'user_id' => $this->userId])->first();
                $studioMember->is_approved = 1;
                $studioMember->is_rejected = 0;
                $studioMember->save();
                $notification = addNotificationThenGet($receiver_id, 'You responded to the invite request of the studio', 'accepted your invitation to join studio "' . $studio->name . '"', 'teaching_studio', 'TeachingStudio', $studio->id, 'studio' . $studio->id . '_invitation_response_by' . $request['user_id']);
                $notification->is_studio_request_response = 1;
                $notification->save();
                return response()->json(array('success' => 'Studio invitation request approved.', 'status' => 'approved', 'notification' => $notification));
            }
        }
    }

    function stats($studio_id) {
        $data['title'] = 'Musician |Event Statistics';
        $data['user'] = $this->user;
        $data['studio'] = TeachingStudio::find($studio_id);
        $views_stats_data = [];
        $views_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = ServiceProfileView::where('studio_id', $studio_id)->whereDate('created_at', $date)->count();
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
            $count = FollowServie::where('studio_id', $studio_id)->whereDate('created_at', $date)->count();
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
            $count = Booking::where(['teaching_studio_id' => $studio_id, 'status' => 'payment_approved'])->whereDate('created_at', $date)->count();
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
            $count = Review::where('teaching_studio_id', $studio_id)->whereDate('created_at', $date)->count();
            array_push($reviews_stats_data, $count);
            array_push($reviews_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['reviews_stats_data'] = $reviews_stats_data;
        $data['reviews_stats_labels'] = $reviews_stats_labels;
        return view('user.statistics_studio', $data);
    }

}
