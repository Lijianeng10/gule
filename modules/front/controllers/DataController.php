<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/09/04
 * Time: 10:03:46
 */
namespace  app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\News;

class DataController extends Controller{
    /**
     * 爬虫谷乐资讯数据接入
     * @return json
     */
    public function actionInformationData() {
        $request = \Yii::$app->request;
        $json = $request->post('data', '');
        $data = json_decode($json, true);
        $news = new News();
        $news->pic_name = $this->arrParameter($data[0], 'pic_name');
        $news->pic_url = $this->arrParameter($data[0], 'pic_url');
        $news->content = $this->arrParameter($data[0], 'content');
        $news->type = $this->arrParameter($data[0], 'type');
        $news->info_type = $this->arrParameter($data[0], 'info_type');
//        $news->league_code = $this->arrParameter($data[0], 'league_code');
        $news->create_time = $this->arrParameter($data[0], 'create_time');
        $news->sub_content = $this->arrParameter($data[0], 'sub_content');
        $news->status = 1;
        if ($news->validate()) {
            if ($news->save()) {
                return $this->jsonResult(600, '数据写入成功', true);
            }
            return $this->jsonResult(109, '数据写入失败', $news->errors);
        } else {
            return $this->jsonResult(109, '数据验证失败', $news->errors);
        }
    }
    /**
     * 判断数组是否存在该键
     * @param type $data
     * @param type $name
     * @return type
     */
    public function arrParameter($data, $name) {
        if (!isset($data[$name])) {
            return $this->jsonError(109, $name . "参数缺失;");
        }
        return $data[$name];
    }
}