define(function (require) {
    var app = require('../app');

    app.controller('ListController', ['$scope', '$http', '$state', '$stateParams',
            function ($scope, $http, $state, $stateParams) {
                $scope.search = JSON.parse($stateParams.search);

                $scope.match_hid = '';
                $scope.count = '';
                $scope.hids = [];

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
                    var response = data.data;
                    $scope.match_hid = response.match_hid;
                    $scope.count = response.count;
                    $scope.hids = response.hids;
                }).error(function (data) {
                    $scope.count = 0;
                    $scope.error = data.message;
                });

                $scope.search = function () {
                    $scope.error = '';

                    $http.post('api/search-content', $scope.searchModel).success(function (data) {
                        //if (data.data.count > 0) {
                        console.log(data);
                        var response = data.data;
                        $scope.match_hid = response.match_hid;
                        $scope.count = response.count;
                        $scope.hids = response.hids;
                        //$state.go('list', {search: JSON.stringify($scope.searchModel)});
                        //}
                    }).error(function (data) {
                        $scope.count = 0;
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
