<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "video".
 *
 * @property integer $video_id
 * @property string $url
 * @property string $create_time
 * @property string $update_time
 */
class Video extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'safe'],
            [['url'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'video_id' => 'Video ID',
            'url' => 'Url',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
