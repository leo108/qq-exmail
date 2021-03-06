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
use Leo108\QQExmail\Core\Exceptions\MissingSecretException;
use Leo108\QQExmail\Contact\Department;
use Leo108\QQExmail\Contact\Group;
use Leo108\QQExmail\MailNotice\Mail;
use Leo108\QQExmail\SystemLog\Log;
use Leo108\QQExmail\UniqueLogin\UniqueLogin;
use Leo108\QQExmail\Contact\User;
use Leo108\QQExmail\FunctionSetting\UserOption;
use Leo108\SDK\SDK;
use Psr\Log\LoggerInterface;
use Psr\SimpleCache\CacheInterface;

/**
 * Class QQExmail
 * @package Leo108\QQExmail
 * @property \Leo108\QQExmail\Core\AccessToken           $accessToken
 * @property \Leo108\QQExmail\Contact\User               $user
 * @property \Leo108\QQExmail\Contact\Department         $department
 * @property \Leo108\QQExmail\Contact\Group              $group
 * @property \Leo108\QQExmail\FunctionSetting\UserOption $userOption
 * @property \Leo108\QQExmail\UniqueLogin\UniqueLogin    $uniqueLogin
 * @property \Leo108\QQExmail\SystemLog\Log              $log
 * @property \Leo108\QQExmail\MailNotice\Mail            $mail
 */
class QQExmail extends SDK
{
    /**
     * @var string
     */
    protected $corpId;

    /**
     * @var array
     */
    protected $corpSecrets;

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
     * @param string $app
     * @throws MissingSecretException
     * @return string
     */
    public function getCorpSecret($app)
    {
        if (!isset($this->corpSecrets[$app])) {
            throw new MissingSecretException('缺少 secret: '.$app);
        }

        return $this->corpSecrets[$app];
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
            'department'  => Department::class,
            'group'       => Group::class,
            'userOption'  => UserOption::class,
            'uniqueLogin' => UniqueLogin::class,
            'log'         => Log::class,
            'mail'        => Mail::class,
        ];
    }

    protected function parseConfig(array $config)
    {
        if (!isset($config['corp_id'])) {
            throw new InvalidArgumentException('缺少 corp_id 参数');
        }

        $this->corpId = $config['corp_id'];

        if (!isset($config['corp_secrets']) || empty($config['corp_secrets'])) {
            throw new InvalidArgumentException('缺少 corp_secrets 参数');
        }

        $this->corpSecrets = $config['corp_secrets'];

        if (isset($config['cache_key_prefix'])) {
            $this->cacheKeyPrefix = $config['cache_key_prefix'];
        }

        $this->config = $config;
    }
}
