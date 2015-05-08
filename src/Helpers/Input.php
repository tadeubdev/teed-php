<?php

	class Input
	{

		public static $data = [];

		public static function start( $get, $post )
		{
			self::$data += $get;
			self::$data += $post;
		}

		public static function getAllData() { return self::$data; }

		public static function __callStatic( $meth, $args )
		{

			$str = $args[0];

			$isNull = isset( $args[1] )? $args[ 1 ]: null;

			if( $meth == 'has' )
			{

				if( !isset( $args[1] ) ) $args[1] = null;

				if( !isset( $args[2] ) ) $args[2] = null;

				return isset(self::$data[$str]) && !is_null(self::$data[$str])? $args[1]: $args[2];
			}

			if( $meth == 'set' )
			{
				self::$data[ $str ] = !isset(self::$data[$str]) || is_null(self::$data[$str])? $args[1]: $isNull;
			}

			if( $meth == 'get' )
			{
				return isset(self::$data[$str]) && !is_null(self::$data[$str])? self::$data[$str]: $isNull;
			}
		}

	}