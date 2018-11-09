<?php

namespace app\modules\admin\models;

use Yii;

/**
 * This is the model class for table "sys_auth".
 *
 * @property integer $auth_id
 * @property string $auth_name
 * @property string $auth_url
 * @property string $auth_create_at
 * @property string $auth_update_at
 * @property integer $auth_status
 * @property integer $auth_pid
 * @property integer $auth_level
 * @property integer $auth_sort
 * @property string $update_time
 */
class SysAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_name', 'auth_create_at', 'auth_update_at'], 'required'],
            [['auth_create_at', 'auth_update_at', 'update_time'], 'safe'],
            [['auth_status', 'auth_pid', 'auth_level', 'auth_sort'], 'integer'],
            [['auth_name'], 'string', 'max' => 50],
            [['auth_url'], 'string', 'max' => 127],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_id' => 'Auth ID',
            'auth_name' => 'Auth Name',
            'auth_url' => 'Auth Url',
            'auth_create_at' => 'Auth Create At',
            'auth_update_at' => 'Auth Update At',
            'auth_status' => 'Auth Status',
            'auth_pid' => 'Auth Pid',
            'auth_level' => 'Auth Level',
            'auth_sort' => 'Auth Sort',
            'update_time' => 'Update Time',
        ];
    }
}
