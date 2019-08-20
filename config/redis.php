<?php
if(YII_ENV_DEV){
    return [
        'class' => 'app\modules\components\redis\Connection',
        'hostname' => '139.159.143.55',
        'password' => 'glcg8888',
        'port' => 6379,
        'database' =>0,
    ];
}else{
//    return [
//            'class' => 'app\modules\components\redis\Connection',
//            'hostname' => '27.155.105.165',
//            'password' => 'gula_lottery_redis',
//            'port' => 63790,
//            'database' => 0,
//        ];
}


