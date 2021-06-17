<?php

namespace App\Http\Controllers\Api;

use App\Models\NewsRecord;
use App\Models\QuwenQiushiRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsRecordController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"新闻"},
     *     path="/api/newsrecord/save",
     *     summary="增加浏览记录",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="news_id", type="integer",description="文章id"),
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
        $user_id = $request->user_id;
        $news_id = $request->news_id;
        //浏览 只添加
        $newsrecord = new NewsRecord();
        $newsrecord->news_id=$news_id;
        $newsrecord->user_id=$user_id;
        if ($newsrecord->save()) {
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
