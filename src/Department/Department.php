<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/25
 * Time: 14:15
 */

namespace Leo108\QQExmail\Department;

use Leo108\QQExmail\Core\BaseApi;

class Department extends BaseApi
{
    const API_CREATE = 'department/create';
    const API_UPDATE = 'department/update';
    const API_DELETE = 'department/delete';
    const API_LIST = 'department/list';
    const API_SEARCH = 'department/search';

    public function create($data)
    {
        return static::parseJson($this->apiJson(self::API_CREATE, $data));
    }

    public function update($id, $data)
    {
        return static::parseJson($this->apiJson(self::API_UPDATE, array_merge($data, ['id' => $id])));
    }

    public function delete($id)
    {
        return static::parseJson($this->apiGet(self::API_DELETE, ['id' => $id]));
    }

    public function departmentList($id = null)
    {
        $query = [];
        if (!is_null($id)) {
            $query['id'] = $id;
        }

        return static::parseJson($this->apiGet(self::API_LIST, $query));
    }

    public function search($name, $fuzzy = false)
    {
        return static::parseJson($this->apiJson(self::API_SEARCH, [
            'name'  => $name,
            'fuzzy' => $fuzzy ? 1 : 0,
        ]));
    }

    protected function getAppName()
    {
        return 'contact';
    }
}
