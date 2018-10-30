<?php

namespace app\modules\shopadmin\models;

use Yii;

/**
 * This is the model class for table "sys_admin_role".
 *
 * @property integer $admin_role_id
 * @property integer $admin_id
 * @property integer $role_id
 * @property string $update_time
 */
class SysAdminRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_admin_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_id'], 'required'],
            [['admin_id', 'role_id'], 'integer'],
            [['update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_role_id' => 'Admin Role ID',
            'admin_id' => 'Admin ID',
            'role_id' => 'Role ID',
            'update_time' => 'Update Time',
        ];
    }
}
