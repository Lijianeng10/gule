<?php

namespace app\modules\admin;

/**
 * admin module definition class
 */
class admin extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\admin\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
        return [
            "LoginFilter" => [
                "class" => 'app\modules\core\filters\LoginFilter'
            ],
//            "AuthFilter" => [
//                "class" => 'app\modules\core\filters\AuthFilter',
//                "except" => [
//                    /**
//                     * 后台管理用户
//                     */
//                    'admin/login',
//                    'admin/logout',
//                    'admin/get-admin-list',
//                    'admin/add',
//                    'admin/update',
//
//                    'auth/*',
//                    'role/*',
////                    'views/*'
//                    /**
//                     * 权限
//                     */
//                    'auth/add',
//                    'auth/edit-save',
//                ],
//            ],
        ];
    }

}
