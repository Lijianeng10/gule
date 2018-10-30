<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "user_funds".
 *
 * @property integer $user_funds_id
 * @property integer $user_id
 * @property string $cust_no
 * @property string $all_funds
 * @property string $able_funds
 * @property string $ice_funds
 * @property string $no_withdraw
 * @property integer $user_integral
 * @property string $pay_password
 * @property integer $opt_id
 * @property integer $withdraw_status
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class UserFunds extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_funds';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'user_integral', 'opt_id', 'withdraw_status'], 'integer'],
            [['cust_no'], 'required'],
            [['all_funds', 'able_funds', 'ice_funds', 'no_withdraw'], 'number'],
            [['create_time', 'modify_time', 'update_time'], 'safe'],
            [['cust_no'], 'string', 'max' => 50],
            [['pay_password'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_funds_id' => 'User Funds ID',
            'user_id' => 'User ID',
            'cust_no' => 'Cust No',
            'all_funds' => 'All Funds',
            'able_funds' => 'Able Funds',
            'ice_funds' => 'Ice Funds',
            'no_withdraw' => 'No Withdraw',
            'user_integral' => 'User Integral',
            'pay_password' => 'Pay Password',
            'opt_id' => 'Opt ID',
            'withdraw_status' => 'Withdraw Status',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
