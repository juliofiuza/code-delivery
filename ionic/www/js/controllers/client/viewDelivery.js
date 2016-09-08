angular.module('code-delivery.controllers')
	.controller('ClientViewDeliveryCtrl', [
	'$scope', '$state', '$stateParams', '$ionicLoading', '$ionicPopup', '$window', '$pusher', '$map', 'ClientOrder', 'UserData', 'uiGmapGoogleMapApi',
	function($scope, $state, $stateParams, $ionicLoading, $ionicPopup, $window, $pusher, $map, ClientOrder, UserData, uiGmapGoogleMapApi) {
		$scope.order = {};

		$scope.map = $map;

		$scope.markers = [];

		$ionicLoading.show({
			template: 'Carregando...'
		});

		uiGmapGoogleMapApi.then(function(){
			$ionicLoading.hide();
		}, function() {
			$ionicLoading.hide();
		});

		ClientOrder.get({id: $stateParams.id, include: 'items,cupom'}, function(data) {
			$scope.order = data.data;
			
			if (parseInt($scope.order.status, 10) == 1) {
				initMarkers($scope.order);
			} else {
                $ionicPopup.alert({
                    title: 'Advertência',
                    template: 'Pedido não está em status de entrega',
                    buttons: [
                      {
                        text: 'Ok',
                        type: 'button-balanced'
                      }
                    ]
                });
			}
		}, function(dataError) {
			console.log('Erro:', dataError);
		});

		$scope.$watch('markers.length', function(value) {
			if (value == 2) {
				createBounds();
			}
		});

		var initMarkers = function(order) {
			var client = UserData.get().client.data;
			var address = client.zipcode + ', ' + client.address + ', ' + client.city + ' - ' + client.state;

			console.log('endreco: ', address);
			createMarkerClient(address);
			watchPositionDeliveryman(order.hash);
		};

		var createMarkerClient = function(address) {
			var geocoder = new google.maps.Geocoder();

			geocoder.geocode({
				address: address
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					var lat = results[0].geometry.location.lat();
					var lng = results[0].geometry.location.lng();

					$scope.markers.push({
						id: 'client',
						coords: {
							latitude: lat,
							longitude: lng
						},
						options: {
							title: 'Local de Entrega',
							labelContent: 'Local de Entrega',
							icon: 'http://maps.google.com/mapfiles/kml/pal3/icon56.png'
						}
					});
				} else {
	                $ionicPopup.alert({
	                    title: 'Advertência',
	                    template: 'Não foi possível localizar seu endereço',
	                    buttons: [
	                      {
	                        text: 'Ok',
	                        type: 'button-balanced'
	                      }
	                    ]
	                });
				}
			});
		};

		var watchPositionDeliveryman = function(channel) {
			var pusher = $pusher($window.client);
			var channel = pusher.subscribe(channel);

			channel.bind('CodeDelivery\\Events\\GetLocationDeliveryman', function(data) {
				console.log(data);
				var lat = data.geo.lat, lng = data.geo.lng;

				if ($scope.markers.length == 0 || $scope.markers.length == 1) {
					$scope.markers.push({
						id: 'entregador',
						coords: {
							latitude: lat,
							longitude: lng
						},
						options: {
							title: 'Entregador',
							labelContent: 'Entregador',
							icon: 'http://maps.google.com/mapfiles/kml/shapes/motorcycling.png'
						}
					});
					return;
				}

				for(var key in $scope.markers) {
					if ($scope.markers[key].id == 'entregador') {
						$scope.markers[key].coords = {
							latitude: lat,
							longitude: lng
						}
					}
				}
			});
		};

		var createBounds = function() {
			var bounds = new google.maps.LatLngBounds();
			var latlng;

			angular.forEach($scope.markers, function(value) {
				latlng = new google.maps.LatLng(Number(value.coords.latitude), Number(value.coords.longitude));

				bounds.extend(latlng);
			});

			$scope.map.bounds = {
				northeast: {
					latitude: bounds.getNorthEast().lat(),
					longitude: bounds.getNorthEast().lng()
				},
				southwest: {
					latitude: bounds.getSouthWest().lat(),
					longitude: bounds.getSouthWest().lng()
				}
			};
		};

	}])
	.controller('CvdControlDescentralize', ['$scope', '$map', function($scope, $map) {
		$scope.map = $map;
		$scope.fit = function() {
			$scope.map.fit = !$scope.map.fit;
		};
	}])
	.controller('CvdControlReload', ['$scope', '$window', '$timeout', function($scope, $window, $timeout) {
		$scope.reload = function() {
			$timeout(function() {
				$window.location.reload(true);
			}, 100);
		};
	}]);