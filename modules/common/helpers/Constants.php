<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\modules\common\helpers;

class Constants {

    const ADMIN_ROLE = 3; //超级管理员角色ID
    const SMS_KEY_REGISTER = 'sms_register'; // 注册
    const SMS_KEY_UPPWD = 'sms_up_pwd'; // 修改密码
    const SMS_KEY_UP_PAY_PWD = 'sms_up_pay_pwd'; // 修改设置 支付密码
    const SMS_KEY_FOLLOW_STORE = 'sms_follow_store'; // 门店关注 
    const SMS_KEY_WX_BOUNDING = 'sms_wxbounding'; //  信息绑定
    const SMS_KEY_WX_CHANGE_BOUNDING = 'sms_wx_change_bound'; //  手机换绑
    const REDIS_KEY_REGLIST = 'register_list'; //新注册用户列表
    const MIN_WITHDRAW = 5.00;
    const WITHDRAW_FEE = 1.00;
    const PAY_TYPE_PIC_URL = 'http://ovjj0n6lg.bkt.clouddn.com/img/sys/paytype_pic/pay_type_';

    /**
     * 阿里短信模板
     * 1：注册 2：登录 4：忘记密码(登录密码，支付密码)
     */
    const ALISMS_MODULES=[
        "1"=>"SMS_134135445",
        "2"=>"SMS_134135447",
        "4"=>"SMS_134135443",
        '5'=>"SMS_134135448",
        "6"=>"SMS_135027049",
    ];
    /**
     * 网点认证状态
     */
    const AUTHEN_STATUS = [
        '' => '请选择',
        '0' => '未认证',
        '1' => '已通过',
        '2' => '审核中',
        '3' => '未通过',
    ];

    /**
     * 微信绑定状态
     */
    const WX_STATUS = [
        "" => "请选择",
        "1" => "已绑定",
        "2" => "未绑定",
    ];
    const COMPAR = [
        '' => '请选择',
        '<=' => '<=',
        '=' => '==',
        '>=' => '>='
    ];

    /**
     * 交易支出类型  1、购买 3、文章购买
     */
    const EXPENDITURE_TYPE = ["1"];

    /**
     * 交易明细订单状态
     */
    const PAY_STATUS = [
        '' => '请选择',
        '0' => '未支付',
        '1' => '已支付',
        '2' => '退款成功',
//        '3' => '退款成功',
//        '4' => '订单取消',
    ];

    /**
     * 交易明细支付方式
     */
    const PAY_WAY = [
        '' => '请选择',
        '1' => '支付宝支付',
        '2' => '微信支付',
        '3' => '余额支付',
        '4' => '合支付',
    ];

    /**
     * 交易明细支付类型
     */
    const PAY_TYPE = [
        '' => '请选择',
        '1' => '购买商品',
        '2' => '退款',
    ];
    //后台商品订单状态
    const ORDER_STATUS_ARR = [
        '0' => '待付款',
        '1' => '待发货',
        '2' => '待收货',
        '3' => '已退款',
        '4' => '已完成',
        '5' => '取消',
    ];
    //后台商品支付状态
    const PAY_STATUS_ARR = [
        '0' => '未支付',
        '1' => '已支付',
        '2' => '订单取消',
    ];

}
