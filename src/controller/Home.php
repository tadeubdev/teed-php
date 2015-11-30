<?php

	class Home
	{

		use Controller\Base;

		public static function getHome()
		{

			self::getView()

				->with('title', 'Home')

				->with('css', 'welcome')

				->with('notMenu', true);

		}

	}