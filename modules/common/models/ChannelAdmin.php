<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "channel_admin".
 *
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $password
 * @property string $nickname
 * @property string $admin_code
 * @property integer $type
 * @property integer $status
 * @property integer $admin_pid
 * @property string $create_time
 * @property string $last_login
 * @property string $update_time
 */
class ChannelAdmin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_admin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_name', 'password', 'create_time'], 'required'],
            [['type', 'status', 'admin_pid'], 'integer'],
            [['create_time', 'last_login', 'update_time'], 'safe'],
            [['admin_name', 'nickname'], 'string', 'max' => 50],
            [['password', 'admin_code'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'admin_name' => 'Admin Name',
            'password' => 'Password',
            'nickname' => 'Nickname',
            'admin_code' => 'Admin Code',
            'type' => 'Type',
            'status' => 'Status',
            'admin_pid' => 'Admin Pid',
            'create_time' => 'Create Time',
            'last_login' => 'Last Login',
            'update_time' => 'Update Time',
        ];
    }
    /**
     * 密码验证
     */
    public function validatePassword() {
        if ($this->password != null) {
            $adminInfo = $this->findOne(["admin_name" => $this->admin_name]);
            if ($adminInfo != null && $adminInfo->password == $this->password) {
                $this->admin_id = $adminInfo['admin_id'];
                $this->nickname = $adminInfo['nickname'];
                $this->last_login = $adminInfo['last_login'];
                $this->admin_code = $adminInfo['admin_code'];
                $this->type = $adminInfo['type'];
                return true;
            } else {
                return false;
            }
            return Yii::$app->security->validatePassword($this->password, $adminInfo->password);
        }
    }
}
