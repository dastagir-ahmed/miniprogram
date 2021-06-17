<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Models\Question;
use App\Models\User;
use App\Models\UserQuestionRecord;
use App\Models\Word;
use Faker\Provider\Base;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserQuestionRecordController extends BaseController
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"问卷"},
     *     path="/api/userquestionrecord/save",
     *     summary="用户提交答案",
     *     description="同一个用户，同一道题多次答题会更新答题记录",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"data"},
     *              @OA\Property(property="data", type="string",description="答题数组"),
     *              @OA\Property(property="answers", type="string",description="用户的选项，多选用,隔开"),
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description=""
     *       ),
     *     )
     */
    public function save(Request $request)
    {
        $data = $request->data;
        $userQuestionRecord = new UserQuestionRecord();
        if ($userQuestionRecord->insert($data)) {
            return response()->json([
                'code' => 0,
                'msg' => '成功'
            ]);
        }
        return response()->json([
            'code' => -1,
            'msg' => '失败'
        ]);
    }
}
