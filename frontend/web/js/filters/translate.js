define(function (require) {
    var angular = require('angular');
    var app = require('../app');

    app.filter("I18N", ['$translate', function($translate) {
        return function(key) {
            if(key){
                return $translate.instant(key);
            }
        };
    }]);
});
