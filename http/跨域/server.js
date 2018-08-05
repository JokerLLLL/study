const http = require('http')
const fs = require('fs')

http.createServer(function (request,response) {
	console.log('requset come',request.url)
	// response.end('hello world')
	const html = fs.readFileSync('test.html','utf8')
	// response.writeHead(200,{
	// 	'Content-Type':'text/plain'
	// })
	response.end(html)

}).listen(8888)

console.log('server start...')
