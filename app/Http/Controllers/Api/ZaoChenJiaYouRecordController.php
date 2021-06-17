<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use App\Models\ZaoChenJiaYouRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ZaoChenJiaYouRecordController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"BetterMe"},
     *     path="/api/zaochenjiayourecord/save",
     *     summary="早晨加油",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="contents", type="string",description="内容"),
     *              @OA\Property(property="user_id", type="integer",description="用户id")
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
        $zaochenjiayourecord = new ZaoChenJiaYouRecord();
        $zaochenjiayourecord->user_id = $request->user_id;
        $zaochenjiayourecord->content = $request->contents;
        if ($zaochenjiayourecord->save()) {
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
