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

```text
# -*- mode: ruby -*-
# vi: set ft=ruby :

# All Vagrant configuration is done below. The "2" in Vagrant.configure
# configures the configuration version (we support older styles for
# backwards compatibility). Please don't change it unless you know what
# you're doing.
Vagrant.configure("2") do |config|
  # The most common configuration options are documented and commented below.
  # For a complete reference, please see the online documentation at
  # https://docs.vagrantup.com.

  # Every Vagrant development environment requires a box. You can search for
  # boxes at https://vagrantcloud.com/search.
  config.vm.box = "lnmp"

  # Disable automatic box update checking. If you disable this, then
  # boxes will only be checked for updates when the user runs
  # `vagrant box outdated`. This is not recommended.
  # config.vm.box_check_update = false

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine. In the example below,
  # accessing "localhost:8080" will access port 80 on the guest machine.
  # NOTE: This will enable public access to the opened port
  # config.vm.network "forwarded_port", guest: 80, host: 8080

  # Create a forwarded port mapping which allows access to a specific port
  # within the machine from a port on the host machine and only allow access
  # via 127.0.0.1 to disable public access
  # config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"

  # Create a private network, which allows host-only access to the machine
  # using a specific IP.
   config.vm.network "private_network", ip: "192.168.88.100"

  # Create a public network, which generally matched to bridged network.
  # Bridged networks make the machine appear as another physical device on
  # your network.
  # config.vm.network "public_network"

  # Share an additional folder to the guest VM. The first argument is
  # the path on the host to the actual folder. The second argument is
  # the path on the guest to mount the folder. And the optional third
  # argument is a set of non-required options.
  # config.vm.synced_folder "../data", "/vagrant_data"

  # Provider-specific configuration so you can fine-tune various
  # backing providers for Vagrant. These expose provider-specific options.
  # Example for VirtualBox:
  #
   config.vm.provider "virtualbox" do |vb|
  #   # Display the VirtualBox GUI when booting the machine
  #   vb.gui = true
  #
  #   # Customize the amount of memory on the VM:
     vb.memory = "8192"
     vb.cpus = 8
   end
  #
  # View the documentation for the provider you are using for more
  # information on available options.

  # Enable provisioning with a shell script. Additional provisioners such as
  # Puppet, Chef, Ansible, Salt, and Docker are also available. Please see the
  # documentation for more information about their specific syntax and use.
  # config.vm.provision "shell", inline: <<-SHELL
  #   apt-get update
  #   apt-get install -y apache2
  # SHELL
end

```

```text
Vagrant.configure("2") do |config|
  config.vm.box = "jinzhi/CentOS76-Lnmp"
  config.vm.box_version = "1.0.0"
  config.vm.network "private_network", ip: "192.168.88.100"
  config.vm.provider "virtualbox" do |vb|
     vb.memory = "8192"
     vb.cpus = 8
   end
end
```



## 错误信息

处理：
vagrant plugin expunge --reinstall

错误：
Error message given during initialization: Unable to resolve dependency: user requested 'vagrant-vbguest (= 0.17.2)'

处理：
vagrant plugin uninstall vagrant-vbguest
