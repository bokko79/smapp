<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityCookie' => [
                'name'     => '_frontendIdentity',
                'path'     => '/',
                'httpOnly' => true,
            ],
            'class' => 'common\components\User',
            'identityClass' => '\common\models\UserAccount',
        ],
        'session' => [
            'name' => 'FRONTENDSESSID',
            'cookieParams' => [
                'httpOnly' => true,
                'path'     => '/',
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                'contact-us' => 'site/contact',
                // AUTOCOMPLETE
                'auto/list-act-services' => 'autocomplete/list-act-services',
                'auto/list-ind-actions' => 'autocomplete/list-ind-actions',
                'auto/list-services' => 'autocomplete/list-services',
                'auto/list-industries' => 'autocomplete/list-industries',
                'auto/list-actions' => 'autocomplete/list-actions',
                'auto/list-objects' => 'autocomplete/list-objects',
                'auto/list-providers' => 'autocomplete/list-providers',
                /*'auto/list-tags' => 'autocomplete/list-tags',
                'auto/list-services-tags' => 'autocomplete/list-services-tags',
                'auto/list-industries-tags' => 'autocomplete/list-industries-tags',
                'auto/list-actions-tags' => 'autocomplete/list-actions-tags',
                'auto/list-objects-tags' => 'autocomplete/list-objects-tags',*/
                'autoindex' => 'autocomplete/index',
            ],
        ],
        'authClientCollection' => [
            'class'   => \yii\authclient\Collection::className(),
            'clients' => [
                // here is the list of clients you want to use
                // you can read more in the "Available clients" section
                'facebook' => [
                    'class'        => 'dektrium\user\clients\Facebook',
                    'clientId'     => '378436095836284',
                    'clientSecret' => '6513c2a65ea6fcaacb3ee1dbaeb7bf4f',
                ],
                'google' => [
                    'class'        => 'dektrium\user\clients\Google',
                    'clientId'     => '925657439136-4aphu2j63j04v7fc5lgahrrba0g4mojs.apps.googleusercontent.com',
                    'clientSecret' => 'YpOC_guE7k4o5DL7Gd8fhexr',
                ],
            ],
        ],
    ],
    'modules' => [
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module',
            // format settings for displaying each date attribute (ICU format example)
            'displaySettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'dd. MMM yyyy.',
                \kartik\datecontrol\Module::FORMAT_TIME => 'H:mm',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'dd. MMM yyyy. H:mm',
            ],
            
            // format settings for saving each date attribute (PHP format example)
            'saveSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => 'php:Y-m-d', //
                \kartik\datecontrol\Module::FORMAT_TIME => 'php:H:i:s',
                \kartik\datecontrol\Module::FORMAT_DATETIME => 'php:Y-m-d H:i:s',
            ],
            
            // automatically use kartik\widgets for each of the above formats
            'autoWidget' => true,
     
            // default settings for each widget from kartik\widgets used when autoWidget is true
            'autoWidgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => ['type'=>2, 'pluginOptions'=>['autoclose'=>true]], // example
                \kartik\datecontrol\Module::FORMAT_DATETIME => [], // setup if needed
                \kartik\datecontrol\Module::FORMAT_TIME => [], // setup if needed
            ],
            
            // custom widget settings that will be used to render the date input instead of kartik\widgets,
            // this will be used when autoWidget is set to false at module or widget level.
            'widgetSettings' => [
                \kartik\datecontrol\Module::FORMAT_DATE => [
                    'class' => 'yii\jui\DatePicker', // example
                    'options' => [
                        'dateFormat' => 'php:Y-m-d',
                        'options' => ['class'=>'form-control'],
                    ]
                ]
            ]
        ],
        'user' => [
            // following line will restrict access to admin controller from frontend application
            'as frontend' => 'dektrium\user\filters\FrontendFilter',            
        ],
    ],
    'params' => $params,
];
