<?php

namespace backend\models\driver;

use Yii;

class DriverOs extends \common\models\DriverOs
{
    // 以下三个是在包管理选择文件导入使用
    public static $all_32_pf = [
        'win10' => 32,
        'win81' => 32,
        'win8' => 32,
        'win7' => 32,
        'winxp' => 32,
        'vista' => 32,
        'win2k3' => 32,
    ];
    public static $all_64_pf = [
        'win10' => 64,
        'win81' => 64,
        'win8' => 64,
        'win7' => 64,
        'winxp' => 64,
        'vista' => 64,
        'win2k3' => 64,
    ];
    public static $all_os = [
        'win10' => 'win10',
        'win81' => 'win81',
        'win8' => 'win8',
        'win7' => 'win7',
        'winxp' => 'winxp',
        'vista' => 'vista',
        'win2k3' => 'win2k3',
    ];
    public static $all_os_select = [
        '1' => 'all',
        '2' => 'all-32',
        '3' => 'all-64',

        '4' => 'win10-32',
        '5' => 'win81-32',
        '6' => 'win8-32',
        '7' => 'win7-32',
        '8' => 'winxp-32',
        '9' => 'vista-32',
        '10' => 'win2k3-32',

        '11' => 'win10-64',
        '12' => 'win81-64',
        '13' => 'win8-64',
        '14' => 'win7-64',
        '15' => 'winxp-64',
        '16' => 'vista-64',
        '17' => 'win2k3-64',
    ];

    // 以下为包编辑页面使用

    public function insertData(Driver $driver, $data)
    {
        if (isset($data['qd_os']) && ($os = strtolower($data['qd_os']))) {
            $qd_osz = explode(',', $data['qd_os']);
            foreach ($qd_osz as $os) {
                $os = strtolower(trim($os));
                if ($os) {
                    if ('all' == $os || 'allx86' == $os || 'allx64' == $os) {
                        $this->insertAllXPf($driver, $os);
                        continue;
                    }
                    $driver_os = new DriverOs;
                    $driver_os->driver_id = $driver->id;
                    $os_array = explode(' ', $os);
                    if (isset($os_array[0]) && $os_array[0]) {
                        $driver_os->qd_os = strtolower($os_array[0]);
                    }

                    if (isset($os_array[1]) && $os_array[1]) {
                        $driver_os->qd_pf = $this->strint($os_array[1]);
                    }
                    $driver_os->save();
                }
            }
        }

        return true;
    }

    public function insertAllXPf(Driver $driver, $type)
    {
        $values = '';
        $table_name = self::tableName();
        $date_time = date('Y-m-d H:i:s');
        $insert_sql = "INSERT INTO {$table_name} (driver_id, qd_pf, qd_os, created_at, updated_at) VALUES ";

        if ('all' == $type) {
            foreach (self::$all_32_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }
            foreach (self::$all_64_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }

            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        if ('allx64' == $type) {
            foreach (self::$all_64_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }

            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        if ('allx86' == $type) {
            foreach (self::$all_32_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }

            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        return true;
    }

    public function strint($str)
    {
        if ($str) {
            preg_match("/\d+/is", $str, $v);
        }
        $str_int = @$v[0];
        if ($str_int) {
            return $str_int;
        } else {
            return $str;
        }
    }

    public static function delOsByDriver(Driver $driver)
    {
        self::deleteAll(['driver_id' => $driver->id]);
    }

    public function saveOs(Driver $driver)
    {
        $options = self::$all_os_select;
        $selects = array_map(function ($option) use ($options) {
            return $options[$option];
        }, $driver->driver_os);

        if (in_array('all', $selects)) {
            $this->insertAllXPf($driver, 'all');
            return true;
        }

        if (in_array('all-32', $selects)) {
            $this->insertAllXPf($driver, 'allx86');
        } else {
            foreach ($selects as $select) {
                if (strpos($select, '32') !== false) {
                    $driver_os = new DriverOs;
                    $driver_os->driver_id = $driver->id;
                    $os_array = explode('-', $select);
                    if (isset($os_array[0]) && $os_array[0]) {
                        $driver_os->qd_os = strtolower($os_array[0]);
                    }

                    if (isset($os_array[1]) && $os_array[1]) {
                        $driver_os->qd_pf = trim($os_array[1]);
                    }
                    $driver_os->save();
                }
            }
        }

        if (in_array('all-64', $selects)) {
            $this->insertAllXPf($driver, 'allx64');
        } else {
            foreach ($selects as $select) {
                if (strpos($select, '64') !== false) {
                    $driver_os = new DriverOs;
                    $driver_os->driver_id = $driver->id;
                    $os_array = explode('-', $select);
                    if (isset($os_array[0]) && $os_array[0]) {
                        $driver_os->qd_os = strtolower($os_array[0]);
                    }

                    if (isset($os_array[1]) && $os_array[1]) {
                        $driver_os->qd_pf = trim($os_array[1]);
                    }
                    $driver_os->save();
                }
            }
        }
    }
}
