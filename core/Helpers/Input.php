<?php

	class Input
	{

		static $data = [];

		static function start()
		{
			self::$data = array_merge( self::$data, $_GET, $_POST );
		}

		static function getAllData()
		{
			return self::$data;
		}

		static function __callStatic( $meth, $args )
		{

			$str = $args[0];

			$isNull = isset( $args[1] )? $args[ 1 ]: null;

			if( $meth == 'has' ):

				if( !isset( $args[1] ) ) $args[1] = null;

				if( !isset( $args[2] ) ) $args[2] = null;

				return isset(self::$data[$str]) && !is_null(self::$data[$str])? $args[1]: $args[2];

			endif;

			if( $meth == 'set' ):

				self::$data[ $str ] = !isset(self::$data[$str]) || is_null(self::$data[$str])? $args[1]: $isNull;

			endif;

			if( $meth == 'get' ):

				return isset(self::$data[$str]) && !is_null(self::$data[$str])? self::$data[$str]: $isNull;

			endif;
		}

	}