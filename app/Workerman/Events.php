<?php


namespace App\Workerman;


use App\Models\TutorBind;
use App\Models\TutorMessage;
use GatewayWorker\Lib\Gateway;

class Events
{
    public static function onWorkerStart($businessWorker)
    {
    }

    /**
     * 客户端连接到服务端时触发
     * @param $client_id
     */
    public static function onConnect($client_id)
    {
        Gateway::sendToClient($client_id, json_encode(array(
            'type' => 'init',
            'client_id' => $client_id
        )));
    }

    /**
     * 客户端发送消息到服务端时触发
     * @param $client_id
     * @param $message
     */
    public static function onMessage($client_id, $message)
    {
        $data = json_decode($message);
        $group_id = $data->group_id;
        $user_id = $data->user_id;
        $msg = $data->msg;
        //插入消息记录
        $tutormessage = new TutorMessage();
        $tutormessage->user_id = $user_id;
        $tutormessage->group_id = $group_id;
        $tutormessage->message = $msg;
        if ($tutormessage->save()) {
            Gateway::sendToGroup($group_id, $msg);
        } else {
            Gateway::sendToClient($client_id, json_encode(array(
                'code' => -1,
                'msg' => "失败"
            )));
        }
    }

    /**
     * 客户端离线时触发
     * @param $client_id
     */
    public static function onClose($client_id)
    {

    }


}
