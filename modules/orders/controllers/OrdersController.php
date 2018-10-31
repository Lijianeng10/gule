<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Lottery;

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

}
