<?php

namespace app\modules\main\controllers;

use app\modules\admin\models\Admin;
use app\modules\admin\models\SysAdminRole;
use app\modules\center\models\CenterAdmin;
use yii\web\Controller;
/**
 * Default controller for the `index` module
 */
class ViewsController extends Controller
{

    /**
     * 说明:跳转登录页面
     * @author chenqiwei
     * @date 2018/7/30 下午4:46
     */
    public function actionToLogin(){
        return $this->render('/main/login');
    }

    public function actionToTest(){
//        echo 1;die;
        return $this->render('/mainmod/main/test');
    }

    public function actionToUserinfo1(){
        $admin = [];
        $adminId = \Yii::$app->session['admin']['admin_id'];
        $adminModel = new Admin();
        //所属角色
        $admin['roles'] = $adminModel->getMyRoles($adminId);
        //所属中心
        $admin['centers'] = $adminModel->getMyCenters($adminId);
        return $this->render('/mainmod/main/user_info1',['adminInfo1'=>$admin]);
    }

    public function actionToUserinfo2(){
        $data = [];
        return $this->render('/mainmod/main/user_info2',['adminInfo2'=>$data]);
    }

    public function actionToUserinfo3(){
        $data = [];

        return $this->render('/mainmod/main/user_info3',['adminInfo2'=>$data]);
    }

}