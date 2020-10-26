### 说明
symfony 脚本命名：以Command结尾 并继承 ContainerAwareCommand

###更新数据库表 （过滤外键） 
  
######  php app/console ops:doctrine:schema:update --force

创建entity set 和 get 

php app/console doctrine:generate:entities Uco\\BeehiveBundle\\Entity\\PreBoxSpotTask

###测试环境创建 

php app/console doctrine:schema:create --em wmsIncoming --env test
php app/console doctrine:schema:create --em orderIncoming --env test
php app/console doctrine:schema:create --env test
php app/console doctrine:schema:create --em ops --env test
php app/console doctrine:schema:create --em counter --env test


###店铺环境修改

php app/console config:dump_entities --flavor 3p
php app/console config:dump_entities --flavor yy
php app/console config:dump_entities --flavor uco


## uco 单元测试命令

-- 环境
./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-master-2847 -o chenchaoliang@app20.uco.com -f stress start

use_src.py 的配置： srcDir = '/home/songjiaqi/oms'	 
FLAVOR=prod python3.6 build/my_init.d/use_src.py	
FLAVOR=3p python3.6 build/my_init.d/use_src.py                3p环境	
FLAVOR=yy python3.6 build/my_init.d/use_src.py                 yy环境
./run.sh -n koms console ops:doctrine:schema:update --env dev --force  --dump-sql  		
./run.sh -n  koms console cache:clear --env dev
./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-master-3120 -d -p 10002 -q -n koms start 运行命令


## 进入container、执行命令
./run.sh -n  kikioms shell
./run.sh -n  kikioms console wms:shipment:download 950

## busybee docker-image
docker-reg.uco.com/uco/busybee:jenkins-busybee-master-112

./run.sh -i docker-reg.uco.com/uco/busybee:jenkins-busybee-master-112 -d -p 999 -q -n bsb start 

alias 'start_oms'='docker start oms-cv3 oms-redis oms-mq oms' //开启
alias 'start_oms'='docker start oms oms-cv3 oms-redis oms-mq' //关闭

-- 测试 unit test

-- run.sh 中 src_static_analyze 注释掉可跳过语法检查

./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-master-3298 -d unittest src/Uco/OmsBundle/Tests/Service/ShunfengServiceTest.php

./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-master-3298 -d unittest --filter testConfirmCancelShipmentWithPendingReverseNotMerge 

## 线上环境 开启/关闭 

./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-user3-365 -o chenchaoliang@app13.uco.com -R ccl-test@dby1.uco.com:4006,asdaASD@#323,uco -f elc

./run.sh -i docker-reg.uco.com/uco/oms:jenkins-oms-user3-365 -o chenchaoliang@app13.uco.com -R ccl-test@dby1.uco.com:4006,asdaASD@#323,uco -n app13-oms-elc-2v19hh stop

## 共享说明

/mnt/oms-3p-share/ 所有app和对应的docker的目录共享
/mnt/oms-3p/ 本机app和本机docker共享的目录。

# 缓存清理
php bin/console cache:clear --env=prod --no-debug

# bundle 创建
php bin/console generate:bundle --namespace=Acme/TestBundle



### command 配置信息

->addArgument('orderIds',  InputArgument::REQUIRED, "oms单号用英文,逗号隔开")  // $input->getArguments('orderIds'); 字符串 // ops:command 123  或 orderIds=123

///或用 getArguments() 获取全部

->addOption('index', null, InputOption::VALUE_OPTIONAL, 'index') //  $index = $input->getOption('index'); // ops:command --index 3 

命令通过类来定义，这些类必须存放在你的bundle (如 AppBundle\Command) 的 Command 命名空间下。类名必须是 Command 后缀。

继承 ContainerAwareCommand 获取容器。

-- 测试命令
http://www.symfonychina.com/doc/current/console.html

