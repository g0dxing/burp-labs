<?php
/* 1. 清掉已有缓冲区，避免被主题覆盖 */
while (ob_get_level()) ob_end_clean();

/* 2. 启动我们自己的输出缓冲区 */
ob_start();

/* 3. 获取参数（漏洞点） */
$url = $_REQUEST['detail'] ?? 'data/404.html';

/* 4. 总是执行包含：LFI / RFI */
@include $url;          // 本地或远程，文件不存在也继续

/* 5. 取出本次输出的实际长度 */
$output = ob_get_clean();

/* 6. 有内容就回显，无内容才给 404 */
if (strlen(trim($output)) === 0) {
    http_response_code(404);
    echo '<!doctype html><title>404 详情页未建成</title>';
    echo '<style>body{font-family:system-ui;background:#0B1426;color:#F0F8FF;text-align:center;padding:4rem}</style>';
    echo '<h1>🚧 该生物详情页尚未建成</h1>';
} else {
    echo $output;   // 正常回显包含结果
}
?>
