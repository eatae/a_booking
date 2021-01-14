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
            return response()->json(['status'=>'error', 'messages' => 'The request method should be GET']);
        }
        $validator = Validator::make($request->all(), [
            'order' => ['nullable', 'string', 'in:price,created_at'],
            'sort' => ['nullable', 'string', 'in:asc,desc']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->first()]);
        }

        $order = $request->get('order') ?: 'created_at';
        $sort = $request->get('sort') ?: 'asc';
        $rooms = DB::table('rooms')->orderBy($order, $sort)->get();

        return response()->json($rooms);
    }



    public function actionCreate(Request $request)
    {
        /* validation */
        if (!$request->isMethod('POST')) {
            return response()->json(['status'=>'error', 'messages' => 'The request method should be POST']);
        }
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'price' => ['required', 'integer']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->first()]);
        }
        $room = new Room($request->post());
        $room->save();

        return response()->json(['room_id' => $room->id]);
    }
}
