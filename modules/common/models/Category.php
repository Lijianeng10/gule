<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $name
 * @property integer $p_id
 * @property integer $sort
 * @property integer $status
 * @property string $create_time
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_id', 'sort', 'status'], 'integer'],
            [['create_time'], 'safe'],
            [['name'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Category ID',
            'name' => 'Name',
            'p_id' => 'P ID',
            'sort' => 'Sort',
            'status' => 'Status',
            'create_time' => 'Create Time',
        ];
    }
}
