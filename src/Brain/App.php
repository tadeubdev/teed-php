<?php

	class App
	{

		use \Traits\Functions;

		public static function setVariables()
		{

			$uri = trim( $_SERVER['REQUEST_URI'], '/' );

			//

			if( String::countExplode( '/', $_SERVER['SCRIPT_NAME'] ) == 4 ):

				$scriptFileName = str_replace( '/index.php', '', $_SERVER['SCRIPT_NAME'] );

				$scriptFileName = substr( $scriptFileName, 1, strlen($scriptFileName) );

				self::setBase( Url::addHttpIntoUrl( sprintf( '%s/%s/', $_SERVER['SERVER_NAME'], $scriptFileName ) ) );

				$branch = trim( str_replace( $scriptFileName, '', $_SERVER['REQUEST_URI'] ), '/' );

				$branch = String::getFirstExplodeString( '.', $branch );

				$branch = String::getFirstExplodeString( '?', $branch );

				self::setBranch( $branch );

			elseif( String::countExplode( '/', $_SERVER['SCRIPT_NAME'] ) == 3 ):

				$scriptFileName = String::getFirstExplodeString( '/', trim( $_SERVER['SCRIPT_NAME'], '/' ) );

				self::setBase( Url::addHttpIntoUrl( sprintf( '%s/%s/', $_SERVER['SERVER_NAME'], $scriptFileName ) ) );

				$branch = trim( str_replace( $scriptFileName, '', $_SERVER['REQUEST_URI'] ), '/' );

				$branch = String::getFirstExplodeString( '.', $branch );

				$branch = String::getFirstExplodeString( '?', $branch );

				self::setBranch( $branch );

			else:

				$uri = String::getFirstExplodeString( '.', $uri );

				$uri = String::getFirstExplodeString( '?', $uri );

				self::setBranch( $uri );

				self::setBase( Url::addHttpIntoUrl( $_SERVER['SERVER_NAME'] ) . '/' );

			endif;

			//

			self::setUrl( self::getBase( self::getBranch() ) );

			self::setMethod( strtolower( $_SERVER['REQUEST_METHOD'] ) );

			self::setUri( str_replace( 'index.php', '', $_SERVER['SCRIPT_FILENAME'] ) );

			self::setWWWDir( self::getBase('www/') );

				self::setImageDir( self::getWWWDir('images/') );

				self::setScriptDir( self::getWWWDir('jscript/') );

				self::setCssDir( self::getWWWDir('css/') );

					self::setCssPagesDir( self::getCssDir('pages/') );

			self::setSrcDir( self::getUri('src/') );

			self::setAppDir( self::getSrcDir('App/') );

				self::setDataDir( self::getAppDir('data/') );

			self::setBrainDir( self::getSrcDir('Brain/') );

			self::setControllerDir( self::getSrcDir('Controller/') );

			self::setCoreDir( self::getSrcDir('Core/') );

				self::setViewsDir( self::getCoreDir('views/') );

				self::setTemplateDir( self::getCoreDir('templates/') );

				self::setTemplateType( self::getTemplateDir('master/') );

			self::setCacheDir( App::getCoreDir('cache/') );

			self::setHelpersDir( self::getSrcDir('Helpers/') );

			self::setTraitsDir( self::getSrcDir('Traits/') );

		}

		public static function initTemplateRouting()
		{

			$route = new stdClass;

			if( !count( Route::getRoute() ) ):

				$route->data[] = self::getBranch();

				$route->controller = ['Controller\\Error','getFileNotFound'];

			else:

				$route = Route::getRoute();

				$route->controller = explode( '@', $route->controller );

				if( substr( $route->controller[1], 0, 3 ) == 'get' ):

					$route->controller[1] = App::getMethod() . substr( $route->controller[1], 3, strlen($route->controller[1]) );

				endif;

				$route->controller[0] = "Controller\\{$route->controller[0]}";

				if( !class_exists( $route->controller[0] ) ):

					$route->data[] = self::getBranch();

					$route->controller = ['Controller\\Error','getControllerNotFound'];

				elseif( !method_exists( $route->controller[0], $route->controller[1] ) ):

					$route->data[] = self::getBranch();

					$route->controller = ['Controller\\Error','getMethodNotFound'];

				endif;

			endif;

			if( !isset( $route->data ) ):

				$route->data = [];

			endif;

			if( count( \Input::getAllData() ) ):

				$route->data += \Input::getAllData();

			endif;

			if( App::getMethod() == 'post' ):

				dump($_POST);

				return;

			endif;

			call_user_func_array( implode( '::', $route->controller ), $route->data );

		}

	}