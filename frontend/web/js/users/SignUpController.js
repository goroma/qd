define(function (require) {
    var app = require('../app');

    app.controller('SignUpController', ['$scope', '$http', '$window', '$location',
            function($scope, $http, $window, $location) {

                $scope.userModel = {};

                $scope.signup = function () {
                    $scope.submitted = true;

                    $scope.error = {};

                    if ($scope.userModel.username == '' || $scope.userModel.username == undefined) {
                        $scope.error.username = '用户名不能为空';
                        $scope.submitted = false;
                    }

                    if ($scope.userModel.email == '' || $scope.userModel.email == undefined) {
                        $scope.error.email = '邮箱不能为空';
                        $scope.submitted = false;
                    }

                    if ($scope.userModel.password == '' || $scope.userModel.password == undefined) {
                        $scope.error.password = '密码不能为空';
                        $scope.submitted = false;
                    }

                    if ($scope.userModel.retype_password == '' || $scope.userModel.retype_password == undefined) {
                        $scope.error.retype_password = '重复密码不能为空';
                        $scope.submitted = false;
                    }

                    if ($scope.userModel.password != $scope.userModel.retype_password) {
                        $scope.error.retype_password = '两次密码输入不一样';
                        $scope.submitted = false;
                    }
                    if ($scope.submitted == false) {
                        $scope.submitted = true;
                        return false;
                    }

                    $http.post('api/sign-up', $scope.userModel).success(
                            function (data) {
                                $window.sessionStorage.access_token = data.access_token;
                                $location.path('/dashboard').replace();
                            }).error(
                                function (data) {
                                    angular.forEach(data, function (error) {
                                        $scope.error[error.field] = error.message;
                                        if (error.field == 'password') {
                                            $scope.error['retype_password'] = error.message;
                                        }
                                    });
                                }
                            );
                };
            }
    ]);
});
