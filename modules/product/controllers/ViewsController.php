<?php

namespace app\modules\product\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\common\models\Category;
use app\modules\common\models\Product;


class ViewsController extends Controller {

    /**
     * @return string 类别列表
     */
    public function actionToCategoryList(){
        return $this->render('/productmod/category/list',[]);
    }
    public function actionToCategoryAdd(){
        return $this->render('/productmod/category/add');
    }
    public function actionToCategoryEdit(){
        $id = \Yii::$app->request->get('category_id');
        $auth = Category::find()->where(['category_id'=>$id])->asArray()->one();
        return $this->render('/productmod/category/edit',['auth'=>$auth]);
    }

    /**
     * 产品列表
     * @return string
     */
    public function actionToProductList(){
        return $this->render('/productmod/product/list');
    }

    public function actionToProductAdd() {
        return $this->render('/productmod/product/add');
    }
    public function actionToProductEdit(){
        $id = \Yii::$app->request->get('product_id');
        $data = Product::find()->where(['product_id'=>$id])->asArray()->one();
//        if($data['status']!=0){
//            return $this->jsonError(109,'请先将产品下架再编辑！');
//        }
        return $this->render('/productmod/product/edit',['data'=>$data]);
    }

}
