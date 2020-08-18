
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
        
        
## ORM Object-Relational Mapper 

## Entity (字段 关系)   Repository(对象操作集合)  Proxy Class(代理类)


## dump doctrine
延迟加载代理总是包含Doctrine的EntityManager及其所有依赖项的实例。因此，var \ _dump（）可能会转储一个非常大的递归结构，这种结构无法呈现和读取。您必须使用 Doctrine\Common\Util\Debug::dump()将转储限制为人类可读的级别。此外，您应该知道将EntityManager转储到浏览器可能需要几分钟，而Debug :: dump（）方法只是忽略它在Proxy实例中出现的任何情况。

## entity 什么周期

 * @ORM\Entity(repositoryClass="WayBillRepository")
 * @ORM\HasLifecycleCallbacks()  启用什么生命周期
 
## entity 关联 要相互set 否知不能显示关联字段
    如果两个都是一起new 的 就要相互persist
    如果主的已经flush,子一定要set主的包含id的关系否知无效。
    
## symfony 

$em->beginTrancation();
$em->flush(); // 必须flush 否则无效
$em->commit();
    
    

