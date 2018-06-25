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

                $http.post('api/search', {type: $scope.searchModel.type.type, content: $scope.searchModel.content}).success(function (data) {
                    if (data.data.count > 0) {
                        $state.go('list', {type: $scope.searchModel.type.type, content: $scope.searchModel.content});
                    } else {
                        $scope.error = '没有搜索到相关结果';
                    }
                }).error(function (data) {
                    $scope.error = data.message;
                });
            };
        }
    ]);
});
