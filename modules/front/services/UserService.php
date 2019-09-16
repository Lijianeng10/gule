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
use app\modules\common\models\ShopCar;

class UserService{
    /**
     * 授权第一步，获取code
     * @return int
     */
    public static function getUserInfo($type, $code = '') {
        $wxInfo = \Yii::$app->params['wechat'];
        $appid = $wxInfo['appid'];
        $appsecret = $wxInfo['secret'];
        $redirect_uri = $wxInfo['redirect_uri'];
        if (empty($code)) {
            //触发微信返回code码
            $baseUrl = urlencode($redirect_uri);
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . $appid . "&redirect_uri=" . $baseUrl . "&response_type=code&scope=snsapi_userinfo&state=state&connect_redirect=1#wechat_redirect";
            Header("Location: $url");
            exit;
        } else {
            //获取用户基础信息
            $wxUserInfo = self::getSnsapiUserinfo($appid, $appsecret,$code);
            if (!isset($wxUserInfo['openid'])) {
                return ['code' => 109, 'msg' => '请先关注该公众号！', 'data' => ''];
            }
            $user = User::find()->where(['openid' => $wxUserInfo['openid']])->asArray()->one();
            $token = '';
            if (empty($user)) {
                $createUser = self::createUser($wxUserInfo);
                if ($createUser['code'] != 600) {
                    return ['code' => $createUser['code'], 'msg' => $createUser['msg']];
                }
                $custNo = $createUser['data']['cust_no'];
                $userId = $createUser['data']['user_id'];
//                $thirdUser = ThirdUser::find()->where(['user_id' => $userId, 'cust_no' => $custNo, 'store_code' => $storeCode])->one();
//                if (empty($thirdUser)) {
//                    self::createThirdUserInfo($wxUserInfo, $storeCode, $userId, $custNo);
//                }
                $mobile = '';
            } else {
                $custNo = $user['cust_no'];
                $userId = $user['user_id'];
                $mobile = $user['phone'];
            }
            $token = self::autoLogin($custNo, $userId);
            $userInfoAry = [];
            $userInfoAry['token'] = $token;
            $userInfoAry['wxUserInfo'] = $wxUserInfo;
//            $userInfoAry['agentCode'] = $storeCode;
            $userInfoAry['mobile'] = $mobile;
            return ['code' => 600, 'msg' => '登录成功！', 'data' => $userInfoAry];
        }
    }

    /**
     *  获取微信登录用户信息
     * @param $appid
     * @param $appsecret
     * @param $code
     * @return array
     */
    public static function getSnsapiUserinfo($appid, $appsecret, $code) {
        //获取网页授权的access_token、openid
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $appid . "&secret=" .
            $appsecret . "&code=" . $code . "&grant_type=authorization_code";
        $weixin = file_get_contents($url); //通过code换取网页授权access_token
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode); //转换成数组
        $accessToken = $array['access_token']; //输出access_token
        $openid = $array['openid']; //输出openid
        //获取详细信息
        $infoUrl = "https://api.weixin.qq.com/sns/userinfo?access_token=" . $accessToken . "&openid=" . $openid . "&lang=zh_CN";
        $ret = \Yii::CurlGet($infoUrl);
        return $ret;
    }

    /**
     * 创建用户
     * @param $wxUserInfo 微信用户信息包
     * @param string $userTel 手机号
     */
    public static function createUser($wxUserInfo, $userTel = '') {
        $custNo = self::getNo();
        $cTime = date('Y-m-d H:i:s');
        $user = new User();
        $user->cust_no = $custNo;
        $user->phone = $userTel;
        $user->pic = $wxUserInfo['headimgurl'];
        $user->nickname = $wxUserInfo['nickname'];
        $user->province = $wxUserInfo['province'];
        $user->city = $wxUserInfo['city'];
//        $user->unionid = $wxUserInfo['unionid'];
        $user->openid = $wxUserInfo['openid'];
        $user->create_time = $cTime;
        if (!$user->save()) {
            return ['code' => 109, 'msg' => '用户新增失败！'];
        }
        $userId = $user->attributes['user_id'];
        $userData = ['user_id' => $userId, 'cust_no' => $custNo];
        return ['code' => 600, 'msg' => '新增成功！', 'data' => $userData];
    }
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
    /**
     * 获取我的购物车列表
     * @param $userId 用户ID
     */
    public static function getShopCarList($userId){
        $field = ['shop_car.*','p.*'];
        $list = ShopCar::find()
            ->select($field)
            ->leftJoin('product p','p.product_id = shop_car.product_id')
            ->where(['shop_car.user_id'=>$userId])
            ->orderBy('shop_car.create_time desc')
            ->asArray()
            ->all();
        return ['code'=>600,'msg'=>'获取成功','data'=>$list];
    }
    /**
     * 用户购物车操作
     * @param $cardId 购物车ID
     * @param $productId 商品ID
     * @param nums 商品数量
     * @param type 操作类型 1新增 2 更新数量 3 删除
     */
    public static function optUserShopCar($userId,$type,$cardId,$productId,$nums){
        $where = ["product_id"=>$productId,"user_id"=>$userId];
        switch ($type){
            case 1:
                //查找购物车中是否存在同商品数据，有则只更新数量
                $carInfo = ShopCar::find()->where($where)->one();
                if(!empty($carInfo)){
//                    $newNums = $carInfo->nums + $nums;
//                    $res = ShopCar::updateAll(["nums"=>$newNums],$where);
                    return ['code'=>109,'msg'=>'该产品已存在购物车中，请前往购物车购买！'];
                }else{
                    //新增购物车
                    $userCar = new ShopCar();
                    $userCar->user_id = $userId;
                    $userCar->product_id = $productId;
                    $userCar->nums = $nums;
                    $userCar->create_time = date("Y-m-d H:i:s");
                    $res = $userCar->save();
                }
                break;
            case 2:
                $res = ShopCar::updateAll(["nums"=>$nums],$where);
                break;
            case 3:
                $res = ShopCar::deleteAll($where);
                break;
        }
        $counts = ShopCar::find()->where(["user_id"=>$userId])->count();
        return ["code"=>600,"msg"=>"操作成功","data"=>$counts];
    }

    /**
     * 生成唯一用户编号
     */
    public static function getNo() {
        $No = \Yii::redisIncr('cust_number');
        $no = "GL" . $No;
        return $no;
    }

    /**
     * 绑定手机号
     * 2019年8月16日10:54:29 ZYL
     * @param type $tel
     * @param type $wxUserInfo
     * @return type
     */
    public static function bindTel($tel, $wxUserInfo) {
        //根据微信信息查询用户是否绑定手机号
        if (empty($wxUserInfo) && !isset($wxUserInfo['openid'])) {
            return ['code' => 109, 'msg' => '信息错误！请稍后再试'];
        }
        $user = User::findOne(['openid' => $wxUserInfo['openid']]);
        if (!$user) {
            return ['code' => 109, 'msg' => '错误用户'];
        }
        $user->phone = $tel;
        if (!$user->save()) {
            return ['code' => 109, 'msg' => '绑定失败！请稍后再试'];
        }
        return ['code' => 600, 'msg' => '绑定成功！', 'data' => $tel];
    }

}