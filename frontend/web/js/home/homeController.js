define(function (require) {
    var app = require('../app');

    app.controller('homeController', ['$scope', '$location', '$http', '$window',
            function ($scope, $location, $http, $window) {
                $scope.name = 'Home of bobo';
                $scope.login = function () {
                    console.log('aaa');
                    return false;
                    $scope.submitted = true;

                    $scope.error = {};
                    $http.post('api/login', $scope.userModel).success(
                            function (data) {
                                $window.sessionStorage.access_token = data.access_token;
                                $location.path('/dashboard').replace();
                            }).error(
                                function (data) {
                                    angular.forEach(data, function (error) {
                                        $scope.error[error.field] = error.message;
                                    });
                                }
                            );
                };

            }
    ]);
});
