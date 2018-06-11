<?php

namespace backend\models\driver;

use Yii;

class InfHid extends \common\models\InfHid
{
    public function insertData(Driver $driver, Inf $inf, $hids)
    {
        $table_name = self::tableName();
        $date_time = date('Y-m-d H:i:s');
        $nums = count($hids);
        $limit = 1000;
        if ($nums > $limit) {
            $hids_array = array_chunk($hids, $limit, true);
            foreach ($hids_array as $hids) {
                $values = '';
                $insert_sql = "INSERT INTO {$table_name} (driver_id, inf_id, hid_name, hid, created_at, updated_at) VALUES ";
                foreach ($hids as $hid => $hid_name) {
                    $hid = addcslashes($hid, "\\");
                    $values .= "({$driver->id}, {$inf->id}, '{$hid_name}', '{$hid}', '{$date_time}', '{$date_time}'),";
                }
                if ($values) {
                    $insert_sql .= trim($values, ',');
                    Yii::$app->db->createCommand($insert_sql)->execute();
                }
            }
        } else {
            $values = '';
            $insert_sql = "INSERT INTO {$table_name} (driver_id, inf_id, hid_name, hid, created_at, updated_at) VALUES ";
            foreach ($hids as $hid => $hid_name) {
                $hid = addcslashes($hid, "\\");
                $values .= "({$driver->id}, {$inf->id}, '{$hid_name}', '{$hid}', '{$date_time}', '{$date_time}'),";
            }
            if ($values) {
                $insert_sql .= trim($values, ',');
                Yii::$app->db->createCommand($insert_sql)->execute();
            }
        }

        return true;
    }
}
