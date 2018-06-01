<?php

namespace common\models\common;

use Yii;
use yii\base\Model;
// 引入鉴权类
use Qiniu\Auth;
// 引入上传类
use Qiniu\Storage\UploadManager;

/**
 * upload file to qiniu.
 */
class Qiniu extends Model
{
    /**
     * 上传文件到七牛.
     *
     * @param string $filePath 上传的文件路径
     * @param mix    $key      文件名称,不传默认使用文件hash值作为文件名
     */
    public static function uploadToQiniu($filePath, $key = null)
    {
        // 需要 Access Key 和 Secret Key
        $accessKey = Yii::$app->params['qiniu']['accessKey'];
        $secretKey = Yii::$app->params['qiniu']['secretKey'];

        // 构建鉴权对象
        $auth = new Auth($accessKey, $secretKey);

        // 要上传的空间
        $bucket = 'products';

        // 生成上传 Token
        $token = $auth->uploadToken($bucket);

        // 上传到七牛后保存的文件名
        //if (empty($key)) {
            //$ext = pathinfo($filePath, PATHINFO_EXTENSION);
            //$key = date('YmdHis').md5($filePath).rand(1,999);
        //}

        // 初始化 UploadManager 对象并进行文件的上传
        $uploadMgr = new UploadManager();

        // 调用 UploadManager 的 putFile 方法进行文件的上传
        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
        if ($err !== null) {
            return false;
        } else {
            return Yii::$app->params['qiniu']['image_domain'].$ret['hash'];
        }
    }
}
