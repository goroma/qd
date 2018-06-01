define(function (require) {
    var app = require('../app');

    app.controller('CheckoutController', ['$scope', '$location', '$window', '$http', '$translate',
            function ($scope, $location, $window, $http, $translate) {
                var browser = {
                    versions : function() {
                        var u = navigator.userAgent, app = navigator.appVersion;
                        return {//移动终端浏览器版本信息
                            trident : u.indexOf('Trident') > -1, //IE内核
                            presto : u.indexOf('Presto') > -1, //opera内核
                            webKit : u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
                            gecko : u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                            mobile : !!u.match(/AppleWebKit.*Mobile.*/)
                            || !!u.match(/AppleWebKit/), //是否为移动终端
                            ios : !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                            android : u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                            iPhone : u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                            iPad: u.indexOf('iPad') > -1, //是否iPad
                            webApp : u.indexOf('Safari') == -1,//是否web应该程序，没有头部与底部
                            google:u.indexOf('Chrome')>-1
                        };
                    }(),
                    language : (navigator.browserLanguage || navigator.language).toLowerCase()
                }
                //document.writeln("语言版本: "+browser.language);
                //document.writeln(" 是否为移动终端: "+browser.versions.mobile);

                $http.post('wechat/we-chat/we-chat-pay-config').success(function (data) {
                    console.log(data);
                    wx.config(data.jsconfig);
                    wx.error(function(res){
                        console.log(res);
                        alert('检验失败');
                    })
                }).error(function (data) {
                    console.log(data);
                });

                $scope.payment = function (type) {

                    if ('wx_charge' == type && browser.versions.mobile) {
                        $scope.pay_type = 'wx_pub';
                    } else if ('wx_charge' == type && false == browser.versions.mobile) {
                        $scope.pay_type = 'wx_qr';
                    } else if ('ali_charge' == type && browser.versions.mobile) {
                        $scope.pay_type = 'ali_wap';
                    } else if ('ali_charge' == type && false == browser.versions.mobile) {
                        $scope.pay_type = 'ali_web';
                    } else {
                        alert('支付方式错误');
                        return false;
                    }

                    $http.post('api/payment', {'type':type, 'pay_type':$scope.pay_type}).success(function (data) {
                        console.log(data);
                        //$location.path(data).replace();
                        //return false;
                        if ('ali_wap' == $scope.pay_type) {
                            location.href=data;
                        } else if ('wx_pub' == $scope.pay_type) {
                            wx.ready(function(){
                                wx.chooseWXPay({
                                    timestamp: data.timeStamp,
                                    nonceStr: data.nonceStr,
                                    package: data.package,
                                    signType: data.signType,
                                    paySign: data.paySign, // 支付签名
                                    success: function (res) {
                                        // 支付成功后的回调函数
                                        console.log(res);
                                        alert('支付成功');
                                        //$location.path('/dashboard').replace();
                                    },
                                    fail: function(res) {
                                        alert('支付失败');
                                    },
                                    cancel: function(res) {
                                        alert('支付取消');
                                    }
                                });
                            })
                        }
                    }).error(function (data) {
                        console.log(data);
                    });
                }
            }
    ]);
});
