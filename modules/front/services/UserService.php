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
use app\modules\common\models\User;

class UserService{
    /**
     * 自动登录 生成token
     * @param $custNo 用户编号
     * @param $userId 用户ID
     * @param string $objStr 类型
     * @return mixed
     */
    public static function autoLogin($custNo, $userId, $objStr = 'user') {
        $token = self::createToken($custNo); //生成token
        $oldToken = \Yii::tokenGet("{$objStr}_token:{$custNo}");
        \Yii::tokenDel("token_{$objStr}:{$oldToken}");
        \Yii::tokenSet("token_{$objStr}:{$token}", "{$custNo}|{$userId}"); //保存token
        \Yii::tokenSet("{$objStr}_token:{$custNo}", "{$token}"); //保存token
        return $token;
    }
    /**
     * 说明: 生成token方法
     * @param $custNo 用户编号
     * @return
     */
    public function createToken($custNo) {
        $salt = 'GL_token_php';
        $all = $custNo . $salt . time();
        return md5($all);
    }

    /**
     * 完善账户信息
     * @param $realName 真实姓名
     * @param $idCardNum 身份证号
     * @param $eMail 电子邮箱
     * @param $address 居住地址
     */
    public static function setUserInfo($custNo,$realName,$idCardNum,$eMail,$address){
        $user = User::find()->where(['cust_no'=>$custNo])->one();
        $user->real_name = $realName;
        $user->id_card_num = $idCardNum;
        $user->e_mail = $eMail;
        $user->address = $address;
        if($user->real_status ==0){
            $user->real_status = 1;
        }
        if(!$user->save()){
            return ['code'=>109,'msg'=>$user->getErrors()];
        }
        return ['code'=>600,'msg'=>'提交成功！'];
    }
    /**
     * 完善用户银行信息
     * @param $accountName 开户姓名
     * @param $bankName 银行名称
     * @param $bankCardNum 银行卡号
     */
    public static function setUserBankInfo($custNo,$accountName,$bankName,$bankCardNum){
        $user = User::find()->where(['cust_no'=>$custNo])->one();
        $user->account_name = $accountName;
        $user->bank_name = $bankName;
        $user->bank_card_num = $bankCardNum;
        if(!$user->save()){
            return ['code'=>109,'msg'=>$user->getErrors()];
        }
        return ['code'=>600,'msg'=>'提交成功！'];
    }

}