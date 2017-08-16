<?php

	namespace Traits;

	trait Functions
	{

		public static $data = [];

		public static function __callStatic( $meth, $args )
		{

			$action = substr( $meth, 0, 3 );

			$name = strtolower( substr( $meth, 3, strlen( $meth ) ) );

			switch( $action )
			{
				#

				case 'all':

					if( $args )
					{
						self::$data = array_merge( self::$data, (array) $args[0] );
					}
					else
					{
						return self::$data;
					}

				break;

				#

				case 'get':

					if( !isset(self::$data[$name]) ) return null;

					if( isset( $args[0] ) ) return self::$data[$name] . $args[0];

					if( isset( $args[1] ) ) return self::$data[$name] . $args[0] . $args[1];

					return self::$data[$name];

				break;

				#

				case 'set':

					return self::$data[$name] = $args[0];

				break;

			}

		}

		public static function getAllData()
		{
			return self::$data;
		}

	}