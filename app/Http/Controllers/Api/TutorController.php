<?php

namespace App\Http\Controllers\Api;

use App\Models\StarPlanRecord;
use App\Models\Tutor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"导师"},
     *     path="/api/tutor/save",
     *     summary="发帖",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="sex", type="integer",description="性别，1表示女，2表示男"),
     *              @OA\Property(property="age", type="integer",description="年龄"),
     *              @OA\Property(property="name", type="string",description="姓名"),
     *              @OA\Property(property="tel", type="string",description="电话"),
     *              @OA\Property(property="city", type="string",description="城市"),
     *              @OA\Property(property="company", type="string",description="企业"),
     *              @OA\Property(property="job", type="string",description="工作"),
     *              @OA\Property(property="time", type="integer",description="在家办公时长"),
     *              @OA\Property(property="remark", type="string",description="申请说明")
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
        $tutor = new Tutor();
        if(Tutor::where([['user_id','=',$request->userid]])->count()>0){
            return response()->json([
                "code" => -1
                , "msg" => "您已经认证过了"
            ]);
        }
        $tutor->user_id = $request->userid;
        $tutor->sex = $request->sex;
        $tutor->name = $request->name;
        $tutor->age = $request->age;
        $tutor->tel = $request->tel;
        $tutor->city = $request->city;
        $tutor->company = $request->company;
        $tutor->job = $request->job;
        $tutor->time = $request->time;
        $tutor->remark = $request->remark;
        if ($tutor->save()) {
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
