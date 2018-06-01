<?php
/**
 * @see http://www.yiiframework.com/
 *
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author bobo
 *
 * @since 2.0
 */
class GritterAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'lib/gritter/css/jquery.gritter.css',
    ];
    public $js = [
        'lib/gritter/js/jquery.gritter.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
