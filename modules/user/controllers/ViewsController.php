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
    /**
     * 终端号列表
     */
    public function actionToTerminalList(){
        return $this->render('/usermod/terminal/list');
    }
    /**
     * 新增终端号
     */
    public function actionToTerminalAdd(){
        return $this->render('/usermod/terminal/add');
    }
    /**
     * 机器列表
     */
    public function actionToMachineList(){
        return $this->render('/usermod/machine/list');
    }
    /**
     * 彩种列表
     */
    public function actionToLotteryList(){
        return $this->render('/usermod/lottery/list');
    }
    public function actionToLotteryAdd(){
        return $this->render('/usermod/lottery/add');
    }
}
