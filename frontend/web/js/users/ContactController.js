define(function (require) {
    var app = require('../app');

    app.controller('ContactController', ['$scope', '$http', '$window',
            function($scope, $http, $window) {
                $scope.captchaUrl = 'site/captcha';
                $scope.contact = function () {
                    $scope.submitted = true;
                    $scope.error = {};
                    $http.post('api/contact', $scope.contactModel).success(
                            function (data) {
                                $scope.contactModel = {};
                                $scope.flash = data.flash;
                                $window.scrollTo(0,0);
                                $scope.submitted = false;
                                $scope.captchaUrl = 'site/captcha' + '?' + new Date().getTime();
                            }).error(
                                function (data) {
                                    angular.forEach(data, function (error) {
                                        $scope.error[error.field] = error.message;
                                    });
                                }
                            );
                };

                $scope.refreshCaptcha = function() {
                    $http.get('site/captcha?refresh=1').success(function(data) {
                        $scope.captchaUrl = data.url;
                    });
                };
            }
    ]);
});
