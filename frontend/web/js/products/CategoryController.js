define(function (require) {
    var app = require('../app');

    app.controller('CategoryController', ['$scope', '$location', '$http', '$window', '$translate',
            function ($scope, $location, $http, $window, $translate) {
                $scope.cat = {};
                $scope.cat.catId = $location.search().catId;
                $scope.cat.subcatId = $location.search().subcatId;
                $scope.cat.thirdcatId = $location.search().thirdcatId;

                //console.log($scope.cat);
                if ($scope.cat.catId) {
                    $http.post('product/product/get-products', $scope.cat).success(function (data) {
                        console.log(data);
                    }).error(function (data) {
                        console.log(data);
                    });
                }
            }
    ]);
});
