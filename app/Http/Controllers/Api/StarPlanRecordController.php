<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\StarPlanRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StarPlanRecordController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"星光计划"},
     *     path="/api/starplanrecord/save",
     *     summary="发帖",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="star_plan_id", type="integer",description="星光计划id"),
     *              @OA\Property(property="user_id", type="integer",description="用户id"),
     *              @OA\Property(property="name", type="string",description="姓名"),
     *              @OA\Property(property="email", type="string",description="邮箱"),
     *              @OA\Property(property="reason", type="string",description="理由")
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
        $starplanrecord = new StarPlanRecord();
        $starplanrecord->user_id = $request->userid;
        $starplanrecord->star_plan_id = $request->star_plan_id;
        $starplanrecord->name = $request->name;
        $starplanrecord->email = $request->email;
        $starplanrecord->reason = $request->reason;
        if ($starplanrecord->save()) {
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
