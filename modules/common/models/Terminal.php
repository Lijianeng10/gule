<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "terminal".
 *
 * @property integer $terminal_id
 * @property string $terminal_num
 * @property integer $status
 * @property string $create_time
 * @property string $qrcode_url
 */
class Terminal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'terminal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time','qrcode_url'], 'safe'],
            [['terminal_num'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'terminal_id' => 'Terminal ID',
            'terminal_num' => 'Terminal Num',
            'status' => 'Status',
            'create_time' => 'Create Time',
            'qrcode_url' => 'Qrcode Url',
        ];
    }
}
