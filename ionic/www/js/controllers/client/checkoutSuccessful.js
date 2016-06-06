angular.module('code-delivery.controllers')
	.controller('ClientCheckoutSuccessfulCtrl', [
	'$scope', '$state', '$stateParams', '$cart',
	function($scope, $state, $stateParams, $cart) {
		var cart = $cart.get();
		$scope.cupom = cart.cupom;
		$scope.items = cart.items;
		$scope.total = $cart.getTotalFinal();
		$cart.clear();

		$scope.openListOrder = function() {

		};
	}]);