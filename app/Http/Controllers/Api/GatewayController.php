<?php

namespace App\Http\Controllers\Api;

use App\Models\Feedback;
use App\Models\TutorBind;
use GatewayWorker\Lib\Gateway;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class GatewayController extends Controller
{
    /**
     * @OA\Post(
     *     security={{"bearer":{}}},
     *     tags={"导师"},
     *     path="/api/gateway/bind",
     *     summary="将client_id与user_id绑定起来",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              @OA\Property(property="client_id", type="string",description="client_id"),
     *              @OA\Property(property="group_id", type="integer",description="分组id，也即是导师id")
     *              ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="成功"
     *       )
     *     )
     */
    public function bind(Request $request)
    {
        $client_id = $request->client_id;
        $userid = $request->userid;
        $group_id = $request->group_id;
        $tutorbind = new TutorBind();
        $gettutorbind = TutorBind::where([['user_id', '=', $userid], ['group_id', '=', $group_id]])->first();
        if ($gettutorbind) {
            $tutorbind = $gettutorbind;
        } else {
            $tutorbind->client_id = $client_id;
            $tutorbind->user_id = $userid;
            $tutorbind->group_id = $group_id;
        }
        $tutorbind->client_id = $client_id;
        if ($tutorbind->save()) {
            Gateway::bindUid($client_id, $userid);
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
}
