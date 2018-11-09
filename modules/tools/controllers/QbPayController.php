<?php

namespace app\modules\tools\controllers;

use yii\web\Controller;
use app\modules\tools\helpers\PayTool;

class QbPayController extends Controller {

    /**
     * 钱包回调
     * @return string
     */
    public function actionQbCallback() {
        $request = \Yii::$app->request;
        $returnCode = $request->post('return_code'); //返回编码
        $returnMsg = $request->post('return_msg'); //返回说明
        $money = $request->post('money'); //实际支付金额
        $payStatus = $request->post('pay_status'); //支付状态success、close、finish、unkown
        $payTime = $request->post('pay_time'); //支付时间戳
        $tradeNo = $request->post('trade_no'); //订单编号(钱包的)
        $attach = $request->post('attach'); //商户订单号(我们的订单id)
        $custNo = $request->post('cust_no'); //商户编号
        $payChannel = $request->post('pay_channel'); //01支付宝，02微信
        $orderId = $request->post('order_id'); //支付订单id(钱包的)
        $redisData = ['attach' => $attach, 'orderId' => $orderId, 'money' => $money, 'payTime' => $payTime, 'custNo' => $custNo, 'payChannel' => $payChannel];
        \Yii::redisSet('call-back', $redisData, 600);
        if ($payStatus == "success") {
            PayTool::notify($attach, $orderId, $money, $payTime, $custNo, $payChannel);
        } else {
//            $payRecord = PayRecord::find()->select('*')->where(['order_code' => $attach, 'status' => 0])->asArray()->one();
            //订单取消
        }
        return 'success';
    }

}
