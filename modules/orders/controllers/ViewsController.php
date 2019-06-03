<?php

namespace app\modules\orders\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\ShopOrders;
use app\modules\common\models\ShopOrdersDetail;

/**
 * Views controller for the `views` module
 */
class ViewsController extends Controller {
    /**
     * 订单列表
     * @return string
     */
    public function actionToOrdersList(){
        return $this->render('/ordersmod/orders/list');
    }
    /**
     * 新增门店订单
     */
    public function actionToAddOrders(){
        $session = \Yii::$app->session;
        $type = $session['admin']['type'];
        if($type!=1){
            return '<span style="text-align: center;font-size: 16px;display: inline-block;width: 100%;">不是渠道用户无该操作权限！</span>';
        }
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
        $ordersData = ShopOrders::find()->where($where)->asArray()->one();
		$orderDetailData = ShopOrdersDetail::find()
						->select(["shop_orders_detail.*","product.product_name","product.product_pic"])
						->leftJoin("product","product.product_id = shop_orders_detail.product_id")
						->where($where)
                        ->asArray()
                        ->all();
        return $this->render('/ordersmod/orders/detail', ['ordersData' => $ordersData,'orderDetailData' => $orderDetailData]);
    }


}
