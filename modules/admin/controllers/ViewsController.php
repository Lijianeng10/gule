<?php

namespace app\modules\shopadmin\controllers;


use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\modules\shopadmin\models\SysAdmin;
use app\modules\shopadmin\models\SysAdminRole;
use app\modules\shopadmin\models\SysAuth;
use app\modules\shopadmin\models\SysRole;

/**
 * Admin controller for the `admin` module
 */
class ViewsController extends Controller {

    /**
     * @return string 管理员列表
     */
    public function actionToAdminList(){
        return $this->render('/shopadminmod/admin/list');

    }
    public function actionToAdminAdd(){
        $role = SysRole::find()->where(["role_status"=>1])->asArray()->all();
        return $this->render('/shopadminmod/admin/add',["role"=>$role]);
    }
    public function actionToAdminEdit(){
        $id = \Yii::$app->request->get('id');
        $admin = SysAdmin::find()
            ->select(["sys_admin.*"])
            ->leftJoin("sys_admin_role as sr","sr.admin_id = sys_admin.admin_id")
            ->where(['sys_admin.admin_id'=>$id])
            ->asArray()
            ->one();
        return $this->render('/shopadminmod/admin/edit',['admin'=>$admin]);
    }

    public function actionToAdminRole(){
        $id = \Yii::$app->request->get('admin_id');
        $admin = Admin::find()->where(['admin_id'=>$id])->asArray()->one();
        $roleList = SysRole::find()->where(['status'=>1])->asArray()->all();
        return $this->render('/adminmod/admin/admin_role',['admin'=>$admin,'roleList'=>$roleList]);
    }


    /**
     * @return string 角色管理
     */
    public function actionToRoleList(){//跳转角色列表页面
        return $this->render('/shopadminmod/role/list');
    }
    public function actionToRoleAdd(){//跳转角色新增页面
        return $this->render('/shopadminmod/role/add');
    }
    public function actionToRoleEdit(){//跳转角色修改页面
        $id = \Yii::$app->request->get('role_id');
        $role = SysRole::find()->where(['role_id'=>$id])->asArray()->one();
        return $this->render('/shopadminmod/role/edit',['role'=>$role]);
    }
    public function actionToRoleAuth(){//跳转角色分配页面
        $id = \Yii::$app->request->get('role_id');
        $role = SysRole::find()->where(['role_id'=>$id])->asArray()->one();
        return $this->render('/shopadminmod/role/role_auth',['role_id'=>$id]);
    }

    /**
     * @return string权限菜单管理
     */
    public function actionToAuthList(){
        return $this->render('/shopadminmod/auth/list');
    }
    public function actionToAuthAdd(){//跳转权限新增页面
        return $this->render('/shopadminmod/auth/add');
    }
    public function actionToAuthEdit(){//跳转权限修改页面
        $id = \Yii::$app->request->get('auth_id');
        $auth = SysAuth::find()->where(['auth_id'=>$id])->asArray()->one();
        return $this->render('/shopadminmod/auth/edit',['auth'=>$auth]);
    }

}
