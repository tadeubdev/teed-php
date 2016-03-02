<?php

	namespace Controller;

	use \App, \Files, \Engine, \Traits\Functions;

	trait Base
	{

		use Functions;

		static $file_name;

		static function getBase()
		{

			if( !isset(self::$base) ):

				preg_match_all('/((?:^|[A-Z])[a-z]+)/', get_class(), $matches);

				$base = \String::toSlug( implode( '-', $matches[0] ) );

			else:

				$base = self::$base;

			endif;

			return $base;

		}

		static function getView( $file_name='index' )
		{

			$file_name = sprintf('%s/%s.php', self::getBase(), $file_name);

			self::$file_name = $file_name;

			return new self;

		}

		static function with( $meth, $args )
		{

			self::$data[ $meth ] = $args;

			return new self;

		}

		static function getDefaultView( $page, $lateral=null )
		{

			self::$data['menulateral'] = !$lateral? 'default': self::getBase();

			self::$data['page'] = $page;

			self::returnView("default/page.php");

		}

		static function returnView()
		{

			self::$data['base'] = self::getBase();

			Engine::$data['variables'] = self::$data;

			//

			$file_name = App::getViewsDir( self::$file_name );

			Engine::renderBody( $file_name );

			///

			$template = App::getTemplatesDir('template.php');

			Engine::renderTemplate( $template );

		}

	}