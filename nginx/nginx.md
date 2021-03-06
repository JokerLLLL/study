#基础篇#
/etc/logrotate.d/nginx   配置文件  日志轮转配置
/etc/nginx               配置文件目录
源码包安装配置目录：
/usr/local/nginx/conf/nginx.conf
/usr/local/nginx/conf/nginx.conf.default
/usr/local/nginx/conf/fastcgi_params                   配置文件   cgi  fastcgi
/usr/local/nginx/conf/uwsgi_params
/usr/local/nginx/conf/scgi_params
/usr/local/nginx/conf/koi-utf                          编码转化文件
/usr/local/nginx/conf/mime.types                       http协议content-type与扩展名对应关系
/sys/fs/cgroup/systemd/system.slice/nginx.service      守护进程文件

yum源配置：
/etc/nginx/


编译参数：
--prefix=/usr/local/nginx             安装目录或路径
--user=www                            所属人
--group=www                           所属组


nginx -t -c /etc/nginx/nginx.conf    #检查配置是否语法错误
nginx -s reload                      #重新加载配置文件
service nginx restart                #nginx重启
#nginx.conf语法说明：


user            用户组
worker_process  工作进程数
error_log       nginx错误日志
pid             nginx服务启动pid


events{
  worker_connenctions   进程允许链接最大数
  use                   工作进程数
}

//日志模块
error_log  access_log
error_log /data/wwwlogs/error_nginx.log crit;  错误日志 //放在最外层

//放在http模块下
log_format
syntax: log_format  name  string...;
default:  log_format
context: http

nginx变量：
http请求变量： $arg_参数名  $http_发送头名  $send_http_响应头名  (都为小写和下划线)
  例：http_referer(用于判断路由前一层地址)
内置变量：


#默认模块：
http_stub_status_module  查看nginx状态  server 或 location
server{
  location /mystatus {
    stub_status on;
  }
}

http_random_index_module  随机主页  location
location / {
  root /usr/...;
  random_index on;
}

http_sub_module 替换http内容 http 或 server 或 location
location / {
  sub_filer '替换前' '替换后';
  sub_filer_once off;
}

#请求限制
#limit_conn_module模块
limit_conn_zone key zone=name:size; 连接限制 zone(申请空间位置)  http
limit_conn zone number; 使用+并发数 http,server,location

#limit_req_module模块
limit_req_zone key zone=name:size rate=rate; 请求限制 zone(申请空间位置)rate(速率) http
limit_req zone=name [burst=3] [nodelay]; 使用 http,server,location

http{
  limit_conn_zone $binary_remote_addr zone=conn_zone:1m;
  //binnary_remote_addr代替remote_addr 更小 对于同一个addr 每秒只请求一次的配置
  limit_req_zone $binary_remote_addr zone=req_zone:1m rate = 1r/s;
  server {
    location / {
      limit_conn conn_zone 1; //允许一个ip过来
      limit_req zone=req_zone;
    }
  }
}

#nginx访问控制
基于ip的访问控制 http_access_module
[remote_addr = ip2(可能是代理的ip)]#用于访问控制
allow address|CIDR|unix:|all;  允许的规则  http,server,location,limit_except
deny address|CIDR|unix:|all; 禁止的规则  http,server,location,limit_except

server {
  location ~ ^/admin.html {
     root /opt/app/code
     allow ip;
     deny all;
  }
}

##代理控制
[http_x_forwarded_for = ip1,ip2,...(代理使用 可别修改 不可靠)]
[geo模块]
[http自定义变量传递]


#http_auth_basic_module模块
auth_basic string 登陆认证   http,server,location,limit_except
auth_basic_user_file file  密码储存位置  使用 htpasswd命令生成  htpasswd -c ./pw_conf jokerl

server {
   location ~ ^/admin.html {
      root /opt/app/code
      auth_basic "启用nginx登陆"
      auth_basic_user_file /etc/nginx/conf/pw_conf
   }
}


###场景实践篇###

#静态资源web服务
.html .css .js  .jpeg .gif .png .flv .mpeg .txt .rar
静态资源CDN加速项:
sendfile on|off  文件读取  http,server,location,if in location
tcp_nopush on|off 包裹延迟一次性发送 http,server,location
tcp_nodelay on|off 包裹立即发送(长连接) http,server,location
gzip_comp_level 1 压缩解压协议 http,server,location

