<?php

namespace common\models;

use Yii;

class InfHid extends \dbbase\models\InfHid
{
    public $driver_qd_name;
    public $driver_inf_name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        $rules = parent::rules();

        return array_merge(
            $rules,
            [
                [['driver_qd_name', 'driver_inf_name'], 'safe'],
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        $labels = parent::attributeLabels();

        return array_merge(
            $labels,
            [
                'id' => Yii::t('app', 'hid ID'),
                'driver_qd_name' => Yii::t('app', '包名称'),
                'driver_inf_name' => Yii::t('app', 'inf名称'),
            ]
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDriver()
    {
        return $this->hasOne(Driver::className(), ['id' => 'driver_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOses()
    {
        return $this->hasMany(DriverOs::className(), ['driver_id' => 'id'])
            ->via('driver');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getInf()
    {
        return $this->hasOne(Inf::className(), ['id' => 'inf_id']);
    }

    public function getHidCount($hid, $os = '', $pf = '')
    {
        $response = [
            'hid' => $hid,
            'count' => 0,
        ];
        $reg = '/^(HDAUDIO\\\)(\w)*/i';
        if (preg_match($reg, preg_quote($hid))) {
            $response = $this->hdaudioCount($hid, $os, $pf);
        }

        $reg = '/^(PCI\\\)(\w)*/i';
        if (preg_match($reg, preg_quote($hid))) {
            $response = $this->pciCount($hid, $os, $pf);
        }

        $reg = '/^(ACPI\\\)(\w)*/i';
        if (preg_match($reg, preg_quote($hid))) {
            $response = $this->acpiCount($hid, $os, $pf);
        }

        $reg = '/^(USB\\\)(\w)*/i';
        if (preg_match($reg, preg_quote($hid))) {
            $response = $this->usbCount($hid, $os, $pf);
        }

        if ($response['count'] <= 0) {
            $response = $this->commonHidCount($hid, $os, $pf);
        }

        return $response;
    }

    /**
     * 2.1 HDAUDIO\开头硬件ID；比如：HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5&REV_1000，按&分隔符把字符串分成5部分。
     * HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5&REV_1000查询，如果有结果直接返回，没有进入下一步。
     * 去掉第五部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&SUBSYS_102805A5查询，如果有结果直接返回，没有进入下一步。
     * 去掉第四部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280&REV_1000查询，如果有结果直接返回，没有进入下一步。
     * 去掉第四，五部分，变成HDAUDIO\FUNC_01&VEN_10EC&DEV_0280查询，如果有结果直接返回，没有就退出，显示无结果。
     */
    public function hdaudioCount($hid, $os, $pf)
    {
        $count = 0;
        $new_hid = $hid;
        if (substr_count($hid, '&') < 2) {
            throw new \Exception('没有搜索到相关结果');
        }

        if (substr_count($hid, '&') == 2) {
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                throw new \Exception('没有搜索到相关结果');
            }
        }

        if (substr_count($hid, '&') == 3) {
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                $new_hid = $this->getFormatString($hid, 3);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    throw new \Exception('没有搜索到相关结果');
                }
            }
        }

        if (substr_count($hid, '&') > 4) {
            $pos = $this->getStrNPos($hid, '&', 5);
            $hid = substr($hid, 0, $pos);
        }

        $count = $this->getInfHidCount($hid, $os, $pf);
        if ($count <= 0) {
            $new_hid = $this->getFormatString($hid, 4);
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                $new_hid = $this->getFormatString($hid, 3);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    $new_hid = $this->getFormatString($hid, [4, 3]);
                    $count = $this->getInfHidCount($new_hid, $os, $pf);
                    if ($count <= 0) {
                        throw new \Exception('没有搜索到相关结果');
                    }
                }
            }
        }
        $response = [
            'hid' => $new_hid,
            'count' => $count,
        ];

        return $response;
    }

    /**
     * 2.2 PCI\开头硬件ID，比如：PCI\VEN_8086&DEV_0412&SUBSYS_05A51028&REV_06，按&分隔符把字符串分成4部分。
     * 以PCI\VEN_8086&DEV_0412&SUBSYS_05A51028&REV_06查询，如果有结果直接返回，没有进入下一步。
     * 去掉第四部分，变成PCI\VEN_8086&DEV_0412&SUBSYS_05A51028查询，如果有结果直接返回，没有进入下一步。
     * 去掉第三部分，变成PCI\VEN_8086&DEV_0412&REV_06查询，如果有结果直接返回，没有进入下一步。
     * 去掉第三，四部分，变成PCI\VEN_8086&DEV_0412查询，如果有结果直接返回，没有就退出，显示无结果。
     */
    public function pciCount($hid, $os, $pf)
    {
        $count = 0;
        $new_hid = $hid;
        if (substr_count($hid, '&') < 1) {
            throw new \Exception('没有搜索到相关结果');
        }

        if (substr_count($hid, '&') == 1) {
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                throw new \Exception('没有搜索到相关结果');
            }
        }

        if (substr_count($hid, '&') == 2) {
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                $new_hid = $this->getFormatString($hid, 2);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    throw new \Exception('没有搜索到相关结果');
                }
            }
        }

