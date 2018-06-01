<?php

namespace console\controllers;

use yii\console\Controller;
use Faker\Factory;

/**
 * 假数据生成工具,不知是什么时候安装的.
 */
class FakerController extends Controller
{
    public function actionGo()
    {
        $faker = Factory::create();
        $faker->seed(5);
        for ($i = 0; $i < 10; ++$i) {
            echo $faker->firstName.PHP_EOL;
            echo $faker->address.PHP_EOL;
            echo $faker->lastName.PHP_EOL;
            echo $faker->email.PHP_EOL;
        }
    }
}
