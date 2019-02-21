 # nginx 配置出现 403的解决问题

```text
 https://blog.csdn.net/onlysunnyboy/article/details/75270533
```

  配置的文件里面

```
server {
        listen 80;
        
        # 如果要处理php文件 index.php 必须要有 并否则报 403权限错误
        index index.html index.php;

        server_name admin.climaxbuy.com.cn;
        
        root /var/www/html/eshow/backend/web;

        location / {
                try_files $uri $uri/ /index.php?$args $uri/ =404;
        }
       
        location ~ \.php$ {
                include snippets/fastcgi-php.conf;
                # fastcgi_pass 配置到 php_fpm 配置的 listen 一致就可以了
                fastcgi_pass unix:/run/php/php7.0-fpm.sock;
        }
}
```

$uri/ 会补全index 的枚举尝试路由调用

ps aux | grep "nginx: worker process" | awk '{print $1}'
查看工作用户 和  启动用户


# selinux 的问题
    略
    
    
> 最后 工作用户必须在 配置单 的文件或文件夹有读权限

