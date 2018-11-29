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