server {
  location ~ .*\.(jpg|gif|png)$ {
     root /opt/app/code/images;
     gzip on;
     gzip_http_version 1.1;
     gzip_types text/plain application/javascript image/gif image/png;
  }
}
##浏览器缓存原理
   校验过期 Expire Cache-Controller(max-age) 过期时间协议 http1.0 和http1.1的过期
   
   Etag头验证(字符串)  
   Last-Modify头验证(时间)
   通过校验 过期服务端返回302 not modify表示为更新

   expire time 过期头配置
  location / {
    expire 14h;
  }

##跨域
    add_header name value  (增加响应头) http,server,location,if in location
    =================>Access-Control-Allow-Origin<========================
    location / {
      add_header Access-Control-Allow-Origin http://www.xxx.com;
      add_header Access-Control-Allow-Origin *;
      add_header Access-Control-Allow-Origin GET,POST,PUT,DELETE,OPTIONS;
    }

##防盗链
    http_refer 模块(nginx变量)  server,location
    location / {
      valid_referers none blocked  [www.baidu.com 127.0.01 ...]
      if ( ) {
        return 403;
      }
    }

    valid_referers none|blocked|server_names|string...;//允许的规则
    blocked:表示代理
    
    curl http://nignx1.com/iamge/1.jpg
    200 ok
    curl -e "http://www.baidu.com" -I http://nginx1.com/image/1.jpg
    403 error
    
   第三方模块：
   HttpAccessKeyModule 实现防盗链
   accesskey on|off;
   accesskey_hashmethod md5|sha-1;
   accesskey_arg "key";
   accesskey_signature "mypass$remote_addr";

#代理服务
  proxy_pass url nginx代理 location if in location limit_except

  http反向代理：
  #访问test.com/test_proxy.html时 反向代理到8080端口 (80端口对外开放)
  server {
    listen 80;
    server_name localhost test.com;

    location / {
      root /usr/html;
      index index.html index.php;
    }

    location ~ /test_proxy.html$ {
      proxy_pass http://127.0.0.1:8080;
    }
  }

  server {
    listen 8080;
    location / {
      root /usr/html/index/
      index default.html;
    }
  }

  http正向代理：
    #  一下服务器外网无法访问 所有加层正向代理
    #  server {
    #    listen 80;
    #    location / {
    #      if($http_x_forwarded_for !~* "^127\.0\.0\.1") {  #允许访问的ip
    #        return 403;
    #      }
    #      root /opt/app/code;
    #      index index.html;
    #    }
    #  }

    代理设置
    server {
      listen 80;
      server_name  xx.xx.xx.xx j.com;
      resoler 8.8.8.8;  #dns服务器
      location / {
         proxy_pass http://$http_host$request_uri;
      }
    }

  其他语法：
  proxy_buffering on|off; 缓冲区
  proxy_buffer_size 32k;
  proxy_buffers 4 128k;
  proxy_redirect default; 跳转重定向
  proxy_set header field value; 头信息
  proxy_hide_header
  proxy_set_body
  proxy_connect_timeout time; 连接超时
  proxy_read_time
  proxy_send_timeout


#负载均衡调度器(SLB)
  负载均衡:
  客户端->nginx(7层负载均衡 proxy_pass)->upstream server->服务
  upstream name {...}  虚拟服务池  只能配置在http模块下

  location / {
    proxy_pass http://name;
    include proxy_params;
  }
  //节点  说明 weight权重 down不参与负载均衡 backup备用  max_fails=10 允许多次失败 fail_timeout=10s 经过max_fail失败后，服务粘暂停时间 max_conns=10s 限制最大连接数
  upstream name {
    server xxx.com  weight=5;
    server xxx.com:8080  backup;
  }

  轮询权重(upstream下)
  weight(基于请求)
  ip_hash; (ip分配 无法判断代理)
  least_conn (最少连接数)
  url_hash (1.7版本后 hash $requst_uri)

