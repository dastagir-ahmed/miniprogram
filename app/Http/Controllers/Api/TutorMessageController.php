<?php

namespace App\Http\Controllers\Api;

use App\Models\UserMessage;
use GatewayWorker\Lib\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TutorMessageController extends Controller
{
    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"导师"},
     *     path="/api/totormessage/getlist",
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
     *    @OA\Parameter(
     *          name="group_id",
     *          description="分组id",
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
        $userid=$request->userid;
        $group_id=$request->group_id;
        $where = [];
        $where[] = ['tutor_messages.user_id', '=', "$userid"];
        $where[] = ['tutor_messages.group_id', '=', "$group_id"];
        $list = UserMessage::join("users", "users.id", "=", "tutor_messages.user_id")
            ->where($where)
            ->orderBy('tutor_messages.created_at', 'desc')
            ->paginate($request->pageSize, ['*'], '', $request->pageNum);
        if($request->pageNum==1){
            Gateway::joinGroup(Gateway::getClientIdByUid($userid), $group_id);
        }
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
