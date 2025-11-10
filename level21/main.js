// 海洋博物馆主要JavaScript文件
// 包含所有页面的动画效果和交互功能

class OceanMuseum {
    constructor() {
        this.currentPage = this.getCurrentPage();
        this.init();
    }

    getCurrentPage() {
        const path = window.location.pathname;
        if (path.includes('login.php')) return 'login';
        if (path.includes('exhibits.php')) return 'exhibits';
        if (path.includes('fish.php')) return 'fish';
        if (path.includes('education.html')) return 'education';
        if (path.includes('about.html')) return 'about';
        return 'index';
    }

    init() {
        this.initCommonFeatures();
        this.initPageSpecificFeatures();
        this.initScrollAnimations();
        this.initParticleSystem();
    }

    initCommonFeatures() {
        // 导航菜单动画
        this.initNavigation();
        
        // 页面加载动画
        this.initPageLoadAnimations();
        
        // 通用交互效果
        this.initHoverEffects();
    }

    initNavigation() {
        const navLinks = document.querySelectorAll('.nav-link');
        navLinks.forEach(link => {
            link.addEventListener('mouseenter', () => {
                anime({
                    targets: link,
                    scale: 1.1,
                    duration: 300,
                    easing: 'easeOutQuad'
                });
            });

            link.addEventListener('mouseleave', () => {
                anime({
                    targets: link,
                    scale: 1,
                    duration: 300,
                    easing: 'easeOutQuad'
                });
            });
        });
    }

    initPageLoadAnimations() {
        // 页面元素渐入动画
        const elements = document.querySelectorAll('.fade-in');
        elements.forEach((element, index) => {
            anime({
                targets: element,
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 800,
                delay: index * 100,
                easing: 'easeOutQuad'
            });
        });
    }

