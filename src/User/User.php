<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/25
 * Time: 17:11
 */

namespace Leo108\QQExmail\User;

use Leo108\QQExmail\Core\BaseApi;

class User extends BaseApi
{
    const API_GET = 'user/get';
    const API_CREATE = 'user/create';
    const API_UPDATE = 'user/update';
    const API_DELETE = 'user/delete';
    const API_SIMPLE_LIST = 'user/simplelist';
    const API_LIST = 'user/list';
    const API_BATCH_CHECK = 'user/batchcheck';

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    public function get($userId)
    {
        return static::parseJson($this->apiGet(self::API_GET, ['userid' => $userId]));
    }

    public function create($data)
    {
        return static::parseJson($this->apiJson(self::API_CREATE, $data));
    }

    public function update($userId, $data)
    {
        return static::parseJson($this->apiJson(self::API_UPDATE, array_merge($data, ['userid' => $userId])));
    }

    public function delete($userId)
    {
        return static::parseJson($this->apiGet(self::API_DELETE, ['userid' => $userId]));
    }

    public function simpleList($departmentId, $fetchChild = false)
    {
        return static::parseJson($this->apiGet(self::API_SIMPLE_LIST, [
            'department_id' => $departmentId,
            'fetch_child'   => $fetchChild ? 1 : 0,
        ]));
    }

    public function userList($departmentId, $fetchChild = false)
    {
        return static::parseJson($this->apiGet(self::API_LIST, [
            'department_id' => $departmentId,
            'fetch_child'   => $fetchChild ? 1 : 0,
        ]));
    }

    public function batchCheck(array $userIdArr)
    {
        return static::parseJson($this->apiJson(self::API_BATCH_CHECK, ['userlist' => $userIdArr]));
    }

    protected function getAppName()
    {
        return 'contact';
    }
}
