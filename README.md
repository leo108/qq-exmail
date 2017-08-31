# qq-exmail
新版 QQ 企业邮箱接口 SDK，接口文档 https://exmail.qq.com/qy_mng_logic/doc#10001

## 安装

`composer require leo108/qq-exmail -vvv`

## 快速开始

```
$config = [
    'corp_id'      => 'CORP_ID',
    'corp_secrets' => [
        'contact'          => '通讯录管理 Secret',
        'unique_login'     => '单点登录 Secret',
        'mail_notice'      => '新邮件提醒 Secret',
        'function_setting' => '功能设置 Secret',
        'system_log'       => '日志查询 Secret'
    ],
    'log'          => [
        'format'            => '{method} {url} {code} {res_header_Content-Length}',
        'hide_access_token' => true,
    ],
];
$exmail = new Leo108\QQExmail\QQExmail($config);

// 创建一个新用户， 更多参数请参考 API 文档
$exmail->user->create([
    'userid'     => 'leo108@exmail.com',
    'name'       => 'leo108',
    'department' => [1],
    'password'   => 'secret',
    'gender'     => Leo108\QQExmail\Contact\User::GENDER_MALE,   // 如果你不想踩坑，还是乖乖用我提供的常量吧 :)
]);
```

## 构造函数

```
public function __construct(
    array $config = [],
    Psr\SimpleCache\CacheInterface $cache = null,
    GuzzleHttp\ClientInterface $httpClient = null,
    Psr\Log\LoggerInterface $logger = null
) 
```

* 第一个参数为配置项。
* 第二个参数是一个符合 PSR-16 规范的缓存对象，用于保存各个应用的 access token，如果不存则默认使用内存缓存，即每次生命周期的各个应用第一次请求都会先通过 api 获得对应的 access token。
* 第三个参数是一个 GuzzleHttp 对象，没有特殊需求可以保持 `null`。
* 第四个参数是一个符合 PSR-3 规范的日志对象，用于打印日志，如果留空则不答应任何日志。

## 配置项

* `corp_id` 可以在企业邮箱的"工具箱"->"应用中心"页面最下方找到。
* `corp_secrets` 从"应用中心"页面进入各个应用，可以找到对应的 secret。对于用不到的应用，可以不配置对应的 secret。
* `log.format` 定义日志格式，各个字段可以参考 https://github.com/guzzle/guzzle/blob/master/src/MessageFormatter.php
* `log.hide_access_token` 如果设定为 `true` 则会隐藏日志中 access token 的值，避免 token 泄露。

## 异常

本 SDK 中所有的异常均继承自 `Leo108\QQExmail\Core\Exceptions\QQExmailException`

* `Leo108\QQExmail\Core\Exceptions\GetAccessTokenException` 使用 corp id 和 corp secret 换取 access token 失败
* `Leo108\QQExmail\Core\Exceptions\MissingSecretException` 使用应用却没有配置该应用的 secret
* `Leo108\QQExmail\Core\Exceptions\InvalidArgumentException` 初始化时传入的配置有误
* `Leo108\QQExmail\Core\Exceptions\ApiException` 当 API 接口返回的 errcode 字段不为 0 时抛出

## API 列表

### 部门管理

创建部门 https://exmail.qq.com/qy_mng_logic/doc#10008

```
$exmail->department->create([
    'name' => '技术部',
    'parentid' => 1,
]);
```

更新部门 https://exmail.qq.com/qy_mng_logic/doc#10009

```
$exmail->department->update($departmentId, [
    'name' => '技术部',
    'parentid' => 1,
    'order' => 100
]);
```

删除部门 https://exmail.qq.com/qy_mng_logic/doc#10010

```
$exmail->department->delete($departmentId);
```

获取部门列表 https://exmail.qq.com/qy_mng_logic/doc#10011

```
// 获取全部部门
$exmail->department->departmentList();

// 获取 $departmentId 部门及其子部门
$exmail->department->departmentList($departmentId);
```

查找部门 https://exmail.qq.com/qy_mng_logic/doc#10012

```
$exmail->department->search('关键词', true); // 第二个参数为 true 时则为模糊搜索
```

### 成员管理

创建成员 https://exmail.qq.com/qy_mng_logic/doc#10014

```
$exmail->user->create([
    'userid'     => 'leo108@exmail.com',
    'name'       => 'leo108',
    'department' => [1],
    'password'   => 'secret',
    'gender'     => Leo108\QQExmail\Contact\User::GENDER_MALE,
]);
```

更新成员 https://exmail.qq.com/qy_mng_logic/doc#10015

```
$exmail->user->update('leo108@exmail.com', [
    'name' => 'Leo Chen',
]);
```

