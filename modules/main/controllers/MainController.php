<?php

namespace app\modules\main\controllers;

use Yii;
use yii\web\Controller;
use app\modules\shopadmin\models\SysRole;
use app\modules\shopadmin\models\SysAuth;
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
//        $menus = AdminCommonfun::getAuthurls();
        //需要隐藏模块
//        $ret=AdminCommonfun::getSysConf('shop_hidden_module');
//        $closeMenu =explode(",",$ret["shop_hidden_module"]);
//        $authIds = SysAuth::find()->select("auth_id")->where(["in","auth_url",$closeMenu])->asArray()->all();
//        foreach ($authIds as $key => $value) {
//            $menus = AdminCommonfun::delCloseAuth($value["auth_id"], $menus);
//        }
//        $menus = AdminCommonfun::getChildrens(0, $menus);
        $menus = [
            [
                'auth_url' => '',
                'auth_name' => '网点管理',
                'auth_pid' => 0,
                'auth_id' => 481,
                'text' => '网点管理',
                'id' => 481,
                'childrens' => [
                    [
                        'auth_url' => '',
                        'auth_name' => '彩票机管理',
                        'auth_pid' => 0,
                        'auth_id' => 481,
                        'text' => '彩票机管理',
                        'id' => 481,
                        'childrens' => [
                            [
                                'auth_url' => '/usermod/views/to-machine-num-list',
                                'auth_name' => '终端号列表',
                                'auth_pid' => 0,
                                'auth_id' => 481,
                                'text' => '终端号列表',
                                'id' => 481,
                            ],
                            [
                                'auth_url' => '/usermod/views/to-machine-list',
                                'auth_name' => '彩票机列表',
                                'auth_pid' => 0,
                                'auth_id' => 481,
                                'text' => '彩票机列表',
                                'id' => 481,
                            ]
                        ]
                    ]
                ]
            ],
        ];
        return $this->render('/mainmod/main/index', ["menus" => $menus]);
    }

}