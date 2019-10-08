<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/05/28
 * Time: 10:30:34
 */

namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;

class TestController extends Controller{

    public function actionTest(){
        $request = Yii::$app->request;
        $imageTemplate = $request->post('imageTemplate');
        $imageTarget = $request->post('imageTarget');
        $token = self::getToken();
        $url = 'https://aip.baidubce.com/rest/2.0/face/v1/merge?access_token=' . $token;
        $bodys = [
            'image_template'=>['image'=>$imageTemplate,'image_type'=>'BASE64','quality_control'=>'NONE'],
            'image_target'=>['image'=>$imageTarget,'image_type'=>'BASE64','quality_control'=>'NONE']
        ];
        $res = json_decode(self::request_post($url, json_encode($bodys)),true);
        $img = base64_decode($res['result']['merge_image']);
        Header( "Content-type: image/jpeg");//直接输出显示jpg格式图片
        echo $img;
    }

    public static function getToken(){
        $url = 'https://aip.baidubce.com/oauth/2.0/token';
        $post_data['grant_type']       = 'client_credentials';
        $post_data['client_id']      = 'UqecKsfwXVY0uRhwZypS1qvj';
        $post_data['client_secret'] = 'B8mj2DuPZsdiDomR8ljbdryalehzW6eR';
        $o = "";
        foreach ( $post_data as $k => $v )
        {
            $o.= "$k=" . urlencode( $v ). "&" ;
        }
        $post_data = substr($o,0,-1);
        $res = json_decode(self::request_post($url, $post_data),true);
        return $res['access_token'];
    }

    public static function request_post($url = '', $param = '')
    {
        if (empty($url) || empty($param)) {
            return false;
        }

        $postUrl = $url;
        $curlPost = $param;
        // 初始化curl
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $postUrl);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        // 要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // post提交方式
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        // 运行curl
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }

}