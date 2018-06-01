define(function (require, exports, module) {
    var angular = require('angular');
    var asyncLoader = require('angular-async-loader');
    require('angular-ui-router');

    // 翻译
    var angular_translate = require('angular-translate');

    // 文件翻译
    require('angular-translate-loader-static-files');
    
    // 翻译安全转义
    require('angular-sanitize');

    var app = angular.module('app', ['ui.router', 'pascalprecht.translate', 'ngSanitize']);

    asyncLoader.configure(app);

    module.exports = app;
});
