<!doctype html>
<html>
	<head>

		@includePartial('head')

	</head>
	<body ng-app="app" ng-controller="AllController" ng-init="base='{{ $base }}'">

		@includePartial('header')

		<div class="content" id="body">

			<div class="container">

				@getContent('body')

			</div>

		</div>

		@includePartial('footer')

	</body>
</html>