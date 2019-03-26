## 什么是yum

YUM是“Yellow dog Updater, Modified”的缩写，是一个软件包管理器，YUM从指定的地方（相关网站的rpm包地址或本地的rpm路径）自动下载RPM包并且安装，能够很好的解决依赖关系问题。

##  epel maintained by Fedora repo. 
    使用epel仓库
    
```text
    RHEL/CentOS 7 64 Bit
    # rpm -ivh http://dl.fedoraproject.org/pub/epel/beta/7/x86_64/epel-release-7-0.2.noarch.rpm
    
    RHEL/CentOS 6 32-Bit 
    # rpm -ivh  http://download.fedoraproject.org/pub/epel/6/i386/epel-release-6-8.noarch.rpm

    RHEL/CentOS 6 64-Bit 
    # rpm -ivh  http://download.fedoraproject.org/pub/epel/6/x86_64/epel-release-6-8.noarch.rpm

    RHEL/CentOS 5 32-64 Bit
    #  rpm -ivh http://download.fedoraproject.org/pub/epel/5/i386/epel-release-5-4.noarch.rpm

    RHEL/CentOS 5 64-Bit
    # rpm -ivh http://download.fedoraproject.org/pub/epel/5/x86_64/epel-release-5-4.noarch.rpm
    
    在 /etc/yum.repos.d/ 形成了仓库
    需要修改/etc/yum.repos.d/epel.repo，把enabled=0改成enabled=1即可。
    # 卸载仓库
    rpm -e epel 
```

##  yum repolist 查看仓库包
##  yum --enablerepo=epel info zabbix       查看使用可以使用epel安装
##  yum --enablerepo=epel install zabbix    安装


## yum list |wc -l
## yum list|



## rpm
rpm -i  xxx.rpm 安装
-ivh
-e 卸载



