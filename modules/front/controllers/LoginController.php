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
            $signature = $_GET['signature'] ;
            $timestamp = $_GET['timestamp'] ;
            $nonce = $_GET['nonce'] ;
            $echostr = $_GET['echostr'] ;
            $token = 'weixin' ;

            $arr = array($token,$timestamp,$nonce) ;
            //自然排序
            sort($arr) ;
            //拆成字符串 加密
            $str = sha1(implode($arr)) ;
            /*
                第一次配置个人服务器时候 为新服务器会传递参数$echostr
                与个人服务器建立连接之后  不会传递该参数
            */
            if($str == $signature && $echostr) {
                echo $echostr ;
                die ;
            }
        }


}
