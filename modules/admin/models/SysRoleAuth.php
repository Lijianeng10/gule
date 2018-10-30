<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "sys_role_auth".
 *
 * @property integer $role_auth_id
 * @property integer $role_id
 * @property integer $auth_id
 * @property string $update_time
 */
class SysRoleAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_role_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'auth_id'], 'required'],
            [['role_id', 'auth_id'], 'integer'],
            [['update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_auth_id' => 'Role Auth ID',
            'role_id' => 'Role ID',
            'auth_id' => 'Auth ID',
            'update_time' => 'Update Time',
        ];
    }
}
