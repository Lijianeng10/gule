<?php

namespace app\modules\front\services;

use app\modules\common\models\Product;
use Yii;
use yii\db\Query;
use yii\base\Exception;
use yii\db\Expression;
use app\modules\common\helpers\Commonfun;
//use app\modules\user\models\UserAddress;
//use app\modules\shop\services\PayService;
//use app\modules\shop\models\ShopCar;
use app\modules\common\models\ShopCar;
use app\modules\common\models\ShopOrders;
use app\modules\common\models\ShopOrdersDetail;
use app\modules\common\helpers\Constants;
use app\modules\common\helpers\WxPay;


class OrderService {

    /**
     * 验证订单
     * @param type $post POST数据包
     * @param type $custNo 用户编号
     * @param type $userId 用户ID
     * @return type $openid  微信openid
     */
    public static function validateOrder($post, $custNo, $userId,$openid='') {
        $goodsNums = isset($post['goods_nums']) ? $post['goods_nums'] : '';
        $concent = isset($post['concent']) ? $post['concent'] : '';
        $addressId = isset($post['address_id']) ? $post['address_id'] : '';
        $orderMoney = isset($post['order_money']) ? $post['order_money'] : '';
//        if (empty($addressId)) {
//            return ['code' => 109, 'msg' => '收货地址不可为空！'];
//        }
        if (empty($concent) || !is_array($concent)) {
            return ['code' => 109, 'msg' => '购买商品错误！'];
        }
        $buyNums = 0;
        $buyMoney = 0;
        foreach ($concent as $sub) {
            $productId = $sub['product_id'];//商品ID
//            $skuId = $sub['sku_id'];//SKU ID
            $nums = $sub['nums'];//SKU 数量
            $productData = Product::find()->select(['product_id', 'product_name','product_price','status'])->where(['product_id' => $productId])->asArray()->one();
            if ($productData['status']!=1) {
                return ['code' => 109, 'msg' => '所购商品['.$productData['product_name'].']已下架,请稍后再试！'];
            }
            $buyNums += $nums;
            $buyMoney += $nums * $productData['product_price'];
        }

        if ($goodsNums != $buyNums) {
            return ['code' => 109, 'msg' => '购买数量不对应！'];
        }

        if ($orderMoney != $buyMoney) {
            return ['code' => 110, 'msg' => '订单总金额错误！'];
        }
        $ret = self::createOrder($post, $custNo, $userId,$openid);
        return $ret;
    }

