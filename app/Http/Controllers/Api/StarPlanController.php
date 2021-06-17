<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\StarPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StarPlanController extends Controller
{
    /**
     * @OA\Get(
     *     tags={"星光计划"},
     *     path="/api/starplan/getlist",
     *     summary="获取所有",
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       ),
     *     )
     */
    public function getList(Request $request)
    {
        $list = StarPlan::orderBy('created_at', 'desc')
            ->get();
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
