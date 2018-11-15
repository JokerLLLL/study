# 下载git
 sudo yum install git
 
# 创建git该用户
 adduser git

# 加入授权密钥到
 /home/git/.ssh/authorized_keys
 搭建过gitlab 用 放到/var/opt/gitlab/.ssh/authorized_keys
 
#初始化仓库
 git init --bare sample.git
 
#更改权限
 chown -R git:git sample.git
 
#拉取
 git clone git@server:/srv/sample.git
 