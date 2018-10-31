<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "order_detail".
 *
 * @property integer $order_detail_id
 * @property integer $order_id
 * @property string $order_code
 * @property string $product_code
 * @property string $sub_code
 * @property integer $lottery_id
 * @property string $lottery_name
 * @property integer $sub_value
 * @property integer $nums
 * @property integer $sheet_nums
 * @property string $price
 * @property string $money
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class OrderDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'lottery_id', 'sub_value', 'nums', 'sheet_nums'], 'integer'],
            [['price', 'money'], 'number'],
            [['create_time', 'modify_time', 'update_time'], 'safe'],
            [['order_code', 'product_code', 'sub_code', 'lottery_name'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_detail_id' => 'Order Detail ID',
            'order_id' => 'Order ID',
            'order_code' => 'Order Code',
            'product_code' => 'Product Code',
            'sub_code' => 'Sub Code',
            'lottery_id' => 'Lottery ID',
            'lottery_name' => 'Lottery Name',
            'sub_value' => 'Sub Value',
            'nums' => 'Nums',
            'sheet_nums' => 'Sheet Nums',
            'price' => 'Price',
            'money' => 'Money',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
