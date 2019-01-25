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
        $ids = $request->post('ids');
        $idArr = explode(',', $ids);
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            if (!Product::deleteAll(['in', 'product_id', $idArr])) {
                throw new Exception('商品删除失败');
            }
            if (!ProductSub::deleteAll(['in', 'product_id', $idArr])) {
                throw new Exception('子表删除失败');
            }
            if (!ProductImgs::deleteAll(['in', 'product_id', $idArr])) {
                throw new Exception('图片表删除失败');
            }
            $trans->commit();
            return $this->jsonResult(600, '删除成功');
        } catch (Exception $ex) {
            $trans->rollBack();
            return $this->jsonError(109, $ex->getMessage());
        }
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
        $session = \Yii::$app->session;
        $coreId = $session['admin']['center_id'];
        if (empty($coreId)) {
            return $this->jsonError(109, '无权限操作！！');
        }
        $request = \Yii::$app->request;
        $productId = $request->post('productId');
        $title = $request->post('title', '');
        $subTitle = $request->post('subTitle', '');
        $productNo = $request->post('productNo', '');
        $productPrice = $request->post('productPrice', '');
        $productSub = $request->post('productSub', '');
        $remark = $request->post('remark', '');
        $srcArr = $request->post('srcArr', '');
        $status = $request->post('status', '');
        $allStock = $request->post('productStock', '');
        $valueSub = $request->post('valueSub', '');
        $masterPic = $request->post('masterPic', '');
        if (empty($title) || ctype_space($title)) {
            return $this->jsonError(109, '商品标题不可为空');
        }
        if (ctype_space($productPrice)) {
            return $this->jsonError(109, '商品价格不可为空');
        }

        if (empty($productSub)) {
            return $this->jsonResult(109, '请选择彩票面额，并填写相关信息！');
        }
        if (empty($masterPic)) {
            return $this->jsonError(109, '商品主图必须上传！！');
        }
        $product = Product::findOne(['product_id' => $productId]);
        if (empty($product)) {
            return $this->jsonError(109, '此次编辑产品不存在！请重新选择！');
        }
        $existProduct = Product::find()->select(['art_no'])->where(['art_no' => $productNo, 'core_id' => $coreId])->andWhere(['!=', 'product_id', $productId])->asArray()->one();
        if (!empty($existProduct)) {
            return $this->jsonError(109, '商品编号请勿重复！！');
        }
        $product->product_title = trim($title);
        $product->product_sub_title = trim($subTitle);
        $product->art_no = trim($productNo);
        $product->product_price = $productPrice;
        $product->remark = $remark;
        $product->product_status = $status;
        $product->core_id = $coreId;
        $product->opt_name = $session['admin']['admin_name'];
        $product->modify_time = date('Y-m-d H:i:s');
        $product->product_stock = $allStock;
        $product->img_url = $masterPic;
        if ($status == 1) {
            $product->up_time = date('Y-m-d H:i:s');
        }
        $db = \Yii::$app->db;
        $trans = $db->beginTransaction();
        try {
            if (!$product->save()) {
                throw new Exception('产品表修改失败!!');
            }
            $updateSub = ProductSub::updateAll(['sub_status' => 0], ['and', ['product_id' => $productId], ['not in', 'sub_value', $valueSub]]);
            if ($updateSub === false) {
                throw new Exception('子产品更新失败！');
            }
            $field = ['product_id', 'sub_code', 'sub_price', 'sub_value', 'sub_stock', 'sub_sku', 'sub_status', 'opt_name', 'create_time'];
            $subVal = [];
            $i = 0;
            foreach ($productSub as $val) {
                if (empty($val[1])) {
                    throw new Exception('彩票面额数据有误!出售价格不可为空');
                }
                if (empty($val[2])) {
                    throw new Exception('彩票面额数据有误!面额相关库存不可为空');
                }
                $subProduct = ProductSub::findOne(['product_id' => $productId, 'sub_value' => $val[0]]);
                if (empty($subProduct)) {
                    $smaxCode = ProductSub::find()->select(['max(sub_code) max_code'])->where(['sub_value' => $val[0]])->asArray()->one();
                    if (empty($smaxCode['max_code'])) {
                        $subCode = 10001;
                    } else {
                        $subCode = (int) substr($smaxCode['max_code'], -5) + 1;
                    }
                    $code = 'JK' . $val[0] . 'V' . ($subCode + $i);
                    $subVal[] = [$product->product_id, $code, $val[1], $val[0], $val[2], trim($val[3]), 1, $session['admin']['admin_name'], date('Y-m-d H:i:s')];
                    $i++;
                } else {
                    $subProduct->sub_price = $val[1];
                    $subProduct->sub_stock = $val[2];
                    $subProduct->sub_sku = trim($val[3]);
                    $subProduct->sub_status = 1;
                    $subProduct->opt_name = $session['admin']['admin_name'];
                    $subProduct->modify_time = date('Y-m-d H:i:s');
                    if (!$subProduct->save()) {
                        throw new Exception('产品子表更新失败！！');
                    }
                }
            }

            $subRet = \Yii::$app->db->createCommand()->batchInsert('product_sub', $field, $subVal)->execute();
            if ($subRet === false) {
                throw new Exception('子产品新增失败！');
            }
            $delImg = ProductImgs::deleteAll(['product_id' => $productId]);
            if ($delImg === false) {
                throw new Exception('产品图片更新失败！');
            }

            if (!empty($srcArr)) {
                $key = ['product_id', 'img_url', 'create_time'];
                $imgVal = [];
                foreach ($srcArr as $src) {
                    $imgVal[] = [$productId, $src, date('Y-m-d H:i:s')];
                }
                $imgRet = \Yii::$app->db->createCommand()->batchInsert('product_imgs', $key, $imgVal)->execute();
                if ($imgRet === false) {
                    throw new Exception('产品图片更新失败！');
                }
            }
            $trans->commit();
            return $this->jsonResult(600, '新增成功', true);
        } catch (Exception $ex) {
            $trans->rollBack();
            return $this->jsonError(109, $ex->getMessage());
        }
    }

    public function actionSubEdit() {
        $session = \Yii::$app->session;
        $coreId = $session['admin']['center_id'];
        if (empty($coreId)) {
            return $this->jsonError(109, '无权限操作！！');
        }
        $request = \Yii::$app->request;
        $pId = $request->post('productId', '');
        $subId = $request->post('subId', '');
        $price = $request->post('price', '');
        $stock = $request->post('stock', '');
        $sku = $request->post('sku', '');
        $status = $request->post('status', '');
        $productData = Product::findOne(['product_id' => $pId, 'core_id' => $coreId]);
        if (empty($productData)) {
            return $this->jsonError(109, '无权限对该子商品进行操作');
        }
        $subData = ProductSub::findOne(['sub_id' => $subId, 'product_id' => $pId]);
        if (empty($subData)) {
            return $this->jsonError(109, '该子商品不存在');
        }
        $subData->sub_price = $price;
        $subData->sub_stock = $stock;
        $subData->sub_sku = $sku;
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
