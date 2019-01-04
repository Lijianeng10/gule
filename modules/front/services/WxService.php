<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/01/03
 * Time: 15:15:08
 */
namespace app\modules\front\services;

use Yii;
use yii\base\Exception;
use yii\db\Expression;

class WxService{
    /**
     * 获取微信accessToken
     */
    public static function getAccessToken()
    {
        $appID = \Yii::$app->params['wx_appid'];
        $appSecret = \Yii::$app->params['wx_app_secret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appID."&secret=".$appSecret ;
        $ret = \Yii::sendCurlGet($url);

    }

}