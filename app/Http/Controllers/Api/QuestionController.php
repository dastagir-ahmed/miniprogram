<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use App\Models\Question;
use App\Models\Word;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuestionController extends BaseController
{
    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"问卷"},
     *     path="/api/question/getlist",
     *     summary="获取试题",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回问卷试题"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $where = [];
        $list = Question::where($where)
            ->orderBy('sort', 'asc')
            ->get();
        foreach ($list as $key => $value) {
            $options = Option::where([['question_id', '=', $value['id']]])
                ->orderBy('id', 'asc')->get();
            $value['options'] = $options;
        }
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }

}
