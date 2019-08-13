<?php
return [
    'userDomain' => "http://119.23.239.189:1011", //前台域名
    'java_appId' => '362a00a28e234199a0d911cbdd1d4c67', //钱包支付AppId
    'java_appKey' => 'edd3c3cfb1d147f89124c5f5f969f272e601f61599ef49679a038ceaab36355d' , // 钱包支付AppKey
    'lottery_img_host' => 'http://119.23.239.189:8082', //图片服务器地址

    'gl_shop_appid' => 'wx774016baa223f8f6',//咕啦商城小程序appid
    'gl_shop_mch_id' => '1514825831',//咕啦商城商户ID
    'gl_shop_secret' => '77d196072921adfd9656bbb94e72a717',//咕啦商城 app secret
    'gl_shop_pay_key' => '0257c8b69d6f9a49285a82a8b7942636',//咕啦商城支付秘钥

    'smtpServer'=>'smtp.qq.com',//SMTP服务器
    'smtpServerport' =>25,//SMTP服务器端口
    'smtpUsermail' => '1028617248@qq.com',//SMTP服务器的用户邮箱
    'smtpUser' => '1028617248@qq.com',//SMTP服务器的用户帐号，注：部分邮箱只需@前面的用户名
    'smtpPass' => 'fmqfwsfttzlbbcjf',//SMTP服务器的授权码

    'wechat' => [//微信公众号参数
        'token' => 'gule',
        'redirect_uri' => 'your redirect uri',
        'appid' => 'wxa2114b0a7c53ffc1',
        'appsecret' => 'e9678906d75d964e268aa35e1608ec15',
        'mchid' => 'your mchid',
        'key' => 'your key',
        'notifyUrl' => 'wechat notify url',
    ],
];
