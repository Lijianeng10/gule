<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/03/04
 * Time: 09:27:10
 */
namespace app\modules\common\services;

use Yii;
use app\modules\common\helpers\SMTP;

class MailService{
    /**
     * 发送邮件
     * @param $smtpEmailTo //发送给谁
     * @param $mailTitle //发送标题
     * @param $mailContent //发送内容
     * @param string $mailType //发送格式  HTML、TXT
     * @return bool
     */
    public static function sendMail($smtpEmailTo,$mailTitle,$mailContent,$mailType='HTML'){
        $smtpServer = \Yii::$app->params['smtpServer'];
        $smtpServerport = \Yii::$app->params['smtpServerport'];
        $smtpUsermail = \Yii::$app->params['smtpUsermail'];
        $smtpUser = \Yii::$app->params['smtpUser'];
        $smtpPass = \Yii::$app->params['smtpPass'];
        $smtp = new SMTP($smtpServer,$smtpServerport,true,$smtpUser,$smtpPass);//这里面的一个true是表示使用身份验证,否则不使用身份验证.
        $smtp->debug = false;//是否显示发送的调试信息
        $state = $smtp->sendmail($smtpEmailTo, $smtpUsermail, $mailTitle, $mailContent, $mailType);
        return $state;
    }
}