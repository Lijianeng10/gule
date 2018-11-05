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

    public function actionAdd() {
        $request = \Yii::$app->request;
        $lotteryName = $request->post('lottery_name', '');
        $lotteryValue = $request->post('lottery_value', '');
        $lotteryPic = $request->post('lottery_pic', '');
        $session = \Yii::$app->session;
        if (empty($lotteryName) || empty($lotteryValue)) {
            return $this->jsonError(109, '参数缺失！！');
        }
        $existLottery = Lottery::findOne(['lottery_name' => $lotteryName,'lottery_value'=>$lotteryValue]);
        if (!empty($existLottery)) {
            return $this->jsonError(109, '彩种面额已存在，请重试');
        }
        $maxCode = Lottery::find()->select(['lottery_code'])->orderBy('lottery_code desc')->asArray()->one();
        if ($maxCode) {
            $lotteryCode = (int) $maxCode['lottery_code'] + 1;
        } else {
            $lotteryCode = '1001';
        }
        $lottery = new Lottery;
        $lottery->lottery_code = (string) $lotteryCode;
        $lottery->lottery_name = trim($lotteryName);
        $lottery->lottery_value = trim($lotteryValue);
        $lottery->lottery_img = $lotteryPic;
        $lottery->admin_code = $session['admin']['admin_name'];
        $lottery->create_time = date('Y-m-d H:i:s');
        if (!$lottery->save()) {
            return $this->jsonError(109, '添加失败');
        }
        return $this->jsonResult(600, '添加成功');
    }

    public function actionUpdate() {
        $request = \Yii::$app->request;
        $lotteryName = $request->post('lottery_name');
        $lotteryId = $request->post('lottery_id');
        $lotteryValue = $request->post('lottery_value', '');
        $lotteryPic = $request->post('lottery_pic', '');
        if (!$lotteryName||!$lotteryValue) {
            return $this->jsonError(109, '参数缺失');
        }
        $session = \Yii::$app->session;
        $existName = Lottery::find()->where(['lottery_name' => $lotteryName,'lottery_value'=>$lotteryValue])->andWhere(['!=', 'lottery_id', $lotteryId])->count();
        if ($existName) {
            return $this->jsonError(109, '该彩种已存在，请勿重复添加');
        }
        $lotteryData = Lottery::findOne(['lottery_id' => $lotteryId]);
        if (!$lotteryData) {
            return $this->jsonError(109, '该数据不存在，请稍后再试');
        }
        $lotteryData->lottery_name = trim($lotteryName);
        $lotteryData->lottery_value = trim($lotteryValue);
        $lotteryData->lottery_img = $lotteryPic;
        $lotteryData->admin_code = $session['admin']['admin_name'];
        if (!$lotteryData->save()) {
            return $this->jsonError(109, '数据更新失败');
        }
        return $this->jsonResult(600, '数据更新成功', true);
    }

    public function actionDelete() {
        $request = \Yii::$app->request;
        $ids = $request->post('ids');
        $idArr = explode(',', $ids);
        $del = Lottery::deleteAll(['in', 'lottery_id', $idArr]);
        if (!$del) {
            return $this->jsonError(109, '删除失败');
        }
        return $this->jsonResult(600, '删除成功');
    }

    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 0;
        }
        Lottery::updateAll(['status' => $status], ['lottery_id' => $parmas['id']]);
        return $this->jsonResult(600, '修改成功', true);
    }
    /**
     * 上传彩种图片
     */
    public function actionUploadPic() {
        if (isset($_FILES['uploadPic'])) {
            $file = $_FILES['uploadPic'];
            $check = UploadPic::check_upload_pic($file);
            if ($check['code'] != 600) {
                return $this->jsonError($check['code'], $check['msg']);
            }
            $saveDir = '/lotteryImg/';
            $str = substr(strrchr($file['name'], '.'), 1);
            $name = rand(0,99).'.' . $str;
            $pathJson = UploadPic::pic_host_upload($file, $saveDir,$name);
            $pathArr = json_decode($pathJson, true);
            if ($pathArr['code'] != 600) {
                return $this->jsonError($pathArr['code'], $pathArr['msg']);
            }
            $path = $pathArr['result']['ret_path'];
            return $this->jsonResult(600, '上传成功', $path);
        } else {
            return $this->jsonError(100, '未上传图片');
        }
    }

}
