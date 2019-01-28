<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "shop_pay_record".
 *
 * @property integer $record_id
 * @property string $record_code
 * @property integer $order_id
 * @property string $order_code
 * @property integer $user_id
 * @property string $cust_no
 * @property string $outer_code
 * @property string $refund_code
 * @property string $third_refund_code
 * @property integer $pay_type
 * @property integer $pay_way
 * @property string $pre_money
 * @property string $pay_money
 * @property string $balance
 * @property integer $status
 * @property string $pay_time
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class ShopPayRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_pay_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_id', 'user_id', 'pay_type', 'pay_way', 'status'], 'integer'],
            [['pre_money', 'pay_money', 'balance'], 'number'],
            [['pay_time', 'create_time', 'modify_time', 'update_time'], 'safe'],
            [['record_code', 'order_code', 'refund_code'], 'string', 'max' => 50],
            [['cust_no'], 'string', 'max' => 25],
            [['outer_code', 'third_refund_code'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'record_id' => 'Record ID',
            'record_code' => 'Record Code',
            'order_id' => 'Order ID',
            'order_code' => 'Order Code',
            'user_id' => 'User ID',
            'cust_no' => 'Cust No',
            'outer_code' => 'Outer Code',
            'refund_code' => 'Refund Code',
            'third_refund_code' => 'Third Refund Code',
            'pay_type' => 'Pay Type',
            'pay_way' => 'Pay Way',
            'pre_money' => 'Pre Money',
            'pay_money' => 'Pay Money',
            'balance' => 'Balance',
            'status' => 'Status',
            'pay_time' => 'Pay Time',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
