<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $cust_no
 * @property string $nickname
 * @property string $phone
 * @property string $pwd
 * @property string $agent_code
 * @property integer $status
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
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['cust_no', 'nickname', 'agent_code'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20],
            [['pwd'], 'string', 'max' => 255],
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
            'phone' => 'Phone',
            'pwd' => 'Pwd',
            'agent_code' => 'Agent Code',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