        if (substr_count($hid, '&') > 3) {
            $pos = $this->getStrNPos($hid, '&', 4);
            $hid = substr($hid, 0, $pos);
        }

        $count = $this->getInfHidCount($new_hid, $os, $pf);
        if ($count <= 0) {
            $new_hid = $this->getFormatString($hid, 3);
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                $new_hid = $this->getFormatString($hid, 2);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    $new_hid = $this->getFormatString($hid, [3, 2]);
                    $count = $this->getInfHidCount($new_hid, $os, $pf);
                    if ($count <= 0) {
                        throw new \Exception('没有搜索到相关结果');
                    }
                }
            }
        }

        $response = [
            'hid' => $new_hid,
            'count' => $count,
        ];

        return $response;
    }

    /**
     * 2.3 ACPI开头硬件ID，比如：ACPI\VEN_LEN&DEV_0068，做字符串替换查询数据。
     * ACPI\VEN_LEN&DEV_0068直接查询，如果有结果直接返回，没有进入下一步。
     * 替换VEN_和&DEV_为空，形成ACPI\LEN0068查询，如果有结果直接返回，没有进入下一步。
     * 再替换ACPI\为*，形成*LEN0068查询，如果有结果直接返回，没有就退出，显示无结果。
     * 有可能输入的直接是第二步ACPI\LEN0068样式的硬件ID，直接从第二步开始即可。
     */
    public function acpiCount($hid, $os, $pf)
    {
        $count = 0;
        $new_hid = $hid;
        $needle1 = 'VEN_';
        $needle2 = '&DEV_';
        $needle3 = 'ACPI\\';

        $count = $this->getInfHidCount($new_hid, $os, $pf);
        if ($count <= 0) {
            if (stripos($hid, $needle1)) {
                $new_hid = str_replace($needle1, '', $new_hid);
            }
            if (stripos($hid, $needle2)) {
                $new_hid = str_replace($needle2, '', $new_hid);
            }
            $count = $this->getInfHidCount($new_hid, $os, $pf);
            if ($count <= 0) {
                $new_hid = str_replace($needle3, '*', $new_hid);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    throw new \Exception('没有搜索到相关结果');
                }
            }
        }

        $response = [
            'hid' => $new_hid,
            'count' => $count,
        ];

        return $response;
    }

    /**
     * 2.4 USB\开头硬件ID，按&分隔，替换掉REV节再查询一次。
     * 比如：USB\VID_04B4&PID_0823&REV_0101&MI_00，如果有结果直接返回，没有进入下一步。
     * 替换掉&REV_0101这个节，形成USB\VID_04B4&PID_0823&MI_00查询，如果有结果直接返回，没有就退出，显示无结果。
     * 比如USB\VID_138A&PID_0090&REV_0164，如果有结果直接返回，没有进入下一步。
     * 替换掉&REV_0164这个节，形成USB\VID_138A&PID_0090查询，如果有结果直接返回，没有就退出，显示无结果。
     */
    public function usbCount($hid, $os, $pf)
    {
        $count = 0;
        $new_hid = $hid;
        $needle = '&REV_';

        $count = $this->getInfHidCount($new_hid, $os, $pf);
        if ($count <= 0) {
            if (stripos($hid, $needle)) {
                $pattern = '/(&REV_)(\w)*/i';
                $new_hid = preg_replace($pattern, '', $new_hid);
                $count = $this->getInfHidCount($new_hid, $os, $pf);
                if ($count <= 0) {
                    throw new \Exception('没有搜索到相关结果');
                }
            } else {
                throw new \Exception('没有搜索到相关结果');
            }
        }

        $response = [
            'hid' => $new_hid,
            'count' => $count,
        ];

        return $response;
    }

    public function commonHidCount($hid, $os, $pf)
    {
        $count = $this->getInfHidCount($hid, $os, $pf);

        $response = [
            'hid' => $hid,
            'count' => $count,
        ];

        return $response;
    }

    public function hidNameCount($hid_name, $os = '', $pf = '')
    {
        $count = $this->getInfHidCount($hid_name, $os, $pf, $type = 1);

        $response = [
            'hid' => $hid_name,
            'count' => $count,
        ];

        return $response;
    }

    public function hidSearch($hid, $os, $pf, $page, $page_size, $type = 0)
    {
        $response = [
            'hid' => $hid,
            'match_hid' => '',
            'hids' => [],
            'count' => 0,
            'page_total' => 0,
            'page' => 1,
        ];
        $inf_hid = [
            'hid_name' => '',
            'driver_ver' => '',
            'driver_original_pubtime' => '',
            'qd_file_size' => '',
            'class' => '',
            'language' => '',
            'qd_install_type' => '',
            'qd_instruction' => '',
            'qd_source' => '',
            'qd_os' => [],
            'qd_os_array' => [],
            'qd_os_string' => '',
            'hash' => '',
        ];

        if ($type) {
            $res = $this->hidNameCount($hid, $os, $pf);
        } else {
            $res = $this->getHidCount($hid, $os, $pf);
        }

        if ($res['count'] > 0) {
            // 分页数据
            $page_total = ceil($res['count']/$page_size);
            $page = $page > $page_total ? $page_total : $page;
            $offset = ($page - 1) * $page_size;
            $response['page'] = $page;
            $response['page_total'] = $page_total;

            $query = self::find()
                ->select(self::tableName().'.*')
                ->distinct()
                ->joinWith(['driver d'])
                ->joinWith(['inf i'])
                ->joinWith(['oses ds'])
                ->where(['d.is_del' => self::NOT_DEL]);

            if ($type) {
                $query->andWhere(['like', 'hid_name', $hid]);
            } else {
                $query->andWhere(['hid' => $res['hid']]);
            }
            if ($os) {
                $query->andWhere(['ds.qd_os' => $os]);
            }
            if ($pf) {
                $query->andWhere(['ds.qd_pf' => $pf]);
            }

            $query->orderBy(['d.rank' => SORT_DESC, 'driver_pubtime' => SORT_DESC]);
            $inf_hids = $query->offset($offset)->limit($page_size)->all();

            if ($inf_hids) {
                foreach ($inf_hids as $hid) {
                    $qd_os = [];
                    $qd_os_array = [];
                    $inf_hid['hid_name'] = $hid->hid_name;
                    $inf_hid['driver_ver'] = $hid->inf->driver_ver;
                    $inf_hid['driver_original_pubtime'] = $hid->inf->driver_original_pubtime;
                    $inf_hid['qd_file_size'] = round($hid->driver->qd_file_size > 0 ? ($hid->driver->qd_file_size / (1024 * 1024)) : 0, 1).'MB';
                    $inf_hid['class'] = $hid->inf->class;
                    $inf_hid['language'] = $hid->driver->language;
                    $inf_hid['qd_install_type'] = Driver::$install_type[$hid->driver->qd_install_type];
                    $inf_hid['qd_instruction'] = $hid->driver->qd_instruction;
                    $inf_hid['qd_source'] = $hid->driver->qd_source;
                    $inf_hid['hash'] = $hid->driver->qd_sha256;
                    $oses = $hid->driver->oses;
                    foreach ($oses as $os) {
                        $qd_os[$os->qd_pf][] = $os->qd_os;
                        $qd_os_array[] = $os->qd_os.'-'.$os->qd_pf;
                    }
                    $inf_hid['qd_os'] = $qd_os;
                    $inf_hid['qd_os_array'] = array_values(array_unique($qd_os_array));
                    $inf_hid['qd_os_string'] = implode(',', array_unique($qd_os_array));

                    $response['hids'][] = $inf_hid;
                }
            }
        }

        $response['match_hid'] = $res['hid'];
        $response['count'] = (int) $res['count'];

        return $response;
    }

    public function getInfHidCount($hid, $os, $pf, $type = 0)
    {
        //echo self::find()
            //->select(self::tableName().'.*')
            //->select(self::tableName().'.*, '.Driver::tableName().'.*, ds.*')
            //->joinWith(['driver d'])
            //->joinWith(['oses ds'])
            //->where(['d.is_del' => Driver::NOT_DEL])
            //->andWhere(['hid' => $hid])
            //->createCommand()->getRawSql();

        $query = self::find()
                ->select(self::tableName().'.*')
                ->distinct()
                ->joinWith(['driver d'])
                ->joinWith(['inf i'])
                ->joinWith(['oses ds'])
                ->where(['d.is_del' => self::NOT_DEL]);

        if ($type) {
            $query->andWhere(['like', 'hid_name', $hid]);
        } else {
            $query->andWhere(['hid' => $hid]);
        }
        if ($os) {
            $query->andWhere(['ds.qd_os' => $os]);
        }
        if ($pf) {
            $query->andWhere(['ds.qd_pf' => $pf]);
        }
        //$query->orderBy(['d.rank' => SORT_DESC, 'driver_pubtime' => SORT_DESC]);

        return $query->count();
    }

    public function getInfHidByHid($hid)
    {
        return self::find()
            ->select(self::tableName().'.*')
            ->joinWith(['driver d'])
            ->andWhere(['hid' => $hid])
            ->all();
    }

    public function getStrNPos($str, $needle, $num)
    {
        $n = 0;
        for($i = 1;$i <= $num;$i++) {
            $n = strpos($str, $needle, $n);
            $i != $num && $n++;
        }

        return $n;
    }

    /**
     * 获取处理后的硬件ID字符串.
     *
     * @param string $hid    硬件ID
     * @param mix    $num    处理指针
     * @param string $needle 分割字符
     *
     * @return string $hid
     */
    public function getFormatString($hid, $num, $needle = '&')
    {
        $hid_array = explode($needle, $hid);
        if (is_numeric($num)) {
            unset($hid_array[$num]);
        } elseif (is_array($num) && $num) {
            foreach ($num as $value) {
                unset($hid_array[$value]);
            }
        }

        return implode($needle, $hid_array);
    }
}
