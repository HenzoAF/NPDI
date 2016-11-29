(function(){
  var app = angular.module('NPDI', ['ngRoute']);
})();
function previousSlide(){
  $('.slider').slider('prev');
}
function nextSlide(){
  $('.slider').slider('next');
}
