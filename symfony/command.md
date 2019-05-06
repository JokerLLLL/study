
###更新数据库表 （过滤外键） 
  
######  php app/console ops:doctrine:schema:update --force

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



