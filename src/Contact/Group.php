<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 07:44
 */

namespace Leo108\QQExmail\Contact;

class Group extends BaseContactApi
{
    const API_GET = 'group/get';
    const API_CREATE = 'group/create';
    const API_UPDATE = 'group/update';
    const API_DELETE = 'group/delete';

    public function get($groupId)
    {
        return static::parseJson($this->apiGet(self::API_GET, ['groupid' => $groupId]));
    }

    public function create($groupId, $data)
    {
        return static::parseJson($this->apiJson(self::API_CREATE, array_merge($data, ['groupid' => $groupId])));
    }

    public function update($groupId, $data)
    {
        return static::parseJson($this->apiJson(self::API_UPDATE, array_merge($data, ['groupid' => $groupId])));
    }

    public function delete($groupId)
    {
        return static::parseJson($this->apiGet(self::API_DELETE, ['groupid' => $groupId]));
    }
}
