angular.module('code-delivery.controllers')
	.controller('ClientCheckoutCtrl', [
	'$scope', '$state', '$ionicLoading', '$ionicPopup', '$cordovaBarcodeScanner', '$cart', 'ClientOrder', 'Cupom',
	function($scope, $state, $ionicLoading, $ionicPopup, $cordovaBarcodeScanner, $cart, ClientOrder, Cupom) {
		var cart = $cart.get();
		$scope.cupom = cart.cupom;
		$scope.items = cart.items;
		$scope.total = $cart.getTotalFinal();
		//$scope.showDelete = false;
		
		$scope.removeItem = function(i) {
			$cart.removeItem(i);
			$scope.items.splice(i, 1);
			$scope.total = $cart.getTotalFinal();
		};

		$scope.openListProducts = function() {
			$state.go('client.view_products');
		};

		$scope.openProductDetail = function(i) {
			$state.go('client.checkout_item_detail', { index: i });
		};

		$scope.save = function() {
			var o = {items: angular.copy($scope.items)};
			angular.forEach(o.items, function(item) {
				item.product_id = item.id;
			});

			if ($scope.cupom.value) {
				o.cupom_code = $scope.cupom.code;
			}

			$ionicLoading.show({
				template: 'Carregando...'
			});

			ClientOrder.save({ id: null }, o, function(data) {
				$ionicLoading.hide();
				$state.go('client.checkout_successful');
			}, function(error) {
				$ionicLoading.hide();
        		$ionicPopup.alert({
        			title: 'Advertência',
        			template: 'Pedido não realizado. Tente novamente.',
				    buttons: [
				      {
				      	text: 'Ok',
				        type: 'button-balanced'
				      }
				    ]
        		});
			});
		};

		$scope.readBarCode = function() {
			$cordovaBarcodeScanner.scan().then(function(barcodeData) {
				getValueCupom(barcodeData.text);
			}, function(error) {
        		$ionicPopup.alert({
        			title: 'Advertência',
        			template: 'Não foi possível ler código de barras. Tente novamente.',
				    buttons: [
				      {
				      	text: 'Ok',
				        type: 'button-balanced'
				      }
				    ]
        		});
			});
		};

		$scope.removeCupom = function() {
			$cart.removeCupom();
			$scope.cupom = $cart.get().cupom;
			$scope.total = $cart.getTotalFinal();
		};

		var getValueCupom = function(code) {

			$ionicLoading.show({
				template: 'Carregando...'
			});

			Cupom.get({code: code}, function(data) {
				$cart.setCupom(data.data.code, data.data.value);
				$scope.cupom = $cart.get().cupom;
				$scope.total = $cart.getTotalFinal();
				$ionicLoading.hide();
			}, function(error) {
				$ionicLoading.hide();
				console.log(error);
        		$ionicPopup.alert({
        			title: 'Advertência',
        			template: 'Cupom inválido',
				    buttons: [
				      {
				      	text: 'Ok',
				        type: 'button-balanced'
				      }
				    ]
        		});
			});

		};
	}]);