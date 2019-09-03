<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "logs".
 *
 * @property integer $logs_id
 * @property integer $type
 * @property string $content
 * @property string $c_time
 */
class Logs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'logs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['content'], 'string'],
            [['c_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'logs_id' => 'Logs ID',
            'type' => 'Type',
            'content' => 'Content',
            'c_time' => 'C Time',
        ];
    }
}
