<?php

	class Home
	{

		use Controller\Base;

		public static $base = 'home';

		//

		public static function getHome()
		{

			self::$data['title'] = 'Home';

			self::$data['css'] = 'welcome';

			self::getView();

		}

	}