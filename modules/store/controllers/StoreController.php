<?php

namespace app\modules\store\controllers;

use app\modules\tools\helpers\PayTool;
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
        $custNo = $request->get('myCustNo', '');
        $terminalNum = $request->get('terminalNum', '');
        if(empty($terminalNum)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::toJumpPage($custNo, $terminalNum);
        return $this->redirect($ret);
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
//        $sellValue = $request->post('sellValue', '');
        if(empty($custNo) || empty($terminalNum) || empty($machineCode)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::activeMachine($custNo, $terminalNum, $machineCode);
        if($ret['code'] != 600) {
            return $this->jsonError($ret['code'], $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], $ret['data']);
    }
    
    /**
     * 获取彩种
     * @return type
     */
    public function actionGetLottery() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '');
        if(empty($custNo)) {
            return $this->jsonError(100, '参数缺失');
        }
        $ret = StoreService::getLottery($custNo, $terminalNum, $machineCode);
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
        $lottery = $request->post('lotteryId', '');
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
        $activeType = $request->post('activeType', ''); // 1：机箱库存扣除 2：总库存扣除
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
       $custNo = $request->post('myCustNo', '');
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
        $page = $request->post('pageNums', 0);
        $size = $request->post('size', 10);
        $ret = StoreService::getSaleList($custNo, $page, $size);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    
    /**
     * 获取进货记录列表
     * @return type
     */
    public function actionGetStockList() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $page = $request->post('pageNums', 0);
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
    
    /**
     * 解绑
     * @return type
     */
    public function actionMachineUnBinding() {
        $request = \Yii::$app->request;
        $custNo = $request->post('custNo', '');
        $terminalNum = $request->post('terminalNum', '');
        $machineCode = $request->post('machineCode', '');
        $ret = StoreService::machineUnBinding($custNo, $terminalNum, $machineCode);
        if($ret['code'] != 600) {
            return $this->jsonError(109, $ret['msg']);
        }
        return $this->jsonResult(600, $ret['msg'], true);
    }
    
    /**
     * 获取广告列表
     * @return type
     */
    public function actionGetBanner() {
        $request = \Yii::$app->request;
        $size = $request->post('size', 10);
        $bannerData = StoreService::getBanner($size);
        return $this->jsonResult(600, '获取成功', $bannerData);
    }
    /**
     * 获取广告内容
     */
    public function actionGetBannerContent() {
        $request = Yii::$app->request;
        $id = $request->post('id', '');
        if (empty($id)) {
            return $this->jsonError(109, '参数缺失');
        }
        $banner = StoreService::getBannerContent($id);
        return $this->jsonResult(600, '获取成功', $banner);
    }
    
    /**
     * 设备实际出票情况
     * @return type
     */
    public function actionIssueTicket() {
        $request = Yii::$app->request;
        $orderCode = $request->get('orderCode', '');
        $terminalNum = $request->get('terminalNum', '');
        $outStatus = $request->get('outStatus', '');
        $outNums = $request->get('outNums', 0);
        if(empty($orderCode) || empty($terminalNum)) {
            return $this->jsonError(109, '参数缺失');
        }
        $ret = StoreService::issueTicket($orderCode, $terminalNum, $outStatus, $outNums);
        if($ret['code'] != 600) {
            return $this->jsonError($ret['code'], $ret['msg']);
        }
        return $this->jsonResult(600, '成功', true);
        
    }

    public function actionTest(){


//        $qbRet = PayTool::createQbThePublic('gl00002324', '868926033600849000000000', 5, 'PS100002', '868926033600849000000000');
//        print_r($qbRet);die;

        $data =[
            'appid' => '362a00a28e234199a0d911cbdd1d4c671',
            'custNo' => 'gl00002324',
            'money' => 5,
            'attach' => '868926033600849000000000',
            'mchOrderNo' => '868926033600849000000000',
            'model' => '00',
            'expireTime' => 5,
            'returnType' => 2,
            'callBackUrl' => 'http://114.115.148.102:8011/tools/qb-pay/qb-callback',
            'returnUrl' => 'http://114.115.148.102:8011/h5_ggc/purchase.html?terminalNum=PS100002&custNo=gl00002324&machineCode=868926033600849000000000',
            'sign' => '6cda3c95d50e13eb9c33d299218c3e33'
        ];

        $ret = Yii::sendCurlPost('https://open.goodluckchina.net/open/pay/buildPayCode',$data);

        print_r($ret);
    }
}
