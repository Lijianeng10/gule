<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\User;
use app\modules\front\services\ProductService;

class ProductController extends Controller {
    /**
     * 获取推荐产品
     * @return type
     */
    public function actionGetHotProduct() {
        $request = \Yii::$app->request;
        $pageSize = $request->post('page_size', 10);
        $ret = ProductService::getHotProduct($pageSize);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    /**
     * 获取产品列表
     * @return type
     */
    public function actionGetProductList() {
        $request = \Yii::$app->request;
        $pageNum = $request->post('page_num', 1);
        $pageSize = $request->post('page_size', 10);
        $ret = ProductService::getProductList($pageNum,$pageSize);
        return $this->jsonResult(600, '获取成功', $ret);
    }


}
