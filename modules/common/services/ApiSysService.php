<?php

namespace app\modules\common\services;

use app\modules\common\models\PayRecord;
use app\modules\common\models\IceRecord;

class ApiSysService {
    
    /**
     * 获取sqlserver路由
     * @return type
     */
    public static function getBaseUrl() {
        return \Yii::$app->params['backup_sqlserver'];
    }
    
    /**
     * 同步交易处理明细表
     * @param type $payRecordId
     * @return type
     */
    public static function payRecord($payRecordId) {
        //获取路由
        $sendUrl = self::getBaseUrl() . 'order/pay_record';
        $retData['pay_record'] = PayRecord::find()->where(['pay_record_id' => $payRecordId])->asArray()->all();
        $jsonData = json_encode($retData);
        $ret = \Yii::sendCurlPost($sendUrl, $jsonData);
        return $ret;
    }
    
    /**
     * 同步冻结明细表
     * @param type $iceRecordId
     * @return type
     */
    public static function iceRecord($iceRecordId) {
        //获取路由
        $sendUrl = self::getBaseUrl() . 'order/ice_record';
        $retData['pay_record'] = IceRecord::find()->where(['ice_record_id' => $iceRecordId])->asArray()->all();
        $jsonData = json_encode($retData);
        $ret = \Yii::sendCurlPost($sendUrl, $jsonData);
        return $ret;
    }
    
    /**
     * 获取sqlserver订单的中奖金额
     * @param type $orderCode
     * @return type
     */
    public static function getWinAamount($orderCode) {
        $sendUrl = self::getBaseUrl() . 'order/get_win_amount';
        $retData['lottery_order_code'] = $orderCode;
        $jsonData = json_encode($retData);
        $ret = \Yii::sendCurlPost($sendUrl, $jsonData);
        return $ret;
    }
}

