angular
    .module('mainApp')
    .controller('enrollCtrl', function($scope, $http, $sce){
        $http.get('/angular/data/enroll.json').success (function(data2){
        $scope.data = data2;
        });


    }).filter('trustAsResourceUrl', ['$sce', function($sce) {
           return function(val) {
               return $sce.trustAsResourceUrl(val);
           }}]);