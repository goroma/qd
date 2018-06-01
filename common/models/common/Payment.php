<?php

namespace common\models\common;

use Yii;
use yii\base\Model;

class Payment extends Model
{
    /**
     * 测试.
     *
     * @param int $payType 1:wechat 2:alipay
     */
    public static function getPaymentConfig($payType)
    {
        // 微信支付，必须设置时区，否则发生错误
        //date_default_timezone_set('Asia/Shanghai');
        switch ($payType) {
            case 'wx_charge':
                $wechatPay = Yii::$app->params['wechatPay'];
                $config = [
                    'app_id' => $wechatPay['app_id'],
                    'mch_id' => $wechatPay['merchant_id'],
                    'md5_key' => $wechatPay['md5_key'],
                    'notify_url' => 'http://api.blianb.com/v2/payment-notifies',

                    // 涉及资金流动时，需要提供该文件
                    'cert_path' => $wechatPay['key_path'].'/apiclient_cert.pem',
                    'key_path' => $wechatPay['key_path'].'/apiclient_key.pem',
                ];
                break;
            case 'ali_charge':
                $aliPay = Yii::$app->params['aliPay'];
                $config = [
                    //'use_sandbox' => true,// 是否使用沙盒模式
                    'partner' => $aliPay['pid'],
                    'app_id' => $aliPay['app_id'],
                    'sign_type' => 'RSA', // RSA  RSA2
                    'ali_public_key' => $aliPay['key_path'].'/alipay_public_key_rsa.pem',
                    'rsa_private_key' => $aliPay['key_path'].'/rsa_private_key.pem',
                    'limit_pay' => [
                        //'balance',// 余额
                        //'moneyFund',// 余额宝
                        //'debitCardExpress',// 	借记卡快捷
                        'creditCard', //信用卡
                        //'creditCardExpress',// 信用卡快捷
                        //'creditCardCartoon',//信用卡卡通
                        //'credit_group',// 信用支付类型（包含信用卡卡通、信用卡快捷、花呗、花呗分期）
                    ], // 用户不可用指定渠道支付当有多个渠道时用“,”分隔

                    // 与业务相关参数
                    'notify_url' => 'http://api.blianb.com/v2/payment-notifies',
                    'return_url' => 'http://blog.blianb.com/',
                    'return_raw' => false, // 在处理回调时，是否直接返回原始数据，默认为false
                ];
                break;
            default:
                $config = [];
                break;
        }

        return $config;
    }
}
