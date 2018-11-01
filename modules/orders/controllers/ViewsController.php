<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Lottery;
use app\modules\orders\models\Order;
use app\modules\orders\models\OrderDetail;

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
	
	/**
     * 填写发货快递信息
     */
	public function actionToCourierAdd() {
        $request = \Yii::$app->request;
        $order_id = $request->get('order_id');
        $where = ['order_id' => $order_id];
        $ordersData = Order::find()->select('order_code,order_id')
                ->where($where)
                ->asArray()
                ->one();
        return $this->render('/ordersmod/orders/courier-add', ['ordersData' => $ordersData]);
    }
	
	/**
     * 查看订单详情页面
     */
	public function actionToOrdersDetails() {
        $request = \Yii::$app->request;
        $order_id = $request->get('order_id');
        $where = ['order_id' => $order_id];
        $ordersData = Order::find()->where($where)->asArray()->one();
		$orderDetailData = OrderDetail::find()->where($where)->asArray()->all();
        return $this->render('/ordersmod/orders/detail', ['ordersData' => $ordersData,'orderDetailData' => $orderDetailData]);
    }


}
