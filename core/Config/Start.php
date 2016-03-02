<?php

	//////
	/// SET DATES OPTIONS
	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
	date_default_timezone_set('America/Sao_Paulo');
	Carbon\CarbonInterval::setLocale('pt_BR');

	//////
	/// START IPUNT
	Input::start();

	/////
	/// SET VARIBLES APP
	App::setVariables();

	/////
	/// SET SITE DATA
	Site::setAllData( Files::getData('website.php') );

	/////
	/// SET ENV
	foreach( Files::getData('enviroment.php') as $name => $value ):

		$match = str_replace('*','(.*)',$value->match);

		if( preg_match("/{$match}/", $_SERVER['HTTP_HOST']) ):

			$value->name = $name;

			App::setEnv( $value );

			break;

		endif;

	endforeach;

	/////
	/// INIT ROUTE
	require_once App::getTeedDir('Routers/configurations.php');

	require_once App::getSrcDir('routes.php');

	App::initTemplateRouting();