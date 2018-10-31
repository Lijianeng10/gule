<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Lottery;

/**
 * Views controller for the `views` module
 */
class ViewsController extends Controller {
    /**
     * 订单列表
     * @return string
     */
    public function actionToOrderList(){
        return $this->render('/ordersmod/orders/list');
    }
    /**
     * 新增门店订单
     */
    public function actionToAddOrders(){
        return $this->render('/ordersmod/orders/add-orders');
    }


}
