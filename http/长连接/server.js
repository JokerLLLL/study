const http = require('http')
const fs = require('fs')

http.createServer(function (request,response) {
	console.log('requset come',request.url)
	// response.end('hello world')

	if(request.url === '/') {
        const html = fs.readFileSync('test.html','utf8')
        response.writeHead(200,{
                'Content-type':'text/html',
                'Cache-Control':'max-age=2000,no-cache',
                'Last-Modified':'123',
                'Etag':'777',
                'Set-Cookie':['id=123;max-age=100','name=abc;HttpOnly'], //设置cookie
                'Link':'</test.jpg>;as=image;rel=preload',  //http2.0 的主动推送
        })
            response.end(html)
	}else{
        const img = fs.readFileSync('test.jpg')
        response.writeHead(200,{
            'Content-type':'image/jpg',
            // 'Cache-Control':'max-age=2000',
        })
        response.end(img)
	}

}).listen(8888)

console.log('server start...')
