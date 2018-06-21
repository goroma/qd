define(function (require) {
    var app = require('../app');

    app.controller('ListController', ['$scope', '$http', '$state', '$stateParams', '$location',
            function ($scope, $http, $state, $stateParams, $location) {
                $scope.type = $stateParams.type;
                $scope.content = $stateParams.content;
                console.log($stateParams.type);

                $scope.match_hid = '';
                $scope.count = '';
                $scope.hids = [];

                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.searchModel = {};
                $scope.searchModel.content = $scope.content;
                angular.forEach($scope.types, function (data) {
                    if (data.type == $scope.type) {
                        $scope.default_type = data;
                    }
                });
                $scope.searchModel.type = $scope.default_type;

                $http.post('api/search-content', {type: $scope.type, content: $scope.content}).success(function (data) {
                    console.log(data);
                    var response = data.data;
                    $scope.match_hid = response.match_hid;
                    $scope.count = response.count;
                    $scope.hids = response.hids;
                    if ($scope.count <= 0) {
                        $scope.error = '没有搜索到相关结果';
                    }
                }).error(function (data) {
                    $scope.count = 0;
                    $scope.error = data.message;
                });

                $scope.search = function () {
                    $scope.error = '';

                    $location.url('list/'+$scope.searchModel.type.type+'/'+$scope.searchModel.content);

                    $http.post('api/search-content', {type: $scope.searchModel.type.type, content: $scope.searchModel.content}).success(function (data) {
                        console.log(data);
                        var response = data.data;
                        $scope.match_hid = response.match_hid;
                        $scope.count = response.count;
                        $scope.hids = response.hids;
                        if ($scope.count <= 0) {
                            $scope.count = false;
                            $scope.error = '没有搜索到相关结果';
                        }
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
