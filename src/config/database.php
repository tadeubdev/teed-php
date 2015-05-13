<?php

	$cfg = ActiveRecord\Config::instance();

	$cfg->set_model_directory('src/service/');

	$cfg->set_connections(

		array(
			'local' => 'mysql://root:@localhost/teste',
			'test' => 'mysql://username:password@localhost/test_database_name',
			'production' => 'mysql://username:password@localhost/production_database_name'
		)
	);

	ActiveRecord\Config::initialize(function($cfg)
	{
		$cfg->set_default_connection( getenv('enviroment') );
	});