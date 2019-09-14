<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use App\Booking;
use App\User;
use App\BookingAvailability;
use App\TeachingStudio;
use App\Group;
use App\Accompanist;
use App\DisputeHistory;
use App\DisputeEvidence;
use Illuminate\Support\Facades\Mail;
use PDF;

class BookingController extends Controller {

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

    function addBooking(Request $request) {
        $add_booking = new Booking;
        $add_booking->booked_by = $this->userId;
        $add_booking->user_id = $request['user_id'];
        $add_booking->price = $request['booking_price'];
        $add_booking->location = $request['booking_location'];
        $add_booking->booking_time = date('Y-m-d H:i:s', strtotime($request['booking_date']));
        $add_booking->time = $request['booking_hours'];
        $add_booking->status = 'pending';

        if ($request['gig_type'] == 'gig') {
            $add_booking->gig_type = $request['gig_type'];
            $add_booking->gig_id = $request['gig_id'];
        } else if ($request['gig_type'] == 'group') {
            $add_booking->gig_type = $request['gig_type'];
            $add_booking->group_id = $request['group_id'];
        } else if ($request['gig_type'] == 'teaching_studio') {
            $add_booking->gig_type = $request['gig_type'];
            $add_booking->teaching_studio_id = $request['teaching_studio_id'];
        } else if ($request['gig_type'] == 'accompanist') {
            $add_booking->gig_type = $request['gig_type'];
            $add_booking->accompanist_id = $request['accompanist_id'];
        } else if ($request['gig_type'] == 'custom') {
            $add_booking->gig_type = $request['gig_type'];
            $add_booking->event_name = $request['event_name'];
        }

        $add_booking->booking_description = $request['booking_description'];
        $add_booking->save();
        $notification = '';
        if ($request['gig_type'] == 'gig') {
            $notification = addNotificationThenGet($request['user_id'], 'You requested to book a gig' . $request['gig_id'], ' requested to book your gig', 'booking', 'Booking', $add_booking->id, 'booking' . $add_booking->id . '_user' . $this->userId . '_request_to_book_gig' . $request['gig_id']);
        } else if ($request['gig_type'] == 'group') {
            $group = Group::find($request->group_id);
            $notification = addNotificationThenGet($request['user_id'], 'You requested to book a group ' . $group->name, ' requested to book your ' . $group->name, 'booking', 'Booking', $add_booking->id, 'booking' . $add_booking->id . '_user' . $this->userId . '_request_to_book_group' . $request['group_id']);
        } else if ($request['gig_type'] == 'teaching_studio') {
            $studio = TeachingStudio::find($request->teaching_studio_id);
            $notification = addNotificationThenGet($request['user_id'], 'You requested to book a teaching studio ' . $studio->name, ' requested to book your ' . $studio->name, 'booking', 'Booking', $add_booking->id, 'booking' . $add_booking->id . '_user' . $this->userId . '_request_to_book_teaching_studio' . $request['teaching_studio_id']);
        } else if ($request['gig_type'] == 'accompanist') {
            $accompanist = Accompanist::find($request->accompanist_id);
            $notification = addNotificationThenGet($request['user_id'], 'You requested to book a accompanist ' . $accompanist->name, ' requested to book your ' . $accompanist->name, 'booking', 'Booking', $add_booking->id, 'booking' . $add_booking->id . '_user' . $this->userId . '_request_to_book_accompanist' . $request['accompanist_id']);
        } else if ($request['gig_type'] == 'custom') {
            $notification = addNotificationThenGet($request['user_id'], 'You requested to book a musician' . $request['user_id'], ' requested to book you', 'booking', 'Booking', $add_booking->id, 'booking' . $add_booking->id . '_user' . $this->userId . '_request_to_book_musician' . $request['user_id']);
        }
        return response()->json(array('message' => 'success', 'bookig_id' => $add_booking->id, 'notification' => $notification));
    }

