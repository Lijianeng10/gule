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
     * 获取机器列表
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
        $onlineStatus = $request->post('online_status', '');
        $where = ['and'];
        if ($terminal_num) {
            $where[] = ['like', 'machine.terminal_num', $terminal_num];
        }
        if ($status != '') {
            $where[] = ['machine.status' => $status];
        }
        if ($onlineStatus != '') {
            $where[] = ['machine.online_status' => $onlineStatus];
        }
		//判断登陆账号是否为渠道账户
		if($session['admin']['type'] == 1){
			$where[] = ['machine.channel_no' => $session['admin']['admin_name']];
		}
		
        $total = Machine::find()->leftJoin('lottery as l','l.lottery_id = machine.lottery_id')->leftJoin('store as s','s.cust_no = machine.cust_no')->where($where)->count();
        $offset = $rows * ($page - 1);
        $lists = Machine::find()
            ->select(['machine.*','l.lottery_name','s.store_name','s.user_tel'])
            ->leftJoin('lottery as l','l.lottery_id = machine.lottery_id')
            ->leftJoin('store as s','s.cust_no = machine.cust_no')
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