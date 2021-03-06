<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use Yii;
use app\modules\common\models\PayRecord;
use app\modules\common\models\Store;

class PayrecordController extends Controller {

    public function actionGetPayrecordList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'pay_record.create_time');
        $orderBy = $request->post('order', 'desc');
        $lotteryInfo = $request->post('lotteryInfo', '');
        $cust_no = $request->post('cust_no', '');
        $status = $request->post('status');
        $start_time = $request->post('start_time');
        $end_time = $request->post('end_time');
        $pay_start_time = $request->post('pay_start_time');
        $pay_end_time = $request->post('pay_end_time');
        $orderInfo = $request->post('orderInfo', '');
        $offset = $rows * ($page - 1);
        $where = ['and'];
        //渠道用户只能看到自己旗下的交易信息
        if($session['admin']['type']!=0){
            $where[] = ['pay_record.channel_no'=>$session['admin']['admin_name']];
        }
        if(!empty($orderInfo)){
            $where[] = ['like','pay_record.order_code',$orderInfo];
        }
        if(!empty($cust_no)){
			$where[] = ['s.cust_no' => $cust_no];
        }
        if(!empty($lotteryInfo)){
            $where[] = ['or',['like','l.lottery_name.',$lotteryInfo],['like','l.lottery_value',$lotteryInfo]];
        }
        if($status!=''){
            $where[] = ['pay_record.status'=>$status];
        }
        if(!empty($start_time)){
            $where[] = ['>=','pay_record.create_time',$start_time];
        }
        if(!empty($end_time)){
            $where[] = ['<=','pay_record.create_time',$end_time];
        }
        if(!empty($pay_start_time)){
            $where[] = ['>=','pay_record.pay_time',$pay_start_time];
        }
        if(!empty($pay_end_time)){
            $where[] = ['<=','pay_record.pay_time',$pay_end_time];
        }
        $field = ['pay_record.*','s.cust_no','s.user_tel','s.channel_no','s.store_name','s.province','s.area','s.city','l.lottery_name'];
        $total = PayRecord::find()
            ->leftJoin("store as s",'s.cust_no = pay_record.store_no')
            ->leftJoin("lottery as l",'l.lottery_id = pay_record.lottery_id')
            ->where($where)
            ->count();
        $lotteryData = PayRecord::find()
                ->select($field)
                ->leftJoin("store as s",'s.cust_no = pay_record.store_no')
                ->leftJoin("lottery as l",'l.lottery_id = pay_record.lottery_id')
                ->where($where)
                ->limit($rows)
                ->offset($offset)
                ->orderBy("{$sort} {$orderBy} ")
                ->asArray()
                ->all();
        return \Yii::datagridJson($lotteryData, $total);
    }
	
	/**
     * 获取网点
     */
    public function actionGetCustNo() {
		$session = \Yii::$app->session;
		$where = ['and'];
		$where[] = ['status' => 1];
		
		//判断登陆账号是否为渠道账户
		if($session['admin']['type'] == 1){
			$where[] = ['channel_no' => $session['admin']['admin_name']];
		}
		
        $storeData = Store::find()->select(['cust_no', 'store_name'])->where($where)->orderBy("create_time desc")->asArray()->all();
        $storeLists=[];
		$storeLists=[['id'=>'','text'=>'全部']];
        foreach($storeData as $key => $val){
            $storeLists[] = ['id'=>$val['cust_no'],'text'=>$val['store_name']];
        }
        return json_encode($storeLists);
    }

}
