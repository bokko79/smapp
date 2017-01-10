<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            //'defaultRoles' => ['admin','editor','user'], // here define your roles
        ],
        'user' => [
            'loginUrl' => ['user/security/login'],  
        ],
        // overriding dektrium views
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@dektrium/user/views' => '@frontend/views/registration',
                ],
            ],
        ],
    ],
    'modules' => [
	    'user' => [
	        'class' => 'dektrium\user\Module',
            // overriding controllers dektrium
            'controllerMap' => [
                'recovery'      => 'frontend\controllers\RecoveryController',
                'registration'  => 'frontend\controllers\RegistrationController',
                'security'      => 'frontend\controllers\SecurityController',
                'settings'      => 'frontend\controllers\SettingsController',
            ],
            // overriding models dektrium
            'modelMap' => [
                'Profile'           => 'common\models\Profile',
                'ProfileContact'    => 'common\models\ProfileContact',
                'ProfileFiles'      => 'common\models\ProfileFiles',
                'RegistrationForm'  => 'common\models\RegistrationForm',
                'SettingsForm'      => 'common\models\SettingsForm',
                'UserAccount'       => 'common\models\User',
            ],
	        // you will configure your module inside this file
	        // or if need different configuration for frontend and backend you may
	        // configure in needed configs
	        'enableUnconfirmedLogin' => true,
	        'enablePasswordRecovery' => true,
	        'confirmWithin' => 21600,
        	'cost' => 12,
	    ],
	    //'rbac' => 'dektrium\rbac\RbacWebModule',
	],
];
