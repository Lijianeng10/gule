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
use app\modules\common\services\MailService;
use app\modules\common\helpers\SMTP;


class TestController extends Controller {
    public function actionSend(){
        $smtpEmailTo = '15805963038@163.com';
        $mailTitle = '测试发送邮件';
        $mailContent = '<p style="color: red;text-align: center">你看到的文字是红色且居中显示的吗？从服务层调用的！</p>';
        $ret = MailService::sendMail($smtpEmailTo,$mailTitle,$mailContent);
        print_r($ret);die;
    }

}