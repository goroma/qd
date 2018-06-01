<?php

namespace common\models\common;

use yii\base\Model;

class DLog extends Model
{
    public static function writeErr($content, $name)
    {
        self::write($content, 'err', $name);
    }

    public static function writeLog($content, $name)
    {
        self::write($content, 'app', $name);
    }

    public static function writeTmp($content, $name)
    {
        self::write($content, 'tmp', $name);
    }

    private static function write($content, $type, $name)
    {
        if ($content) {
            $microsecond = str_pad(floor(microtime() * 1000), 3, 0, STR_PAD_LEFT);
            $content = date('Y-m-d H:i:s ', time()).$microsecond."\n".$content;
            error_log($content."\n\x03\n", 3, '/log/'.$type.'/'.$name.'.log');
        }
    }
}
