
	<meta charset="utf-8">

	<title> {{ $title }} - Teste </title>

	<meta http-equiv="content-language" content="pt-br">

	<link rel="stylesheet" href="{{ App::getCssDir("libs/font-awesome.min.css") }}">

	<link rel="stylesheet" href="{{ App::getCssPagesDir("default.css") }}">

	<link rel="shortcut icon" href="{{ App::getWWWDir("images/favicon.png") }}">

	@if( isset($css) )

		@if( !is_array($css) )

			{{{ $css = [$css] }}}

		@endif

		@foreach( $css as $file )

			@if( is_string($file) )

				{{{ $file = App::getCssPagesDir("{$file}.css") }}}

			@endif

			<link rel="stylesheet" href="{{ $file }}">

		@endforeach

	@endif