<?php

namespace app\modules\admin\controllers;

use function Amp\onError;
use Yii;
use yii\web\Controller;
use yii\db\Query;
use yii\db\Exception;
use app\modules\admin\models\SysAuth;
use app\modules\admin\models\SysRole;
use app\modules\admin\models\Admin;
use app\modules\admin\models\SysAdminRole;
use app\modules\common\helpers\AdminCommonfun;
use app\modules\common\helpers\Constants;

/**
 * Default controller for the `admin` module
 */
class RoleController extends Controller {
    public $enableCsrfValidation = false;

    /**
     * 说明:获取所有角色列表
     * @author chenqiwei
     * @date 2018/9/3 下午4:54
     * @param
     * @return
     */
    public function actionGetRoleList(){
        $session = Yii::$app->session;
        $request =\Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort');
        $order = $request->post('order');
        $role_name = $request->post('role_name');
        $status = $request->post('status');
        $start_time = $request->post('start_time');
        $end_time = $request->post('end_time');
        $where = ['and'];
        if($role_name){
            $where[] = ['like','role_name',$role_name];
        }
        if($status === '0' || $status ==='1'){
            $where[] = ['status'=>$status];
        }
        if($start_time||$end_time){
            if($start_time){
                $where[] = ['>','create_time',$start_time];
            }
            if($end_time){
                $where[] = ['<','create_time',$end_time];
            }
        }
        if($session['admin']['admin_type'] !=0 ){
            //除了超级管理员  都只能看到自己和自己所创建的角色
            if (!in_array(Constants::ADMIN_ROLE,$session['admin']['role'])){
                $where[] = ["or",["admin_pid"=>$session["admin"]["admin_id"]],["role_id"=>$session['admin']["role"]]];
            }
        }

        $total =SysRole::find()->Where($where)->count();
        $offset = $rows*($page-1);
        $dataLists =SysRole::find()
            ->Where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()->all();
        return \Yii::datagridJson($dataLists,$total);
    }

    /**
     * 新增角色
     */
    public function actionAdd() {

        $param = Yii::$app->request->post();

        $session = Yii::$app->session;
        $at_time = 'y/m/d h:i:s';
        $role = new SysRole();
        $role->role_name = $param["role_name"];
        $role->admin_pid = $session["admin"]["admin_id"];
        $role->status = $param["status"];
        $role->create_time = date('Y-m-d H:i:s');
        if(!$role->save()){
//            print_r($role->errors);die;
            return $this->jsonError(100,'操作失败');
        }
        return $this->jsonResult(600,'操作成功',true);
    }


    /**
     * 说明:更新
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionUpdate(){
        $post =\Yii::$app->request->post();
        $role_name = $post['role_name'];
        $status = $post['status'];


        $role = SysRole::find()->where(['role_id'=>$post['role_id']])->one();
        if(!$role){
            return $this->jsonError(100,'没有该条数据，请重试');
        }

        $role->role_name = $role_name;
        $role->status = $status;

        if(!$role->save()){
//            print_r($role->errors);die;
            return $this->jsonError(100,'操作失败');
        }
        return $this->jsonResult(600,'操作成功',true);
    }


    /**
     * 删除角色,通过id
     * @return json
     */
    public function actionDelete() {
        if (!Yii::$app->request->isPost) {
            return $this->redirect('/admin/role/index');
        }
        $post = Yii::$app->request->post();
        if (!is_array($post['ids'])) {
            $id = array($post['ids']);
        } else {
            $id = $post['ids'];
        }
        $used = (new Query)->select('role_id')->from('sys_admin_role')->where(['in', 'role_id', $id])->all();
        if ($used != null) {
            return $this->jsonError(109,'该角色已分配用户,不可被删除');
        }
        $result = SysRole::deleteAll(['in', 'role_id', $id]);
        if ($result != false) {
            return $this->jsonResult(600,'操作成功',true);
        } else {
            return $this->jsonError(109,'操作失败');
        }
    }

