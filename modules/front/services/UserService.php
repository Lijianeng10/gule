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
        $field = ['c.*','g.title','g.goods_name','g.remark','g.main_pic','s.sku_id','s.attr_value','s.price','sp.pic_url','g.category_id','g.status'];
        $new = (new Query())->select('*')->from('shop_goods_pics')->groupBy('sku_id');
        $list = (new Query())->select($field)
            ->from('shop_car as c')
            ->leftJoin('shop_goods as g','g.goods_id = c.goods_id')
            ->leftJoin('shop_goods_sku as s','s.sku_id = c.sku_id')
            ->leftJoin(['sp'=>$new],'sp.sku_id = s.sku_id')
            ->where(['c.user_id'=>$userId])
            ->orderBy('c.create_time desc')
            ->all();
        $proData = [];
        $subData = [];
        $invalid = [];
        $valid = [];
        if(!empty($list)){
            //处理sku字符串
            $field = ['sa.goods_attr_id','sa.name','sv.attr_value_id','sv.value'];
            foreach ($list as $k=>$v){
                $attr = (new Query())->select($field)->from('shop_goods_attr as sa')
                    ->leftJoin('shop_goods_attr_type_category as sc','sc.attr_type_id = sa.attr_type_id')
                    ->leftJoin('shop_goods_attr_value as sv','sv.attr_id = sa.goods_attr_id')
                    ->where(['sc.category_id'=>$v['category_id']])
                    ->all();
                $attrData=[];
                foreach ($attr as $ke =>$value){
                    if(!array_key_exists($value['goods_attr_id'], $attrData)){
                        $attrData[$value['goods_attr_id']] =['id'=>$value['goods_attr_id'],'text'=>$value['name']];
                    }
                    $attrData[$value['goods_attr_id']]['sub'][$value['attr_value_id']] =['id'=>$value['attr_value_id'],'text'=>$value['value']];
                }
                $str = '';
                $attrAry =json_decode($v['attr_value'],true);
                foreach ($attrAry as $key => $val){
                    $str .=$attrData[$key]["text"].":".$attrData[$key]["sub"][$val]['text']." ";
                }
                $proData["goods_id"] =$v["goods_id"];
                $proData["title"] =$v["title"];
                $proData["goods_name"] =$v["goods_name"];
                $proData["remark"] =$v["remark"];
                $proData["main_pic"] =$v["main_pic"];
                $subData["sku_id"] =$v["sku_id"];
                $subData["attrValue"] =$str;
                $subData["attr_value"] =$v["attr_value"];
                $subData["price"] =$v["price"];
                $subData["sub_pic"] =$v["pic_url"];
                $list[$k]["product"] = $proData;
                $list[$k]["sub_product"] = $subData;
                if($v['status']!=1){
                    $invalid[] = $list[$k];
                    unset($list[$k]);
                }else{
                    $valid[] = $list[$k];
                    unset($list[$k]);
                }
            }
        }
        $list['valid'] = $valid;
        $list['invalid'] = $invalid;
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
                    $newNums = $carInfo->nums + $nums;
                    $res = ShopCar::updateAll(["nums"=>$newNums],$where);
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

}