<?php

namespace app\modules\tools\helpers;

use app\modules\common\models\PayRecord;
use app\modules\store\services\StoreService;

class PayTool {

    /**
     * 公众号支付
     * @param type $custNo
     * @param type $orderCode
     * @param type $money
     * @return boolean
     */
    public static function createQbThePublic($custNo, $orderCode, $money, $terminalNum, $machineCode) {
        $surl = 'https://open.goodluckchina.net/open/pay/buildPayCode';
        $attach = $orderCode;
        $qbAppId = \Yii::$app->params['java_appId'];
        $qbCallBack = \Yii::$app->params["userDomain"] . '/tools/qb-pay/qb-callback';
        if ($money < 2) {
            return ['code' => 109, 'msg' => '订单最低金额必须大于2元！！'];
        }
        $post_data = [
            'appid' => $qbAppId,
            'custNo' => $custNo,
            'money' => $money,
            'attach' => $attach,
            'mchOrderNo' => $attach,
            'model' => '00',
            'expireTime' => '5',
            'returnType' => '2',
            'callBackUrl' => $qbCallBack,
            'returnUrl' => \Yii::$app->params['userDomain'] . '/h5_ggc/purchase.html?terminalNum=' . $terminalNum . '&custNo=' . $custNo . '&machineCode=' . $machineCode . '&buyBack=1', // 跳转页面地址
//            'returnUrl' => \Yii::$app->params['userDomain'] . '/h5_ggc/success.html',
        ];
        $post_data['sign'] = self::getSign($post_data);
        $qbret = \Yii::sendCurlPost($surl, $post_data);
        return $qbret;
    }

    /**
     * 签名
     * @param type $post_data
     * @return type
     */
    public static function getSign($post_data) {
        ksort($post_data);
        $str = '';
        $flag = 1;
        foreach ($post_data as $k => $v) {
            if (!empty($v)) {
                if ($flag == 1) {
                    $str .= "{$k}={$v}";
                } else {
                    $str .= "&{$k}={$v}";
                }
                $flag++;
            }
        }
        $appKey = \Yii::$app->params["java_appKey"];
        $sign = md5($str . $appKey);
        return $sign;
    }

    /**
     * 支付回调处理
     * @param type $orderCode 己方订单号
     * @param type $outerNo  第三方交易订单号
     * @param type $totalAmount 交易金额
     * @param type $payTime 交易时间
     * @return type
     */
    public static function notify($orderCode, $outerNo, $totalAmount = 0, $payTime,  $custNo, $payChannel) {
        $key = 'confrimNotify:' . $orderCode;
        if (!\Yii::$app->redis->set($key, '1', "nx", "ex", 5)) {
            return ['code' => 2, 'msg' => '请稍后再试'];
        }
        $payTime = empty($payTime) ? date('Y-m-d H:i:s') : date('Y-m-d H:i:s', strtotime($payTime));
        
        $info = PayRecord::find()->select(['pay_record_id', 'pay_type'])->where(['order_code' => $orderCode, 'status' => 0, 'store_no' => $custNo])->asArray()->one();
        if (empty($info)) {
            return ['code' => 109, 'msg' => '没有该交易记录'];
        }
        $url = "";
        switch ($info['pay_type']) {
            case 1:
                $ret = StoreService::orderNotify($orderCode, $outerNo, $totalAmount, $payTime, $custNo, $payChannel);
                break;
        }
        return ['code' => 0, 'msg' => '回调操作成功'];
    }

}
