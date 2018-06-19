define(function (require) {
    var app = require('../app');

    app.controller('HomeController', ['$scope', '$location', '$http', '$state',
            function ($scope, $location, $http, $state) {
                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.searchModel = {};

                $scope.search = function () {
                    $scope.error = '';

                    $http.post('api/search', $scope.searchModel).success(
                            function (data) {
                                if (data.count > 0) {
                                    $state.go('list', {search: JSON.stringify($scope.searchModel)});
                                }
                                //console.log(data);
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
