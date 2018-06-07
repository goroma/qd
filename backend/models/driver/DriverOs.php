<?php

namespace backend\models\driver;

use Yii;

class DriverOs extends \common\models\DriverOs
{
    public $all_32_pf = [
        'win10' => 32,
        'win81' => 32,
        'win8' => 32,
        'win7' => 32,
        'winxp' => 32,
        'vista' => 32,
        'win2k3' => 32,
    ];

    public $all_64_pf = [
        'win10' => 64,
        'win81' => 64,
        'win8' => 64,
        'win7' => 64,
        'winxp' => 64,
        'vista' => 64,
        'win2k3' => 64,
    ];

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
            foreach ($this->all_32_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }
            foreach ($this->all_64_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }

            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        if ('allx64' == $type) {
            foreach ($this->all_64_pf as $os => $pf) {
                $values .= "({$driver->id}, '{$pf}', '{$os}', '{$date_time}', '{$date_time}'),";
            }

            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        if ('allx86' == $type) {
            foreach ($this->all_32_pf as $os => $pf) {
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
}
