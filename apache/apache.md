<VirtualHost *:80>
    ServerName hz.com
    DocumentRoot "D:\www"                #不能是根目录         
    <Directory D:\www>   
     Options Indexes FollowSymLinks      #选项  没有index时显示文件夹 允许文件链接
             AllowOverride all           #文件重写 .htaccess起作用
             order deny,allow           #用于ip的访问许可
             allow from all              #允许所有ip
             Require all granted         #允许所有请求
    </Directory>
</VirtualHost>


<VirtualHost *:80>
         #ServerAdmin webmaster@localhost 
         #ServerName liemi004.netmi.com.cn
         #CustomLog   /var/log/apache2/site1.xxxx.com-access.log combined 
         DocumentRoot /var/www/html/draw/backend/web
         <Directory /var/www/html/draw/backend/web>
                 DirectoryIndex index.php index.html
                 # MultiViews 是匹配不到的路有会去匹配.*的文件  存在index.php 所以index路由不生效
                 #Options Indexes FollowSymLinks   
                 AllowOverride all
                 Order allow,deny 
                 allow from all 
         </Directory>
</VirtualHost>

#apache 的 ssl https配置

<IfModule mod_ssl.c>
        <VirtualHost _default_:443>
                ServerAdmin 492124454@qq.com
                ServerName  watermeter-admin.netmi.com.cn
                DocumentRoot /var/www/html/watermeter/frontend/web
                SetEnv APPLICATION_ENV "development"
                <Directory "/var/www/html/watermeter/frontend/web">
                                DirectoryIndex index.php index.html
                                AllowOverride All
                                Order allow,deny
                                Allow from all
                </Directory>
                ErrorLog ${APACHE_LOG_DIR}/error.log
                CustomLog ${APACHE_LOG_DIR}/access.log combined
                SSLEngine on
                SSLProtocol all -SSLv2 -SSLv3
                SSLCipherSuite HIGH:!RC4:!MD5:!aNULL:!eNULL:!NULL:!DH:!EDH:!EXP:+MEDIUM
                SSLHonorCipherOrder on
                SSLCertificateFile      /etc/apache2/sites-available/water-ssl/214786092010964.pem
                SSLCertificateKeyFile   /etc/apache2/sites-available/water-ssl/214786092010964.key
                SSLCertificateChainFile /etc/apache2/sites-available/water-ssl/chain.pem
        </VirtualHost>
</IfModule>


sudo a2enmod ssl #开启ssl模块


                