#动态缓存
  nginx代理缓存：(缓存位置 proxy_cache_path)
  proxy_cache name|off;
  proxy_cache_valid [code] time; 过期时间

   http{
    proxy_cache_path /opt/cache levels=1:2 keys_zone=imooc_cache:10m max_size=10g inactive=60m use_temp_path=off;
    server{
      location / {
        proxy_cache imooc_cache;
        proxy_cache_valid 200 304 12h;
        proxy_cache_key $host$uri$is_args$args;
        add_header Nginx-Cache "xxx";

        proxy_next_upstream error timeout invalid_header http_500 http_502 http_503 http 504;
        include proxy_params;
      }
    }
  }

  设置不缓存
  proxy_no_cache string;
  if($request_uri ~ ^/(url3|login|register|password\/reset)) {
    set $cookie_nocache 1;
  }

  proxy_no_cache $cookie_nocache $arg_nocache $arg_comment;

#第四章
#动静分离
upstream php_api{
   server 127.0.0.1:8080;
}
server {


    location ~ \.php$ {
       proxy_pass http:://php_api;
       index index.html index.php;
       root /opt/app/code;
    }

    location ~ \.(jpg|png|gif)$ {
       expires 1h;
       gzip on;
       root /opt/app/code;
    }

    location / {
       index index.html index.htm;
    }

    error_page 500 502 503 504 404 /50x.html;
}

#rewrite重写篇
    rewrite regex replacement [flag];  url重写 server,location,if

    .任意字符
    ?重复0或1次
    +重复1或更多次
    *任意(贪婪匹配)
    \d匹配数字
    ^匹配开头
    $匹配结尾
    {n}重复n次
    {n,}重复n或更多次
    [C]匹配制定字符
    [a-z]a到z任意一个
    \ 转意

    ()匹配括号的内容 通过$1 $2 调用

    [flag]：last,break,redirect,permanent   停止rewrite检查，302临时重定向， 301永久重定向。
    (break 在root目录拼接路由 重定向) (last 在域名下重定向);


    location / {
       rewrite ^/course-(\d+)-(\d+)-(\d+)\.html$ /course/$1/$2/course_$3.html break;
       if($http_user_agent ~* Chrome) {
         rewrite ^/nginx http://coding.xxx.com redirect;
       }

       if(!-f $requset_filename) {
         rewrite ^/(.*)$ http://www.google.com/$1 redirect;
       }
       index index.html
    }


#Nginx高级模块

    ##secure_link_module模块

    secure_link 和secure_link_md5

    /download?md5=vv9r48d3q2rfdv0&expires=1231132

    location / {
       secure_link $arg_md5,$arg_expires; #获取url的md5和expires两个参数

       secure_link_md5 "$secure_link_expires$uri imooc";  #加密规则
       if($secure_link = "") {
         return 403;
       }
       if($secure_link = 0) {
         return 410;
       }
    }


    ##geoip_module模块

    基于IP地址匹配MaxMind GeoIP 二进制文件 读取IP所在地域信息；
    yum install nignx-module-geoip
    配置文件加载模块
    load_module "modules/ngx_http_geoip_module.so";
    load_module "modules/ngx_stream_geoip_module.so";
    下载geolite的二进制源文件

    geoip_county /ect/nginx/geoip/GeoIP.dat;
    geoip_city /etc/nginx/geoip/GeoLiteCity.dat;
    server{
       listen 80；
       server name localhost;
       location / {
         if($geoip_county_code != CN) {
           return 403;
         }
         root /usr/share/nginx/html;
         index index.html index.htm
       }

       location /myip {
         default_type text/plain;
         return 200 "$remote_addr $geoip_country_name $geoip_country_code $geoip_city";
       }
    }


#HTTPS服务

  https ssl连接->服务器发送公钥->客户的发送对称加密密码->对称秘钥连接传输数据

        ssl连接->CA签名(包含公钥)->客户的发送对称加密密码->对称秘钥连接传输数据
                  (客户端对数字进行CA校验 1成功公钥加密 2失败停止回话)(签名是服务端和第三方机构签名和对应的授权)

  CA证书签名:
      #openssl version
      #nginx -v --with-http_ssl_module

      1生成key密钥 2生成csr文件 3第三方公司生成CA文件(crt)

      ssl on|off
      ssl_certificate file;
      ssl_certificate_key file;

      server{
         listen 443;
         server_name 116.62.103.228;
         ssl on;
         ssl_certifilcate /etc/nginx/ssl_key/jesonc.crt;
         ssl_certifilcate_key /etc/nginx/ssl_key/jesonc.key;
         index index.html
         location / {
           root /opt/app/code;
         }
      }

  https服务优化

      激活keepalive长连接  keepalive_timeout 100;
      设置ssl session缓存 ssl_session_cache shared::SSL:10m;  ssl_session_timeout 10m;


