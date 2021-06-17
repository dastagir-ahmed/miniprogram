<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityRecordController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"活动"},
     *     path="/api/activityrecord/save",
     *     summary="发帖",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="activity_id", type="integer",description="活动id")
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
        $activity = new Activity();
        $activity->user_id = $request->userid;
        $activity->activity_id = $request->activity_id;
        if(Activity::where([['user_id','=',$request->userid],['activity_id','=',$request->activity_id]])->count()>0){
            return response()->json([
                "code" => -1
                , "msg" => "您已经报过名了"
            ]);
        }
        if ($activity->save()) {
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
