<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/28
 * Time: 08:02
 */

namespace Leo108\QQExmail\SystemLog;

use Leo108\QQExmail\Core\BaseApi;

class Log extends BaseApi
{
    const API_MAIL_STATUS = 'log/mailstatus';
    const API_MAIL = 'log/mail';
    const API_LOGIN = 'log/login';
    const API_BATCH_JOB = 'log/batchjob';
    const API_OPERATION = 'log/operation';

    const MAIL_TYPE_RECEIVE_AND_SEND = '0';
    const MAIL_TYPE_SEND = '1';
    const MAIL_TYPE_RECEIVE = '2';

    // todo 操作类型列表
    const OPERATION_TYPE_ALL = '1';

    // todo 返回的操作类型列表

    public function mailStatus($domain, $begin, $end)
    {
        $req = ['domain' => $domain, 'begin_date' => $this->formatDate($begin), 'end_date' => $this->formatDate($end)];

        return self::parseJson($this->apiJson(self::API_MAIL_STATUS, $req));
    }

    public function mail($mailType, $begin, $end, $filters = [])
    {
        $req = [
            'mailtype'   => $mailType,
            'begin_date' => $this->formatDate($begin),
            'end_date'   => $this->formatDate($end),
        ];
        if (isset($filters['userid'])) {
            $req['userid'] = $filters['userid'];
        }
        if (isset($filters['subject'])) {
            $req['subject'] = $filters['subject'];
        }

        return self::parseJson($this->apiJson(self::API_MAIL, $req));
    }

    public function login($userId, $begin, $end)
    {
        $req = [
            'userid'     => $userId,
            'begin_date' => $this->formatDate($begin),
            'end_date'   => $this->formatDate($end),
        ];

        return self::parseJson($this->apiJson(self::API_LOGIN, $req));
    }

    public function batchJob($begin, $end)
    {
        $req = [
            'begin_date' => $this->formatDate($begin),
            'end_date'   => $this->formatDate($end),
        ];

        return self::parseJson($this->apiJson(self::API_BATCH_JOB, $req));
    }

    public function operation($type, $begin, $end)
    {
        $req = [
            'type'       => $type,
            'begin_date' => $this->formatDate($begin),
            'end_date'   => $this->formatDate($end),
        ];

        return self::parseJson($this->apiJson(self::API_OPERATION, $req));
    }

    protected function getAppName()
    {
        return 'system_log';
    }
}
