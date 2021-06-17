<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleCommentLike;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedbackController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"个人中心"},
     *     path="/api/feedback/save",
     *     summary="增加意见反馈",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="contents", type="string",description="内容"),
     *              @OA\Property(property="tel", type="string",description="联系方式"),
     *              @OA\Property(property="imgs", type="string",description="图片地址，多个用,隔开"),
     *              @OA\Property(property="types", type="string",description="问题类型，多个用,隔开"),
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
        $feedback = new Feedback();
        $feedback->user_id = $request->user_id;
        $feedback->content = $request->contents;
        $feedback->tel = $request->tel;
        $feedback->imgs = $request->imgs;
        $feedback->types = $request->types;
        if ($feedback->save()) {
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
