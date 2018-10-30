<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\shopadmin\models\SysAdminRole;
use app\modules\shopadmin\models\SysAuth;
use app\modules\shopadmin\models\SysRole;
use app\modules\common\helpers\AdminCommonfun;
use app\modules\common\helpers\Constants;
use app\modules\common\models\ChannelAdmin;

/**
 * Admin controller for the `admin` module
 */
class AdminController extends Controller {

    /**
     * Renders the index view for the module
     * @return string
     */
//    public $enableCsrfValidation = false;

    /**
     * 说明:登录
     * @author chenqiwei
     * @date 2018/8/7 下午2:08
     * @param
     * @return
     */
    public function actionLogin() {
        Yii::$app->response->statusCode = 200;
        $request = \Yii::$app->request;
        $admin_name = $request->post_nn('admin_name');
        $admin_pwd = $request->post_nn('admin_pwd');
        $admin = ChannelAdmin::find()->where(['admin_name' => $admin_name, 'password' => md5($admin_name.$admin_pwd)])->asArray()->one();
        if (empty($admin)) {
            return $this->jsonError(109,"请输入正确的账号密码");
        } elseif ($admin['status'] != 1) {
            return $this->jsonError(109,"登录失败，该用户被禁用！");
        } else {
            unset($admin['admin_pwd']);
        }

//        $admin["authUrls"] = AdminCommonfun::getNowAuthurls($admin["admin_id"]);
//        $nowRole = SysAdminRole::find()
//                ->select(["role_id"])
//                ->where(["admin_id" => $admin["admin_id"]])
//                ->indexBy('role_id')
//                ->asArray()
//                ->all();
//        $admin["role"] = $nowRole;
        \Yii::$app->session['admin'] = $admin;

        $admin_new =ChannelAdmin::findOne($admin['admin_id']);
        $admin_new->last_login = date('Y-m-d H:i:s');
        $admin_new->save();
        return $this->jsonResult(600,"登录成功",true);
    }

    /**
     * 说明:登出
     * @author chenqiwei
     * @date 2018/8/7 下午2:08
     * @param
     * @return
     */
    public function actionLogout() {
        unset(\Yii::$app->session['admin']);
        return $this->redirect('/');
    }

//    public function behaviors() {
//        parent::behaviors();
//        return [
//            "verbs" => [
//                "class" => VerbFilter::className(),
//                "actions" => [
//                    "login" => ["get", "post"],
//                    'editadmin' => ['get']
//                ]
//            ]
//        ];
//    }

    public function actionGetAdminList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'created_at');
        $order = $request->post('order');
        $admin_name = $request->post('admin_name');
        $admin_nickname = $request->post('nickname');
        $admin_tel = $request->post('admin_tel');
        $admin_type = $request->post('admin_type');
        $center_id = $request->post('center_id');
        $status = $request->post('status');
        $start_time = $request->post('start_time');
        $end_time = $request->post('end_time');
        $where = ['and'];
        if ($admin_name) {
            $where[] = ['like', 'sys_admin.admin_name', $admin_name];
        }
        if ($admin_nickname) {
            $where[] = ['like', 'sys_admin.nickname', $admin_nickname];
        }
        if ($admin_tel) {
            $where[] = ['like', 'sys_admin.admin_tel', $admin_tel];
        }
        if ($admin_type === '0' || $admin_type === '1') {
            $where[] = ['sys_admin.type' => $admin_type];
        }
        if ($status === '0' || $status === '1') {
            $where[] = ['sys_admin.status' => $status];
        }
        if ($start_time || $end_time) {
            if ($start_time) {
                $where[] = ['>', 'sys_admin.created_at', $start_time];
            }
            if ($end_time) {
                $where[] = ['<', 'sys_admin.created_at', $end_time];
            }
        }
        if (!array_key_exists(Constants::ADMIN_ROLE,$session['admin']["role"])) {
            $where[] = ["or", ["sys_admin.admin_id" => $session["admin"]["admin_id"]], ["sys_admin.admin_pid" => $session["admin"]["admin_id"]]];
        }
