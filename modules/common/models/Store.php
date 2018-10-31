<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "store".
 *
 * @property integer $store_id
 * @property string $cust_no
 * @property string $user_tel
 * @property string $channel_no
 * @property integer $status
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time', 'modify_time', 'update_time'], 'safe'],
            [['cust_no', 'user_tel', 'channel_no'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'store_id' => 'Store ID',
            'cust_no' => 'Cust No',
            'user_tel' => 'User Tel',
            'channel_no' => 'Channel No',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
