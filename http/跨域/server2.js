const http = require('http')

    http.createServer(function (request,response) {
        console.log('requset come',request.url)

    response.writeHead(200,{
        'Access-Control-Allow-Origin':'*', //允许的地址
        'Access-Control-Allow-Headers':'X-Test-Cors', //允许的头
		'Access-Control-Allow-Methods':'POST, PUT ,DELETE', //允许的方法 区分大小写 要大写
		'Access-Control-Max-Age':'1000' //1000秒内 不用预先请求
    })
	response.end('hello world')
	
}).listen(8887)

console.log('server2 start...')
