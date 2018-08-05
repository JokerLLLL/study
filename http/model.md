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
        
        
