<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\user\models\User;

class UserController extends Controller {
    public function actionRegister(){
        $request = \Yii::$app->request;
        $phone = trim($request->post('phone',''));
        $password = $request->post('password','');
        $surePwd = $request->post('surePwd','');
        if(empty($phone)||empty($password)||empty($surePwd)){
            return $this->jsonError(109,'参数缺失！');
        }
        if(trim($password)!=trim($surePwd)){
            return $this->jsonError(109,'两次密码不一致，请检查！');
        }
        $userInfo = User::find()->where(['phone'=>$phone])->one();
        if(!empty($userInfo)){
            return $this->jsonError(109,'该手机号已被注册，请检查！');
        }
        $user = new  User();
        $custNo =$this->getCustNo();
        $user->cust_no = $custNo;
        $user->nickname = $phone;
        $user->phone = $phone;
        $user->pwd =md5($password);
        $user->create_time =date('Y-m-d H:i:s');
        if(!$user->save()){
            return $this->jsonError(109,'注册失败！'.$user->getErrors());
        }
        return $this->jsonResult(600,'注册成功！',$custNo);
    }
    /**
     * 生成唯一用户编号
     */
    public function getCustNo(){
        $No= \Yii::redisIncr('register_no');
        $cust_no = "gl" . $No;
        return $cust_no;
    }

}
