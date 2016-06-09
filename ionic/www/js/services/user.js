angular.module('code-delivery.services')
	.factory('User', ['$resource', 'appConfig', function($resource, appConfig) {
		return $resource(appConfig.baseUrl + '/api/user/:id', {id: '@id'}, {
			query: {
				isArray: false
			},
			authenticated: {
				method: 'GET',
				url: appConfig.baseUrl + '/api/authenticated',
				isArray: false
			}
		});
	}]);