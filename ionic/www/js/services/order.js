angular.module('code-delivery.services')
	.factory('Order', ['$resource', 'appConfig', function($resource, appConfig) {
		return $resource(appConfig.baseUrl + '/api/client/order/:id', {id: '@id'}, {
			query: {
				isArray: false
			}
		});
	}]);