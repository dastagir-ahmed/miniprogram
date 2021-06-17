<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"文章管理"},
     *     path="/api/article/getdetail",
     *     summary="获取文章详情",
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
        $column_id = $request->column_id;
        $data = DB::select("select a.*,ifnull(arr.record,0) record,ifnull(ac.pinglun,0) pinglun,ifnull(ard.dianzan,0) dianzan from articles a left join (select count(1) record,article_id from article_records where type=1 group by article_id) arr on arr.article_id=a.id
left join (select count(1) pinglun,article_id from article_comments where parent_id=0 group by article_id) ac on ac.article_id=a.id
left join (select count(1) dianzan,article_id from article_records where type=2 group by article_id) ard on ard.article_id=a.id where a.column_id=?", [$column_id]);
        return response()->json([
            "code" => 0
            , "data" => $data
            , "msg" => "成功"
        ]);
    }
}
