<?php

	class Route
	{

		use \Traits\Functions;

		//

		static $rules = [];

		static $route = [];

		static function insert( $url, $controller='EmptyController@getIndex', $name=null )
		{

			$route = new stdClass;

			$route->controller = $controller;

			$route->rules = [];

			$url = trim( $url, '/' );

			$matchInUrl = false;

			if( !empty( $url ) ):

				$new_url = explode('/',$url);

				foreach( $new_url as $key => $value ):

					if( substr( $value, 0, 1 ) == ':' ):

						$route->rules[] = substr( $value, 1, strlen( $value ) );

						$value = '(.*)';

						$matchInUrl = true;

					endif;

					$new_url[ $key ] = $value;

				endforeach;

				if( $name ):

					$routesname = self::getRoutes();

					$routesrules = [];

					foreach( $route->rules as $key => $rules ):

						$routesrules[ $key ] = self::getRule()[$rules];

					endforeach;

					$routesname[$name] = [
						'url' => $new_url,
						'rules' => $routesrules,
						'controller' => $route->controller
					];

					self::setRoutes( $routesname );

				endif;

				$url = implode( '\/', $new_url );

			endif;

			//

			if( $matchInUrl ):

				if( preg_match_all( "/({$url})/", App::getBranch(), $match ) ):

					if( substr_count( App::getBranch(), '/' ) == substr_count( $url, '\/' ) ):

						for( $x=2; $x<=count( $match )-1; $x++ ):

							if( isset( self::getRule($x-2)[ $route->rules[ $x - 2 ] ] ) ):

								$rule = self::getRule($x-2)[ $route->rules[ $x - 2 ] ];

								if( preg_match( "/({$rule}$)/", $match[$x][0] ) ):

									if( preg_match('/(0-9)/', $rule) ):

										$route->data[] = (int) $match[$x][0];

									else:

										$route->data[] = $match[$x][0];

									endif;

								else:

									$route->data[] = null;

								endif;

							endif;

						endfor;

						self::setRoute( $route );

					endif;

				endif;

			else:

				$branch = explode( '/', App::getBranch() );

				$branch = implode( '\/', $branch );

				if( $url == $branch ):

					self::setRoute( $route );

				endif;

			endif;

			return new self;

		}

		static function group( $url, $controller, $routes )
		{

			foreach( $routes as $route ):

				if( !isset($route[2])) $route[2] = null;

				self::insert( "{$url}{$route[0]}", "{$controller}@{$route[1]}", $route[2] );

			endforeach;
		}

		static function __callStatic( $meth, $args )
		{

			$action = substr( $meth, 3, strlen( $meth ) );

			if( substr( $meth, 0, 3 ) == 'set' ):

				if( !isset( $args[1] ) ):

					self::$data[$action] = $args[0];

				else:

					self::$data[ $action ][ $args[0] ] = $args[1];

				endif;

			elseif( substr( $meth, 0, 3 ) == 'get' ):

				return isset(self::$data[$action])? self::$data[$action]: null;


			elseif( substr( $meth, 0, 3 ) == 'add' ):

				if( !isset( $args[1] ) ):

					self::$data[$action][] = $args[0];

				else:

					self::$data[ $action ][ $args[0] ][] = $args[1];

				endif;

			endif;

		}

	}