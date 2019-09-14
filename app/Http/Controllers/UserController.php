<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Response;
use Intervention\Image\Facades\Image;
use App\User;
use App\Interest;
use App\UserInterest;
use App\UserEducation;
use App\UserExperiences;
use App\Category;
use App\Affiliation;
use App\UserFollower;
use App\Booking;
use App\Group;
use App\GroupImage;
use App\GroupMember;
use App\Notification;
use App\TeachingStudio;
use App\TeachingStudioImage;
use App\TeachingStudioMember;
use App\Review;
use App\Language;
use App\Union;
use App\GalleryMedia;
use App\Testimonial;
use App\SelectedMusicianCategory;
use Illuminate\Support\Facades\Mail;
use App\IgnoredUser;
use App\Privacysetting;
use App\Emailsetting;
use App\ProfileView;
use App\FollowServie;
use App\FollowInvite;

class UserController extends Controller {

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

    function editUserProfileView() {
        $data['user'] = User::find($this->userId);
        if ($data['user']->type != 'user') {
            return Redirect::to(URL::previous());
        }
        $data['title'] = 'Edit Profile';
        $data['interests'] = Interest::all();
        $data['languages'] = Language::all();
        $interestsIds = UserInterest::select('interest_id')->where('user_id', $this->userId)->get()->toArray();
        $data['interests'] = '';

        $data['selectedInterests'] = '';
        if ($interestsIds == []) {
            $data['interests'] = Interest::all();
        } else {
            $data['interests'] = Interest::whereNotIn('id', $interestsIds)->get();
            $data['selectedInterests'] = Interest::whereIn('id', $interestsIds)->get();
        }
        $data['bookings'] = Booking::where('booked_by', $this->userId)->whereIn('status', ['pending', 'postponed', 'postponed_updated', 'approved', 'payment_requested', 'admin_requested'])->count();
        $data['timezones'] = \App\Timezone::all();
//        dd($interests->count());
        return view('user.edit_user_profile', $data);
    }

