define(function (require) {
    var app = require('../app');

    app.controller('LoginController', ['$scope', '$http', '$window', '$location',
            function($scope, $http, $window, $location) {
                $scope.login = function () {
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
