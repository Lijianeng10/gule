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
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort','create_time');
        $orderBy = $request->post('order', 'desc' );
        $cust_no = $request->post('cust_no');
        $status = $request->post('status');
		$start_time = $request->post('start_time');
		$end_time = $request->post('end_time');
        $province = $request->post('province');
        $city = $request->post('city');
        $area = $request->post('area');
        $offset = $rows * ($page - 1);
        $where = ['and'];
        if (!empty($cust_no)) {
			$where[] = ['cust_no' => $cust_no];
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
        if(!empty($province)){
            $where[] = ['province' => $province];
        }
        if(!empty($city)){
            $where[] = ['city' => $city];
        }
        if(!empty($area)){
            $where[] = ['area' => $area];
        }
		//判断登陆账号是否为渠道账户
		if($session['admin']['type'] == 1){
			$where[] = ['channel_no' => $session['admin']['admin_name']];
		}
		
        $total = Store::find()->where($where)->count();
        $storeData = Store::find()
                ->where($where)
                ->limit($rows)
                ->offset($offset)
                ->orderBy("{$sort} {$orderBy}")
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
