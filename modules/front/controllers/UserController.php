<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\User;
use app\modules\front\services\UserService;

class UserController extends Controller {
    public function actionRegister(){
        $request = \Yii::$app->request;
        $phone = trim($request->post_nn('phone'));
        $password = $request->post_nn('password');
        $surePwd = $request->post_nn('surePwd');
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
        $token = UserService::autoLogin($user->cust_no, $user->attributes['user_id']); //自动登录
        $result =[
            'cust_no'=>$user->cust_no,
            'token'=>$token
        ];
        return $this->jsonResult(600,'注册成功！',$result);
    }
    /**
     * 生成唯一用户编号
     */
    public function getCustNo(){
        $No= \Yii::redisIncr('register_no');
        $cust_no = "gl" . $No;
        return $cust_no;
    }
//    public function actionSetNo(){
//        $No= \Yii::redisIncrby('register_no',100000);
//        print_r($No);die;
//    }
    /**
     * 用户登录
     */
    public function actionLogin()
    {
        $request = \Yii::$app->request;
        $phone = $request->post_nn('phone');
        $password = $request->post_nn('password');
        $user = User::find()->where(['phone' => $phone, "pwd" => md5($password)])->asArray()->one();
        if (!$user) {//未注册
            return $this->jsonError(109, "账号或密码输入有误，请检查后重新登录");
        } else if ($user['status'] != 1) {
            return $this->jsonError(402, '该账户已禁用，请联系管理人员。');
        }
        $token = UserService::autoLogin($user['cust_no'], $user['user_id']); //自动登录
        return $this->jsonResult(600, '登录成功', ['token' => $token, 'cust_no' => $user['cust_no']]);
    }
    /**
     * 说明: 获取用户个人信息
     * @return
     */
    public function actionGetUserDetail(){
        $request = \Yii::$app->request;
        $custNo = $request->post_nn('custNo');
//        $fieds = ['user.user_name', 'user.user_tel', 'user.cust_no', 'user.user_pic', 'user.province', 'user.city', 'user.area', 'user.address', 'user.authen_status', 'uf.all_funds', 'uf.able_funds', 'uf.ice_funds', 'uf.no_withdraw','uf.pay_password has_pwd'];
        $user = User::find()
//            ->select($fieds)
//            ->leftJoin('user_funds as uf', 'uf.cust_no = user.cust_no')
            ->where(['user.cust_no' => $custNo])
            ->asArray()
            ->one();
        return $this->jsonResult(600, '获取成功', $user);
    }

}
