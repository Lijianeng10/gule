<?php

namespace app\modules\website\controllers;

use Yii;
use yii\db\Query;
use yii\web\Controller;
use app\modules\common\models\Banner;
use app\modules\common\helpers\PublicHelpers;
use app\modules\common\helpers\Constants;
use app\modules\common\models\Video;


class ViewsController extends Controller {

    /**
     * @return string 活动banner页面
     */
    public function actionToBannerList(){
        return $this->render('/websitemod/banner/list',[]);
    }
    public function actionToBannerAdd(){
        $picType = PublicHelpers::BANANER_TYPE;
        $picStatus = PublicHelpers::BANANER_STATUS;
        $picUse = PublicHelpers::BANANER_USE;
        $picArea = PublicHelpers::BANANER_AREA;
        $picJump = PublicHelpers::JUMP_TYPE;
        return $this->render('/websitemod/banner/add',["picType" => $picType, "picStatus" => $picStatus,"picUse"=>$picUse,"picArea"=>$picArea,"picJump"=>$picJump]);
    }
    public function actionToBannerEdit(){
        $id = \Yii::$app->request->get('banner_id');
        $picJump = PublicHelpers::JUMP_TYPE;
        $banner = Banner::find()
            ->where(['banner_id'=>$id])
            ->asArray()
            ->one();
        return $this->render('/websitemod/banner/edit',["picJump" => $picJump,'banner'=>$banner]);
    }

    /**
     *视频管理
     */
    public function actionToVideoList(){
        return $this->render('/websitemod/video/list',[]);
    }
    public function actionToVideoAdd(){
        return $this->render('/websitemod/video/add');
    }
}
