<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>管理员登录 - 海洋博物馆</title>
    <meta name="description" content="海洋博物馆管理系统登录">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&family=Noto+Serif+SC:wght@400;700&family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
    
    <!-- Animation Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    
    <style>
        :root {
            --ocean-deep: #0B1426;
            --ocean-blue: #1E3A5F;
            --coral-orange: #FF6B47;
            --sea-foam: #F0F8FF;
            --pearl-white: #FFFFFF;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Noto Sans SC', sans-serif;
            background: linear-gradient(135deg, var(--ocean-deep) 0%, var(--ocean-blue) 100%);
            color: var(--sea-foam);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .login-container {
            background: rgba(30, 58, 95, 0.3);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(240, 248, 255, 0.1);
            border-radius: 20px;
            padding: 3rem;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }
        
        .login-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        
        .login-title {
            font-family: 'Noto Serif SC', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--coral-orange);
            margin-bottom: 0.5rem;
        }
        
        .login-subtitle {
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--sea-foam);
        }
        
        .form-input {
            width: 100%;
            padding: 1rem;
            background: rgba(11, 20, 38, 0.5);
            border: 1px solid rgba(240, 248, 255, 0.2);
            border-radius: 10px;
            color: var(--sea-foam);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .form-input:focus {
            outline: none;
            border-color: var(--coral-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 71, 0.1);
        }
        
        .form-input::placeholder {
            color: rgba(240, 248, 255, 0.5);
        }
        
        .checkbox-group {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }
        
        .checkbox {
            width: 18px;
            height: 18px;
            margin-right: 0.5rem;
            accent-color: var(--coral-orange);
        }
        
        .checkbox-label {
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .login-button {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(45deg, var(--coral-orange), #FF8A65);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 1rem;
        }
        
        .login-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 71, 0.3);
        }
        
        .login-button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        
        .forgot-password {
            text-align: center;
            margin-top: 1rem;
        }
        
        .forgot-password a {
            color: var(--coral-orange);
            text-decoration: none;
            font-size: 0.9rem;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            background: rgba(220, 38, 38, 0.1);
            border: 1px solid rgba(220, 38, 38, 0.3);
            color: #fca5a5;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            display: none;
        }
        
        .success-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #86efac;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            display: none;
        }
        
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
        }
        
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        
        .fade-in {
            opacity: 0;
        }
        
        .navigation {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(11, 20, 38, 0.9);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(240, 248, 255, 0.1);
        }
        
        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .logo {
            font-family: 'ZCOOL KuaiLe', cursive;
            font-size: 1.5rem;
            color: var(--coral-orange);
            text-decoration: none;
        }
        
        .nav-links {
            display: flex;
            list-style: none;
            gap: 2rem;
        }
        
        .nav-link {
            color: var(--sea-foam);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--coral-orange);
        }
        
        @media (max-width: 768px) {
            .login-container {
                padding: 2rem;
                margin: 1rem;
            }
            
            .login-title {
                font-size: 1.5rem;
            }
            
            .nav-links {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- 导航栏 -->
    <nav class="navigation">
        <div class="nav-container">
            <a href="index.html" class="logo">🌊 海洋博物馆</a>
            <ul class="nav-links">
                <li><a href="index.html" class="nav-link">首页</a></li>
                <li><a href="exhibits.php" class="nav-link">展览</a></li>
                <li><a href="fish.php" class="nav-link">海洋生物</a></li>
                <li><a href="education.html" class="nav-link">教育活动</a></li>
                <li><a href="about.html" class="nav-link">关于我们</a></li>
                <li><a href="login.php" class="nav-link">登录</a></li>
            </ul>
        </div>
    </nav>

    <!-- 登录表单 -->
    <div class="login-container fade-in">
        <div class="login-header">
            <h1 class="login-title">管理员登录</h1>
            <p class="login-subtitle">请输入您的凭据访问管理系统</p>
        </div>
        
        <div id="error-message" class="error-message"></div>
        <div id="success-message" class="success-message"></div>
        
        <form id="login-form" method="POST" action="login.php">
            <div class="form-group">
                <label for="username" class="form-label">用户名</label>
                <input type="text" id="username" name="username" class="form-input" 
                       placeholder="请输入用户名" required autofocus>
            </div>
            
            <div class="form-group">
                <label for="password" class="form-label">密码</label>
                <input type="password" id="password" name="password" class="form-input" 
                       placeholder="请输入密码" required>
            </div>
            
            <div class="checkbox-group">
                <input type="checkbox" id="remember" name="remember" class="checkbox">
                <label for="remember" class="checkbox-label">记住我</label>
            </div>
            
            <button type="submit" class="login-button" id="login-btn">
                <span id="btn-text">登录</span>
                <span id="btn-loading" class="loading" style="display: none;"></span>
            </button>
        </form>
        
        <div class="forgot-password">
            <a href="#" onclick="showComingSoon()">忘记密码？</a>
        </div>
    </div>

    <!-- PHP登录处理 -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // 正确的管理员凭据
        $correct_username = 'admin';
        $correct_password = 'zhy@123456';
        
        // 检查用户名和密码
        if ($username === $correct_username && $password === $correct_password) {
            // 登录成功
            echo '<script>
                document.getElementById("success-message").style.display = "block";
                document.getElementById("success-message").textContent = "登录成功！正在跳转...";
                setTimeout(() => {
                    window.location.href = "welcome.html";
                }, 2000);
            </script>';
        } else {
            // 登录失败 - 这里存在暴力破解漏洞，没有登录尝试限制
            echo '<script>
                document.getElementById("error-message").style.display = "block";
                document.getElementById("error-message").textContent = "用户名或密码错误！";
            </script>';
        }
    }
    ?>

    <!-- JavaScript -->
    <script src="main.js"></script>
    
    <script>
        // 登录表单处理
        document.getElementById('login-form').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            if (!username || !password) {
                e.preventDefault();
                showError('请填写所有必填字段');
                return;
            }
            
            // 显示加载状态
            const loginBtn = document.getElementById('login-btn');
            const btnText = document.getElementById('btn-text');
            const btnLoading = document.getElementById('btn-loading');
            
            loginBtn.disabled = true;
            btnText.style.display = 'none';
            btnLoading.style.display = 'inline-block';
        });
        
        function showError(message) {
            const errorDiv = document.getElementById('error-message');
            errorDiv.textContent = message;
            errorDiv.style.display = 'block';
            
            setTimeout(() => {
                errorDiv.style.display = 'none';
            }, 5000);
        }
        
        function showComingSoon() {
            alert('功能即将上线，敬请期待！');
        }
        
        // 页面加载动画
        document.addEventListener('DOMContentLoaded', function() {
            anime({
                targets: '.fade-in',
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800,
                easing: 'easeOutQuad'
            });
        });
    </script>
</body>
</html>
