angular.module('code-delivery.controllers')
	.controller('ClientCheckoutSuccessfulCtrl', [
	'$scope', '$state', '$stateParams', '$cart',
	function($scope, $state, $stateParams, $cart) {
		var cart = $cart.get();
		$scope.items = cart.items;
		$scope.total = cart.total;
		$cart.clear();

		$scope.openListOrder = function() {

		};
	}]);