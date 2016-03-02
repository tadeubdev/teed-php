<?php

	class Engine
	{

		use \Traits\Functions;

		static function verifyIfFileIsTeedTemplate($file)
		{

			$teed = str_replace('.php','.teed.php',$file);

			return file_exists($teed)? $teed: $file;

		}

		static function verifyDifference( $file, $cached )
		{

			if( !file_exists( $cached ) ) return true;

			$file = Carbon\Carbon::now()->timestamp(filemtime($file));

			$cached = Carbon\Carbon::now()->timestamp(filemtime($cached));

			return $cached < $file;

		}

		static function cacheTemplate( $file_name )
		{

			self::cacheFile( $file_name );

		}

		static function cacheFile( $file_name )
		{

			$file_name = self::verifyIfFileIsTeedTemplate($file_name);

			if( App::getEnv()->name == 'local' ):

				$cached_file =  App::getCacheDir( str_replace( [App::getSrcDir(),'/'], ['','-'], $file_name ) );

			else:

				$cached_file =  App::getCacheDir( sha1($file_name) );

			endif;

			$cached_file = preg_replace('/((?:(\.teed))?(\.php))/','.cache-teed',$cached_file);

			if( !file_exists($file_name) || self::verifyDifference( $file_name, $cached_file ) ):

				$file = self::renderFile( $file_name );

				Files::putFile( $cached_file, $file, 'w+' );

				return $file;

			else:

				return implode(' ',Files::getFile($cached_file));

			endif;

		}

		static function renderFile( $file )
		{

			$file = self::verifyIfFileIsTeedTemplate( $file );

			$string = Files::getFile( $file );

			$variables = Files::getData( App::getTeedDir('Engine/Variables.php'), true );

			foreach( $variables as $value ):

				$value = (array) $value;

				$value[0] = str_replace( ['(',')'], ['\(','\)'], $value[0] );

				$value[0] = str_replace( ['*'], ['(.*)'], $value[0] );

				$value[0] = "/({$value[0]})/" . (isset($value[2])? '': 'U');

				$string = preg_replace( $value[0], $value[1], $string );

			endforeach;

			return $string;

		}

		static function renderVariables( $file )
		{

			$response = [];

			if( preg_match_all("/(\{\-\- setContent\(('|\")(.*)('|\")\) \-\-\}(.*)\{\-\- endcontent \-\-\})/Us", $file, $types)>0 ):

				foreach( $types[0] as $int => $value ):

					if( !isset($types[3][0]) || !isset($types[5][0]) ) continue;

					$item = Teed::setContent($types[3][0],$types[5][0]);

					$file = str_replace( $types[0][0], $item, $file );

				endforeach;

			endif;

			if( preg_match_all("/(\{\-\- (setTemplate|includeFile|includePartial)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0 ):

				foreach( $types[0] as $int => $value ):

					$item = Teed::{$types[2][0]}($types[4][0]);

					$file = str_replace($types[0][0], $item, $file );

					$response[] = [
						'name' => $types[2][0],
						'regex' => $types[0][0],
						'value' => $file
					];

				endforeach;

				if( !isset($types[2][0]) || !isset($types[4][0]) ) continue;

			endif;

			return $response;

		}

		static function getContentsVariables( $file )
		{

			if( preg_match_all("/(\{\-\- (getContent)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0 ):

				foreach( $types[0] as $int => $value ):

					if( !isset($types[2][$int]) || !isset($types[4][$int]) ) continue;

					$item = Teed::getContent($types[4][$int]);

					$file = str_replace( $value, $item, $file );

				endforeach;

			endif;

			return $file;

		}

		static function renderBody( $file )
		{

			$file = self::cacheFile( $file );

			if( preg_match("/(\{\-\- setContent\(('|\")body('|\")\) \-\-\})/U", $file) <= 0 ):

				$file = "{-- setContent('body') --}{$file}{-- endcontent --}";

			endif;

			if( preg_match("/(\{\-\- setContent\((.*)\) \-\-\})/U", $file, $matches) > 0 ):

				self::renderVariables( $file );

			endif;

		}

		static function renderTemplate( $file )
		{

			$file = self::cacheFile( $file );

			extract(Engine::getAllData()['variables']);

			if( preg_match_all("/(\{\-\- (setContent|template|include|includePartial)\(('|\")(.*)('|\")\\) \-\-\})/U", $file, $types)>0 ):

				foreach( $types[0] as $int => $type ):

					if( !isset($types[2][ $int ]) || !isset($types[3][ $int ]) ) continue;

					$response = Teed::{$types[2][ $int ]}($types[4][ $int ]);

					$vars = self::renderVariables( $response );

					if( count($vars) ):

						foreach( $vars as $value ):

							$response = str_replace($value['regex'], $value['value'], $response );

						endforeach;

					endif;

					$file = str_replace($types[0][ $int ], $response, $file );

				endforeach;

			endif;

			$file = self::getContentsVariables( $file );

			if( App::getEnv()->compress_output ):

				$file = preg_replace('/<!--([^\[|(<!)].*)/', '', $file);
				$file = preg_replace('/(?<!\S)\/\/\s*[^\r\n]*/', '', $file);
				$file = preg_replace('/\s{2,}/', '', $file);
				$file = preg_replace('/(\r?\n)/', '', $file);

			endif;

			eval("?>{$file}");

		}

	}