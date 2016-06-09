angular.module('code-delivery.controllers')
	.controller('ClientViewOrderCtrl', [
	'$scope', '$state', '$stateParams', '$ionicLoading', 'Order',
	function($scope, $state, $stateParams, $ionicLoading, Order) {		
		$scope.order = {};
		$ionicLoading.show({
			template: 'Carregando...'
		});

		Order.get({id: $stateParams.id, include: 'items,cupom'}, function(data) {
			$scope.order = data.data;
			$ionicLoading.hide();
		}, function(dataError) {
			console.log('Erro:', dataError);
			$ionicLoading.hide();
		});

	}]);