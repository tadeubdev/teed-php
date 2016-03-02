<?php

	$env = App::getEnv();

	$conn = ["{$env->name}" => $env->database];

	$cfg = ActiveRecord\Config::instance();

	$cfg->set_model_directory('src/service/');

	$cfg->set_connections( $conn );

	ActiveRecord\Config::initialize(function($cfg) use($env)
	{
		$cfg->set_default_connection("mysql://{$env->database['user']}:{$env->database['pass']}@{$env->database['name']}/{$env->database['db']}");
	});