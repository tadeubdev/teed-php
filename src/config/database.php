<?php

	$cfg = ActiveRecord\Config::instance();

	$cfg->set_model_directory('src/service/');

	$conn = [];

	foreach( Files::getData('src/data/enviroment.php',true) as $name => $value ):

		$match = str_replace('*','(.*)',$value['match']);

		if( preg_match("/{$match}/", $_SERVER['HTTP_HOST']) ):

			App::setEnv( $name );

			$conn[ $name ] = "mysql://{$value['database']['user']}:{$value['database']['pass']}@{$value['database']['name']}/{$value['database']['db']}";

			break;

		endif;

	endforeach;

	$cfg->set_connections( $conn );

	ActiveRecord\Config::initialize(function($cfg)
	{
		$cfg->set_default_connection( App::getEnv() );
	});