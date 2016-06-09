angular.module('code-delivery.controllers')
	.controller('ClientMenuCtrl', [
	'$scope', '$state', '$ionicLoading', 'User',
	function($scope, $state, $ionicLoading, User) {
		$scope.user = {
			name: ''
		};

		$ionicLoading.show({
			template: 'Carregando...'
		});

		User.authenticated({include: 'client'}, function(data) {
			$scope.user = data.data;
			$ionicLoading.hide();
		}, function(error) {
			console.log(error);
			$ionicLoading.hide();
		});
	}]);