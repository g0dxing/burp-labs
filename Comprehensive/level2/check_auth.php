<?php
// level22/check_auth.php

/**
 * 检查用户是否已登录
 */
function checkAuth() {
    session_start();
    
    // 检查session中是否有登录标记
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        // 未登录，返回JSON响应供前端处理
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest') {
            header('Content-Type: application/json');
            echo json_encode(['logged_in' => false]);
            exit();
        } else {
            // 普通请求，跳转到首页
            header('Location: index.html');
            exit();
        }
    }
    
    // 检查登录是否过期（可选：设置30分钟过期）
    if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time'] > 1800)) {
        // 登录已过期
        session_destroy();
        header('Location: index.html');
        exit();
    }
}

/**
 * 用户登录成功时调用
 */
function setAuth($username) {
    $_SESSION['logged_in'] = true;
    $_SESSION['login_time'] = time();
    $_SESSION['user_ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['username'] = $username;
}

/**
 * 用户登出时调用
 */
function clearAuth() {
    session_destroy();
}

/**
 * 验证会话安全性
 */
function validateSession() {
    if (!isset($_SESSION['user_ip']) || $_SESSION['user_ip'] !== $_SERVER['REMOTE_ADDR']) {
        return false;
    }
    if (!isset($_SESSION['user_agent']) || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        return false;
    }
    return true;
}

/**
 * 检查登录状态（供AJAX调用）
 */
function checkLoginStatus() {
    session_start();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && validateSession()) {
        return ['logged_in' => true, 'username' => $_SESSION['username']];
    } else {
        return ['logged_in' => false];
    }
}
?>