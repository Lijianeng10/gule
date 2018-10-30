<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\common\helpers;

use app\modules\admin\models\SysAuth;
use Yii;
use yii\db\Query;
use app\modules\common\models\SysConf;

class AdminCommonfun {

    /**
     * 获取权限url
     * @return array
     */
    public static function  getAuthurls() {
        $session = Yii::$app->session;
        $adminId = $session['admin']['admin_id'];
//        $admin_role_model = new Query();
//        $roleIds = $admin_role_model->select('admin_role.role_id')
//                ->from(['admin_role' => 'sys_admin_role'])
//                ->leftJoin(['role' => 'sys_role'], 'role.role_id = admin_role.role_id')
//                ->where(['role.status' => '1'])
////                ->andWhere(["role.login_port" => $loginPort])
//                ->andWhere(['admin_role.admin_id' => $adminId]);
////            ->asArray()
////                ->all();
//        $role_auth_model = new Query();
//        $authIds = $role_auth_model->select('auth_id')
//                ->from('sys_role_auth')
//                ->where(['in', 'role_id', $roleIds]);
//
//        $auth_model = new Query();
//        $authUrls = $auth_model->select(['auth_url','auth_name','auth_pid','auth_id','auth_name as text','auth_id as id'])
//                ->from('sys_auth')
//                ->where(['auth_status' => '1'])
//                ->andWhere(['in', 'auth_id', $authIds])
//                ->orderBy("auth_sort desc,auth_id asc")
//                ->all();
        $authList = SysAuth::find()->select(['sys_auth.auth_url','sys_auth.auth_name','sys_auth.auth_pid','sys_auth.auth_id','sys_auth.auth_name as text','sys_auth.auth_id as id'])
            ->leftJoin('sys_role_auth ru','ru.auth_id = sys_auth.auth_id')
            ->leftJoin('sys_admin_role ar','ar.role_id = ru.role_id')
            ->leftJoin('admin sy','sy.admin_id = ar.admin_id')
            ->where(['sy.admin_id'=>$adminId,'sys_auth.auth_status'=>1])
//            ->andWhere(['sys_auth.auth_type'=>1])
            ->orderBy('sys_auth.auth_sort desc,sys_auth.auth_id asc')
            ->asArray()
            ->all();

        return $authList;
    }

    public static function getChildrens($pid, $menus) {
        $ret = [];
        foreach ($menus as $key => $value) {
            if ($value["auth_pid"] == $pid) {
                $value["childrens"] = self::getChildrens($value["auth_id"], $menus);
                $ret[] = $value;
                unset($menus[$key]);
            }
        }
        return $ret;
    }
    /**
     * 隐藏不显示模块
     */
    public static function delCloseAuth($mid,$menus){
        foreach ($menus as $key => $value) {
            if ($value["auth_id"] == $mid ||$value["auth_pid"] == $mid) {
                unset($menus[$key]);
            }
            if($value["auth_pid"] == $mid){
                $menus = self::delCloseAuth($value["auth_id"], $menus);
                unset($menus[$key]);
                
            }
        }
        return $menus;
    }
    /**
     * 获取权限url
     * @return array
     */
    public static function getNowAuthurls($admin_id="") {
//        $loginPort = "sys"
        if(empty($admin_id)){
            $session = Yii::$app->session;
            $adminId = $session['admin']['admin_id'];
        }else{
            $adminId = $admin_id;
        }
        $authUrls =SysAuth::find()->select(["auth_url"])
            ->leftJoin('sys_role_auth ru','ru.auth_id = sys_auth.auth_id')
            ->leftJoin('sys_admin_role ar','ar.role_id = ru.role_id')
            ->leftJoin('admin a','a.admin_id = ar.admin_id')
            ->where(['a.admin_id'=>$adminId])
            ->andWhere(['sys_auth.auth_status'=>1])
            ->orderBy("sys_auth.auth_sort desc,sys_auth.auth_id asc")
            ->asArray()
            ->all();
        return $authUrls;
    }
    /**
     * 说明:获取系统配置文件参数
     * @param   array $params //参数数组
     * @return
     */
    public static function getSysConf($params,$where = ['status'=>1]) {
        $configs = SysConf::find()->where(['in', 'code', $params])->andWhere($where)->asArray()->all();
        $res = [];
        foreach ($configs as $config) {
            $res[$config['code']] = $config['value'];
        }
        return $res;
    }

}
