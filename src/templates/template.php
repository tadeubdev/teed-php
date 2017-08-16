<!doctype html>
<html>
	<head>
		@includePartial('master.head')
	</head>
	<body ng-app="app" ng-controller="AllController" ng-init="base='{{ $base }}'">
		@includePartial('master.header')
		<div class="content" id="body">
			<div class="container">
				@getContent('body')
			</div>
		</div>
		@includePartial('master.footer')
	</body>
</html>
