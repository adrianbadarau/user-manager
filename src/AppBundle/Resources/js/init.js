var app = angular.module('App', ['ngRoute']);
//-------------------------------------------------------------------------
app.config(['$interpolateProvider', '$routeProvider', function($interpolateProvider, $routeProvider) {
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
	//-----------------------------------
	$routeProvider.when('/employees/index', {
		templateUrl: '/modules/employees-index.html',
		controller: 'employeesIndexController'
	}).when('/home/b', {
		templateUrl: '/modules/slideB.html',
		controller: 'homeSlideBController'
	}).when('/intro', {
		templateUrl: '/templates/intro.html',
		controller: 'introController'
	}).otherwise({
		redirectTo: '/employees/index'
	});
}]);
//-------------------------------------------------------------------------
app.controller('appController', ['$scope', '$location', function($scope, $location) {
	/* test */
	$scope.container = angular.element(document.querySelector('#container'));
	$scope.gotoView = function(view) {
		console.log(view);
		$location.path(view);
	};
}]);
app.controller('employeesIndexController', ['$scope','$http', function($scope, $http) {
	$scope.employees = [];
	$http.get('/api/employees').then(function (response) {
		console.log(response);
		$scope.employees = response.data;
	})
}]);
app.controller('homeSlideBController', ['$scope', function($scope) {
	$scope.subtitle = "Subtitle SlideB from Angular";
}]);
app.controller('introController', ['$scope', function($scope) {
	$scope.title = title;
	$scope.subtitle = "Text from Symfony to Angular";
	$scope.text = intro;
}]);