<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "shop_orders_detail".
 *
 * @property integer $detail_id
 * @property integer $order_id
 * @property integer $product_id
 * @property string $product_price
 * @property integer $num
 * @property integer $is_gift
 * @property string $total_money
 * @property integer $is_comment
 */
class ShopOrdersDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_orders_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'product_id'], 'required'],
            [['order_id', 'product_id', 'num', 'is_gift', 'is_comment'], 'integer'],
            [['product_price', 'total_money'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'detail_id' => 'Detail ID',
            'order_id' => 'Order ID',
            'product_id' => 'Product ID',
            'product_price' => 'Product Price',
            'num' => 'Num',
            'is_gift' => 'Is Gift',
            'total_money' => 'Total Money',
            'is_comment' => 'Is Comment',
        ];
    }
}
