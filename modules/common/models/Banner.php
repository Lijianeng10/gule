<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "banner".
 *
 * @property integer $banner_id
 * @property string $pic_name
 * @property string $pic_url
 * @property integer $jump_type
 * @property string $jump_title
 * @property string $jump_url
 * @property string $content
 * @property integer $type
 * @property integer $status
 * @property string $create_time
 * @property string $update_time
 * @property integer $opt_id
 * @property integer $praise_num
 * @property integer $comment_num
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jump_type', 'type', 'status', 'opt_id', 'praise_num', 'comment_num'], 'integer'],
            [['content'], 'string'],
            [['create_time', 'update_time'], 'safe'],
            [['pic_name', 'jump_title'], 'string', 'max' => 50],
            [['pic_url', 'jump_url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'banner_id' => 'Banner ID',
            'pic_name' => 'Pic Name',
            'pic_url' => 'Pic Url',
            'jump_type' => 'Jump Type',
            'jump_title' => 'Jump Title',
            'jump_url' => 'Jump Url',
            'content' => 'Content',
            'type' => 'Type',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'opt_id' => 'Opt ID',
            'praise_num' => 'Praise Num',
            'comment_num' => 'Comment Num',
        ];
    }
}
