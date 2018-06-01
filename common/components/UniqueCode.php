<?php
namespace common\components;

use Yii;
use yii\base\Component;

class UniqueCode extends Component
{

    public function getUniqueCode()
    {
        return time().rand(1000, 9999);
    }

}
