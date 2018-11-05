<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use Yii;
use app\modules\common\models\PayRecord;

class PayrecordController extends Controller {

    public function actionGetPayrecordList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page', 1);
        $size = $request->post('size', 15);
        $sort = $request->post('sort', '');
        $orderBy = $request->post('order', '');
        $lotteryInfo = $request->post('lotteryInfo', '');
        $storeInfo = $request->post('storeInfo', '');
        $status = $request->post('status');
        $start_time = $request->post('start_time');
        $end_time = $request->post('end_time');
        $pay_start_time = $request->post('pay_start_time');
        $pay_end_time = $request->post('pay_end_time');
        $where = ['and'];
        //渠道用户只能看到自己旗下的交易信息
        if($session['admin']['type']!=0){
            $where[] = ['pay_record.channel_no'=>$session['admin']['admin_name']];
        }
        if(!empty($storeInfo)){
            $where[] = ['or',['like','s.cust_no',$storeInfo],['like','s.user_tel',$storeInfo],['like','s.store_name',$storeInfo]];
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
                ->limit($size)
                ->offset($size * ($page - 1))
                ->orderBy("{$orderBy} {$sort}")
                ->asArray()
                ->all();
        return \Yii::datagridJson($lotteryData, $total);
    }

}
