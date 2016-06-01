angular.module('code-delivery.controllers')
	.controller('LoginCtrl', [
	'$scope', 'OAuth', '$state', '$ionicPopup',
	function($scope, OAuth, $state, $ionicPopup) {
        $scope.user = {
        	username: '',
        	password: ''
        };

        $scope.login = function() {
        	OAuth.getAccessToken($scope.user).then( function(data) {
        		$state.go('home');
        	}, function(error) {
        		$ionicPopup.alert({
        			title: 'Advertência',
        			template: 'Login e/ou senha inválidos',
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