(function(){
angular.module("NPDI").config(['$routeProvider', function($routeProvider){
  $routeProvider
    .when('/', {
        templateUrl: 'templates/home.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/sobre', {
        templateUrl: 'templates/sobre.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/projetos', {
        templateUrl: 'templates/projetos.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/disciplinas', {
        templateUrl: 'templates/disciplinas.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/galeria', {
        templateUrl: 'templates/galeria.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/links', {
        templateUrl: 'templates/links.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/login', {
        templateUrl: 'templates/login.html',
        controller: 'loginController',
        controllerAs: 'loginCtrl'
    })
    .when('/novaPostagem', {
        templateUrl: 'templates/novaPostagem.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
    .when('/parceirias', {
        templateUrl: 'templates/parceirias.html',
        controller: 'blankController',
        controllerAs: 'blankCtrl'
    })
  .otherwise({redirectTo: '/'});
}]);
})();