//        if($session['admin']['type'] !=0 ){
//
//        }
        //除了系统管理员  都只能看到自己和自己所创建的角色
        $total = SysAdmin::find()->where($where)->count();
        $offset = $rows * ($page - 1);
        $sysLists = SysAdmin::find()
                        ->select(['sys_admin.*','sys_admin.admin_id as id'])
                        ->where($where)
                        ->limit($rows)
                        ->offset($offset)
                        ->orderBy("{$sort}  {$order}")
                        ->asArray()->all();
        $idAry=[];
        foreach ($sysLists as $k=>$v){
            $idAry[] =$v['admin_id'];
        }
        $roleAry = SysRole::find()->select(['sys_admin_role.admin_id','role_name'])->leftJoin('sys_admin_role','sys_role.role_id = sys_admin_role.role_id')
            ->where(['in','sys_admin_role.admin_id',$idAry])
            ->asArray()
            ->all();
        foreach ($sysLists as $k=>&$v){
            foreach ($roleAry as $key =>$val){
                if($v['admin_id']==$val['admin_id']){
                    $v['role_name'][] = $val['role_name'];
                }
            }
        }
        return \Yii::datagridJson($sysLists, $total);
    }

    /**
     * 说明:
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionAdd() {
        $session = \Yii::$app->session;
        $post = \Yii::$app->request->post();
        $admin = new SysAdmin();
        foreach ($admin->attributes as $k => $v) {
            if (isset($post[$k])) {
                if ($k == 'password') {
                    $admin->$k = md5($post["admin_name"].$post["password"]);
                } elseif ($k != 'admin_role') {
                    $admin->$k = $post[$k];
                }
            }
        }
        $admin->created_at = date('Y-m-d H:i:s');
        $admin->admin_pid = $session["admin"]["admin_id"];
        $admin->updated_at = date('Y-m-d H:i:s');
        if (!$admin->save()) {
            return $this->jsonError(100, '操作失败');
        }

        //新增角色表
        $adminId = $admin->attributes['admin_id'];
        $roleAry = [];
        foreach ($post["admin_role"] as $value) {
            $roleAry[] = [$adminId, $value];
        }
        $res = Yii::$app->db->createCommand()->batchInsert('sys_admin_role', ['admin_id', 'role_id'], $roleAry)->execute();
        return $this->jsonResult(600, '操作成功', true);
    }

    /**
     * 说明:更新
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionUpdate() {
        $post = \Yii::$app->request->post();
        $admin_name = trim($post['admin_name']);
        $nickname = $post['nickname'];
        $password = $post['password'];
        $admin_tel = $post['admin_tel'];
        $type = $post['type'];
        $status = $post['status'];
        $admin = SysAdmin::find()->where(['admin_id' => $post['admin_id']])->one();
        if (!$admin) {
            return $this->jsonError(100, '没有该条数据，请重试');
        }
        $admin->admin_name = $admin_name;
        $admin->nickname = $nickname;
        if ($password != '********') {
            $admin->password = md5($admin_name.$password);
        }
        $admin->admin_tel = $admin_tel;
        $admin->type = $type;
        $admin->status = $status;
        if (!$admin->save()) {
            return $this->jsonError(100, '操作失败');
        }
//        修改用户角色关系
        Yii::$app->db->createCommand()->delete('sys_admin_role', ['admin_id' => $post['admin_id']])->execute();
        $roleAry = [];
        foreach ($post["admin_role"] as $value) {
            $roleAry[] = [$post['admin_id'], $value];
        }
        $res = Yii::$app->db->createCommand()->batchInsert('sys_admin_role', ['admin_id', 'role_id'], $roleAry)->execute();
        return $this->jsonResult(600, '操作成功', true);
    }

    /**
     * 说明:
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionDelete() {
        $ids = \Yii::$app->request->post()['ids'];
        $idsArr = explode(',', $ids);
        SysAdmin::deleteAll(['in', 'admin_id', $idsArr]);

        return $this->jsonResult(600, '操作成功', true);
    }

    /**
     * 说明:修改状态
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 0;
        }
        SysAdmin::updateAll(['status' => $status], ['admin_id' => $parmas['id']]);
        return $this->jsonResult(600, '修改成功', true);
    }

    /**
     * 获取角色列表
     */
    public function actionGetRoleList() {
        $request = \Yii::$app->request;
        $session = Yii::$app->session;
        $adminId = $session['admin']['admin_id'];
        $id = $request->get('id', '');
        $roleModel = new SysRole();
        $roleLists = $roleModel->getMyRoleList($adminId);
        if (!empty($id)) {
            $role = SysAdminRole::find()
                    ->select(["sr.*"])
                    ->leftJoin("sys_role as sr", "sr.role_id = sys_admin_role.role_id")
                    ->where(["sys_admin_role.admin_id" => $id])
                    ->asArray()
                    ->all();
            $chooseArr = [];
            foreach ($role as $item) {
                $chooseArr[] = $item['role_id'];
            }
            foreach ($roleLists as &$roleList) {//是否能被选中
                if (in_array($roleList['id'], $chooseArr)) {
                    $roleList['selected'] = true;
                }
            }
        }
        return json_encode($roleLists);
    }

}
