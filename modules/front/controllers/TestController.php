<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/08/29
 * Time: 11:15:07
 */
namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\helpers\SMTP;

class TestController extends Controller {
    public function actionSend(){
        $smtpserver = "smtp.qq.com";//SMTP服务器
        $smtpserverport =25;//SMTP服务器端口
        $smtpusermail = "lijianeng10@qq.com";//SMTP服务器的用户邮箱
        $smtpemailto = "15805963038@163.com";//发送给谁
        $smtpuser = "lijianeng10@qq.com";//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
        $smtppass = "fmqfwsfttzlbbcjf";//SMTP服务器的授权码
        $mailtitle = "测试邮件";//邮件主题
        $mailcontent = "测试一下，你收到了吗";//邮件内容
        $mailtype = "HTML";//邮件格式（HTML/TXT）,TXT为文本邮件
        //************************ 配置信息 ****************************
        $smtp = new SMTP($smtpserver,$smtpserverport,true,$smtpuser,$smtppass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpemailto, $smtpusermail, $mailtitle, $mailcontent, $mailtype);
        print_r($state);die;

    }

}