// 全局变量
let currentUser = null;
let isLoggedIn = false;

// 页面加载完成后初始化
document.addEventListener('DOMContentLoaded', function() {
    initializeApp();
});

// 初始化应用
function initializeApp() {
    // 检查登录状态
    checkLoginStatus();
    
    // 初始化轮播图
    initializeCarousel();
    
    // 初始化移动端菜单
    initializeMobileMenu();
    
    // 初始化滚动动画
    initializeScrollAnimations();
    
    // 初始化登录表单
    initializeLoginForm();
}

// 检查登录状态
function checkLoginStatus() {
    const user = localStorage.getItem('currentUser');
    if (user) {
        currentUser = JSON.parse(user);
        isLoggedIn = true;
        updateLoginButton();
    }
}

// 更新登录按钮状态
function updateLoginButton() {
    const loginButtons = document.querySelectorAll('button[onclick="showLoginModal()"]');
    loginButtons.forEach(button => {
        if (isLoggedIn) {
            button.textContent = currentUser.name;
            button.onclick = () => showUserMenu();
        } else {
            button.textContent = '登录';
            button.onclick = () => showLoginModal();
        }
    });
}

// 初始化轮播图
function initializeCarousel() {
    if (document.getElementById('hero-carousel')) {
        new Splide('#hero-carousel', {
            type: 'loop',
            autoplay: true,
            interval: 4000,
            pauseOnHover: true,
            arrows: false,
            pagination: true,
            gap: '1rem',
        }).mount();
    }
}

// 初始化移动端菜单
function initializeMobileMenu() {
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuBtn && mobileMenu) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
    }
}

// 初始化滚动动画
function initializeScrollAnimations() {
    // 创建Intersection Observer
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    // 观察需要动画的元素
    const animatedElements = document.querySelectorAll('.product-card, .glass-effect');
    animatedElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
}

// 初始化登录表单
function initializeLoginForm() {
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', handleLogin);
    }
}

// 显示登录模态框
function showLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // 添加动画效果
        anime({
            targets: modal.querySelector('.bg-white'),
            scale: [0.8, 1],
            opacity: [0, 1],
            duration: 300,
            easing: 'easeOutCubic'
        });
    }
}

