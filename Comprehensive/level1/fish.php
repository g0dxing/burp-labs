<?php
/* ---- 文件包含漏洞点 ---- */
if (!empty($_GET['page'])) {
    include $_GET['page'];   // 可被目录遍历 / 远程包含
    exit;
}
/* ------------------------ */

/* 原有鱼类数据逻辑不变 */
$fish_json = file_get_contents('data/fish-data.json');
$fish_data = json_decode($fish_json, true);
$fish_list = $fish_data['fish'];
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>海洋生物 - 海洋博物馆</title>
    <meta name="description" content="探索海洋生物多样性，了解各种海洋生物的特征和习性">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+SC:wght@300;400;500;700&family=Noto+Serif+SC:wght@400;700&family=ZCOOL+KuaiLe&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <style>
        :root{--ocean-deep:#0B1426;--ocean-blue:#1E3A5F;--coral-orange:#FF6B47;--sea-foam:#F0F8FF;--pearl-white:#FFFFFF;}
        body{font-family:'Noto Sans SC',sans-serif;background:linear-gradient(135deg,var(--ocean-deep) 0%,var(--ocean-blue) 100%);color:var(--sea-foam);min-height:100vh;margin:0;}
        .navigation{position:fixed;top:0;left:0;right:0;z-index:1000;background:rgba(11,20,38,.9);backdrop-filter:blur(10px);border-bottom:1px solid rgba(240,248,255,.1);}
        .nav-container{max-width:1200px;margin:0 auto;padding:1rem 2rem;display:flex;justify-content:space-between;align-items:center;}
        .logo{font-family:'ZCOOL KuaiLe',cursive;font-size:1.5rem;color:var(--coral-orange);text-decoration:none;}
        .nav-links{display:flex;list-style:none;gap:2rem;}
        .nav-link{color:var(--sea-foam);text-decoration:none;font-weight:500;transition:color .3s;}
        .nav-link:hover{color:var(--coral-orange);}
        .main-content{margin-top:80px;padding:3rem 0;}
        .page-header{text-align:center;margin-bottom:3rem;padding:0 2rem;}
        .page-title{font-family:'Noto Serif SC',serif;font-size:3rem;font-weight:700;color:var(--coral-orange);margin-bottom:1rem;}
        .page-subtitle{font-size:1.2rem;opacity:.8;max-width:600px;margin:0 auto;}
        .category-filters{display:flex;justify-content:center;gap:1rem;margin-bottom:3rem;flex-wrap:wrap;padding:0 2rem;}
        .category-btn{padding:.75rem 1.5rem;background:rgba(30,58,95,.3);border:1px solid rgba(240,248,255,.2);border-radius:25px;color:var(--sea-foam);cursor:pointer;transition:all .3s;font-weight:500;}
        .category-btn.active,.category-btn:hover{background:var(--coral-orange);border-color:var(--coral-orange);color:#fff;}
        .fish-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(350px,1fr));gap:2rem;max-width:1200px;margin:0 auto;padding:0 2rem;}
        .fish-card{background:rgba(30,58,95,.3);backdrop-filter:blur(10px);border:1px solid rgba(240,248,255,.1);border-radius:15px;overflow:hidden;transition:all .3s;cursor:pointer;opacity:0;}
        .fish-card:hover{transform:translateY(-5px);box-shadow:0 15px 35px rgba(0,0,0,.2);border-color:var(--coral-orange);}
        .fish-image{width:100%;height:200px;object-fit:cover;}
        .fish-content{padding:1.5rem;}
        .fish-name{font-size:1.3rem;font-weight:600;margin-bottom:.5rem;color:var(--sea-foam);}
        .fish-scientific{font-style:italic;opacity:.7;font-size:.9rem;margin-bottom:.5rem;}
        .fish-category{color:var(--coral-orange);font-size:.9rem;margin-bottom:1rem;font-weight:500;}
        .fish-description{opacity:.8;margin-bottom:1rem;line-height:1.6;font-size:.95rem;}
        .fish-stats{display:grid;grid-template-columns:repeat(2,1fr);gap:.5rem;margin-top:1rem;font-size:.9rem;}
        .fish-stat{display:flex;justify-content:space-between;padding:.25rem 0;border-bottom:1px solid rgba(240,248,255,.1);}
        .fish-stat-label{opacity:.7;}
        .fish-stat-value{font-weight:500;color:var(--coral-orange);}
        .conservation-status{position:absolute;top:1rem;right:1rem;padding:.25rem .75rem;border-radius:15px;font-size:.8rem;font-weight:500;}
        .status-stable{background:rgba(76,175,80,.2);color:#4caf50;}
        .status-vulnerable{background:rgba(255,193,7,.2);color:#ffc107;}
        .status-endangered{background:rgba(244,67,54,.2);color:#f44336;}
        .footer{background:var(--ocean-deep);padding:3rem 0 2rem;text-align:center;border-top:1px solid rgba(240,248,255,.1);margin-top:5rem;}
        .footer-content{max-width:1200px;margin:0 auto;padding:0 2rem;}
        .footer p{opacity:.7;margin-bottom:1rem;}
        @media (max-width:768px){.page-title{font-size:2rem;}.nav-links{display:none;}.fish-grid{grid-template-columns:1fr;padding:0 1rem;}}
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
        </ul>
    </div>
</nav>

<main class="main-content">
    <div class="page-header">
        <h1 class="page-title">海洋生物</h1>
        <p class="page-subtitle">探索海洋世界的生物多样性，了解各种海洋生物的特征、习性和保护现状</p>
    </div>

    <!-- 分类筛选 -->
    <div class="category-filters">
        <button class="category-btn active" data-category="all">全部</button>
        <button class="category-btn" data-category="哺乳动物">哺乳动物</button>
        <button class="category-btn" data-category="软骨鱼类">软骨鱼类</button>
        <button class="category-btn" data-category="刺胞动物">刺胞动物</button>
        <button class="category-btn" data-category="特色鱼类">特色鱼类</button>
        <button class="category-btn" data-category="软体动物">软体动物</button>
        <button class="category-btn" data-category="爬行动物">爬行动物</button>
        <button class="category-btn" data-category="棘皮动物">棘皮动物</button>
    </div>

    <!-- 鱼类网格 -->
    <div class="fish-grid" id="fish-grid">
        <?php foreach ($fish_list as $fish): ?>
            <div class="fish-card scroll-animate" data-category="<?= $fish['category'] ?>">
                <div style="position:relative;">
                    <div class="conservation-status status-<?=
                    $fish['conservation_status']==='稳定'?'stable':
                            ($fish['conservation_status']==='易危'?'vulnerable':'endangered') ?>">
                        <?= $fish['conservation_status'] ?>
                    </div>
                    <img src="<?= $fish['image'] ?>" alt="<?= $fish['name'] ?>" class="fish-image">
                </div>
                <div class="fish-content">
                    <h3 class="fish-name"><?= $fish['name'] ?></h3>
                    <p class="fish-scientific"><?= $fish['scientific_name'] ?></p>
                    <p class="fish-category"><?= $fish['category'] ?></p>
                    <p class="fish-description"><?= $fish['description'] ?></p>
                    <div class="fish-stats">
                        <div class="fish-stat"><span class="fish-stat-label">栖息地:</span><span class="fish-stat-value"><?= $fish['habitat'] ?></span></div>
                        <div class="fish-stat"><span class="fish-stat-label">深度:</span><span class="fish-stat-value"><?= $fish['depth'] ?></span></div>
                        <div class="fish-stat"><span class="fish-stat-label">寿命:</span><span class="fish-stat-value"><?= $fish['lifespan'] ?></span></div>
                        <div class="fish-stat"><span class="fish-stat-label">体长:</span><span class="fish-stat-value"><?= $fish['size'] ?></span></div>
                    </div>
                    <!-- 更多按钮（保留参数暴露） -->
                    <div class="mt-4 text-right">
                        <a href="detail.php?detail=<?= urlencode('data/'.$fish['id'].'.html') ?>"
                           target="_blank"
                           class="text-sm text-coral-orange hover:underline">
                            更多 →
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<footer class="footer">
    <div class="footer-content">
        <p>&copy; 2024 海洋博物馆. 保护海洋，从了解开始.</p>
        <p>地址：海洋大道123号 | 电话：400-123-4567 | 开放时间：周二至周日 9:00-17:00</p>
    </div>
</footer>

<!-- 分类筛选 JS（直接内联） -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const buttons = document.querySelectorAll('.category-btn');
        const cards   = document.querySelectorAll('.fish-card');

        buttons.forEach(btn => btn.addEventListener('click', function () {
            // 按钮状态
            buttons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const category = this.dataset.category;

            // 卡片筛选
            cards.forEach(card => {
                const cardCat = card.dataset.category;
                if (category === 'all' || cardCat === category) {
                    card.style.display = 'block';
                    anime({targets: card, opacity: [0, 1], scale: [0.8, 1], duration: 400, easing: 'easeOutQuad'});
                } else {
                    anime({targets: card, opacity: [1, 0], scale: [1, 0.8], duration: 400, easing: 'easeOutQuad', complete: () => card.style.display = 'none'});
                }
            });
        }));
    });
</script>
<script>
    /* 首次加载：立即显示全部卡片（不缩放） */
    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.fish-card');
        cards.forEach(card => {
            card.style.display = 'block';
            card.style.opacity = '1';
        });
    });
</script>
</body>
</html>