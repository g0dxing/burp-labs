# Level 30 Writeup — Stay-logged-in Cookie 暴力破解

## 关卡目标
- 通过弱 Cookie 设计（可预测/低熵/无签名）进行暴力破解，伪装为已登录状态。

## 场景概览
- 登录入口：`level30/login.html`
- 登录后端：`level30/login.php`
- 账户页：`level30/account.php`
- 登出页：`level30/logout.php`

## 核心缺陷
- “保持登录” Cookie 未签名或熵不足，攻击者可伪造或爆破有效值。

## 攻击步骤
1. 观察 Cookie 名称与格式；尝试根据模式猜测/构造值。
2. 使用脚本或代理批量尝试 Cookie 值；观察是否进入账户页。

## 验证点与证据
- 未登录状态下仅依赖 Cookie 即可访问账户页。

## 修复建议
- 使用强随机、带签名的会话令牌；绑定设备/会话并设置合理过期。
- 服务端对关键页进行会话校验，拒绝仅凭 Cookie 的弱校验。

## 教学提示
- Cookie 安全是 Web 认证的核心，设计不当极易被滥用。