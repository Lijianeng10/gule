<?php

namespace app\modules\main;

/**
 * index module definition class
 */
class main extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\main\controllers';

    /**
     * @inheritdoc
     */
    public function init() {
        parent::init();

        // custom initialization code goes here
    }

    public function behaviors() {
        return [
//            "LoginFilter" => [
//                "class" => 'app\modules\core\filters\LoginFilter',
//                'except'=>[
//                    'index/test',
//                ]
//            ],
        ];
    }

}
