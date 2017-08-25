<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/14
 * Time: 18:19
 */

namespace Leo108\WorkWechat\Core;

use GuzzleHttp\MessageFormatter as BaseMessageFormatter;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class MessageFormatter extends BaseMessageFormatter
{
    /**
     * @var bool
     */
    protected $hideAccessToken = true;

    public function __construct($template = BaseMessageFormatter::CLF, $hideAccessToken = true)
    {
        parent::__construct($template);
        $this->hideAccessToken = $hideAccessToken;
    }

    /**
     * @return bool
     */
    public function isHideAccessToken()
    {
        return $this->hideAccessToken;
    }

    /**
     * @param bool $hideAccessToken
     */
    public function setHideAccessToken($hideAccessToken)
    {
        $this->hideAccessToken = $hideAccessToken;
    }

    public function format(
        RequestInterface $request,
        ResponseInterface $response = null,
        \Exception $error = null
    ) {
        if ($this->isHideAccessToken()) {
            $query                 = \GuzzleHttp\Psr7\parse_query($request->getUri()->getQuery());
            $query['access_token'] = 'hidden';
            $uri                   = $request->getUri()->withQuery(http_build_query($query));
            $request               = $request->withUri($uri);
        }

        return parent::format($request, $response, $error);
    }
}
