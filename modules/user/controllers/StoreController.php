<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use Yii;
use app\modules\common\helpers\Commonfun;
use app\modules\common\models\Store;
use app\modules\common\models\Machine;
use app\modules\common\models\PayRecord;

class StoreController extends Controller {

    public function actionGetStoreList() {

        $request = \Yii::$app->request;
		$session = \Yii::$app->session;
        $page = $request->post('page', 1);
        $size = $request->post('size', 15);
        $sort = $request->post('sort', 'desc');
        $orderBy = $request->post('order', 'create_time');
        $cust_no = $request->post('cust_no');
        $status = $request->post('status');
		$start_time = $request->post('start_time');
		$end_time = $request->post('end_time');

        $where = ['and'];
        if (!empty($cust_no)) {
            $where[] = ['or',['like', 'cust_no', $cust_no],['like', 'user_tel', $cust_no],['like', 'store_name', $cust_no]];
        }
        if (!empty($status)) {
            $where[] = ['status' => $status];
        }
		if(!empty($start_time)){
            $where[] = ['>=','create_time',$start_time];
        }
		if(!empty($end_time)){
            $where[] = ['<=','create_time',$end_time];
        }
		
		//判断登陆账号是否为渠道账户
		if($session['admin']['type'] == 1){
			$where[] = ['channel_no' => $session['admin']['admin_name']];
		}
		
        $total = Store::find()->where($where)->count();
        $storeData = Store::find()
                ->where($where)
                ->limit($size)
                ->offset($size * ($page - 1))
                ->orderBy("{$orderBy} {$sort}")
                ->asArray()
                ->all();
				
		foreach($storeData as $key => $val){
			$machineNums = Machine::find()->where(['cust_no' => $val['cust_no']])->count();//统计机器总数
			$saleMoneys = PayRecord::find()->where(['store_no' => $val['cust_no']])->sum('pay_money');//统计总销量
			$storeData[$key]['machineNums'] = $machineNums??0;
			$storeData[$key]['saleMoneys'] = $saleMoneys??'0.00';
		}
        return \Yii::datagridJson($storeData, $total);
    }

    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 2;
        }
        Store::updateAll(['status' => $status], ['store_id' => $parmas['id']]);
        return $this->jsonResult(600, '修改成功', true);
    }

}
