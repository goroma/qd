define(function (require) {
    var app = require('../app');

    app.controller('WeChatPayController', ['$scope', '$location', '$http', '$window', '$translate',
            function ($scope, $location, $http, $window, $translate) {
                $http.post('wechat/we-chat/we-chat-pay-config').success(function (data) {
                    console.log(data);
                    //wx.config({
                        //debug: true,
                        //appId: 'wx3cf0f39249eb0e60',
                        //timestamp: 1430009304,
                        //nonceStr: 'qey94m021ik',
                        //signature: '4F76593A4245644FAE4E1BC940F6422A0C3EC03E',
                        //jsApiList: ['chooseWXPay']
                    //});
                    wx.config(data.jsconfig);
                    wx.ready(function(){
                        wx.chooseWXPay({
                            timestamp: data.payconfig.timestamp,
                            nonceStr: data.payconfig.nonceStr,
                            package: data.payconfig.package,
                            signType: data.payconfig.signType,
                            paySign: data.payconfig.paySign, // 支付签名
                            success: function (res) {
                                // 支付成功后的回调函数
                                console.log(res);
                                $location.path('/dashboard').replace();
                            }
                        });
                    })
                    wx.error(function(res){
                        console.log(res);
                    })
                }).error(function (data) {
                    console.log(data);
                });
            }
    ]);
});
