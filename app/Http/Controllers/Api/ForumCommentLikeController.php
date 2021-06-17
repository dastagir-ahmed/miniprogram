<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleCommentLike;
use App\Models\ForumCommentLike;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForumCommentLikeController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"中心广场"},
     *     path="/api/forumcommentlike/save",
     *     summary="增加评论点赞取消点赞",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="forum_comment_id", type="integer",description="评论id"),
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
        $forum_comment_id = $request->forum_comment_id;
        //点赞添加或取消点赞
        $forumcommentlike = ForumCommentLike::where([['forum_comment_id', '=', $forum_comment_id], ['user_id', '=', $user_id]])->first();
        if ($forumcommentlike) {
            if ($forumcommentlike->delete()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        } else {
            $forumcommentlike = new ForumCommentLike();
            $forumcommentlike->forum_comment_id = $forum_comment_id;
            $forumcommentlike->user_id = $user_id;
            if ($forumcommentlike->save()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        }
        return response()->json([
            "code" => -1
            , "msg" => "失败"
        ]);
    }
}
