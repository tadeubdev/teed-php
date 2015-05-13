# teed-php
TeedPHP Framework!

----

#### Framework

	Facilita a criação de arquivos PHP, HTML, SCSS, AngularJs.

	Criação de Template para o PHP, exemplo:

	.....

	@if( $user->logado() )

		Olá {{ Html::h1( $user->username ) }}!

	@else

		<button class="btn-warning" ng-click="OpenBoxLogin()">

			<i class="fa fa-user"></i> &nbsp;

			Efetue login

		</button>

	@endif

	.....

------