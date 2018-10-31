<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "store_lottery".
 *
 * @property integer $store_lottey_id
 * @property string $cust_no
 * @property string $channel_no
 * @property integer $lottery_id
 * @property integer $lottery_value
 * @property integer $stock
 * @property string $create_time
 * @property string $update_time
 */
class StoreLottery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store_lottery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_lottey_id'], 'required'],
            [['store_lottey_id', 'lottery_id', 'lottery_value', 'stock'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['cust_no', 'channel_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'store_lottey_id' => 'Store Lottey ID',
            'cust_no' => 'Cust No',
            'channel_no' => 'Channel No',
            'lottery_id' => 'Lottery ID',
            'lottery_value' => 'Lottery Value',
            'stock' => 'Stock',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
