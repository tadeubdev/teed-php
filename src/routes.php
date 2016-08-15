<?php

Route::insert('', 'Home@getHome', 'home');

Route::group('musica', 'Musica', array(

	array('/', 'getHome', 'musica')

));