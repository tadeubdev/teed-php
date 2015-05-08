angular.module('app',[

	'app.controller',

	'app.service'

],
function ($interpolateProvider)
{
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
})