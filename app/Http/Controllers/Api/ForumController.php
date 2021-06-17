<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use App\Models\Forum;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"中心广场"},
     *     path="/api/forum/save",
     *     summary="发帖",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="contents", type="string",description="内容"),
     *              @OA\Property(property="title", type="string",description="标题"),
     *              @OA\Property(property="imgs", type="string",description="图片地址，多个用,隔开"),
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
        $forum = new Forum();
        $forum->user_id = $request->user_id;
        $forum->content = $request->contents;
        $forum->title = $request->title;
        $forum->imgs = $request->imgs;
        if ($forum->save()) {
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
     *     path="/api/forum/getdetail",
     *     summary="获取详情",
     *    @OA\Parameter(
     *          name="column_id",
     *          description="栏目id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回文章详情，包含评论总数、点赞总数、浏览总数"
     *       ),
     *     )
     */
    public function getDetail(Request $request)
    {
        $id = $request->id;
        $data = Forum::find($id);
        return response()->json([
            "code" => 0
            , "data" => $data
            , "msg" => "成功"
        ]);
    }
    /**
     * @OA\Get(
     *     tags={"中心广场"},
     *     path="/api/forum/getlist",
     *     summary="获取分页列表",
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
     *          name="pageNum",
     *          description="页码",
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
    public function getList(Request $request)
    {
        $startfrom = ($request->pageNum - 1) * $request->pageSize;
        $list = DB::select("select f.*,ifnull(frr.record,0) record,ifnull(frrz.recordzan,0) recordzan,ifnull(fc.recordc,0) recordc  from forums f
left join (select count(1) record,forum_id from forum_records where type=1 group by forum_id) frr on frr.forum_id=f.id
left join (select count(1) recordzan,forum_id from forum_records where type=2 group by forum_id) frrz on frrz.forum_id=f.id
left join (select count(1) recordc,forum_id from forum_comments group by forum_id) fc on fc.forum_id=f.id
order by f.istop,f.created_at desc limit ?,?",[$startfrom, $request->pageSize]);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
