define(function (require) {
    var app = require('./app');

    app.run(['$state', '$stateParams', '$rootScope', function ($state, $stateParams, $rootScope) {
        $rootScope.$state = $state;
        $rootScope.$stateParams = $stateParams;
    }]);

    app.config(['$stateProvider', '$urlRouterProvider', '$httpProvider', function ($stateProvider, $urlRouterProvider, $httpProvider) {
        $urlRouterProvider.otherwise('/home');

        $stateProvider.
            state('home', {
                url: '/home',
                templateUrl: 'templates/home/home.html',
                 // new attribute for ajax load controller
                controllerUrl: 'js/home/homeController',
                controller: 'homeController',
                dependencies: [
                    //'js/filters/translate',
                ]
            }).
            state('users', {
                url: '/users',
                templateUrl: 'templates/users/users.html',
                controllerUrl: 'js/users/usersController',
                controller: 'usersController',
                // load more controllers, services, filters, ...
                dependencies: [
                    'js/services/usersService',
                    'js/filters/commonFilter',
                ]
            }).
            state('login', {
                url: '/login',
                templateUrl: 'templates/users/login.html',
                controllerUrl: 'js/users/LoginController',
                controller: 'LoginController',
                dependencies: [
                    //'js/filters/translate',
                ]
            }).
            state('signup', {
                url: '/signup',
                templateUrl: 'templates/users/signup.html',
                controllerUrl: 'js/users/SignUpController',
                controller: 'SignUpController'
            }).
            state('dashboard', {
                url: '/dashboard',
                templateUrl: 'templates/users/dashboard.html',
                controllerUrl: 'js/users/DashboardController',
                controller: 'DashboardController',
            }).
            state('contact', {
                url: '/contact',
                templateUrl: 'templates/users/contact.html',
                controllerUrl: 'js/users/ContactController',
                controller: 'ContactController',
            }).
            state('single', {
                url: '/single',
                templateUrl: 'templates/products/single.html',
                controllerUrl: 'js/products/SingleController',
                controller: 'SingleController',
                dependencies: [
                    'js/imagezoom',
                    'js/jquery.flexslider',
                ]
            }).
            state('product', {
                url: '/product',
                templateUrl: 'templates/products/product.html',
                controllerUrl: 'js/products/ProductController',
                controller: 'ProductController',
                dependencies: [
                ]
            }).
            state('category', {
                url: '/category',
                templateUrl: 'templates/products/category.html',
                controllerUrl: 'js/products/CategoryController',
                controller: 'CategoryController',
                dependencies: [
                ]
            }).
            state('wechat_pay', {
                url: '/wechat_pay',
                templateUrl: 'templates/products/wechat_pay.html',
                controllerUrl: 'js/products/WeChatPayController',
                controller: 'WeChatPayController',
                dependencies: [
                ]
            }).
            state('checkout', {
                url: '/checkout',
                templateUrl: 'templates/users/checkout.html',
                controllerUrl: 'js/users/CheckoutController',
                controller: 'CheckoutController',
                dependencies: [
                ]
            }).
            state('wishlist', {
                url: '/wishlist',
                templateUrl: 'templates/users/wishlist.html',
                controllerUrl: 'js/users/WishlistController',
                controller: 'WishlistController',
                dependencies: [
                ]
            }).
            state('components', {
                url: '/components',
                templateUrl: 'templates/components/components.html',
                controllerUrl: 'js/components/componentsCtrl',
                controller: 'componentsCtrl'
            });

            $httpProvider.interceptors.push('authInterceptor');

            // load 'cn' table on startup
            var lang = window.localStorage.lang || 'cn';

            // configures staticFilesLoader
            //$translateProvider.useStaticFilesLoader({
                //prefix: '/i18n/',
                //suffix: '.json'
            //});
            //$translateProvider.preferredLanguage(lang);

            // Enable escaping of HTML
            //$translateProvider.useSanitizeValueStrategy('sanitize');

            // Enable escaping of HTML
            //$translateProvider.useSanitizeValueStrategy('escape');
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
