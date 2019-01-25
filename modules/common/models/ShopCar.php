<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "shop_car".
 *
 * @property integer $car_id
 * @property integer $user_id
 * @property integer $product_id
 * @property integer $nums
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class ShopCar extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shop_car';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'nums'], 'integer'],
            [['create_time', 'modify_time', 'update_time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'car_id' => 'Car ID',
            'user_id' => 'User ID',
            'product_id' => 'Product ID',
            'nums' => 'Nums',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
