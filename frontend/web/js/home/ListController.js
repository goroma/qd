define(function (require) {
    var app = require('../app');

    app.controller('ListController', ['$scope', '$http', '$state', '$stateParams', '$location',
            function ($scope, $http, $state, $stateParams, $location) {
                $scope.searchModel = {};
                $scope.type = $stateParams.type;
                $scope.content = $stateParams.content;

                $scope.page_size = 20;
                $scope.match_hid = '';
                $scope.count = '';
                $scope.hids = [];

                $scope.types = [
                    {name : "硬件ID", type : 1},
                    {name : "设备名称", type : 2}
                ];
                $scope.oses = [
                    {name: 'Win7', type: 'win7'},
                    {name: 'Win10', type: 'win10'},
                    {name: 'WinXP', type: 'winxp'},
                    {name: 'Win8', type: 'win8'},
                    {name: 'Win8.1', type: 'win81'},
                    {name: 'WinVista', type: 'vista'},
                    {name: 'Win2003', type: 'win2k3'}
                ];
                $scope.pfs = [
                    {name: '64位', type: '64'},
                    {name: '32位', type: '32'}
                ];
                $scope.searchModel.os = $scope.oses[0];
                $scope.searchModel.pf = $scope.pfs[0];

                $scope.searchModel.content = $scope.content;
                angular.forEach($scope.types, function (data) {
                    if (data.type == $scope.type) {
                        $scope.default_type = data;
                    }
                });
                $scope.searchModel.type = $scope.default_type;

                $scope.myinit = function() {
                    var params = {
                        type: $scope.searchModel.type.type,
                        content: $scope.searchModel.content,
                        page_size: $scope.page_size,
                        page: 1
                    };
                    $http.post('api/search-content', params).success(function (data) {
                        var response = data.data;
                        $scope.match_hid = response.match_hid;
                        $scope.count = response.count;
                        $scope.hids = response.hids;
                        $scope.pageCount = response.page_total;

                        if ($scope.count <= 0) {
                            $scope.count = false;
                            $scope.error = '没有搜索到相关结果';
                        }
                    }).error(function (data) {
                        $scope.count = false;
                        $scope.error = data.message;
                    });
                };
                $scope.myinit();


                $scope.search = function (search_type) {
                    $scope.error = '';
                    var params = {
                        type: $scope.searchModel.type.type,
                        content: $scope.searchModel.content,
                        page_size: $scope.page_size,
                        page: 1
                    };
                    if ('os' == search_type) {
                        params.os = $scope.searchModel.os.type;
                        params.pf = $scope.searchModel.pf.type;
                    }

                    $location.url('list/'+$scope.searchModel.type.type+'/'+$scope.searchModel.content);

                    $http.post('api/search-content', params).success(function (data) {
                        var response = data.data;
                        $scope.match_hid = response.match_hid;
                        $scope.count = response.count;
                        $scope.hids = response.hids;
                        if ($scope.count <= 0) {
                            $scope.count = false;
                            $scope.error = '没有搜索到相关结果';
                        }
                    }).error(function (data) {
                        $scope.count = false;
                        $scope.error = data.message;
                    });
                };

                // 分页
                $scope.onPageChange = function() {
                    var params = {
                        type: $scope.searchModel.type.type,
                        content: $scope.searchModel.content,
                        page_size: $scope.page_size,
                        page: $scope.currentPage
                    };

                    $http.post('api/search-content', params).success(function (data) {
                        var response = data.data;
                        $scope.match_hid = response.match_hid;
                        $scope.count = response.count;
                        $scope.hids = response.hids;
                        $scope.pageCount = response.page_total;
                        if ($scope.count <= 0) {
                            $scope.count = false;
                            $scope.error = '没有搜索到相关结果';
                        }
                    }).error(function (data) {
                        $scope.count = false;
                        $scope.error = data.message;
                    });
                };

                $scope.toDownload = function toDownload(hash) {
                    $state.go('download', {hash: hash});
                }
            }
    ]);
});
