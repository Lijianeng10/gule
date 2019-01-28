<?php

namespace app\modules\front\controllers;


use Yii;
use yii\web\Controller;
use app\modules\pay\helpers\WxPay;
use app\modules\front\services\OrderService;

class OrderController extends Controller {

    /**
     * 商城下单
     * @return type
     */
    public function actionPlayOrder() {
        $request = \Yii::$app->request;
        $post = $request->post();
        $custNo = $this->custNo;
        $userId = $this->userId;
//        $user = ThirdUser::find()->where(["uid"=>$userId,'type'=>2])->asArray()->one();
//        if(empty($user)){
//            return $this->jsonError(109,"查无此用户授权信息，请确保账户已绑定手机完成授权！");
//        }
//        $user['third_uid']
        $ret = OrderService::validateOrder($post, $custNo, $userId,'');
        if($ret['code'] != 600) {
            return $this->jsonError($ret['code'], $ret['msg']);
        }
        return $this->jsonResult($ret['code'], $ret['msg'],'');
    }

    /**
     * 取消订单
     * @return type
     */
    public function actionCancelOrder() {
        $request = \Yii::$app->request;
        $userId = $this->userId;
        $orderCode = $request->post('order_code', '');
        if(empty($orderCode)) {
            return $this->jsonError(109, '参数缺失');
        }
        $ret = OrderService::cancelOrder($orderCode, $userId);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, '取消成功', true);
    }

    /**
     * 获取订单列表
     * @return type
     */
    public function actionGetOrderList() {
        $request = \Yii::$app->request;
        $userId = $this->userId;
        $type = $request->post('type', ''); // 0：待付款 1：待发货 2：待收货 3:退款、售后 4:已完成
        $page = $request->post('page', 1);
        $size = $request->post('size', 10);
        $orderData = OrderService::getOrderList($userId, $type, $page, $size);
        return $this->jsonResult(600, '获取成功', $orderData);
    }

    /**
     * 获取订单详情
     * @return type
     */
    public function actionGetOrderDetail() {
        $request = \Yii::$app->request;
        $orderId = $request->post('order_id', '');
        if(empty($orderId)) {
            return $this->jsonError(109, '参数缺失');
        }
        $orderData = OrderService::getOrderDetail($orderId);
        return $this->jsonResult(600, '获取成功', $orderData);
    }
    /**
     * 获取用户订单数量统计
     */
    public function actionGetUserOrderNum(){
        $request = \Yii::$app->request;
        $userId = $this->userId;
        $orderNums = OrderService::getOrderNum($userId);
        return $this->jsonResult(600, '获取成功', $orderNums);
    }
    /**
     *用户确认收货
     */
    public function actionConfirmReceipt(){
        $userId = $this->userId;
        $request = \Yii::$app->request;
        $orderCode = $request->post('order_code', '');
        if(empty($orderCode)){
            return $this->jsonError(109, '参数缺失');
        }
        $res = OrderService::confirmReceipt($orderCode,$userId);
        if($res['code']!=600){
            return $this->jsonError($res['code'],$res['msg']);
        }
        return $this->jsonResult(600,'操作成功！');
    }
    /**
     * 申请退款
     */
    public function actionRequestRefund(){
        $request = \Yii::$app->request;
        $orderCode = $request->get('order_code', '');
        if(empty($orderCode)){
            return $this->jsonError(109, '参数缺失');
        }
        $wxPay = new WxPay();
        $ret = $wxPay->requestRefund($orderCode);
        return $this->jsonResult($ret['code'],$ret['msg']);

    }
    /**
     * 待发货订单修改收货地址
     */
    public function actionUpdateOrderAddress(){
        $userId = $this->userId;
        $request = \Yii::$app->request;
        $orderCode = $request->post('order_code', '');
        $addressId = $request->post('address_id', '');
        if(empty($orderCode)||empty($addressId)){
            return $this->jsonError(109,'参数缺失');
        }
        $res = OrderService::updateOrderAddress($orderCode,$userId,$addressId);
        return $this->jsonResult($res['code'],$res['msg']);
    }

}