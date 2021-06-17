<?php

namespace App\Http\Controllers\Api;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"新闻"},
     *     path="/api/news/getlist",
     *     summary="获取分页列表",
     *    @OA\Parameter(
     *          name="pageSize",
     *          description="每页数量",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *    @OA\Parameter(
     *          name="pageNum",
     *          description="页码",
     *          required=false,
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
        $list = News::orderBy('created_at', 'desc')
            ->paginate($request->pageSize, ['*'], '', $request->pageNum);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
    /**
     * @OA\Get(
     *     tags={"新闻"},
     *     path="/api/news/getdetail",
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
     *          description="返回文章详情，包含评论总数"
     *       ),
     *     )
     */
    public function getDetail(Request $request)
    {
        $id = $request->id;
        $data = DB::select("select n.*,ifnull(nr.total,0) total from news n
left join (select count(1) total,news_id from news_records group by news_id) nr on nr.news_id=n.id
where id=?", [$id]);
        return response()->json([
            "code" => 0
            , "data" => $data
            , "msg" => "成功"
        ]);
    }
}