    function getBookings() {
        $data['title'] = 'Musician | Booking';
        return view('user.booking', $data);
    }

    function bookingDetail($booking_id) {
        $data['title'] = 'Musician | Booking Details';
        $data['booking'] = Booking::find($booking_id);
        if (!$data['booking']) {
            return Redirect::to(Url::previous());
        }
        $booking_time = strtotime($data['booking']->booking_time);
        $data['booking_time'] = date('l, F d, Y', $booking_time);
        if ($data['booking']->availablity) {
            $available_from = explode(" ", $data['booking']->availablity->available_from);
            $available_to = explode(" ", $data['booking']->availablity->available_to);
            $data['available_from_time'] = $available_from[1];
            $data['available_to_time'] = $available_to[1];
            $availableFromDate = $available_from[0];
            $availableFromDate = strtotime($availableFromDate);
            $data['available_from_date'] = date('l, F d, Y', $availableFromDate);
            $availableToDate = $available_to[0];
            $availableToDate = strtotime($availableToDate);
            $data['available_to_date'] = date('l, F d, Y', $availableToDate);
        }
        return view('user.singlebooking', $data);
    }

    function fetchBookings(Request $request) {
        if ($this->user->type == 'artist') {

            $data['bookings'] = Booking::where('user_id', $this->userId)
                            ->when($request->type == 'standard', function ($q) {
                                $q->where(function ($x) {
                                    $x->where('gig_type', 'gig')
                                    ->orWhere('gig_type', 'group')
                                    ->orWhere('gig_type', 'teaching_studio')
                                    ->orWhere('gig_type', 'accompanist');
                                });
                            })
                            ->when($request->type == 'custom', function ($q) {
                                $q->where('gig_type', 'custom');
                            })
                            ->orderBy('updated_at', 'desc')->take($request->take)->skip($request->skip);
            $data['bookings'] = $data['bookings']->get();
            foreach ($data['bookings'] as $booking) {
                if (!$booking->is_viewed_by_musician) {
                    $booking->is_viewed_by_musician = 1;
                    $booking->save();
                }
            }
          
            return view('user.loader.bookings_loader', $data);
            
        } else {
            $data['bookings'] = Booking::where('booked_by', $this->userId)
                            ->when($request->type == 'standard', function ($q) {
                                $q->where(function ($x) {
                                    $x->where('gig_type', 'gig')
                                    ->orWhere('gig_type', 'group')
                                    ->orWhere('gig_type', 'teaching_studio')
                                    ->orWhere('gig_type', 'accompanist');
                                });
                            })
                            ->when($request->type == 'custom', function ($q) {
                                $q->where('gig_type', 'custom');
                            })
                            ->orderBy('updated_at', 'desc')->take($request->take)->skip($request->skip);
            $data['bookings'] = $data['bookings']->get();
            foreach ($data['bookings'] as $booking) {
                
                if (!$booking->is_viewed_by_user) {
                    $booking->is_viewed_by_user = 1;
                    $booking->save();
                }
                
                
            }
            return view('user.loader.bookings_loader_user', $data);
        }
    }
    
    function downloadInvoice($id)
    {
        
      if(isset($id))
      {
       $data['booking'] = Booking::findOrFail($id);
       $date_time =$data['booking']->booking_time;
       $file_name = '';
       if($data['booking']->booking_time != '')
       {
           $month = date('M', strtotime($date_time));  
           $date= date('d', strtotime($date_time));            
           $year = date('Y', strtotime($date_time));
           $file_name = $month.', '.$date.', '.$year;
       }
       
       if($data['booking']->artist->first_name && $data['booking']->artist->last_name)
       {
        $file_name = $data['booking']->artist->first_name . '_' . $data['booking']->artist->last_name .'_'.$file_name;   
       }
       $pdf = PDF::loadView('public.invoice', $data);
       return $pdf->download($file_name.'.pdf');
        return view('public.invoice', $data);
       
      }
       
    }

