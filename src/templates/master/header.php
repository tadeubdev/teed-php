
	@if( !isset( $notMenu ) )

		<header id="menu">

			<div id="menu-center">

				<a href="@link('')" sidebar-link="home">

					home

				</a>

				<a href="@link('musica')" sidebar-link="musica">

					musica

				</a>

			</div>

		</header>

		@if( isset( $menu ) )

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

	@endif

	@getContent('header')