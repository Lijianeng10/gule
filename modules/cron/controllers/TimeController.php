<?php

namespace app\modules\cron\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Machine;

class TimeController extends Controller {
    /**
     * 定时取在线机器数据
     */
    public function actionGetOnLineMachine(){
        $url = Yii::$app->params['machine_service'] . 'getOnLineMachine';
        $postData = ['sign' => 'getOnLineMachine'];
        $ret = Yii::sendCurlPost($url, $postData);
        Machine::updateAll(['online_status'=>0]);
        if(!empty($ret['data'])){
            $upStr= '';
            foreach ($ret['data'] as $k=>$v){
                $upStr .= "update machine set online_status = 1 where machine_code = {$v['machine_no']} and status in (0,1);";
            }
            $db =  Yii::$app->db->createCommand($upStr)->execute();
            return $this->jsonResult(600,'执行成功'.$db.'条');
        }
        return $this->jsonResult(600,'执行成功');
    }

    /**
     * 测试定时服务器
     */
    public function actionTestCron(){
        return $this->jsonResult(600,'执行成功',date('Y-m-d H:i:s'));
    }

}