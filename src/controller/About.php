<?php

	class About
	{

		use Controller\Base;

		public static $base = 'about';

		//

		public static function getHome()
		{

			self::getView()

				->with('title', 'Sobre');

		}

	}