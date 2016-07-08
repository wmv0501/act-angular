angular
    .module('mainApp')

    .controller('eventCtrl', function($scope, $http, $sce,$rootScope){
        $rootScope.menu="events";
        $http.get('/angular/data/event.json').success (function(data2){
        $scope.data = data2;
        });

        $scope.clearDiv = function(index){
            return index%2 == 1;
        };
    })