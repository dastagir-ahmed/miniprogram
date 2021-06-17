<?php

namespace App\Http\Controllers\Api;

use App\Models\ArticleComment;
use App\Models\ForumComment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ForumCommentController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"中心广场"},
     *     path="/api/forumcomment/save",
     *     summary="添加评论",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="forum_id", type="integer",description="帖子id"),
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
        $forumcomment = new ForumComment();
        $forumcomment->forum_id = $request->forum_id;
        $forumcomment->parent_id = $request->parent_id;
        $forumcomment->content = $request->contents;
        $forumcomment->user_id = $request->userid;
        if ($forumcomment->save()) {
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
     *     tags={"中心广场"},
     *     path="/api/forumcomment/delete",
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
        if (ForumComment::destroy($request->id) > 0) {
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
     *     tags={"中心广场"},
     *     path="/api/forumcomment/getlist",
     *     summary="获取评论列表",
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
     *          name="forum_id",
     *          description="帖子id",
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
        $forum_id = $request->forum_id;
        $startfrom = ($request->pageNum - 1) * $request->pageSize;
        $list = DB::select("select ac.*,ifnull(acl.total,0) total from forum_comments ac left join (select count(1) total,forum_comment_id from forum_comment_likes GROUP BY forum_comment_id) acl on acl.forum_comment_id=ac.id where forum_id=? limit ?,?", [$forum_id, $startfrom, $request->pageSize]);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
