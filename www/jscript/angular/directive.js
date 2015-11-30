angular.module('app.directive',[]).

directive('sidebarLink', function()
{

	return function( scope, elm, attrs )
	{

		if( attrs['sidebarLink'] == scope.base )
		{
			elm.addClass('selected');
		}
	};

})