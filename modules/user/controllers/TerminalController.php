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
use app\modules\common\models\Terminal;

class TerminalController extends Controller {
    /**
     * 获取终端号列表
     */
    public function actionGetTerminalList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'terminal_num');
        $order = $request->post('order');
        $terminal_num = $request->post('terminal_num', '');
        $status = $request->post('status', '');
        $use_status = $request->post('use_status', '');
        $where = ['and'];
        if ($terminal_num) {
            $where[] = ['like', 'terminal_num', $terminal_num];
        }
        if ($status != '') {
            $where[] = ['status' => $status];
        }
        if ($use_status != '') {
            $where[] = ['use_status' => $use_status];
        }
        $total = Terminal::find()->where($where)->count();
        $offset = $rows * ($page - 1);
        $field = ['terminal.*','m.machine_code'];
        $lists = Terminal::find()
            ->select($field)
            ->leftJoin('machine as m','m.terminal_num = terminal.terminal_num')
            ->where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()
            ->all();
        return \Yii::datagridJson($lists, $total);
    }
    /**
     * 新增终端号
     */
    public function actionAddTerminalNum(){
        $post = \yii::$app->request->post();
        $nums = $post['nums'];
        if(empty($nums)){
            return $this->jsonError(109,'参数有误，请检查！');
        }
        $dataAry = [];
        for($i=0;$i<$nums;$i++){
            $terminalNum =$this->getNo();
            $qrcode = \Yii::$app->params['urlIp'].'/store/store/to-jump-page?terminalNum='.$terminalNum;
            $dataAry[] = [$terminalNum,$qrcode,date('Y-m-d H:i:s')];
        }
        $ret = Yii::$app->db->createCommand()->batchInsert('terminal', ['terminal_num','qrcode_url','create_time'], $dataAry)->execute();
        if($ret){
            return $this->jsonError(600,'操作成功！');
        }else{
            return $this->jsonError(109,'操作失败，请重试！');
        }

    }
    /**
     * 生成唯一用户编号
     */
    public function getNo(){
        $No= \Yii::redisIncr('terminal-no');
        $no = "PS" . $No;
        return $no;
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