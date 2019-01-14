<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/01/03
 * Time: 15:15:08
 */
namespace app\modules\front\services;

use Yii;
use yii\base\Exception;
use yii\db\Expression;
use app\modules\common\models\Banner;

class PublicService{
    /**
     * 获取广告页
     * @return type
     */
    public static function getBanner($size) {
        $field = ['banner_id', 'pic_name', 'pic_url', 'jump_type', 'jump_url', 'jump_title'];
        $bananerData = Banner::find()->select($field)
            ->where(['type' => 1, 'status' => 1])
            ->limit($size)
            ->orderBy('create_time desc')
            ->asArray()
            ->all();
        return $bananerData;
    }
}