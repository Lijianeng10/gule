<?php

namespace app\modules\admin\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\modules\admin\models\Admin;
use app\modules\admin\models\SysAdminRole;
use app\modules\admin\models\SysAuth;
use app\modules\admin\models\SysRole;
use app\modules\common\helpers\AdminCommonfun;
use app\modules\common\helpers\Constants;

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
        $admin = Admin::find()->where(['admin_name' => $admin_name, 'password' => md5($admin_name.$admin_pwd)])->asArray()->one();
        if (empty($admin)) {
            return $this->jsonError(109,"请输入正确的账号密码");
        } elseif ($admin['status'] != 1) {
            return $this->jsonError(109,"登录失败，该用户被禁用！");
        } else {
            unset($admin['admin_pwd']);
        }
        $admin["authUrls"] = AdminCommonfun::getNowAuthurls($admin["admin_id"]);
        $nowRole = SysAdminRole::find()
            ->select(["role_id"])
            ->where(["admin_id" => $admin["admin_id"]])
            ->indexBy('role_id')
            ->asArray()
            ->all();
        $admin["role"] = $nowRole;
        \Yii::$app->session['admin'] = $admin;

        $admin_new =Admin::findOne($admin['admin_id']);
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
        $sort = $request->post('sort', 'admin.create_time');
        $order = $request->post('order','desc');
        $admin_name = $request->post('admin_name');
        $admin_nickname = $request->post('admin_nickname');
        $admin_tel = $request->post('admin_tel');
        $admin_type = $request->post('admin_type');
        $status = $request->post('status');
        $start_time = $request->post('start_time');
        $end_time = $request->post('end_time');
        $where = ['and'];
        if ($admin_name) {
            $where[] = ['like', 'admin.admin_name', $admin_name];
        }
        if ($admin_nickname) {
            $where[] = ['like', 'admin.admin_nickname', $admin_nickname];
        }
        if ($admin_tel) {
            $where[] = ['like', 'admin.admin_tel', $admin_tel];
        }
        if ($admin_type === '0' || $admin_type === '1') {
            $where[] = ['admin.type' => $admin_type];
        }
        if ($status === '0' || $status === '1') {
            $where[] = ['admin.status' => $status];
        }
        if ($start_time || $end_time) {
            if ($start_time) {
                $where[] = ['>=', 'admin.create_time', $start_time];
            }
            if ($end_time) {
                $where[] = ['<=', 'admin.create_time', $end_time];
            }
        }
		
		//除了系统管理员  都只能看到自己和自己所创建的用户
		if (!array_key_exists(Constants::ADMIN_ROLE,$session['admin']["role"])) {
			$where[] = ["or", ["admin.admin_id" => $session["admin"]["admin_id"]], ["admin.admin_pid" => $session["admin"]["admin_id"]]];
		}
		
        $total = Admin::find()->Where($where)->count();
        $offset = $rows * ($page - 1);
        $sysLists = Admin::find()
                        ->select(['admin.admin_id as id', 'admin.*', 'sys_role.role_name'])
                        ->leftJoin('sys_admin_role', 'sys_admin_role.admin_id = admin.admin_id')
                        ->leftJoin('sys_role', 'sys_role.role_id = sys_admin_role.role_id')
                        ->Where($where)
                        ->offset($offset)
                        ->limit($rows)
                        ->orderBy("{$sort}  {$order}")
                        ->asArray()->all();
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
		
		$admin_count = Admin::find()->Where(['admin_name' => trim($post['admin_name_new'])])->count();//判断该用户是否已存在
		if($admin_count > 0){
			return $this->jsonError(109, '该用户已存在，不能重复添加！');
		}
		
        $admin = new Admin();
		$admin->admin_name = $post['admin_name_new'];
		$admin->password = md5($post['admin_name_new'].$post['password']);
		$admin->nickname = $post['nickname'];
		$admin->admin_tel = $post['admin_tel'];
		
		if($session['admin']['type'] == 1){   //判断登陆账号是否为渠道账户
			$admin->type = 1;
		}else{
			$admin->type = $post['type'];
		}
		
		$admin->status = $post['status'];
        $admin->create_time = date('Y-m-d H:i:s');
        $admin->admin_pid = $session["admin"]["admin_id"];
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
		$session = \Yii::$app->session;
        $post = \Yii::$app->request->post();
        //$admin_name = trim($post['admin_name_new']);
		$admin_name_old = trim($post['admin_name_old']);
        $nickname = $post['nickname'];
        $admin_pwd = $post['admin_pwd'];
        $admin_tel = $post['admin_tel'];
		
		/*if($admin_name_old != $admin_name){
			$admin_count = Admin::find()->Where(['admin_name' => $admin_name])->count();//判断该用户是否已存在
			if($admin_count > 0){
				return $this->jsonError(109, '该用户已存在，不能重复添加！');
			}
		}*/
		
        $status = $post['status'];
        $admin = Admin::find()->where(['admin_id' => $post['admin_id']])->one();
        if (!$admin) {
            return $this->jsonError(100, '没有该条数据，请重试');
        }
        //$admin->admin_name = $admin_name;
        $admin->nickname = $nickname;
        if ($admin_pwd != '********') {
            $admin->password = md5($admin_name_old.$admin_pwd);
        }
        $admin->admin_tel = $admin_tel;
		
		if($session['admin']['type'] == 0){   //判断登陆账号是否为渠道账户
			$admin_type = $post['admin_type'];
			$admin->type = $admin_type;
		}
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
		if($ids == Constants::ADMIN_ROLE){
			return $this->jsonResult(109, '超级管理员不能删除');
		}
        $idsArr = explode(',', $ids);
        Admin::deleteAll(['in', 'admin_id', $idsArr]);
		
		Yii::$app->db->createCommand()->delete('sys_admin_role', ['admin_id' => $ids])->execute();

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
		
		if($status == 0){
			if($parmas['id'] == Constants::ADMIN_ROLE){
				return $this->jsonResult(109, '不能禁用超级管理员');
			}
		}
		
        Admin::updateAll(['status' => $status], ['admin_id' => $parmas['id']]);
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
