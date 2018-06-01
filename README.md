# 系统简介

* 后台管理。

***

# 代码框架结构说明：

> dbbase （自动生成的底层model，一个model对应一个数据表）

> api （RESTful模块）

>> modules （RESTful具体功能模块,分版本号）

> common （通用模块，自动生成数据库CRUD类，封装常用工具类）

>> models （中间层模型,前后台模型都继续中间层）

> backend （后台框架模板）

>> controllers （后台控制器）

>> models （后台模型）

>> views （后台视图）

> console （控制台框架模板）

>> controllers （控制台控制器）

>> models （控制台模型）

>> migrations （数据库迁移记录）

> environments （环境配置）

> frontend （前台框架模板）

>> controllers （前台控制器）

>> models （前台模型）

>> views （前台视图）

> tests （测试框架）

> vendor （YII 2.0框架库）

>　init （Linux初始化脚本）

>　init.bat （Windows初始化脚本）

>　yii （Linux下php执行脚本）

>  yii.bat （Windows下php执行脚本）

>　composer.json （COMPOSER资源文件）

>　composer.lock （操作锁）

>　composer.phar （PHP执行命令）

>　requirements.php （环境检验）

>　LICENSE.md  （授权协议）

>　README.md   （本说明）

***

## 注意事项

1. 在任何人参与项目之前，请记住，一定不能修改 environments 配置目录下的文件，

   *不要修改enviroments目录;不要修改enviroments目录;不要修改enviroments目录*

2. 然后，自己本机上搭建数据库dbname,  username: root; password: xxxx，初始化项目 `./init`,
   根据实际情况自行修改本地数据库连接配置文件(common/config/main-local.php),然后执行 `./yii migrate`就可以在本机上进行开发了,必须给对应模块下runtime可读写权限。

***

## 部署说明：

```

1、代码目录 root_path/travel
2、部署规则
   域名:端口 frontend.me:80    root /var/data/html/travel/frontend/web
   域名:端口 backend.me:80     root /var/data/html/travel/backend/web
   域名:端口 api.me:80         root /var/data/html/travel/api/web
3、dev、test环境分别在域名前面添加 dev. 和 test.
4、Nginx部署模型仅供参考(仅作参考)
		server {
	        listen       80;
	        server_name  frontend.travel.com;
			send_timeout 0;
	        location / {
	            root   root_path/travel/frontend/web;
	            index  index.html index.htm index.php;
				autoindex on;
				if (!-e $request_filename){
					rewrite "^(.*)$" /index.php?r=$1 last;
				}
	        }

	        location ~ \.php$ {
				root	/root_path/travel/frontend/web;
				fastcgi_pass	127.0.0.1:9000;
				fastcgi_index	index.php;
				fastcgi_param	SCRIPT_FILENAME  $document_root/$fastcgi_script_name;
				fastcgi_buffers 4 128k;
				include			fastcgi_params;
			}
	    }
	    server {
	        listen       80;
	        server_name  backend.travel.com;
			send_timeout 0;
	        location / {
	            root   root_path/travel/backend/web;
	            index  index.html index.htm index.php;
				autoindex on;
				if (!-e $request_filename){
					rewrite "^(.*)$" /index.php?r=$1 last;
				}
	        }

	        location ~ \.php$ {
				root	/root_path/travel/backend/web;
				fastcgi_pass	127.0.0.1:9000;
				fastcgi_index	index.php;
				fastcgi_param	SCRIPT_FILENAME  $document_root/$fastcgi_script_name;
				fastcgi_buffers 4 128k;
				include			fastcgi_params;
			}
	    }
5、Apache部署模型(仅作参考)
		<VirtualHost *:80>
		    DocumentRoot "/root_path/travel/frontend/web"
		    ServerName frontend.travel.com
		    ServerAlias
		  <Directory "/root_path/travel/frontend/web">
		      Options FollowSymLinks ExecCGI
		      AllowOverride All
		      Order allow,deny
		      Allow from all
		      Require all granted
		  </Directory>
		</VirtualHost>

		<VirtualHost *:80>
		    DocumentRoot "/root_path/travel/backend/web"
		    ServerName backend.travel.com
		    ServerAlias
		  <Directory "/root_path/travel/backend/web">
		      Options FollowSymLinks ExecCGI
		      AllowOverride All
		      Order allow,deny
		      Allow from all
		      Require all granted
		  </Directory>
		</VirtualHost>

		在对应的根目录下面(/root_path/travel/frontend|backend/web)增加Rewrite解析的.htaccess
		代码
		RewriteEngine on

		RewriteCond %{REQUEST_FILENAME} !-f
		RewriteCond %{REQUEST_FILENAME} !-d
		RewriteRule . index.php

```
