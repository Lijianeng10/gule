<?php

namespace app\modules\product\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\common\models\Category;


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

}
