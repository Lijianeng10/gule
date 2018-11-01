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
        $machineCode = $request->post('machineCode', '');
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
    
    public function actionChangeLottery() {
        
    }
}
