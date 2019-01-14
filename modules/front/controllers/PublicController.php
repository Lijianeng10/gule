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


}
