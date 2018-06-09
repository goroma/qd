define(function (require) {
    var app = require('./js/app');

    app.controller('BrandController', ['$scope', '$location', '$http', '$window',
            function ($scope, $location, $http, $window) {
                //$scope.brands = {};

                //$http.get('product/product-brand/get-product-brands').success(function (data) {
                    //$scope.brands = data;
                //}).error( function (data) {
                //});
            }

    ]);
});
