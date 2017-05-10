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
	'language'=>'zh-CN',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
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
        'assetManager' => [
            'linkAssets' => true,
        ],
    		'i18n' => [
    				'translations' => [
    						'app' => [
    								'class' => 'yii\i18n\PhpMessageSource',
    								'basePath' => '@common/messages',
    								'fileMap' => [
    										'app' => 'app.php'
    								],
    						],
    				],
    		],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',
            'rules' => [
            		//'<controller>/<cid:\d+>/<sname:\w+>/<action>'=>'<controller>/<action>',
            		'<controller>/<sname:\w+>/<id:\d+>/<action>'=>'<controller>/<action>',
            		'<controller>/<sname:\w+>/<aid:\d+>/<action>'=>'<controller>/<action>',
            		'<controller>/<sname:\w+>/<action>'=>'<controller>/<action>',
            		//'<controller>/<id:\d+>/<action>'=>'<controller>/<action>',
            		
            ],
        ], 
		
		'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
			'useFileTransport' =>false,
			'transport' => [  
		    'class' => 'Swift_SmtpTransport',  
		    'host' => 'smtp.exmail.qq.com',
		    'username' => 'cs@gohoc.com',  
		    'password' => 'Gohoc@123',
		],   
		'messageConfig'=>[  
			'charset'=>'UTF-8',  
			'from'=>['cs@gohoc.com'=>'光合科技']  
			],  
        ],
        
    ],
    'params' => $params,
];
