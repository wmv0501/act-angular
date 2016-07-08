angular
    .module('mainApp')
    .controller('staffCtrl', function($scope, $http, $sce, $rootScope){
        $rootScope.menu="staff";
        $http.get('/angular/data/staff.json').success (function(data2){
        $scope.data = data2;
        });
    })