<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 07:56
 */

namespace Leo108\QQExmail\UniqueLogin;

use Leo108\QQExmail\Core\BaseApi;

class UniqueLogin extends BaseApi
{
    const API_GET_LOGIN_URL = 'service/get_login_url';

    public function getLoginUrl($userId)
    {
        return self::parseJson($this->apiGet(self::API_GET_LOGIN_URL, ['userid' => $userId]));
    }

    protected function getAppName()
    {
        return 'unique_login';
    }
}
