<?php

namespace app\modules\product\controllers;


use Yii;
use yii\web\Controller;
use app\modules\tools\helpers\UploadPic;
use yii\base\Exception;
use app\modules\common\helpers\Commonfun;
use yii\db\Expression;
use app\modules\common\models\Product;
use app\modules\common\models\Category;

class ProductController extends Controller {

    public function actionGetProductList() {
        $request = \Yii::$app->request;
        $page = $request->post('page', 1);
        $size = $request->post('rows', 10);
        $orderBy = $request->post('order', '');
        $sort = $request->post('sort', '');
        $productInfo = $request->post('productInfo');
        $p_id = $request->post('p_id');
        $status = $request->post('status');
        $where = ['and'];
        if (!empty($productInfo)) {
            $where[] = ['or', ['like', 'product_name', $productInfo], ['like', 'description', $productInfo]];
        }
        if ($status === '0' || $status === '1') {
            $where[] = ['status' => $status];
        }
        if ($p_id != '' && $p_id != '-1') {
            $where[] = ['category' => $p_id];
        }
        $total = Product::find()->where($where)->count();
        $offset = $size * ($page - 1);
        $field = ['*'];
        $productData = Product::find()->select($field)
                ->where($where)
                ->limit($size)
                ->offset($offset)
                ->orderBy("{$orderBy} {$sort}")
                ->asArray()
                ->all();
        //查询上级权限名称
        $list = Category::find()->indexBy("category_id")->asArray()->all();
        foreach ($productData as &$dataList) {
                $dataList["p_name"] = $list[$dataList["category"]]["name"];
        }
        return \Yii::datagridJson($productData, $total);
    }

    public function actionAdd() {
        $request = \Yii::$app->request;
        $productName = $request->post('productName', '');
        $description = $request->post('description', '');
        $category = $request->post('category', '');
        $productPrice = $request->post('productPrice', '');
        $masterPic = $request->post('masterPic', '');
        $remark = $request->post('remark', '');
        $status = $request->post('status', '');
        if (empty($productName) || ctype_space($productName)) {
            return $this->jsonError(109, '产品名称不可为空！');
        }
        if (ctype_space($productPrice)) {
            return $this->jsonError(109, '产品价格不可为空！');
        }
        if (empty($masterPic)) {
            return $this->jsonError(109, '产品主图必须上传！');
        }
        $isUse = Product::find()->where(['product_name'=>$productName])->one();
        if(!empty($isUse)){
            return $this->jsonError(109, '产品名称重复，请检查！');
        }
        $product = new Product();
//        $product->product_code = 'JKP' . $productCode;
        $product->product_name = trim($productName);
        $product->description = trim($description);
        $product->category = $category;
        $product->product_pic = $masterPic;
        $product->product_price = $productPrice;
        $product->product_detail = $remark;
        $product->status = $status;
        $product->create_time = date('Y-m-d H:i:s');
        if(!$product->save()){
            return $this->jsonError(109,$product->getErrors());
        }
        return $this->jsonResult(600,'新增成功！');
    }

    public function actionUploadPic() {
        if (isset($_FILES['uploadPic'])) {
            $day = date('ymdHis', time());
            $file = $_FILES['uploadPic'];
            $check = UploadPic::check_upload_pic($file);
            if ($check['code'] != 600) {
                return $this->jsonError($check['code'], $check['msg']);
            }
            $type = strtolower(substr($file['name'],strrpos($file['name'],'.')+1));
            $name = $day.'.'.$type;
            $saveDir = '/productImg/';
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

    public function actionDelete() {
        $request = \Yii::$app->request;
        $result = Product::deleteAll(['product_id' => $post['ids']]);
        if ($result) {
            return $this->jsonResult(600, '操作成功', '');
        }
        return $this->jsonError(109, '操作失败');

    }

    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $res = Product::updateAll(['status' => $parmas['status']], ['product_id' => $parmas['id']]);
        if($res){
            return $this->jsonResult(600, '操作成功', true);
        }else{
            return $this->jsonError(109, '操作失败');
        }
    }

    /**
     * 产品推荐
     */
    public function actionChangeHotStatus() {
        $parmas = \Yii::$app->request->post();
        $res = Product::updateAll(['is_hot' => $parmas['status']], ['product_id' => $parmas['id']]);
        if($res){
            return $this->jsonResult(600, '操作成功', true);
        }else{
            return $this->jsonError(109, '操作失败');
        }
    }
    public function actionUpdate() {
        $request = \Yii::$app->request;
        $productId = $request->post('productId');
        $productName = $request->post('productName', '');
        $description = $request->post('description', '');
        $category = $request->post('category', '');
        $productPrice = $request->post('productPrice', '');
        $masterPic = $request->post('masterPic', '');
        $remark = $request->post('remark', '');
        $status = $request->post('status', '');
        if (empty($productName) || ctype_space($productName)) {
            return $this->jsonError(109, '产品名称不可为空！');
        }
        if (ctype_space($productPrice)) {
            return $this->jsonError(109, '产品价格不可为空！');
        }
        if (empty($masterPic)) {
            return $this->jsonError(109, '产品主图必须上传！');
        }
        $isUse = Product::find()->where(['product_name'=>$productName])->andWhere(['<>','product_id',$productId])->one();
        if(!empty($isUse)){
            return $this->jsonError(109, '产品名称重复，请检查！');
        }
        $product = Product::find()->where(['product_id'=>$productId])->one();
        $product->product_name = trim($productName);
        $product->description = trim($description);
        $product->category = $category;
        $product->product_pic = $masterPic;
        $product->product_price = $productPrice;
        $product->product_detail = $remark;
        $product->status = $status;
        if(!$product->save()){
            return $this->jsonError(109,$product->getErrors());
        }
        return $this->jsonResult(600,'新增成功！');
    }


    
    public function actionSubChangeStatus() {
        $session = \Yii::$app->session;
        $coreId = $session['admin']['center_id'];
        if (empty($coreId)) {
            return $this->jsonError(109, '无权限操作！！');
        }
        $request = \Yii::$app->request;
        $pId = $request->post('productId', '');
        $subId = $request->post('subId', '');
        $status = $request->post('status', '');
         $productData = Product::findOne(['product_id' => $pId, 'core_id' => $coreId]);
        if (empty($productData)) {
            return $this->jsonError(109, '无权限对该子商品进行操作');
        }
        $subData = ProductSub::findOne(['sub_id' => $subId, 'product_id' => $pId]);
        if (empty($subData)) {
            return $this->jsonError(109, '该子商品不存在');
        }
        $subData->sub_status = $status;
        $subData->modify_time = date('Y-m-d H:i:s');
        $subData->opt_name = $session['admin']['admin_name'];
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            if (!$subData->save()) {
                throw new Exception('子商品更新失败');
            }
            $sumUp = ProductSub::find()->where(['product_id' => $pId, 'sub_status' => 1])->count();
            if (!$sumUp) {
                $productData->product_status = 0;
                $productData->modify_time = date('Y-m-d H:i:s');
                $productData->opt_name = $session['admin']['admin_name'];
                if(!$productData->save()) {
                    throw new Exception('商品下架失败');
                }
            }
            $trans->commit();
            return $this->jsonResult(600, '更新成功', true);
        } catch (Exception $ex) {
            $trans->rollBack();
            return $this->jsonError(109, $ex->getMessage());
        }
    }

}
