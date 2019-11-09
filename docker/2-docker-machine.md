## docker machine  是docker提供的服务器工具
可让您在虚拟主机上安装Docker Engine，并使用docker-machine命令管理主机。
使用docker-machine命令，您可以启动，检查，停止和重新启动托管主机，升级Docker客户端和守护程序，并配置Docker客户端以与主机通信。


## docker-machine 命令
 
docker-machine ls
    查看可连接的docker服务

docker-machine create --driver virtualbox default
    本地创建defualt的docker服务器

docker-machine env default
    获取default环境命令
    ```text
     export DOCKER_TLS_VERIFY="1"
     export DOCKER_HOST="tcp://172.16.62.130:2376"
     export DOCKER_CERT_PATH="/Users/<yourusername>/.docker/machine/machines/default"
     export DOCKER_MACHINE_NAME="default"
     # Run this command to configure your shell:
     # eval "$(docker-machine env default)"   //将default的路径映射到本地
    ```
docker-machine ssh default
    登录到default
    
docker-machine rm/stop/status/ssh..  default 


docker-machine env --unset
    ```
    eval "$(docker-machine env --unset)"
    ```
