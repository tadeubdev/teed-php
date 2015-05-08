<?php

	class Engine
	{

		use \Traits\Functions;

		public static function verifyDifference( $file, $other )
		{

			if( !file_exists( $other ) ):

				return true;

			else:

				$file =  (int) strtotime( date("F d Y H:i:s.", filemtime( $file ) ) );

				$other = (int) strtotime( date("F d Y H:i:s.", filemtime( $other ) ) );

				return $other < $file;

			endif;

		}

		public static function cacheTemplate( $file_name, $body=null )
		{
			include self::cacheFile( $file_name, $body );
		}

		public static function cacheFile( $file_name, $body=null )
		{

			$slug = '';

			// $slug = String::toSlug( str_replace( App::getUri(), '', $file_name) ).'-';

			$cached_file =  App::getCacheDir( $slug . sha1($file_name) );

			if( !file_exists($file_name) || self::verifyDifference( $file_name, $cached_file ) ):

				$file = self::renderTemplate( $file_name, $body );

				$file = preg_replace('/<!--([^\[|(<!)].*)/', '', $file);
				$file = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $file);
				$file = preg_replace('/\s{2,}/', '', $file);
				$file = preg_replace('/(\r?\n)/', '', $file);

				Files::putFile( $cached_file, $file, 'w+' );

			endif;

			return $cached_file;

		}

		public static function renderTemplate( $file, $body=null )
		{

			$string = Files::getFile( $file );

			$string = "{{{ if(Engine::getAllData()['variables']){extract(Engine::getAllData()['variables']);} }}} {$string}";

			if( $body ):

				$string = "@setContent('body') {$string} @endcontent";

			endif;

			$variables = Files::getData('template-variable.php');

			foreach( $variables as $value ):

				$value[0] = str_replace( ['(',')'], ['\(','\)'], $value[0] );

				$value[0] = str_replace( ['*'], ['(.*)'], $value[0] );

				$value[0] = "/({$value[0]})/U";

				$string = preg_replace( $value[0], $value[1], $string );

			endforeach;

			return $string;

		}

		public static function setContent( $content, $function )
		{
			self::$data['content'][$content] = $function;
		}

		public static function getContent( $content )
		{

			if( !isset( self::$data['content'][$content] ) ) return;

			$function = self::$data['content'][$content];

			$function( self::$data['variables'] );

		}

		public static function setVariable( $name, $str )
		{
			self::$data['variables'][$name] = $str;
		}

		public static function getVariable( $name, $nullValue=null )
		{

			if( !isset( self::$data['variables'][$name] ) ):

				echo $nullValue;

			else:

				$data = self::$data['variables'][$name];

				if( is_array($data) || is_object($data) ):

					return $data;

				else:

					echo $data;

				endif;

			endif;
		}

		public static function getVariables()
		{
			return self::$data['variables'];
		}

		//

		public static function includeFile( $file )
		{

			if( file_exists($file) ):

				include self::cacheFile( $file );

			else:

				echo Html::h3( "File not found: <strong>{$file}</strong>" )->class( 'error' );

			endif;
		}

		//

		public static function includePartial( $file )
		{

			$file = App::getTemplateType( "{$file}.php" );

			if( file_exists($file) ):

				include self::cacheFile( $file );

			else:

				echo Html::h3( "Partial not found: <strong>{$file}</strong>" )->class( 'error' );

			endif;

		}

	}