<?php

namespace app\modules\front\controllers;

use app\modules\tools\helpers\PayTool;
use Yii;
use yii\web\Controller;
use app\modules\store\services\StoreService;

class LoginController extends Controller {

    /**
     * 获取跳转页面
     * @return type
     */
    public function actionIndex() {
//        $agent = $_SERVER['HTTP_USER_AGENT'];
        echo 1111;die;
        $request = \Yii::$app->request;
        $custNo = $request->get('myCustNo', '');
        $statusBarHeight = $request->get('statusBarHeight', '');
        if (!$custNo) {
            if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') === false) {
                //非支付宝 返回错误提示
                $url = \Yii::$app->params['userDomain'] . '/h5_ggc/error.html?msg=请使用支付宝客户端扫码购彩' . '&statusBarHeight=' . $statusBarHeight;
                return $this->redirect($url);
            }
        }
        $terminalNum = $request->get('terminalNum', '');
        if (empty($terminalNum)) {
            $url = \Yii::$app->params['userDomain'] . '/h5_ggc/error.html?msg=参数缺失' . '&statusBarHeight=' . $statusBarHeight;
            return $this->redirect($url);
        }
        $ret = StoreService::toJumpPage($custNo, $terminalNum, $statusBarHeight);
        return $this->redirect($ret);
    }

}
