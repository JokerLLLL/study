﻿#Yii2-admin安装
linux:
php composer.phar require mdmsoft/yii2-admin "~2.0"
php composer.phar update
windows:
composer require mdmsoft/yii2-admin "~2.0"
composer update

#yii2的composer更新
composer update yiisoft/yii2-composer

#composer自更新
composer self-update composer update

#版本更新
composer self-update --no-plugins

#版本回滚
composer self-update --rollback


#安装设置中国镜像源：
composer config -g repo.packagist composer https://packagist.phpcomposer.com

#查看详情
composer -v

#yii2 后台模板(-vvv 显示安装过程)
composer require dmstr/yii2-adminlte-asset "2.*" -vvv
没安装则安装admin(rbac 可视化管理)
composer require mdmsoft/yii2-admin "2.x-dev"

# PHP 7.1 进行开发，而我本地是 PHP 7.0, 于是悲剧发生了
删除 composer.lock 文件，重新执行 composer install，这样就能重新生成 composer.lock 文件了。

#依赖composer.lock文件 可以通过 composer update 进行更新

# 删除composer的包
composer remove response/name

# composer基础 

删除包 composer remove name/pack_name

### composer --dev 会生成dev环境

### Allowed memory size of bytes exhausted
php.ini 设置：
memory_limit = -1 //不设内存限制 
https://www.cnblogs.com/yehuisir/p/10434308.html
-- TODO 调查： composer 和 php composer.phar 的区别
https://www.jianshu.com/p/796eff32046c


### 更新指定版本：

方法1：
composer require hashids/hashids:2.0.0

方法2：
vim composer.json
"require": {
    "hashids/hashids": "3.0.0"
},
composer update hashids/hashids


## 版本号说明

指定版本号
（1）指定版本：比如"classnames": "2.2.5"，表示安装2.2.5的版本

（2）波浪号~+指定版本：比如 "babel-plugin-import": "~1.1.0",表示安装1.1.x的最新版本（不低于1.1.0），但是不安装1.2.x，也就是说安装时不改变大版本号和次要版本号

（1）^+指定版本：比如 "antd": "^3.1.4",，表示安装3.1.4及以上的版本，但是不安装4.0.0，也就是说安装时不改变大版本号。
