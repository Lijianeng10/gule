<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "lottery".
 *
 * @property integer $lottery_id
 * @property string $lottery_code
 * @property string $lottery_name
 * @property string $admin_code
 * @property integer $status
 * @property string $limit_area
 * @property string $create_time
 * @property string $update_time
 */
class Lottery extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'lottery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['create_time', 'update_time'], 'safe'],
            [['lottery_code'], 'string', 'max' => 15],
            [['lottery_name', 'admin_code'], 'string', 'max' => 100],
            [['limit_area'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lottery_id' => 'Lottery ID',
            'lottery_code' => 'Lottery Code',
            'lottery_name' => 'Lottery Name',
            'admin_code' => 'Admin Code',
            'status' => 'Status',
            'limit_area' => 'Limit Area',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }
}
