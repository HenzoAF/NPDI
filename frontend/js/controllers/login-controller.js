(function(){
  angular.module("NPDI").controller('loginController', ['$scope', '$location', '$http', function($scope, $location, $http) {
    $scope.go = function(path) {
      $location.path(path);
    };

    $scope.login = {};

      $scope.enviar = function() {

              console.log(JSON.stringify($scope.login));
              $scope.loginJSON = JSON.stringify($scope.login);
              $http({method: 'POST', url: '../backend/public/index.php/login', data: $scope.loginJSON}).then(function successCallback(response) {
                console.log("SUCESSO");
                if (typeof(Storage) !== "undefined") {
                  // Guardando no storage local...
                  localStorage.setItem("userID", null);
                  localStorage.setItem("userID", response.data.id);
                  // Debugando...
                  console.log(localStorage.getItem("userID"));
                  // Definindo rota por tipo de login

                } else {
                  alert("Seu navegador não suporta este website, desculpe.")
                }
              }, function errorCallback(response) {
                alert('LOGIN E SENHA INVÁLIDOS');
              });

      };


  }]);
})();
