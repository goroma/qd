<?php

namespace console\controllers;

use yii\console\Controller;
use common\models\User;

class InitController extends Controller
{
    /**
     * add user.
     */
    public function actionUser()
    {
        echo "Create new User ......\n";
        $username = $this->prompt('Input UserName: ');
        $email = $this->prompt("Input Email for $username: ");
        $password = $this->prompt("Input password for $username: ");

        $model = new User();
        $model->username = $username;
        $model->email = $email;
        $model->setPassword($password);
        $model->generateAuthKey();

        if (!$model->save()) {
            foreach ($model->getErrors() as $errors) {
                foreach ($errors as $e) {
                    echo "$e\n";
                }
            }

            return 1;
        }

        return 0;
    }
}
