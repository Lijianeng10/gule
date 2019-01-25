<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property integer $product_id
 * @property string $product_name
 * @property string $description
 * @property integer $category
 * @property string $product_pic
 * @property string $product_price
 * @property string $product_detail
 * @property integer $is_hot
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Product extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'is_hot', 'status'], 'integer'],
            [['product_price'], 'number'],
            [['product_detail'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['product_name'], 'string', 'max' => 150],
            [['description', 'product_pic'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'product_id' => 'Product ID',
            'product_name' => 'Product Name',
            'description' => 'Description',
            'category' => 'Category',
            'product_pic' => 'Product Pic',
            'product_price' => 'Product Price',
            'product_detail' => 'Product Detail',
            'is_hot' => 'Is Hot',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
