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
        $id = $request->post('id', '');//类别ID
        $ret = ProductService::getProductList($pageNum,$pageSize,$id);
        return $this->jsonResult(600, '获取成功', $ret);
    }

    /**
     * 获取产品详情
     */
    public function actionGetProductDetail(){
        $request = \Yii::$app->request;
        $productId = $request->post('productId', '');
        if(empty($productId)){
            return $this->jsonError(109,'参数缺失！');
        }
        $ret = ProductService::getProductDetail($productId);
        return $this->jsonResult(600, '获取成功', $ret);
    }
    /**
     * 获取产品类别
     */
    public function actionGetCategoryList(){
        $ret = ProductService::getCategoryList();
        return $this->jsonResult(600, '获取成功', $ret);
    }
    /**
     * 获取产品详情
     */
    public function actionGetProductListDetail(){
        $request = \Yii::$app->request;
        $pidStr = $request->post('pidStr', '');
        if(empty($pidStr)){
            return $this->jsonError(109,'参数缺失！');
        }
        $ret = ProductService::getProductListDetail($pidStr);
        return $this->jsonResult(600, '获取成功', $ret);
    }

}
