define(function (require) {
    var app = require('./js/app');

    app.controller('HeaderController', ['$scope', '$location', '$http', '$window',
            function ($scope, $location, $http, $window) {
                $scope.loggedIn = function() {
                    return Boolean($window.sessionStorage.access_token);
                };

                //$scope.logout = function() {
                    //delete $window.sessionStorage.access_token;
                    //$location.path('/login').replace();
                //};

                //$scope.switching = function(lang) {
                    //$translate.use(lang);
                    //window.localStorage.lang = lang;
                    //window.location.reload();
                //};

                //$scope.cur_lang = $translate.proposedLanguage();

                //$scope.login_title = T.T('Login');
                //console.log($scope.login_title);
                //$translate('Login').then(function (translatedValue) {
                    //$scope.login_title = translatedValue;
                //});
                //$translate('Register').then(function (translatedValue) {
                    //$scope.signup_title = translatedValue;
                //});
                //$translate('Logout').then(function (translatedValue) {
                    //$scope.logout_title = translatedValue;
                //});
                //$translate('Home').then(function (translatedValue) {
                    //$scope.home_title = translatedValue;
                //});

                //$http.post('product/product-category/get-product-categories').success(function (data) {
                    //console.log(data);
                    //$scope.cateData = data;
                    //$window.sessionStorage.access_token = data.access_token;
                    //$location.path('/dashboard').replace();
                //}).error(function (data) {
                    //angular.forEach(data, function (error) {
                    //$scope.error[error.field] = error.message;
                    //if (error.field == 'password') {
                    //$scope.error['retype_password'] = error.message;
                    //}
                    //});
                //});
            }
    ]);
});
