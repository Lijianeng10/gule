<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $cust_no
 * @property string $nickname
 * @property string $pic
 * @property string $phone
 * @property string $pwd
 * @property string $agent_code
 * @property integer $status
 * @property string $real_name
 * @property string $id_card_num
 * @property string $e_mail
 * @property string $address
 * @property integer $real_status
 * @property string $create_time
 * @property string $update_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'real_status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['cust_no', 'nickname', 'agent_code', 'real_name', 'id_card_num'], 'string', 'max' => 50],
            [['pic', 'pwd', 'address'], 'string', 'max' => 255],
            [['phone'], 'string', 'max' => 20],
            [['e_mail'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'cust_no' => 'Cust No',
            'nickname' => 'Nickname',
            'pic' => 'Pic',
            'phone' => 'Phone',
            'pwd' => 'Pwd',
            'agent_code' => 'Agent Code',
            'status' => 'Status',
            'real_name' => 'Real Name',
            'id_card_num' => 'Id Card Num',
            'e_mail' => 'E Mail',
            'address' => 'Address',
            'real_status' => 'Real Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}