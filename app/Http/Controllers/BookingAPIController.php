<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Booking;


class BookingAPIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * List
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionList(Request $request)
    {
        /* validation */
        if (!$request->isMethod('GET')) {
            return response()->json(['status'=>'error', 'messages' => ['The request method should be GET']]);
        }
        $validator = Validator::make($request->all(), [
            'room_id' => ['nullable'],
            'sort' => ['nullable', 'string', 'in:asc,desc']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->all()]);
        }

        $sort = $request->get('sort') ?: 'asc';
        $query = DB::table('bookings')->orderBy('date_start', $sort);
        /* by room_id */
        if ( $request->get('room_id') ) {
            $query->where('room_id', $request->get('room_id'));
        }
        $bookings = $query->get();

        return response()->json(['status' => 'success', 'response' => $bookings]);
    }


    /**
     * Create
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionCreate(Request $request)
    {
        /* validation */
       if (!$request->isMethod('POST')) {
            return response()->json(['status'=>'error', 'messages' => ['The request method should be POST']]);
        }
        $validator = Validator::make($request->all(), [
            'room_id' => ['required', 'exists:rooms,id'],
            'date_start' => ['required', 'date_format:Y-m-d', 'after:today'],
            'date_end' => ['required', 'date_format:Y-m-d', 'after:date_start']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->all()]);
        }
        $booking = new Booking($request->all());
        $booking->save();

        return response()->json(['status' => 'success', 'response' => ['booking_id' => $booking->id]]);
    }


    /**
     * Delete
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function actionDelete(Request $request)
    {
        /* validation */
        if (!$request->isMethod('DELETE')) {
            return response()->json(['status'=>'error', 'messages' => ['The request method should be DELETE']]);
        }
        $validator = Validator::make($request->all(), [
            'booking_id' => ['required', 'exists:bookings,id']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->all()]);
        }
        /* delete */
        $booking_id = $request->input('booking_id');
        Booking::find($booking_id)->delete();

        return response()->json(['status' => 'success', 'response' => ['deleted_booking_id' => $booking_id]]);
    }
}
