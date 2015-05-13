<?php

	Input::start( $_GET, $_POST );

	App::setVariables();

	require_once App::getSrcDir('routes.php');

	App::initTemplateRouting();