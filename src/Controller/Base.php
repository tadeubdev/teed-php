<?php

	namespace Controller;

	use \App, \Files, \Engine, \Traits\Functions;

	trait Base
	{

		use Functions;

		public static function getView( $file_name='index' )
		{

			$file_name = sprintf('%s/%s.php', self::$base, $file_name);

			self::returnView( $file_name );

		}

		public static function getDefaultView( $pagina, $menulateral='default' )
		{

			self::$data['menulateral'] = $menulateral;

			self::$data['pagina'] = $pagina;

			self::returnView( "default/pagina.php" );

		}

		public static function returnView( $file_name )
		{

			self::$data['base'] = self::$base;

			Engine::$data['variables'] = self::$data;

			$file_name = App::getViewsDir($file_name);

			Engine::cacheTemplate( $file_name, true );

			///

			$template = App::getTemplateDir('template.php');

			Engine::cacheTemplate( $template );

		}

	}