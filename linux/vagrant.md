#地址
> https://www.jianshu.com/p/d3398b2e3f4f  简书
> https://zhuanlan.zhihu.com/p/34684496   知乎
#下载
> https://www.virtualbox.org/wiki/Downloads      virtualBox
> https://www.vagrantup.com/docs/cli/cloud.html   vagrant
> http://www.vagrantbox.es/                       vagrant box 源
>https://app.vagrantup.com/jinzhi/boxes/CentOS76-Lnmp

# 添加镜像
vagrant box add [名称] [源路径]

# 部署
在目录某个目录下面进行 (此后这个目录被映射到虚拟机的 /vagrant 目录下面从而共享目录)
vagrant init  # 初始化
vagrant up  # 启动虚拟机
vagrant halt  # 关闭虚拟机
vagrant reload  # 重启虚拟机
vagrant ssh  # SSH 至虚拟机
vagrant vstatus  # 查看虚拟机运行状态
vagrant destroy  # 销毁当前虚拟机

## 备份box系统
vagrant package --output backup.box

## 注意事项
使用 Apache/Nginx 时会出现诸如图片修改后但页面刷新仍然是旧文件的情况，是由于静态文件缓存造成的。需要对虚拟机里的 Apache/Nginx 配置文件进行修改：
# Apache 配置（httpd.conf 或者 apache.conf）添加：
EnableSendfile off

# Nginx 配置（nginx.conf）添加：
sendfile off;



## 修改 访问方式为 host-only (配置单独IP)
Vagrant 默认是使用端口映射方式将虚拟机的端口映射本地从而实现类似 http://localhost:80 这种访问方式，这种方式比较麻烦，新开和修改端口的时候都得编辑。相比较而言，host-only 模式显得方便多了。打开 Vagrantfile，将下面这行的注释去掉（移除 #）并保存：
config.vm.network :private_network, ip: "192.168.20.14"



## 错误信息

处理：
vagrant plugin expunge --reinstall

错误：
Error message given during initialization: Unable to resolve dependency: user requested 'vagrant-vbguest (= 0.17.2)'

处理：
vagrant plugin uninstall vagrant-vbguest
