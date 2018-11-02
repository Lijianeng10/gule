<?php

namespace app\modules\user\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\common\models\Lottery;
use app\modules\common\models\StoreLottery;


class ViewsController extends Controller {

    /**
     * @return string 网点列表
     */
    public function actionToStoreList(){
        return $this->render('/usermod/store/list',[]);
    }
	/**
     * @return string 网点彩种库存详情
     */
    public function actionToStockLotteryDetails(){
		$request = \Yii::$app->request;
        $cust_no = $request->get('cust_no');
        $storeLotteryData = StoreLottery::find()
							->select(["store_lottery.*","lottery.lottery_name","lottery.lottery_img"])
							->leftJoin("lottery","lottery.lottery_id = store_lottery.lottery_id")
							->where(['cust_no' => $cust_no])->asArray()->all();
        return $this->render('/usermod/store/lottery_details',['storeLotteryData' => $storeLotteryData,'cust_no' => $cust_no]);
    }
    /**
     * 终端号列表
     */
    public function actionToTerminalList(){
        return $this->render('/usermod/terminal/list');
    }
    /**
     * 新增终端号
     */
    public function actionToTerminalAdd(){
        return $this->render('/usermod/terminal/add');
    }
    /**
     * 查看终端号二维码
     */
    public function actionToTerminalQrcode(){
        $request= \Yii::$app->request;
        $url = $request->get('url');
        $num = explode('=',$url)[1];
        return $this->render('/usermod/terminal/qrcode',['url'=>$url,'num'=>$num]);
    }
    /**
     * 机器列表
     */
    public function actionToMachineList(){
        return $this->render('/usermod/machine/list');
    }
    /**
     * 彩种列表
     */
    public function actionToLotteryList(){
        return $this->render('/usermod/lottery/list');
    }
    public function actionToLotteryAdd(){
        return $this->render('/usermod/lottery/add');
    }
    public function actionToLotteryEdit(){
        $request = \Yii::$app->request;
        $lotteryId = $request->get('lottery_id');
        $lotteryData = Lottery::find()->where(['lottery_id' => $lotteryId])->asArray()->one();
        return $this->render('/usermod/lottery/edit',['lotteryData' => $lotteryData]);
    }
    /**
     * 销售明细列表
     */
    public function actionToPayrecordList(){
        return $this->render('/usermod/payrecord/list');
    }
}
