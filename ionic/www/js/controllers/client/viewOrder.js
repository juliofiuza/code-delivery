angular.module('code-delivery.controllers')
	.controller('ClientViewOrderCtrl', [
	'$scope', '$state', '$stateParams', '$ionicLoading', 'ClientOrder',
	function($scope, $state, $stateParams, $ionicLoading, ClientOrder) {		
		$scope.order = {};
		$ionicLoading.show({
			template: 'Carregando...'
		});

		ClientOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data) {
			$scope.order = data.data;
			$ionicLoading.hide();
		}, function(dataError) {
			console.log('Erro:', dataError);
			$ionicLoading.hide();
		});

	}]);