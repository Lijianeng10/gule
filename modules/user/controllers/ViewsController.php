<?php

namespace app\modules\user\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;


class ViewsController extends Controller {

    /**
     * @return string 会员列表
     */
    public function actionToUserList(){
        return $this->render('/usermod/user/list',[]);
    }
}
