## php-redis扩展安装失败

```text
Error: php70w-common conflicts with php55w-common-5.5.38-1.w7.x86_64
 You could try using --skip-broken to work around the problem
 You could try running: rpm -Va --nofiles --nodigest

```
https://www.jianshu.com/p/25407616d686

直接卸载 php-common 然后重新安装
出错！！！

卸载 php-common 直接造成 php-fpm也被卸载 导致出错
后来改成源码包安装

php-redis 扩展编译安装
https://hooyes.net/p/php7-redis

