<?php

namespace common\models\common;

use yii\base\Model;

/**
 * preg_match model class.
 */
class PregMatch extends Model
{
    /**
     * 分割字母数字.
     */
    public static function splitEnglishNumber($str)
    {
        $str = trim($str);
        $arr = preg_split('/([a-zA-Z]+)/', $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        if (isset($arr) && !empty($arr)) {
            return $arr;
        } else {
            return false;
        }
    }
}
