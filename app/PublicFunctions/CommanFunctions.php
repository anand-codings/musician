<?php

use App\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use App\Bookmark;
use App\Review;
use App\Notification;
use App\User;
use App\Booking;
use App\UserFollower;
use App\GalleryMedia;
use Illuminate\Support\Str;
use App\Category;
use App\IgnoredUser;
use App\Group;
use App\Accompanist;
use App\TeachingStudio;
use App\FollowServie;
use App\Language;
use App\FollowInvite;
use App\Chat;
use App\ChatGroupMember;

function image_fix_orientation($filename) {
    $exif = @exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, -90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        imagejpeg($image, $filename, 90);
    }
    return $filename;
}

function addFile($file, $path) {
    if ($file) {
        if ($file->getClientOriginalExtension() != 'exe') {
            $type = $file->getClientMimeType();
            $extension = $file->getClientOriginalExtension();
//            echo $extension;exit;
            if ($extension == 'pdf' || $extension == 'mp3' || $type == 'image/jpg' || $type == 'image/jpeg' || $type == 'image/png' || $type == 'image/bmp' || $type == 'image/gif' || $type == 'image/*') {
                $destination_path = 'public/images/' . $path; // upload path
                $extension = $file->getClientOriginalExtension(); // getting image extension
                $fileName = 'image_' . Str::random(15) . '.' . $extension; // renameing image
                $file->move($destination_path, $fileName);
                $file_path = $path . '/' . $fileName;
                return $file_path;
            } else {
                return False;
            }
        } else {
            return False;
        }
    } else {
        return False;
    }
}

