angular.module('code-delivery.controllers')
	.controller('ClientMenuCtrl', [
	'$scope', 'UserData', function($scope, UserData) {
		$scope.user = UserData.get();
	}]);