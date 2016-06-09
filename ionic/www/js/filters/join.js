angular.module('code-delivery.filters')
	.filter('join', function() {
		return function(input, joinStr) {
			return input.join(joinStr);
		};
	});