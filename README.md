# check-if-email-exists

Check if an email address exists without sending any email. Use php `stream_socket_client`.

在不发送邮件的情况下检测邮件地址是否有效

# Usage

```shell
php check.php example@example.com
```

# ATTENTION! 注意！

这是一个**草稿**，仅仅提供思路，也许它只会在某些情况下工作（比如 `qq.com`）

这个工具依赖于 25 端口，然而部分服务商（TX Cloud）默认屏蔽了 25 端口，连不上 SMTP 服务器

部分邮件服务商会屏蔽家宽的 IP，导致 `RCPT TO` 不可用，因此本地测试可能会失败，比如微软和 Zoho

```
# Microsoft
550 5.7.1 Client host [49.*.*.*] blocked using Spamhaus. To request removal f
rom this list see http://www.spamhaus.org/lookup.lasso (S3130). [VE1EUR01FT012.e
op-EUR01.prod.protection.outlook.com]

# Zoho
550 Mail rejected by <Zoho Mail> for policy reasons. We generally do not accept
email from dynamic IP's as they are typically used to deliver unauthenticated SM
TP e-mail to an Internet mail server. http://www.spamhaus.org maintains lists of
 dynamic and residential IP addresses. If you are not an email/network admin ple
ase contact your E-mail/Internet Service Provider for help. Email/network admins
, please contact <support@zohomail.com> for email delivery information and suppo
rt
```

# 碎碎念

TL 里发现了 `amaurymartiny/check-if-email-exists`，一个同样功能的小脚本，然而实际上是跑不起来的，想提个 PR 改改，可惜不太会，就用 PHP 写了个同样功能的

## 原版草稿有哪些坑

- 默认域名就是邮件服务器，不会查询 MX 记录
- `OUPUT` 只会取到最后的 `221 Bye`（就是这个改不来