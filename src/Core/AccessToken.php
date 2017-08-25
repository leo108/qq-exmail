<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/25
 * Time: 16:47
 */

namespace Leo108\QQExmail\Core;

use Leo108\QQExmail\Core\Exceptions\GetAccessTokenException;

class AccessToken extends BaseApi
{
    const API_GET_TOKEN = 'gettoken';

    public function getToken($app, $refresh = false)
    {
        $cacheKey = $this->getCacheKey($app);
        $cache    = $this->getSDK()->getCache();
        if ($refresh || !$ret = $cache->get($cacheKey)) {
            $token = $this->getTokenFromServer($app);
            $cache->set($cacheKey, $token['access_token'], $token['expires_in'] - 1500);

            return $token['access_token'];
        }

        return $ret;
    }

    public function getTokenFromServer($app)
    {
        $ret = static::parseJson($this->apiGet(self::API_GET_TOKEN, [
            'corpid'     => $this->getSDK()->getCorpId(),
            'corpsecret' => $this->getSDK()->getCorpSecret($app),
        ]));
        if (empty($ret['access_token'])) {
            throw new GetAccessTokenException('get AccessToken fail. response: '.json_encode($ret));
        }

        return $ret;
    }

    public function getCacheKey($app)
    {
        $prefix = $this->getSDK()->getCacheKeyPrefix();
        $corpId = $this->getSDK()->getCorpId();

        return sprintf('%s.access_token.%s.%s', $prefix, $corpId, $app);
    }

    protected function getAppName()
    {
        // disable token middleware
        return null;
    }
}
