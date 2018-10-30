<?php

namespace app\modules\common\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $user_id
 * @property string $cust_no
 * @property string $user_name
 * @property string $user_pic
 * @property string $user_tel
 * @property string $password
 * @property string $belong_center
 * @property integer $status
 * @property integer $authen_status
 * @property string $authen_remark
 * @property integer $opt_id
 * @property string $user_remark
 * @property string $real_name
 * @property string $card_no
 * @property string $card_front
 * @property string $card_back
 * @property string $card_with
 * @property string $province
 * @property string $city
 * @property string $area
 * @property string $address
 * @property string $sports_lottery_num
 * @property string $sports_lottery_img
 * @property string $recv_bank_acct_num
 * @property string $bank_card_img
 * @property string $recv_bank_province
 * @property string $recv_bank_city
 * @property string $recv_bank_name
 * @property string $recv_bank_branch_name
 * @property string $last_login
 * @property string $create_time
 * @property string $modify_time
 * @property string $update_time
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cust_no', 'user_tel'], 'required'],
            [['status', 'authen_status', 'opt_id'], 'integer'],
            [['last_login', 'create_time', 'modify_time', 'update_time'], 'safe'],
            [['cust_no'], 'string', 'max' => 15],
            [['user_name', 'belong_center', 'province', 'city', 'area', 'sports_lottery_num', 'recv_bank_acct_num', 'recv_bank_branch_name'], 'string', 'max' => 50],
            [['user_pic'], 'string', 'max' => 256],
            [['user_tel'], 'string', 'max' => 12],
            [['password', 'authen_remark', 'address'], 'string', 'max' => 100],
            [['user_remark'], 'string', 'max' => 255],
            [['real_name', 'recv_bank_province', 'recv_bank_city', 'recv_bank_name'], 'string', 'max' => 25],
            [['card_no'], 'string', 'max' => 20],
            [['card_front', 'card_back', 'card_with', 'sports_lottery_img', 'bank_card_img'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'cust_no' => 'Cust No',
            'user_name' => 'User Name',
            'user_pic' => 'User Pic',
            'user_tel' => 'User Tel',
            'password' => 'Password',
            'belong_center' => 'Belong Center',
            'status' => 'Status',
            'authen_status' => 'Authen Status',
            'authen_remark' => 'Authen Remark',
            'opt_id' => 'Opt ID',
            'user_remark' => 'User Remark',
            'real_name' => 'Real Name',
            'card_no' => 'Card No',
            'card_front' => 'Card Front',
            'card_back' => 'Card Back',
            'card_with' => 'Card With',
            'province' => 'Province',
            'city' => 'City',
            'area' => 'Area',
            'address' => 'Address',
            'sports_lottery_num' => 'Sports Lottery Num',
            'sports_lottery_img' => 'Sports Lottery Img',
            'recv_bank_acct_num' => 'Recv Bank Acct Num',
            'bank_card_img' => 'Bank Card Img',
            'recv_bank_province' => 'Recv Bank Province',
            'recv_bank_city' => 'Recv Bank City',
            'recv_bank_name' => 'Recv Bank Name',
            'recv_bank_branch_name' => 'Recv Bank Branch Name',
            'last_login' => 'Last Login',
            'create_time' => 'Create Time',
            'modify_time' => 'Modify Time',
            'update_time' => 'Update Time',
        ];
    }
}
