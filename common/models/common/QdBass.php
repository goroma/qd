<?php

namespace common\models\common;

use Yii;
use Yii\base\Model;
error_reporting(E_ALL);
define('_MAX_LIN_LEN', 1024);

class QdBass extends Model
{
    public $m_inf_ret;
    //public $hardwareids;
    //public $m_version_info;

    public $m_inf_data;
    public $m_file_md5;
    public $m_inf_filename;
    public $m_inf_utf8_filename;
    public $m_inf_content;

    public function readAllZipFile($path = '')
    {
        $files = [];
        if (!$path) {
            $path = './';
        }
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != '.' && $filename != '..' && !is_dir($filename)) {
                if (preg_match("/\.zip$/i", $filename)) {
                    $files[] = $path.$filename;
                }
            }
        }
        closedir($handler);

        return $files;
    }

    /**
     * 读取Inf zip 包内容.
     */
    public function readInfZip($filename)
    {
        $data = [];
        $qd_configs = [];
        $zip = zip_open($filename);
        if ($zip) {
            while ($zip_entry = zip_read($zip)) {
                if (preg_match("/\.json$/i", zip_entry_name($zip_entry))) {
                    $config = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                    $configs = explode('|', $config);
                    foreach ($configs as $config) {
                        $config = trim($config);
                        if ($config == '') {
                            continue;
                        }
                        $qd_configs[] = json_decode($config, true);
                        switch (json_last_error()) {
                            case JSON_ERROR_NONE:
                                break;
                            case JSON_ERROR_DEPTH:
                            case JSON_ERROR_STATE_MISMATCH:
                            case JSON_ERROR_CTRL_CHAR:
                            case JSON_ERROR_SYNTAX:
                            case JSON_ERROR_UTF8:
                            default:
                                die('json文件解析错误,请检查后重试');
                                break;
                            }
                    }
                }
            }
            zip_close($zip);

            foreach ($qd_configs as $key => $config) {
                $data[$key]['qd_config'] = $config;
                if ($config['qd_infs']) {
                    foreach ($config['qd_infs'] as $inf) {
                        $zip = zip_open($filename);
                        while ($zip_entry = zip_read($zip)) {
                            if ($inf == zip_entry_name($zip_entry)) {
                                $p = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                                $this->qd_InfInfo_init_content($inf, $p);
                                $this->parse_inf_file_content();
                                $data[$key]['qd_config']['infs'][] = $this->m_inf_ret;
                                @unlink($this->m_inf_utf8_filename);
                            }
                        }
                        zip_close($zip);
                    }
                }
            }
        }

        return $data;
    }

    private function ToUTF8(&$filecontent)/*{{{*/
    {
        $transfer = false;
        $header = substr($filecontent, 0, 4);
        $encodetype = array(
            'UTF-16BE' => "\xFE\xFF",
            'UTF-16LE' => "\xFF\xFE",
            'UTF-32BE' => "\x00\x00\xFE\xFF",
            'UTF-32LE' => "\xFF\xFE\x00\x00",
            'GB18030' => "\x84\x31\x95\x33", );

        foreach ($encodetype as $key => $value) {
            if (strpos($header, $value) !== false) {
                //printf ("1111111111111111\n" );
            $filecontent = substr($filecontent, strlen($value));
                $filecontent = @iconv($key, 'UTF-8', $filecontent);
                $transfer = true;
            }
        }
        if (!$transfer) {
            if (strpos($header, "\xEF\xBB\xBF") === false) {
                //printf ("2222222222221111111111111111\n" );
            $orilen = strlen($filecontent);
                $ret = @iconv('GB2312', 'UTF-8', $filecontent);
                if ($ret !== false) {
                    $newlen = strlen($ret);
                    if ($newlen >= $orilen) {
                        //printf ("4444[%d][%d]\n" , $newlen, $orilen);
                  $filecontent = $ret;

                        return;
                    }
                }
            }
         //printf ("33333\n" );
        }
    }

