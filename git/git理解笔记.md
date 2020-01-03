#密钥创建
ssh-keygen

#版本回退 git reset --soft --mixed (default) --hard 

git reset --hard 版本号或Head^ 80f9292 
退回某个版本或上几个版本

git reset 版本号
版本库里版本号回滚，本地不撤销

git reflog
查看历史命令 (带上版本号) //查看历史版本号 用于查找版本号得更替


git checkout -- [filename]
把工作区回退到最后一次 git add 或 git commit 的状态

git reset head
把当前目录的 缓冲区里(git add 提交的) 的撤销

#文件删除
git status
查看是否有文件删除

git rm [filename]
提交到缓冲区(会删除工作区文件)

git checkout -- [filename]
如果想从版本库恢复

git commit -m 'delete file'
提交版本库

#分支
git checkout -b develop
新建分支develop并把head头指向develop [-b表示 branch]

git checkeout master
把head头指向master(切换分支)

git branch develop
创建develop分支

git branch [-a]
查看分支 [所有,外加远程仓库]

git branch -d develop
删除分支

git branch -D feature
强制删除分支 {feature有提交，但未进行合并，会进行数据丢失}

git push origin --delete develop_19448
远程分支删除

git merge develop
在master分支中执行，合并 {这种合并会是fast forward,会破会树形结构,或会产生recursive报警=此时效果和--no-ff参数一样}

git merge develop --no-ff -m 'meger master by jokerl'
--no-ff参数表示不使用fast forward提交，而进行了一次commit

git fetch --all && git reset --hard origin/develop


#隐藏工作区
git stash
需要切换其他分支 但工作区文件未并不想先提交 {对于新建文件 未追踪文件要先 git add 进行增加}

git stash list
查看备份

git stash apply
恢复工作区

git stash drop
丢弃备份

git stash pop
恢复+丢弃

#远程仓库 + 多人合作

/* 远程仓库 */
git remote rm origin //移除
git remote add origin git@xxx/xx.git //添加
git remote -v


# 更改远程仓库地址
git remote set-url origin http://192.168.100.235:9797/john/git_test.git

#创建远程的中心仓库
git init --bare

#得到远程默认仓库名，一般都为origin
git remote

git remote -v
查看具体可以push 和pull的源

git clone git@127.0.0.1:demo.git
git clone http://127.0.0.1/demo.git
git clone /c/demo/demo.git
克隆远程仓库

git checkout -b develop origin/develop
创建本地的develop并关联远程仓库的devel的分支

git branch --set-upstream-to=origin/develop
关联本地分支和远程分支

git push [origin] [master]
在哪个分支下使用 push 就推送那个分支 或向这样完整写明

git branch -vv

//查看本地分支 和远程分支关系 和修改分支关系
① 进入当前项目根目录的’.git’文件夹(请自行设置显示隐藏文件)。打开config文件（注意不要用window记事本打开）。
② [remote "origin"]这一项是修改对应远程Git仓库地址。
③ [branch "master"]这一项是修改本地分支‘master’的远程追踪关系分支，直接修改merge = refs/heads/master为merge = refs/heads/dev
④ 再次通过命令行查看状态就可以发现你的远程分支已经改掉。
⑤ 可能出现的问题补充： 
没有[branch "master"]这一项怎么办？ 
如果是新项目，没有git pull或git clone，就不会与远程分支建立关系，或者也可以自己添加这一项，但不建议。



## git多次分支整合一个分支 -i 交互 

    git rebase -i develop
    将 pick 改成 s
    重设提交信息
    
    git rebase --abort
    重设提交事务


## git 获取最后一次id
    git rev-parse HEAD
    git config --global alias.last "rev-parse HEAD"
    
## Git cherry-pick  38361a55 
    https://www.jianshu.com/p/08c3f1804b36
    将其他分支的版本信息裁切到这个分支上并提交



## Git 文件权限控制

    查看文件权限 git ls-tree HEAD

    原文：https://blog.csdn.net/taiyangdao/article/details/78398383 
    git add --chmod=+x myFile
    git update-index --chmod=+x myFile    
    git add --chmod=-x myFilegit update-index --chmod=-x myFile
    

#标签功能
git tag
查看所以标签

