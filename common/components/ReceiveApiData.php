<?php

namespace common\components;

use yii\base\Component;

class ReceiveApiData extends Component
{
    /**
     * Parse raw HTTP request data.
     *
     * Pass in $a_data as an array. This is done by reference to avoid copying
     * the data around too much.
     *
     * Any files found in the request will be added by their field name to the
     * $data['files'] array.
     *
     * http://www.tangshuang.net/?p=2294
     *
     * @param   array  Empty array to fill with data
     *
     * @return array Associative array of request data
     */
    public function parseHttpInputRaw()
    {
        $a_data = array();

        // read incoming data
        $input = file_get_contents('php://input');

        // grab multipart boundary from content type header
        preg_match('/boundary=(.*)$/', $_SERVER['CONTENT_TYPE'], $matches);

        // content type is probably regular form-encoded
        if (!count($matches)) {
            // we expect regular puts to containt a query string containing data
            parse_str(urldecode($input), $a_data);

            return $a_data;
        }

        $boundary = $matches[1];

        // split content by boundary and get rid of last -- element
        $a_blocks = preg_split("/-+$boundary/", $input);
        array_pop($a_blocks);

        // loop data blocks
        foreach ($a_blocks as $id => $block) {
            if (empty($block)) {
                continue;
            }

            // you'll have to var_dump $block to understand this and maybe replace \n or \r with a visibile char

            // parse uploaded files
            if (strpos($block, 'filename=') !== false) {
                // match "name", then everything after "stream" (optional) except for prepending newlines
                preg_match("/name=\"([^\"]*)\".*filename=\"([^\"].*?)\".*Content-Type:\s+(.*?)[\n|\r|\r\n]+([^\n\r].*)?$/s", $block, $matches);
                $a_data['files'][$matches[1]] = array(
                    'name' => $matches[1],
                    'filename' => $matches[2],
                    'type' => $matches[3],
                    'blob' => $matches[4],
                );
            // parse all other fields
            } else {
                // match "name" and optional value in between newline sequences
                preg_match('/name=\"([^\"]*)\"[\n|\r]+([^\n\r].*)?\r$/s', $block, $matches);

                $a_data[$matches[1]] = $matches[2];
            }
        }

        return $a_data;
    }

    /**
     * 获取put类型的含上传文件格式的数据.
     *
     * @param type $raw 从php://input内获取的数据
     *
     * @return type 数组，下标为：FILES的为文件类型的字段，可以支持多文件类型字段，下面有两个值：fileName代表文件名，source代表文件的二进制流，可直接存文件。
     *              下标为：INPUT的为对应的非文件类型字段，值为对应的值。
     */
    public function getRawData()
    {
        $raw = file_get_contents('php://input');
        //$raw = file_get_contents('/var/www/html/test/parse_str0.txt');

        $tmp = explode("\r\n", $raw);
        if (substr($tmp[0], 0, 1) != '-') {
            return array();
        }
        $boundary = $tmp[0];
        $allData = explode($boundary."\r\n", $raw);
        $ret = array();
        foreach ($allData as $k => $data) {
            //$thisDataArr = explode("\r\n", $data);
            if (!$data) {
                continue;
            }

            $tmpArr = explode("\r\n\r\n", $data);
            if (strpos($data, 'filename=') !== false && strpos($data, 'Content-Disposition:') !== false) {
                //文件类型数据
                $dataType = 'files';
                $pregPage = '/[\w\W]*?Content-Disposition[\w\W]*?name=\"([\w\W]*?)\"[\w\W]*?filename=\"([\w\W]*?)\"[\w\W]*?/';
                preg_match_all($pregPage, $tmpArr[0], $arrPage);
                $ret['FILES'][$arrPage[1][0]]['fileName'] = $arrPage[2][0];
                $ret['FILES'][$arrPage[1][0]]['source'] = trim(substr($data, strlen($tmpArr[0])), "\r\n");
            } else {
                $pregPage = "/[\w\W]*?Content-Disposition[\w\W]*?name=\"([\w\W]*?)\"[\w\W]*?/";
                preg_match_all($pregPage, $tmpArr[0], $arrPage);
                $value = trim(substr($data, strlen($tmpArr[0])), "\r\n");
                $ret['INPUT'][$arrPage[1][0]] = $value;
            }
        }

        return $ret;
    }
}
