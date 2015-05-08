
	@if( isset($js) )

		@if( !is_array($js) )

			{{{ $js = [$js] }}}

		@endif

		@foreach( $js as $file )

			@if( is_string($file) )

				{{{ $file = App::getWWWDir("jscript/{$file}.js") }}}

			@endif

			<script src="{{ $file }}"></script>

		@endforeach

	@endif