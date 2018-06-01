<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\helpers\ArrayHelper;

class PregMatch extends Component
{
    /**
     * 分割字母数字.
     */
    public function splitEnglishNumber($str)
    {
        $str = trim($str);
        $arr = preg_split("/([a-zA-Z]+)/", $str, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        if (isset($arr) && !empty($arr)) {
            return $arr;
        } else {
            $result = [
                'code' => 400,
                'message' => '格式不正确!',
            ];

            return $result;
        }
    }

    /**
     * 手机号.
     */
    public function phone($str)
    {
        $result = [];
        $str = trim($str);
        $match = '/^1[34578]\d{9}$/';
        if (!preg_match($match, $str)) {
            $result = ['code' => 400, 'message' => '手机号格式不正确！'];
        }

        return $result;
    }

    /**
     * 密码.
     */
    public function password($str)
    {
        $result = [];
        $str = trim($str);
        $match = '/^(?!([a-zA-Z]+|\d+)$)[a-zA-Z\d]{6,18}$/';
        if (!preg_match($match, $str)) {
            $result = ['code' => 400, 'message' => '密码必须为至少6位的数字字母组合！'];
        }

        return $result;
    }
}
