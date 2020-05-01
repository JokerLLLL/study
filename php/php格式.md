# &#x开头的是什么编码呢

https://www.zhihu.com/question/21390312

可以使用 html_entity_decode 函数将器转换成正常格式

# php 一些格式转换

urlencode()
urldecode()

将字符转换为 HTML 转义字符
htmlentities()
html_entity_decode()


# php 的 SimpleXMLElement 

正对这个类，如果请求头是 <?xml version="1.0"?>格式： 对应里中午会被转换成 html的 &#x5230;&#x4ED8;&#x8FD0;&#x8D39。

正对这个类，如果请求头是 <?xml version="1.0" encoding="UTF-8"?> 中文还是中文。