    initHoverEffects() {
        // 卡片悬停效果
        const cards = document.querySelectorAll('.card-hover');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                anime({
                    targets: card,
                    scale: 1.05,
                    rotateY: 5,
                    rotateX: 5,
                    boxShadow: '0 20px 40px rgba(0,0,0,0.2)',
                    duration: 400,
                    easing: 'easeOutQuad'
                });
            });

            card.addEventListener('mouseleave', () => {
                anime({
                    targets: card,
                    scale: 1,
                    rotateY: 0,
                    rotateX: 0,
                    boxShadow: '0 4px 6px rgba(0,0,0,0.1)',
                    duration: 400,
                    easing: 'easeOutQuad'
                });
            });
        });
    }

    initScrollAnimations() {
        // 滚动触发动画
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-animate').forEach(el => {
            observer.observe(el);
        });
    }

    animateElement(element) {
        const animationType = element.dataset.animation || 'fadeInUp';
        
        switch(animationType) {
            case 'fadeInUp':
                anime({
                    targets: element,
                    opacity: [0, 1],
                    translateY: [50, 0],
                    duration: 800,
                    easing: 'easeOutQuad'
                });
                break;
            case 'fadeInLeft':
                anime({
                    targets: element,
                    opacity: [0, 1],
                    translateX: [-50, 0],
                    duration: 800,
                    easing: 'easeOutQuad'
                });
                break;
            case 'scaleIn':
                anime({
                    targets: element,
                    opacity: [0, 1],
                    scale: [0.8, 1],
                    duration: 800,
                    easing: 'easeOutQuad'
                });
                break;
        }
    }

    initParticleSystem() {
        // 粒子系统 - 模拟海洋中的浮游生物和气泡
        if (typeof PIXI !== 'undefined' && document.getElementById('particle-container')) {
            this.createParticleSystem();
        }
    }

    createParticleSystem() {
        const app = new PIXI.Application({
            width: window.innerWidth,
            height: window.innerHeight,
            backgroundColor: 0x000000,
            backgroundAlpha: 0
        });

        const container = document.getElementById('particle-container');
        if (container) {
            container.appendChild(app.view);
            
            // 创建粒子
            const particles = [];
            for (let i = 0; i < 50; i++) {
                const particle = new PIXI.Graphics();
                particle.beginFill(0x87CEEB, 0.3);
                particle.drawCircle(0, 0, Math.random() * 3 + 1);
                particle.endFill();
                
                particle.x = Math.random() * app.screen.width;
                particle.y = Math.random() * app.screen.height;
                particle.vx = (Math.random() - 0.5) * 0.5;
                particle.vy = (Math.random() - 0.5) * 0.5;
                
                app.stage.addChild(particle);
                particles.push(particle);
            }

            // 动画循环
            app.ticker.add(() => {
                particles.forEach(particle => {
                    particle.x += particle.vx;
                    particle.y += particle.vy;
                    
                    // 边界检查
                    if (particle.x < 0) particle.x = app.screen.width;
                    if (particle.x > app.screen.width) particle.x = 0;
                    if (particle.y < 0) particle.y = app.screen.height;
                    if (particle.y > app.screen.height) particle.y = 0;
                });
            });
        }
    }

    initPageSpecificFeatures() {
        switch(this.currentPage) {
            case 'index':
                this.initIndexPage();
                break;
            case 'exhibits':
                this.initExhibitsPage();
                break;
            case 'fish':
                this.initFishPage();
                break;
            case 'education':
                this.initEducationPage();
                break;
        }
    }

    initIndexPage() {
        // 英雄区域文字动画
        this.initHeroAnimations();
        
        // 展览轮播
        this.initExhibitionCarousel();
        
        // 统计数据动画
        this.initStatsAnimation();
    }

    initHeroAnimations() {
        const heroTitle = document.querySelector('.hero-title');
        const heroSubtitle = document.querySelector('.hero-subtitle');
        
        if (heroTitle) {
            // 文字分割动画
            const text = heroTitle.textContent;
            heroTitle.innerHTML = text.split('').map(char => 
                `<span class="char">${char}</span>`
            ).join('');
            
            anime({
                targets: '.char',
                opacity: [0, 1],
                translateY: [50, 0],
                duration: 800,
                delay: anime.stagger(50),
                easing: 'easeOutQuad'
            });
        }

        if (heroSubtitle) {
            anime({
                targets: heroSubtitle,
                opacity: [0, 1],
                translateY: [30, 0],
                duration: 1000,
                delay: 1000,
                easing: 'easeOutQuad'
            });
        }
    }

    initExhibitionCarousel() {
        if (typeof Splide !== 'undefined') {
            const splide = new Splide('.exhibition-carousel', {
                type: 'loop',
                perPage: 3,
                perMove: 1,
                gap: '2rem',
                autoplay: true,
                interval: 4000,
                breakpoints: {
                    768: {
                        perPage: 1
                    },
                    1024: {
                        perPage: 2
                    }
                }
            });
            splide.mount();
        }
    }

    initStatsAnimation() {
        const stats = document.querySelectorAll('.stat-number');
        stats.forEach(stat => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        this.animateNumber(entry.target);
                    }
                });
            });
            observer.observe(stat);
        });
    }

    animateNumber(element) {
        const finalNumber = parseInt(element.textContent);
        const duration = 2000;
        
        anime({
            targets: { number: 0 },
            number: finalNumber,
            duration: duration,
            easing: 'easeOutQuad',
            update: function(anim) {
                element.textContent = Math.round(anim.animatables[0].target.number);
            }
        });
    }

    initExhibitsPage() {
        // 搜索功能
        this.initSearchFunction();
        
        // 展览网格动画
        this.initExhibitsGrid();
    }

    initSearchFunction() {
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        
        if (searchButton) {
            searchButton.addEventListener('click', () => {
                this.performSearch();
            });
        }

        if (searchInput) {
            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    this.performSearch();
                }
            });
        }
    }

    performSearch() {
        const searchTerm = document.getElementById('search-input').value;
        if (searchTerm) {
            // 这里会触发PHP的搜索功能
            window.location.href = `exhibits.php?search=${encodeURIComponent(searchTerm)}`;
        }
    }

    initExhibitsGrid() {
        const exhibitCards = document.querySelectorAll('.exhibit-card');
        exhibitCards.forEach((card, index) => {
            anime({
                targets: card,
                opacity: [0, 1],
                translateY: [50, 0],
                duration: 600,
                delay: index * 100,
                easing: 'easeOutQuad'
            });
        });
    }

    initFishPage() {
        // 鱼类分类筛选
        this.initFishCategories();
        
        // 鱼类详情模态框
        this.initFishModal();
    }

    initFishCategories() {
        const categoryButtons = document.querySelectorAll('.category-btn');
        categoryButtons.forEach(button => {
            button.addEventListener('click', () => {
                const category = button.dataset.category;
                this.filterFishByCategory(category);
                
                // 更新按钮状态
                categoryButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
            });
        });
    }

    filterFishByCategory(category) {
        const fishCards = document.querySelectorAll('.fish-card');
        fishCards.forEach(card => {
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
    }

    initFishModal() {
        const fishCards = document.querySelectorAll('.fish-card');
        const modal = document.getElementById('fish-modal');
        const closeModal = document.querySelector('.modal-close');

        fishCards.forEach(card => {
            card.addEventListener('click', () => {
                const fishId = card.dataset.fishId;
                this.showFishDetails(fishId);
            });
        });

        if (closeModal) {
            closeModal.addEventListener('click', () => {
                this.hideModal();
            });
        }

        if (modal) {
            modal.addEventListener('click', (e) => {
                if (e.target === modal) {
                    this.hideModal();
                }
            });
        }
    }

    showFishDetails(fishId) {
        // 这里应该从JSON数据中获取鱼类详情
        const modal = document.getElementById('fish-modal');
        if (modal) {
            modal.style.display = 'flex';
            anime({
                targets: modal,
                opacity: [0, 1],
                duration: 300,
                easing: 'easeOutQuad'
            });
        }
    }

    hideModal() {
        const modal = document.getElementById('fish-modal');
        if (modal) {
            anime({
                targets: modal,
                opacity: [1, 0],
                duration: 300,
                easing: 'easeOutQuad',
                complete: () => {
                    modal.style.display = 'none';
                }
            });
        }
    }

    initEducationPage() {
        // 海洋测验系统
        this.initQuizSystem();
        
        // 虚拟潜水体验
        this.initVirtualDive();
    }

    initQuizSystem() {
        const startQuizBtn = document.getElementById('start-quiz');
        if (startQuizBtn) {
            startQuizBtn.addEventListener('click', () => {
                this.startQuiz();
            });
        }
    }

    startQuiz() {
        // 加载测验题目
        this.loadQuizQuestions();
    }

    async loadQuizQuestions() {
        try {
            const response = await fetch('data/quiz-questions.json');
            const data = await response.json();
            this.displayQuizQuestion(data.questions[0]);
        } catch (error) {
            console.error('Failed to load quiz questions:', error);
        }
    }

    displayQuizQuestion(question) {
        const quizContainer = document.getElementById('quiz-container');
        if (quizContainer) {
            quizContainer.innerHTML = `
                <div class="quiz-question">
                    <h3>${question.question}</h3>
                    <div class="quiz-options">
                        ${question.options.map((option, index) => `
                            <button class="quiz-option" data-index="${index}">${option}</button>
                        `).join('')}
                    </div>
                </div>
            `;

            // 添加选项点击事件
            const options = quizContainer.querySelectorAll('.quiz-option');
            options.forEach(option => {
                option.addEventListener('click', () => {
                    this.selectQuizOption(option, question);
                });
            });
        }
    }

    selectQuizOption(selectedOption, question) {
        const selectedIndex = parseInt(selectedOption.dataset.index);
        const isCorrect = selectedIndex === question.correct_answer;
        
        // 显示结果
        selectedOption.classList.add(isCorrect ? 'correct' : 'incorrect');
        
        // 显示解释
        setTimeout(() => {
            this.showQuizExplanation(question.explanation);
        }, 1000);
    }

    showQuizExplanation(explanation) {
        const quizContainer = document.getElementById('quiz-container');
        if (quizContainer) {
            quizContainer.innerHTML += `
                <div class="quiz-explanation">
                    <p>${explanation}</p>
                    <button id="next-question">下一题</button>
                </div>
            `;
        }
    }

    initVirtualDive() {
        const diveButton = document.getElementById('start-dive');
        if (diveButton) {
            diveButton.addEventListener('click', () => {
                this.startVirtualDive();
            });
        }
    }

    startVirtualDive() {
        const diveContainer = document.getElementById('virtual-dive');
        if (diveContainer) {
            diveContainer.style.display = 'block';
            this.createDiveScene();
        }
    }

    createDiveScene() {
        // 使用p5.js创建虚拟潜水场景
        if (typeof p5 !== 'undefined') {
            new p5((p) => {
                let fish = [];
                
                p.setup = () => {
                    const canvas = p.createCanvas(800, 600);
                    canvas.parent('virtual-dive');
                    
                    // 创建鱼群
                    for (let i = 0; i < 20; i++) {
                        fish.push({
                            x: Math.random() * p.width,
                            y: Math.random() * p.height,
                            vx: (Math.random() - 0.5) * 2,
                            vy: (Math.random() - 0.5) * 2,
                            size: Math.random() * 20 + 10
                        });
                    }
                };
                
                p.draw = () => {
                    // 海洋背景
                    p.background(25, 25, 112);
                    
                    // 绘制鱼群
                    fish.forEach(f => {
                        p.fill(255, 215, 0);
                        p.noStroke();
                        p.ellipse(f.x, f.y, f.size, f.size * 0.6);
                        
                        // 更新位置
                        f.x += f.vx;
                        f.y += f.vy;
                        
                        // 边界检查
                        if (f.x < 0 || f.x > p.width) f.vx *= -1;
                        if (f.y < 0 || f.y > p.height) f.vy *= -1;
                    });
                };
            });
        }
    }
}

// 页面加载完成后初始化
document.addEventListener('DOMContentLoaded', () => {
    new OceanMuseum();
});

// 工具函数
const Utils = {
    // 平滑滚动到元素
    scrollToElement: (elementId) => {
        const element = document.getElementById(elementId);
        if (element) {
            element.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    },

    // 显示通知
    showNotification: (message, type = 'info') => {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        anime({
            targets: notification,
            opacity: [0, 1],
            translateY: [-50, 0],
            duration: 300,
            easing: 'easeOutQuad'
        });
        
        setTimeout(() => {
            anime({
                targets: notification,
                opacity: [1, 0],
                translateY: [0, -50],
                duration: 300,
                easing: 'easeOutQuad',
                complete: () => {
                    document.body.removeChild(notification);
                }
            });
        }, 3000);
    },

    // 格式化数字
    formatNumber: (num) => {
        return new Intl.NumberFormat('zh-CN').format(num);
    },

    // 防抖函数
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
};

// 滚动动画效果
document.addEventListener('DOMContentLoaded', function() {
    // 滚动动画
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // 观察所有需要动画的元素
    document.querySelectorAll('.scroll-animate, .fade-in').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });

    // 初始化轮播（如果存在）
    if (typeof Splide !== 'undefined') {
        new Splide('.exhibition-carousel', {
            type: 'loop',
            perPage: 3,
            gap: '2rem',
            breakpoints: {
                768: {
                    perPage: 1
                }
            }
        }).mount();
    }

    // 简单的粒子效果替代
    const particleContainer = document.getElementById('particle-container');
    if (particleContainer) {
        createParticleEffect(particleContainer);
    }
});

// 简单的粒子效果
function createParticleEffect(container) {
    for (let i = 0; i < 30; i++) {
        const particle = document.createElement('div');
        particle.style.position = 'absolute';
        particle.style.width = Math.random() * 3 + 1 + 'px';
        particle.style.height = particle.style.width;
        particle.style.background = 'rgba(255, 107, 71, 0.5)';
        particle.style.borderRadius = '50%';
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animation = `float ${Math.random() * 10 + 10}s linear infinite`;
        container.appendChild(particle);
    }

    // 添加浮动动画样式
    const style = document.createElement('style');
    style.textContent = `
        @keyframes float {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(20px); opacity: 0; }
        }
    `;
    document.head.appendChild(style);
}