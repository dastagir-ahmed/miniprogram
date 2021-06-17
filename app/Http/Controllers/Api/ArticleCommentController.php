<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleCommentController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"文章管理"},
     *     path="/api/articlecomment/save",
     *     summary="添加评论",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="article_id", type="integer",description="文章id"),
     *              @OA\Property(property="parent_id", type="integer",description="父id,评论为0，回复时为评论id"),
     *              @OA\Property(property="contents", type="string",description="评论内容")
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
        $articlecomment = new ArticleComment();
        $articlecomment->article_id = $request->article_id;
        $articlecomment->parent_id = $request->parent_id;
        $articlecomment->content = $request->contents;
        $articlecomment->user_id = $request->userid;
        $articlecomment->isgood = 0;
        if ($articlecomment->save()) {
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

    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"文章管理"},
     *     path="/api/articlecomment/delete",
     *     summary="删除评论",
     *      @OA\Parameter(
     *          name="id",
     *          description="id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function delete(Request $request)
    {
        if (ArticleComment::destroy($request->id) > 0) {
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

    /**
     * @OA\Get(
     *     tags={"文章管理"},
     *     path="/api/articlecomment/getlist",
     *     summary="获取文章评论列表",
     *    @OA\Parameter(
     *          name="pageNum",
     *          description="页码",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="pageSize",
     *          description="每页数量",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="article_id",
     *          description="文章id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="user_id",
     *          description="用户id",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回所有已精选的评论及当前登录用户的所有评论，包含评论点赞数total"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $article_id = $request->article_id;
        $user_id = $request->user_id;
        if ($user_id) {
            $where = "and (isgood=1 or user_id=" . $user_id . ")";
        } else {
            $where = "and (isgood=1)";
        }
        $startfrom = ($request->pageNum - 1) * $request->pageSize;
        $list = DB::select("select ac.*,ifnull(acl.total,0) total from article_comments ac left join (select count(1) total,article_comment_id from article_comment_likes GROUP BY article_comment_id) acl on acl.article_comment_id=ac.id where article_id=? " . $where . " limit ?,?", [$article_id, $startfrom, $request->pageSize]);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
