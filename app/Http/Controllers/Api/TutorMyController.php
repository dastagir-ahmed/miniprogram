<?php

namespace App\Http\Controllers\Api;

use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorMyController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"导师"},
     *     path="/api/tutormy/save",
     *     summary="发帖",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="tutor_id", type="integer",description="导师id")
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       )
     *     )
     */
    public function save(Request $request)
    {
        $tutormy = new TutorMy();
        $tutormy->user_id = $request->userid;
        $tutormy->tutor_id = $request->tutor_id;
        if ($tutormy->save()) {
            return response()->json([
                "code" => 0
                , "msg" => "成功"
            ]);
        }
        return response()->json([
            "code" => -1
            , "msg" => "失败"
        ]);
    }
}
