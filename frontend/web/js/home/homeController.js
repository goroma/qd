define(function (require) {
    var app = require('../app');

    app.controller('homeController', ['$scope', '$location', '$http', '$window', '$translate',
            function ($scope, $location, $http, $window, $translate) {
                $scope.name = 'Home of bobo';

                $scope.ua = navigator.userAgent.toLowerCase();
                if ($scope.ua.match(/MicroMessenger/i) == "micromessenger") {
                    $http.post('api/get-we-chat-web-user').success(function (data) {
                        $scope.name = data.wechatUser.name;
                        //$window.sessionStorage.access_token = data.access_token;
                        //$location.path('/dashboard').replace();
                    }).error(function (data) {
                        //angular.forEach(data, function (error) {
                        //$scope.error[error.field] = error.message;
                        //if (error.field == 'password') {
                        //$scope.error['retype_password'] = error.message;
                        //}
                        //});
                    });
                } else {
                }
            }
    ]);
});
