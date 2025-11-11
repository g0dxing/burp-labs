# Burp-Labs 靶场实验室

![Burp-Labs](https://img.shields.io/badge/Burp--Labs-Web%20Security%20Range-blue)
![License](https://img.shields.io/badge/License-MIT-green)
![PHP](https://img.shields.io/badge/PHP-7.0%2B-purple)
![Difficulty](https://img.shields.io/badge/Difficulty-Beginner%20to%20Expert-orange)

一个专为学习 **Burp Suite** 安全测试工具设计的综合性靶场项目，通过渐进式难度设计，帮助安全爱好者系统掌握 Web 应用爆破攻击的各种技术和场景。

## 📋 项目概览

### 🎯 项目特色
- **渐进式学习路径** - 从基础到专家，循序渐进掌握爆破技术
- **真实场景模拟** - 模拟各类 Web 应用安全防护机制
- **全面技术覆盖** - 涵盖编码、加密、频率限制等核心防护手段
- **详细技术文档** - 每个关卡都有明确的学习目标和解决方案

### 🏗️ 项目结构
```
burp-labs/
├── base/           # 基础篇 - 入门级爆破技术
├── middle/         # 中级篇 - 进阶攻击技巧  
├── high/           # 高级篇 - 复杂编码处理
├── Expert/         # 专家篇 - 高级防护绕过
├── Comprehensive/  # 综合篇 - 实战场景演练
├── writeups/       # 技术解析文档
└── index.html      # 主入口页面
```

## 🗂️ 关卡详解

### 🟢 基础篇 - 入门级爆破技术

| 关卡 | 难度 | 核心技能 | 技术要点 | writeup |
|------|------|----------|----------|-----------|
| **Level 1** | ⭐ | 基础爆破 | GET请求、基础攻击器使用 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 2** | ⭐ | 响应过滤 | 长度一致场景下的过滤器应用 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 3** | ⭐⭐ | 用户名枚举 | 固定用户名的密码爆破 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 4** | ⭐⭐ | 高级过滤 | 用户名固定+长度一致的双重挑战 | [关卡解析(暂无)](writeups/nowriteup.md) |

### 🟡 中级篇 - 进阶攻击技巧

| 关卡 | 难度 | 核心技能 | 技术要点 | writeup |
|------|------|----------|----------|-----------|
| **Level 1** | ⭐⭐ | POST攻击 | POST请求处理、参数构造 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 2** | ⭐⭐⭐ | 中文响应 | 非英文响应的结果识别 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 3** | ⭐⭐⭐ | 重定向处理 | 302跳转的成功判断 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 4** | ⭐⭐ | Base64编码 | 客户端编码的识别和绕过 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 5** | ⭐⭐ | MD5加密 | 哈希加密的爆破策略 | [关卡解析(暂无)](writeups/nowriteup.md) |

### 🟠 高级篇 - 复杂编码处理

| 关卡 | 难度 | 核心技能 | 技术要点 | writeup |
|------|------|----------|----------|-----------|
| **Level 1** | ⭐⭐⭐ | 双参数攻击 | Pitchfork模式、MD5校验 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 2** | ⭐⭐⭐ | 前缀处理 | 固定前缀的密码构造 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 3** | ⭐⭐⭐⭐ | 时间戳验证 | 时效性token的处理 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 4** | ⭐⭐⭐ | JSON格式 | JSON数据结构的处理 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 5** | ⭐⭐⭐⭐ | Base64+JSON | 多重编码的层层解析 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 6** | ⭐⭐⭐⭐ | JSON+MD5 | 哈希化的JSON数据处理 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 7** | ⭐⭐⭐⭐⭐ | 复杂编码 | JSON→Base64→MD5三重转换 | [关卡解析(暂无)](writeups/nowriteup.md) |

### 🔴 专家篇 - 高级防护绕过

| 关卡 | 难度 | 核心技能 | 技术要点 | writeup |
|------|------|----------|----------|-----------|
| **Level 1** | ⭐⭐⭐⭐⭐ | 频率限制 | Session控制的请求频率绕过 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 2** | ⭐⭐⭐⭐⭐ | MD5加盐 | 盐+文本的MD5加盐模式 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 3** | ⭐⭐⭐⭐⭐ | HMAC MD5 | HMAC MD5加盐，信息收集能力 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 4** | ⭐⭐⭐⭐ | 脚本辅助 | Python脚本在复杂场景中的应用 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 5** | ⭐⭐⭐ | 用户枚举与暴力破解 | 用户名枚举技术 | [关卡解析](writeups/Expert/level5.md) |
| **Level 6** | ⭐⭐⭐⭐ | 2FA简单绕过 | 双因素认证绕过技术 | [关卡解析](writeups/Expert/level6.md) |
| **Level 7** | ⭐⭐⭐⭐ | 密码重置逻辑缺陷 | 密码重置流程漏洞利用 | [关卡解析](writeups/Expert/level7.md) |
| **Level 8** | ⭐⭐⭐⭐ | 用户名枚举(响应时间) | 基于响应时间的用户枚举 | [关卡解析](writeups/Expert/level8.md) |
| **Level 9** | ⭐⭐⭐⭐ | IP封禁防护缺陷 | IP封锁机制绕过 | [关卡解析](writeups/Expert/level9.md) |
| **Level 10** | ⭐⭐⭐⭐ | 用户名枚举(账户锁定) | 基于账户锁定的用户枚举 | [关卡解析](writeups/Expert/level10.md) |
| **Level 11** | ⭐⭐⭐⭐ | 2FA逻辑缺陷 | 双因素认证逻辑漏洞 | [关卡解析](writeups/Expert/level11.md) |
| **Level 12** | ⭐⭐⭐⭐ | Stay-logged-in Cookie | Cookie暴力破解技术 | [关卡解析](writeups/Expert/level12.md) |
| **Level 13** | ⭐⭐⭐⭐ | 密码重置主机污染 | X-Forwarded-Host头部劫持 | [关卡解析](writeups/Expert/level13.md) |
| **Level 14** | ⭐⭐⭐⭐ | 密码修改页面枚举 | 错误消息差异导致的密码枚举 | [关卡解析](writeups/Expert/level14.md) |
| **Level 15** | ⭐⭐⭐⭐ | 多凭证一请求 | 批量凭证提交的防护缺陷 | [关卡解析](writeups/Expert/level15.md) |

### 🟣 综合篇 - 实战场景演练

| 关卡 | 难度 | 核心技能 | 技术要点 | writeup |
|------|------|----------|----------|-----------|
| **Level 1** | ⭐⭐⭐⭐ | 海洋博物馆 | 信息收集能力及针对性字典生成 | [关卡解析(暂无)](writeups/nowriteup.md) |
| **Level 2** | ⭐⭐⭐⭐⭐ | 外贸B2B平台 | 弱密码爆破、综合渗透测试能力 | [关卡解析(暂无)](writeups/nowriteup.md) |

## 🚀 快速开始

### 环境要求
- **PHP**: 7.0 或更高版本
- **Web服务器**: Apache / Nginx
- **Burp Suite**: Professional 版本
- **浏览器**: Chrome / Firefox 等现代浏览器

### 安装步骤

1. **克隆项目**
   ```bash
   git clone https://github.com/g0dxing/burp-labs.git
   cd burp-labs
   ```

2. **部署到Web服务器**
   ```bash
   # 如果是Apache，复制到Web目录
   sudo cp -r burp-labs /var/www/html/
   
   # 设置权限
   sudo chmod -R 755 /var/www/html/burp-labs
   ```

3. **配置Burp Suite**
   - 启动 Burp Suite Professional
   - 配置浏览器代理: `127.0.0.1:8080`
   - 安装 Burp CA 证书

4. **开始挑战**
   - 访问: `http://localhost/burp-labs/`
   - 从 Level 1 开始逐步挑战


## 🛠️ 技术架构

### 前端技术栈
- **HTML5** + **CSS3** - 响应式界面设计
- **JavaScript** - 客户端加密/编码逻辑
- **现代UI组件** - 用户体验优化

### 后端技术栈
- **PHP** - 业务逻辑处理
- **Session管理** - 用户状态维护
- **文件存储** - JSON数据持久化

### 安全机制模拟
- **编码方式**: Base64, JSON, URL Encoding
- **加密算法**: MD5, HMAC-MD5, 加盐哈希
- **防护机制**: 频率限制, IP封锁, 账户锁定
- **验证方式**: 2FA, 时间戳验证, Token验证

## 📚 学习指南

### 新手入门路径
1. **基础篇 (1-4)**: 掌握Burp Suite基本操作
2. **中级篇 (1-5)**: 学习各种请求处理和编码识别
3. **高级篇 (1-7)**: 掌握复杂场景下的攻击技巧

### 进阶提升路径
1. **专家篇 (1-16)**: 深入理解各类防护机制的绕过
2. **综合篇 (1-2)**: 在真实场景中应用所学技能



## 🤝 贡献指南

我们欢迎各种形式的贡献！

### 贡献方式
1. **新增关卡**: 设计具有教育意义的挑战场景
2. **代码优化**: 改进现有代码结构和性能
3. **文档完善**: 补充技术文档和使用说明
4. **Bug修复**: 发现并修复程序缺陷

### 提交规范
- 使用清晰的提交信息
- 确保代码符合项目规范
- 新增功能需包含相应文档


## 👥 维护团队

- **g0dxing** - 项目创建者 & 项目维护
- **雾島风起時** - 联合开发 & 技术文档

## 🙏 致谢

感谢所有为这个项目贡献代码和创意的安全爱好者们！

---

## ⚠️ 免责声明

**重要提示**: 本靶场仅用于**教育目的**和**授权测试**。请勿将所学技术用于非法用途。使用者需遵守当地法律法规，对使用本工具造成的任何后果负责。

---

**开始你的 Burp Suite 学习之旅！从 Level 1 开始，逐步成为 Web 安全专家。** 🚀