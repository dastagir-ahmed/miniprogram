<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\Forum;
use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ActivityController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"活动"},
     *     path="/api/activity/getlist",
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
        $list = Activity::orderBy('created_at', 'desc')
            ->paginate($request->pageSize, ['*'], '', $request->pageNum);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
    /**
     * @OA\Get(
     *     tags={"活动"},
     *     path="/api/activity/getdetail",
     *     summary="获取活动详情",
     *    @OA\Parameter(
     *          name="id",
     *          description="活动id",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="返回详情"
     *       ),
     *     )
     */
    public function getDetail(Request $request)
    {
        $id = $request->id;
        $data = Activity::find($id);
        return response()->json([
            "code" => 0
            , "data" => $data
            , "msg" => "成功"
        ]);
    }
}