// 隐藏登录模态框
function hideLoginModal() {
    const modal = document.getElementById('loginModal');
    if (modal) {
        anime({
            targets: modal.querySelector('.bg-white'),
            scale: [1, 0.8],
            opacity: [1, 0],
            duration: 200,
            easing: 'easeInCubic',
            complete: () => {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    }
}



// 显示用户菜单
function showUserMenu() {
    const menu = confirm('您已登录\n姓名: ' + currentUser.name + '\n电话: ' + currentUser.phone + '\n\n是否要退出登录？');
    if (menu) {
        logout();
    }
}

// 退出登录
function logout() {
    localStorage.removeItem('currentUser');
    currentUser = null;
    isLoggedIn = false;
    updateLoginButton();
    showNotification('已退出登录', 'info');
}

// 显示产品详情
function showProductDetail(name, description) {
    if (!isLoggedIn) {
        showLoginModal();
        return;
    }
    
    const modal = document.getElementById('productModal');
    const content = document.getElementById('productDetailContent');
    
    if (modal && content) {
        // 生成详细的产品信息
        content.innerHTML = `
            <div class="text-center mb-8">
                <h3 class="text-3xl font-bold text-gray-800 mb-4">${name}</h3>
                <div class="w-full h-64 bg-gray-200 rounded-lg mb-6 flex items-center justify-center">
                    <span class="text-gray-500 text-lg">产品图片</span>
                </div>
            </div>
            
            <div class="space-y-6">
                <div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-3">产品描述</h4>
                    <p class="text-gray-600 leading-relaxed">${description}</p>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">产品规格</h4>
                        <ul class="text-gray-600 space-y-1">
                            <li>• 材质：优质材料</li>
                            <li>• 尺寸：标准规格</li>
                            <li>• 颜色：多种可选</li>
                            <li>• 包装：安全包装</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="text-lg font-semibold text-gray-800 mb-2">服务支持</h4>
                        <ul class="text-gray-600 space-y-1">
                            <li>• 质量保证</li>
                            <li>• 快速发货</li>
                            <li>• 技术支持</li>
                            <li>• 售后服务</li>
                        </ul>
                    </div>
                </div>
                
                <div class="bg-blue-50 p-6 rounded-lg">
                    <h4 class="text-lg font-semibold text-blue-800 mb-3">联系我们</h4>
                    <p class="text-blue-700 mb-4">如需了解更多产品信息或获取报价，请联系我们的专业团队。</p>
                    <div class="flex flex-col sm:flex-row gap-3">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            获取报价
                        </button>
                        <button class="border-2 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white px-6 py-3 rounded-lg font-medium transition-colors">
                            联系供应商
                        </button>
                    </div>
                </div>
            </div>
        `;
        
        modal.classList.add('show');
        document.body.style.overflow = 'hidden';
        
        // 添加动画效果
        anime({
            targets: modal.querySelector('.bg-white'),
            scale: [0.8, 1],
            opacity: [0, 1],
            duration: 300,
            easing: 'easeOutCubic'
        });
    }
}

// 隐藏产品详情模态框
function hideProductModal() {
    const modal = document.getElementById('productModal');
    if (modal) {
        anime({
            targets: modal.querySelector('.bg-white'),
            scale: [1, 0.8],
            opacity: [1, 0],
            duration: 200,
            easing: 'easeInCubic',
            complete: () => {
                modal.classList.remove('show');
                document.body.style.overflow = 'auto';
            }
        });
    }
}

// 显示通知
function showNotification(message, type = 'info') {
    // 创建通知元素
    const notification = document.createElement('div');
    notification.className = `fixed top-20 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform translate-x-full transition-transform duration-300`;
    
    // 根据类型设置样式
    switch (type) {
        case 'success':
            notification.classList.add('bg-green-500', 'text-white');
            break;
        case 'error':
            notification.classList.add('bg-red-500', 'text-white');
            break;
        case 'warning':
            notification.classList.add('bg-yellow-500', 'text-white');
            break;
        default:
            notification.classList.add('bg-blue-500', 'text-white');
    }
    
    notification.innerHTML = `
        <div class="flex items-center justify-between">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // 显示动画
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);
    
    // 自动隐藏
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentElement) {
                notification.remove();
            }
        }, 300);
    }, 3000);
}

// 产品数据
const products = [
    {
        id: 1,
        name: '纺织面料',
        category: '纺织品',
        price: 25.80,
        unit: '米',
        image: 'https://kimi-web-img.moonshot.cn/img/www.silailor.in/bcb3f58faab250e46d6cc2333be968f6af049ebf.jpg',
        description: '高品质纺织面料，适用于服装制造和家居装饰'
    },
    {
        id: 2,
        name: '智能家居',
        category: '电子产品',
        price: 299.00,
        unit: '件',
        image: 'https://kimi-web-img.moonshot.cn/img/cdn.builder.io/3e451407c1f8c76eb4825954d6af552904aefe01',
        description: '现代化智能家居产品，提升生活品质'
    },
    {
        id: 3,
        name: '太阳能设备',
        category: '能源设备',
        price: 1299.00,
        unit: '套',
        image: 'https://kimi-web-img.moonshot.cn/img/cdn.britannica.com/39539ad4d866cf3793a1cfc66e098f4c47597d43.jpg',
        description: '高效太阳能发电设备，清洁能源解决方案'
    },
    {
        id: 4,
        name: '包装机械',
        category: '机械设备',
        price: 8999.00,
        unit: '台',
        image: 'https://kimi-web-img.moonshot.cn/img/www.supplyone.com/386ade5f44beeb2e757c92484db504b5e9746b06.jpg',
        description: '自动化包装机械设备，提升生产效率'
    },
    {
        id: 5,
        name: '建筑材料',
        category: '建材',
        price: 159.00,
        unit: '平方米',
        image: 'https://kimi-web-img.moonshot.cn/img/uploads-ssl.webflow.com/917d0918434ee8a682943dbe5d9e74796afe6c39.jpeg',
        description: '优质建筑材料，耐用环保'
    },
    {
        id: 6,
        name: '安全防护用品',
        category: '安全用品',
        price: 89.00,
        unit: '套',
        image: 'https://kimi-web-img.moonshot.cn/img/www.andandappe.com/5dfbef24b17719c816e94c8d03a55da13f828b6d.jpg',
        description: '专业安全防护用品，保障工作安全'
    }
];

// 客户数据
let customers = [
    {
        id: 1,
        name: '张三',
        phone: '13800138001',
        firstVisit: '2025-01-15',
        lastActive: '2025-01-20',
        visits: [
            { time: '2025-01-15 10:30', page: '纺织面料', duration: '5分钟' },
            { time: '2025-01-20 14:20', page: '智能家居', duration: '8分钟' }
        ]
    },
    {
        id: 2,
        name: '李四',
        phone: '13900139002',
        firstVisit: '2025-01-18',
        lastActive: '2025-01-22',
        visits: [
            { time: '2025-01-18 09:15', page: '太阳能设备', duration: '12分钟' },
            { time: '2025-01-22 16:45', page: '包装机械', duration: '15分钟' }
        ]
    }
];

// 系统监控数据
const systemData = {
    cpu: [45, 52, 48, 61, 55, 67, 72, 58, 49, 53, 46, 51],
    memory: [62, 58, 65, 71, 68, 74, 69, 63, 59, 66, 61, 64],
    disk: [78, 76, 79, 77, 80, 78, 82, 79, 77, 75, 78, 76],
    visitors: [120, 135, 148, 162, 155, 178, 192, 165, 142, 158, 134, 149],
    newCustomers: [8, 12, 15, 18, 14, 22, 25, 19, 16, 20, 13, 17]
};

// 添加登录状态管理函数
// 添加登录状态管理函数
function updateLoginStatus(isLoggedIn) {
    const loginButtons = document.querySelectorAll('[onclick*="showLoginModal"]');
    
    if (isLoggedIn) {
        loginButtons.forEach(btn => {
            btn.textContent = '管理后台';
            btn.onclick = function() {
                window.location.href = 'admin.php';  // 确保这里是 admin.php
            };
            // 移除原有的事件监听器（如果有的话）
            btn.setAttribute('onclick', 'window.location.href="admin.php"');
        });
    } else {
        loginButtons.forEach(btn => {
            btn.textContent = '登录';
            btn.onclick = showLoginModal;
            btn.setAttribute('onclick', 'showLoginModal()');
        });
    }
}



// 导出数据供其他页面使用
window.products = products;
window.customers = customers;
window.systemData = systemData;

// 全局函数
window.showLoginModal = showLoginModal;
window.hideLoginModal = hideLoginModal;
window.showProductDetail = showProductDetail;
window.hideProductModal = hideProductModal;
window.logout = logout;



// 登录表单提交处理
document.addEventListener('DOMContentLoaded', function() {
    // 检查登录状态
    checkLoginStatus();
        // 初始化登录表单
    const loginForm = document.getElementById('loginForm');
    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            e.preventDefault();
            handleLogin(e);  // 传递事件对象
        });
    }
});

// 检查登录状态
function checkLoginStatus() {
    fetch('check_login.php')
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                updateLoginStatus(true);
            } else {
                updateLoginStatus(false);
            }
        })
        .catch(error => {
            console.error('检查登录状态失败:', error);
            updateLoginStatus(false);
        });
}


function handleLoginSuccess(userData) {
    // 显示成功消息
    showNotification('登录成功！', 'success');
    
    // 隐藏登录模态框
    hideLoginModal();
    
    // 更新登录状态
    updateLoginStatus(true);
    
    // 可以在这里添加跳转到管理页面的逻辑
    // 如果当前在首页，可以显示管理后台按钮
    console.log('用户登录成功:', userData);
}


function handleLoginError(message) {
    showNotification(message || '登录失败，请检查账号密码！', 'error');
    
    // 重置登录按钮状态
    const loginBtn = document.querySelector('#loginForm button[type="submit"]');
    if (loginBtn) {
        loginBtn.disabled = false;
        loginBtn.innerHTML = '登录';
    }
}


// 登录处理函数
function handleLogin(e) {
    if (e) e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    
    // 简单的客户端验证
    if (!username || !password) {
        showNotification('请输入账号和密码', 'error');
        return;
    }
    
    // 禁用登录按钮防止重复提交
    const loginBtn = document.querySelector('#loginForm button[type="submit"]');
    if (loginBtn) {
        loginBtn.disabled = true;
        loginBtn.innerHTML = '登录中...';
    }
    
    // 发送登录请求
    fetch('login.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            username: username,
            password: password
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('登录成功！', 'success');
            localStorage.setItem('currentUser', JSON.stringify(data.user));
            hideLoginModal();
            
            // 更新登录状态
            updateLoginStatus(true);
            
            // 如果是管理员，跳转到管理页面
            if (username === 'admin') {
                setTimeout(() => {
                    window.location.href = 'admin.php';
                }, 1000);
            }
        } else {
            showNotification(data.message || '登录失败', 'error');
        }
    })
    .catch(error => {
        console.error('登录错误:', error);
        showNotification('网络错误，请重试', 'error');
    })
    .finally(() => {
        // 重新启用登录按钮
        if (loginBtn) {
            loginBtn.disabled = false;
            loginBtn.innerHTML = '登录';
        }
    });
}