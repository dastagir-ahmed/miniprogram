<?php

namespace App\Http\Controllers\Api;

use App\Models\QuwenQiushi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class QuwenQiushiController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"趣闻糗事"},
     *     path="/api/quwenqiushi/getdetail",
     *     summary="获取详情",
     *    @OA\Parameter(
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
     *          description="返回文章详情，包含评论总数、点赞总数、浏览总数"
     *       ),
     *     )
     */
    public function getDetail(Request $request)
    {
        $id = $request->id;
        $data = DB::select("select qq.*,ifnull(qqrr.totalr,0) totalr,ifnull(qqrz.totalz,0) totalz from quwen_qiushis qq
left join (select count(1) totalr,quwen_qiushi_id from quwen_qiushi_records where type=1 group by quwen_qiushi_id ) qqrr on qqrr.quwen_qiushi_id=qq.id
left join (select count(1) totalz,quwen_qiushi_id from quwen_qiushi_records where type=2 group by quwen_qiushi_id ) qqrz on qqrz.quwen_qiushi_id=qq.id
where id=?", [$id]);
        return response()->json([
            "code" => 0
            , "data" => $data
            , "msg" => "成功"
        ]);
    }
    /**
     * @OA\Get(
     *     tags={"趣闻糗事"},
     *     path="/api/quwenqiushi/getlist",
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
     *          description="成功,type=1表示趣闻，2表示糗事"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $startfrom = ($request->pageNum - 1) * $request->pageSize;
        $list = DB::select("select qq.*,ifnull(qqr.total,0) total from quwen_qiushis qq left join (select count(1) total,quwen_qiushi_id from quwen_qiushi_records where type=1 group by quwen_qiushi_id ) qqr on qqr.quwen_qiushi_id=qq.id order by created_at desc limit ?,?",[$startfrom, $request->pageSize]);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
