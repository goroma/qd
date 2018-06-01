<?php

namespace api\components;

use yii\base\Component;
use yii\web\BadRequestHttpException;

class ApiCommon extends Component
{
    /**
     * 检验参数是否为空.
     *
     * @param []     $params  需要检验的参数
     * @param object $request 接口接收的请求对象
     */
    public function verifyParamIsEmpty(array $params, $request)
    {
        $result = [];
        foreach ($params as $param) {
            if ($request->isGet) {
                if ($request->get($param) == null) {
                    throw new BadRequestHttpException('缺少参数:'.$param, 400);
                    break;
                }
            } else {
                if ($request->getBodyParam($param) == null) {
                    throw new BadRequestHttpException('缺少参数:'.$param, 400);
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * 检验参数不能全为空.
     *
     * @param []     $params  需要检验的参数
     * @param object $request 接口接收的请求对象
     */
    public function verifyParamNotAllEmpty(array $params, $request)
    {
        $result = [];
        $flag = false;
        foreach ($params as $param) {
            if ($request->isGet) {
                if ($request->get($param) != null) {
                    $flag = true;
                }
            } else {
                if ($request->getBodyParam($param) != null) {
                    $flag = true;
                }
            }
        }

        if (!$flag) {
            $paramString = implode(',', $params);
            throw new BadRequestHttpException('以下参数'.$paramString.'不能全为空.', 400);
        }

        return $result;
    }

    /**
     * 检验含有不必要参数是否.
     *
     * @param []     $params  需要检验的参数
     * @param object $request 接口接收的请求对象
     */
    public function verifyParamIsNotNeed(array $params, $request)
    {
        $result = [];
        foreach ($params as $param) {
            if ($request->isGet) {
                if ($request->get($param) != null) {
                    throw new BadRequestHttpException('参数:'.$param.'不能处理', 400);
                    break;
                }
            } else {
                if ($request->getBodyParam($param) != null) {
                    throw new BadRequestHttpException('参数:'.$param.'不能处理', 400);
                    break;
                }
            }
        }

        return $result;
    }

    /**
     * 检验参数是否为空.
     *
     * @param [] $params  需要检验的参数
     * @param [] $request 接口接收的请求参数数组
     */
    public function verifyParamIsEmptyByRequestArray(array $params, $request)
    {
        $result = [];
        foreach ($params as $param) {
            if (!array_key_exists($param, $request)) {
                throw new BadRequestHttpException('缺少参数:'.$param, 400);
                break;
            }
        }

        return $result;
    }
}
