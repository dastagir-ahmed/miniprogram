<?php
namespace paynotify;
use App\Models\UserVipOrder;

class PayNotify implements \Payment\Contracts\IPayNotify
{
    /**
     * 处理自己的业务逻辑，如更新交易状态、保存通知数据等等
     * @param string $channel 通知的渠道，如：支付宝、微信、招商
     * @param string $notifyType 通知的类型，如：支付、退款
     * @param string $notifyWay 通知的方式，如：异步 async，同步 sync
     * @param array $notifyData 通知的数据
     * @return bool
     */
    public function handle(
        string $channel,
        string $notifyType,
        string $notifyWay,
        array $notifyData
    ) {
        //根据商户号 out_trade_no    更新订单状态user_vip_orders表、user_vips新增或更新用户数据
        if($channel=='Alipay'){
            if($notifyData->trade_status=='TRADE_SUCCESS'){
                //支付成功
                $userVipOrder=UserVipOrder::where([['code','=',$notifyData->out_trade_no],['pay_from','=',1]])->first();
                $userVipOrder->pay_no=$notifyData->buyer_logon_id;
                $userVipOrder->pay_code=$notifyData->trade_no;
                $userVipOrder->pay_time=$notifyData->gmt_payment;
                if(!$userVipOrder->save()){
                    return false;
                }
            }
        }
        return true;
    }
}
