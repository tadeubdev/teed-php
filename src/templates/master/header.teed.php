
	@if( !isset( $notMenu ) )

		<div class="content sidebar" id="sidebar">

			<div class="container">

				<a href="@link('')" sidebar-link="home"> home </a>

				<a href="@link('about')" sidebar-link="about"> sobre </a>

			</div>

		</div>

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