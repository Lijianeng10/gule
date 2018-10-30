<?php

namespace app\modules\shopadmin\controllers;

use app\modules\shopadmin\models\AdminRole;
use app\modules\common\helpers\AdminCommonfun;
use Yii;
use yii\web\Controller;
use app\modules\shopadmin\models\SysAuth;
use app\modules\shopadmin\models\SysRole;
use app\modules\shopadmin\models\SysAdmin;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\db\Exception;

/**
 * Auth controller for the `auth` module
 */
class AuthController extends Controller
{
    public function actionGetAuthList()
    {
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort');
        $order = $request->post('order');
        $auth_name = $request->post('auth_name');
        $auth_pid = $request->post('auth_pid');
        $status = $request->post('status');
        $auth_type = $request->post('auth_type');
        $where = ['and'];
        if ($auth_name) {
            $where[] = ['like', 'auth_name', $auth_name];
        }
        if ($status === '0' || $status === '1') {
            $where[] = ['auth_status' => $status];
        }
        if ($auth_pid != '' && $auth_pid != '-1') {
            $where[] = ['or', ['auth_id' => $auth_pid], ['auth_pid' => $auth_pid]];
        }
        if ($auth_type) {
            $where[] = ['auth_type'=>$auth_type];
        }
        $total = SysAuth::find()->Where($where)->count();
        $offset = $rows * ($page - 1);
        $dataLists = SysAuth::find()
            ->Where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()->all();
        //查询上级权限名称
        $list = SysAuth::find()->indexBy("auth_id")->asArray()->all();
        foreach ($dataLists as &$dataList) {
            if ($dataList["auth_pid"] == 0) {
                $dataList["auth_pname"] = "顶级权限";
            } else {
                $dataList["auth_pname"] = $list[$dataList["auth_pid"]]["auth_name"];
            }
        }
        return \Yii::datagridJson($dataLists, $total);
    }

    /**
     * 新增权限
     */
    public function actionAdd()
    {
        $param = Yii::$app->request->post();
        if (empty($param["auth_name"])) {
            return $this->jsonError(109, '权限名不能为空');
        }
        $pid = 0;
        if (!empty($param["auth_pid"])) {
            $pid = $param["auth_pid"];
        }
        $session = Yii::$app->session;
        $at_time = date("Y-m-d H:i:s");
        $auth = new SysAuth();
        $auth->auth_name = $param["auth_name"];
        if (!empty($param["auth_url"])) {
            $auth->auth_url = $param["auth_url"];
        }
        $auth->auth_status = $param["auth_status"];
        $auth->auth_pid = $pid;
        $auth->auth_create_at = $at_time;
        $auth->auth_update_at = $at_time;
        $auth->auth_type = $param["auth_type"];
        if (!$auth->save()) {
            return $this->jsonError(109, '操作失败');
        }
        return $this->jsonResult(600, '操作成功', true);
    }

    /**
     * 编辑保存权限
     */
    public function actionEditSave()
    {
        $request = \Yii::$app->request;
        $authId = $request->post_nn('auth_id');
        $authName = $request->post_nn('auth_name');
        $authUrl = $request->post('auth_url');
        $authSort = $request->post('auth_sort');
        $authPid = $request->post('auth_pid');
        $authStatus = $request->post('auth_status');
        $authType = $request->post('auth_type');
        $format = date('Y-m-d H:i:s');
        $data = [
            'auth_name' => $authName,
            'auth_url' => $authUrl,
            'auth_sort' => $authSort,
            'auth_pid' => $authPid,
            'auth_status' => $authStatus,
            'auth_type' => $authType,
            'auth_update_at' => $format,
        ];
        $res = SysAuth::updateAll($data, ["auth_id" => $authId]);
        if ($res) {
            return $this->jsonResult(600, '操作成功', '');
        }
        return $this->jsonError(109, '保存失败');
    }


