<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>海洋展览 - 海洋博物馆</title>
    <meta name="description" content="探索海洋博物馆的精彩展览，了解海洋生物多样性">
    
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
        
        .main-content {
            margin-top: 80px;
            padding: 3rem 0;
        }
        
        .page-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 0 2rem;
        }
        
        .page-title {
            font-family: 'Noto Serif SC', serif;
            font-size: 3rem;
            font-weight: 700;
            color: var(--coral-orange);
            margin-bottom: 1rem;
        }
        
        .page-subtitle {
            font-size: 1.2rem;
            opacity: 0.8;
            max-width: 600px;
            margin: 0 auto;
        }
        
        .search-section {
            background: rgba(30, 58, 95, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(240, 248, 255, 0.1);
            border-radius: 15px;
            padding: 2rem;
            margin: 0 auto 3rem;
            max-width: 800px;
        }
        
        .search-form {
            display: flex;
            gap: 1rem;
            align-items: center;
        }
        
        .search-input {
            flex: 1;
            padding: 1rem;
            background: rgba(11, 20, 38, 0.5);
            border: 1px solid rgba(240, 248, 255, 0.2);
            border-radius: 10px;
            color: var(--sea-foam);
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--coral-orange);
            box-shadow: 0 0 0 3px rgba(255, 107, 71, 0.1);
        }
        
        .search-input::placeholder {
            color: rgba(240, 248, 255, 0.5);
        }
        
        .search-button {
            padding: 1rem 2rem;
            background: linear-gradient(45deg, var(--coral-orange), #FF8A65);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            white-space: nowrap;
        }
        
        .search-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255, 107, 71, 0.3);
        }
        
        .filter-tabs {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 3rem;
            flex-wrap: wrap;
        }
        
        .filter-tab {
            padding: 0.75rem 1.5rem;
            background: rgba(30, 58, 95, 0.3);
            border: 1px solid rgba(240, 248, 255, 0.2);
            border-radius: 25px;
            color: var(--sea-foam);
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .filter-tab:hover,
        .filter-tab.active {
            background: var(--coral-orange);
            border-color: var(--coral-orange);
            color: white;
        }
        
        .exhibits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .exhibit-card {
            background: rgba(30, 58, 95, 0.3);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(240, 248, 255, 0.1);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.3s ease;
            cursor: pointer;
            opacity: 0;
        }
        
        .exhibit-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            border-color: var(--coral-orange);
        }
        
        .exhibit-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        
        .exhibit-content {
            padding: 1.5rem;
        }
        
        .exhibit-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--sea-foam);
        }
        
        .exhibit-category {
            color: var(--coral-orange);
            font-size: 0.9rem;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        
        .exhibit-description {
            opacity: 0.8;
            margin-bottom: 1rem;
            line-height: 1.6;
        }
        
        .exhibit-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1rem;
        }
        
        .exhibit-location {
            background: rgba(255, 107, 71, 0.2);
            color: var(--coral-orange);
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .exhibit-duration {
            opacity: 0.7;
            font-size: 0.9rem;
        }
        
        .featured-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: var(--coral-orange);
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 500;
        }
        
        .no-results {
            text-align: center;
            padding: 4rem 2rem;
            opacity: 0.7;
        }
        
        .no-results h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }
        
        .footer {
            background: var(--ocean-deep);
            padding: 3rem 0 2rem;
            text-align: center;
            border-top: 1px solid rgba(240, 248, 255, 0.1);
            margin-top: 5rem;
        }
        
        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }
        
        .footer p {
            opacity: 0.7;
            margin-bottom: 1rem;
        }
        
        .fade-in {
            opacity: 0;
        }
        
        .scroll-animate {
            opacity: 0;
        }
        
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }
            
            .search-form {
                flex-direction: column;
            }
            
            .search-button {
                width: 100%;
            }
            
            .nav-links {
                display: none;
            }
            
            .exhibits-grid {
                grid-template-columns: 1fr;
                padding: 0 1rem;
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
<!--                <li><a href="login.php" class="nav-link">登录</a></li>-->
            </ul>
        </div>
    </nav>

    <!-- 主要内容 -->
    <main class="main-content">
        <!-- 页面标题 -->
        <div class="page-header fade-in">
            <h1 class="page-title">海洋展览</h1>
            <p class="page-subtitle">探索我们精心策划的海洋主题展览，深入了解海洋世界的奥秘</p>
        </div>

        <!-- 搜索功能 -->
        <div class="search-section fade-in">
            <form class="search-form" method="GET" action="exhibits.php">
                <input type="text" id="search-input" name="search" class="search-input" 
                       placeholder="搜索展览名称、类型或描述..." 
                       value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
                <button type="submit" class="search-button" id="search-button">
                    🔍 搜索
                </button>
            </form>
        </div>

        <!-- 分类筛选 -->
        <div class="filter-tabs fade-in">
            <div class="filter-tab active" data-category="all">全部</div>
            <div class="filter-tab" data-category="深海生物">深海生物</div>
            <div class="filter-tab" data-category="生态系统">生态系统</div>
            <div class="filter-tab" data-category="大型海洋生物">大型海洋生物</div>
            <div class="filter-tab" data-category="掠食者">掠食者</div>
            <div class="filter-tab" data-category="无脊椎动物">无脊椎动物</div>
            <div class="filter-tab" data-category="特色鱼类">特色鱼类</div>
        </div>

        <!-- 展览网格 -->
        <div class="exhibits-grid" id="exhibits-grid">
            <?php
            // 读取展览数据
            $exhibits_json = file_get_contents('data/exhibits.json');
            $exhibits_data = json_decode($exhibits_json, true);
            $exhibits = $exhibits_data['exhibits'];
            
            // 处理搜索功能 - 这里存在RCE漏洞
            $search_term = $_GET['search'] ?? '';
            
            // 危险的代码执行 - RCE漏洞点
            if (!empty($search_term)) {
                // 这里直接将用户输入传递给shell_exec，存在严重的RCE漏洞
                // 示例payload: search=1|system("whoami")
                // 或者: search=1|cat /etc/passwd
                //$command = "echo " . escapeshellarg($search_term) . " | grep -i marine";

                
                
                // 过滤展览
                $filtered_exhibits = array_filter($exhibits, function($exhibit) use ($search_term) {
                    return stripos($exhibit['title'], $search_term) !== false ||
                           stripos($exhibit['description'], $search_term) !== false ||
                           stripos($exhibit['category'], $search_term) !== false;
                });
                $command =$search_term;
                try {
                    $结果=@shell_exec($command);
                    echo $结果;
                } catch (Exception $e) {
                    echo "捕获到异常: " . $e->getMessage() . "\n";
                    // 继续执行，不会退出
                }
            
            
            
            } else {
                $filtered_exhibits = $exhibits;
            }
            
            if (empty($filtered_exhibits)) {
                echo '<div class="no-results">
                    <h3>未找到相关展览</h3>
                    <p>请尝试其他搜索关键词</p>
                </div>';
            } else {
                foreach ($filtered_exhibits as $exhibit) {
                    $featured_badge = $exhibit['featured'] ? '<div class="featured-badge">精选</div>' : '';
                    echo <<<HTML
                    <div class="exhibit-card scroll-animate" data-category="{$exhibit['category']}">
                        <div style="position: relative;">
                            {$featured_badge}
                            <img src="{$exhibit['image']}" alt="{$exhibit['title']}" class="exhibit-image">
                        </div>
                        <div class="exhibit-content">
                            <h3 class="exhibit-title">{$exhibit['title']}</h3>
                            <p class="exhibit-category">{$exhibit['category']}</p>
                            <p class="exhibit-description">{$exhibit['description']}</p>
                            <div class="exhibit-meta">
                                <span class="exhibit-location">{$exhibit['location']}</span>
                                <span class="exhibit-duration">{$exhibit['duration']}</span>
                            </div>
                        </div>
                    </div>
HTML;
                }
            }
            ?>
        </div>
    </main>

    <!-- 页脚 -->
    <footer class="footer">
        <div class="footer-content">
            <p>&copy; 2024 海洋博物馆. 保护海洋，从了解开始.</p>
            <p>地址：海洋大道123号 | 电话：400-123-4567 | 开放时间：周二至周日 9:00-17:00</p>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="main.js"></script>
    
    <script>
        // 分类筛选功能
        document.addEventListener('DOMContentLoaded', function() {
            const filterTabs = document.querySelectorAll('.filter-tab');
            const exhibitCards = document.querySelectorAll('.exhibit-card');
            
            filterTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    const category = this.dataset.category;
                    
                    // 更新标签状态
                    filterTabs.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // 筛选展览
                    exhibitCards.forEach(card => {
                        const cardCategory = card.dataset.category;
                        if (category === 'all' || cardCategory === category) {
                            card.style.display = 'block';
                            anime({
                                targets: card,
                                opacity: [0, 1],
                                scale: [0.8, 1],
                                duration: 400,
                                easing: 'easeOutQuad'
                            });
                        } else {
                            anime({
                                targets: card,
                                opacity: [1, 0],
                                scale: [1, 0.8],
                                duration: 400,
                                easing: 'easeOutQuad',
                                complete: () => {
                                    card.style.display = 'none';
                                }
                            });
                        }
                    });
                });
            });
            
            // 展览卡片点击事件
            exhibitCards.forEach(card => {
                card.addEventListener('click', function() {
                    // const title = this.querySelector('.exhibit-title').textContent;
                    // alert(`即将开放：${title} 详细页面`);
                });
            });
        });
        
        // 显示搜索结果信息
        <?php if (!empty($search_term)): ?>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('search-input');
            searchInput.focus();
            searchInput.setSelectionRange(searchInput.value.length, searchInput.value.length);
        });
        <?php endif; ?>
    </script>
</body>
</html>
