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
 * @property string $store_name
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
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
            [['cust_no', 'user_tel', 'channel_no', 'province', 'city', 'area'], 'string', 'max' => 50],
            [['store_name'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 150],
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
            'store_name' => 'Store Name',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
