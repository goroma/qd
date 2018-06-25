define(function (require) {
    var app = require('./app');

    app.run(['$state', '$stateParams', '$rootScope', function ($state, $stateParams, $rootScope) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
    }]);

    app.config(['$stateProvider', '$urlRouterProvider', '$httpProvider', '$locationProvider', function ($stateProvider, $urlRouterProvider, $httpProvider, $locationProvider) {
        $urlRouterProvider.otherwise('/home');

        $stateProvider.
            state('home', {
                url: '/home',
                templateUrl: 'templates/home/home.html',
                 // new attribute for ajax load controller
                controllerUrl: 'js/home/HomeController',
                controller: 'HomeController',
                dependencies: [
                    //'js/filters/translate',
                ]
            }).
            state('list', {
                url: '/list/:type/:content',
                templateUrl: 'templates/home/list.html',
                controllerUrl: 'js/home/ListController',
                controller: 'ListController',
                dependencies: [
                    //'lib/ng-pagination',
                ]
            }).
            state('download', {
                url: '/download/:hash',
                templateUrl: 'templates/home/download.html',
                controllerUrl: 'js/home/DownloadController',
                controller: 'DownloadController',
            }).
            state('components', {
                url: '/components',
                templateUrl: 'templates/components/components.html',
                controllerUrl: 'js/components/componentsCtrl',
                controller: 'componentsCtrl'
            });

            $httpProvider.interceptors.push('authInterceptor');

            $locationProvider.html5Mode(true);
    }]);

    app.factory('authInterceptor', function ($q, $window, $location) {
        return {
            request: function (config) {
                if ($window.sessionStorage.access_token) {
                    //HttpBearerAuth
                    config.headers.Authorization = 'Bearer ' + $window.sessionStorage.access_token;
                }
                return config;
            },
            responseError: function (rejection) {
                if (rejection.status === 401) {
                    $location.path('/login').replace();
                }
                return $q.reject(rejection);
            }
        };
    });

    //app.factory('T', ['$translate', function($translate) {
        //var T = {
            //T:function (key) {
                //if (key) {
                    //$translate(key).then(function (translatedValue) {
                        //return translatedValue;
                    //});
                //}
                //return key;
            //}
        //}
        //return T;
    //}]);
});
