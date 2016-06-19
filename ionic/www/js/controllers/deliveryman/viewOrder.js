angular.module('code-delivery.controllers')
	.controller('DeliverymanViewOrderCtrl', [
	'$scope', '$stateParams', '$ionicLoading', '$ionicPopup', '$cordovaGeolocation', 'DeliverymanOrder',
	function($scope, $stateParams, $ionicLoading, $ionicPopup, $cordovaGeolocation, DeliverymanOrder) {
		var watch;

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

		$scope.goToDelivery = function() {

    		$ionicPopup.alert({
    			title: 'Advertência',
    			template: 'Interrompa a localização clicando em OK',
			    buttons: [
			      {
			      	text: 'Ok',
			        type: 'button-energized'
			      }
			    ]
    		}).then(function() {
    			stopWatchPosition();
    		});

			DeliverymanOrder.updateStatus({id: $stateParams.id}, {status: 1}, function(data) {
				var watchOptions = {
					timeout: 3000,
					enableHighAccuracy: false
				};
				watch = $cordovaGeolocation.watchPosition(watchOptions);
				watch.then(null,
				function(error) {
					console.log(error);
				}, function(position) {
					console.log(position);
					DeliverymanOrder.geo({id: $stateParams.id}, {
						lat: position.coords.latitude,
						lng: position.coords.longitude
					}, function(data) {
						console.log(data);
					});
				});

			});
		};

		var stopWatchPosition = function() {
			if (watch && typeof watch == 'object' && watch.hasOwnProperty('watchID')) {
				$cordovaGeolocation.clearWatch(watch.watchID);
			}
		};

	}]);