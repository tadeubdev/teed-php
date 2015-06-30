<?php

	setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');

	date_default_timezone_set('America/Sao_Paulo');

	Carbon\CarbonInterval::setLocale('pt_BR');

	//

	Input::start( $_GET, $_POST );

	App::setVariables();

	Site::setAllData( Files::getData('website.php') );

	require_once App::getSrcDir('routes.php');

	App::initTemplateRouting();