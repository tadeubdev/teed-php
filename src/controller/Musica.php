<?php

	class Musica
	{

		use Controller\Base;

		public static $base = 'musica';

		#

		public static function getHome()
		{

			self::getView()

				->with('title', 'Musica');

		}

	}