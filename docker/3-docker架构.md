## docker platform
docker提供了一个大包开发运行的app平台

## docker engine
后台进程 dockerd
Rest api server
CLI接口

## 镜像和容器

client 可以通过restAPI 连接 docker_host
    可以从registry拉起image ，从而生成containers
    
## 底层（linux的技术支持）
namespaces：做pid，net，ipc，mnt，uts的隔离
control group：做资源限制
union file systems：contain和image的分层


## docker Image
image 是 meta data 的集合。 （root filesystem）
base_image 包含了 rootfs 但共享了主机的 kernel内核。
基于base_image 进行添加文件，例如apache，nginx 打包成新的image
image 只读。
不同的image可以共享相同的一层。

通过 DockerFile 构建image。
从registry获取 docker。

创建自己的base_image




命令：
    docker image ls
        查看该服务的image
    docker pull ubuntu:14.04
        拉起image
    docker build -t jokerl/hello . 
        从当前DockerFile创建image
        DockerFile ：
        ```
            FROM scratch
            ADD hello /
            CMD ["./hello"]
        ```
    docker history 390582d83ead 
        查看image的历史变更记录
        
    docker commit jovial_noether joker/ubuntu:vim  
        将推出的 container commit 成一个新 image 与原来的image共享一些新的层级关系。
        
    
      
        
## docker container
通过image创建的
在image layer创建一个可读写的 contain layer
image负责存储，container负责运行。

命令：
    docker run -it ubuntu:latest 
        生成容器  -it 交互运行 -d 守护进程后台运行
    docker exec -it container_name /bin/sh
        进入容器中里面
       
    docker container ls -a
        查看运行的 和 -a 运行过的容器
    
    docker container rm container_id
    docker container rm $(docker container ls -f 'status=exited' -q)  
        exited 或 created 全部删除 
    
    docker image push jokerl/hello-world
    docker image pull jokerl/hello-world
    
    
    
## Dockerfile
```dockerfile
FROM scratch
FROM centos
LABEL maintainer='xxx'
LABEL metadat
RUN yum install -y vim  #执行命令并创建image layer  shell格式
CMD ['/bin/echo','hello'] #默认执行的命令和参数  excel格式 默认执行的 只一个 docker run 的后有参数则忽略
ENTRYPOINT ['/bin/echo']
WORKDIR /root  #改变当前目录
WORKDIR demo 
RUN pwd #/root/demo
ADD file /root/
ADD xx.gz /  #添加并解压
ENV MYSQ 5.6    #定义常量
VOLUME
EXPOSE   #暴露端口

```


##  docker registry
docker 搭建私有的 registry
https://hub.docker.com/_/registry
在一个公网ip上建立一个私有仓库
`docker run -d -p 5000:5000 --restart always --name registry registry:2`
`docker ps`
`docker build -t 127.0.0.1:5000/hello .`
然后在 `vim /etc/docker/daemon.json` 下面建立信赖的仓库源
```json
{
    "insecure-registries":[
      "127.0.0.1:5000"
    ]
}
```
然后 在 `vim /lib/systemd/system/docker.service` 
添加 `EnvironmentFile=/etc/docker/daemon.json`

`docker push 127.0.0.1:5000/hello:lasted`

registry api 查看列表 
`http://192.168.88.101:5000/v2/_catalog`


## 实战

docker run -d jokerl/hello
docker exec -it b3565c19961d /bin/bash          # 进入up的容器
docker exec -it b3565c19961d ip a   

docker stop b3565c19961d
docker start b3565c19961d

docker logs b3565c19961d             # 查看容器日志


# docker 镜像

设置镜像
https://blog.csdn.net/m0_37886429/article/details/80323149