<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "user_address".
 *
 * @property integer $user_address_id
 * @property string $cust_no
 * @property string $consignee_name
 * @property string $consignee_tel
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $post_code
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 */
class UserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_address';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['cust_no'], 'string', 'max' => 15],
            [['consignee_name'], 'string', 'max' => 25],
            [['consignee_tel'], 'string', 'max' => 11],
            [['province', 'city', 'area', 'post_code'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_address_id' => 'User Address ID',
            'cust_no' => 'Cust No',
            'consignee_name' => 'Consignee Name',
            'consignee_tel' => 'Consignee Tel',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'post_code' => 'Post Code',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
