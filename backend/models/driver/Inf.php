<?php

namespace backend\models\driver;

class Inf extends \common\models\Inf
{
    public function insertData(Driver $driver, $data)
    {
        if (isset($data['infs'])) {
            foreach ($data['infs'] as $inf) {
                if (isset($inf['version_info']) && ($version = $inf['version_info'])) {
                    $inf_model = new Inf;
                    $inf_model->driver_id = $driver->id;
                    $inf_model->class = isset($version['class']) ? $version['class'] : '';
                    $inf_model->driver_provider = isset($version['provider']) ? $version['provider'] : '';
                    if (isset($version['driverver'])) {
                        $version_array = explode(',', $version['driverver']);
                        if (isset($version_array[0])) {
                            $inf_model->driver_original_pubtime = trim($version_array[0]);
                            $inf_model->driver_pubtime = $this->formatDate(trim($version_array[0]));
                        }
                        if (isset($version_array[1])) {
                            $inf_model->driver_ver = trim($version_array[1]);
                        }
                    }

                    if (isset($inf['baseinfo']) && ($baseinfo = $inf['baseinfo'])) {
                        $inf_model->inf_name = isset($baseinfo['filename']) ? $baseinfo['filename'] : '';
                        $inf_model->inf_sha256 = isset($baseinfo['sha256']) ? $baseinfo['sha256'] : '';
                    }

                    if ($inf_model->save()) {
                        if (isset($inf['hardwareids'])) {
                            $inf_hid = new InfHid();
                            $inf_hid->insertData($driver, $inf_model, $inf['hardwareids']);
                        }
                    }
                }
            }
        }

        return true;
    }

    public function formatDate($date)
    {
        $date = explode('/', $date);
        $month = substr($date[0], -2);
        $day = trim($date[1]);
        $year = trim($date[2]);

        return $year."-".$month."-".$day;
    }
}
