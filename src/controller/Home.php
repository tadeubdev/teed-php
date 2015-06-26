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

		public static function getAbout()
		{

			self::$data['title'] = 'Sobre';

			self::$data['menu'] = [['','Home'],'Sobre'];

			self::getView('about');

		}

	}