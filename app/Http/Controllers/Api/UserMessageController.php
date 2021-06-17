<?php

namespace App\Http\Controllers\Api;

use App\Models\Activity;
use App\Models\UserMessage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserMessageController extends Controller
{
    /**
     * @OA\Get(
     *     security={{"bearer":{}}},
     *     tags={"用户管理"},
     *     path="/api/usermessage/getlist",
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
     *          name="type",
     *          description="类型，1表示系统消息，2表示互动消息",
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
        $userid=$request->userid;
        $type=$request->type;
        $where = [];
        $where[] = ['user_messages.user_id', '=', "$userid"];
        $where[] = ['user_messages.type', '=', "$type"];
        $list = UserMessage::join("users", "users.id", "=", "user_messages.from_user_id")
            ->where($where)
            ->orderBy('user_messages.created_at', 'desc')
            ->paginate($request->pageSize, ['*'], '', $request->pageNum);
        return response()->json([
            "code" => 0
            , "data" => $list
            , "msg" => "成功"
        ]);
    }
}
