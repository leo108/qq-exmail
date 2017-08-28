<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 08:18
 */

namespace Leo108\QQExmail\MailNotice;

use Leo108\QQExmail\Core\BaseApi;

class Mail extends BaseApi
{
    const API_NET_ACCOUNT = 'mail/newcount';

    public function newAccount($userId, $begin, $end)
    {
        $req = [
            'userid'     => $userId,
            'begin_date' => $this->formatDate($begin),
            'end_date'   => $this->formatDate($end),
        ];

        return self::parseJson($this->apiGet(self::API_NET_ACCOUNT, $req));
    }

    // todo 回调模式

    protected function getAppName()
    {
        return 'mail_notice';
    }
}