    function acceptBooking(Request $request) {
        $booking = Booking::find($request->booking_id);
        $user = User::find($booking->booked_by);
        $errorMessage = '';
        try {
            $charge = $user->charge($booking->price * 100);
            $booking->status = 'approved';
            $booking->stripe_charge_id = $charge->id;
            $booking->save();
            $notification = addNotificationThenGet($booking->booked_by, 'You responded to a booking request', ' accepted your booking request', 'booking', 'Booking', $booking->id, 'booking' . $booking->id . '_user' . $this->userId . '_response_to_booking');
            return response()->json(array('success' => 'Booking Has Been Approved', 'user_id' => $booking->booked_by, 'notification' => $notification));
        } catch (\Stripe\Error\Card $e) {
            $errorMessage = $e->getMessage();
        } catch (\Stripe\Error\RateLimit $e) {
            $errorMessage = $e->getMessage();
        } catch (\Stripe\Error\InvalidRequest $e) {
            $errorMessage = $e->getMessage();
        } catch (\Stripe\Error\Authentication $e) {
            $errorMessage = $e->getMessage();
        } catch (\Stripe\Error\ApiConnection $e) {
            $errorMessage = $e->getMessage();
        } catch (\Stripe\Error\Base $e) {
            $errorMessage = $e->getMessage();
        } catch (Exception $e) {
            $errorMessage = $e->getMessage();
        }
        $booking->status = 'cancelled';
        $booking->save();
        $notification = addNotificationThenGet($booking->booked_by, 'Payment is declined because, ' . $errorMessage, ' cancelled your booking because, ' . lcfirst($errorMessage), 'booking', 'Booking', $booking->id, 'booking' . $booking->id . '_user' . $this->userId . '_response_to_booking');
        return response()->json(array('error' => lcfirst($errorMessage), 'user_id' => $booking->booked_by, 'notification' => $notification));
    }

    function checkBookingsOnTheSameDay(Request $request) {
//        dd($request->all());
        $booking = Booking::find($request->booking_id);
        $bookingTime = $booking->booking_time;
        $bookingsOnTheSameDay = Booking::where(['user_id' => $this->userId, 'booking_time' => $bookingTime, 'status' => 'approved'])->whereNotIn('id', [$booking->id])->get();
        $user = User::select('email','first_name','last_name')->where('id', $booking->booked_by)->first();
        $send_to  = $user->email;
        $fullname  = $user->first_name.' '.$user->last_name;
        $timestamp = strtotime($bookingTime);

        $date = date('n.j.Y', $timestamp); // d.m.YYYY
        $time = date('H:i', $timestamp); // HH:ss
        
        $viewData['date'] = $date;
        $viewData['time'] = $time;
        $viewData['name'] = $fullname;
        
        
        Mail::send('emails.booking_accepted', $viewData, function ($m) use ($send_to, $fullname) {
            $m->from(env('MAIL_USERNAME'), $fullname);
            $m->to($send_to, $fullname)->subject('Musician');
            });
            
        if (!$bookingsOnTheSameDay->isEmpty()) {
            $convertedBookingTime = date('F j, Y', strtotime($booking->booking_time));
            return response()->json(array('success' => 1, 'booking_time' => $convertedBookingTime, 'href' => asset('get_bookings_on_the_same_day/' . $booking->id)));
        }
        return response()->json(array('failure' => 1));
    }

    function getBookingsOnTheSameDay($id) {
        $booking = Booking::find($id);
        if ($booking) {
            $bookingTime = $booking->booking_time;
            $data['title'] = 'Musician | Booking';
            $data['bookings'] = Booking::where(['user_id' => $this->userId, 'booking_time' => $bookingTime, 'status' => 'approved'])->whereNotIn('id', [$booking->id])->get();
            if ($data['bookings']->isEmpty()) {
                return Redirect::to(URL::previous());
            }
            return view('user.bookings_on_the_same_day', $data);
        }
        return Redirect::to(URL::previous());
    }

