# Level 31 Writeup — 密码重置主机污染（中间件）

## 关卡目标
- 通过污染 `Host` 或 `X-Forwarded-Host` 等头部，劫持密码重置链接的主机部分。

## 场景概览
- 登录入口：`level31/login.html`
- 重置请求：`level31/forgot-password.html`、`level31/forgot-password.php`
- 邮箱模拟：`level31/mailbox.json`
- 重置令牌：`level31/tokens.json`
- 重置页：`level31/reset.php`
- 登录成功页：`level31/welcome.html`

## 核心缺陷
- 后端或中间件在生成重置链接时信任来源头部，导致主机名可被攻击者注入。

## 攻击步骤
1. 在请求中加入恶意 `X-Forwarded-Host` 或修改 `Host`，触发服务端生成带恶意主机的重置链接。
2. 受害者点击邮件中的链接时被引导至攻击者控制的域名或路径。

## 验证点与证据
- 邮件或 `mailbox.json` 中的链接主机名为攻击者指定值。

## 修复建议
- 在可信代理层规范化并擦除不可信头；服务端使用固定站点配置生成链接。
- 对外发邮件的链接进行签名与校验，避免被替换。

## 教学提示
- 主机污染常见于错误的代理信任链与链接生成逻辑。