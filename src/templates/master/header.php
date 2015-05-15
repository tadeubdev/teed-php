
	@if( isset( $menu ) )

		<div class="content" id="header">

			<div class="container">

				<h1> Teste </h1>

			</div>

		</div>

		<div class="content sidebar" id="sidebar">

			<div class="container">

				<a href="@link('')"> home </a>

			</div>

		</div>

		<div class="content sidebar" id="sidebar-bread">

			<div class="container">

				@foreach( $menu as $menu )

					@if( is_array( $menu ) )

						<a href="@link("$menu[0]")"> {{ $menu[1] }} </a>

					@else

						<span> {{ $menu }} </span>

					@endif

				@endforeach

			</div>

		</div>

	@endif

	@getContent('header')