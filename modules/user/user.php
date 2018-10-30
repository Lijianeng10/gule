<?php

namespace app\modules\user;

/**
 * modules module definition class
 */
class user extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\user\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

    }

    public function behaviors() {
         return [
            "LoginFilter" => [
                "class" => 'app\modules\core\filters\LoginFilter'
            ],
        ];
    }

}
