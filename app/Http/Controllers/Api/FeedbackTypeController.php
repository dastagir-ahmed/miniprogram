<?php

namespace App\Http\Controllers\Api;

use App\Models\FeedbackType;
use App\Models\Option;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackTypeController extends Controller
{
    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"个人中心"},
     *     path="/api/feedbacktype/getlist",
     *     summary="获取意见反馈问题类型",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回所有"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $where = [];
        $list = FeedbackType::where($where)
            ->get();
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
