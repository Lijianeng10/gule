<?php

namespace app\modules\admin\controllers;

use app\modules\admin\models\Admin;
use app\modules\admin\models\SysAdminRole;
use Yii;
use yii\web\Controller;
use app\modules\admin\models\SysAdmin;
use yii\filters\VerbFilter;
use app\modules\admin\models\SysAuth;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use app\modules\admin\models\SysRole;

/**
 * Admin controller for the `admin` module
 */
class ViewsController extends Controller {

    /**
     * @return string 管理员管理
     */
    public function actionToAdminList(){
        return $this->render('/adminmod/admin/list');

    }
    public function actionToAdminAdd(){
        $role = SysRole::find()->where(["status"=>1])->asArray()->all();
        return $this->render('/adminmod/admin/add',["role"=>$role]);
    }
    public function actionToAdminEdit(){
        $id = \Yii::$app->request->get('id');
        $admin = Admin::find()
            ->select(["admin.*"])
            ->leftJoin("sys_admin_role as sr","sr.admin_id = admin.admin_id")
            ->where(['admin.admin_id'=>$id])
            ->asArray()
            ->one();
        return $this->render('/adminmod/admin/edit',['admin'=>$admin]);
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
        return $this->render('/adminmod/role/list');
    }
    public function actionToRoleAdd(){//跳转角色新增页面
        return $this->render('/adminmod/role/add');
    }
    public function actionToRoleEdit(){//跳转角色修改页面
        $id = \Yii::$app->request->get('role_id');
        $role = SysRole::find()->where(['role_id'=>$id])->asArray()->one();
        return $this->render('/adminmod/role/edit',['role'=>$role]);
    }
    public function actionToRoleAuth(){//跳转角色分配页面
        $id = \Yii::$app->request->get('role_id');
        $role = SysRole::find()->where(['role_id'=>$id])->asArray()->one();
        return $this->render('/adminmod/role/role_auth',['role_id'=>$id]);
    }

    /**
     * @return string权限菜单管理
     */
    public function actionToAuthList(){
        return $this->render('/adminmod/auth/list');
    }
    public function actionToAuthAdd(){//跳转权限新增页面
        return $this->render('/adminmod/auth/add');
    }
    public function actionToAuthEdit(){//跳转权限修改页面
        $id = \Yii::$app->request->get('auth_id');
        $auth = SysAuth::find()->where(['auth_id'=>$id])->asArray()->one();
        return $this->render('/adminmod/auth/edit',['auth'=>$auth]);
    }

}
