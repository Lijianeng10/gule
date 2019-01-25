<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/01/03
 * Time: 15:15:08
 */
namespace app\modules\front\services;

use Yii;
use yii\base\Exception;
use yii\db\Expression;
use app\modules\common\models\Product;

class ProductService{
    /**
     * 获取推荐产品
     * @param $pageSize
     * @return array
     */
    public static function getHotProduct($pageSize) {
        $productList = Product::find()
            ->where(['status' => 1,'is_hot'=>1])
            ->limit($pageSize)
            ->orderBy('create_time desc')
            ->asArray()
            ->all();
        return $productList;
    }
    /**
     * 获取产品列表
     * @return type
     */
    public static function getProductList($pageNum,$pageSize) {
        $total = Product::find()->where(['status' => 1])->count();
        $pages = ceil($total / $pageSize);
        $offset = ($pageNum - 1) * $pageSize;
        $productList = Product::find()
            ->where(['status' => 1])
            ->limit($pageSize)
            ->offset($offset)
            ->orderBy('create_time desc')
            ->asArray()
            ->all();
        return ['page_num' => $pageNum, 'data' => $productList, 'size' => $pageSize, 'pages' => $pages, 'total' => $total];
    }

    /**
     * 获取产品详情
     * @param $productId
     * @return array|null|\yii\db\ActiveRecord
     */
    public static function getProductDetail($productId) {
        $product = Product::find()
            ->where(['product_id' => $productId])
            ->asArray()
            ->one();
        return $product;
    }
}