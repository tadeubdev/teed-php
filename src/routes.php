<?php

Route::insert('/', 'Home@getHome', 'home');

Route::group( 'about', 'About', array(
	array('/', 'getHome', 'about')
));