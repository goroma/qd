<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\candy\Star;

class TestController extends Controller
{
    /**
     * 测试用例.
     */
    public function actionGo()
    {
        Star::query();
    }
}
