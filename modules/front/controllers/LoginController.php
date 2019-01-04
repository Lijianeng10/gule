<?php

namespace app\modules\front\controllers;

use app\modules\tools\helpers\PayTool;
use Yii;
use yii\web\Controller;
use app\modules\store\services\StoreService;

class LoginController extends Controller {

    /**
     * 微信配置token验证
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
       //第一次配置个人服务器时候 为新服务器会传递参数$echostr,与个人服务器建立连接之后  不会传递该参数
        if($str == $signature && $echostr) {
            echo $echostr ;
            die ;
        }
    }
    public function actionSetMenu(){
        $access_token = \Yii::redisGet('wxgzh_token');
        $url = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=' . $access_token;
        $ary = [
            'button' => [
                [
                    'name' => urlencode('菜单一'),
                    'type' => 'click',
                    'key' => 'item1'
                ],
                [
                    'name' => urlencode('菜单二'),
                    'sub_button' => [
                        [
                            'name' => urlencode('歌曲'),
                            'type' => 'click',
                            'key' => 'songs'
                        ],
                        [
                            'name' => urlencode('电影'),
                            'type' => 'view',
                            'url' => 'http://www.baidu.com'
                        ]
                    ]
                ]
            ]
        ];
        $postAry = urldecode(json_encode($ary));
        $ret = \Yii::sendCurlPost($url,$postAry);
        print_r($ret);die;

    }


}