    function declineBooking(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'rejected';
        $booking->save();
        $notification = addNotificationThenGet($booking->booked_by, 'You rejected a booking request', ' rejected you booking request', 'booking', 'Booking', $booking->id, 'booking' . $booking->id . '_user' . $this->userId . '_response_to_booking');
        return response()->json(array('success' => 'Booking Has Been Rejected', 'user_id' => $booking->booked_by, 'notification' => $notification));
    }

    function requestPayment(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'payment_requested';
        $booking->save();
        $notification = addNotificationThenGet($booking->booked_by, 'You requested for payment', ' requested for payment release', 'payment request', 'Booking', $booking->id, 'requested_payment_for_booking' . $booking->id . '_user' . $this->userId . '_response_to_booking');
        return response()->json(array('success' => 'Your Request Has been sent', 'user_id' => $booking->booked_by, 'notification' => $notification));
    }

    function requestPaymentAdmin(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'admin_requested';
        $booking->save();
        addNotification(null, $this->userName . 'You requested for payment to admin', ' requested for payment release to admin', 'payment request', 'Booking', $booking->id, 'requested_payment_to_admin_for_booking' . $booking->id . '_user' . $this->userId);
        return response()->json(array('success' => 'Your Request Has been sent', 'user_id' => $booking->booked_by));
    }

    function AddAvailabilty(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'postponed';
        $booking->save();
        BookingAvailability::where('booking_id', $request->booking_id)->delete();
        $add_booking_avil = new BookingAvailability;
        $add_booking_avil->available_from = date('Y-m-d H:i:s', strtotime($request['booking_date_from'] . $request['booking_time_from']));
        $add_booking_avil->available_to = date('Y-m-d H:i:s', strtotime($request['booking_date_to'] . $request['booking_time_to']));
        $add_booking_avil->user_id = $this->userId;
        $add_booking_avil->booking_id = $request->booking_id;
        $add_booking_avil->save();
        $notification = addNotificationThenGet($booking->booked_by, 'You postponed booking', ' postponed booking', 'booking', 'Booking', $booking->id, 'postponed_booking' . $booking->id . '_user' . $this->userId . '_response_to_booking');
        return response()->json(array('success' => 'Your Request Has been sent', 'user_id' => $booking->booked_by, 'notification' => $notification));
    }

    function approvePayment(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'payment_approved';
        $booking->notes = $request->notes;
        $booking->tip_amount = $request->tip_amount;
        $booking->save();
        $notification = addNotificationThenGet($booking->user_id, 'You approved booking payment', ' approved your booking payment', 'payment approved', 'Booking', $booking->id, 'payment_approved_of_booking' . $booking->id . '_by_user' . $this->userId);
        return response()->json(array('success' => 'Payment Approved Successfully', 'user_id' => $booking->user_id, 'notification' => $notification));
    }

    function rejectPayment(Request $request) {
        $booking = Booking::find($request->booking_id);
        // $booking->notes = $request->notes;
        $booking->notes = $request->reason;
        $booking->status = 'disputed';
        $booking->dispute_start_time_utc = date('Y-m-d h:i:s', time());
        $booking->is_user_submitted_evidence = 1;
        $booking->save();

        $disputeHistory = new DisputeHistory();
        $disputeHistory->reason = $request->reason;
        $disputeHistory->user_id = $this->userId;
        $disputeHistory->booking_id = $request->booking_id;
        $disputeHistory->save();

        if ($request->hasfile('evidence_files')) {
            if ($files = $request->file('evidence_files')) {
                foreach ($files as $file) {

                    $input['imagename'] = uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('../public/images/evidences');
                    $file->move($destinationPath, $input['imagename']);

                    $disputeEvidence = new DisputeEvidence();
                    $disputeEvidence->file_path = 'evidences/' . $input['imagename'];
                    $disputeEvidence->user_id = $this->userId;
                    $disputeEvidence->dispute_history_id = $disputeHistory->id;
                    $disputeEvidence->booking_id = $request->booking_id;
                    $disputeEvidence->save();
                }
            }
        }

        $notification = addNotificationThenGet($booking->user_id, 'You rejected booking payment', ' rejected your booking payment', 'payment rejected', 'Booking', $booking->id, 'payment_rejected_of_booking' . $booking->id . '_by_user' . $this->userId);
        return response()->json(array('success' => 'Payment Rejected Successfully', 'user_id' => $booking->user_id, 'notification' => $notification));
    }

