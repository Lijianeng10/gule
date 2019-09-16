<?php

namespace app\modules\front;

/**
 * tools module definition class
 */
class front extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\front\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
    public function behaviors() {
        return [
            "LoginFilter" => [
                "class" => 'app\modules\core\filters\FrontLoginFilter',
                'only' => [
                     'user/get-user-detail',
                     'user/set-nickname',
                     'user/set-user-info',
                     'user/set-user-bank-info',
                     'user/get-shop-car-list',
                     'user/opt-user-shop-car',
                     'order/play-order',
                    'order/get-user-order-num',
                    'order/get-order-list',
                    'order/cancle-order'

                ],
                "any" => [
//                    'user/get-store-detail',
//                    'user/user-follow',
//                    'user/bink-bank-card',
//                    'fjtc/get-redeem-code',
//                    'fjtc/cron-deal',
//                    'user-comment/comment',
//                    'user-comment/reply',
                ],
                "except"=>[

                ]
            ]
        ];
    }
}
