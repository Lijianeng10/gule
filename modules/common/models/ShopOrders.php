<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "shop_orders".
 *
 * @property integer $order_id
 * @property string $order_code
 * @property integer $user_id
 * @property integer $order_num
 * @property string $order_money
 * @property integer $order_status
 * @property integer $pay_status
 * @property string $address
 * @property string $remark
 * @property string $touser_remark
 * @property string $order_time
 * @property string $pay_time
 * @property string $send_time
 * @property string $receive_time
 * @property string $update_time
 * @property string $wxpay_data
 * @property integer $add_status
 */
class ShopOrders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_code', 'user_id', 'order_time'], 'required'],
            [['user_id', 'order_num', 'order_status', 'pay_status', 'add_status'], 'integer'],
            [['order_money'], 'number'],
            [['order_time', 'pay_time', 'send_time', 'receive_time', 'update_time'], 'safe'],
            [['wxpay_data'], 'string'],
            [['order_code'], 'string', 'max' => 45],
            [['address'], 'string', 'max' => 255],
            [['remark', 'touser_remark'], 'string', 'max' => 500],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_code' => 'Order Code',
            'user_id' => 'User ID',
            'order_num' => 'Order Num',
            'order_money' => 'Order Money',
            'order_status' => 'Order Status',
            'pay_status' => 'Pay Status',
            'address' => 'Address',
            'remark' => 'Remark',
            'touser_remark' => 'Touser Remark',
            'order_time' => 'Order Time',
            'pay_time' => 'Pay Time',
            'send_time' => 'Send Time',
            'receive_time' => 'Receive Time',
            'update_time' => 'Update Time',
            'wxpay_data' => 'Wxpay Data',
            'add_status' => 'Add Status',
        ];
    }
}
