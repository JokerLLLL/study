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
 
 
 
# 快速将一个普通库变成裸库 #

原理 就是将 .git 变成 xxx.git 然后 git config --bool core.bare true

cd repo
mv .git ../repo.git # renaming just for clarity
cd ..
rm -fr repo
cd repo.git
git config --bool core.bare true




# 快速fork一个仓库

# https://www.jianshu.com/p/29775d91f536

新建一个远程空仓库 -> 拉取 -> 添加upstream地址 -> fetch upstream -> merge 到 origin -> push 到远程仓库

# git 多个remote仓库

https://segmentfault.com/q/1010000008366409
 
可以通过-all一次提交多个仓库
 
 配置远程仓库
 git remote add origin https://url
 
 再添加一个远程仓库
 git remote set-url --add origin https://url
 
 注意这里多次添加需要用
 git remote set-url --add
 不然会报错：
 fatal: remote origin already exists.
 或者改名
 git remote add otherOrigin https://url
 
 一次提交到所有远程仓库
 git push --all
 
 注意
 git pull 是 git pull (from) origin (to) master
 git push 是 git push (to) origin (from) master
 
 
 