    function submitDisputeReason(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->is_musician_submitted_evidence = 1;
        $booking->save();

        $disputeHistory = new DisputeHistory();
        $disputeHistory->reason = $request->reason;
        $disputeHistory->user_id = $this->userId;
        $disputeHistory->booking_id = $request->booking_id;
        $disputeHistory->save();

        if ($request->hasfile('evidence_files')) {
            if ($files = $request->file('evidence_files')) {
                foreach ($files as $file) {

                    $input['imagename'] = uniqid() . '.' . $file->getClientOriginalExtension();
                    $destinationPath = public_path('../public/images/evidences');
                    $file->move($destinationPath, $input['imagename']);

                    $disputeEvidence = new DisputeEvidence();
                    $disputeEvidence->file_path = 'evidences/' . $input['imagename'];
                    $disputeEvidence->user_id = $this->userId;
                    $disputeEvidence->dispute_history_id = $disputeHistory->id;
                    $disputeEvidence->booking_id = $request->booking_id;
                    $disputeEvidence->save();
                }
            }
        }

//        $notification = addNotificationThenGet($booking->user_id, 'You rejected booking payment', ' rejected your booking payment', 'payment rejected', 'Booking', $booking->id, 'payment_rejected_of_booking' . $booking->id . '_by_user' . $this->userId);
//        return response()->json(array('success' => 'Dispute Evidence Added Successfully', 'user_id' => $booking->user_id, 'notification' => $notification));
        return response()->json(array('success' => 'Dispute Evidence Added Successfully'));
    }

    function requestPartialRefund(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'partial_refund_requested';
        $booking->partial_refund_requested_percentage = $request['percentage'];
        $booking->partial_refund_reason = $request['reason'];
        $booking->save();

//        $notification = addNotificationThenGet($booking->user_id, 'You rejected booking payment', ' rejected your booking payment', 'payment rejected', 'Booking', $booking->id, 'payment_rejected_of_booking' . $booking->id . '_by_user' . $this->userId);
//        return response()->json(array('success' => 'Dispute Evidence Added Successfully', 'user_id' => $booking->user_id, 'notification' => $notification));
        return response()->json(array('success' => 'Partial Refund Requested Successfully'));
    }

    function acceptPartialRefund(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'payment_approved';
        $booking->is_refunding = 1;
        $booking->save();
        return response()->json(array('success' => 'Partial Refund Accepted'));
    }

    function rejectPartialRefund(Request $request) {
        $booking = Booking::find($request->booking_id);
        $booking->status = 'payment_approved';
        $booking->is_refunding = 1;
        $booking->save();
        return response()->json(array('success' => 'Partial Refund Rejected'));
    }

    function updateBooking(Request $request) {
        $update_booking = Booking::find($request->booking_id);
        $update_booking->booking_time = date('Y-m-d H:i:s', strtotime($request['booking_date']));
        $update_booking->time = $request['booking_hours'];
        $update_booking->status = 'postponed_updated';
        $update_booking->booking_description = $request['booking_description'];
        $update_booking->save();
        $notification = addNotificationThenGet($request['user_id'], $this->userName . ' updated booking', $this->userName . ' updated booking', 'booking', 'Booking', $update_booking->id, $this->userName . ' updated booking' . $update_booking->id . $this->userId);
        return response()->json(array('bookig_id' => $update_booking->id, 'notification' => $notification));
    }

}