git tag v1.0 [commit_id]
添加当前标签或某个提交点标签

git show v1.0
查看标签节点变得信息

git tag -a v2.0 -m '版本2.0' [commit_id]
添加标签和备注

git push origin v1.0
推送标签

git push origin --tags
推送所有标签

git tag -d v1.0
删除标签

git push origin :refs/tags/v1.0
删除远程标签

#服务器部署
git 挂钩功能(Hooks)
在--bare 仓库中 进入hooks 加入post-receive的shell脚本
在客户段提交时候 会自动更新到线上服务器

注：权限！权限！权限！
    1.post-receive 要有可执行权限
    2.无论是git仓库，还好git要部署的代码都要 chmod -R git:git 
    3.git在/etc/passwd 的bash不要动 不用改成git-bash(未改成git-bash可忽略)
    4.shell脚本里 git命令都要使用 env -i 去执行


post-receive例子 eg:
```sh
#!/bin/sh
IS_BARE=$(git rev-parse --is-bare-repository)
if [ -z "$IS_BARE" ]; then
	echo >&2 "fatal: post-receive: IS_NOT_BARE"
	exit 1
fi
SUBJECT=$(git log -1 --pretty=format:"%s")
IS_PULL=$(echo "$SUBJECT" | grep "\[deploy\]")
if [ -z "$IS_PULL" ]; then
	echo >&2 "tips: post-receive: IS_NOT_PULL"
	exit 1
fi
DEPLOY_DIR=/home/icyleaf/php/icyleaf/
if [ ! -d $DEPLOY_DIR ] ; then
	echo >&2 "fatal: post-receive: DEPLOY_DIR_NOT_EXIST: \"$DEPLOY_DIR\""
	exit 1
fi
cd $DEPLOY_DIR
env -i git pull
```

```sh
#!/bin/bash
cd /path/test
env -i git checkout develop
env -i git pull origin develop
```


### 命令查询表

初始化一个仓库      git init

查看仓库状态        git status

预提交仓库          git add .

移除缓存            git rm -cached

正式更新提交        git commit -m 'first commit'

查看所有commit记录  git log

查看分支所在位置    git branch

新建分支            git branch test1

切换分支            git checkout test1

                   git checkout v1.0

                   git checkout 8739df5828a9a4c2ef3de8fa83880f73e0f920d2   [commit_id ]

                   git checkout abc  [将未add的文件进行还原]

新建切换           git checkout -b test2

合并分支到master   git merge  test1

删除分支           git branch -d test1

                   git branch -D test1  [强制删除]

标签历史           git tag

新建标签           git tag v1.0

SSH链接远程仓库    ssh-keygen -t rsa
生成SSH key  生成id_rsa和id_rsa.pub        
Linux/Mac 系统 在 ~/.ssh 下，win系统在 /c/Documents and Settings/username/.ssh
然后将id_rsa.pub 的内容添加到 GitHub

Push & Pull

克隆远程仓库      git clone git@github.com:JokerLLLL/gitTest.git

本地执行 add commit

更新远程仓库       git push origin master  

关联本地和远程仓库 git remote add origin    [origin]为仓库设置的名称

设置全局姓名邮箱   git config --global user.name "jokerl"

                   git config --global user.email "145645529@qq.com"

别名配置alias     git config --global alias.co checkout #别名

                  git config --global alias.ci commit

                  git config --global alias.st status

                  git config --global alias.br branch

                  git config --global alias.psm 'push origin master'

                  git config --global alias.plm 'pull origin master'

   #git lg        git config --global alias.lg "log --graph --pretty=format:'%Cred%h%Creset -%C(yellow)%d%Creset %s %Cgreen(%cr) %C(bold blue)<%an>%Creset' --abbrev-commit --date=relative"


其他配置          git config --global core.editor "vim"

                  git config --global color.ui true

                  git config --global core.quotepath false #设置显示中文文件名

~/.gitconfig 文件 git config -l

比较命令diff(比较add之前的改动）

                  git diff


#本地修改不提交到远程仓库
git update-index --assume-unchanged [filename]  
#取消本地忽略
git update-index --no-assume-unchanged [filenae]
#查看本地仓库哪些文件被加入忽略列表
git ls-files -v

# windows 别名修改
/etc/profile.d/aliases.sh