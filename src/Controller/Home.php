<?php

	namespace Controller;

	class Home
	{

		use Base;

		public static $base = 'home';

		//

		public static function getHome()
		{

			self::$data['title'] = 'Home';

			self::$data['menu'] = ['home'];

			self::getView();

		}

	}