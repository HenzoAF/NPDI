(function(){
  angular.module("NPDI").controller('disciplinasController', ['$scope', '$location', function($scope, $location) {
      $scope.go = function(path) {
        $location.path(path);
      };
  }]);
})();
