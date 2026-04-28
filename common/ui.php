<?php
function h($s) { return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function render_success($title, $message, $back_url = null, $redirect = null, $redirect_delay_ms = 1500) {
    http_response_code(200);
    echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . h($title) . '</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#f4f4f4;color:#333;margin:0}';
    echo '.card{width:380px;max-width:92vw;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.08)}';
    echo '.title{margin:0 0 8px;font-size:1.25rem;color:#2ecc71}';
    echo '.msg{margin:0 0 16px;font-size:1rem;color:#555}';
    echo '.btn{display:inline-block;background:#2ecc71;color:#fff;text-decoration:none;border:none;border-radius:8px;padding:10px 14px;cursor:pointer}';
    echo '.btn:hover{background:#27ae60}</style></head><body>';
    echo '<div class="card"><h1 class="title">' . h($title) . '</h1>';
    echo '<p class="msg">' . h($message) . '</p>';
    if ($back_url) { echo '<p style="text-align:center"><a class="btn" href="' . h($back_url) . '">Back</a></p>'; }
    echo '</div>';
    if ($redirect) {
        echo '<script>setTimeout(function(){location.href=' . json_encode($redirect) . '},' . (int)$redirect_delay_ms . ');</script>';
    }
    echo '</body></html>';
}
function render_error($title, $message, $back_url = 'login.html', $status = 200) {
    http_response_code(200);
    echo '<!DOCTYPE html><html lang="zh-CN"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">';
    echo '<title>' . h($title) . '</title>';
    echo '<style>body{font-family:-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Arial,sans-serif;display:grid;place-items:center;min-height:100vh;background:#f4f4f4;color:#333;margin:0}';
    echo '.card{width:380px;max-width:92vw;background:#fff;border:1px solid #e5e7eb;border-radius:12px;padding:24px;box-shadow:0 10px 25px rgba(0,0,0,.08)}';
    echo '.title{margin:0 0 8px;font-size:1.25rem;color:#e74c3c}';
    echo '.msg{margin:0 0 16px;font-size:1rem;color:#555}';
    echo '.btn{display:inline-block;background:#2ecc71;color:#fff;text-decoration:none;border:none;border-radius:8px;padding:10px 14px;cursor:pointer}';
    echo '.btn:hover{background:#27ae60}</style></head><body>';
    echo '<div class="card"><h1 class="title">' . h($title) . '</h1>';
    echo '<p class="msg">' . h($message) . '</p>';
    if ($back_url) { echo '<p style="text-align:center"><a class="btn" href="' . h($back_url) . '">Back to Login</a></p>'; }
    echo '</div></body></html>';
}
?>
