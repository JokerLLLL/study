```json

    "autoload":{
    	"psr-4":{
    		"abc\\":"dirname/"
    	},
        "files":[
            "fuc/help.php"
        ]
    }
```

在composer.json 加上规则

abc\  命名空间就只向dirname目录下
func/help.php 就好被加载中


# 命令文件生成 自动生成加载类

composer dump-autoload  

 执行 composer dumpautoload -o

可自动化生成 autoload.php
[url](https://juejin.im/post/58b50896128fe10065e68010)
