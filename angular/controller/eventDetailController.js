angular
    .module('mainApp')

    .controller('eventDetailCtrl', function($scope, $http, $sce, $stateParams, $rootScope){
        $rootScope.menu="events";
        $http.get('/angular/data/events/'+$stateParams.eventId+'.json').success (function(data2){
            $scope.data = data2;
        });
        $scope.param1=$stateParams.eventId;


    }).filter('trustAsResourceUrl', ['$sce', function($sce) {
           return function(val) {
               return $sce.trustAsResourceUrl(val);
           }}]);