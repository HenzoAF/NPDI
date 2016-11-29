(function(){
  angular.module("NPDI").controller('indexController', ['$scope', '$location', function($scope, $location) {
      $scope.go = function(path) {
        $location.path(path);
      };
  }]);
})();
