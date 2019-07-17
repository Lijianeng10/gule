<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use app\modules\admin\models\SysRole;
use app\modules\admin\models\SysAuth;
use app\modules\common\helpers\AdminCommonfun;

/**
 * Default controller for the `index` module
 */
class MainController extends Controller
{

    public function actionIndex()
    {
        $session = \Yii::$app->session;
        $admin = $session['admin'];
        if (!$admin) {
            return $this->render('/mainmod/main/login');
        }
        $menus = AdminCommonfun::getAuthurls();
        $menus = AdminCommonfun::getChildrens(0, $menus);
        return $this->render('/mainmod/main/index', ["menus" => $menus]);
    }

}