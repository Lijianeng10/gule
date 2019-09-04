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
use app\modules\common\models\News;

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

    /**
     * 获取谷乐新闻列表
     * @param $infoType
     * @param $page
     * @param $size
     * @return array
     */
    public static function getNews($infoType,$page,$size) {
        $where = ['and'];
        if(!empty($infoType)){
            $where[] = ['info_type'=>$infoType];
        }
        $where[] = ['type'=>1,'status' => 1];
        $total = News::find()->where($where)->count();
        $pages = ceil($total / $size);
        $offset = ($page - 1) * $size;
        $newsList = News::find()
            ->where($where)
            ->limit($size)
            ->offset($offset)
            ->orderBy('create_time desc')
            ->asArray()
            ->all();
        return ['page_num' => $page, 'data' => $newsList, 'size' => $size, 'pages' => $pages, 'total' => $total];
    }
}