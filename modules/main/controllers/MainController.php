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
        //需要隐藏模块
        /*$ret=AdminCommonfun::getSysConf('shop_hidden_module');
        $closeMenu =explode(",",$ret["shop_hidden_module"]);
        $authIds = SysAuth::find()->select("auth_id")->where(["in","auth_url",$closeMenu])->asArray()->all();
        foreach ($authIds as $key => $value) {
            $menus = AdminCommonfun::delCloseAuth($value["auth_id"], $menus);
        }*/
        $menus = AdminCommonfun::getChildrens(0, $menus);
        return $this->render('/mainmod/main/index', ["menus" => $menus]);
    }

}