    /**
     * 删除权限,通过id
     * @return json
     */
    public function actionDelete()
    {

        $post = Yii::$app->request->post();
        if (!$post['ids']) {
            return $this->jsonError(109, '参数缺失');
        }
        //判断权限有没有被分配
        $used = (new Query)->select('role_auth_id')->from('sys_role_auth')->where(['auth_id' => $post['ids']])->one();
        if (!empty($used)) {
            return $this->jsonError(109, '权限已被分配给角色使用，不可删除');
        }
        $result = SysAuth::deleteAll(['auth_id' => $post['ids']]);
        if ($result) {
            return $this->jsonResult(600, '操作成功', '');
        }
        return $this->jsonError(109, '操作失败');
    }

    /**
     * 说明:修改状态
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionChangeStatus()
    {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 0;
        }
        $res = SysAuth::updateAll(['auth_status' => $status], ['auth_id' => $parmas['id']]);
        if (!$res) {
            return $this->jsonError(109, '修改失败');
        }
        return $this->jsonResult(600, '修改成功', true);
    }

    /**
     * 说明:获取该权限的所有管理员
     * @author chenqiwei
     * @date 2018/8/10 上午9:19
     * @param
     * @return
     */
    public function actionGetRoleAdmins()
    {
        $parmas = \Yii::$app->request->get();
        $total = AdminRole::find()->where(['role_id' => $parmas['id']])->count();
        $admins = AdminRole::find()
            ->select(['admin_name', 'admin.status'])
            ->leftJoin('admin', 'admin.admin_id = admin_role.admin_id')
            ->where(['role_id' => $parmas['id']])->asArray()->all();
        return \Yii::datagridJson($admins, $total);
    }

    /**
     * @return string 获取树形数据
     */
    public function actionGetAuthTree()
    {
        $request = \Yii::$app->request;
        $id = $request->get('id', 0);
        $type = $request->get('type', 2);//type 用来区分是列表搜索1 还是新增编辑2
        $authLists = SysAuth::find()
            ->select(['auth_id as id', 'auth_name as text', 'auth_pid'])
            //->where(['auth_pid' => $id])
            ->orderBy('auth_sort desc')
            ->asArray()
            ->all();
        $openList = \Yii::$app->db->createCommand('SELECT auth_id FROM sys_auth where auth_id not in (select auth_pid from sys_auth);')
            ->queryAll();
        $openArr = [];
        foreach ($openList as $item) {
            $openArr[] = $item['auth_id'];
        }

        foreach ($authLists as &$authList) {//是否有下级
            if (in_array($authList['id'], $openArr)) {
                $authList['state'] = 'open';
            } else {
                $authList['state'] = 'closed';
            }
        }
        $auth = [];
        if ($id == 0) {
            if($type==1){
                $auth[0] = [
                    'id' => '-1',
                    'text' => '所有权限',
					'auth_pid' => '0',
                    'state' => 'open',
                ];
                $auth[1] = [
                    'id' => '0',
                    'text' => '顶级权限',
					'auth_pid' => '0',
                    'state' => 'open',
                ];
            }elseif($type==2){
                $auth[0] = [
                    'id' => '0',
                    'text' => '顶级权限',
					'auth_pid' => '0',
                    'state' => 'open',
                ];
            }

        }
		$tree = array();
        $authLists = $this->actionTree($authLists, $tree);
        $authLists = array_merge($auth, $authLists);
        return json_encode($authLists);
    }
	
	public function actionTree($info, $child, $pid = 0) {
        $child = array();
        if (!empty($info)) {
            foreach ($info as $k => &$v) {
                if ($v['auth_pid'] == $pid) {
                    $v['children'] = $this->actionTree($info, $child, $v['id']);
                    $child[] = $v;
                    unset($info[$k]);
                }
            }
        }
        return $child;
    }

    public function actionGetMyAuths(){
//        $admin["authUrls"] =
        $adminId = \Yii::$app->session['admin']['admin_id'];
        $auths = AdminCommonfun::getNowAuthurls($adminId);
        $ret = [];
        foreach ($auths as $auth) {
            if(!empty($auth['auth_url'])){
                $ret[] = $auth['auth_url'];
            }
        }
        return json_encode($ret);
    }

}
