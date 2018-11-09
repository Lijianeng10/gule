<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "order".
 *
 * @property integer $order_id
 * @property string $order_code
 * @property string $cust_no
 * @property integer $order_num
 * @property string $order_money
 * @property integer $order_status
 * @property integer $pay_status
 * @property string $address
 * @property string $shipping_fee
 * @property string $courier_name
 * @property string $courier_code
 * @property string $remark
 * @property string $touser_remark
 * @property string $order_time
 * @property string $pay_time
 * @property string $send_time
 * @property string $receive_time
 * @property string $update_time
 */
class Order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_code', 'cust_no', 'order_time'], 'required'],
            [['order_num', 'order_status', 'pay_status'], 'integer'],
            [['order_money', 'shipping_fee'], 'number'],
            [['order_time', 'pay_time', 'send_time', 'receive_time', 'update_time'], 'safe'],
            [['order_code'], 'string', 'max' => 45],
            [['cust_no', 'courier_name'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['courier_code'], 'string', 'max' => 100],
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
            'cust_no' => 'Cust No',
            'order_num' => 'Order Num',
            'order_money' => 'Order Money',
            'order_status' => 'Order Status',
            'pay_status' => 'Pay Status',
            'address' => 'Address',
            'shipping_fee' => 'Shipping Fee',
            'courier_name' => 'Courier Name',
            'courier_code' => 'Courier Code',
            'remark' => 'Remark',
            'touser_remark' => 'Touser Remark',
            'order_time' => 'Order Time',
            'pay_time' => 'Pay Time',
            'send_time' => 'Send Time',
            'receive_time' => 'Receive Time',
            'update_time' => 'Update Time',
        ];
    }
}
