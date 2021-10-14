<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoomListRequest;
use App\Models\Room;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
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
     * @return JsonResponse
     */
    public function actionList(RoomListRequest $request): JsonResponse
    {
        $rooms = DB::table('rooms')->orderBy($request->getOrder(), $request->getSort())->get();

        return response()->json(['data' => $rooms], Response::HTTP_OK);
    }


    /**
     * One
     *
     * @param Room $room
     * @return JsonResponse
     */
    public function actionOne(Room $room): JsonResponse
    {
        return response()->json(['data' => $room], Response::HTTP_OK);
    }


    /**
     * Create
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actionCreate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'price' => ['required', 'integer']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['data' => ['error'=> $validator->errors()->first()]], Response::HTTP_BAD_REQUEST);
        }
        /* create */
        $room = new Room($request->post());
        $room->save();

        return response()->json(['data' => ['id'=> $room->id]], Response::HTTP_OK);
    }


    /**
     * Update
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function actionUpdate(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'price' => ['required', 'integer']
        ]);
        if ( $validator->fails() ) {
            return response()->json(['data' => ['error'=> $validator->errors()->first()]], Response::HTTP_BAD_REQUEST);
        }
        /* create */
        $room = new Room($request->post());
        $room->save();

        return response()->json(['data' => ['id'=> $room->id]], Response::HTTP_OK);
    }

    /**
     * Delete
     *
     * @param Room $room
     * @return JsonResponse
     * @throws Exception
     */
    public function actionDelete(Room $room): JsonResponse
    {
        $room->delete();

        return response()->json(['data' => ['id' => $room->id]]);
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
