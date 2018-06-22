require.config({
    baseUrl: './',
    paths: {
        'angular': 'lib/angular/angular.min',
        'angular-ui-router': 'lib/angular-ui-router/release/angular-ui-router.min',
        'angular-async-loader': 'lib/angular-async-loader/angular-async-loader.min',
        'angular-ui-mask': 'lib/angular-ui-mask/dist/mask.min',
        'angular-cookies': 'lib/angular-cookies/angular-cookies.min',
        'angular-sanitize': 'lib/angular-sanitize/angular-sanitize.min',
        'messageformat': 'lib/messageformat',
        //'angular-translate': 'lib/angular-translate.min',
        //'angular-translate-handler-log': 'lib/angular-translate-handler-log/angular-translate-handler-log.min',
        //'angular-translate-interpolation-messageformat': 'lib/angular-translate-interpolation-messageformat/angular-translate-interpolation-messageformat.min',
        //'angular-translate-loader-static-files': 'lib/angular-translate-loader-static-files/angular-translate-loader-static-files.min',
        //'angular-translate-loader-url': 'lib/angular-translate-loader-url/angular-translate-loader-url.min',
        //'angular-translate-storage-cookie': 'lib/angular-translate-storage-cookie/angular-translate-storage-cookie.min',
        //'angular-translate-storage-local': 'lib/angular-translate-storage-local/angular-translate-storage-local.min',
        'ng-tags-input': 'lib/ng-tags-input/build/ng-tags-input.min',
        'ng-file-upload': 'lib/ng-file-upload/dist/ng-file-upload-all.min',
        'header': 'js/home/HeaderController',
        'footer': 'js/home/FooterController',
        'brand': 'js/home/BrandController',
        'ng-pagination': 'lib/ng-pagination',
    },
    shim: {
        'angular': {
            exports: 'angular'
        },
        'angular-ui-router': {
            deps: [
                'angular',
                //'angular-translate',
            ]
        },
        //'angular-translate': {
            //deps: [
                //'angular',
                ////'angular-translate-loader-static-files'
            //],
            //exports: 'angular-translate'
        //},
        //'angular-translate-loader-static-files': {
            //deps: [
                //'angular-translate',
            //],
        //},
        'angular-sanitize': {
            deps: [
                'angular',
            ],
        },
        'ng-pagination': {
            deps: [
                'angular',
            ],
        },
        //'angular-translate': {
            //deps: [
                //'angular',
                //'messageformat',
                //'angular-translate-interpolation-messageformat',
                //'angular-translate-loader-static-files',
                //'angular-translate-loader-url',
                //'angular-translate-storage-cookie',
                //'angular-translate-storage-local',
            //]
        //},
        'header': {
        },
        'footer': {
        },
        'brand': {
        },
    },
    //urlArgs: 'v=0.1',
    urlArgs: "bust=" + (new Date()).getTime()  //防止读取缓存，调试用
});

require(['angular', 'js/app-routes', 'header', 'footer', 'ng-pagination'], function (angular) {
    angular.element(document).ready(function () {
        angular.bootstrap(document, ['app']);
        angular.element(document).find('html').addClass('ng-app');
    });
});