function addVideo($video, $path) {
    $video_extension = $video->getClientOriginalExtension(); // getting image extension
    $video_extension = strtolower($video_extension);
    $allowedextentions = ["mov", "3g2", "3gp", "4xm", "a64", "aa", "aac", "ac3", "act", "adf", "adp", "adts", "adx", "aea", "afc", "aiff", "alaw", "alias_pix", "alsa", "amr", "anm", "apc", "ape", "apng",
        "aqtitle", "asf", "asf_o", "asf_stream", "ass", "ast", "au", "avi", "avisynth", "avm2", "avr", "avs", "bethsoftvid", "bfi", "bfstm", "bin", "bink", "bit", "bmp_pipe",
        "bmv", "boa", "brender_pix", "brstm", "c93", "caf", "cavsvideo", "cdg", "cdxl", "cine", "concat", "crc", "dash", "data", "daud", "dds_pipe", "dfa", "dirac", "dnxhd",
        "dpx_pipe", "dsf", "dsicin", "dss", "dts", "dtshd", "dv", "dv1394", "dvbsub", "dvd", "dxa", "ea", "ea_cdata", "eac3", "epaf", "exr_pipe", "f32be", "f32le", "f4v",
        "f64be", "f64le", "fbdev", "ffm", "ffmetadata", "film_cpk", "filmstrip", "flac", "flic", "flv", "framecrc", "framemd5", "frm", "g722", "g723_1", "g729", "gif", "gsm", "gxf",
        "h261", "h263", "h264", "hds", "hevc", "hls", "hls", "applehttp", "hnm", "ico", "idcin", "idf", "iff", "ilbc", "image2", "image2pipe", "ingenient", "ipmovie",
        "ipod", "ircam", "ismv", "iss", "iv8", "ivf", "j2k_pipe", "jacosub", "jpeg_pipe", "jpegls_pipe", "jv", "latm", "lavfi", "live_flv", "lmlm4", "loas", "lrc",
        "lvf", "lxf", "m4v", "matroska", "mkv", "matroska", "webm", "md5", "mgsts", "microdvd", "mjpeg", "mkvtimestamp_v2", "mlp", "mlv", "mm", "mmf", "mp4", "m4a", "3gp",
        "3g2", "mj2", "mp2", "mp3", "mp4", "mpc", "mpc8", "mpeg", "mpeg1video", "mpeg2video", "mpegts", "mpegtsraw", "mpegvideo", "mpjpeg", "mpl2", "mpsub", "msnwctcp",
        "mtv", "mulaw", "mv", "mvi", "mxf", "mxf_d10", "mxf_opatom", "mxg", "nc", "nistsphere", "nsv", "null", "nut", "nuv", "oga", "ogg", "oma", "opus", "oss", "paf",
        "pictor_pipe", "pjs", "pmp", "png_pipe", "psp", "psxstr", "pulse", "pva", "pvf", "qcp", "qdraw_pipe", "r3d", "rawvideo", "realtext", "redspark", "rl2", "rm",
        "roq", "rpl", "rsd", "rso", "rtp", "rtp_mpegts", "rtsp", "s16be", "s16le", "s24be", "s24le", "s32be", "s32le", "s8", "sami", "sap", "sbg", "sdl", "sdp", "sdr2",
        "segment", "sgi_pipe", "shn", "siff", "singlejpeg", "sln", "smjpeg", "smk", "smoothstreaming", "smush", "sol", "sox", "spdif", "spx", "srt", "stl",
        "stream_segment", "ssegment", "subviewer", "subviewer1", "sunrast_pipe", "sup", "svcd", "swf", "tak", "tedcaptions", "tee", "thp", "tiertexseq",
        "tiff_pipe", "tmv", "truehd", "tta", "tty", "txd", "u16be", "u16le", "u24be", "u24le", "u32be", "u32le", "u8", "uncodedframecrc", "v4l2", "vc1", "vc1test",
        "vcd", "video4linux2", "v4l2", "vivo", "vmd", "vob", "vobsub", "voc", "vplayer", "vqf", "w64", "wav", "wc3movie", "webm", "webm_chunk", "webm_dash_manife",
        "webp", "webp_pipe", "webvtt", "wsaud", "wsvqa", "wtv", "wv", "x11grab", "xa", "xbin", "xmv", "xv", "xwma", "wmv", "yop", "yuv4mpegpipe"];
    if (in_array($video_extension, $allowedextentions)) {
        $video_destinationPath = base_path('public/videos/' . $path); // upload path
        $video_fileName = 'video_' . Str::random(15) . '.' . 'mp4'; // renameing image
        $fileDestination = $video_destinationPath . '/' . $video_fileName;
        $filePath = $video->getRealPath();
        exec("ffmpeg -i $filePath -strict -2 -vf scale=320:240 $fileDestination 2>&1", $result, $status);
        $info = getVideoInformation($result);
        $poster_name = explode('.', $video_fileName)[0] . '.jpg';
        $poster = 'public/images/' . $path . '/posters/' . $poster_name;
        exec("ffmpeg -ss $info[1] -i $filePath -frames:v 1 $poster 2>&1");
        $data['file'] = '/' . $path . '/' . $video_fileName;
        $data['poster'] = '/' . $path . '/posters/' . $poster_name;
    } else {
        $data['file'] = '';
        $data['poster'] = '';
    }
    return $data;
}

