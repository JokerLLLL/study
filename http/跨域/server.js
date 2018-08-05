const http = require('http')
const fs = require('fs')

http.createServer(function (request,response) {
	console.log('requset come',request.url)
	// response.end('hello world')
	const html = fs.readFileSync('test.html','utf8')
	response.writeHead(200,{
		// 'Content-Type':'text/plain',
		'Cache-Control':'max-age=20000000',
		'Set-Cookie':['id=123;max-age=100','name=abc;HttpOnly'], //设置cookie
	})
	if(request.url === '/script.js') {

        const etag = request.headers['if-none-match']
		console.log(etag)
        if(etag === '777') {
        	response.writeHead(304,{ //304 就是last-modified 未修改
        		'Content-type':'text/javascript',
        	})
			response.end('')
        }else{
            response.writeHead(200,{
                'Content-type':'text/javascript',
                'Cache-Control':'max-age=2000,no-cache',
                'Last-Modified':'123',
                'Etag':'777'
            })
            response.end('console.log("script load")')
        }

	}

	response.end(html)

}).listen(8888)

console.log('server start...')
