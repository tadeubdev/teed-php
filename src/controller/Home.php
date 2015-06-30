<?php

	class Home
	{

		use Controller\Base;

		public static function getHome()
		{

			self::$data['title'] = 'Home';

			self::$data['css'] = 'welcome';

			self::$data['notMenu'] = true;

			self::getView();

		}

	}