angular.module('code-delivery.controllers')
	.controller('DeliverymanViewOrderCtrl', [
	'$scope', '$stateParams', '$ionicLoading', 'DeliverymanOrder',
	function($scope, $stateParams, $ionicLoading, DeliverymanOrder) {		
		$scope.order = {};
		$ionicLoading.show({
			template: 'Carregando...'
		});

		DeliverymanOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data) {
			$scope.order = data.data;
			$ionicLoading.hide();
		}, function(error) {
			console.log('Erro:', error);
			$ionicLoading.hide();
		});

	}]);