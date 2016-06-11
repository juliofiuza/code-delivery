angular.module('code-delivery.controllers')
	.controller('LoginCtrl', [
	'$scope', 'OAuth', 'OAuthToken', '$state', '$ionicPopup', 'UserData', 'User',
	function($scope, OAuth, OAuthToken, $state, $ionicPopup, UserData, User) {
        $scope.user = {
        	username: '',
        	password: ''
        };

        $scope.login = function() {
        	var promise = OAuth.getAccessToken($scope.user);

            promise.then( function(data) {
        		return User.authenticated({include: 'client'}).$promise;
        	})
            .then(function (data) {
                UserData.set(data.data);
                if (data.data.role == 'client') {
                    $state.go('client.home');
                } else {
                    $state.go('deliveryman.home');
                }
            }, function(error) {
                console.log(error);
                UserData.set(null);
                OAuthToken.removeToken();
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