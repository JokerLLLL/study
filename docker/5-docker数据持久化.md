###  数据的数据

1. 基于本地的 Volume
2. 基于plugin的 Volume (NAS)

受管理的 data Volum ，由docker后台自动创建。
绑定的挂载的Volume，自己绑定。


### Data Volume

docker volume ls; 
docker volume inspect af594034cb08efad4a21dcd1fb8d4abd665b45e9a680e13abf00095817ff270d; //name
docker run -d -v volume_name:/var/temp/mysql --name mysql1 -e MYSQL_ROOT_PASSWORD="root" mysql

如果volume_name已经存在 就会使用这个数据。

### Bind Mounting

docker run -it -v /var/opt/:/var/opt/ --name ubuntu2 127.0.0.1:5000/ubuntu_vim
文件夹直接映射。当前目录:容器里面目录



