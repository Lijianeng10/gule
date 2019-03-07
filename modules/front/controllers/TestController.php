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
    /**
     * 发送邮件
     *
     * @param string $from      发送邮箱
     * @param string $to        收件邮箱
     * @param string $subject   主题
     * @param string $body      邮件内容，默认使用html
     *
     * @return bool
     */
    public function actionIndex()
    {
        $from = Yii::$app->params['smtpUsermail'];
        $to = "15805963038@163.com";
        $subject = "早上好啊!";
        $body = '嘿嘿嘿';
        $mailer = Yii::$app->mailer->compose();
        $mailer->setFrom($from);
        $mailer->setTo($to);
        $mailer->setSubject($subject);
        $mailer->setHtmlBody($body);
        $status = $mailer->send();
        print_r($status);die;
    }

}