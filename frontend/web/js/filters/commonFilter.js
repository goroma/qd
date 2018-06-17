define(function (require) {
    var angular = require('angular');
    var app = require('../app');

    app.filter('test', function () {
        return function (input) {
            if (input == 'admin') {
                return input + ',你是管理员哟';
            }
        }
    })
});
