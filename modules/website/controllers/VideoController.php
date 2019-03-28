<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/08/29
 * Time: 11:15:07
 */
namespace app\modules\website\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\common\models\Video;
use app\modules\tools\helpers\UploadPic;

class VideoController extends Controller {

    public function actionGetVideoList() {
        $session = \Yii::$app->session;
        $request = \Yii::$app->request;
        $page = $request->post('page');
        $rows = $request->post('rows');
        $sort = $request->post('sort', 'create_time');
        $order = $request->post('order','desc');
        $picName = $request->post('pic_name', '');
        $status = $request->post('status', '');
        $where = ['and'];
//        if ($picName) {
//            $where[] = ['like', 'pic_name', $picName];
//        }
//        if ($status != '') {
//            $where[] = ['status' => $status];
//        }
        if($session['admin']['admin_name']!='jn'){
            $where[] = ['type' => 1];
        }
        $total = Video::find()->where($where)->count();
        $offset = $rows * ($page - 1);
        $lists = Video::find()
            ->where($where)
            ->offset($offset)
            ->limit($rows)
            ->orderBy("{$sort}  {$order}")
            ->asArray()
            ->all();
        return \Yii::datagridJson($lists, $total);
    }
    /**
     * 新增动态广告
     */
    public function actionAddVideo() {
            $post = Yii::$app->request->post();
            $type = $post['type'];
            $session = Yii::$app->session;
            $timer = date('Y-m-d H:i:s');
            if (isset($_FILES['upfile'])) {
                $file = $_FILES['upfile'];
                $saveDir = '/video/';
                $str = substr(strrchr($file['name'], '.'), 1);
                $name = rand(0,99).'.' . $str;
                $pathJson = UploadPic::pic_host_upload($file, $saveDir,$name);
                $path = json_decode($pathJson, true);
                if ($path['code'] != 600) {
                    return $this->jsonResult($path['code'], $path['msg']);
                }
                $videoUrl = $path['result']['ret_path'];
            } else {
                return $this->jsonResult(109, '请上传视频文件', '');
            }
            $video= new Video();
            $video->url= $videoUrl;
            $video->type= $type;
            $video->create_time= $timer;
            if ($video->validate()) {
                $result = $video->save();
                if ($result == false) {
                    return $this->jsonResult(109, '新增失败');
                }
                return $this->jsonResult(600, '新增成功');
            } else {
                return $this->jsonResult(109, 'Video表单验证失败', $video->errors);
            }
        }
    /**
     * 编辑广告
     */
    public function actionEditBanner(){
            $post = Yii::$app->request->post();
            $session = Yii::$app->session;
            $bannerId=$post["banner_id"];
            $picName = $post["articleTitle"];
            $jumpType = $post["jumpType"];
            $jumpUrl = $post["jumpUrl"];
            $jumpTitle = $post["jumpTitle"];
            $content = $post["content"];
            $timer = date('Y-m-d H:i:s');
            if($picName==""){
                return $this->jsonResult(109, '参数有误，请检查重新上传');
            }
            if (isset($_FILES['upfile'])&&$_FILES['upfile']!="Undefined") {
                $file = $_FILES['upfile'];
                $check = UploadPic::check_upload_pic($file);
                if ($check['code'] != 600) {
                    return $this->jsonResult($check['code'], $check['msg']);
                }
                $saveDir = '/bananer/';
                $str = substr(strrchr($file['name'], '.'), 1);
                $name = rand(0,99).'.' . $str;
                $pathJson = UploadPic::pic_host_upload($file, $saveDir,$name);
                $path = json_decode($pathJson, true);
                if ($path['code'] != 600) {
                    return $this->jsonResult($path['code'], $path['msg']);
                }
                $picUrl = $path['result']['ret_path'];
            }else{
                $banner = Banner::find()->where(["banner_id"=>$bannerId])->one();
                $picUrl=$banner->pic_url;
            }
            $banner = Banner::find()->where(["banner_id"=>$bannerId])->one();
            $banner->pic_name= $picName;
            $banner->pic_url= $picUrl;
            $banner->content= $content;
            $banner->jump_type= $jumpType;
            $banner->jump_title= $jumpTitle;
            $banner->jump_url= $jumpUrl;
            $banner->opt_id= $session['admin']['admin_id'];
            if ($banner->validate()) {
                $result = $banner->save();
                if ($result == false) {
                    return $this->jsonResult(109, '广告编辑失败');
                }
                return $this->jsonResult(600, '广告编辑成功');
            } else {
                return $this->jsonResult(109, 'Bananer表单验证失败',$banner->errors);
            }
    }
    /**
     * 说明:修改状态
     */
    public function actionChangeStatus() {
        $parmas = \Yii::$app->request->post();
        $res = Banner::updateAll(['status' => $parmas['status']], ['banner_id' => $parmas['id']]);
        if($res){
            return $this->jsonResult(600, '操作成功', true);
        }else{
            return $this->jsonError(109, '操作失败');
        }
    }
    /**
     * 说明:删除数据
     * @param
     * @return
     */
    public function actionDelete() {
        $id = \Yii::$app->request->post()['id'];
        $res = Video::deleteAll(['video_id'=>$id]);
        if($res){
            return $this->jsonResult(600, '操作成功', true);
        }else{
            return $this->jsonError(109, '操作失败');
        }

    }
}