    function editUserProfile(Request $request) {
        $validation = $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'language' => 'required',
            'gender' => 'required',
            'email' => 'required',
        ]);
        $user = User::find($this->userId);
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->language = $request['language'];
        $user->gender = $request['gender'];
        $user->description = $request['description'];
        $user->country = $request['country'];
        $user->city = $request['city'];
        $user->address = $request['address'];
        $user->zip_code = $request['zip_code'];
        $user->timezone = $request['timezone'];
        $user->phone = $request['phone'];
        $check_email = User::where('email', $request->email)->where('id', '!=', $this->userId)->first();
        if ($check_email) {
            $user->save();
            Session::flash('error', 'Email Already Taken');
            return Redirect::to(Url::previous());
        }
        $user->email = $request->email;
        $image = $request->file('photo');
        if ($image) {
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/profile_pics');
            $user->photo = 'profile_pics/' . $input['imagename'];
            $completePath = 'public/images/profile_pics/' . $input['imagename'];
            addMedia($completePath, 'image', '', $image);
            $image->move($destinationPath, $input['imagename']);
        }
        $user->save();
        if ($request['interests']) {
            foreach ($request['interests'] as $interestId) {
                $userInterest = new UserInterest();
                $userInterest->user_id = $this->userId;
                $userInterest->interest_id = $interestId;
                $userInterest->save();
            }
        }
        if ($request['education']) {
            foreach ($request['education'] as $education) {
                if ($education) {
                    if (isset($education['education_id'])) {
                        $oldEducationData = UserEducation::find($education['education_id']);
                        $oldEducationData->title = $education['title'];
                        $oldEducationData->institute_name = $education['institute_name'];
                        $oldEducationData->start_year = $education['start_year'];
                        $oldEducationData->end_year = $education['end_year'];
                        $oldEducationData->save();
                    } else {
                        $userEducation = new UserEducation();
                        $userEducation->title = $education['title'];
                        $userEducation->institute_name = $education['institute_name'];
                        $userEducation->start_year = $education['start_year'];
                        $userEducation->end_year = $education['end_year'];
                        $userEducation->user_id = $this->userId;
                        $userEducation->save();
                    }
                }
            }
        }
        if ($request['experience']) {
            foreach ($request['experience'] as $experience) {
                if ($experience) {
                    if (isset($experience['experience_id'])) {
                        $oldExperienceData = UserExperiences::find($experience['experience_id']);
                        $oldExperienceData->title = $experience['title'];
                        $oldExperienceData->institute_name = $experience['institute_name'];
                        $oldExperienceData->start_year = $experience['start_year'];
                        $oldExperienceData->end_year = $experience['end_year'];
                        $oldExperienceData->save();
                    } else {
                        $userExperience = new UserExperiences();
                        $userExperience->title = $experience['title'];
                        $userExperience->institute_name = $experience['institute_name'];
                        $userExperience->start_year = $experience['start_year'];
                        $userExperience->end_year = $experience['end_year'];
                        $userExperience->user_id = $this->userId;
                        $userExperience->save();
                    }
                }
            }
        }
        Session::flash('success', 'Profile updated successfully.');
        return Redirect::to(URL::previous());
    }

    function updatePrivacy(Request $request) {
        $user = $this->user;
        $user->is_private = $request->isprivate;
        $user->save();
    }

    function editMusicianProfileView() {
        $data['title'] = 'Edit Profile';
        $data['user'] = User::find($this->userId);
        $data['email_setting'] = Emailsetting::where('user_id', $this->userId)->first();
        $data['privacy_setting'] = Privacysetting::where('user_id', $this->userId)->first();
        $data['artistTypes'] = Category::where('is_for_musician', 1)->orderBy('title')->get();
        $unionIds = $data['user']->getUnionIdsFromAffiliations->toArray();
        $data['unions'] = Union::whereNotIn('id', $unionIds)->get();
        $data['languages'] = Language::orderBy('name', 'asc')->get();
        $selectedArtistTypeIds = SelectedMusicianCategory::where('artist_id', $this->userId)->pluck('category_id');
        $myArtistTypeIds = [];
        foreach ($selectedArtistTypeIds as $artistTypeId) {
            array_push($myArtistTypeIds, $artistTypeId);
        }
        $data['myArtistTypeIds'] = $myArtistTypeIds;
        $data['genres'] = ['Baroque', 'Classical', 'Jazz', 'Country', 'World', 'Rock', 'Electronic', 'Popular', 'Wedding'];
        if ($data['user']->type != 'artist') {
            return Redirect::to(URL::previous());
        }
        $data['bookings'] = Booking::where('user_id', $this->userId)->whereIn('status', ['pending', 'postponed', 'postponed_updated', 'approved', 'payment_requested', 'admin_requested'])->count();
        return view('user.edit_musician_profile', $data);
    }

    function editMusicianProfile(Request $request) {
        $user = User::find($this->userId);
        if ($request['personal_info'] == 1) {
            $user->first_name = $request['first_name'];
            $user->last_name = $request['last_name'];
            $user->gender = $request['gender'];
            $user->phone = $request['phone'];
            $user->dob = $request['dob'];
            $user->contact_info_privacy = $request['contact_info_privacy'];
            if (isset($request['gigs_availability'])) {
                $user->allow_booking = 1;
            } else {
                $user->allow_booking = 0;
            }
            $check_email = User::where('email', $request->email)->where('id', '!=', $this->userId)->first();
            if ($check_email) {
                $user->save();
                Session::flash('error', 'Email Already Taken');
                return Redirect::to(Url::previous());
            }
            $user->email = $request->email;
            Session::flash('success', 'Profile updated successfully.');
        } else if ($request['edit_info_section'] == 1) {
            SelectedMusicianCategory::where('artist_id', $this->userId)->delete();
            foreach ($request['artist_type_id'] as $artistTypeIds) {
                $selectedArtistType = new SelectedMusicianCategory();
                $selectedArtistType->artist_id = $this->userId;
                $selectedArtistType->category_id = $artistTypeIds;
                $selectedArtistType->save();
            }
            $user->since = $request['since'];
            $user->genre = $request['genre'];
            $user->address = $request['address'];
            $user->language = $request['language'];
            Session::flash('success', 'Info section updated successfully.');
        } else if ($request['edit_description_info'] == 1) {
            $user->description = $request['description'];
            Session::flash('success', 'Description updated successfully.');
        } else if ($request['education_info'] == 1) {
            if (isset($request['education_id'])) {
                $oldEducationData = UserEducation::where(['id' => $request['education_id'], 'user_id' => $this->userId])->first();
                $oldEducationData->title = $request['title'];
                $oldEducationData->institute_name = $request['institute_name'];
                $oldEducationData->start_year = $request['start_year'];
                $oldEducationData->end_year = $request['end_year'];
                $oldEducationData->save();
            } else {
                $userEducation = new UserEducation();
                $userEducation->title = $request['title'];
                $userEducation->institute_name = $request['institute_name'];
                $userEducation->start_year = $request['start_year'];
                $userEducation->end_year = $request['end_year'];
                $userEducation->user_id = $this->userId;
                $userEducation->save();
            }
            Session::flash('success', 'Education info updated successfully.');
        } else if ($request['experience_info'] == 1) {
            if (isset($request['experience_id'])) {
                $oldExperienceData = UserExperiences::where(['id' => $request['experience_id'], 'user_id' => $this->userId])->first();
                $oldExperienceData->title = $request['title'];
                $oldExperienceData->institute_name = $request['institute_name'];
                $oldExperienceData->start_year = $request['start_year'];
                $oldExperienceData->end_year = $request['end_year'];
                $oldExperienceData->save();
            } else {
                $userExperience = new UserExperiences();
                $userExperience->title = $request['title'];
                $userExperience->institute_name = $request['institute_name'];
                $userExperience->start_year = $request['start_year'];
                $userExperience->end_year = $request['end_year'];
                $userExperience->user_id = $this->userId;
                $userExperience->save();
            }
            Session::flash('success', 'Experience info updated successfully.');
        } else if ($request['affiliation_info'] == 1) {
            if (isset($request['affiliation_id'])) {
                Affiliation::where(['id' => $request['affiliation_id'], 'user_id' => $this->userId])->delete();
            }
            $newAffiliation = new Affiliation();
            $newAffiliation->union_id = $request['union_id'];
            $newAffiliation->user_id = $this->userId;
            $newAffiliation->save();

            Session::flash('success', 'Affiliation info updated successfully.');
        }
        $user->save();
//        dd($user);
        return Redirect::to(URL::previous());
    }

    function deleteMusicianEducation(Request $request) {
        $edu = UserEducation::where(['user_id' => $this->userId, 'id' => $request['education_id']])->delete();
        if ($edu) {
            Session::flash('success', 'Education deleted successfully.');
        }
        return Redirect::to(URL::previous());
    }

    function deleteMusicianExperience(Request $request) {
        $experience = UserExperiences::where(['user_id' => $this->userId, 'id' => $request['experience_id']])->delete();
        if ($experience) {
            Session::flash('success', 'Experience deleted successfully.');
        }
        return Redirect::to(URL::previous());
    }

    function deleteMusicianAffiliation(Request $request) {
        $affiliation = Affiliation::where(['user_id' => $this->userId, 'id' => $request['affiliation_id']])->delete();
        if ($affiliation) {
            Session::flash('success', 'Affiliation deleted successfully.');
        }
        return Redirect::to(URL::previous());
    }

    function changePassword(Request $request) {
        $validation = $this->validate($request, [
            'current_password' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);
        $password = $this->user->password;
        if (Hash::check($request['current_password'], $password)) {
            $newpass = Hash::make($request['password']);
            User::where('id', $this->userId)->update(['password' => $newpass]);
            Session::flash('success', 'Password Updated successfully');
            return Redirect::to(URL::previous());
        } else {
            Session::flash('error', 'Invalid Old Password');
            return Redirect::to(URL::previous());
        }
    }

    function removeUserInterest(Request $request) {
        $interest = Interest::find($request['interest_id']);
        UserInterest::where(['user_id' => $this->userId, 'interest_id' => $request['interest_id']])->delete();
        return response()->json($interest);
    }

    function removeUserEducation(Request $request) {
        UserEducation::where(['id' => $request['education_id'], 'user_id' => $this->userId])->delete();
    }

    function removeUserExperience(Request $request) {
        UserExperiences::where(['id' => $request['experience_id'], 'user_id' => $this->userId])->delete();
    }

    function deleteUserProfilePic(Request $request) {
        User::where('id', $request['user_id'])->update(['photo' => '']);
    }

    function deleteUserCoverPic(Request $request) {
        User::where('id', $request['user_id'])->update(['cover_photo' => '']);
    }

    function uploadProfilePic(Request $request) {
        $user = $this->user;
        $image = $request->photo;
        if ($image) {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            $destinationPath = public_path('../public/images/profile_pics');
            $user->photo = 'profile_pics/' . $image_name;
            $user->original_photo = $request->original_photo;
            $completePath = 'public/images/profile_pics/' . $image_name;
            addMediaForBase64Images($completePath, 'image', '', $request->photo);
            \File::put($destinationPath . '/' . $image_name, base64_decode($image));
        }
        $user->save();
        return response()->json('Profile pic successfully uploaded.');
    }

    function uploadServiceProfilePic(Request $request) {
        $user = $this->user;
        $image = $request->photo;
        if ($image) {
            $image = str_replace('data:image/png;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $image_name = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
            if ($request->pic_type == 'gig_pic') {
                $destinationPath = public_path('../uploads/events');
                $db_name = asset('uploads/events/' . $image_name);
            } else if ($request->pic_type == 'group_pic') {
                $destinationPath = public_path('../public/images/groups');
                $db_name = 'groups/' . $image_name;
            } else if ($request->pic_type == 'studio_pic') {
                $destinationPath = public_path('../public/images/teaching_studios');
                $db_name = 'teaching_studios/' . $image_name;
            } else if ($request->pic_type == 'accompanist_pic') {
                $destinationPath = public_path('../public/images/accompanists');
                $db_name = 'accompanists/' . $image_name;
            }
            if ($destinationPath && $db_name) {
                \File::put($destinationPath . '/' . $image_name, base64_decode($image));
                return response()->json(['success' => 1, 'photo' => $db_name]);
            }
        }
        return response()->json(['error' => 1]);
    }

    function saveOriginalProfilePic(Request $request) {
        $image = $request->file('photo');
        $input['imagename'] = substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . $image->getClientOriginalExtension();
        $destinationPath = '';
        $db_name = '';
        if ($request->pic_type == 'profile_pic') {
            $destinationPath = public_path('../public/images/profile_pics');
            $db_name = 'profile_pics/' . $input['imagename'];
        } else if ($request->pic_type == 'gig_pic') {
            $destinationPath = public_path('../uploads/events');
            $db_name = asset('uploads/events/' . $input['imagename']);
        } else if ($request->pic_type == 'group_pic') {
            $destinationPath = public_path('../public/images/groups');
            $db_name = 'groups/' . $input['imagename'];
        } else if ($request->pic_type == 'studio_pic') {
            $destinationPath = public_path('../public/images/teaching_studios');
            $db_name = 'teaching_studios/' . $input['imagename'];
        } else if ($request->pic_type == 'accompanist_pic') {
            $destinationPath = public_path('../public/images/accompanists');
            $db_name = 'accompanists/' . $input['imagename'];
        }
        if ($destinationPath && $db_name) {
            $image->move($destinationPath, $input['imagename']);
            return response()->json(['success' => 1, 'photo' => $db_name]);
        }
        return response()->json(['error' => 1]);
    }

    function uploadCoverPic(Request $request) {
        $user = $this->user;
        $image = $request->file('photo');
        if ($image) {
            $input['imagename'] = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('../public/images/profile_pics');
            $user->cover_photo = 'profile_pics/' . $input['imagename'];
            $completePath = 'public/images/profile_pics/' . $input['imagename'];
            addMedia($completePath, 'image', '', $image);
            $image->move($destinationPath, $input['imagename']);
        }
        $user->save();
        return response()->json('Cover pic successfully uploaded.');
    }

    function getAllMembers() {
        $term = $_GET['term'];
        if ($_GET['ids']) {
//            dd($_GET['ids']);
            $ids = json_decode($_GET['ids']);
            if (!$term) {
                $members = User::where('type', 'artist')
                                ->whereNotIn('id', $ids)
                                ->select('id', 'first_name', 'last_name', 'email', 'photo')->get();
            } else {
                $members = User::where('type', 'artist')
                                ->where(function($q) use($term) {
                                    $q->where('first_name', 'like', '%' . $term . '%')
                                    ->orWhere('last_name', 'like', '%' . $term . '%');
                                })
                                ->whereNotIn('id', $ids)
                                ->select('id', 'first_name', 'last_name', 'email', 'photo')->get();
            }
        } else {
            if (!$term) {
                $members = User::where('type', 'artist')
                                ->select('id', 'first_name', 'last_name', 'email', 'photo')->get();
            } else {
                $members = User::where('type', 'artist')
                                ->where(function($q) use($term) {
                                    $q->where('first_name', 'like', '%' . $term . '%')
                                    ->orWhere('last_name', 'like', '%' . $term . '%');
                                })
                                ->select('id', 'first_name', 'last_name', 'email', 'photo')->get();
            }
        }
        echo json_encode($members);
    }

    function ignoreUser(Request $request) {
        $check_ignored = IgnoredUser::where(array('blocked_id' => $request->other_id, 'user_id' => $this->userId))->first();
        if (!$check_ignored) {
            $add_ignore = new IgnoredUser;
            $add_ignore->blocked_id = $request->other_id;
            $add_ignore->user_id = $this->userId;
            $add_ignore->save();
        }
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        return view('user.suggestions_ajax', $data);
    }

    function unfollowUser(Request $request) {
        UserFollower::where(array('user_id' => $request->other_id, 'followed_by' => $this->userId))->delete();
//        Notification::where('user_id', $this->userId)->where('on_user', $request->other_id)->where('type', 'follow')->delete();
        return response()->json('Unfollowed Successfully.');
    }

    function followUser(Request $request) {
        $check_user = UserFollower::where(array('user_id' => $request->other_id, 'followed_by' => $this->userId))->first();
        if (!$check_user) {
            $add_follow = new UserFollower;
            $add_follow->user_id = $request->other_id;
            $add_follow->followed_by = $this->userId;
            $add_follow->save();
        }
        $other_user = Emailsetting::where('user_id', $request->other_id)->first();
        $other_user_detail = User::where('id', $request->other_id)->first();
        if ($other_user && $other_user->on_follow) {
            $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
            $viewData['othrername'] = $other_user_detail->first_name . ' ' . $other_user_detail->last_name;
            Mail::send('emails.follow_email', $viewData, function ($m) use ($other_user_detail) {
                $m->from(env('FROM_EMAIL'), 'Musician App');
                $m->to($other_user_detail->email, $other_user_detail->first_name)->subject('Follow Email');
            });
        }
        $notification = addNotificationThenGet($request->other_id, 'You started following user' . $request->other_id, 'started following you', 'follow', 'User', $this->userId, 'user' . $request->other_id . '_followed_by_user' . $this->userId);
        $data['current_photo'] = getUserImage($this->user->photo, $this->user->social_photo, $this->user->gender);
        $notification->view_data = view('user.suggestions_ajax', $data)->render();
        return response()->json(['message' => 'success', 'notification' => $notification], 200);
    }

    function postReview(Request $request) {
        $validation = $this->validate($request, [
            'user_id' => 'required',
//            'booking_id' => 'required',
//            'rating' => 'required',
            'review' => 'required'
        ]);
        if ($request['review']) {
            if (searchForVulgarTerms($request['review'])) {
                return Response::json(['error' => 1]);
            }
        }
        $review = new Review();
        $review->review = $request['review'];
        $review->type = $request['type'];
        $notification = '';
        if ($request['type'] == 'review') {
            $review->rating = $request['rating'];
            $review->gig_type = $request['gig_type'];

            $dataToRate = '';

            if ($request['gig_type'] == 'gig') {
                $review->gig_id = $request['gig_type_id'];
                $dataToRate = \App\PostEvent::find($request['gig_type_id']);
            } else if ($request['gig_type'] == 'group') {
                $review->group_id = $request['gig_type_id'];
                $dataToRate = Group::find($request['gig_type_id']);
            } else if ($request['gig_type'] == 'teaching_studio') {
                $review->teaching_studio_id = $request['gig_type_id'];
                $dataToRate = TeachingStudio::find($request['gig_type_id']);
            } else if ($request['gig_type'] == 'accompanist') {
                $review->accompanist_id = $request['gig_type_id'];
                $dataToRate = \App\Accompanist::find($request['gig_type_id']);
            }

            $review->user_id = $request['user_id'];
            $review->reviewed_by = $this->userId;
            $review->save();

            $booking = \App\Booking::find($request['booking_id']);
            $booking->is_reviewed = 1;
            $booking->save();

            $totalRatings = 0;
            $reviewsCount = 0;
            $rating = 0;
            if (!$dataToRate->getReviews->isEmpty()) {
                $reviewsCount = $dataToRate->getReviews->count();
                foreach ($dataToRate->getReviews as $reviewData) {
                    $totalRatings = $totalRatings + $reviewData->rating;
                }
            }
            $ratingPercentage = 0;
            if ($reviewsCount > 0) {
                $ratingPercentage = ($totalRatings / ($reviewsCount * 5)) * (100);
                $rating = ($ratingPercentage * 5) / 100;
            }
            if ($rating && $ratingPercentage && $reviewsCount) {
                $rating = number_format((float) $rating, 1, '.', '');
                $explodeRating = explode(".", $rating);
                if (!$explodeRating[1]) {
                    $rating = $explodeRating[0];
                }
                $ratingPercentage = number_format((float) $ratingPercentage, 2, '.', '');
            }
            $dataToRate->rating = $rating;
            $dataToRate->rating_percentage = $ratingPercentage;
            $dataToRate->number_of_reviews = $reviewsCount;
            $dataToRate->save();
            $gig_type = str_replace(' ', '_', $request['gig_type']);
        }

        $review->user_id = $request['user_id'];
        $review->reviewed_by = $this->userId;
        $review->save();

        if ($request['type'] == 'review') {
            $notification = addNotificationThenGet($review->user_id, 'You reviewed a musician', 'entered a review on your ' . $request['gig_type'], 'review', 'Review', $review->id, 'review' . $review->id . '_to_' . $request['gig_type'] . $request['gig_type_id'] . '_by_user' . $review->reviewed_by);
        } else {
            $notification = addNotificationThenGet($review->user_id, 'You reviewed a musician', 'entered a review on your profile', 'review', 'Review', $review->id, 'review' . $review->id . '_to_musician' . $review->user_id . '_by_user' . $review->reviewed_by);
        }

        Session::flash('success', 'Review Posted successfully.');
        return response()->json(['status' => 'success', 'notification' => $notification], 200);
    }

    function postTestimonial(Request $request) {
        $validation = $this->validate($request, [
            'user_id' => 'required',
            'review' => 'required'
        ]);
        $review = new Testimonial();
        $review->review = $request['review'];
        $review->user_id = $request['user_id'];
        $review->reviewed_by = $this->userId;
        $review->save();
        Session::flash('success', 'Review Posted successfully.');
//        return Redirect::to('profile_reviews/'.$request['user_id']);
        $notification = addNotificationThenGet($review->user_id, 'You reviewed a musician', 'entered a review on your profile', 'review', 'Review', $review->id, 'review' . $review->id . '_to_musician' . $review->user_id . '_by_user' . $review->reviewed_by);
        return response()->json(['status' => 'success', 'notification' => $notification], 200);
    }

    function reviews() {
        $data['reviews'] = Review::where('user_id', $this->userId)->get();
        $data['title'] = 'Musician | Reviews';
        return view('user.reviews', $data);
    }

    function fetchReviews(Request $request) {
        $data['current_id'] = Auth::user()->id;
        $data['reviews'] = Review::where('user_id', $this->userId)
                ->orderByDesc('updated_at')
                ->skip($request->skip)
                ->take($request->take)
                ->get();
        Review::where('user_id', $this->userId)
                ->orderByDesc('updated_at')
                ->skip($request->skip)
                ->take($request->take)
                ->update(['is_viewed' => 1]);
        return view('user.loader.reviews_loader', $data);
    }

    function deleteReview(Request $request) {
        deleteNotification('review', $request['review_id']);
        if (Review::where(['id' => $request['review_id'], 'reviewed_by' => $this->userId])->delete()) {
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'error'], 200);
        }
    }

    function deleteGalleryMedia(Request $request) {
        GalleryMedia::where('id', $request['id'])->delete();
    }

    function statistics() {
        $data['title'] = 'Musician | Statistics';
        $data['user'] = $this->user;

        $views_stats_data = [];
        $views_stats_labels = [];
        $date = date('Y-m-d', strtotime('-11 days', strtotime(date('Y-m-d'))));
        while (true) {
            if (strtotime($date) > strtotime(date('d-m-Y'))) {
                break;
            }
            $count = ProfileView::where('profile_viewed', $this->userId)->whereDate('created_at', $date)->count();
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
            $count = UserFollower::where('user_id', $this->userId)->whereDate('created_at', $date)->count();
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
            $count = Booking::where(['user_id' => $this->userId, 'status' => 'payment_approved'])->whereDate('created_at', $date)->count();
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
            $count = Review::where('user_id', $this->userId)->whereDate('created_at', $date)->count();
            array_push($reviews_stats_data, $count);
            array_push($reviews_stats_labels, date('M j', strtotime($date)));
            $date = date('Y-m-d', strtotime('+1 days', strtotime($date)));
        }
        $data['reviews_stats_data'] = $reviews_stats_data;
        $data['reviews_stats_labels'] = $reviews_stats_labels;

        return view('user.statistics', $data);
    }

    function sendInvititaionMail(Request $request) {
        $email = $request->email;
        $check_user = User::where('email', $email)->first();
        if ($check_user) {
            echo FALSE;
        } else {
            $viewData['name'] = $this->user->first_name . ' ' . $this->user->last_name;
            Mail::send('emails.invitation_email', $viewData, function ($m) use ($email) {
                $m->from(env('FROM_EMAIL'), 'Musician App');
                $m->to($email, '')->subject('Invitation Email');
            });
            echo TRUE;
        }
    }

    function deactiveAccount() {
        $user = $this->user;
        $user->is_active = 0;
        $user->is_online = 0;
        $user->save();
        Auth::guard('user')->logout();
        return Redirect::to('/');
    }

    function addPrivacySetting(Request $request) {
        $col = $request->col;
        $val = $request->col_val;
        $check_privacy = Privacysetting::where('user_id', $this->userId)->first();
        if (!$check_privacy) {
            $check_privacy = new Privacysetting;
        }
        $check_privacy->$col = $val;
        $check_privacy->save();
    }

    function addEmailSetting(Request $request) {
        $col = $request->col;
        $val = $request->col_val;
        $table = $request->table;

        $check_email = Emailsetting::where('user_id', $this->userId)->first();
        if ($table == 'Privacysetting') {
            $check_email = Privacysetting::where('user_id', $this->userId)->first();
        }
        if (!$check_email) {
            $check_email = new Emailsetting;
            if ($table == 'Privacysetting') {
                $check_email = new Privacysetting;
            }
            $check_email->user_id = $this->userId;
        }
        $check_email->$col = $val;
        $check_email->save();
    }

    function updateCover(Request $request) {

        $user = User::find($this->userId);
        if ($request['image_croped']) {
            $cover_name = "cover-" . substr(md5(uniqid(mt_rand(), true)), 0, 16) . ".png";
            Image::make(file_get_contents($request->image_croped))->save('public/images/profile_pics/' . $cover_name);
            $user->cover_photo = 'profile_pics/' . $cover_name;
            if ($request->hasFile('cover')) {
                $photo_name = "cover-" . substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . $request->cover->getClientOriginalExtension();
                addMedia('public/images/profile_pics/' . $photo_name, 'image', '', $request['cover']);
                $request->cover->move('public/images/profile_pics/', $photo_name);
                $user->original_cover_photo = 'profile_pics/' . $photo_name;
            }
            $user->save();
        }
        return Redirect::to(URL::previous());
    }

    function followService(Request $request) {
        $type = $request->type;
        if ($type == 'g') {
            $check_service = FollowServie::where(array('user_id' => $this->userId, 'post_type' => 'g', 'group_id' => $request->type_id))->first();
            if (!$check_service) {
                $add_service = new FollowServie;
                $add_service->user_id = $this->userId;
                $add_service->post_type = 'g';
                $add_service->group_id = $request->type_id;
                $add_service->save();
                addNotificationThenGet($request->other_id, 'follow the event', 'started following your event', 'group', 'Group', $request->type_id, 'event' . $request->type_id . '_followed_by_' . $this->userId . '_on_event' . $request->type_id);
            }
        }
        if ($type == 's') {
            $check_service = FollowServie::where(array('user_id' => $this->userId, 'post_type' => 's', 'studio_id' => $request->type_id))->first();
            if (!$check_service) {
                $add_service = new FollowServie;
                $add_service->user_id = $this->userId;
                $add_service->post_type = 's';
                $add_service->studio_id = $request->type_id;
                $add_service->save();
                addNotificationThenGet($request->other_id, 'Followed to teaching studio', 'started following your teaching studio', 'teaching_studio', 'TeachingStudio', $request->type_id, 'teaching_studio' . $request->type_id . '_followed_by_' . $this->userId . '_on_studio' . $request->type_id);
            }
        }
        if ($type == 'a') {
            $check_service = FollowServie::where(array('user_id' => $this->userId, 'post_type' => 'a', 'accompanist_id' => $request->type_id))->first();
            if (!$check_service) {
                $add_service = new FollowServie;
                $add_service->user_id = $this->userId;
                $add_service->post_type = 'a';
                $add_service->accompanist_id = $request->type_id;
                $add_service->save();
                addNotificationThenGet($request->other_id, 'Followed to accompanist', 'started following your accompanist', 'accompanist', 'Accompanist', $request->type_id, 'accompanist' . $request->type_id . '_followed_by_' . $this->userId . '_on_accompanist' . $request->type_id);
            }
        }
    }

    function unfollowService(Request $request) {
        FollowServie::where(array('user_id' => $this->userId, 'post_type' => $request->type))
                ->when($request->type == 'g', function($q) use($request) {
                    $q->where('group_id', $request->type_id);
                })
                ->when($request->type == 's', function($q) use($request) {
                    $q->where('studio_id', $request->type_id);
                })
                ->when($request->type == 'a', function($q) use($request) {
                    $q->where('accompanist_id', $request->type_id);
                })
                ->delete();
    }

    function followInvite(Request $request) {
        $type = $request->type;
        if ($type == 'g') {
            $check_invite = FollowInvite::where(array('user_id' => $this->userId, 'post_type' => 'g', 'group_id' => $request->type_id))->first();
            if (!$check_invite) {
                $add_invite = new FollowInvite;
                $add_invite->user_id = $request->other_id;
                $add_invite->post_type = 'g';
                $add_invite->group_id = $request->type_id;
                $add_invite->save();
                addNotificationThenGet($request->other_id, 'Invite to event', 'Invite to his event', 'group', 'Group', $request->type_id, 'event' . $request->type_id . '_invited_by_' . $this->userId . '_on_event' . $request->type_id);
            }
        }
        if ($type == 's') {
            $check_invite = FollowInvite::where(array('user_id' => $this->userId, 'post_type' => 's', 'studio_id' => $request->type_id))->first();
            if (!$check_invite) {
                $add_invite = new FollowInvite;
                $add_invite->user_id = $request->other_id;
                $add_invite->post_type = 's';
                $add_invite->studio_id = $request->type_id;
                $add_invite->save();
                addNotificationThenGet($request->other_id, 'Invite to teaching studio', 'Invite to his teaching studio', 'teaching_studio', 'TeachingStudio', $request->type_id, 'teaching_studio' . $request->type_id . '_invited_by_' . $this->userId . '_on_studio' . $request->type_id);
            }
        }
        if ($type == 'a') {
            $check_invite = FollowInvite::where(array('user_id' => $this->userId, 'post_type' => 'a', 'accompanist_id' => $request->type_id))->first();
            if (!$check_invite) {
                $add_invite = new FollowInvite;
                $add_invite->user_id = $request->other_id;
                $add_invite->post_type = 'a';
                $add_invite->accompanist_id = $request->type_id;
                $add_invite->save();
                addNotificationThenGet($request->other_id, 'Invite to accompanist', 'Invite to his accompanist', 'accompanist', 'Accompanist', $request->type_id, 'accompanist' . $request->type_id . '_invited_by_' . $this->userId . '_on_accompanist' . $request->type_id);
            }
        }
    }

}
