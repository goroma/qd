<?php

namespace console\controllers;

use yii;
use yii\console\Controller;
use MySQLHandler\MySQLHandler;

class MonologController extends Controller
{
    /**
     * 测试monolog记录日志.
     */
    public function actionGo()
    {
        $pdo = Yii::$app->db->getMasterPdo();

        // Create MysqlHandler
        $addColumns = [
            'user_id',
            'messages',
            'other_one',
            'other_two',
        ];
        $description = [
            'user_id' => 'INTEGER UNSIGNED NOT NULL DEFAULT 0',
            'other_one' => 'VARCHAR(32) NOT NULL DEFAULT ""',
        ];
        $mySQLHandler = new MySQLHandler($pdo, Yii::$app->db->tablePrefix.'test_log', $addColumns, \Monolog\Logger::DEBUG, true, $description);

        // Create logger
        $context = 'test';
        $logger = new \Monolog\Logger($context);
        $logger->pushHandler($mySQLHandler);

        // Now you can use the logger, and further attach additional information
        try {
            $res = $logger->addWarning('This is a great message, woohoo!', ['user_id' => 245, 'messages' => 'woohoo,cool', 'other_one' => 'yes', 'other_two' => 'no']);
            var_dump($res);
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }
}
