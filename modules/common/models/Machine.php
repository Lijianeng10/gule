<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "machine".
 *
 * @property integer $machine_id
 * @property string $terminal_num
 * @property string $machine_code
 * @property string $cust_no
 * @property string $channel_no
 * @property integer $lottery_id
 * @property integer $lottery_value
 * @property integer $stock
 * @property integer $ac_status
 * @property integer $online_status
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class Machine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'machine';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lottery_id', 'lottery_value', 'stock', 'ac_status', 'online_status', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['terminal_num', 'machine_code', 'cust_no', 'channel_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'machine_id' => 'Machine ID',
            'terminal_num' => 'Terminal Num',
            'machine_code' => 'Machine Code',
            'cust_no' => 'Cust No',
            'channel_no' => 'Channel No',
            'lottery_id' => 'Lottery ID',
            'lottery_value' => 'Lottery Value',
            'stock' => 'Stock',
            'ac_status' => 'Ac Status',
            'online_status' => 'Online Status',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
