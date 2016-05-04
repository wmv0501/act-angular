angular
    .module('mainApp')
    .controller('staffCtrl', function($scope, $http, $sce){
        $http.get('/angular/data/staff.json').success (function(data2){
        $scope.data = data2;
        });


    })