function getVideoInformation($video_information) {
    $regex_duration = "/Duration: ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2}).([0-9]{1,2})/";
    if (preg_match($regex_duration, implode(" ", $video_information), $regs)) {
        $hours = $regs [1] ? $regs [1] : null;
        $mins = $regs [2] ? $regs [2] : null;
        $secs = $regs [3] ? $regs [3] : null;
        $ms = $regs [4] ? $regs [4] : null;
        $random_duration = sprintf("%02d:%02d:%02d", rand(0, $hours), rand(0, $mins), rand(0, $secs));
        $original_duration = $hours . ":" . $mins . ":" . $secs;
        $parsed = date_parse($original_duration);
        $seconds = ($parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']) > 20 ? true : false;
        return [$original_duration, $random_duration, $seconds];
    }
}

function sendSuccess($message, $data) {
    return Response::json(array('status' => 200, 'successMessage' => $message, 'successData' => $data), 200, [], JSON_NUMERIC_CHECK);
}

function sendError($error_message, $code) {
    return Response::json(array('status' => 400, 'errorMessage' => $error_message), 400);
}

function timeago($ptime) {
    $difference = time() - strtotime($ptime);
    if ($difference) {
        $periods = array("second", "minute", "hour", "day", "week", "month", "years", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");
        for ($j = 0; $difference >= $lengths[$j]; $j++)
            $difference /= $lengths[$j];

        $difference = round($difference);
        if ($difference != 1)
            $periods[$j] .= "s";

        $text = "$difference $periods[$j] ago";


        return $text;
    }else {
        return ' Just Now';
    }
}

function categories($filter = null, $solo_ensemble = null) {
    $type_array = '';
    if ($filter == 'musician') {
        $type_array = \App\Category::where('is_for_musician', 1)->orderBy('title')->get();
    } else if ($filter == 'studio') {
        $type_array = \App\Category::where('is_for_studio', 1)->orderBy('title')->get();
    } else if ($filter == 'accompanist') {
        $type_array = \App\Category::where('is_for_accompanist', 1)->orderBy('title')->get();
    } else if ($filter == 'group') {
        if ($solo_ensemble == 'solo') {
            $type_array = \App\Category::where(['is_for_group' => 1, 'is_solo' => 1])->orderBy('title')->get();
        } else if ($solo_ensemble == 'ensemble') {
            $type_array = \App\Category::where(['is_for_group' => 1, 'is_ensemble' => 1])->orderBy('title')->get();
        } else {
            $type_array = \App\Category::where(['is_for_group' => 1])->orderBy('title')->get();
        }
    } else {
        $type_array = \App\Category::orderBy('title')->get();
    }
    
    return $type_array->toArray();
}

function getUserImage($image, $social_image, $gender = '') {
    if ($image) {
        return asset('public/images/' . $image);
    }
    if ($social_image) {
        return $social_image;
    }
    if ($gender) {
        if ($gender == 'male')
            return asset('public/images/profile_pics/demo.png');
        else if ($gender == 'female')
            return asset('public/images/profile_pics/fdemo.png');
    }
    return asset('public/images/profile_pics/demo.png');
}

function getUserPhoto($id) {
    $img = User::find($id);
    return $img->photo;
}

function getUserName($id) {
    $name = User::find($id);
    return $name->first_name.' '.$name->last_name;
}

function unreadMessages() {
    $user_accompinist = Accompanist::select('id')->where('admin_id', Auth::user()->id)->get()->toArray();
    $user_groups = Group::select('id')->where('admin_id', Auth::user()->id)->get()->toArray();
    $user_studio = TeachingStudio::select('id')->where('admin_id', Auth::user()->id)->get()->toArray();
    return ChatMessage::where('receiver_id', Auth::user()->id)
                    ->where(function ($q) use($user_accompinist) {
                        $q->whereNotIn('accompanist_id', $user_accompinist)
                        ->orWhereNull('accompanist_id');
                    })
                    ->where(function ($q) use($user_studio) {
                        $q->whereNotIn('studio_id', $user_studio)
                        ->orWhereNull('studio_id');
                    })
                    ->where(function ($q) use($user_groups) {
                        $q->whereNotIn('group_id', $user_groups)
                        ->orWhereNull('group_id');
                    })->where('is_read', 0)->count();
}

function unreadFriendsMessages() {
    return ChatGroupMember::where('member_id', Auth::user()->id)
            ->where('type_id', 0)
            ->where('member_left', 0)
            ->where('group_deleted', 0)
            ->where('is_read', 0)->count();
                    
}

function favouritesCount() {
    return Bookmark::where(['user_id' => Auth::user()->id, 'is_viewed' => 0])->count();
}

function bookingCount() {
    return Booking::where(['user_id' => Auth::user()->id, 'is_viewed_by_musician' => 0])->count();
}

function bookingCountUser() {
    return Booking::where(['booked_by' => Auth::user()->id, 'is_viewed_by_user' => 0])->count();
}

function reviewsCount() {
    return Review::where(['user_id' => Auth::user()->id, 'is_viewed' => 0])->count();
}

function notificationCount() {
    return Notification::where('user_id', '!=', Auth::user()->id)
                    ->where('on_user', Auth::user()->id)
                    ->where('is_read', 0)->count();
}

function notifications($take, $skip) {
    return Notification::where(function($q) {
                        $q->where('user_id', null)
                        ->where('on_user', Auth::user()->id);
                    })
                    ->orWhere(function($q) {
                        $q->where('user_id', '!=', Auth::user()->id)
                        ->where('on_user', Auth::user()->id);
                    })
                    ->take($take)->skip($skip)->groupBy('unique_text')
                    ->orderby('created_at', 'desc')->get();
}

function getMessages($user_id, $take, $skip) {
    $other_id = '';
    $chat_user_sender = Chat::select('sender_id as uid')->where('receiver_id', $user_id)->where('receiver_deleted', 0)->get()->toArray();
    $chat_user_reciver = Chat::select('receiver_id as uid')->where('sender_id', $user_id)->where('sender_deleted', 0)->get()->toArray();
    $user_chated = array_merge($chat_user_sender, $chat_user_reciver);
    $user_accompinist = Accompanist::select('id')->where('admin_id', $user_id)->get()->toArray();
    $user_groups = Group::select('id')->where('admin_id', $user_id)->get()->toArray();
    $user_studio = TeachingStudio::select('id')->where('admin_id', $user_id)->get()->toArray();
    return Chat::with('sender', 'receiver')
                    ->withCount(['messages' => function ($q) {
                            $q->where('is_read', 0);
                        }])
                    ->where(function ($q) use($user_id) {
                        $q->where('sender_id', $user_id);
                        $q->orWhere('receiver_id', $user_id);
                    })->where(function ($q) use($user_accompinist) {
                        $q->whereNotIn('accompanist_id', $user_accompinist)
                        ->orWhereNull('accompanist_id');
                    })
                    ->where(function ($q) use($user_studio) {
                        $q->whereNotIn('studio_id', $user_studio)
                        ->orWhereNull('studio_id');
                    })
                    ->where(function ($q) use($user_groups) {
                        $q->whereNotIn('group_id', $user_groups)
                        ->orWhereNull('group_id');
                    })
                    ->whereRaw("IF(`sender_id` = $user_id, `sender_deleted`, `receiver_deleted`)= 0")
                    ->take($take)->skip($skip)->orderBy('updated_at', 'desc')->get();
}

function addNotification($on_user, $text, $notification_text, $type, $relation, $type_id = '', $unique_description = '') {
    if ($unique_description) {
        Notification::where('unique_text', $unique_description)->delete();
    }
    $add_activity = new Notification;
    $add_activity->user_id = Auth::user()->id;
    $add_activity->on_user = $on_user;
    $add_activity->activity_log = $text;
    $add_activity->notification_text = $notification_text;
    $add_activity->type = $type;
    $add_activity->model = $relation;
    $add_activity->type_id = $type_id;
    $add_activity->unique_text = $unique_description;
    $add_activity->save();
    return TRUE;
}

function addNotificationThenGet($on_user, $text, $notification_text, $type, $relation, $type_id = '', $unique_description = '') {
    if ($unique_description) {
        Notification::where('unique_text', $unique_description)->delete();
    }
    $add_activity = new Notification;
    $add_activity->user_id = Auth::user()->id;
    $add_activity->on_user = $on_user;
    $add_activity->activity_log = $text;
    $add_activity->notification_text = $notification_text;
    $add_activity->type = $type;
    $add_activity->model = $relation;
    $add_activity->type_id = $type_id;
    $add_activity->unique_text = $unique_description;
    $add_activity->save();
    return $add_activity;
}

function addNotificationForStudioAdminThenGet($on_user, $text, $notification_text, $type, $relation, $type_id = '', $unique_description = '', $user) {
    if ($unique_description) {
        Notification::where('unique_text', $unique_description)->delete();
    }
    $add_activity = new Notification;
    $add_activity->user_id = ($user)? $user->id:'';
    $add_activity->on_user = $on_user;
    $add_activity->activity_log = $text;
    $add_activity->notification_text = $notification_text;
    $add_activity->type = $type;
    $add_activity->model = $relation;
    $add_activity->type_id = $type_id;
    $add_activity->unique_text = $unique_description;
    $add_activity->save();
    return $add_activity;
}


function addNotificationFromAdminThenGet($on_user, $text, $notification_text, $type, $relation, $type_id = '', $unique_description = '') {
    if ($unique_description) {
        Notification::where('unique_text', $unique_description)->delete();
    }
    $add_activity = new Notification;
//    $add_activity->user_id = '';
    $add_activity->on_user = $on_user;
    $add_activity->activity_log = $text;
    $add_activity->notification_text = $notification_text;
    $add_activity->type = $type;
    $add_activity->model = $relation;
    $add_activity->type_id = $type_id;
    $add_activity->unique_text = $unique_description;
    $add_activity->save();
    return $add_activity;
}

function getUser($id) {
    return User::find($id);
}

function getProfileSidebarPath($type) {
    if ($type == 'user') {
        return 'views/includes/user_profile_sidebar.php';
    } else if ($type == 'artist') {
//        if(!Auth::user() || Auth::user()->type == 'artist'){
        return 'views/includes/musician_profile_sidebar_shown_to_musician.php';
//        } else {
//            return 'views/includes/musician_profile_sidebar.php';
//        }
    }
}

function checkFollowing($other_id) {
    if (Auth::user()) {
        return UserFollower::where(array('user_id' => $other_id, 'followed_by' => Auth::user()->id))->first();
    }
}

function deleteNotification($type, $type_id) {
    if ($type == 'post') {
        Notification::where('type_id', $type_id)
                ->whereIn('type', ['like', 'comment'])
                ->delete();
    } else if ($type == 'like') {
        Notification::where('type_id', $type_id)
                ->where('type', 'like')
                ->delete();
    } else if ($type == 'comment') {
        Notification::where('type_id', $type_id)
                ->where('type', 'comment')
                ->delete();
    } else if ($type == 'group') {
        Notification::where('type_id', $type_id)
                ->where('type', 'group')
                ->delete();
    } else if ($type == 'teaching_studio') {
        Notification::where('type_id', $type_id)
                ->where('type', 'teaching_studio')
                ->delete();
    } else if ($type == 'review') {
        Notification::where('type_id', $type_id)
                ->where('type', 'review')
                ->delete();
    }
}

function units() {
    return App\Unit::all();
}

function soloCategories() {
    return App\Category::where('is_solo', 1)->orderBy('title')->get();
}

function ensembleCategories() {
    return App\Category::where('is_ensemble', 1)->orderBy('title')->get();
}

function addMedia($path, $type = 'image', $poster = '', $file = '') {
    $check = GalleryMedia::where(['path' => $path, 'type' => $type])->first();
    if ($check) {
        return true;
    }
    if ($type == 'image' && $file) {
        $name = 'image_' . str_random(10);
        $save_name = $name . '.' . $file->getClientOriginalExtension();
        $resize_name = 'thum_' . $save_name;
        Image::make($file->getRealPath())
                ->resize(200, null, function ($constraints) {
                    $constraints->aspectRatio();
                })->orientate()
                ->save('public/images/posts/thumnails/' . $resize_name);
        $poster = $resize_name;
    }
    $add_media = new GalleryMedia;
    $add_media->user_id = Auth::user()->id;
    $add_media->path = $path;
    $add_media->type = $type;
    $add_media->poster = $poster;
    $add_media->save();
    return $add_media;
}

function addMediaForBase64Images($path, $type = 'image', $poster = '', $file = '') {
    $check = GalleryMedia::where(['path' => $path, 'type' => $type])->first();
    if ($check) {
        return true;
    }
    if ($type == 'image' && $file) {
        $name = 'image_' . substr(md5(uniqid(mt_rand(), true)), 0, 16) . '.' . 'png';
        $resize_name = 'thum_' . $name;
        Image::make(file_get_contents($file))
                ->resize(200, null, function ($constraints) {
                    $constraints->aspectRatio();
                })->orientate()
                ->save('public/images/posts/thumnails/' . $resize_name);
        $poster = $resize_name;
    }
    $add_media = new GalleryMedia;
    $add_media->user_id = Auth::user()->id;
    $add_media->path = $path;
    $add_media->type = $type;
    $add_media->poster = $poster;
    $add_media->save();
    return $add_media;
}

function selectedGigCategoryIds($id) {
    $selectedIds = App\SelectedGigCategory::where('gig_id', $id)->pluck('category_id');
    $myCategoryIds = [];
    foreach ($selectedIds as $categoryId) {
        array_push($myCategoryIds, $categoryId);
    }
    return $myCategoryIds;
}

function thousandsNumberFormat($num) {
    if ($num > 1000) {
        $x = round($num);
        $x_number_format = number_format($x);
        $x_array = explode(',', $x_number_format);
        $x_parts = array('k', 'm', 'b', 't');
        $x_count_parts = count($x_array) - 1;
        $x_display = $x;
        $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
        $x_display .= $x_parts[$x_count_parts - 1];
        return $x_display;
    }
    return $num;
}

function trendingTag() {
    return Category::orderBy('search_count', 'desc')->orderBy('title')->take(10)->get();
}

function getSuggestions() {
    $following = UserFollower::select('user_id as uid')->where('followed_by', Auth::user()->id)->get()->toArray();
    $ignored = IgnoredUser::select('blocked_id  as uid')->where('user_id', Auth::user()->id)->get()->toArray();
    $all_ingroed = array_merge($following, $ignored);
    $all_ingroed['uid'] = Auth::user()->id;
    return User::whereNotin('id', $all_ingroed)
                    ->where('is_active', 1)
                    ->inRandomOrder()
                    ->take(3)->get();
}

function getFollower($other_id) {
    $following = UserFollower::select('user_id as uid')->where('followed_by', Auth::user()->id)->get()->toArray();
    $other_following = UserFollower::select('user_id as uid')->where('followed_by', $other_id)->get()->toArray();
    $matched_id = [];
    foreach ($following as $a2) {

        foreach ($other_following as $b2) {
            if ($b2['uid'] == $a2['uid']) {
                $matched_id[] += $a2['uid'];
            }
        }
    }
    return User::whereIn('id', $matched_id)
                    ->where('type', 'artist')
//                    ->inRandomOrder()
                    ->first();
}

function getMentions($content) {
    $mention_regex = '/@\[([0-9]+)\]/i'; //mention regrex to get all @texts
    if (preg_match_all($mention_regex, $content, $matches)) {
        foreach ($matches[1] as $match) {
//            $match_user = $DB->row("SELECT * FROM w3_user WHERE user_id=?", array($match));
            $match_user = User::find($match);
            if ($match_user) {
                $match_search = '@[' . $match . ']';
                $match_replace = '<a target="_blank" href="' . asset('profile_timeline/' . $match_user->id) . '">' . $match_user->first_name . ' ' . $match_user->last_name . '</a>';
            } else {
                $match_search = '@[' . $match . ']';
                $match_replace = '<a target="_blank" href="javascript:void(0)">privat user</a>';
            }
//            if (isset($match_user->id)) {
            $content = str_replace($match_search, $match_replace, $content);
//            }
        }
    }
    return $content;
}

function saveMentions($content) {
    $mention_regex = '/@\[([0-9]+)\]/i'; //mention regrex to get all @texts
    if (preg_match_all($mention_regex, $content, $matches)) {
        foreach ($matches[1] as $match) {
//            $match_user = $DB->row("SELECT * FROM w3_user WHERE user_id=?", array($match));
            $match_user = User::find($match);
            if ($match_user) {
                $match_search = '@[' . $match . ']';

                $match_replace = "@[$match_user->first_name $match_user->last_name](user:$match_user->id)";
            } else {
                $match_search = '@[' . $match . ']';
                $match_replace = "@[Private User](user:33333)";
            }
//            if (isset($match_user->id)) {
            $content = str_replace($match_search, $match_replace, $content);
//            }
        }
    }
    return $content;
}

function getUnreadCountService($type, $type_id) {
    return ChatMessage::where('message_type', $type)->where('receiver_id', Auth::user()->id)->where('is_read', 0)
                    ->when($type == 'g', function($q) use($type_id) {
                        $q->where('group_id', $type_id);
                    })
                    ->when($type == 's', function($q) use($type_id) {
                        $q->where('studio_id', $type_id);
                    })
                    ->when($type == 'a', function($q) use($type_id) {
                        $q->where('accompanist_id', $type_id);
                    })->count();
}

function getUnreadCountServiceForGroups($type, $type_id) {
    return ChatGroupMember::where('member_id', Auth::user()->id)->where('is_read', 0)->where('group_deleted', 0)->where('member_left', 0)
                    ->when($type == 'g', function($q) use($type_id) {
                        $q->where('group_id', $type_id);
                    })
                    ->when($type == 's', function($q) use($type_id) {
                        $q->where('studio_id', $type_id);
                    })
                    ->when($type == 'a', function($q) use($type_id) {
                        $q->where('accompanist_id', $type_id);
                    })->count();
}

function getNotificaionUrl($type_id) {
    $message = ChatMessage::find($type_id);
    $url = asset('messages');
    if ($message && $message->message_type == 'g' && $message->group->admin_id == Auth::user()->id) {
        $url = asset('group_messages/' . $message->group_id);
    }
    if ($message && $message->message_type == 'a' && $message->accompanist->admin_id == Auth::user()->id) {
        $url = asset('accompanist_messages/' . $message->accompanist_id);
    }
    if ($message && $message->message_type == 's' && $message->studio->admin_id == Auth::user()->id) {
        $url = asset('studio_messages/' . $message->studio_id);
    }
    return $url;
}

function getServicsImage($image) {
//    $pic = asset('public/images/profile_pics/demo.png');
//    if ($image) {
    $pic = asset('public/images/' . $image);
//    }
    return $pic;
}

function checkServiceFollowing($type, $type_id, $column) {
    return FollowServie::where(array('user_id' => Auth::user()->id, 'post_type' => $type, $column => $type_id))->first();
}

function getLanguages() {
    return Language::orderBy('name')->get();
}

function getInviteUsers($type, $type_id, $column) {
    $where_in_user = UserFollower::select('user_id')->where('followed_by', Auth::user()->id)->get()->toArray();
    $where_not_user = FollowServie::select('user_id')
                    ->where('post_type', $type)
                    ->where($column, $type_id)
                    ->get()->toArray();
    $where_not_user_invited = FollowInvite::select('user_id')
                    ->where('post_type', $type)
                    ->where($column, $type_id)
                    ->get()->toArray();
    return User::whereIn('id', $where_in_user)
                    ->whereNotIn('id', $where_not_user)
                    ->whereNotIn('id', $where_not_user_invited)->get();
}

function getFollowingCount($type, $type_id, $column) {
    return FollowServie::where(array('post_type' => $type, $column => $type_id))->count();
}

//function searchForVulgarTerms($string) {
//    $terms = \App\VulgarTerm::all();
//    foreach ($terms as $term) {
//        if (strpos($string, $term->term) !== false) {
//            return true;
//        }
//    }
//}

function searchForVulgarTerms($string) {
    $words = array_unique(preg_split('/\PL+/u', $string, -1, PREG_SPLIT_NO_EMPTY));
    $terms = \App\VulgarTerm::orderBy('term', 'ASC')->pluck('term')->toArray();
    $result = array_intersect($words, $terms);
    if (!empty($result)) {
        return true;
    }
}
