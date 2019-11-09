# 什么是docker
    virtual machines ：
    infrastructure -> Host OS ->hypervisor -> Guset OS * N ->Bins/Libs ->APP;
    
    Docker(Containers): 
    infrastructure -> OS -> Docker Engine ->Bins/Libs * N ->APP;
    
    容器 共享了同一个 OS Kernel，是一个APP层面上的隔离，虚拟化是物理层面上的隔离。
    
    
# 容器的出现的契机
    1.虚拟机的所占比的资源过大，因为每个虚拟机都要一个完整的操作系统。
    2.开发运维各端之间的环境的依赖不统一的问题。实现DevOps
    
    
# docker 安装

window直接安装包；
window10 安装 docker 会导致 virtuaBox无法使用 
https://blog.csdn.net/zhang197093/article/details/78643708

centos安装：
     sudo yum remove docker \
                      docker-common \
                      docker-selinux \
                      docker-engine
     
     sudo yum install -y yum-utils \
       device-mapper-persistent-data \
       lvm2
       
     sudo yum-config-manager \
         --add-repo \
         https://download.docker.com/linux/centos/docker-ce.repo
         
     sudo yum install docker-ce
     
     sudo systemctl start docker
     
     
     -本地碰到错误
     docker: Error response from daemon: OCI runtime create failed: container_linux.go:344: starting container process caused "process_linux.go:293: copying bootstrap data to pipe caused \"write init-p: broken pipe\"": unknown.
     ERRO[0001] error waiting for container: context canceled
    查看版本  # cat /etc/os-release 
    查看内核：# uname -r   
             # 3.10.0-327.4.5.el7.x86_64
    注意：
    3.10 版本的内核，可能无法正常运行 18.06.x 及以上版本的 docker（解决方法：升级内核或者降低 docker 版本）
    
    问题解决
    https://blog.csdn.net/chenxing109/article/details/87792111 （重装旧版）
    https://forums.docker.com/t/centos7-docker-hello-world-fails/68941 （升级内核）
    https://www.tecmint.com/install-upgrade-kernel-version-in-centos-7/
    
    重新安装（简书）
    https://www.jianshu.com/p/7d9ff93bc89e
    如果 客户端也要卸载 重新安装版本
    # yum list installed | grep docker
       containerd.io.x86_64               1.2.4-3.1.el7              @docker-ce-stable
       docker-ce-cli.x86_64               1:18.09.3-3.el7            @docker-ce-stable
     # yum remove -y docker-ce-cli.x86_64 
    
     # yum install -y docker-ce-18.03.1.ce  （安装低版本）
   
     启动 +  docker run hello-world 成功;
   
    