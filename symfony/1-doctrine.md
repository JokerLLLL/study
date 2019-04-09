
## 使用mapping下面的所以类型注释

    use Doctrine\ORM\Mapping as ORM;

## 控制台实现方法

    实现字段的gets sets 方法 
    php app/console doctrine:generate:entities AppBundle/Entity/User

    内建数据库
    php app/console doctrine:database:create

    更新通过代码模型层 数据库  --force 强制执行
    php app/console doctrine:schema:update --force
    UCO内部命令  优化过滤外键
    php app/console ops:doctrine:schema:update --force


    
    启动服务
    php app/console server:run 0.0.0.0:8000
    
    更新样式
    php app/console assets:install --symlink
    
    

## 增删改查

        /* @var $group Groups */
        $group = $this->getDoctrine()->getRepository(Groups::class)->find(1);
        var_dump($group->getDescription());die;
        
        
