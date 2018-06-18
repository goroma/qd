define(function (require) {
    var app = require('../app');

    app.controller('HomeController', ['$scope', '$location', '$http', '$window',
            function ($scope, $location, $http, $window) {
                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.searchModel = {};

                $scope.search = function () {
                    $scope.error = '';

                    $http.post('api/search', $scope.searchModel).success(
                    //$http.post('api/login', $scope.searchModel).success(
                            function (data) {
                                console.log(data);
                                //$window.sessionStorage.access_token = data.access_token;
                                //$location.path('/list').replace();
                            }).error(
                                function (data) {
                                    $scope.error = data.message;
                                }
                            );
                };

            }
    ]);
});
