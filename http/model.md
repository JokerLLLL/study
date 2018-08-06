###网络传输5层模型：
    1物理层
    2数据链路层
    3网络层
    4传输层 TCP/IP   UDP/IP
    5应用层

###TCP协议
    向用户提供end-to-end服务
    传输层向高层屏蔽了下层数据通信细节。（一个http传输量大 分片传输看不到）

###HTTP历史
    1. /0.9 只有get 没有HEADER等描述的信息
       发送完就关闭TCP连接
    2. /1.0 增加更多命令 status code  header 多字符集 权限 缓存
    3. /1.1 持久连接
    4. /2.0 二级制传输 多个请求不在按顺序来 头信息进行压缩 推送功能
  
    
###HTTP三次握手
    
###HTTP报文
    GET /test/hi-there.txt HTTP/1.0
    Accept: text/*
    Accept-Language: en,fr
    
    HTTP/1.0 200 ok
    Content-type:text/plain   //表示不解析html
    Content-length: 19
    Hi!This is Message!
    
    
###HTTP跨域问题

    CORS 预请求
        跨域默认允许的方法：GET HEAD POST
        允许的请求头：Content-type:text/plain   multipart/form-data  application/x-www-form-urlencode
        请求头的限制：
        都需要OPTION 进行预先请求
        
###缓存
    Cache-Control :
    可缓存性：
      public     
      private  
      no-cache  //需要服务器验证才能使用缓存 服务器判断以下内容
          If-Modified-Since:123
          If-None-Match:777
      
    max-age = 200 //前端缓存200s  
    s-maxage = 200 
    max-stale = 200
    
    must-revalidate
    proxy-revalidate
    
    no-store //本地和代理都不能使用缓存
    no-transform  //不被压缩
    
    资源验证：
    Last-Modified:  //对比上次修改时间是否过期
    Etag:          //签名验证 是否过期
    
    
    Set-Cookie设置 键值对的形式设置
      max-age expire 设置过期时间
      Secure https 发送
      HttpOnly 无法通过 document.cookie 访问
      domain=test.com 设置一级域名在二级域名下cookie公用  //无法跨域设置
      
      eg：
      Set-Cookie:['id=1;max-age=200','name=jokerl;HttpOnly','all=xxx;domain=test.com']
      
      
      
####TCP长连接复用
   浏览器有6个tcp连接的限制
   
   
   
###数据协商
    --请求头:
      Accept:
      Accept-Encoding:
      Accept_language:
      User-Agent:
      
    --响应头
      Content-Tpye:
      Content-Encoding:
      Content-Language:
      
      eg：
      Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8
      Accept-Encoding:gzip, deflate, br
      Accept-Language:zh-CN,zh;q=0.9
      Cache-Control:no-cache
      Connection:keep-alive
      Cookie:id=123; name=abc
      Host:127.0.0.1:8888
      Pragma:no-cache
      Upgrade-Insecure-Requests:1
      User-Agent:Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/63.0.3239.108 Safari/537.3
      
      
      
      --表单提交
        Content-Type:application/x-www-form-urlencoded
        内容放在
        Form Data
        
      Content-Type:multipart/form-data
      eg：
      Content-Type:multipart/form-data; boundary=----WebKitFormBoundarytA3BheRC64ba2lqT
      Request Payload
      ------WebKitFormBoundaryRorFTOoXQosssxMF
      Content-Disposition: form-data; name="id"
      
      ------WebKitFormBoundaryRorFTOoXQosssxMF //字串
      Content-Disposition: form-data; name="password"
      
      ------WebKitFormBoundaryRorFTOoXQosssxMF  //文件
      Content-Disposition: form-data; name="file"; filename="croped-image.jpg"
      Content-Type: image/jpeg
      
      ------WebKitFormBoundaryRorFTOoXQosssxMF--
      
      
      
###资源重定向 / => /new 
    302 重定向(每次访问 / 都先请求服务器)
    Location:/new
    
    301 永久重定向(第二次请求 / 时，浏览器就直接重定向了)
    Location:/new
    

### Content-Security-Policy

    