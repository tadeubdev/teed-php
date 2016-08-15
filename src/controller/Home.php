<?php

	class Home
	{

		use Controller\Base;

		public static $base = 'home';

		#

		public static function getHome()
		{

			self::getView()

				->with('title', 'Home');

		}

	}