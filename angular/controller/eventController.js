angular
    .module('mainApp')

    .controller('eventCtrl', function($scope, $http, $sce){
        $http.get('/angular/data/event.json').success (function(data2){
        $scope.data = data2;
        });

        $scope.var1 = 'var11233';

    }).filter('trustAsResourceUrl', ['$sce', function($sce) {
           return function(val) {
               return $sce.trustAsResourceUrl(val);
           }}]);