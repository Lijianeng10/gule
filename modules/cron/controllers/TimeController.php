<?php

namespace app\modules\cron\controllers;

use Yii;
use yii\web\Controller;
//use app\modules\common\models\Machine;
use app\modules\common\models\ShopOrders;

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
     * 测试redis 添加队列
     */
    public function actionTestAddQueue(){
        $redis = \Yii::$app->redis;
        $time = date('Y-m-d H:i:s');
        $ary=[
            'num'=>rand(0,9999),
            'time'=>$time
        ];
        $ret = $redis->rpush("mylist",json_encode($ary));
        if($ret){
            echo "入队的值".$time;
        }else{
            echo "入队失败";
        }

    }
    /**
     * 测试redis 消费队列
     */
    public function actionTestLpopQueue(){
        $redis = \Yii::$app->redis;
        $value = $redis->lpop('mylist');
        $ary = json_decode($value,true);
        if($value){
            echo "出队的值".$ary['num'].' '.$ary['time'];
        }else{
            echo "出队完成";

        }
    }
    /**
     * 更新微信access_token
     * @return type
     */
    public function actionUpdateAccess_token() {
        $appId = \Yii::$app->params['wx_appid'];
        $appSecret = \Yii::$app->params['wx_app_secret'];

        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appId."&secret=".$appSecret;
        $access_token = '';
        $flag = 0;
        while (!$access_token) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            $result = json_decode($result, true);
            if (isset($result['access_token'])) {
                $access_token = $result['access_token'];
            }
            $flag++;
            if ($flag == 10) {
                break;
            }
        }
        \Yii::redisSet('wxgzh_token', $access_token, 6000);
        return $this->jsonResult(600, 'succ', ['token' => $access_token, 'flag' => $flag]);
    }

    /**
     * 定时取消订单
     */
    public function actionCancleNoPayOrders(){
//        $timer = date('Y-m-d H:i:s',strtotime('-30 minute'));//30分钟前
        $timer = date('Y-m-d H:i:s',strtotime('-2 hours'));
        $ret = ShopOrders::updateAll(['order_status'=>5,'pay_status'=>2],['and',['<=','order_time',$timer],['order_status'=>0,'pay_status'=>0]]);
        print_r($ret);
    }

}