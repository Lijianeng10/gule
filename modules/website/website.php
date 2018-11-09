<?php

namespace app\modules\website;

/**
 * modules module definition class
 */
class website extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\website\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
         return [
            "LoginFilter" => [
                "class" => 'app\modules\core\filters\LoginFilter'
            ],
//            "AuthFilter" => [
//                "class" => 'app\modules\core\filters\AuthFilter',
//                "children" => [
//                ]
//            ],
        ];
    }

}
