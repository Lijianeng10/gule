<?php

namespace app\modules\common\models;

use Yii; 

/** 
 * This is the model class for table "user_gl_coin_record". 
 * 
 * @property integer $gl_coin_record_id
 * @property integer $user_id
 * @property integer $type
 * @property string $coin_source
 * @property string $coin_value
 * @property integer $totle_balance
 * @property double $multiple
 * @property string $remark
 * @property string $order_code
 * @property integer $order_source
 * @property string $create_time
 */ 
class UserGlCoinRecord extends \yii\db\ActiveRecord
{ 
    /** 
     * @inheritdoc 
     */ 
    public static function tableName() 
    { 
        return 'user_gl_coin_record'; 
    } 

    /** 
     * @inheritdoc 
     */ 
    public function rules() 
    { 
        return [
            [['user_id', 'type', 'coin_source', 'coin_value'], 'required'],
            [['user_id', 'type', 'totle_balance', 'order_source','coin_source'], 'integer'],
            [['coin_value', 'multiple'], 'number'],
            [['create_time'], 'safe'],
            [['remark'], 'string', 'max' => 200],
            [['order_code'], 'string', 'max' => 50],
        ]; 
    } 

    /** 
     * @inheritdoc 
     */ 
    public function attributeLabels() 
    { 
        return [ 
            'gl_coin_record_id' => 'Gl Coin Record ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'coin_source' => 'Coin Source',
            'coin_value' => 'Coin Value',
            'totle_balance' => 'Totle Balance',
            'multiple' => 'Multiple',
            'remark' => 'Remark',
            'order_code' => 'Order Code',
            'order_source' => 'Order Source',
            'create_time' => 'Create Time',
        ]; 
    } 
} 

