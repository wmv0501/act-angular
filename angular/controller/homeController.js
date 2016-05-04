angular
    .module('mainApp')
    .controller('homeCtrl', function($scope, $http, $sce){
        $http.get('/angular/data/home.json').success (function(data2){
        $scope.data = data2;
        });


    }).filter('trustAsResourceUrl', ['$sce', function($sce) {
           return function(val) {
               return $sce.trustAsResourceUrl(val);
           }}]);