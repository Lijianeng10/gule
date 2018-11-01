<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "pay_record".
 *
 * @property integer $pay_record_id
 * @property string $order_code
 * @property string $store_no
 * @property string $channel_no
 * @property string $terminal_num
 * @property string $outer_code
 * @property integer $pay_type
 * @property integer $lottery_value
 * @property integer $buy_nums
 * @property string $pre_pay_money
 * @property string $pay_money
 * @property string $pay_time
 * @property integer $status
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class PayRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pay_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pay_type', 'lottery_value', 'buy_nums', 'status'], 'integer'],
            [['pre_pay_money', 'pay_money'], 'number'],
            [['pay_time', 'create_time', 'modify_time', 'update_time'], 'safe'],
            [['order_code'], 'string', 'max' => 100],
            [['store_no', 'channel_no', 'terminal_num'], 'string', 'max' => 50],
            [['outer_code'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pay_record_id' => 'Pay Record ID',
            'order_code' => 'Order Code',
            'store_no' => 'Store No',
            'channel_no' => 'Channel No',
            'terminal_num' => 'Terminal Num',
            'outer_code' => 'Outer Code',
            'pay_type' => 'Pay Type',
            'lottery_value' => 'Lottery Value',
            'buy_nums' => 'Buy Nums',
            'pre_pay_money' => 'Pre Pay Money',
            'pay_money' => 'Pay Money',
            'pay_time' => 'Pay Time',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
