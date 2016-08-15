
	<meta charset="utf-8">

	<title> {{ $title }} - {{ Site::getTitle() }} </title>

	<meta http-equiv="content-language" content="pt-br">

	{{ Html::link()->rel('stylesheet')->href( Dir::getCss("template.min.css") ) }}

	{{ Html::link()->rel('stylesheet')->href( Dir::getCss("libs/font-awesome.min.css") ) }}

	{{ Html::link()->rel('shortcut icon')->href( Dir::getWWW("images/favicon.ico") ) }}

	@if( isset($css) )

		@if( !is_array($css) )

			{{{ $css = [$css] }}}

		@endif

		@foreach( $css as $filecss )

			@if( is_string($filecss) )

				{{{ $filecss = Dir::getCssPages("{$filecss}.css") }}}

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

				{{{ $filejs = Dir::getWWW("jscript/{$filejs}.js") }}}

			@endif

			{{ Html::script()->src( $filejs ) }}

		@endforeach

	@endif