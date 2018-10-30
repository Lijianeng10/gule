<?php

namespace app\modules\core\filters;

use yii\base\ActionFilter;

// use app\modules\core\model\User;

class LoginFilter extends ActionFilter {

    public function beforeAction($action) {
        $session = \Yii::$app->session;
        if (empty($session["admin"])) {
            \Yii::$app->response->redirect('/mainmod/main/login');
        }
//        else {
//            \Yii::$app->response->redirect('/admin/admin/login');
//        }
        return parent::beforeAction($action);
    }

    public function afterAction($action, $result) {
        return parent::afterAction($action, $result);
    }

}

?>