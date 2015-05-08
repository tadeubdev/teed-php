<!doctype html>
<html>
	<head>

		@includePartial('head')

	</head>
	<body ng-app="app" ng-controller="AllController">

		@includePartial('header')

		<div class="content" id="body">

			<div class="container">

				@getContent('body')

			</div>

		</div>

		@includePartial('footer')

		<script src="{{ App::getWWWDir("node_modules/jquery/jquery.min.js") }}"></script>
		<script src="{{ App::getWWWDir("node_modules/angular/angular.min.js") }}"></script>
		<script src="{{ App::getWWWDir("jscript/angular/app.js") }}"></script>
		<script src="{{ App::getWWWDir("jscript/angular/controller.js") }}"></script>
		<script src="{{ App::getWWWDir("jscript/angular/service.js") }}"></script>

	</body>
</html>