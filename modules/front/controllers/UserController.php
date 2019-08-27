<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\User;
use app\modules\front\services\UserService;
use app\modules\common\helpers\Constants;
use app\modules\tools\helpers\AliSms;
use app\modules\common\models\ShopCar;

class UserController extends Controller {


    /**
     * 微信授权
     * @return string
     */
    public function actionWeChatAuth() {
        $request = \Yii::$app->request;
        $type = $request->get('type',1);
        $ret = UserService::getUserInfo($type);
        if ($ret['code'] != 600) {
            return $this->jsonError($ret['code'], $ret['msg']);
        }
        return $this->jsonResult(600, '登录成功！', $ret['data']);
    }

    public function actionCallBackWxCode() {
        $request = \Yii::$app->request;
//        $storeCode = $request->get('state');
        $wxCode = $request->get('code', '');
        //$storeCode 参数拼接了门店公众号Code、H5跳转链接
//        $codeAry = explode('_', $storeCode);
        $ret = UserService::getUserInfo(1, $wxCode);
        $pageUrl = \Yii::$app->params['page_url'];
        if ($ret['code'] != 600) {
            $url = \Yii::$app->params['awardDomain'] . '/' . $pageUrl[$codeAry[1]] . '?code=' . $ret['code'] . '&msg=' . $ret['msg'];
        }
        $url = \Yii::$app->params['awardDomain'] . '/' . $pageUrl[$codeAry[1]] . '?userInfo=' . json_encode($ret['data']);
        return $this->redirect($url);
    }

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
        $custNo = $this->custNo;
//        $fieds = ['user.user_name', 'user.user_tel', 'user.cust_no', 'user.user_pic', 'user.province', 'user.city', 'user.area', 'user.address', 'user.authen_status', 'uf.all_funds', 'uf.able_funds', 'uf.ice_funds', 'uf.no_withdraw','uf.pay_password has_pwd'];
        $user = User::find()
//            ->select($fieds)
//            ->leftJoin('user_funds as uf', 'uf.cust_no = user.cust_no')
            ->where(['user.cust_no' => $custNo])
            ->asArray()
            ->one();
        return $this->jsonResult(600, '获取成功', $user);
    }
    /**
     * 修改名称
     */
    public function actionSetNickname() {
        $userId = $this->userId;
        $request = Yii::$app->request;
        $nickname = $request->post('nickname', '');
        if ($nickname == '' || ctype_space($nickname)) {
            return $this->jsonError(100, '参数缺失');
        }
        if (strpos($nickname, '官') !== false || strpos($nickname, '群') !== false || strpos($nickname, 'wns8807') !== false) {
            return $this->jsonError(100, '非法字符！！请慎重填写');
        }
        $nickName = str_replace(' ', '', $nickname);
        $exist = User::find()->select(['nickname'])->where(['nickname' => $nickName])->andWhere(['!=', 'user_id', $userId])->asArray()->one();
        if (!empty($exist)) {
            return $this->jsonError(109, '该昵称已被征用啦！');
        }
        $userData = User::findOne(['user_id' => $userId]);
        $userData->nickname = $nickName;
        if (!$userData->save()) {
            return $this->jsonError(109, '修改失败');
        }
        return $this->jsonResult(600, '修改成功', true);
    }
    /**
     * 说明: 发送短信验证码（注册）忘记密码
     * @param account //手机号
     * @param cType //1:注册 2:登录 4:忘记密码
     * @return
     */
    public function actionGetSmsCode() {
        $request = Yii::$app->request;
        $userTel = $request->post('phone', '');
        $cType = $request->post('cType', ''); //1:注册 2:登录 4:忘记密码 5:提现申请
        if (empty($userTel) || empty($cType)) {
            return $this->jsonError(109, '参数缺失');
        }
        if (strlen($userTel) != 11) {
            return $this->jsonError(109, '请输入正确的手机号！');
        }
        if ($cType == 1) {//注册
            $ret = User::find()->where(['phone'=>$userTel])->one();
            if(!empty($ret)){
                return $this->jsonError(109, '该手机号已注册！');
            }
            $saveKey = Constants::SMS_KEY_REGISTER;
        } else if ($cType == 2) {//登录
            $saveKey = Constants::SMS_KEY_LOGIN;
        } else if ($cType == 4) {//忘记密码
            $saveKey = Constants::SMS_KEY_UPPWD;
        } else if ($cType == 5) {//用户提现申请
            $saveKey = Constants::SMS_KEY_WITHDRAW_APPLY;
        } elseif ($cType == 6) {
            $saveKey = Constants::SMS_KEY_WX_CHANGE_BOUNDING;
        }
        AliSms::sendSmsCode($cType, $saveKey, $userTel);
    }
    /**
     * 说明: 忘记密码
     * @param $phone   手机号
     * @param smsCode   短信验证码
     * @param password  新密码
     * @return
     */
    public function actionUpdatePwd() {
        $request = \Yii::$app->request;
        $phone = $request->post('phone');
        $smsCode = $request->post('smsCode');
        $password = $request->post('password');
        if (empty($phone) || empty($password)) {
            return $this->jsonError(109, '参数缺失');
        }
        $saveKey = Constants::SMS_KEY_UPPWD;
        AliSms::check_code($saveKey, $phone, $smsCode);
        $ret = User::updateAll(['pwd'=>md5($password)],['phone'=>$phone]);
        if(!$ret){
            return $this->jsonError(109, '修改失败！');
        }
        return $this->jsonResult(600,'修改成功！');
    }

    /**
     * 完善用户信息
     */
    public function actionSetUserInfo(){
        $custNo = $this->custNo;
        $request = \Yii::$app->request;
        $realName = $request->post('realName','');
        $idCardNum = $request->post('idCardNum','');
        $eMail = $request->post('eMail','');
        $address = $request->post('address','');
        if(empty($realName)||empty($idCardNum)||empty($eMail)||empty($address)){
            return $this->jsonError(109, '参数缺失');
        }
        $ret = UserService::setUserInfo($custNo,$realName,$idCardNum,$eMail,$address);
        return $this->jsonResult($ret['code'],$ret['msg']);
    }
    /**
     * 完善用户账户信息
     */
    public function actionSetUserBankInfo(){
        $custNo = $this->custNo;
        $request = \Yii::$app->request;
        $accountName = $request->post('accountName','');
        $bankName = $request->post('bankName','');
        $bankCardNum = $request->post('bankCardNum','');
        if(empty($accountName)||empty($bankName)||empty($bankCardNum)){
            return $this->jsonError(109, '参数缺失');
        }
        $ret = UserService::setUserBankInfo($custNo,$accountName,$bankName,$bankCardNum);
        return $this->jsonResult($ret['code'],$ret['msg']);
    }
    /**
     * 获取用户购物车列表
     */
    public function actionGetShopCarList(){
        $userId = $this->userId;
        $request = Yii::$app->request;
        $ret = UserService::getShopCarList($userId);
        return $this->jsonResult(600,'获取成功',$ret['data']);
    }
    /**
     * 用户购物车操作
     */
    public function actionOptUserShopCar(){
        $userId = $this->userId;
        $request = Yii::$app->request;
        $cardId = $request->post('car_id','');
        $productId = $request->post('product_id','');
        $nums = $request->post('nums',1);
        $type = $request->post('type',1);
        $res = UserService::optUserShopCar($userId,$type,$cardId,$productId,$nums);
        if($res["code"]!=600){
            return $this->jsonError($res["code"],$res["msg"]);
        }
        return $this->jsonResult($res["code"],$res["msg"],$res["data"]);
    }

}
