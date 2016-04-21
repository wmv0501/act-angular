angular
    .module('mainApp')
    .controller('homeCtrl', function($scope, $http){
        $http.get('/angular/data/home.json').success (function(data2){
        $scope.data = data2;
        });
    });