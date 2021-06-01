<?php
use yii\web\UrlManager;
use yii\rest\UrlRule;

$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);
return [
    'id' => 'yii-api',
    'basePath' => dirname(__DIR__),
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module',
        ],
    ],
    'components' => [
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-api', 'httpOnly' => true],
        ],
        'session' => [
            'name' => 'yii-api',
        ],
        'urlManager' => [
            'class' => UrlManager::class,
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                'POST v1/auth/login' => 'v1/auth/login',

                'GET,HEAD v1/collection' => 'v1/collection/index',
                'GET,HEAD v1/collection/<id>' => 'v1/collection/view',
                'PUT,PATCH v1/collection/<id>' => 'v1/collection/update',
                'POST v1/collection' => 'v1/collection/create',

                'GET,HEAD v1/photo' => 'v1/photo/index',
                'GET,HEAD v1/photo/<id>' => 'v1/photo/view',
                'POST v1/photo' => 'v1/photo/create',
            ],

        ],

    ],

    'params' => $params,
];