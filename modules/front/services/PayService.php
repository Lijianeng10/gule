<?php

namespace app\modules\front\services;

use Yii;
use yii\db\Query;
use yii\base\Exception;
use app\modules\common\helpers\Commonfun;
use app\modules\common\models\ShopPayRecord;

class PayService{
    /**
     * 生成交易记录
     * @param type $orderId 订单ID
     * @param type $custNo 用户编号
     * @param type $userId 用户ID
     * @param type $orderCode 订单编号
     * @param type $payType 支付类型 1 购买 2退款
     * @param type $payWay 支付渠道 1 支付宝  2微信支付 3余额 4 合支付 5 钱包H5',
     * @param type $preMoney 预支付金额
     */
    public function addPayRecord($orderId,$orderCode,$userId,$custNo,$payType,$payWay,$preMoney) {
        $pay = new ShopPayRecord();
        $pay->record_code=Commonfun::getShopCode("PAY", "P");
        $pay->order_id = $orderId;
        $pay->order_code = $orderCode;
        $pay->user_id=$userId;
        $pay->cust_no = $custNo;
        $pay->pay_type = $payType;
        $pay->pay_way = $payWay;
        $pay->pre_money = $preMoney;
        $pay->status = 0;
        $pay->create_time = date("Y-m-d H:i:s");
        $pay->modify_time = date("Y-m-d H:i:s");
        $pay->save();
    }
    /**
     * 退款支付信息记录操作
     * @param $orderCode 订单code
     * @param $type 操作type 1 新增退款记录 2 退款回调更新退款状态
     * @param $refundCode  1 内部退款编号 2 第三方返回退款编号
     * @param $successTime 退款成功至账户时间
     */
    public function createOrUpdateRefundRecord($orderCode,$type,$refundCode='',$successTime=''){
        $time = date("Y-m-d H:i:s");
        switch ($type){
            case 1:
                $payRecord = ShopPayRecord::find()->where(['order_code'=>$orderCode,'pay_type'=>1,'status'=>1])->asArray()->one();
                //新增退款记录
                $record = new ShopPayRecord();
                $record->record_code = Commonfun::getShopCode("PAY", "T");
                $record->order_id = $payRecord['order_id'];
                $record->order_code = $payRecord['order_code'];
                $record->user_id = $payRecord['user_id'];
                $record->cust_no = $payRecord['cust_no'];
                $record->outer_code =$payRecord['outer_code'];
                $record->refund_code = $refundCode;
                $record->pay_type = 2;
                $record->pay_way = 2;
                $record->pre_money = $payRecord['pre_money'];
                $record->pay_money =$payRecord['pay_money'];
                $record->status = 0;
                $record->create_time = $time;
                if($record->save()){
                    return ['code'=>600,'msg'=>'操作成功'];
                }else{
                    return ['code'=>109,'msg'=>'操作失败'.$record->getFirstErrors()];
                }
                break;
            case 2:
                $payRecord = ShopPayRecord::find()->where(['order_code'=>$orderCode,'pay_type'=>2,'status'=>0])->one();
                if(empty($payRecord)){
                    return ['code'=>109,'msg'=>'无符合条件订单，无需操作'];
                }
                $payRecord->third_refund_code = $refundCode;
                $payRecord->status  = 2;
                $payRecord->pay_time  = $successTime;
                $payRecord->modify_time  = $time;
                if($payRecord ->save()){
                    return ['code'=>600,'msg'=>'操作成功'];
                }else{
                    return ['code'=>109,'msg'=>'操作失败'.$payRecord->getFirstErrors()];
                }
                break;
        }

    }
}
