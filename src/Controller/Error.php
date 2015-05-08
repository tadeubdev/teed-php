<?php

	namespace Controller;

	class Error
	{

		use Base;

		public static $base = 'error';

		//

		public static function getFileNotFound( $pagina=null )
		{

			self::$data['title'] = 'Erro';

			self::$data['css'] = 'error';

			self::$data['menu'] = ['Algo deu errado!'];

			self::$data['pagina'] = $pagina;

			self::getView('not-found-class');

		}

		public static function getControllerNotFound()
		{

			self::$data['title'] = 'Erro';

			self::$data['css'] = 'error';

			self::$data['menu'] = ['Algo deu errado!'];

			self::getView('not-found-function');
		}

		public static function getMethodNotFound()
		{

			self::$data['title'] = 'Erro';

			self::$data['css'] = 'error';

			self::$data['menu'] = ['Algo deu errado!'];

			self::getView('not-found-class');
		}

	}