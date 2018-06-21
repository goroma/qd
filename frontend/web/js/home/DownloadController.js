define(function (require) {
    var app = require('../app');

    app.controller('DownloadController', ['$scope', '$http', '$stateParams', '$state',
            function ($scope, $http, $stateParams, $state) {
                $scope.hash = $stateParams.hash;
                $scope.searchModel = {};
                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.count = '';
                $scope.driver = {};

                $http.post('api/search-hash', {'hash': $scope.hash}).success(function (data) {
                    $scope.driver = data.data;
                    $scope.count = true;
                }).error(function (data) {
                    $scope.count = 0;
                    $scope.error = data.message;
                });

                $scope.search = function () {
                    $scope.error = '';

                    $http.post('api/search', $scope.searchModel).success(function (data) {
                        if (data.data.count > 0) {
                            $state.go('list', {search: JSON.stringify($scope.searchModel)});
                        } else {
                            $scope.error = '没有搜索到相关结果';
                            $scope.count = 0;
                        }
                    }).error(function (data) {
                        $scope.error = data.message;
                    });
                };
            }
    ]);
});
