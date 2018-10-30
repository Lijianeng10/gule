<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/08/29
 * Time: 11:15:07
 */
namespace app\modules\user\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Machine;

class MachineController extends Controller {
    /**
     * 获取终端号列表
     */
    public function actionGetMachineList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'create_time');
        $order = $request->post('order');
        $terminal_num = $request->post('terminal_num', '');
        $status = $request->post('status', '');
        $where = ['and'];
        if ($terminal_num) {
            $where[] = ['like', 'terminal_num', $terminal_num];
        }
        if ($status != '') {
            $where[] = ['status' => $status];
        }
        $total = Machine::find()->where($where)->count();
        $offset = $rows * ($page - 1);
        $lists = Machine::find()
            ->where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()
            ->all();
        return \Yii::datagridJson($lists, $total);
    }
    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 0;
        }
        Terminal::updateAll(['status' => $status], ['terminal_id' => $parmas['id']]);
        return $this->jsonResult(600, '修改成功', true);
    }
}