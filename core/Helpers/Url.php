<?php

	class Url
	{

		public static function addHttpIntoUrl( $url )
		{
			return preg_match( '/(http)/', $url )? $url: "http://{$url}";
		}

		public static function removeHttpIntoUrl( $url )
		{
			return preg_replace('/((.*):\/\/(.*))/', '', $url );
		}

		public static function toLocalUrl( $url )
		{
			return $url;
		}

		public static function toExternalUrl( $url )
		{
			return self::addHttpIntoUrl( $url );
		}

		public static function redirect( $url )
		{

			ob_start();

			header("Location: {$url}");

			ob_flush();

		}

		public static function route()
		{

			$route = self::returnRoute( func_get_args() );

			return self::redirect( $route );

		}

		public static function returnRoute( $data )
		{

			if( !isset( Route::getRoutes()[ $data[0] ] ) ) return App::getBase();

			$route = Route::getRoutes()[ $data[0] ];

			$data = array_slice( $data, 1 );

			if( !$route['rules'] )
			{

				$url = $route['url'];

				return App::getBase() . implode('/',$url);

			}
			else
			{

				$url = [];

				foreach( $route['rules'] as $int => $rule )
				{

					if( !isset($data[$int]) ) continue;

					$rule = $route['url'][ $int+1 ];

					$match = $route['rules'][ $int ];

					if( $rule=='(.*)')
					{

						if( !preg_match("/({$match})/",$data[$int])) continue;

						$url[] = $data[$int];

					}
					else
					{

						$url[] = $data[$int];

					}

				}

				if( count( $url ) )
				{

					array_unshift( $url, $route['url'][0] );

					$url = implode('/',$url);

					return App::getBase() . $url;

				}

			}

			return App::getBase();

		}

	}