/*}}}*/

    public function qd_InfInfo_init_content($filename, $content)
    {
        $this->m_inf_data = array();
        $this->m_file_md5 = hash('sha256', $content);
        $this->m_inf_filename = $filename;
        $this->m_inf_utf8_filename = '/tmp/'.$filename.'.utf8';

        $newstr = sprintf('%s%s', basename($this->m_inf_filename), $this->m_file_md5);
        //echo "aaa$newstr\n";
        $this->m_file_md5 = hash('sha256', $newstr);

        $this->m_inf_content = $content;

        $this->m_inf_ret = array(
            'version_info' => array(
                'signature' => '',
                'class' => '',
                'classguid' => '',
                'provider' => '',
                'driverver' => '',
                'compatible' => '',
                'driverpackagetype' => '',
                'driverpackagedisplayname' => '',
            ),
            'hardwareids' => array(),
            'manufacture' => array(),
        );
    }

    public function get_file_md5()
    {
        return $this->m_file_md5;
    }

    public function get_ini_file()
    {
        return $this->m_inf_filename;
    }

    public function qd_InfInfo_close()
    {
        if (file_exists($this->m_inf_utf8_filename)) {
            unlink($this->m_inf_utf8_filename);
        }
        unset($this->m_inf_data);
        unset($this->m_inf_content);
        unset($this->m_inf_ret);
    }

    private function set_version_value(&$inf_data)/*{{{*/
    {
        if (isset($inf_data['version'])) {
            $versioninfo = $inf_data['version'];
            foreach ($versioninfo as $key => $row) {
                $versioninfo[$key][0] = strtolower($row[0]);
            }

            //m_version_info
            foreach ($versioninfo as $row) {
                $key = $row[0];
                $value = trim($row[1], '"');
                if (isset($this->m_inf_ret['version_info'][$key])) {
                    $this->m_inf_ret['version_info'][$key] = $value;
                }
            }
        }
    }

    public function get_key_name($k)
    {
        foreach ($this->m_inf_data['strings'] as $k1 => $v1) {
            if (strcasecmp($v1[0], $k) == 0) {
                return $v1[1];
            }
        }

        return $k;
    }

    public function get_k_v($str)
    {
        $retp = array();
        $index = 0;
        while (true) {
            $lindex = strpos($str, '%', $index);
            if ($lindex !== false) {
                $rindex = strpos($str, '%', $lindex + 1);
                if (($lindex !== false) && ($rindex !== false)) {
                    $k = substr($str, $lindex + 1, $rindex - $lindex - 1);
                    $v = $this->get_key_name($k);
                    $retp[$k] = $v;
                    $index = $rindex + 1;
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        return $retp;
    }

    private function set_nodeincludes(&$inf_data)
    {
        $infs = array();
        foreach ($inf_data as $node => $arrvals) {
            foreach ($arrvals as $v) {
                $k = isset($v[0]) ? $v[0] : '';
                $v = isset($v[1]) ? $v[1] : '';
                $k = strtolower($k);
                if ('include' !== $k) {
                    continue;
                }
                $arr = explode(',', $v);
                foreach ($arr as $v) {
                    $v = trim($v);
                    if (!isset($infs[$v])) {
                        $infs[$v] = 1;
                    }
                    $infs[$v] += 1;
                }
            }
        }
        $ks = array_keys($infs);
        $this->m_inf_ret['includes'] = implode(',', $ks);
    }

    private function _set_manufacturer_value(&$myk, $myv)
    {
        $k1 = $this->get_k_v($myv);
        foreach ($k1 as $k => $v) {
            $str = str_replace("%$k%", $v, $myv);
            $myk = $str;
        }
    }

    private function set_manufacture_value(&$inf_data)
    {
        $Manufacturer = isset($inf_data['manufacturer']) ? $inf_data['manufacturer'] : false;
        if ($Manufacturer) {
            foreach ($Manufacturer as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $k1 => $v2) {
                        if (stripos($v2, '%') !== false) {
                            $this->_set_manufacturer_value($inf_data['manufacturer'][$key][$k1], $v2);
                        }
                    }
                } else {
                    if (strpos($value, '"') !== false) {
                        $inf_data['manufacturer'][$key] = trim($value, '"');
                    }
                }
            }
        }

        return true;
    }

    private function set_hardwareids_value(&$inf_data)/*{{{*/
    {
        $this->set_manufacture_value($inf_data);
        $Manufacturer = isset($inf_data['manufacturer']) ? $inf_data['manufacturer'] : false;
        $oshids = array();

        if ($Manufacturer) {
            foreach ($Manufacturer as $key => $value) {
                $nodenames = array();
                //$arrs = explode(',', $value[1]);
                if (is_array($value)) {
                    $arrs = explode(',', $value[1]);
                } else {
                    $arrs = explode(',', $value);
                }
                foreach ($arrs as $key => $arr) {
                    if (0 == $key) {
                        $nodenames[] = trim(strtolower(trim($arr)), '"');
                    } else {
                        $nodenames[] = sprintf('%s.%s', $nodenames[0], trim(strtolower(trim($arr)), '"'));
                    }
                }
                foreach ($nodenames as $nodename) {
                    if (isset($inf_data[$nodename])) {
                        if (!isset($oshids[$nodename])) {
                            $oshids[$nodename] = array();
                        }

                        $ids = $this->get_hardwareids_from_nodename($inf_data[$nodename]);
                        $oshids[$nodename] = $ids;
                        if ($ids === false) {
                            return  false;
                        }
                        foreach ($ids as $id => $name) {
                            $this->m_inf_ret['hardwareids'][$id] = $name;
                        }
                    }
                }
            //var_dump($nodenames);
            }
        }
        $this->get_os_hids_num($oshids);

        return true;
    }

/*}}}*/

    //获取每个操做系统对应hids数量信息，当相等时os_hids返回1，否则返回0
    private function get_os_hids_num($oshids)
    {
        $os_2 = array();
        $os = array_keys($oshids);
        $os_2 = $this->get_os_version($os, '1');

        $ret = array();
        foreach ($os_2 as $k => $v) {
            foreach ($v as $key => $val) {
                if (!isset($ret[$val])) {
                    $ret[$val] = array();
                }
                foreach ($oshids[$k] as $a => $b) {
                    if (!in_array($a, $ret[$val])) {
                        array_push($ret[$val], $a);
                    }
                }
            }
        }
        $num;
        $count = 0;
        foreach ($ret as $k => $v) {
            if (count($v) == 0) {
                continue;
            }
            if ($count == 0) {
                $num = count($v);
                ++$count;
                continue;
            }

            if ($num != count($v)) {
                $this->m_inf_ret['os_hids'] = 0;

                return;
            }
        }

        $this->m_inf_ret['os_hids'] = 1;
    }

    private function get_osver_function($v)
    {
        $os_list = array(
            '5.1' => 'winxp',
            '5.2' => 'win2k3',
            '6.0' => 'vista',
            '6.1' => 'win7',
            '6.2' => 'win8',
            '6.3' => 'win81',
            '6.4' => 'win10',
            '10.0' => 'win10',
        );

        if (isset($os_list[$v])) {
            return $os_list[$v];
        } else {
            if (substr($v, -1, 1) == 6) {
                return 'win7';
            } elseif (substr($v, -1, 1) == 5) {
                return 'winxp';
            }
        }

        return false;
    }

    private function get_osbit_function($version)
    {
        $os_bit_list = array(
            'amd64' => '64',
            'x86' => '32',
        );
        foreach ($os_bit_list  as $k => $v) {
            if (stristr(strtolower($version), $k) !== false) {
                return $v;
            }
        }

        return false;
    }

    //type=0表示只是获取相应的操作系统信息，type！=0表示获取每个硬件描述如ntx86.6.2对应的操作系统信息
    //为统计每个操作系统对应的hid数量做准备
    private function get_os_version(&$nodenames, $type = 0)
    {
        $inf_os_1 = array(
            'win10_32' => 1,
            'win10_64' => 1,
            'win81_32' => 1,
            'win81_64' => 1,
            'win8_32' => 1,
            'win8_64' => 1,
            'win7_32' => 1,
            'win7_64' => 1,
            'winxp_32' => 1,
            'winxp_64' => 1,
            'vista_32' => 1,
            'vista_64' => 1,
            'win2k3_32' => 1,
            'win2k3_64' => 1,
        );
        $inf_os = array(
            'win10_32' => 0,
            'win10_64' => 0,
            'win81_32' => 0,
            'win81_64' => 0,
            'win8_32' => 0,
            'win8_64' => 0,
            'win7_32' => 0,
            'win7_64' => 0,
            'winxp_32' => 0,
            'winxp_64' => 0,
            'vista_32' => 0,
            'vista_64' => 0,
            'win2k3_32' => 0,
            'win2k3_64' => 0,
        );

        //if ( count ( $nodenames ) == 1 )
        //	return $inf_os_1;
        if (count($nodenames) == 1) {
            $ret[$nodenames[0]] = array();
            if (strtolower(substr($nodenames[0], 0, 9)) == 'ntx86.6.2') {
                // 根据 driverver 来设置 win8 ?

                $inf_os['win8_32'] = 1;
                $inf_os['win7_32'] = 0;
                $inf_os['vista_32'] = 0;
                $inf_os['winxp_32'] = 0;
                $inf_os['win2k3_32'] = 0;
                if ($type === 0) {
                    return $inf_os;
                }
                array_push($ret[$nodenames[0]], 'win8_32');

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 9)) == 'ntx86.6.3') {
                // 根据 driverver 来设置 win81 ?
                $inf_os['win81_32'] = 1;
                $inf_os['win7_32'] = 0;
                $inf_os['vista_32'] = 0;
                $inf_os['winxp_32'] = 0;
                $inf_os['win2k3_32'] = 0;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 9)) == 'ntx86.6.1') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_32'] = 0;
                $inf_os['win7_32'] = 1;
                $inf_os['vista_32'] = 0;
                $inf_os['winxp_32'] = 0;
                $inf_os['win2k3_32'] = 0;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 9)) == 'ntx86.6.0') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_32'] = 0;
                $inf_os['win7_32'] = 1;
                $inf_os['vista_32'] = 0;
                $inf_os['winxp_32'] = 0;
                $inf_os['win2k3_32'] = 0;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 9)) == 'ntx86.5.1') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_32'] = 0;
                $inf_os['win7_32'] = 0;
                $inf_os['vista_32'] = 0;
                $inf_os['winxp_32'] = 1;
                $inf_os['win2k3_32'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 12)) == 'ntamd64.10.0') {
                $inf_os['win10_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 11)) == 'ntamd64.6.4') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win10_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 11)) == 'ntamd64.6.2') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 11)) == 'ntamd64.6.3') {
                // 根据 driverver 来设置 win81 ?
                $inf_os['win81_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif (strtolower(substr($nodenames[0], 0, 11)) == 'ntamd64.6.1') {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win7_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif ((strtolower(substr($nodenames[0], -3, 3)) == 'x86')) {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_32'] = 1;
                $inf_os['win7_32'] = 1;
                $inf_os['vista_32'] = 1;
                $inf_os['winxp_32'] = 1;
                $inf_os['win2k3_32'] = 1;
                $inf_os['win10_32'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif ((strtolower(substr($nodenames[0], -5, 5)) == 'amd64')) {
                // 根据 driverver 来设置 win8 ?
                $inf_os['win8_64'] = 1;
                $inf_os['win7_64'] = 1;
                $inf_os['vista_64'] = 1;
                $inf_os['winxp_64'] = 1;
                $inf_os['win2k3_64'] = 1;
                $inf_os['win10_64'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif ((strtolower(substr($nodenames[0], -2, 2)) == 'nt')) {
                if ($type === 0) {
                    return $inf_os_1;
                }
                foreach ($inf_os_1 as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif ((strtolower(substr($nodenames[0], 0, 4)) == 'nt.6')) {
                $inf_os['win7_64'] = 1;
                $inf_os['vista_64'] = 1;
                $inf_os['win7_32'] = 1;
                $inf_os['vista_32'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } elseif ((strtolower(substr($nodenames[0], 0, 4)) == 'nt.5')) {
                $inf_os['winxp_32'] = 1;
                $inf_os['win2k3_32'] = 1;
                if ($type === 0) {
                    return $inf_os;
                }
                foreach ($inf_os as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            } else {
                if ($type === 0) {
                    return $inf_os_1;
                }
                foreach ($inf_os_1 as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                    }
                }

                return $ret;
            }
        }

        if (count($nodenames) == 2) {
            if ((strtolower(substr($nodenames[0], -3, 3)) == 'x86' &&
                    strtolower(substr($nodenames[1], -5, 5)) == 'amd64') ||
                (strtolower(substr($nodenames[1], -3, 3)) == 'x86' &&
                strtolower(substr($nodenames[0], -5, 5)) == 'amd64')) {
                $ret[$nodenames[0]] = array();
                $ret[$nodenames[1]] = array();
                if ($type === 0) {
                    return $inf_os_1;
                }
                foreach ($inf_os_1 as $k => $v) {
                    if ($v == 1) {
                        array_push($ret[$nodenames[0]], $k);
                        array_push($ret[$nodenames[1]], $k);
                    }
                }

                return $ret;
            }
        }

        $ret = array();
        $inf_os_2 = $inf_os;
        foreach ($nodenames as $k => $v) {
            foreach ($inf_os_2 as $key => $val) {
                $inf_os_2[$key] = 0;
            }
            if (strlen($v) < 7) {
                continue;
            }

            $os = substr($v, -3, 3);
            if ($os[0] == '0') {
                $os = '1'.$os;
            }
            $osver = $this->get_osver_function($os);
            $ostype = $this->get_osbit_function($v);

            if ($ostype !== false && $osver === false) {
                if ($ostype == '32') {
                    $inf_os['win10_32'] = 1;
                    $inf_os['win8_32'] = 1;
                    $inf_os['win81_32'] = 1;
                    $inf_os['win7_32'] = 1;
                    $inf_os['vista_32'] = 1;
                    $inf_os['winxp_32'] = 1;
                    $inf_os['win2k3_32'] = 1;

                    $inf_os_2['win8_32'] = 1;
                    $inf_os_2['win81_32'] = 1;
                    $inf_os_2['win7_32'] = 1;
                    $inf_os_2['vista_32'] = 1;
                    $inf_os_2['winxp_32'] = 1;
                    $inf_os_2['win2k3_32'] = 1;
                } elseif ($ostype == '64') {
                    $inf_os['win10_64'] = 1;
                    $inf_os['win8_64'] = 1;
                    $inf_os['win81_64'] = 1;
                    $inf_os['win7_64'] = 1;
                    $inf_os['vista_64'] = 1;
                    $inf_os['winxp_64'] = 1;
                    $inf_os['win2k3_64'] = 1;

                    $inf_os_2['win8_64'] = 1;
                    $inf_os_2['win81_64'] = 1;
                    $inf_os_2['win7_64'] = 1;
                    $inf_os_2['vista_64'] = 1;
                    $inf_os_2['winxp_64'] = 1;
                    $inf_os_2['win2k3_64'] = 1;
                }
                if (!isset($ret[$v])) {
                    $ret[$v] = array();
                }

                foreach ($inf_os_2 as $key => $val) {
                    if ($val == 1) {
                        array_push($ret[$v], $key);
                    }
                }
                continue;
            } elseif ($osver == false || $ostype == false) {
                continue;
            }
            $osp = $osver.'_'.$ostype;
            $inf_os[$osp] = 1;
            $inf_os_2[$osp] = 1;
            if ($osver == 'win7') {
                $osp = 'win8'.'_'.$ostype;
                $inf_os[$osp] = 1;
                $inf_os_2[$osp] = 1;
            }
            if (!isset($ret[$v])) {
                $ret[$v] = array();
            }

            foreach ($inf_os_2 as $key => $val) {
                if ($val == 1) {
                    array_push($ret[$v], $key);
                }
            }
        }
        if ($type === 0) {
            return $inf_os;
        }

        return $ret;
    }

    private function set_manufacturer_os(&$inf_data)
    {
        $inf_os_1 = array(
            'win10_32' => 0,
            'win10_64' => 0,
            'win81_32' => 0,
            'win81_64' => 0,
            'win8_32' => 0,
            'win8_64' => 0,
            'win7_32' => 1,
            'win7_64' => 1,
            'winxp_32' => 1,
            'winxp_64' => 1,
            'vista_32' => 1,
            'vista_64' => 1,
            'win2k3_32' => 1,
            'win2k3_64' => 1,
        );

        $Manufacturer = isset($inf_data['manufacturer']) ? $inf_data['manufacturer'] : false;
        if ($Manufacturer == false) {
            $this->m_inf_ret['manufacture']['cnt'] = 0;
            $this->m_inf_ret['manufacture']['string'] = '';
            $this->m_inf_ret['manufacture']['winos'] = $inf_os_1;

            return false;
        }
        foreach ($Manufacturer as $key => $value) {
            $nodenames = array();
            $arrs = explode(',', $value[1]);
            foreach ($arrs as $key => $arr) {
                if (0 == $key) {
                    $nodenames[] = trim(strtolower(trim($arr)), '"');
                } else {
                    $nodenames[] = sprintf('%s.%s', $nodenames[0], trim(strtolower(trim($arr)), '"'));
                }
            }
            if (count($arrs) == 1) {
                $this->m_inf_ret['manufacture']['cnt'] = 1;
                $this->m_inf_ret['manufacture']['string'] = $value[1];
                $this->m_inf_ret['manufacture']['winos'] = $inf_os_1;

                return false;
            }
            $tarrs = array();
            foreach ($arrs as $key => $arr) {
                if (0 == $key) {
                    continue;
                } else {
                    $tarrs[] = trim(strtolower(trim($arr)), '"');
                }
            }
            $osinfo = $this->get_os_version($tarrs);
            $this->m_inf_ret['manufacture']['cnt'] = count($nodenames);
            $this->m_inf_ret['manufacture']['string'] = $value[1];
            $this->m_inf_ret['manufacture']['winos'] = $osinfo;
            unset($tarrs);
            unset($arrs);
            //print_r ( $nodenames ) ;
            //print_r ( $osinfo ) ;
            break;
        }
    }

/*}}}*/

    private function judge_valid_key($key)
    {
        $key_l = array(
            '%NotFound%' => '1',
            'NotFound' => '1',
        );
        foreach ($key_l as $k => $v) {
            if (strcasecmp($k, $key) == 0) {
                return false;
            }
        }

        return true;
    }

    private function get_hardwareids_from_nodename($nodevalue)
    {
        $hardwareids = array();
        foreach ($nodevalue as $row) {
            $key = $row[0];
            //$kret = $this->judge_valid_key ( $key ) ;
            //if ( $kret === false )
                //continue ;
            $value = $row[1];
            $ids = array();
            $arr = explode(',', $value);
            foreach ($arr as $v) {
                //$v = trim($v);
                $v = trim((trim($v)), '"');
                if (strlen($v) > 0) {
                    $ids[] = $v;
                }
            }

            if (count($arr) > 1) {
                unset($ids[0]);
            } else {
                if (strpos($arr[0], '\\') === false) {
                    continue;
                }
            }
            foreach ($ids as $id) {
                $hardwareids[$id] = $key;
            }
            unset($ids);
        }

        return $hardwareids;
    }

/*}}}*/

    private function replace_content_to_lower(&$str)/*{{{*/
    {
        $index = 0;
        while (true) {
            //if ( is_array ( $str ) ) { printf ("-------------\n" ); print_r ( $str ) ; printf ("-------------\n" );}
            $lindex = strpos($str, '%', $index);
            if ($lindex !== false) {
                $rindex = strpos($str, '%', $lindex + 1);
                if (($lindex !== false) && ($rindex !== false)) {
                    $substr = substr($str, $lindex + 1, $rindex - $lindex - 1);
                    $sublowstr = strtolower($substr);
                    $str = str_replace("%$substr%", "%$sublowstr%", $str);
                    $index = $rindex + 1;
                } else {
                    break;
                }
            } else {
                break;
            }
        }

        return $str;
    }

    private function replace_version_info()
    {
        foreach ($this->m_inf_ret['version_info'] as $key => $value) {
            $this->m_inf_ret['version_info'][$key] = $this->replace_content_to_lower($this->m_inf_ret['version_info'][$key]);
        }
        if ($this->m_inf_ret['hardwareids']) {
            $hids = array();
            foreach ($this->m_inf_ret['hardwareids'] as $k => $v) {
                $k = $this->replace_content_to_lower($k);
                $v = $this->replace_content_to_lower($v);
                $hids[$k] = $v;
            }
            $this->m_inf_ret['hardwareids'] = $hids;
        }
    }

    private function replace_version_info_2($k, $v)
    {
        foreach ($this->m_inf_ret['version_info'] as $key => $value) {
            $this->m_inf_ret['version_info'][$key] = str_replace($k, $v, $this->m_inf_ret['version_info'][$key]);
        }
        $ids = array();
        if ($this->m_inf_ret['hardwareids']) {
            foreach ($this->m_inf_ret['hardwareids'] as $k1 => $v1) {
                $k2 = str_replace($k, $v, $k1);
                $v2 = str_replace($k, $v, $v1);
                $ids[$k2] = $v2;
            }
            $this->m_inf_ret['hardwareids'] = $ids;
        }
    }

    private function replace_variable($strings)/*{{{*/
    {
        if ($strings) {
            // strtolower strings
            $strs = array();
            foreach ($strings as $row) {
                $row[0] = strtolower($row[0]);
                $strs[] = $row;
            }
            $strings = $strs;

            $this->replace_version_info();

            foreach ($strings as $row) {
                //print_r ( $row ) ;
                if (count($row) >= 2) {
                    $key = $row[0];
                    $value = $row[1];
                    $key = sprintf('%%%s%%', $key);
                    $this->replace_version_info_2($key, $value);
                } else {
                    //printf  ( "filename =%s\n", $this->m_inf_filename ) ;
                    //print_r ( $strings ) ;
                }
            }
        }
    }

    public function parse_inf_utf8_file()
    {
        $filecontent = file_get_contents($this->m_inf_filename);
        if ($filecontent == false) {
            return false;
        }
        $this->ToUTF8($filecontent);
        $fp = fopen($this->m_inf_utf8_filename, 'w');
        if ($fp === false) {
            return false;
        }
        fwrite($fp, $filecontent);
        fclose($fp);
        unset($filecontent);

        $fp = fopen($this->m_inf_utf8_filename, 'r');
        if ($fp === false) {
            return false;
        }
        $nodename = '';
        $i = 0;
        while ($line = fgets($fp, _MAX_LIN_LEN)) {
            $line = trim($line);
            $line = ereg_replace('#.*$', '', $line);
            $line = trim($line);
            if (strlen($line) > 0) {
                if (substr($line, 0, 1) == ';') {
                    continue;
                }
                if (strpos($line, ';') !== false) {
                    $index = strpos($line, ';');
                    $line = trim(substr($line, 0, $index));
                }
                if ((substr($line, 0, 1) == '[') && (substr($line, strlen($line) - 1) == ']')) {
                    $nodename = strtolower(substr($line, 1, strlen($line) - 2));
                    $this->m_inf_data[$nodename] = array();
                } else {
                    if (strpos($line, '=') !== false) {
                        $index = strpos($line, '=');
                        $str1 = trim(trim(substr($line, 0, $index)), '"');
                        $str2 = trim(trim(substr($line, $index + 1)), '"');
                        $this->m_inf_data[$nodename][] = array($str1, $str2);
                    } else {
                        if ($nodename == '') {
                            //printf ( "%s %s \n", $line, $this->m_inf_filename ) ;
                        } else {
                            $this->m_inf_data[$nodename][] = $line;
                        }
                    }
                }
            }
        }

        fclose($fp);

        return true;
    }

    public function parse_inf_utf8_content()
    {
        $this->ToUTF8($this->m_inf_content);
        $fp = fopen($this->m_inf_utf8_filename, 'w');
        if ($fp === false) {
            return false;
        }
        fwrite($fp, $this->m_inf_content);
        fclose($fp);
        unset($filecontent);

        $fp = fopen($this->m_inf_utf8_filename, 'r');
        if ($fp === false) {
            return false;
        }
        while ($line = fgets($fp, _MAX_LIN_LEN)) {
            $line = trim($line);
            if (strlen($line) > 0) {
                if (substr($line, 0, 1) == ';') {
                    continue;
                }
                if (strpos($line, ';') !== false) {
                    $index = strpos($line, ';');
                    $line = trim(substr($line, 0, $index));
                }
                if ((substr($line, 0, 1) == '[') && (substr($line, strlen($line) - 1) == ']')) {
                    $nodename = strtolower(substr($line, 1, strlen($line) - 2));
                    $this->m_inf_data[$nodename] = array();
                } else {
                    if (strpos($line, '=') !== false) {
                        $index = strpos($line, '=');
                        $str1 = trim(trim(substr($line, 0, $index)), '"');
                        $str2 = trim(trim(substr($line, $index + 1)), '"');
                        @$this->m_inf_data[$nodename][] = array($str1, $str2);
                    } else {
                        @$this->m_inf_data[$nodename][] = $line;
                    }
                }
            }
        }
        fclose($fp);

        return true;
    }

    public function parse_inf_file_content()
    {
        $iret = $this->parse_inf_utf8_content();
        if ($iret === false) {
            return $iret;
        }
        $ret = false;
        $this->set_version_value($this->m_inf_data);
        $this->set_manufacturer_os($this->m_inf_data);
        $this->set_nodeincludes($this->m_inf_data);

        $this->m_inf_ret['baseinfo']['sha256'] = $this->m_file_md5;
        $this->m_inf_ret['baseinfo']['filename'] = basename($this->m_inf_filename);
        $ret = $this->set_hardwareids_value($this->m_inf_data);
        if ($ret !== false) {
            if (isset($this->m_inf_data['strings'])) {
                $this->replace_variable($this->m_inf_data['strings']);
            }
            $ret = true;
        }

        if (count($this->m_inf_ret['hardwareids']) < 1) {
            return false;
        }

        return $ret;
    }
}
