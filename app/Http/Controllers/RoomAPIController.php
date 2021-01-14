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

class RoomAPIController extends BaseController
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
            'order' => ['nullable', 'string', 'in:price,created_at'],
            'sort' => ['nullable', 'string', 'in:asc,desc']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->all()]);
        }
        /* get rooms */
        $order = $request->get('order') ?: 'created_at';
        $sort = $request->get('sort') ?: 'asc';
        $rooms = DB::table('rooms')->orderBy($order, $sort)->get();

        return response()->json(['status' => 'success', 'response' => $rooms]);
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
            'description' => ['required', 'string'],
            'price' => ['required', 'integer']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->first()]);
        }
        /* create */
        $room = new Room($request->post());
        $room->save();

        return response()->json(['status' => 'success', 'response' => ['room_id' => $room->id]]);
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
            'room_id' => ['required', 'exists:rooms,id']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['status'=>'error', 'messages' => $validator->errors()->all()]);
        }
        /* delete */
        $room_id = $request->input('room_id');
        Room::find($room_id)->delete();

        return response()->json(['status' => 'success', 'response' => ['deleted_room_id' => $room_id]]);
    }


}
