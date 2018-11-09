<?php

namespace app\modules\admin\models;

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
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'admin';
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
     * 说明:获取我的所属角色列表
     * @author chenqiwei
     * @date 2018/9/3 下午4:55
     * @param
     * @return
     */
    public function getMyRoles($adminId){
        $myRoles = SysAdminRole::find()
            ->select(['sys_role.role_id','sys_role.role_name'])
            ->leftJoin('sys_role','sys_role.role_id = sys_admin_role.role_id')
            ->where(['sys_admin_role.admin_id'=>$adminId])
            ->asArray()->all();
        return $myRoles;
    }

    public function getMyCenters($adminId){
        $centers = CenterAdmin::find()->select(['center.center_id','center_name'])
            ->leftJoin('center','center.center_id = center_admin.center_id')
            ->where(['admin_id' => $adminId])->asArray()->all();
        return $centers;
    }


}
