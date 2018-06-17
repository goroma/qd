define(function (require) {
    var app = require('../app');

    app.controller('DownloadController', ['$scope', '$http', '$stateParams',
            function ($scope, $http, $stateParams) {
                $scope.hash = $stateParams.hash;
                console.log($scope.hash);
                //$http.get('api/dashboard').success(function (data) {
                    //$scope.dashboard = data;
                //})
            }
    ]);
});
