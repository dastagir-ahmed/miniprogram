<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ColumnController extends BaseController
{
    /**
     * @OA\Get(
     *     tags={"栏目管理"},
     *     path="/api/column/getlist",
     *     summary="获取栏目",
     *    @OA\Parameter(
     *          name="parent_id",
     *          description="父id",
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
     *          description="返回所有栏目"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $parent_id = $request->parent_id;
        $user_id = $request->user_id;
        $list = DB::select("select c.*,ifnull(cus.sort,0) sort from `columns` c left join column_user_sorts cus on cus.column_id=c.id and cus.user_id=?
where c.parent_id=?",[$user_id,$parent_id]);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }

}
