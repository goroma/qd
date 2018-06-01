<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\httpclient\Client;
use common\models\common\Common;
use common\models\common\PregMatch;
use common\models\common\Qiniu;
use common\models\common\YsSDK;
use backend\models\product\ProductBrand;
use backend\models\product\ProductCategory;
// wehcat
use common\models\common\WeChat;
use backend\models\wechat\WeChatUser;
use backend\models\wechat\WeChatAccount;
use common\models\wechat\WeChatCommunicationVoice;
// 引入鉴权类

// 引入上传类

// 中间表via contect
use backend\models\product\Product;
// payment SDK
use Payment\Config;
use Payment\ChargeContext;
use Payment\Common\PayException;
use common\models\common\Payment;
// 二维码生成
use dosamigos\qrcode\QrCode;
// 发送短信
use common\models\common\SendMessage;

/**
 * test controller.
 */
class TestController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 可以把接收到的信息发给指定的人.
     */
    public function actionReceive()
    {
        $openId = 'opIwTxIjBqTgg03fDsPWrQy6i9Vo';
        $message = '测试成功';
        $content = json_encode(['code' => 200, 'message' => $message, 'msgType' => 0]);
        $data = ['userId' => $openId, 'message' => $content];
        $dataProvider = Yii::$app->websocket->send(json_encode($data));

        // userId是指打开页面时登录的用户id， 哈哈，终于测试成功
        //$data = ['userId' => 1, 'message' => 'test haha !'];
        //$dataProvider = Yii::$app->websocket->send(json_encode($data));
    }

    /**
     * 测试邮件发送服务,已经可以发送，但不能发送html格式文本.
     */
    public function actionMail()
    {
        $toUser = 'wanlianbo@gdmbest.com';
        $subject = 'this is a test';
        $textBody = 'Hello world hahahaah!!';
        //$htmlBody = '<a href="http://www.tiantian8.com">请查看官网</a>';
        $htmlBody = '<br>html body';

        $mail = Yii::$app->mailer->compose();
        $mail->setTo($toUser)
            ->setSubject($subject)
            ->setTextBody($textBody);
            //->setHtmlBody($htmlBody);
        if ($mail->send()) {
            echo 'success';
        } else {
            echo 'fail';
        }
    }

    public function actionYun()
    {
        $content = Common::getFromTencentYun();

        //ExpressImage::saveExpressImage($content['files']);

        //Common::updateTencentYunFile($content['update']['files']);
        //Common::updateTencentYunFile($content['update']['dirs']);

        echo '<pre>';
        print_r($content);
    }

    public function actionPreg()
    {
        //$str = 'ems1234234';
        $str = 'shunfeng1234234';
        $arr = PregMatch::splitEnglishNumber($str);
        echo '<pre>';
        print_r($arr);
    }

    public function actionAddData()
    {
        return false;

        // 测试时需要修改getAllAgencyShop方法
        $result = AgencyShop::getAllAgencyShop();
        foreach ($result as $key => $value) {
            unset($result[$key]['id']);
            $result[$key]['vehicle_id'] = 3;
            $result[$key]['shop_name'] .= '（迅捷）';
        }

        Yii::$app->db->createCommand()->batchInsert(AgencyShop::tableName(), ['league_id', 'vehicle_id',  'shop_name', 'contacts', 'call', 'email', 'zipcode', 'class_a_price', 'class_b_price', 'milk_price', 'sales_staff_id', 'province_id', 'city_id', 'county_id', 'detail_address', 'status', 'is_signing', 'check_status', 'is_show', 'latitude', 'longitude', 'geohash', 'created_at', 'updated_at', 'is_del'], $result)->execute(); //批量插入
        echo '<pre>';
        print_r($result);
    }

    public function actionXunjie()
    {
        return false;
        $data = file_get_contents('uploads/xunjieexpressnumber.txt');
        $data = explode(',', $data);
        $saves = [];
        foreach ($data as $key => $val) {
            $saves[$key]['xunjie_express_number'] = trim($val);
            $saves[$key]['created_at'] = date('Y-m-d H:i:s');
            $saves[$key]['updated_at'] = date('Y-m-d H:i:s');
            $saves[$key]['is_del'] = 0;
        }
        //echo '<pre>';
        //print_r($saves);
        //die;

        Yii::$app->db->createCommand()->batchInsert(XunjieExpressNumber::tableName(), ['xunjie_express_number', 'created_at', 'updated_at', 'is_del'], $saves)->execute(); //批量插入
        //echo '<pre>';
        //print_r($result);
    }

    public function actionTestIndex()
    {
        $array = [
            ['suppler_id' => '123', 'data' => 'abc'],
            ['suppler_id' => '123', 'data' => 'bobo'],
            ['suppler_id' => '345', 'data' => 'def'],
            ['suppler_id' => '345', 'data' => 'guangli'],
        ];

        //$result = ArrayHelper::getValue($array, 'id');

        $result = [];
        foreach ($array as $element) {
            //$value = ArrayHelper::getValue($element, 'suppler_id');
            //$result[$value][] = $element;
            $result[$element['suppler_id']][] = $element;
        }

        //$result = ArrayHelper::index($array, 'id');
        echo '<pre>';
        //print_r($array);
        print_r($result);
    }

    public function actionQiniu()
    {
        // 要上传文件的本地路径
        //$filePath = '/home/sting/Documents/webwxgetmsgimg.jpg';
        //$filePath = '/usr/share/nginx/html/travel/frontend/web/images/ic3.png';
        $filePath = '/tmp/gogo.mp3';

        // 上传到七牛后保存的文件名
        //$key = 'frontend_idcardss.jpg';
        $key = null;
        /*
         *Array
         *(
         *    [0] => Array
         *    (
         *        [hash] => Fi-SSfROKjBeuoHjWhShAOLTPpFR
         *        [key] => frontend_idcardsss.jpg
         *    )
         *
         *    [1] =>
         *)
         */
        $result = Qiniu::uploadToQiniu($filePath);
        echo '<pre>';
        print_r($result);
    }

    public function actionBrand()
    {
        echo '<pre>';
        //$res = ProductBrand::getBrand();
        $res = ProductBrand::getBrandCategories();
        print_r($res);
    }

    public function actionCategory()
    {
        echo '<pre>';
        $res = ProductCategory::getLevelFormatCates();
        print_r($res);
    }

    public function actionWechatUser()
    {
        $lists = WeChatUser::getWeChatUserLists();

        //$lists = [
            //'oI9O5uGL2LZwVk5K54oArdAGz52Y',
            //'oI9O5uPShVRIBq_WHoaKIPQNRKNQ',
            //'oI9O5uA8fSlNFprpdfNsngBl64Ow',
        //];

        echo '<pre>';
        print_r($lists->data['openid']);
        die;
        $userList = array_chunk($lists->data['openid'], 100);

        foreach ($userList as $chunkUserList) {
            $info = WeChatUser::getWeChatUserInfo($chunkUserList);

            $result = WeChatUser::saveWeChatUserInfo($info);
            //var_dump($result);
        }

        //$info = WeChatUser::getWeChatUserInfo($lists->data['openid']);
        //print_r($info);
        die;
        //var_dump($info);
        //die;
        //foreach ($info['user_info_list'] as $value) {
            //var_dump($value->nickname);
            //var_dump($value);
        //}
        //var_dump($info->user_info_list);

        $result = WeChatUser::saveWeChatUserInfo($info);
        var_dump($result);
    }

    public function actionGetLocalWechatUser()
    {
        $lists = [
            'oI9O5uGL2LZwVk5K54oArdAGz52Y',
            //'oI9O5uPShVRIBq_WHoaKIPQNRKNQ',
            //'oI9O5uA8fSlNFprpdfNsngBl64Ow',
        ];

        $userInfo = WeChatUser::getLocalWeChatUserInfo($lists);

        echo '<pre>';
        print_r($userInfo);
    }

    /**
     * 获取微信语音.
     */
    public function actionGetWechatVoice()
    {
        $accountId = 1;
        $account = WeChatAccount::getWeChatAccount($accountId);
        $mediaId = 'EKZS0xraEjqkebHt33o2Qj0tssGu8KivCRcsK0kugx_vCt5tccUQarhgZOoOxqDm';
        $result = WeChatCommunicationVoice::getWeChatCommunicationVoiceToLocal($account, $mediaId, 'amr');

        echo '<pre>';
        var_dump($result);
    }

    /**
     * 获取登录用户信息.
     */
    public function actionGetLoginUserInfo()
    {
        $result = Yii::$app->User->identity;
        //$result = Yii::$app->User->getId();

        echo '<pre>';
        var_dump($result);
    }

    /**
     * 测试微信自定义菜单.
     */
    public function actionWeChatMenu()
    {
        $account = WeChatAccount::getWeChatAccount(WeChatAccount::getCurrentWeChatAccount());
        $menu = WeChat::getWeChatApp($account)->menu;
        echo '<pre>';
        try {
            //$menus = $menu->all();
            $menus = $menu->current();
            print_r($menus);
        } catch (\Exception $e) {
            //print_r($e->getMessage());
            print_r($e->getCode());
        }
    }

    /**
     * 测试via中间关联功能.
     */
    public function actionTestVia()
    {
        $out = [];
        $product = Product::findOne(4);

        $skus = $product->skuValues;

        foreach ($skus as $k => $skuValue) {
            $out[$k]['id'] = $skuValue->id;
            $out[$k]['name'] = $skuValue->sku_value_name;
        }

        echo '<pre>';
        //print_r($product);
        //print_r($skus);
        print_r($out);
        die;
    }

    public function actionOrder()
    {
        $config = Payment::getPaymentConfig(2);
        //echo '<pre>';
        //print_r($config);
        //die;

        // 订单数组
        $order_id = date('Ymdhis', time()).substr(floor(microtime() * 1000), 0, 1).rand(0, 9);
        $orderData = [
            'order_no' => $order_id,
            'amount' => '0.01', // 单位为元 ,最小为0.01
            'client_ip' => '127.0.0.1',
            'subject' => '测试支付',
            'body' => '支付接口测试',
            'timeout_express' => time() + 600,
            //"show_url"  => 'http://mall.tiyushe.com/goods/23.html',
        ];

        // 实例化环境类
        $charge = new ChargeContext();

        try {
            // 支付宝即时到帐接口
            //$type = Config::ALI_CHANNEL_WEB;

            // 支付宝 手机网站支接口
            $type = Config::ALI_CHANNEL_WAP;

            // 支付宝 移动支付接口
            //$type = Config::ALI_CHANNEL_APP;

            // 微信 扫码支付
            //$type = Config::WX_CHANNEL_QR;
            // 微信扫码支付，需要设置的参数
            $orderData['product_id'] = '123456';

            // 微信 APP支付
            //$type = Config::WX_CHANNEL_APP;

            // 微信 公众号支付
            //$type = Config::WX_CHANNEL_PUB;
            // 微信公众号支付，需要的参数
            // 需要通过微信提供的api获取该openid
            $orderData['openid'] = 'ofTN_wajIjD_cbPl8G14YSTOSNxE';

            $charge->initCharge($type, $config);
            $ret = $charge->charge($orderData);
        } catch (PayException $e) {
            echo $e->errorMessage();
            exit;
        }

        if ($type === Config::ALI_CHANNEL_APP) {
            var_dump($ret);
        } elseif ($type === Config::WX_CHANNEL_QR) {
            $url = urlencode($ret);
            echo "<img alt='扫码支付' src='http://paysdk.weixin.qq.com/example/qrcode.php?data={$url}' style='width:150px;height:150px;'/>";
        } elseif ($type === Config::WX_CHANNEL_PUB) {
            $json = $ret;
            var_dump($json);
            exit;
        } elseif (stripos($type, 'wx') !== false) {
            var_dump($ret);
        } else {
            // 跳转支付宝
            header("Location:{$ret}");
        }
        die;
    }

    public function actionQrcode()
    {
        $request = Yii::$app->request;
        $host = $request->hostInfo;
        echo $host;
        die;
        $text = 'http://www.baidu.com';
        $result = QrCode::png($text, '/tmp/'.time().'.png');
        print_r($result);
        die;
    }

    public function actionHttpclient()
    {
        $ys = new YsSDK();
        $deviceSerial = '758197469';
        $validateCode = 'SBBQDC';
        //$result = $ys->getAccessToken();
        $result = $ys->addDevice($deviceSerial, $validateCode);
        //$result = $ys->deleteDevice('427734222');
        //$result = $ys->deviceCapture($deviceSerial, 1);
        //$result = $ys->modifyDeviceName('427734222', 'bbb');
        //$result = $ys->getVideoAddress($deviceSerial, 1);
        //$result = $ys->openVideo('427734222:1');

        echo '<pre>';
        print_r($result);
        //$url = 'https://open.ys7.com/api/lapp/token/get';
        //$camera = Yii::$app->params['camera'];
        //$data = [
            //'appKey' => $camera['appKey'],
            //'appSecret' => $camera['appSecret']
        //];
        //$client = new Client;

        //$response = $client->post($url, $data)->send();
        //if ($response->isOk) {
            //echo '<pre>';
            //print_r($response->data);
        //}
        die;
    }

    public function actionSms()
    {
        $mobile = '17600113608';
        $message = '你好，这是一个测试';

        $sms = new SendMessage();
        $result = $sms->sendMessage($mobile, $message);

        echo '<pre>';
        print_r($result);
        print_r($result->content);
        die;
    }
}
