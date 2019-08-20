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
use app\modules\common\models\User;

class UserController extends Controller {
    /**
     * 获取会员列表
     */
    public function actionGetUserList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'user.create_time');
        $order = $request->post('order','desc');
        $userInfo = $request->post('userInfo', '');
        $status = $request->post('status', '');
        $where = ['and'];
        if ($userInfo != '') {
            $where[] = ['or',['like', 'user.cust_no', $userInfo],['like', 'user.nickname', $userInfo],['like', 'user.phone', $userInfo]];
        }
        if ($status != '') {
            $where[] = ['user.status' => $status];
        }
        $total = User::find()
            ->where($where)
            ->count();
        $offset = $rows * ($page - 1);
        $field = ['user.*'];
        $lists = User::find()
            ->select($field)
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
            $status = 2;
        }
        User::updateAll(['status' => $status], ['user_id' => $parmas['id']]);
        return $this->jsonResult(600, '修改成功', true);
    }
}