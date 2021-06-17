<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleCommentLike;
use App\Models\ArticleRecord;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleCommentLikeController extends Controller
{
    /**
     * @OA\Post(
     *     tags={"文章管理"},
     *     path="/api/articlecommentlike/save",
     *     summary="增加评论点赞取消点赞",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="article_comment_id", type="integer",description="评论id"),
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
        $article_comment_id = $request->article_comment_id;
        //点赞添加或取消点赞
        $articlecommentlike = ArticleCommentLike::where([['article_comment_id', '=', $article_comment_id], ['user_id', '=', $user_id]])->first();
        if ($articlecommentlike) {
            if ($articlecommentlike->delete()) {
                return response()->json([
                    "code" => 0
                    , "msg" => "成功"
                ]);
            }
        } else {
            $articlecommentlike = new ArticleCommentLike();
            $articlecommentlike->article_comment_id = $article_comment_id;
            $articlecommentlike->user_id = $user_id;
            if ($articlecommentlike->save()) {
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
