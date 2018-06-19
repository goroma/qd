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
                        if (data.data.count > 0) {
                            console.log(data);
                            $state.go('list', {search: JSON.stringify($scope.searchModel)});
                        }
                    }).error(
                        function (data) {
                            $scope.error = data.message;
                        }
                    );
            };

        }
    ]);
});
