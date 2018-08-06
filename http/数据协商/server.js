const http = require('http')
const fs = require('fs')
const zlib = require('zlib')

http.createServer(function (request,response) {
	console.log('requset come',request.url)
	// response.end('hello world')


    // const html = fs.readFileSync('test.html','utf8')
    const html = fs.readFileSync('test.html')
        response.writeHead(200,{
                'Content-type':'text/html',
                'Content-Encoding':'gzip',

        })
            // response.end(html)
            response.end(zlib.gzipSync(html))


}).listen(8888)

console.log('server start...')
