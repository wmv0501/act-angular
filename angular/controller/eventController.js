angular
    .module('mainApp')

    .controller('eventCtrl', function($scope, $http, $sce){
        $http.get('/angular/data/event.json').success (function(data2){
        $scope.data = data2;
        });

        $scope.var1 = 1;

        $scope.clearDiv = function(index){
            return index%2 == 1;
        };


    })