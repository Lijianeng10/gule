<?php
return [
    'userDomain' => "http://www.gulezyun.com.cn", //前台域名
    'lottery_img_host' => 'http://sys.gulezyun.com.cn/img/', //图片服务器地址

    'gl_shop_appid' => 'wxa2114b0a7c53ffc1',//谷乐财顾appid
    'gl_shop_mch_id' => '1541649181',//谷乐财顾商户ID
    'gl_shop_secret' => '77d196072921adfd9656bbb94e72a717',//谷乐财顾 app secret
    'gl_shop_pay_key' => '5dfabd0343b4055226859a8e00a8e891',//谷乐财顾支付秘钥

    'smtpServer'=>'smtp.qq.com',//SMTP服务器
    'smtpServerport' =>25,//SMTP服务器端口
    'smtpUsermail' => '1028617248@qq.com',//SMTP服务器的用户邮箱
    'smtpUser' => '1028617248@qq.com',//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
    'smtpPass' => 'fmqfwsfttzlbbcjf',//SMTP服务器的授权码

    'wechat' => [//微信公众号参数
        'token' => 'gule',
        'redirect_uri' => 'http://www.gulezyun.com.cn/api/front/user/call-back-wx-code',
        'appid' => 'wxa2114b0a7c53ffc1',
        'secret' => '423670fefb95b1e1be24c5f4dfb91919',
        'mchid' => 'your mchid',
        'key' => 'your key',
        'notifyUrl' => 'wechat notify url',
    ],
];
