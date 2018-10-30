<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "auto_out_order".
 *
 * @property integer $out_order_id
 * @property string $out_order_code
 * @property string $order_code
 * @property string $ticket_code
 * @property integer $free_type
 * @property string $lottery_code
 * @property string $play_code
 * @property string $periods
 * @property string $bet_val
 * @property integer $bet_add
 * @property integer $multiple
 * @property string $amount
 * @property integer $count
 * @property integer $status
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class AutoOutOrder extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auto_out_order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['free_type', 'bet_add', 'multiple', 'count', 'status'], 'integer'],
            [['bet_val'], 'string'],
            [['amount'], 'number'],
            [['create_time', 'modify_time', 'update_time'], 'safe'],
            [['out_order_code', 'order_code'], 'string', 'max' => 100],
            [['ticket_code', 'periods'], 'string', 'max' => 50],
            [['lottery_code', 'play_code'], 'string', 'max' => 25],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'out_order_id' => '自动出票订单表主键',
            'out_order_code' => '出票编号',
            'order_code' => '订单编号',
            'ticket_code' => '出票单票号',
            'free_type' => '串关方式 0：非自由串关 1：自由串关',
            'lottery_code' => '彩种编号',
            'play_code' => '玩法编号',
            'periods' => '期数',
            'bet_val' => '投注内容',
            'bet_add' => '追加 0：不追加 1:追加',
            'multiple' => '倍数',
            'amount' => '投注金额',
            'count' => '注数',
            'status' => '订单状态 1:等待出票 2:出票成功 3:出票失败',
            'create_time' => '创建时间',
            'modify_time' => '修改时间',
            'update_time' => '数据库对比时间',
        ];
    }
}
