<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 07:50
 */

namespace Leo108\QQExmail\FunctionSetting;

use Leo108\QQExmail\Core\BaseApi;

class UserOption extends BaseApi
{
    const API_GET = 'useroption/get';
    const API_UPDATE = 'useroption/update';

    const TYPE_FORCE_SSL = 1;
    const TYPE_IMAP_SMTP = 2;
    const TYPE_POP_SMTP = 3;
    const TYPE_ENABLE_SSL = 4;

    public function get($userId, array $types)
    {
        return static::parseJson($this->apiJson(self::API_GET, ['userid' => $userId, 'type' => $types]));
    }

    public function update($userId, array $options)
    {
        return static::parseJson($this->apiJson(self::API_UPDATE, ['userid' => $userId, 'option' => $options]));
    }

    protected function getAppName()
    {
        return 'function_setting';
    }
}