    /**
     * 说明:修改状态
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionChangeStatus(){
        $parmas =\Yii::$app->request->post();
        $status = 1;
        if($parmas['status']==1){
            $status = 0;
        }
        SysRole::updateAll(['status'=>$status],['role_id'=>$parmas['id']]);
        return $this->jsonResult(600,'修改成功',true);
    }

    /**
     * 说明:获取该权限的所有管理员
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionGetRoleAdmins(){
        $parmas =\Yii::$app->request->get();
        $total = AdminRole::find()->where(['role_id'=>$parmas['id']])->count();
        $admins = AdminRole::find()
            ->select(['admin_name','admin.status'])
            ->leftJoin('admin','admin.admin_id = admin_role.admin_id')
            ->where(['role_id'=>$parmas['id']])->asArray()->all();
        return \Yii::datagridJson($admins,$total);
    }

    /**
     * @return string权限配置页面
     */
    public function actionAuths() {
        $session = Yii::$app->session;
        $get = Yii::$app->request->get();
        if (isset($get['role_id']) && $get['role_id'] != null) {
            $role_id = $get['role_id'];
//            array_key_exists(Constants::ADMIN_ROLE,$session["admin"]["role"])&&
            if ($session["admin"]["admin_type"]==0) { // 如果是内部用户、总管理员
                $authLists = (new Query())->select(['*','auth_id as id','auth_name as text'])->from('sys_auth')->where(["auth_status" => 1])->orderBy("auth_create_at asc")->all();
            } else {
                $authLists =AdminCommonfun::getAuthurls();
            }
            $openList=\Yii::$app->db->createCommand('SELECT auth_id FROM sys_auth where auth_id not in (select auth_pid from sys_auth);')
                ->queryAll();
            $openArr = [];
            foreach ($openList as $item) {
                $openArr[] = $item['auth_id'];
            }
            $rows = (new Query())->select('auth_id')->from('sys_role_auth')->where(['role_id' => $role_id])->all();
            $rows = array_column($rows, 'auth_id');
            foreach ($authLists as &$authList) {//是否有下级
                if(in_array($authList['id'],$openArr)){
                    $authList['state'] = 'open';
                    if (in_array($authList['auth_id'], $rows)) {
                        $authList['checked'] = 'true';
                    }
                }else{
                    $authList['state'] = 'open';

                }
            }
//            print_r($authList);die;
//            $tree = array();
//            $control = $this->actionTree($authLists, $tree);
//            $rows = (new Query())->select('auth_id')->from('sys_role_auth')->where(['role_id' => $role_id])->all();
//            $rows = array_column($rows, 'auth_id');
//            foreach ($control as &$val) {
//                if(!empty($val["children"])){
//
//                }
//                if (in_array($val['auth_id'], $rows)) {
//                    $val['checked'] = 'true';
//                }
//            }

//            $rows = (new Query())->select('auth_id')->from('sys_role_auth')->where(['role_id' => $role_id])->all();
//            $rows = array_column($rows, 'auth_id');
//            foreach ($authLists as &$val) {
//                if (in_array($val['auth_id'], $rows)) {
//                    $val['checked'] = 'true';
//                }
//            }
        }
        $tree = array();
        $control = $this->actionTree($authLists, $tree);
        return json_encode($control);

    }
    public function actionTree($info, $child, $pid = 0) {
        $child = array();
        if (!empty($info)) {
            foreach ($info as $k => &$v) {
                if ($v['auth_pid'] == $pid) {
                    $v['children'] = $this->actionTree($info, $child, $v['auth_id']);
                    $child[] = $v;
                    unset($info[$k]);
                }
            }
        }
        return $child;
    }

    /**
     * 权限配置
     */
    public function actionUpauth() {
        $post = $post = Yii::$app->request->post();
        $role_id = $post['role_id'];
        $role_auth = json_decode($post['authIds']);
        if (empty($role_id)) {
            return $this->jsonResult(109,'角色ID缺失，操作失败');
        }
        $rows = [];
        if ($role_auth != null) {
            foreach ($role_auth as $value) {
                $rows[] = [$role_id, $value];
            }
        }
        $db = Yii::$app->db;
        $transaction = $db->beginTransaction();
        try {
            //查找原先权限
            $detail = (new Query)->select('role_id')->from('sys_role_auth')->where(['role_id' => $role_id])->all();
            if (count($detail) > 0) {
                $deleteId = $db->createCommand()->delete('sys_role_auth', [ 'role_id' => $role_id])->execute();
                if ($deleteId == false) {
                    throw new Exception('操作删除已有数据失败！');
                }
            }
            $updateId = $db->createCommand()->batchInsert('sys_role_auth', [ 'role_id', 'auth_id'], $rows)->execute();
            if ($updateId === false) {
                throw new Exception('操作添加新数据失败！');
            }
            $transaction->commit();
            return $this->jsonResult(600,'操作成功');
        } catch (Exception $e) {
            $transaction->rollBack();
            return $this->jsonResult(109,$e->getMessage());
        }
    }
}
