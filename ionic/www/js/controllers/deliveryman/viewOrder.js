angular.module('code-delivery.controllers')
	.controller('DeliverymanViewOrderCtrl', [
	'$scope', '$stateParams', '$ionicLoading', '$ionicPopup', '$cordovaGeolocation', 'DeliverymanOrder',
	function($scope, $stateParams, $ionicLoading, $ionicPopup, $cordovaGeolocation, DeliverymanOrder) {
		var watch;
		var lat = null, lng;

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
					if (!lat) {
						lat = position.coords.latitude;
						lng = position.coords.longitude;
					} else {
						lng += 0.0150;
					}

					DeliverymanOrder.geo({id: $stateParams.id}, {
						lat: lat,
						lng: lng
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