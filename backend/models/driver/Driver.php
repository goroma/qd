<?php

namespace backend\models\driver;

use Yii;

class Driver extends \common\models\Driver
{
    public static function find()
    {
        return Yii::createObject(\yii\db\ActiveQuery::className(), [get_called_class()])->where(['is_del' => self::NOT_DEL]);
    }

    /**
     * 重定义delete方法,默认逻辑删除.
     */
    public function delete()
    {
        if ($this->hasAttribute('is_del') && !$this->isNewRecord) {
            $this->is_del = self::IS_DEL;

            return $this->save(false);
        }
    }

    public function insertData($data)
    {
        if (isset($data['qd_sha256'])) {
            $driver = self::find()->where(['qd_sha256' => $data['qd_sha256'], 'is_del' => self::NOT_DEL])->one();
            if ($driver) {
                return $driver->qd_name.' 此包已上传';
            }
        }
        $driver = new Driver;
        $driver->qd_name = isset($data['qd_name']) ? $data['qd_name'] : '';
        $driver->qd_file_size = isset($data['qd_file_size']) ? (string) $data['qd_file_size'] : '';
        $driver->qd_sha256 = isset($data['qd_sha256']) ? $data['qd_sha256'] : '';
        $driver->qd_source = isset($data['qd_source']) ? $data['qd_source'] : '';
        $driver->qd_download_url = isset($data['qd_download_url']) ? $data['qd_download_url'] : '';
        $driver->qd_instruction = isset($data['qd_instruction']) ? $data['qd_instruction'] : '';
        $driver->rank = isset($data['rank']) ? $data['rank'] : 5;
        $driver->language = isset($data['language']) ? $data['language'] : '';
        $driver->parameter = isset($data['parameter']) ? $data['parameter'] : '';
        $driver->note = isset($data['note']) ? $data['note'] : '';
        $driver->type = isset($data['type']) ? $data['type'] : '';
        if (isset($data['qd_install_type'])) {
            if ($data['qd_install_type'] == 'inf') {
                $driver->qd_install_type = 1;
            } elseif ($data['qd_install_type'] == 'exe') {
                $driver->qd_install_type = 2;
            }
        }

        if ($driver->save()) {
            return $driver;
        }

        return false;
    }
}
