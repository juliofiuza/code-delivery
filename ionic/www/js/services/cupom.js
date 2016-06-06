angular.module('code-delivery.services')
	.factory('Cupom', ['$resource', 'appConfig', function($resource, appConfig) {
		return $resource(appConfig.baseUrl + '/api/cupom/:code', {code: '@code'}, {
			query: {
				isArray: false
			}
		});
	}]);