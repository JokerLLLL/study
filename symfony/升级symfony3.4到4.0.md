## 开启debug配置（profiler配置）

framework:
    router:   { resource: "%kernel.project_dir%/app/config/routing_dev.yml" }
    session:
        handler_id: session.handler.pdo
    profiler:
        enabled: true
        only_exceptions: false

web_profiler:
    toolbar: true
    intercept_redirects: false
    
    
### 路由的 depracations

sensio_framework_extra.router.annotations

https://stackoverflow.com/questions/51171934/how-to-fix-symfony-3-4-route-and-method-deprecation
https://stackoverflow.com/questions/51208547/how-to-fix-sensio-bundle-frameworkextrabundle-configuration-route-is-depreca

后续：composer remove sensio/framework-extra-bundle ？？ 

## 其他depracation: 好像可以兼容4.x版本？

Doctrine\Common\Inflector\Inflector::classify
Twig_Extension_GlobalsInterface


### 依赖

symfony 4.1.x


需要移除包：
symfony/assetic-bundle （3.x版本后废弃）
symfony/webpack-encore-pack （4.0 版本后废弃）
建议使用：symfony/webpack-encore-bundle（兼容3.0 4.0 5.0）

### 处理 symfony/assetic-bundle 包 (可以不使用)

remove symfony/assetic-bundle 
require symfony/webpack-encore-bundle

### 4.1.x 版本

"symfony/symfony": "4.1.7",
"doctrine/doctrine-bundle": "1.11.2",
"sensio/framework-extra-bundle": "5.2.4",
"doctrine/doctrine-fixtures-bundle": "3.2.2",
---
指定monolog版本：
"monolog/monolog": "1.22.0"
新增：
doctrine/doctrine-migrations-bundle 3.0.1