    /**
     * 创建订单
     * @param type $post
     * @param type $custNo
     * @param type $userId
     * @return type
     * @throws Exception
     */
    public static function createOrder($post, $custNo, $userId,$openid='') {
        $goodsNums = $post['goods_nums'];
        $concent = $post['concent'];
//        $addressId = $post['address_id'];
        $orderMoney = $post['order_money'];
//        $orderRemark = $post['order_remark'];
//        if($orderMoney <= 0) {
//            return ['code' => 109, 'msg' => '订单金额有误！'];
//        }
        //查找收货地址信息
//        $addressData = UserAddress::find()->where(["user_id"=>$userId,"user_address_id"=>$addressId])->asArray()->one();
//        if(empty($addressData)){
//            return ['code' => 109, 'msg' => '收货地址信息有误！'];
//        }
        $orderModel = new ShopOrders();
        $orderModel->order_code = Commonfun::getShopCode('BUY', 'B');
        $orderModel->user_id = $userId;
        $orderModel->order_num = $goodsNums;
        $orderModel->order_money = $orderMoney;
//        $orderModel->address = $addressData['consignee_name'].' '.$addressData['consignee_tel'].' '.$addressData['province'].$addressData['city'].$addressData['area'].$addressData['address'];
//        $orderModel->remark = $orderRemark;
        $orderModel->order_time = date('Y-m-d H:i:s');
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            if (!$orderModel->save()) {
                throw new Exception('下单失败');
            }
            $field = ['order_id', 'product_id','product_price', 'num', 'total_money'];
            $inVal = [];
            $upStr = '';
            $format = date('Y-m-d H:i:s');
            $carCode = [];
            foreach ($concent as $sub) {
                $productId = $sub['product_id'];
                $nums = $sub['nums'];
                if($nums <= 0) {
                    throw new Exception('购买商品数量有误，至少购买1件');
                }
                $productData = Product::find()->select(['product_id', 'product_name','product_price','status'])->where(['product_id' => $productId])->asArray()->one();
                if ($productData['status']!=1) {
                    return ['code' => 109, 'msg' => '所购商品['.$productData['product_name'].']已下架,请稍后再试！'];
                }
                $inVal[] = [$orderModel->order_id,$productId, $productData['product_price'], $nums, $nums * $productData['product_price']];
                $carCode[] = $productId;//购物车
            }
            $ret = $db->createCommand()->batchInsert('shop_orders_detail', $field, $inVal)->execute();
            if($ret === false) {
                throw new Exception('下单失败--子单');
            }
            if($ret != count($concent)) {
                throw new Exception('下单失败-子单');
            }
            $db->createCommand($upStr)->execute();
            $trans->commit();
            //生成交易记录
            $payService = new PayService();
            $payService->addPayRecord($orderModel->order_id,$orderModel->order_code,$userId,$custNo,1, 2,$orderMoney);
            //微信小程序支付
            $body = '谷乐-购买商品';
            $money = floatval($orderMoney*100);//接口中参数支付金额单位为【分】
            $wxPay =new WxPay();
            $payRet =$wxPay->unifiedorder($orderModel->order_code,$body,$money,$openid);
            if($payRet["code"]!=600){
                return ['code' => 109, 'msg' => $payRet['msg']];
            }
//            订单ID
            $payRet['data']['orderId'] = $orderModel->order_id;
            //保存wx支付返回的数据包
//            ShopOrders::updateAll(['wxpay_data'=>json_encode($payRet['data'])],['order_code'=>$orderModel->order_code]);
            //删除购物车数据
            ShopCar::deleteAll(['and', ['user_id' => $userId],['in', 'product_id', $carCode]]);
//            'data' =>$payRet['data']
            return ['code' => 600, 'msg' => '下单成功','data' =>$payRet['data']];
        } catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }

    /**
     * 取消订单
     * @param type $orderCode
     * @return type
     */
    public static function cancelOrder($orderCode, $userId) {
        $orderData = ShopOrders::findOne(['order_code' => $orderCode, 'user_id' => $userId, 'pay_status' => 0]);
        if(empty($orderData)) {
            return ['code' => 109, 'msg' => '无效订单~请重新选择'];
        }
        $format = date('Y-m-d H:i:s');
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try{
            $orderData->order_status = 5;
            $orderData->pay_status = 2;
            $orderData->wxpay_data = '';
            if(!$orderData->save()) {
                throw new Exception('操作失败！请重新再试');
            }
            //取消订单更新商品库存
            $detail = ShopOrdersDetail::find()->where(["order_id"=>$orderData->order_id])->asArray()->all();
            foreach ($detail as $v){
                $str = '';
                //更新商品子库存
                $str .= "update shop_goods_sku set stock = stock + {$v['sku_num']} where sku_id = '{$v["sku_id"]}';";
                $ret = $db->createCommand($str)->execute();
                if(!$ret){
                    throw new Exception('商品库存更新失败');
                }
            }
            $trans->commit();
            return ['code' => 600, 'msg' => '操作成功'];
        }catch (Exception $ex) {
            $trans->rollBack();
            return ['code' => 109, 'msg' => $ex->getMessage()];
        }
    }
    
    /**
     * 获取订单列表
     * @param type $userId
     * @param type $type
     * @param type $page
     * @param type $size
     * @return type
     */
    public static function getOrderList($userId, $type, $page, $size){
        $where = ['and', ['user_id' => $userId]];
        switch ($type) {
            case '0':
                $where[] = ['order_status' => 0];
                break;
            case 1:
                $where[] = ['order_status' => 1, 'pay_status' => 1];
                break;
            case 2:
                $where[] = ['order_status' => 2, 'pay_status' => 1];
                break;
            case 3:
                $where[] = ['order_status' => 3, 'pay_status' => 1];
                break;
            case 4:
                $where[] = ['order_status' => 4, 'pay_status' => 1];
                break;
            default :
                break;
        }
        $total = ShopOrders::find()->where($where)->count();
        $offset = $size * ($page - 1);
        $pages = ceil($total / $size);
        $field = ['order_id','order_code', 'order_num', 'order_money', 'order_status', 'pay_status', 'address', 'remark', 'order_time','pay_time', 'send_time', 'receive_time','wxpay_data'];
        $orderData = ShopOrders::find()->select($field)
                ->where($where)
                ->limit($size)
                ->offset($offset)
                ->indexBy('order_id')
                ->orderBy('order_time desc')
                ->asArray()
                ->all();
        $orderStatus = Constants::ORDER_STATUS_ARR;
        $payStatus = Constants::PAY_STATUS_ARR;
        foreach ($orderData as &$order) {
//            $addressAry = explode(' ',$order['address']);
//            $order['consignee_name'] = $addressAry[0];
//            $order['consignee_phone'] = $addressAry[1];
//            $order['address'] = $addressAry[2];
            $order['end_time'] = date("Y-m-d H:i:s",strtotime($order['order_time'])+10*60);
            $order['statusVal'] = $orderStatus[$order['order_status']];
            $order['payVal'] = $payStatus[$order['pay_status']];
            $order['wxPayData'] = json_decode($order['wxpay_data'],true);
        }
        $codeArr = array_column($orderData, 'order_id');
        $commentStatus = 0;//订单评价状态
        $field2 = ['d.*','p.product_name', 'p.product_pic', 'p.product_price'];
        $orderDetail = (new  Query())->select($field2)
            ->from("shop_orders_detail d")
            ->leftJoin('product p', 'p.product_id = d.product_id')
            ->where(['in', 'd.order_id', $codeArr])
            ->all();
        foreach ($orderDetail as $detail) {
            $orderData[$detail['order_id']]['order_detail'][] = $detail;
        }

        return ['page' => $page, 'size' => count($orderData), 'pages' => $pages, 'total' => $total, 'data' => array_values($orderData)];
    }
    
    /**
     * 获取订单详情
     * @param type $orderId
     * @return type
     */
    public static function getOrderDetail($orderId) {
        $orderStatus = Constants::SHOP_ORDER_STATUS;
        $payStatus = Constants::SHOP_PAY_STATUS;
        $where = ['order_id' =>$orderId];
        $field = ['shop_orders.order_id','shop_orders.order_code', 'shop_orders.order_num', 'shop_orders.order_money', 'shop_orders.order_status', 'shop_orders.pay_status', 'shop_orders.address', 'shop_orders.shipping_fee', 'shop_orders.remark', 'shop_orders.order_time','shop_orders.pay_time', 'shop_orders.send_time', 'shop_orders.receive_time','shop_orders.wxpay_data','c.courier_name','c.courier_code'];
        $orderData = ShopOrders::find()->select($field)
            ->leftJoin('shop_orders_courier c','c.order_code = shop_orders.order_code')
            ->where($where)
            ->asArray()
            ->one();
        $addressAry = explode(' ',$orderData['address']);
        $orderData['consignee_name'] = $addressAry[0];
        $orderData['consignee_phone'] = $addressAry[1];
        $orderData['address'] = $addressAry[2];
        $orderData['end_time'] = date("Y-m-d H:i:s",strtotime($orderData['order_time'])+10*60);
        $orderData['statusVal'] = $orderStatus[$orderData['order_status']];
        $orderData['payVal'] = $payStatus[$orderData['pay_status']];
        $orderData['wxPayData'] = json_decode($orderData['wxpay_data'],true);
        $new = (new Query())->select('*')->from('shop_goods_pics')->groupBy('sku_id');
        $field2 = ['shop_orders_detail.*','g.goods_name', 'g.title', 'g.main_pic', 'g.remark','s.attr_value','sp.pic_url','s.attr_name'];
        $orderDetail = ShopOrdersDetail::find()->select($field2)
                ->leftJoin('shop_goods g', 'g.goods_id = shop_orders_detail.goods_id')
                ->leftJoin('shop_goods_sku s', 's.sku_id = shop_orders_detail.sku_id')
                ->leftJoin(['sp'=>$new],'sp.sku_id = s.sku_id')
                ->where(['shop_orders_detail.order_id'=>$orderId])
                ->asArray()
                ->all();
        foreach ($orderDetail as &$v){
            //处理sku字符串
            $attrAry = json_decode($v['attr_name'],true);
            $str = '';
            foreach ($attrAry as $key => $val){
                $str .=$key .':'.$val.' ';
            }
            $v['attrValue'] = $str;
        }
        $orderData['detail'] = $orderDetail;
        return $orderData;
    }
    
    /**
     * 购彩回调-处理订单/支付记录
     * @param string $orderCode
     * @param string $outer_no
     * @param decimal $total_amount
     * @return boolean
     */
    public static function orderNotify($orderCode, $outer_no, $total_amount, $payTime, $record) {
        $orderData = Orders::find()->where(["order_code" => $orderCode, "status" => 0])->asArray()->one();
        if ($record["status"] != 0) {
            return true;
        }
        //查询用户总金额
        $funds = UserFunds::find()->select(['all_funds'])->where(['cust_no' => $record['cust_no']])->asArray()->one();
        //修改支付记录表状态及其他信息
        $ret2 = PayRecord::updateAll(["status" => 1, "third_pay_no" => $outer_no, "modify_time" => date("Y-m-d H:i:s"), "pay_time" => $payTime, "pay_money" => $total_amount, "balance" => $funds["all_funds"]], ["order_code" => $orderCode]);
        //修改订单状态为处理中
        $ret1 = Orders::updateAll(["status" => 1, 'deal_status' => 1, 'place_time' => date('Y-m-d H:i:s')], ["order_id" => $orderData["order_id"]]);
        if (!$ret1) {
            return false;
        }
        if (!$ret2) {
            return false;
        }
        $upStr = '';
        $buyNums = OrderDetail::find()->select(['nums', 'product_code', 'sub_code'])->where(['order_code' => $orderCode])->asArray()->all();
        foreach ($buyNums as $buy) {
            $upStr .= "update product set buy_nums = buy_nums + {$buy['nums']}, modify_time = '".  date('Y-m-d H:i:s') ."' where product_code = '{$buy['product_code']}';";
            $upStr .= "update product_sub set buy_nums = buy_nums + {$buy['nums']}, modify_time = '".  date('Y-m-d H:i:s') ."' where sub_code = '{$buy['sub_code']}';";
        }
        \Yii::$app->db->createCommand($upStr)->execute();
        return true;
    }

    /**
     * 获取用户订单数量统计
     * @param $userId
     */
    public static function getOrderNum($userId){
        $field =['sum(case when order_status = 0 then 1 else 0 end) as stayPay','sum(case when order_status = 1 then 1 else 0 end) as staySend','sum(case when order_status = 2 then 1 else 0 end) as stayReceive','sum(case when order_status = 3 then 1 else 0 end) as refund','sum(case when order_status = 4 then 1 else 0 end) as finish','sum(case when order_status = 5 then 1 else 0 end) as close'];
        $orderNums = ShopOrders::find()->select($field)->where(['user_id'=>$userId])
            ->asArray()
            ->one();
        return $orderNums;
    }
    /**
     * 用户确认收货
     * @param $orderCode 订单编号
     * @param $userId 用户ID
     */
    public static function confirmReceipt($orderCode,$userId){
        $orderData = ShopOrders::findOne(['order_code'=>$orderCode,'user_id'=>$userId,'order_status'=>2]);
        if(empty($orderData)){
            return ['code'=>109,'msg'=>'数据有误！'];
        }
        $orderData->order_status = 4;
        $orderData->receive_time = date("Y-m-d H:i:s");
        //更新商品销售量
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try{
            if(!$orderData->save()){
                throw new Exception('订单状态更新失败!');
            }
            $str = '';
            $field = ['shop_orders_detail.goods_id','shop_orders_detail.sku_num'];
            $goodsData = ShopOrdersDetail::find()
                ->select($field)
                ->leftJoin('shop_orders o','o.order_id = shop_orders_detail.order_id')
                ->where(['o.order_code'=>$orderCode])
                ->asArray()
                ->all();
            foreach ($goodsData as $v){
                $str .="update shop_goods set sale_nums = sale_nums + {$v['sku_num']} WHERE goods_id = {$v['goods_id']}";
            }
            $ret = $db->createCommand($str)->execute();
            if(!$ret){
                throw new Exception('商品销量数据更新失败!');
            }
            $trans->commit();
            return ['code'=>600,'msg'=>'操作成功完毕！'];
        }catch (Exception $e){
            $trans->rollBack();
            return ['code'=>109,'msg'=>$e->getMessage()];
        }
    }

    /**
     * 修改待发货订单收货地址
     * @param $orderCode
     * @param $userId
     * @param $addressId
     */
    public static function updateOrderAddress($orderCode,$userId,$addressId){
        $order = ShopOrders::find()->where(['order_code'=>$orderCode,'user_id'=>$userId,'order_status'=>1])->one();
        if(empty($order)){
            return ['code'=>109,'msg'=>'订单数据有误，请检查！'];
        }
        if($order->add_status==1){
            return ['code'=>109,'msg'=>'收货地址只允许修改一次！'];
        }
        //查找收货地址信息
        $addressData = UserAddress::find()->where(["user_id"=>$userId,"user_address_id"=>$addressId])->asArray()->one();
        if(empty($addressData)){
            return ['code' => 109, 'msg' => '收货地址信息有误！'];
        }
        $str = $addressData['consignee_name'].' '.$addressData['consignee_tel'].' '.$addressData['province'].$addressData['city'].$addressData['area'].$addressData['address'];
        $order->address = $str;
        $order->add_status = 1;
        if(!$order->save()){
            return ['code' => 109, 'msg' => '收货地址修改失败！'];
        }
        return ['code' => 600, 'msg' => '收货地址修改成功！'];
    }
}
