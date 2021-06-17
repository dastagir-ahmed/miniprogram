<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleRecord;
use App\Models\QuwenQiushiRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuwenQiushiRecordController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"趣闻糗事"},
     *     path="/api/quwenqiushirecord/save",
     *     summary="增加浏览记录或点赞取消点赞",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="quwen_qiushi_id", type="integer",description="文章id"),
     *              @OA\Property(property="user_id", type="integer",description="用户id"),
     *              @OA\Property(property="type", type="integer",description="类型，1表示浏览，2表示点赞")
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
        $quwen_qiushi_id = $request->quwen_qiushi_id;
        $type = $request->type;
        if ($type == 1) {
            //浏览 只添加
            $quwenqiushirecord = new QuwenQiushiRecord();
            $quwenqiushirecord->quwen_qiushi_id=$quwen_qiushi_id;
            $quwenqiushirecord->type=1;
            $quwenqiushirecord->user_id=$user_id;
            if ($quwenqiushirecord->save()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        }else{
            //点赞添加或取消点赞
            $quwenqiushirecord=QuwenQiushiRecord::where([['article_id','=',$quwen_qiushi_id],['user_id','=',$user_id]
                ,['type','=',2]])->first();
            if($quwenqiushirecord){
                if($quwenqiushirecord->delete()){
                    return response()->json([
                        "code" => 0
                        , "msg" => "成功"
                    ]);
                }
            }else{
                $quwenqiushirecord = new QuwenQiushiRecord();
                $quwenqiushirecord->quwen_qiushi_id=$quwen_qiushi_id;
                $quwenqiushirecord->type=2;
                $quwenqiushirecord->user_id=$user_id;
                if ($quwenqiushirecord->save()) {
                    return response()->json([
                        "code" => 0
                        , "msg" => "成功"
                    ]);
                }
            }
        }
        return response()->json([
            "code" => -1
            , "msg" => "失败"
        ]);
    }
}