#Lua开发

      lua及基础语法:
      #!/usr/bin/lua 开头
      --行注释

      变量：
      a = '\97\n\124';
      布尔：nil和false    0和''都是true

      sum = 0
      while num<=100 do
        sum = sum + 1
        num = num + 1
      end
      print('sum=',sum)

      if age>15 and sex == 'male' then
          print('大于15的男性')
      elseif sex~='female' and age<=15 then
          print('小于16的男性')
      else
          local age=io.read()
          print('your age is'..age)
      end

      ~=不等于
      io.read()终端读取
      io.write()终端写入
      ..字符连接


#nginx+lua环境

  nginx调用lua指令

  灰度发布




#架构篇！！！

   虚拟主机优先级：
      优先匹配则不再查找

   location匹配优先级:
      高优先级：
      =   完全匹配
      ^~  前缀匹配
      低优先级：
      ~    正则区分大小写
      ~*   正则不区分大小写
    (location =) > (location 完整路径) > (location ^~ 路径) > (location ~,~* 正则顺序) > (location 部分起始路径) > (/)

   try_file：检查文件是否存在   root 只有在server模块下拼接uri尝试文件是否存在  而对于index.php脚本是以server模块下的root去拼接执行  拼接 [index.php] 使用前必须 变成 /index.php?$args
      location / {
        try_files $uri $uri/ /index.php;
      }

   alias 和 root 区别：

   location /requset_path/image/ {
      root /local_path/image/;
   }
   http://www.imooc.com/request_path/image/cat.png  =>地址  /local_path/image/request_path/image/cat.png

   location /requset_path/image/ {
      alias /local_path/image/;
   }
   http://www.imooc.com/request_path/image/cat.png  =>地址  /local_path/image/cat.png


   传递用户真实IP：
   set x_real_ip = $remote_addr(第一级代理ip设置)

   其他：
      413 request entity too large 上传附件太大 client_max_bady_size
      502 bad gateway 后端无响应
      504 gateway time-out 后端服务执行超时

##性能优化


    ab压力测试：
    ab -n 2000 -c 2 http://127.0.0.1/
    -n总次数
    -c并发数
    -k是否长连接

    返回数据说明：
    Server Software:        BWS/1.1                               #服务器版本号
    Server Hostname:        www.baidu.com

    Coplete requests:      2000
    Failed requests:        0
    Write errors:           0
    Total transferred:      1744000 bytes
    HTML transferred:       454000 bytes
    Requests per second:    43.24 [#/sec] (mean)                  #kps 重要数值
    Time per request:       46.256 [ms] (mean)
    Time per request:       23.128 [ms] (mean, across all concurrent requests)
    Transfer rate:          36.82 [Kbytes/sec] received


    #系统与nginx优化
        文件句柄
          linux\Unix 一切皆文件 文件句柄是一个索引
        设置方式
          1系统全局方式 2用户局部修改 3进程局部性修改
          1.和2.
          vim /etc/sevurity/limits.conf

            `
            *    soft nproc 65535
            *    hard nproc 65535
            *    soft nofile 65535
            *    hard nofile 65535
            root soft nofile 25535
            root hard nofile 25535
            `
          3.
            worker_rlimit_nofile 35535;


    #cup亲和与nginx优化
      cat /proc/cpuinfo|grep "physical id"|sort|uniq|wc -l     物理核心
      cat /proc/cpuinfo|grep "cpu cores"|uniq                  每核核心
      top                                                      查看进程

      配置：
      worker_processes 2;
      worker_cpu_affinity 01 10;
      worker_cpu_affinity auto;

      ps -eo pid,args,psr | grep [n]ginx



##安全篇
  1. 恶意行为
      爬虫和恶意抓取，资源盗用
      基础防盗链
      secure_link_module
      access_module-对后台基于Ip访问控制

  2. 攻击手段
      暴力破解密码
      文件传漏洞
      sql注入
