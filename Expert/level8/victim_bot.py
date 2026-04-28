import json
import time
import requests
import os

# 配置
MAILBOX_FILE = "mailbox.json"
CHECK_INTERVAL = 2  # 检查间隔（秒）

print(f"[*] 模拟受害者正在运行...")
print(f"[*] 正在监控邮箱文件: {MAILBOX_FILE}")
print(f"[*] 当收到新邮件时，受害者会自动点击其中的链接。")

last_mtime = 0
processed_links = set()

def get_links_from_mailbox():
    try:
        if not os.path.exists(MAILBOX_FILE):
            return []
        
        # 简单的文件读取
        with open(MAILBOX_FILE, 'r', encoding='utf-8') as f:
            content = f.read()
            if not content: return []
            data = json.loads(content)
            
        links = []
        if isinstance(data, list):
            for email in data:
                if 'link' in email:
                    links.append(email['link'])
        return links
    except Exception as e:
        print(f"[!] 读取邮箱出错: {e}")
        return []

# 初始化：标记已有的链接为已处理，避免重复点击
initial_links = get_links_from_mailbox()
for link in initial_links:
    processed_links.add(link)

while True:
    try:
        current_links = get_links_from_mailbox()
        
        for link in current_links:
            if link not in processed_links:
                print(f"\n[+] 发现新邮件链接: {link}")
                print(f"[*] 受害者正在点击链接...")
                
                try:
                    # 模拟点击：发送 GET 请求
                    # 设置超时，防止攻击者服务器不响应导致卡死
                    resp = requests.get(link, timeout=5)
                    print(f"    -> 访问完成 (状态码: {resp.status_code})")
                except Exception as e:
                    print(f"    -> 访问失败: {e}")
                    print(f"       (这可能是因为攻击者服务器 [Host Header] 指向了错误的地址)")
                
                processed_links.add(link)
        
        time.sleep(CHECK_INTERVAL)
        
    except KeyboardInterrupt:
        print("\n[*] 受害者模拟已停止")
        break
