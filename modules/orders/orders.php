<?php

namespace app\modules\orders;


/**
 * member module definition class
 */
class orders extends \yii\base\Module {

    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\orders\controllers';

    public function init() {
        parent::init();
        $this->SetContainer([
//            'app\modules\agents\services\IAgentsService' => 'app\modules\agents\services\AgentsService',
        ]);
    }

    public function behaviors() {
        return [
            "LoginFilter" => [
                "class" => 'app\modules\core\filters\LoginFilter'
            ],
        ];
    }
    
    private function SetContainer($relation) {
        foreach ($relation as $key => $value) {
            \Yii::$container->set($key, $value);
        }
    }

}
