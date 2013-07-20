<?php
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'黄山折扣优惠',
    'defaultController' => 'index',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),


    'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
    'modules'=>array(
        'gii'=>array(
            'generatorPaths'=>array(
                'bootstrap.gii',
            ),
        ),
    ),
	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'Enter Your Password Here',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        'bootstrap'=>array(
            'class'=>'bootstrap.components.Bootstrap',
        ),

        // uncomment the following to enable URLs in path-format
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                /*                'post/<id:\d+>/<title:.*?>'=>'post/view',*/
                // REST patterns
                array('<version>/<controller>/list', 'pattern'=>'api/<version:\w+>/<controller:\w+>', 'verb'=>'GET'),
                array('<version>/<controller>/view', 'pattern'=>'api/<version:\w+>/<controller:\w+>/<id:\d+>', 'verb'=>'GET'),
                array('<version>/<controller>/update', 'pattern'=>'api/<version:\w+>/<controller:\w+>/<id:\d+>', 'verb'=>'PUT'),
                array('<version>/<controller>/delete', 'pattern'=>'api/<version:\w+>/<controller:\w+>/<id:\d+>', 'verb'=>'DELETE'),
                array('<version>/<controller>/create', 'pattern'=>'api/<version:\w+>/<controller:\w+>', 'verb'=>'POST'),
                // Other controllers

            ),
        ),
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=voucher',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);