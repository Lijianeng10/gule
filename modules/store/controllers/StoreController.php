<?php

namespace app\modules\store\controllers;

use Yii;
use yii\web\Controller;
use app\modules\store\services\StoreService;

class StoreController extends Controller {
    
    /**
     * 获取跳转页面
     * @return type
     */
    public function actionToJumpPage() {
        $request = \Yii::$app->request;
        $custNo = $request->get('custNo', '');
        if($custNo == 'gl00002324'){
            return $this->redirect('http://caipiao.goodluckchina.net');
        }
        $terminalNum = $request->get('terminalNum', '');
        if(empty($terminalNum)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::toJumpPage($custNo, $terminalNum);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], $ret['data']);
    }
    
    /**
     * 激活绑定机器
     * @return type
     */
    public function actionActiveMachine() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '868926033601029000000000');
        $sellValue = $request->post('sellValue', '');
        if(empty($custNo) || empty($terminalNum) || empty($machineCode) || empty($sellValue)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::activeMachine($custNo, $terminalNum, $machineCode, $sellValue);
        if($ret['code'] != 600) {
            return $this->jsonError($ret['code'], $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], true);
    }
    
    /**
     * 获取彩种
     * @return type
     */
    public function actionGetLottery() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        if(empty($custNo)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::getLottery($custNo);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    
    /**
     * 修改设备出售彩种
     * @return type
     */
    public function actionChangeSellLottery() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '868926033601029000000000');
        $lottery = $request->post('lottery', '');
        $lotteryValue = $request->post('lotteryValue', '');
        if(empty($custNo) || empty($terminalNum) || empty($lottery) || empty($lotteryValue) || empty($machineCode)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::changeMachineLottery($custNo, $terminalNum, $lottery, $lotteryValue, $machineCode);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], true);
    }
    
    /**
     * 修改机器库存补给
     * @return type
     */
    public function actionChangeMachineStock() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '868926033601029000000000');
        $stock = $request->post('nums', '');
        $activeType = $request->post('activeType', ''); // 1：库存补给 2：库存扣除
        $ret = StoreService::changeMachineStock($custNo, $terminalNum, $machineCode, $activeType, $stock);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], true);
    }
    
    /**
     * 获取门店详情
     * @return type
     */
    public function actionGetStoreDetail() {
       $request = \Yii::$app->request;
       $custNo = $request->post('custNo', '');
       $ret = StoreService::getStoreDetail($custNo);
       if($ret['code'] != 600) {
           return $this->jsonError(109, $ret['msg']);
       }
       return $this->jsonResult(600, '获取成功', $ret['data']);
    }
    
    /**
     * 获取销售列表
     * @return type
     */
    public function actionGetSaleList() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $page = $request->post('page_nums', 0);
        $size = $request->post('size', 10);
        $ret = StoreService::getSaleList($custNo, $page, $size);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    
    /**
     * 获取进货记录列表
     * @return type
     */
    public function actionGetOrderList() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $page = $request->post('page_nums', 0);
        $size = $request->post('size', 10);
        $ret = StoreService::getStockList($custNo, $page, $size);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    
    /**
     * 获取设备销售界面
     * @return type
     */
    public function actionGetMachineGoods() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '');
        $ret = StoreService::getMachineGoods($custNo, $terminalNum, $machineCode);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, '获取成功', $ret['data']);
    }
    
    /**
     * 设备开锁
     * @return type
     */
    public function actionOpenMachine() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '');
        $ret = StoreService::openMachine($custNo, $terminalNum, $machineCode);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], true);
    }
    
    /**
     * 设备下单
     * @return type
     */
    public function actionPlayOrder() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '');
        $buyNums = $request->post('buyNums', '');
        $payMoney = $request->post('payMoney', '');
        $ret = StoreService::playOrder($custNo, $terminalNum, $machineCode, $buyNums, $payMoney);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], $ret['data']);
    }
    
    public function actionTest() {
        $valueLength = \app\modules\common\helpers\Constants::VALUE_LENGTH;
        $url = \Yii::$app->params['order_service'] . 'add';
        $md5Code = 'PS100001' . '201811011601151016943027c';
        $sign = \app\modules\common\helpers\Commonfun::getSign($md5Code);
        $postData = ['cust_no' => 'PS100001', 'order_no' => '201811011601151016943027c', 'price' => 5, 'quantity' => 2, 'lottery_length' => $valueLength[5], 'sign' => $sign];
        $ret = \Yii::sendCurlPost($url, $postData);
        print_r($ret);
    }
    
}
