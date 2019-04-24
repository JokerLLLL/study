# apache重写文件配置
```apacheconfig

Options +FollowSymLinks
IndexIgnore /
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . index.php
#RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]

```
```apacheconfig
<IfModule mod_rewrite.c>
  RewriteEngine On
  RewriteBase /         ## 要加
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ app_dev.php/$1 [QSA,PT,L]
</IfModule>
```


# 前后台不分离配置选项
```apacheconfig

# prevent directory listings
#禁止目录访问 
Options -Indexes
# follow symbolic links
Options FollowSymlinks
RewriteEngine on

RewriteCond %{REQUEST_URI} ^/admin/$
RewriteRule ^(admin)/$ /$1 [R=301,L]
RewriteCond %{REQUEST_URI} ^/admin
RewriteRule ^admin(/.+)?$ /backend/web/$1 [L,PT]

RewriteCond %{REQUEST_URI} ^.*$
RewriteRule ^(.*)$ /frontend/web/$1



```




