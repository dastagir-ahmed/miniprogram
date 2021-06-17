<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleRecord;
use App\Models\ForumRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumRecordController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"中心广场"},
     *     path="/api/forumrecord/save",
     *     summary="增加浏览记录或点赞取消点赞",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="forum_id", type="integer",description="帖子id"),
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
        $forum_id = $request->forum_id;
        $type = $request->type;
        if ($type == 1) {
            //浏览 只添加
            $forumrecord = new ForumRecord();
            $forumrecord->forum_id=$forum_id;
            $forumrecord->type=1;
            $forumrecord->user_id=$user_id;
            if ($forumrecord->save()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        }else{
            //点赞添加或取消点赞
            $forumrecord=ArticleRecord::where([['forum_id','=',$forum_id],['user_id','=',$user_id]
                ,['type','=',2]])->first();
            if($forumrecord){
                if($forumrecord->delete()){
                    return response()->json([
                        "code" => 0
                        , "msg" => "成功"
                    ]);
                }
            }else{
                $forumrecord = new ForumRecord();
                $forumrecord->forum_id=$forum_id;
                $forumrecord->type=2;
                $forumrecord->user_id=$user_id;
                if ($forumrecord->save()) {
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
