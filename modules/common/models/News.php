<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property integer $news_id
 * @property string $pic_name
 * @property string $pic_url
 * @property string $pc_pic_url
 * @property integer $jump_type
 * @property string $jump_title
 * @property string $jump_url
 * @property string $content
 * @property string $sub_content
 * @property integer $area
 * @property integer $type
 * @property integer $info_type
 * @property integer $use_type
 * @property string $league_code
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $opt_id
 * @property integer $praise_num
 * @property integer $comment_num
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pic_name', 'content', 'sub_content'], 'string'],
            [['jump_type', 'area', 'type', 'info_type', 'use_type', 'status', 'opt_id', 'praise_num', 'comment_num'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['pic_url', 'pc_pic_url', 'jump_url'], 'string', 'max' => 255],
            [['jump_title'], 'string', 'max' => 50],
            [['league_code'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'pic_name' => 'Pic Name',
            'pic_url' => 'Pic Url',
            'pc_pic_url' => 'Pc Pic Url',
            'jump_type' => 'Jump Type',
            'jump_title' => 'Jump Title',
            'jump_url' => 'Jump Url',
            'content' => 'Content',
            'sub_content' => 'Sub Content',
            'area' => 'Area',
            'type' => 'Type',
            'info_type' => 'Info Type',
            'use_type' => 'Use Type',
            'league_code' => 'League Code',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'opt_id' => 'Opt ID',
            'praise_num' => 'Praise Num',
            'comment_num' => 'Comment Num',
        ];
    }
} 
