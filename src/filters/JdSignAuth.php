<?php

namespace graychen\yii2\jd\deposit\filters;

use common\models\User;
use yii\filters\auth\AuthMethod;

class JdSignAuth extends AuthMethod
{
    public $realm = 'api';
    public $auth;

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $rawParams = $params = empty($request->getBodyParams()) ? $request->getQueryParams() : $request->getBodyParams();
        if ($params['customerId'] != getenv('JINDONG_API_CUSTOMERID')) {
            $this->handleFailure($response);
        }
        $sign = $this->createSign($params);
        if ($sign != $rawParams['sign']) {
            $this->handleFailure($response);
        }
        $request->setBodyParams($params);

        return new User();
    }

    /**
     * @inheritdoc
     */
    public function challenge($response)
    {
        //$response->getHeaders()->set('WWW-Authenticate', "Basic realm=\"{$this->realm}\"");
    }

    /**
     * 生成签名验证串sign
     * @param array $params post或get请求的请求参数数组
     * @return string sign签名验证串
     */
    public function createSign($params)
    {
        $data = $params['data'];
        $signStr = "customerId=" . getenv('JINDONG_API_CUSTOMERID') . "&data=" . $data . "&timestamp=" . $params['timestamp'] . "&" . getenv('JINDONG_API_PRIVATEKEY');
        $sign = md5($signStr);
        return $sign;
    }
}
