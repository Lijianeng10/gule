<?php

namespace app\modules\product\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\Category;

class CategoryController extends Controller{

    public function actionGetCategoryList(){
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', '');
        $orderBy = $request->post('order', '');
        $name = $request->post('name');
        $p_id = $request->post('p_id');
        $status = $request->post('status');
        $offset = $rows * ($page - 1);
        $where = ['and'];
        if (!empty($name)) {
            $where[] = ['like', 'name', $name];
        }
        if ($status === '0' || $status === '1') {
            $where[] = ['status' => $status];
        }
        if ($p_id != '' && $p_id != '-1') {
            $where[] = ['or', ['category_id' => $p_id], ['p_id' => $p_id]];
        }

        $total = Category::find()->where($where)->count();
        $categoryData = Category::find()
            ->where($where)
            ->limit($rows)
            ->offset($offset)
            ->orderBy("{$sort} {$orderBy}")
            ->asArray()
            ->all();
        //查询上级权限名称
        $list = Category::find()->indexBy("category_id")->asArray()->all();
        foreach ($categoryData as &$dataList) {
            if ($dataList["p_id"] == 0) {
                $dataList["p_name"] = "顶级权限";
            } else {
                $dataList["p_name"] = $list[$dataList["p_id"]]["name"];
            }
        }
        return \Yii::datagridJson($categoryData, $total);
    }
    /**
     * @return string 获取树形数据
     */
    public function actionGetCategoryTree(){
        $request = \Yii::$app->request;
        $id = $request->get('id', 0);
        $type = $request->get('type', 2);//type 用来区分是列表搜索1 还是新增编辑2
        $authLists = Category::find()
            ->select(['category_id as id', 'name as text', 'p_id'])
            ->orderBy('sort asc')
            ->asArray()
            ->all();
        $openList = \Yii::$app->db->createCommand('SELECT category_id FROM category where category_id not in (select p_id from category);')
            ->queryAll();
        $openArr = [];
        foreach ($openList as $item) {
            $openArr[] = $item['category_id'];
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
                if ($v['p_id'] == $pid) {
                    $v['children'] = $this->actionTree($info, $child, $v['id']);
                    $child[] = $v;
                    unset($info[$k]);
                }
            }
        }
        return $child;
    }

    /**
     * 新增类别
     */
    public function actionAdd(){
        $param = Yii::$app->request->post();
        if (empty($param["name"])) {
            return $this->jsonError(109, '类别名成不能为空');
        }
        $pid = 0;
        if (!empty($param["p_id"])) {
            $pid = $param["p_id"];
        }
        $session = Yii::$app->session;
        $at_time = date("Y-m-d H:i:s");
        $category = new Category();
        $category->name = $param["name"];
        $category->status = $param["status"];
        $category->sort = $param["sort"];
        $category->p_id = $pid;
        $category->create_time = $at_time;
        if (!$category->save()) {
            return $this->jsonError(109, '操作失败');
        }
        return $this->jsonResult(600, '操作成功', true);
    }
    /**
     * 编辑保存类别
     */
    public function actionEdit()
    {
        $request = \Yii::$app->request;
        $categoryId = $request->post_nn('category_id');
        $name = $request->post_nn('name');
        $Pid = $request->post('p_id');
        $sort = $request->post('sort');
        $status = $request->post('status');
        $format = date('Y-m-d H:i:s');
        $data = [
            'name' => $name,
            'p_id' => $Pid,
            'sort' => $sort,
            'status' => $status,
        ];
        $res = Category::updateAll($data, ["category_id" => $categoryId]);
        if ($res) {
            return $this->jsonResult(600, '操作成功', '');
        }
        return $this->jsonError(109, '保存失败');
    }


    /**
     * 删除类别,通过id
     */
    public function actionDelete(){
        $post = Yii::$app->request->post();
        if (!$post['ids']) {
            return $this->jsonError(109, '参数缺失');
        }
        //判断权限有没有被分配
//        $used = (new Query)->select('role_auth_id')->from('sys_role_auth')->where(['auth_id' => $post['ids']])->one();
//        if (!empty($used)) {
//            return $this->jsonError(109, '权限已被分配给角色使用，不可删除');
//        }
        $result = Category::deleteAll(['category_id' => $post['ids']]);
        if ($result) {
            return $this->jsonResult(600, '操作成功', '');
        }
        return $this->jsonError(109, '操作失败');
    }
    /**
     * 说明:修改状态
     */
    public function actionChangeStatus()
    {
        $parmas = \Yii::$app->request->post();
        $status = 1;
        if ($parmas['status'] == 1) {
            $status = 0;
        }
        $res = Category::updateAll(['status' => $status], ['category_id' => $parmas['id']]);
        if (!$res) {
            return $this->jsonError(109, '修改失败');
        }
        return $this->jsonResult(600, '修改成功', true);
    }

}
