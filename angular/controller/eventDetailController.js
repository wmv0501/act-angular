angular
    .module('mainApp')

    .controller('eventDetailCtrl', function($scope, $http, $sce, $stateParams){
        $http.get('/angular/data/eventDetail.json').success (function(data2){
        $scope.data = data2;
        });

        $scope.param1 =$stateParams.eventId;

    }).filter('trustAsResourceUrl', ['$sce', function($sce) {
           return function(val) {
               return $sce.trustAsResourceUrl(val);
           }}]);