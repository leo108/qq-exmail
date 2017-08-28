<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 08:14
 */

namespace Leo108\QQExmail\Contact;

use Leo108\QQExmail\Core\BaseApi;

abstract class BaseContactApi extends BaseApi
{
    protected function getAppName()
    {
        return 'contact';
    }
}
