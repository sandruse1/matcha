<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'en',
//    'layout' => 'basic',
    'modules' => [
        'redactor' => 'yii\redactor\RedactorModule',
        'class' => 'yii\redactor\RedactorModule',
        'uploadDir' => '@webroot/uploads',
        'uploadUrl' => '/hello/uploads',
        'user' => [
            'class' => 'dektrium\user\Module',
            'enableUnconfirmedLogin' => TRUE,
            'confirmWithin' => 21600,
            'cost' => 12,
            'admins' => ['admin']
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'NAIc3nuF',
//            'baseUrl' => '',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'geoip' => ['class' => 'lysenkobv\GeoIP\GeoIP'
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
//            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,

        'urlManager' => [

            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
//                'site/success_login' => 'user/profiledata',
                '<alias:index|about|contact|signup|login|forgot>' => 'site/<alias>',
                'search' => 'account/search',
                'account' => 'account/account',
                'message' => 'account/message',
                'profiledata' => 'account/profiledata',
                'settings' => 'account/settings',
            ],
        ],
        'facebook' => [
            'class' => 'yii\authclient\clients\Facebook',
            'authUrl' => 'https://www.facebook.com/dialog/oauth?display=popup',
            'clientId' => '302902180181988',
            'clientSecret' => '53debebd7a56476e4b9ed58206f7d425',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '302902180181988',
                    'clientSecret' => '53debebd7a56476e4b9ed58206f7d425',
                ],
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => '295617776206-eg8ht00ilj1su2231h5jequh35rq9p7t.apps.googleusercontent.com',
                    'clientSecret' => 'beAXxolPM2_ebrswtUHBjA2-',
                ],
                // etc.
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'kossmoss\GoogleMaps\GoogleMapsAsset' => [
                    'apiKey' => 'AIzaSyAEMGeAu4-DWCQShVdZM_qLgCPe9rvrd20',   // get at https://developers.google.com/maps/documentation/javascript/get-api-key
                    'language' => 'ru', // use language code supported by Google Maps API  (default: en)
                ],
            ],
        ],
//        'assetManager' => [
//            'basePath' => '@webroot/assets',
//            'baseUrl' => '@web/assets'
//        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
