<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Lottery;
use app\modules\common\models\Order;
use app\modules\common\models\OrderDetail;
use app\modules\common\models\StoreLottery;
use app\modules\common\helpers\Constants;

/**
 * Orders controller for the `orders` module
 */
class OrdersController extends Controller {
    /**
     * 获取彩种
     */
    public function actionGetLottery() {
        $lotteryData = Lottery::find()->select(['lottery_id', 'lottery_name'])->where([ 'status' => 1])->asArray()->all();
        $lotteryLists=[];
        foreach($lotteryData as $key => $val){
            $lotteryLists[] = ['id'=>$val['lottery_id'],'text'=>$val['lottery_name']];
        }
        return json_encode($lotteryLists);
    }
    /**
     * 新增网点订单
     */
    public function actionPlayOrder(){
        $request = \Yii::$app->request;
        $session = \Yii::$app->session;
        $channel = $session['admin']['admin_name'];
        $custNo = $request->post('cust_no','');
        $consignee_name = $request->post('consignee_name','');
        $consignee_tel = $request->post('consignee_tel','');
        $consignee_address = $request->post('consignee_address','');
        $content = $request->post('content');
        $order_num = $request->post('order_num');
        $order_money = $request->post('order_money');
        if(empty($custNo)||empty($consignee_name)||empty($consignee_tel)||empty($consignee_address)){
            return $this->jsonError(109,'参数缺失');
        }
        if(empty($content)){
            return $this->jsonError(109,'请选择有效的彩种数据');
        }
        $format = date('Y-m-d H:i:s');
        //新增订单主表数据 默认已支付
        $order = new Order();
        $order->order_code = 'GGC'.date('YmdHis').rand(10,99);
        $order->cust_no = $custNo;
        $order->order_num = $order_num;
        $order->order_money = $order_money;
        $order->order_status = 1;
        $order->pay_status = 1;
        $order->address = $consignee_address;
        $order->order_time = $format;
        $order->pay_time = $format;
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try{
            if (!$order->save()) {
                throw new Exception('下单失败');
            }
            $field = ['order_id', 'order_code', 'lottery_id', 'lottery_name', 'sub_value', 'nums','sheet_nums','price','money'];
            $inVal = [];
            $upStr = '';
            foreach ($content as $k => $v){
                $inVal[] = [$order->order_id,$order->order_code,$v['lottery_id'],$v['lottery_name'],$v['sub_value'],$v['nums'],$v['sheet_nums'],$v['price'],$v['nums']*$v['price']];
                //更新门店彩种表数据
                $this->updateStoreLottery($custNo,$channel,$v['lottery_id'],$v['sub_value'],$v['nums']*$v['sheet_nums']);
            }
            $ret = $db->createCommand()->batchInsert('order_detail', $field, $inVal)->execute();
            if($ret === false) {
                throw new Exception('下单失败,订单明细生成失败');
            }
            $trans->commit();
            return $this->jsonResult(600,'下单成功');
        }catch (Exception $ex) {
            $trans->rollBack();
            return $this->jsonError(109,$ex->getMessage());
        }
    }
    /**
     * 更新门店彩种表数据
     */
    public function updateStoreLottery($cust_no,$channel_no,$lottery_id,$lottery_value,$nums){
        $where = ["cust_no"=>$cust_no,"channel_no"=>$channel_no,"lottery_id"=>$lottery_id,'lottery_value'=>$lottery_value];
        $info = StoreLottery::find()->where($where)->one();
        if(!empty($info)){
            $newNums = $info->stock + $nums;
            StoreLottery::updateAll(["stock"=>$newNums],$where);
        }else{
            //新增门店彩种表数据
            $storeLottery = new StoreLottery();
            $storeLottery->cust_no = $cust_no;
            $storeLottery->channel_no = $channel_no;
            $storeLottery->lottery_id = $lottery_id;
            $storeLottery->lottery_value = $lottery_value;
            $storeLottery->stock = $nums;
            $storeLottery->create_time = date("Y-m-d H:i:s");
            $storeLottery->save();
        }
        return ['code'=>600,'msg'=>'操作成功'];
    }
    /**
     * 获取订单状态
     */
    public function actionGetOrderStatus() {
        $order_status_arr = Constants::ORDER_STATUS_ARR;
        $orderStatusLists=[];
        $orderStatusLists = [['id'=>'-1','text'=>'全部']];
        foreach($order_status_arr as $key => $val){
            $orderStatusLists[] = ['id'=>$key,'text'=>$val];
        }

        return json_encode($orderStatusLists);
    }

    /**
     * 获取支付状态
     */
    public function actionGetPayStatus() {
        $pay_status_arr = Constants::PAY_STATUS_ARR;
        $payStatusLists=[];
        $payStatusLists = [['id'=>'-1','text'=>'全部']];
        foreach($pay_status_arr as $key => $val){
            $payStatusLists[] = ['id'=>$key,'text'=>$val];
        }

        return json_encode($payStatusLists);
    }
    /**
     * @return string 获取订单数据
     */
    public function actionGetList(){
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort','order_time');
        $order = $request->post('order','desc');
        $offset = $rows * ($page - 1);

        $order_code = $request->post('order_code');//订单编号
        $user_name = $request->post('user_name');//下单用户名称
        $order_status = $request->post('order_status');//订单状态
        $pay_status = $request->post('pay_status');//支付状态
        $start_order_time = $request->post('start_order_time');//下单起始时间
        $end_order_time = $request->post('end_order_time');//下单结束时间
        $where = ['and'];
        if($order_code != ''){
            $where[] = ['like','shop_orders.order_code',$order_code];
        }
        if($user_name != ''){
            $where[] = ['like','user.user_name',$user_name];
        }
        if($order_status != '' && $order_status != '-1'){
            $where[] = ['order_status'=>$order_status];
        }
        if($pay_status != '' && $pay_status != '-1'){
            $where[] = ['pay_status'=>$pay_status];
        }
        if($start_order_time != ''){
            $where[] = ['>=','order_time',$start_order_time];
        }
        if($end_order_time != ''){
            $where[] = ['<=','order_time',$end_order_time];
        }
        $total = Order::find()->where($where)->count();
        $AttrList = Order::find()
//            ->select(['shop_orders.*','user.user_name as user_name'])
//            ->leftJoin('user','user.user_id = shop_orders.user_id')
            ->where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()
            ->all();
        $order_status_arr = Constants::ORDER_STATUS_ARR;//订单状态
        $pay_status_arr = Constants::PAY_STATUS_ARR;//支付状态
        foreach($AttrList as $k => $v){
            $AttrList[$k]['remark_xs'] = Commonfun::utf8Substr($v['remark'],5);
            $AttrList[$k]['address_xs'] = Commonfun::utf8Substr($v['address'],25);
            if(array_key_exists($v['order_status'], $order_status_arr)){
                $AttrList[$k]['order_status_val'] = $order_status_arr[$v['order_status']];
            }else{
                $AttrList[$k]['order_status_val'] = '';
            }
            if(array_key_exists($v['pay_status'], $pay_status_arr)){
                $AttrList[$k]['pay_status_val'] = $pay_status_arr[$v['pay_status']];
            }else{
                $AttrList[$k]['pay_status_val'] = '';
            }
        }
        return \Yii::datagridJson($AttrList, $total);
    }
}
