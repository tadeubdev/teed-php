<?php

	class App
	{

		use \Traits\Functions;

		public static function startTheApplicationVariables()
		{

			$branch = trim( $_SERVER['REQUEST_URI'], '/' );

			$countScriptName = String::countExplode( '/', $_SERVER['SCRIPT_NAME'] );

			$ServerName = "{$_SERVER['SERVER_NAME']}/";

			if(  $countScriptName > 2  )
			{

				$scriptFileName = substr( $_SERVER['SCRIPT_NAME'], 1, strlen($_SERVER['SCRIPT_NAME']) - 10 );

				$ServerName .= $scriptFileName;

				$branch = trim( str_replace( $scriptFileName, '', $_SERVER['REQUEST_URI'] ), '/' );

			}

			$branch = String::getFirstExplodeString( '.', $branch );

			$branch = String::getFirstExplodeString( '?', $branch );

			self::setBranch( $branch );

			##

			self::setBase( Url::addHttpIntoUrl( $ServerName ) );

			self::setUrl( self::getBase( self::getBranch() ) );

			self::setMethod( strtolower( $_SERVER['REQUEST_METHOD'] ) );

			self::setUri( str_replace( 'index.php', '', $_SERVER['SCRIPT_FILENAME'] ) );

			##

			Dir::setVendor( self::getUri('vendor/') );

			Dir::setCore( self::getUri('core/') );

			foreach( Files::getData('src/data/globals.php',true)['paths'] as $type => $path )
			{

				$pathname = ($type=='src')? self::getUri(): self::getBase();

				Dir::$data[$type] = "{$pathname}{$type}/";

				foreach( $path as $name => $value )
				{

					if(!preg_match('/(\/$)/',$value)) $value .= '/';

					Dir::$data[$name] = "{$pathname}{$value}";

				}

			}

		}

		public static function confTemplateRoutes()
		{

			$route = new stdClass;

			try{

				if( !count( Route::getRoute() ) )
				{

					$route->data[] = self::getBranch();

					throw new TeedException();

				}
				else
				{

					$route = Route::getRoute();

					$route->controller = explode( '@', $route->controller );

					if( substr( $route->controller[1], 0, 3 ) == 'get' )
					{

						$route->controller[1] = App::getMethod() . substr( $route->controller[1], 3, strlen($route->controller[1]) );

					}

					$route->controller[0] = "{$route->controller[0]}";

					if( !class_exists( $route->controller[0] ) )
					{

						$route->data[] = self::getBranch();

						$route->controller = ['Error','getControllerNotFound'];

					}
					elseif( !method_exists( $route->controller[0], $route->controller[1] ) )
					{

						$route->data[] = self::getBranch();

						$route->controller = ['Error','getMethodNotFound'];

					}

				}

			}catch(TeedException $e)
			{

				$e->errorMessage( 'rout-not-found', App::getBranch(), null, App::getBase( App::getBranch() ) );

			}

			if( !isset( $route->data ) )
			{

				$route->data = [];

			}

			if( count( \Input::all() ) )
			{

				$route->data = array_merge( $route->data, \Input::all() );

			}

			call_user_func_array( implode( '::', $route->controller ), $route->data );

			call_user_func( $route->controller[0] . '::returnView' );

		}

	}
