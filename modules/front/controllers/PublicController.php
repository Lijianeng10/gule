<?php

namespace app\modules\front\controllers;

use Yii;
use yii\web\Controller;
use app\modules\common\models\User;
use app\modules\front\services\PublicService;

class PublicController extends Controller {
    /**
     * 获取广告列表
     * @return type
     */
    public function actionGetBanner() {
        $request = \Yii::$app->request;
        $size = $request->post('size', 10);
        $bannerData = PublicService::getBanner($size);
        return $this->jsonResult(600, '获取成功', $bannerData);
    }

    /**
     * 获取谷乐新闻列表
     */
    public function actionGetNews(){
        $request = \Yii::$app->request;
        $infoType = $request->post('infoType', '');
        $page = $request->post('page', 1);
        $size = $request->post('size', 10);
        $newsData = PublicService::getNews($infoType,$page,$size);
        return $this->jsonResult(600, '获取成功', $newsData);
    }
}
