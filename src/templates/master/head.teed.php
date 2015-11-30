
	<meta charset="utf-8">

	<title> {{ $title }} - {{ Site::getTitle() }} </title>

	<meta http-equiv="content-language" content="pt-br">

	{{ Html::link()->rel('stylesheet')->href( App::getCssPagesDir("default.css") ) }}

	{{ Html::link()->rel('stylesheet')->href( App::getCssDir("libs/font-awesome.min.css") ) }}

	{{ Html::link()->rel('shortcut icon')->href( App::getWWWDir("images/favicon.png") ) }}

	@if( isset($css) )

		@if( !is_array($css) )

			{{{ $css = [$css] }}}

		@endif

		@foreach( $css as $filecss )

			@if( is_string($filecss) )

				{{{ $filecss = App::getCssPagesDir("{$filecss}.css") }}}

			@endif

			{{ Html::link()->rel('stylesheet')->href( $filecss ) }}

		@endforeach

	@endif

	@if( isset($js) )

		@if( !is_array($js) )

			{{{ $js = [$js] }}}

		@endif

		@foreach( $js as $filejs )

			@if( is_string($filejs) )

				{{{ $filejs = App::getWWWDir("jscript/{$filejs}.js") }}}

			@endif

			{{ Html::script()->src( $filejs ) }}

		@endforeach

	@endif