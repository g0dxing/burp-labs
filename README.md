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

### 🏗️ 项目结构
```
burp-labs/
├── base/           # 基础篇 - 入门级爆破技术
├── middle/         # 中级篇 - 进阶攻击技巧  
├── high/           # 高级篇 - 复杂编码处理
├── Expert/         # 专家篇 - 高级防护绕过
├── common/         # 公共库 - UI组件与核心逻辑
└── index.html      # 主入口页面
```

## 🗂️ 关卡详解

### 🟢 基础篇 - 入门级爆破技术

| 关卡 | 难度 | 核心技能 | 技术要点 |
|------|------|----------|----------|
| **Level 1** | ⭐ | 基础爆破 | GET请求、基础攻击器使用 |
| **Level 2** | ⭐ | 响应过滤 | 长度一致场景下的过滤器应用 |
| **Level 3** | ⭐⭐ | 用户名枚举 | 固定用户名的密码爆破 |

### 🟡 中级篇 - 进阶攻击技巧

| 关卡 | 难度 | 核心技能 | 技术要点 |
|------|------|----------|----------|
| **Level 4** | ⭐⭐ | Base64编码 | 客户端编码的识别和绕过 |
| **Level 5** | ⭐⭐ | MD5加密 | 哈希加密的爆破策略 |
| **Level 6** | ⭐⭐ | 302重定向 | 重定向场景下的爆破判断 |

### 🟠 高级篇 - 复杂编码处理

| 关卡 | 难度 | 核心技能 | 技术要点 |
|------|------|----------|----------|
| **Level 7** | ⭐⭐⭐ | 多参数加密 | 复杂的多参数加密爆破 |
| **Level 8** | ⭐⭐⭐ | 前缀处理 | 固定前缀的密码构造 |
| **Level 9** | ⭐⭐⭐⭐ | 时间戳验证 | 时效性token的处理 |
| **Level 10** | ⭐⭐⭐ | JSON格式 | JSON数据结构的处理 |
| **Level 11** | ⭐⭐⭐⭐ | Base64+JSON | 多重编码的层层解析 |
| **Level 12** | ⭐⭐⭐⭐ | 复杂编码 | JSON→Base64→MD5三重转换 |

### 🔴 专家篇 - 高级防护绕过

| 关卡 | 难度 | 核心技能 | 技术要点 |
|------|------|----------|----------|
| **Level 13** | ⭐⭐⭐⭐⭐ | 频率限制 | Session控制的请求频率绕过 |
| **Level 14** | ⭐⭐⭐⭐⭐ | 2FA简单绕过 | 双因素认证绕过技术 |
| **Level 15** | ⭐⭐⭐⭐⭐ | 密码重置逻辑缺陷 | 密码重置流程漏洞利用 |
| **Level 16** | ⭐⭐⭐⭐ | 用户名枚举(响应时间) | 基于响应时间的用户枚举 |
| **Level 17** | ⭐⭐⭐ | IP封禁防护缺陷 | IP封锁机制绕过 |
| **Level 18** | ⭐⭐⭐⭐ | 用户名枚举(账户锁定) | 基于账户锁定的用户枚举 |
| **Level 19** | ⭐⭐⭐⭐ | 2FA逻辑缺陷 | 双因素认证逻辑漏洞 |
| **Level 20** | ⭐⭐⭐⭐ | 密码重置主机污染 | X-Forwarded-Host头部劫持 |
| **Level 21** | ⭐⭐⭐⭐ | 密码修改页面枚举 | 错误消息差异导致的密码枚举 |

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

## 👥 维护团队

- **g0dxing** - 项目创建者 & 项目维护
- **雾島风起時** - 联合开发 & 技术文档

## ⚠️ 免责声明

**重要提示**: 本靶场仅用于**教育目的**和**授权测试**。请勿将所学技术用于非法用途。使用者需遵守当地法律法规，对使用本工具造成的任何后果负责。

---

**开始你的 Burp Suite 学习之旅！从 Level 1 开始，逐步成为 Web 安全专家。** 🚀
