<?php
/**
 * Created by PhpStorm.
 * User: leo108
 * Date: 2017/8/25
 * Time: 16:46
 */

namespace Leo108\QQExmail;

use Cache\Adapter\PHPArray\ArrayCachePool;
use GuzzleHttp\ClientInterface;
use Leo108\QQExmail\Core\AccessToken;
use Leo108\QQExmail\Core\Exceptions\InvalidArgumentException;
use Leo108\QQExmail\User\User;
use Leo108\SDK\SDK;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Class QQExmail
 * @package Leo108\QQExmail
 * @property \Leo108\QQExmail\Core\AccessToken $accessToken
 * @property \Leo108\QQExmail\User\User        $user
 */
class QQExmail extends SDK
{
    /**
     * @var string
     */
    protected $corpId;

    /**
     * @var string
     */
    protected $corpSecret;

    /**
     * @var CacheInterface
     */
    protected $cache = null;

    /**
     * @var string
     */
    protected $cacheKeyPrefix = 'qq_exmail';

    /**
     * QQExmail constructor.
     * @param array                $config
     * @param CacheInterface|null  $cache
     * @param ClientInterface|null $httpClient
     * @param LoggerInterface|null $logger
     */
    public function __construct(
        array $config = [],
        CacheInterface $cache = null,
        ClientInterface $httpClient = null,
        LoggerInterface $logger = null
    ) {
        parent::__construct($config, $httpClient, $logger);
        $this->cache = $cache ?: new ArrayCachePool();
        $this->parseConfig($config);
    }

    /**
     * @return CacheInterface
     */
    public function getCache()
    {
        return $this->cache;
    }

    /**
     * @param CacheInterface $cache
     */
    public function setCache($cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return string
     */
    public function getCorpId()
    {
        return $this->corpId;
    }

    /**
     * @return string
     */
    public function getCorpSecret()
    {
        return $this->corpSecret;
    }

    /**
     * @return string
     */
    public function getCacheKeyPrefix()
    {
        return $this->cacheKeyPrefix;
    }

    protected function getApiMap()
    {
        return [
            'accessToken' => AccessToken::class,
            'user'        => User::class,
        ];
    }

    protected function parseConfig(array $config)
    {
        if (!isset($config['corp_id'])) {
            throw new InvalidArgumentException('缺少 corp_id 参数');
        }

        $this->corpId = $config['corp_id'];

        if (!isset($config['corp_secret'])) {
            throw new InvalidArgumentException('缺少 corp_secret 参数');
        }

        $this->corpId = $config['corp_id'];

        if (isset($config['cache_key_prefix'])) {
            $this->cacheKeyPrefix = $config['cache_key_prefix'];
        }

        $this->config = $config;
    }
}
