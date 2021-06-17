<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleRecordController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"文章管理"},
     *     path="/api/articlerecord/save",
     *     summary="增加文章记录或点赞取消点赞",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="article_id", type="integer",description="文章id"),
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
        $article_id = $request->article_id;
        $type = $request->type;
        if ($type == 1) {
            //浏览 只添加
            $articlerecord = new ArticleRecord();
            $articlerecord->article_id=$article_id;
            $articlerecord->type=1;
            $articlerecord->user_id=$user_id;
            if ($articlerecord->save()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        }else{
            //点赞添加或取消点赞
            $articlerecord=ArticleRecord::where([['article_id','=',$article_id],['user_id','=',$user_id]
            ,['type','=',2]])->first();
            if($articlerecord){
                if($articlerecord->delete()){
                    return response()->json([
                        "code" => 0
                        , "msg" => "成功"
                    ]);
                }
            }else{
                $articlerecord = new ArticleRecord();
                $articlerecord->article_id=$article_id;
                $articlerecord->type=2;
                $articlerecord->user_id=$user_id;
                if ($articlerecord->save()) {
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
