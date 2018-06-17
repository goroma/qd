define(function (require) {
    var app = require('../app');

    app.controller('DashboardController', ['$scope', '$http',
            function ($scope, $http) {
                $http.get('api/dashboard').success(function (data) {
                    $scope.dashboard = data;
                })
            }
    ]);
});
