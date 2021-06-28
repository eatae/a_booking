<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomListRequest;
use App\Models\Room;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomAPIController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * List
     *
     * @param RoomListRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function actionList(RoomListRequest $request)
    {
        $rooms = DB::table('rooms')->orderBy($request->getOrder(), $request->getSort())->get();

        return response()->json(['data' => $rooms], Response::HTTP_OK);
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



    public function actionTest()
    {
        $data = ['foo', 'bar', 'baz', 'zaz', 'uaz', 'kraz'];
        $result = array_reduce($data, function($carry, $item){
            return $carry . $item . PHP_EOL;
        });
        /* create */
        $room = new Room([
            'description' => $result,
            'price' => 200
        ]);
        $room->save();

        return response()->json(['status' => 'success', 'response' => ['room' => $room]]);
    }


}
