define(function (require) {
    var app = require('../app');

    app.controller('ListController', ['$scope', '$http', '$state',
            function ($scope, $http, $state) {
                console.log('detail');
                //$http.get('api/dashboard').success(function (data) {
                    //$scope.dashboard = data;
                //})

                $scope.toDownload = function toDownload(hash) {
                    console.log('download');
                    $state.go('download', {hash: hash});
                }
            }
    ]);
});
