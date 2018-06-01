define(function (require) {
    var app = require('./js/app');

    app.controller('BrandController', ['$scope', '$location', '$http', '$window', '$translate', '$translate', 'T',
            function ($scope, $location, $http, $window, $translate, $translate, T) {
                //$scope.brands = {};

                $http.get('product/product-brand/get-product-brands').success(function (data) {
                    $scope.brands = data;
                }).error( function (data) {
                });
            }

    ]);
});
