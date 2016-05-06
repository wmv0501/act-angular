(function(){
    var app = angular.module('mainApp', [
        'ui.router','ngSanitize'
        ])
    .config(['$urlRouterProvider', '$stateProvider', function($urlRouterProvider, $stateProvider) {
    $urlRouterProvider.otherwise('/');
    $stateProvider
      .state('home', {
        url: '/',
        templateUrl: 'templates/home.html',
        controller:  'homeCtrl'
      })
      .state('staff', {
        url: '/staffss',
        templateUrl: 'templates/staff.html',
        controller: 'staffCtrl'
      })
      .state('enroll', {
        url: '/enroll',
        templateUrl: 'templates/enroll.html',
        controller: 'enrollCtrl'
      })
      .state('event', {
        url: '/event',
        templateUrl: 'templates/event.html',
        controller: 'eventCtrl'
      })
      .state('contact', {
        url: '/contact',
        templateUrl: 'templates/contact.html',
        controller: 'aboutCtrl'
      })
      .state('career', {
        url: '/career',
        templateUrl: 'templates/site-under-contruction.html',
        controller: 'aboutCtrl'
      })
       .state('event-detail', {
                    url: '/event-detail/:eventId',
                    templateUrl: 'templates/event-detail.html',
                    controller: 'eventDetailCtrl'
                  })



      }]).filter('trustAsResourceUrl', ['$sce', function($sce) {
                    return function(val) {
                        return $sce.trustAsResourceUrl(val);
                    }}]);


    app.controller('IndexController', function($scope){
        $scope.webapp = info;
        $scope.menu=2;

    })
    var info = {
        email: 'lqhhcs@gmail.com',
        phone: '808-623-7109'
    };


})();



