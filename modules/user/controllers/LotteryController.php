<?php

namespace app\modules\user\controllers;

use yii\web\Controller;
use Yii;
use app\modules\common\helpers\Commonfun;
use app\modules\common\models\Lottery;
use app\modules\tools\helpers\UploadPic;

class LotteryController extends Controller {

    public function actionGetLotteryList() {

        $request = \Yii::$app->request;
        $page = $request->post('page', 1);
        $size = $request->post('size', 15);
        $sort = $request->post('sort', '');
        $orderBy = $request->post('order', '');
        $lotteryInfo = $request->post('lotteryInfo', '');
        $status = $request->post('status');
//        $session = \Yii::$app->session;

        $where = ['and'];
        if (!empty($lotteryInfo)) {
            $where[] = ['or', ['like', 'lottery_code', $lotteryInfo], ['like', 'lottery_name', $lotteryInfo]];
        }

        if (!empty($status)) {
            $where[] = ['status' => $status];
        }

        $total = Lottery::find()->where($where)->count();
        $lotteryData = Lottery::find()
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
