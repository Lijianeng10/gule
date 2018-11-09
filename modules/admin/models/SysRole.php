<?php

namespace app\modules\admin\models;

use Yii;
use app\modules\common\helpers\Constants;

/**
 * This is the model class for table "sys_role".
 *
 * @property integer $role_id
 * @property string $role_name
 * @property integer $admin_id
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property string $login_port
 */
class SysRole extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name'], 'required'],
            [['admin_pid', 'status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['role_name', 'login_port'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'role_id' => 'Role ID',
            'role_name' => 'Role Name',
            'admin_pid' => 'Admin Pid',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'login_port' => 'Login Port',
        ];
    }

    /**
     * 说明:根据adminId获取角色列表
     * @author chenqiwei
     * @date 2018/9/4 下午1:57
     * @param
     * @return
     */
    public function getMyRoleList($adminId){
        $session = Yii::$app->session;
        $myroles = $session['admin']['role'];
        $where = ['and'];
		
		//除了系统管理员  都只能看到自己和自己所创建的角色
		if (!array_key_exists(Constants::ADMIN_ROLE,$session['admin']["role"])) {
			$where[] = ["or",["admin_pid"=>$adminId],['in',"role_id",$myroles]];
		}

        $dataLists =SysRole::find()
            ->select(['role_id as id', 'role_name as text'])
            ->Where($where)
            ->asArray()->all();
        return $dataLists;
    }

}
