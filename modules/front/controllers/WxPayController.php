<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/09/17
 * Time: 15:41:01
 */
namespace app\modules\front\controllers;

use yii\web\Controller;
use app\modules\common\helpers\WxPay;

class WxPayController extends Controller{
    /**
     *小程序预下单
     */
    public function actionWxPayOrder(){
//        $userId =$this->userId;
//        $request = \Yii::$app->request;
//        $orderCode = $request->post_nn("orderCode");
//        //根据用户user_id 获取openid
//        $user = ThirdUser::find()->where(["uid"=>$userId, 'type' => 2])->asArray()->one();
//        if(empty($user)){
//            return $this->jsonError(109,"查无此用户，请确保绑定手机完成授权");
//        }
//        //获取交易记录
//        $orders =ShopOrders::find()->where(["order_code"=>$orderCode,"status"=>0])->asArray()->one();
//        if(empty($orders)){
//            return $this->jsonError(109,"查无此订单，请检查！");
//        }
        $body = '咕啦商城-购买商品';
        $money = floatval(0.01*100);//接口中参数支付金额单位为【分】
        $wxPay =new WxPay();
        $ret =$wxPay->unifiedorder(date('YmdHis'),$body,$money,'oJPbb1Q0ViLS_bwZmFTDCMjPtKgE');
        if($ret["code"]!=600){
            return $this->jsonError($ret['code'],$ret['msg']);
        }
        return $this->jsonResult(600,'下单成功',$ret['data']);
    }
    /**
     * 回调支付通知
     */
    public function actionPayNotice(){
        $postData = \Yii::$app->request->post();
//        KafkaService::addLog("appletsPaylog",var_export($postData,true));
        $wxPay =new WxPay();
        $ret = $wxPay->notify($postData);
//        if($ret['code']!=600){
//            KafkaService::addLog("appletsPayError",var_export($ret['msg'].'&postData='.$postData,true));
//        }
        return $wxPay->return_success("SUCCESS","OK");
    }
    /**
     * 回调退款通知
     */
    public function actionRefundNotice(){
        $postData = \Yii::$app->request->post();
        KafkaService::addLog("appletsRefundlog",var_export($postData,true));
        $wxPay =new WxPay();
        $ret = $wxPay->refundNotify($postData);
        if($ret['code']!=600){
            KafkaService::addLog("appletRefundError",var_export($ret['msg'].'&postData='.$postData,true));
        }
        return $wxPay->return_success("SUCCESS","OK");
    }
}