删除成员 https://exmail.qq.com/qy_mng_logic/doc#10016

```
$exmail->user->delete('leo108@exmail.com');
```

获取成员 https://exmail.qq.com/qy_mng_logic/doc#10017

```
$exmail->user->get('leo108@exmail.com');
```

获取部门成员 https://exmail.qq.com/qy_mng_logic/doc#10018

```
$exmail->user->simpleList($departmentId, true); // 第二个参数为 true 时递归获取子部门成员
```

获取部门成员（详情） https://exmail.qq.com/qy_mng_logic/doc#10019

```
$exmail->user->userList($departmentId, true); // 第二个参数为 true 时递归获取子部门成员
```

批量检查帐号 https://exmail.qq.com/qy_mng_logic/doc#10020

```
$exmail->user->batchCheck(['leo108@exmail.com', 'test@exmail.com']);
```

### 邮件群组管理

创建邮件群组 https://exmail.qq.com/qy_mng_logic/doc#10022

```
$exmail->group->create([
    'groupid'    => 'group_name@exmail.com',
    'groupname'  => '测试邮件群组',
    'userlist'   => ['leo108@exmail.com', 'test@exmail.com'],
    'allow_type' => Leo108\QQExmail\Contact\Group::ALLOW_TYPE_ALL,
]);
```

更新邮件群组 https://exmail.qq.com/qy_mng_logic/doc#10023

```
$exmail->group->update('group_name@exmail.com', [
    'groupname' => '技术部邮件组',
]);
```

删除邮件群组 https://exmail.qq.com/qy_mng_logic/doc#10024

```
$exmail->group->delete('group_name@exmail.com');
```

获取邮件群组信息 https://exmail.qq.com/qy_mng_logic/doc#10025

```
$exmail->group->get('group_name@exmail.com');
```

### 功能设置

获取功能属性 https://exmail.qq.com/qy_mng_logic/doc#10047

```
$exmail->userOption->get('leo108@exmail.com', [
    Leo108\QQExmail\FunctionSetting\UserOption::TYPE_FORCE_SSL,
    Leo108\QQExmail\FunctionSetting\UserOption::TYPE_IMAP_SMTP,
    Leo108\QQExmail\FunctionSetting\UserOption::TYPE_POP_SMTP,
    Leo108\QQExmail\FunctionSetting\UserOption::TYPE_ENABLE_SSL,
]);
```

更改功能属性 https://exmail.qq.com/qy_mng_logic/doc#10048

```
$exmail->userOption->update('leo108@exmail.com', [
    ['type' => Leo108\QQExmail\FunctionSetting\UserOption::TYPE_FORCE_SSL, 'value' => '1'],
    ['type' => Leo108\QQExmail\FunctionSetting\UserOption::TYPE_IMAP_SMTP, 'value' => '1'],
    ['type' => Leo108\QQExmail\FunctionSetting\UserOption::TYPE_POP_SMTP, 'value' => '1'],
    ['type' => Leo108\QQExmail\FunctionSetting\UserOption::TYPE_ENABLE_SSL, 'value' => '1'],
]);
```

### 系统日志

查询邮件概况 https://exmail.qq.com/qy_mng_logic/doc#10027

```
$exmail->log->mailStatus('exmail.com', '2016-10-01', '2016-10-07');
```

查询邮件 https://exmail.qq.com/qy_mng_logic/doc#10028

```
$exmail->log->mail(Leo108\QQExmail\SystemLog\Log::MAIL_TYPE_RECEIVE_AND_SEND, '2016-10-01', '2016-10-07', [
    'userid'  => 'leo108@exmail.com',
    'subject' => '查询关键词'
]);
```

查询成员登录 https://exmail.qq.com/qy_mng_logic/doc#10029

```
$exmail->log->login('leo108@exmail.com', '2016-10-01', '2016-10-07');
```

查询批量任务 https://exmail.qq.com/qy_mng_logic/doc#10030

```
$exmail->log->batchJob('2016-10-01', '2016-10-07');
```

查询操作记录 https://exmail.qq.com/qy_mng_logic/doc#10031

```
$exmail->log->operation(Leo108\QQExmail\SystemLog\Log::OPERATION_TYPE_ALL, '2016-10-01', '2016-10-07');
```

### 新邮件提醒

获取邮件未读数 https://exmail.qq.com/qy_mng_logic/doc#10033

```
$exmail->mail->newAccount('leo108@exmail.com', '2016-10-01', '2016-10-07');
```

获取邮件未读数（回调模式）尚未实现

### 单点登录

获取登录企业邮的url https://exmail.qq.com/qy_mng_logic/doc#10036

```
$exmail->uniqueLogin->getLoginUrl('leo108@exmail.com');
```
