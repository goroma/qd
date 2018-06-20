define(function (require) {
    var app = require('../app');

    app.controller('ListController', ['$scope', '$http', '$state', '$stateParams',
            function ($scope, $http, $state, $stateParams) {
                $scope.search = JSON.parse($stateParams.search);

                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.searchModel = {};
                $scope.searchModel.content = $scope.search.content;
                angular.forEach($scope.types, function (data) {
                    if (data.type == $scope.search.type.type) {
                        $scope.default_type = data;
                    }
                });
                $scope.searchModel.type = $scope.search.type;

                $http.post('api/search-content', $scope.searchModel).success(function (data) {
                    console.log(data);
                }).error(function (data) {
                    $scope.error = data.message;
                });

                $scope.search = function () {
                    $scope.error = '';

                    $http.post('api/search-content', $scope.searchModel).success(function (data) {
                        //if (data.data.count > 0) {
                        console.log(data);
                        //$state.go('list', {search: JSON.stringify($scope.searchModel)});
                        //}
                    }).error(function (data) {
                        $scope.error = data.message;
                    });
                };

                $scope.toDownload = function toDownload(hash) {
                    console.log('download');
                    $state.go('download', {hash: hash});
                }
            }
    ]);
});
